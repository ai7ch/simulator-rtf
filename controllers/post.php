<?php 
	require_once 'fields.php';
	require_once 'functions.php';
/**
* Handles the data submitted by the form
*/

	$field = new Fields();


	

	if(isset($_POST['submit'])):
		$posted_fields = $_POST;
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
		$coef_de_localisation = !empty($posted_fields['coef_de_localisation']) ? $posted_fields['coef_de_localisation'] : '1.0';
		$coef_de_neutralisation = $posted_fields['coef_de_neutralisation'];
		$les_taux = $posted_fields['taux'];
		$surfaces = $posted_fields['surfaces'];
		$proprietes = $posted_fields['proprietes']; //this need to be optimized, it isn't the best way

		/******************************
		***        Variables        ***
		******************************/
		/*les champs qui ne sont pas prise dans la calcules*/
		$champs_a_exclure = [
			'gemapi'=>0,
		];
		/*enregistre les valeurs locative planchonee POUR la base de cotisation de l'annee courante (current_year) */
		$vl_planchonee_base_cotisation = [];
		/*enregistre la base de cotisation de l'avis, renseigné par l'utilisateur (current_year - 1)*/
		$base_cotisation_avis = "";
		/*enregistre la valeur locative, de l'annee de l'avis (current_year - 1)*/
		$valeur_locative = "";
		/*enregistre les valeurs de cotisation de l'annee courante (current_year) */
		$base_cotisation_annee = [];

		/**
		* Calcules le valeur locative POUR l'annee courante (current_year -1)
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
			<td>Base de cotisation <?=get_current_year() - 1 ?></td>
			<td><?=!empty($base_cotisation_avis) ? $base_cotisation_avis : 0 ; ?></td>
			<td><?=!empty($base_cotisation_avis) ? $base_cotisation_avis : 0 ; ?></td>
		</tr>
		<tr>
			<td>Valeurs Locatives <?=get_current_year() - 1 ?></td>
			<td><?=$valeur_locative ?></td>
			<td><?=$valeur_locative ?></td>
		</tr>
	</table> <!-- Valeur locative 1970 -->

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
	</table> <!-- Valeur locative révisée brute -->

	<br><br>
	
	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="9">Valeur locative révisée neutralisée</th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($les_taux as $noms => $valeur):
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;}?>
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
	</table> <!-- Valeur locative révisée neutralisée -->
	
	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="9">Valeur locative planchonée</th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($les_taux as $noms => $valeur): 
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;}?>
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
	</table> <!-- Valeur locative planchonée -->
	
	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="7">Base Cotisation <?=get_current_year()?></th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($les_taux as $noms => $valeur): 
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;}?>
				<td>
					<?=ucwords($noms)?>
				</td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Bâti</td>
			<?php 
				foreach ($vl_planchonee_base_cotisation as $noms => $valeur): 
					$cotisation_annee = $field->get_base_cotisation_annee($valeur);
					$base_cotisation_annee[$noms] = $cotisation_annee;
				?>
				<td><?= number_format(round($cotisation_annee),2,',',' ') ?></td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Total</td>
			<?php 
				foreach ($vl_planchonee_base_cotisation as $noms => $valeur): 
					$cotisation_annee = $field->get_base_cotisation_annee($valeur);?>
				<td><?= number_format(round($cotisation_annee),2,',',' ') ?></td>
			<?php endforeach ?>
		</tr>
	</table> <!-- Base de cotisation -->
	
	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="7">Taux d'imposation</th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($les_taux as $noms => $taux):
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;} ?>
				<td>
					<?=ucwords($noms)?>
				</td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Bâti</td>
			<?php 
				foreach ($les_taux as  $noms => $taux):
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;} ?>
				<td><?= !empty($taux) ? $taux : 0 ?></td>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>Total</td>
			<?php 
				foreach ($les_taux as $noms => $taux):
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;} ?>
				<td><?= !empty($taux) ? $taux : 0 ?></td>
			<?php endforeach ?>
		</tr>
	</table> <!-- Taux d'imposition -->
	
	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="8">Cotisation <?=get_current_year()?> en system actuel (sans frais de gestion)</th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($les_taux as $noms => $taux):
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;}?>
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
				foreach ($les_taux as $noms => $taux):
					if(array_key_exists($noms, $champs_a_exclure)){continue;}
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
				foreach ($les_taux as $noms => $taux):
					if(array_key_exists($noms, $champs_a_exclure)){continue;}
					$cotisation_annee_sans_frais = $field->get_cotisation_annee((float)$base_cotisation_avis, (float)$taux);?>
				<td><?= number_format(round($cotisation_annee_sans_frais),2,',',' ') ?></td>
			<?php endforeach ?>
			<td>
				{Total des tout tatal cotisation 2017}
			</td>
		</tr>
	</table> <!-- Cotisation current_year en system actuel (sans frais de gestion) -->
	
	<br><br>

	<table cellspacing="0" cellpadding="10" border="1" width="1224">
		<tr>
			<th colspan="8">Cotisation <?=get_current_year()?> reviséé (sans frais de gestion)</th>
		</tr>
		<tr>
			<td></td>
			<?php foreach ($les_taux as $noms => $taux):
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;}?>
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
				foreach ($les_taux as $noms => $taux):
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;}
					$cotisation = $base_cotisation_annee[$noms];
					$cotisation_annee_revise = $field->get_cotisation_annee_revise((float)$cotisation, (float)$taux);?>
				<td><?= number_format(round($cotisation_annee_revise),2,',',' ') ?></td>
			<?php endforeach ?>
			<td>
				{Total des cotisation 2017}
			</td>
		</tr>
		<tr>
			<td>Total</td>
			<?php 
				foreach ($les_taux as $noms => $taux):
					//enlever les teaux qui ne sont pas calculer dans la cotisation
					// ex: les taux de GEMAPI dans ce simulateur
					if(array_key_exists($noms, $champs_a_exclure)){continue;}
					$cotisation = $base_cotisation_annee[$noms];
					$cotisation_annee_revise = $field->get_cotisation_annee_revise((float)$cotisation, (float)$taux);?>
				<td><?= number_format(round($cotisation_annee_revise),2,',',' ') ?></td>
			<?php endforeach ?>
			<td>
				{Total des tout tatal cotisation 2017}
			</td>
		</tr>
	</table> <!-- Cotisation current_year revisee (sans frais de gestion) -->
	
	<?php
	echo "<pre>";

	echo '<br>';

	echo '<br>';
	print_r($posted_fields);
	endif;
	echo "</pre>";