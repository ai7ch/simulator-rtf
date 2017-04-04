<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../ressources/css/style.css"> <!-- this should echo from $config[path=>css] -->
	<title>Simulateur RTF</title>
</head>
<body>
	<div id="container" class="contaier">
		<form method="" action="../controllers/post.php">
			<div class="row avis" style="border: 1px solid gray; margin: 20px 0 50px; padding: 20px 15px; background-color: #ededed;">
				<h2>Avis d'impôt 2016 <!-- = $current_year --> taxes foncières :</h2>
				<div class="col-md-12">
					<h3>Information de l'entreprise :</h3>
					<label for="nom-ent">Nom d'entreprise : <input type="text" id="nom-ent" name="nom-ent"></label>
					<label for="montant-ent">Montant à payer : <input type="text" id="montant-ent" name="montant-ent"></label>
					<label for="departement-ent">Département : <input type="text" id="departement-ent" name="departement-ent"></label>
					<label for="commune-ent">Commune : <input type="text" id="commune-ent" name="commune-ent"></label>
				</div>
				<br>
				<div class="col-md-12">
					<h3>Détail du calcul des cotisations, propriétés Bâties :</h3>
					<table cellpadding="0" cellspacing="0" border="0" id="proprietes-baties">
						<tr>
							<th></th>
							<th>Commune</th>
							<th>Syndicat de communes</th>
							<th>Inter communalité</th>
							<th>Département</th>
							<th>Taxes spéciale</th>
							<th>Taxe ordures ménagères</th>
							<th>Taxe GEMAPI</th>
							<th>Total des cotisations</th>
						</tr> <!--Headers-->
						<tr>
							<td>Taux 2016 <!--  = $current_year (-) 1 --></td>
							<td> <input type="text" id="taux-com-baties" name="taux-com-baties" class="" > </td>
							<td> <input type="text" id="taux-synd-com-baties" name="taux-synd-com-baties" class="" > </td>
							<td> <input type="text" id="taux-inter-com-baties" name="taux-inter-com-baties" class="" > </td>
							<td> <input type="text" id="taux-dep-baties" name="taux-dep-baties" class="" > </td>
							<td> <input type="text" id="taux-tse-baties" name="taux-tse-baties" class="" > </td>
							<td> <input type="text" id="taux-teom-baties" name="taux-teom-baties" class="" > </td>
							<td> <input type="text" id="taux-gemapi-baties" name="taux-gemapi-baties" class="" > </td>
							<td> <input type="text" id="taux-total-baties" name="taux-total-baties" class="" > </td>
						</tr> <!--Taux-->
						<tr><td colspan="9">
							<table cellpadding="0" cellspacing="0" border="0"><tr>
								<td>Adresse</td>
								<td colspan="7"> <input type="text" id="adresse-baties-0" name="propriete-0[adresse]" class="" ></td>
								</tr><tr>
									<td>Base</td>
									<td> <input type="text" id="base-com-baties-0" name="propriete-0[base][commune]" class="" > </td>
									<td> <input type="text" id="base-synd-com-baties-0" name="propriete-0[base][syndicat-commune]" class="" > </td>
									<td> <input type="text" id="base-inter-com-baties-0" name="propriete-0[base][syndicat-inter-commune]" class="" > </td>
									<td> <input type="text" id="base-dep-baties-0" name="propriete-0[base][departement]" class="" > </td>
									<td> <input type="text" id="base-tse-baties-0" name="propriete-0[base][tse]" class="" > </td>
									<td> <input type="text" id="base-teom-baties-0" name="propriete-0[base][teom]" class="" > </td>
									<td> <input type="text" id="base-gemapi-baties-0" name="propriete-0[base][gemapi]" class="" > </td>
									<td> <input type="text" id="base-total-baties-0" name="propriete-0[base][total]" class="" > </td>
								</tr><tr><!--Base-->
									<td>Cotisation</td>
									<td> <input type="text" id="cotisation-com-baties-0" name="propriete-0[cotisation][commune]" class="" > </td>
									<td> <input type="text" id="cotisation-synd-com-baties-0" name="propriete-0[cotisation][syndicat-commune]" class="" > </td>
									<td> <input type="text" id="cotisation-inter-com-baties-0" name="propriete-0[cotisation][syndicat-inter-commune]" class="" > </td>
									<td> <input type="text" id="cotisation-dep-baties-0" name="propriete-0[cotisation][departement]" class="" > </td>
									<td> <input type="text" id="cotisation-tse-baties-0" name="propriete-0[cotisation][tse]" class="" > </td>
									<td> <input type="text" id="cotisation-teom-baties-0" name="propriete-0[cotisation][teom]" class="" > </td>
									<td> <input type="text" id="cotisation-gemapi-baties-0" name="propriete-0[cotisation][gemapi]" class="" > </td>
									<td> <input type="text" id="cotisation-total-baties-0" name="propriete-0[cotisation][total]" class="" > </td>
								</tr> <!--Cotisation-->
							</table>
						</td></tr>
					</table>
					<a href="#ajouter_une_propriete">Ajouter une proprietés bâties</a>
					<br><br><br>
					!!! Les bases relatives aux propriétés non bâties ne rentrent pas dans le calcul de la simulation puisque la réforme de la taxe foncière porte uniquement sur les locaux, soient les propriétés bâties.
				</div>
			</div> <!-- .avis -->
			<div class="row cerfa-6660-rev" style="border: 1px solid gray; margin: 20px 0 50px; padding: 20px 15px; background-color: #ededed;">
				<h2>CERFA 6660-REV :</h2>
				<div class="col-md-12">
					<h3>Votre département ? / Ou... ? :</h3>
					<label for="departement-ent-cerfa"> Département :
						<input type="text" id="departement-ent-cerfa" placeholder="Département"> 
						<input type="hidden" name="departement-ent-cerfa">
					</label>
					<label for="commune-ent-cerfa"> Commune :
						<input type="text" id="commune-ent-cerfa" placeholder="La commune">
						<input type="hidden" name="commune-ent-cerfa">
					</label>
					<br>
					<label for="secteur-ent-cerfa"> Secteur :
						<select id="secteur-ent-cerfa" name="secteur-ent-cerfa">
							<option value="0">-- Choix d'un secteur --</option>
							<option value="1">Secteur 1</option>
							<option value="2">Secteur 2</option>
							<option value="3">Secteur 3</option>
							<option value="4">Secteur 4</option>
							<option value="5">Secteur 5</option>
							<option value="6">Secteur 6</option>
							<option value="7">Secteur 7</option>
						</select> <span>PDF</span>
					</label>
					<br>
					<label for="section-ent-cerfa"> Section :
						<input type="text" name="section-ent-cerfa" id="section-ent-cerfa" placeholder="Section">
					</label>
					<label for="invariant-ent-cerfa"> Invariant :
						<input type="text" name="invariant-ent-cerfa" id="invariant-ent-cerfa" placeholder="Invariant">
					</label>
				</div>
				<div class="col-md-12">
					<h3>Occupation du local :</h3>
					<h4>Catégorie du local :</h4>
						<select name="local-cat" id="local-cat">
							<option value="">-- Choix d'un groupe --</option>
							<optgroup label="Magasins et lieux de vente"><option value="mag1">MAG 1 - boutiques et magasins sur rue</option>
								<option value="mag2">MAG 2 - commerces sans accès direct sur la rue</option>
								<option value="mag3">MAG 3 - magasins appartenant à un ensemble commercial</option>
								<option value="mag4">MAG 4 - magasins de grande surface (surface principale comprise entre 400 et 2 500 m²)</option>
								<option value="mag5">MAG 5 - magasins de très grande surface (surface principale supérieure ou égale à 2 500 m²)</option>
								<option value="mag6">MAG 6 - stations-service, stations de lavage et assimilables</option>
								<option value="mag7">MAG 7 - marchés</option>
							</optgroup>
							<optgroup label="Bureaux et locaux divers assimilables">
								<option value="bur1">BUR 1 - locaux à usage de bureaux d'agencement ancien</option>
								<option value="bur2">BUR 2 - locaux à usage de bureaux d'agencement récent</option>
								<option value="bur3">BUR 3 - locaux assimilables à des bureaux mais présentant des aménagements spécifiques</option>
							</optgroup>
							<optgroup label="Lieux de dépôt ou de stockage et parcs de stationnement">
								<option value="dep1">DEP 1 - lieux de dépôt à ciel ouvert et terrains à usage commercial ou industriel</option>
								<option value="dep2">DEP 2 - lieux de dépôt couverts</option>
								<option value="dep3">DEP 3 - parcs de stationnement à</option>
							</optgroup>
						</select>
					<h4>Consistance du local :</h4>
					<table cellpadding="0" cellpadding="0" border="0" id="surfaces-local-hpk">
						<tr>
							<th>Répartition de la surface totale de stationnement (parkings / hors parkings)</th>
						</tr>
						<tr>
							<td>
								<table cellpadding="0" cellpadding="0" border="0">
									<tr>
										<td>P1</td>
										<td>P2</td>
										<td>P3</td>
										<td>Pk1</td>
										<td>Pk2</td>
									</tr>
									<tr>
										<td><input type="text" id="surface-p1" name="surfaces[p1]" placeholder="Surface en m²"></td>
										<td><input type="text" id="surface-p2" name="surfaces[p2]" placeholder="Surface en m²"></td>
										<td><input type="text" id="surface-p3" name="surfaces[p3]" placeholder="Surface en m²"></td>
										<td><input type="text" id="surface-pk1" name="surfaces[pk1]" placeholder="Surface en m²"></td>
										<td><input type="text" id="surface-pk2" name="surfaces[pk2]" placeholder="Surface en m²"></td>
									</tr>
								</table>
							</td>
						</tr>
					</table> <!--Surfaces-->
				</div>
				<div class="col-md-12 options">
					<h4>Options : Calculs de la Simulation</h4>
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<th></th>
							<th>Commune</th>
							<th>Syndicat de communes</th>
							<th>Inter communalité</th>
							<th>Département</th>
							<th>Taxes spéciale (TSE)</th>
							<th>Taxe ordures ménagères (TEOM)</th>
						</tr>
						<tr>
							<td>Coefficient de neutralisation</td>
							<td> <input type="text" id="option-neutr-com" name="option-neutr-com" class="" value="55" > </td>
							<td> <input type="text" id="option-neutr-synd-com" name="option-neutr-synd-com" class="" value="33" > </td>
							<td> <input type="text" id="option-neutr-inter-com" name="option-neutr-inter-com" class="" value="37" > </td>
							<td> <input type="text" id="option-neutr-dep" name="option-neutr-dep" class="" value="45" > </td>
							<td> <input type="text" id="option-neutr-tse" name="option-neutr-tse" class="" value="28" > </td>
							<td> <input type="text" id="option-neutr-teom" name="option-neutr-teom" class="" value="35" > </td>
						</tr>
					</table>
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>Coefficient de localisation</td>
							<td><input type="text" id="option-local" name="option-local" class="" value="1" ></td>
						</tr>
					</table> <!--options : calcul simulation-->
					<br>
					<span>
						!!! La date estimée de la diffusion des coefficients de neutralisation est prévue pour fin Juin 2017, en attendant, la simulation s'effectue en fonction du coefficient moyen sur la France égal à 0,3.
						<br>On vous informe également que le coefficient de neutralisation est prévu d'être propre à chaque collectivité et à chaque impôt (taxe foncière, CFE, ordures ménagères,…).
						<br>Concernant les taux de Commune, syndicats de communes, inter communalité, département, taxes spéciales, taxe ordures ménagères … etc, on prend par défaut les taux N-1.
					</span>
				</div>
				<div class="col-md-12 signature">
					<h4>A propos de vous :</h4>
					<input type="text" id="nom-u" name="nom-u" placeholder="Nom et prénom">
					<input type="email" id="email-u" name="email-u" placeholder="E-mail">
				</div>
				<div class="col-md-6">
					<input type="submit" name="submit" value="Lancer la simulation" class="" />
				</div>
			</div> <!-- .cerfa-666-rev -->
		</form>
	</div> <!--#container -->

	<!-- SCRIPTS -->
	<!-- lib -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- local -->
	<script>
		$(function(){
			/**
			 * Adding rows to PROPRIETES BÂTIES table
			 */
			$('a[href="#ajouter_une_propriete"]').on('click', function(e){
				e.preventDefault();
				var targetItem = '#proprietes-baties',
					id;
					/*return the # of properties to use it as an ID for the fields*/
				$(targetItem).find('table').each(function(count){
					id = count + 1;
				})
				$(this).prev(targetItem)
						.append('<tr><td colspan="9">&nbsp;</td></tr><tr><td colspan="9">'+
									'<table cellpadding="0" cellspacing="0" border="0"><tr>'+
										'<td>Adresse</td>'+
										'<td colspan="7"> <input type="text" id="adresse-baties-'+id+'" name="propriete-'+id+'[adresse]" class="" ></td>'+
										'</tr><tr>'+
											'<td>Base</td>'+
											'<td> <input type="text" id="base-com-baties-'+id+'" name="propriete-'+id+'[base][commune]" class="" > </td>'+
											'<td> <input type="text" id="base-synd-com-baties-'+id+'" name="propriete-'+id+'[base][syndicat-commune]" class="" > </td>'+
											'<td> <input type="text" id="base-inter-com-baties-'+id+'" name="propriete-'+id+'[base][syndicat-inter-commune]" class="" > </td>'+
											'<td> <input type="text" id="base-dep-baties-'+id+'" name="propriete-'+id+'[base][departement]" class="" > </td>'+
											'<td> <input type="text" id="base-tse-baties-'+id+'" name="propriete-'+id+'[base][tse]" class="" > </td>'+
											'<td> <input type="text" id="base-teom-baties-'+id+'" name="propriete-'+id+'[base][teom]" class="" > </td>'+
											'<td> <input type="text" id="base-gemapi-baties-'+id+'" name="propriete-'+id+'[base][gemapi]" class="" > </td>'+
											'<td> <input type="text" id="base-total-baties-'+id+'" name="propriete-'+id+'[base][total]" class="" > </td>'+
										'</tr><tr>'+
											'<td>Cotisation</td>'+
											'<td> <input type="text" id="cotisation-com-baties-'+id+'" name="propriete-'+id+'[cotisation][commune]" class="" > </td>'+
											'<td> <input type="text" id="cotisation-synd-com-baties-'+id+'" name="propriete-'+id+'[cotisation][syndicat-commune]" class="" > </td>'+
											'<td> <input type="text" id="cotisation-inter-com-baties-'+id+'" name="propriete-'+id+'[cotisation][syndicat-inter-commune]" class="" > </td>'+
											'<td> <input type="text" id="cotisation-dep-baties-'+id+'" name="propriete-'+id+'[cotisation][departement]" class="" > </td>'+
											'<td> <input type="text" id="cotisation-tse-baties-'+id+'" name="propriete-'+id+'[cotisation][tse]" class="" > </td>'+
											'<td> <input type="text" id="cotisation-teom-baties-'+id+'" name="propriete-'+id+'[cotisation][teom]" class="" > </td>'+
											'<td> <input type="text" id="cotisation-gemapi-baties-'+id+'" name="propriete-'+id+'[cotisation][gemapi]" class="" > </td>'+
											'<td> <input type="text" id="cotisation-total-baties-'+id+'" name="propriete-'+id+'[cotisation][total]" class="" > </td>'+
										'</tr>'+
									'</table>'+
								'</td></tr>');
			});

			/**
			 * Remove current row
			 */
			$('body').on('click','.remove-row', function(){
				$(this).parents('tr').remove();
			})

			/**
			* Auto-complete related data fields 
			*/

			var depEnt = $('#departement-ent'),
				comEnt = $('#commune-ent');

			depEnt.on('blur',function(e){
				if($(this).val() != ''){
					$('#departement-ent-cerfa, [name="departement-ent-cerfa"]').val($(this).val());
					$('#departement-ent-cerfa').attr('disabled','disabled');
				}
			})
			comEnt.on('blur',function(e){
				if($(this).val() != ''){
					$('#commune-ent-cerfa, [name="commune-ent-cerfa"]').val($(this).val());
					$('#commune-ent-cerfa').attr('disabled','disabled');
				}
			})

			/**
			* 
			*/

		})
	</script>
</body>
</html>