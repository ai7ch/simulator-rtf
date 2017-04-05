<?php 
	require_once 'fields.php';
	require_once 'functions.php';
/**
* Handles the data submitted by the form
*/

	$field = new Fields();


	

	//if(isset($_POST['submit'])):
		$posted_fields = $_GET;
		$patterns = [
			'taux' => '^taux',
			//'proprietes' => '[-]\d',
			'entreprise-avis' => '[-]ent$',
			'entreprise-cerfa' => '[-]ent[-]cerfa',
			'utilisateur' => '[-]u',
			'surfaces' => '(p|pk)\d',
		];

		/*Recuperer la coef de localisation en cas ou est different de value { 1 }*/
		$coef_de_localisation = !empty($posted_fields['coef_de_localisation']) ? $posted_fields['coef_de_localisation'] : '1.0';

		/*Recuperer la coef de neutralisation*/
		$coef_de_neutralisation = $posted_fields['coef_de_neutralisation'];
		
		/*Recuperer propriete*/
		$proprietes = $posted_fields['proprietes'];
		foreach ($proprietes as $value) {
			$base_cotisation_annee = $value['base']['commune'];
			$valeur_locative = $field->get_vl((int)$base_cotisation_annee);
		}

		/*Recuperer la list de(s) surface(s)*/
		$get_surfaces = $posted_fields['surfaces'];
		
		/*Valeur des champs de base de cotisation de l'annee actuel (current_year) */
		$vl_planchonee_base_cotisation = [];
	?>

	<table cellspacing="0" cellpadding="10" border="1" width="350">
		<tr>
			<th colspan="3" align="center">
				Valeur locative 1970
			</th>
		</tr>
		<tr>
			<td></td>
			<td>Bâti</td>
			<td>Total</td>
		</tr>
		<tr>
			<td>Base de cotisation <?=get_current_year()-1 ?></td>
			<td><?=$base_cotisation_annee; ?></td>
			<td><?=$base_cotisation_annee; ?></td>
		</tr>
		<tr>
			<td>Valeurs Locatives <?=get_current_year()-1 ?></td>
			<td><?=$valeur_locative ?></td>
			<td><?=$valeur_locative ?></td>
		</tr>
	</table>

	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="350">
		<tr>
			<th colspan="2">Valeur locative révisée brute</th>
		</tr>
		<tr>
			<td>Surfaces pondérèes</td>
			<td><?php 
					$surface_ponderee = $field->get_surfaces_ponderees($get_surfaces);
					echo $surface_ponderee;
				?></td>
		</tr>
		<tr>
			<td>Tarif de la grille</td>
			<td><?=$tarif="132.30"?></td>
		</tr>
		<tr>
			<td>Coefficient de localisation</td>
			<td><?=$coef_de_localisation ?></td>
		</tr>
		<tr>
			<td>VL révisée brute</td>
			<td><?php 
					$vl_revisee_brute = $field->get_vl_revisee_brute($surface_ponderee, $tarif, $coef_de_localisation);
					$vl_revisee_brute_rounded = round($vl_revisee_brute);
					$vl_revisee_brute_rounded = str_replace('00','',number_format($vl_revisee_brute_rounded,2,' ',' '));
					echo $vl_revisee_brute_rounded;
				?>
			</td>
		</tr>
	</table>

	<br><br>
	
	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="7">Valeur locative révisée neutralisée</th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($coef_de_neutralisation as $column_titles => $column_values): ?>
				<td>
					<?=ucwords($column_titles)?>
				</td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Coefficient de neutralisation</td>
			<?php foreach ($coef_de_neutralisation as $column_values): ?>
				<td><?=$column_values ?></td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>VL Révisée neutraliée</td>
			<?php 
				$vl_revisee_neutralisee = $field->get_vl_revisee_neutralisee($vl_revisee_brute,$coef_de_neutralisation);
				foreach ($vl_revisee_neutralisee as $column_values): ?>
				<td><?= str_replace('00','',number_format(round($column_values),2,'',' ')) ?></td>
			<?php endforeach ?>
		</tr>
	</table>
	
	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="7">Valeur locative planchonée</th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($coef_de_neutralisation as $column_titles => $column_values): ?>
				<td>
					<?=ucwords($column_titles)?>
				</td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>VL neutraliée planchonée</td>
			<?php 
				foreach ($vl_revisee_neutralisee as $column_titles => $column_values): 
					$vl_planchonee = $field->get_vl_planchonee($column_values,$valeur_locative);
					$vl_planchonee_base_cotisation[$column_titles] = $vl_planchonee;?>
				<td><?= str_replace('00','',number_format(round($vl_planchonee),2,'',' ')) ?></td>
			<?php endforeach ?>
		</tr>
	</table>
	
	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="7">Base Cotisation <?=get_current_year()?></th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($coef_de_neutralisation as $column_titles => $column_values): ?>
				<td>
					<?=ucwords($column_titles)?>
				</td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Bâti</td>
			<?php 
				foreach ($vl_planchonee_base_cotisation as $valeur): 
					$base_cotisation_annee = $field->get_base_cotisation($valeur);?>
				<td><?= str_replace('00','',number_format(round($base_cotisation_annee),2,'',' ')) ?></td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Total</td>
			<?php 
				foreach ($vl_planchonee_base_cotisation as $valeur): 
					$base_cotisation_annee = $field->get_base_cotisation($valeur);?>
				<td><?= str_replace('00','',number_format(round($base_cotisation_annee),2,'',' ')) ?></td>
			<?php endforeach ?>
		</tr>
	</table>

	<?php
	echo "<pre>";

	echo '<br>';

	echo '<br>';
	print_r($posted_fields);
	//endif;
	echo "</pre>";