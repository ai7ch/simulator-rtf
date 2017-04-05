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


		/******************************
		*** Recuperation des champs ***
		******************************/
		/*Assignier un valeur par*/
		$coef_de_localisation = !empty($posted_fields['coef_de_localisation']) ? $posted_fields['coef_de_localisation'] : '1.0';
		$coef_de_neutralisation = $posted_fields['coef_de_neutralisation'];
		$les_taux = $posted_fields['taux'];
		$surfaces = $posted_fields['surfaces'];
		$proprietes = $posted_fields['proprietes']; //need to be optimized this, it isn't the best way!

		/******************************
		***        Variables        ***
		******************************/
		/*Enregistre les valeur locative planchonee pour la base de cotisation de l'annee courante (current_year) */
		$vl_planchonee_base_cotisation = [];
		/*Base de cotisation de l'avis, renseigné par l'utilisateur*/
		$base_cotisation_avis = "";
		/*Récupération des noms des colones*/
		$noms_colones = array_keys($coef_de_neutralisation);

		/**
		* Calcule de valeur locative pour l'annee courante
		*/
		foreach ($proprietes as $value) {
			$base_cotisation_avis = $value['base']['commune']; //base_cotisation shouldn't be provided this way
			$valeur_locative = $field->get_vl((int)$base_cotisation_avis);
		}
		
		
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
			<td><?=!empty($base_cotisation_avis) ? $base_cotisation_avis : 0 ; ?></td>
			<td><?=!empty($base_cotisation_avis) ? $base_cotisation_avis : 0 ; ?></td>
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
					$surface_ponderee = $field->get_surfaces_ponderees($surfaces);
					echo $surface_ponderee;
				?></td>
		</tr>
		<tr>
			<td>Tarif de la grille</td>
			<td><?=$tarif="255.90"?></td>
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
			<?php foreach ($noms_colones as $noms): ?>
				<td>
					<?=ucwords($noms)?>
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
				<td><?= number_format(round($column_values),2,',',' ') ?></td>
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
			<?php foreach ($noms_colones as $noms): ?>
				<td>
					<?=ucwords($noms)?>
				</td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>VL neutraliée planchonée</td>
			<?php 
				foreach ($vl_revisee_neutralisee as $column_titles => $column_values): 
					$vl_planchonee = $field->get_vl_planchonee($column_values,$valeur_locative);
					$vl_planchonee_base_cotisation[$column_titles] = $vl_planchonee;?>
				<td><?= number_format(round($vl_planchonee),2,',',' ') ?></td>
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
			<?php foreach ($noms_colones as $noms): ?>
				<td>
					<?=ucwords($noms)?>
				</td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Bâti</td>
			<?php 
				foreach ($vl_planchonee_base_cotisation as $valeur): 
					$base_cotisation_annee = $field->get_base_cotisation($valeur);?>
				<td><?= str_replace('','',number_format(round($base_cotisation_annee),2,',',' ')) ?></td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Total</td>
			<?php 
				foreach ($vl_planchonee_base_cotisation as $valeur): 
					$base_cotisation_annee = $field->get_base_cotisation($valeur);?>
				<td><?= str_replace('','',number_format(round($base_cotisation_annee),2,'',' ')) ?></td>
			<?php endforeach ?>
		</tr>
	</table>
	
	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="9">Taux d'imposation</th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($les_taux as $noms => $column_values): ?>
				<td>
					<?=ucwords($noms)?>
				</td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Bâti</td>
			<?php 
				foreach ($les_taux as $valeur):?>
				<td><?= !empty($valeur) ? $valeur : 0 ?></td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Total</td>
			<?php 
				foreach ($les_taux as $valeur):?>
				<td><?= !empty($valeur) ? $valeur : 0 ?></td>
			<?php endforeach ?>
		</tr>
	</table>
	
	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="10">Cotisation <?=get_current_year()?> en system actuel (sans frais de gestion)</th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($les_taux as $noms => $column_values): ?>
				<td>
					<?=ucwords($noms)?>
				</td>
			<?php endforeach ?>
			<td>
				Total
			</td>
		</tr>
		<tr>
			<td>Bâti</td>
			<?php 
				foreach ($les_taux as $taux):
					$cotisation_annee_sans_frais = $field->get_cotisation_annee((float)$base_cotisation_avis, (float)$taux);?>
				<td><?= number_format(round($cotisation_annee_sans_frais),2,',',' ') ?></td>
			<?php endforeach ?>
			<td>
				{Total des cotisation 2017}
			</td>
		</tr>
		<tr>
			<td>Total</td>
			<?php 
				foreach ($les_taux as $taux):
					$cotisation_annee_sans_frais = $field->get_cotisation_annee((float)$base_cotisation_avis, (float)$taux);?>
				<td><?= number_format(round($cotisation_annee_sans_frais),2,',',' ') ?></td>
			<?php endforeach ?>
			<td>
				{Total des tout tatal cotisation 2017}
			</td>
		</tr>
	</table>
	
	<br><br>

	
	
	<?php
	echo "<pre>";

	echo '<br>';

	echo '<br>';
	print_r($les_taux);
	//endif;
	echo "</pre>";