<?php 


	/**
	* 
	*/
	class fields
	{
		/**
		*
		* CETTE METHOD EST CREE POUR DES CAS TRES PRECIS
		* ELLE PEUT ETRE SUPPRIMER A LA FINALISATION DU PROJET
		* OU DANS LE CAS CONTRAINE ^_-
		*
		* This method is used to filter FORM input fields
		* @param $pattern, regexp the keys to isolate
		* @param $input, array list to fetch in the keys
		* @return 
		*	# an array of field keys and their values;
		*	# or Null if not
		*/
		function group_fields(string $pattern, array $input){
			//assign a Null value to avoid (error => Undefined value), when a pattern not found
			$selected_fields = null;
			//get the pattern keys
			$group_fields = preg_grep('/'.$pattern.'/', array_keys($input));
			//go through pattern keys to match the @param $input keys 
			//if exist @return array or null if not
			foreach ($input as $field_name => $field_value) {
				foreach ($group_fields as $field) {
					if($field_name === $field){
						$selected_fields[$field_name] = $field_value;
					}
				}
			}
			//self explanatory
			return $selected_fields;
		}

		/**
		 * Calcule la valeur locative de l'annee de l'avis (current_year - 1)
		 * sur la base de cotisation de l'annee de l'avis (current_year -1)
		 * @param $base_cotisation
		 * @return valeur locative
		 */
		function get_vl(int $base_cotisation){
			return $base_cotisation * 2;
		}

		/**
		 * Calcule la surface ponderees par rapport au surface renseigné par l'utilisateur
		 * @param $list_des_surfaces
		 * @return $total_de_la_surface_ponderees
		 */
		function get_surfaces_ponderees(array $list_surfaces){
			$surfaces = array();
			$total_surface ="";

			/**
			 * Recuperer les champs qui contienne des valeur (! null / ! empty)
			 */
			foreach ($list_surfaces as $key => $value) {
				if(!empty($value)){
					$surfaces[$key] = $value;
				}
			}

			/**
			 * Calcule chaque champ a sa coef de ponderation
			 * et puis faire l'addition pour avoir la surface ponderees
			 */
			foreach ($surfaces as $surface_id => $surface_value) {
				switch ($surface_id) {
					case $surface_id == "p1" :
						$coef_de_ponderation = 1;
						$total_surface += $surface_value * $coef_de_ponderation;
						break;
					case ($surface_id == "p2" || $surface_id == "pk1") :
						$coef_de_ponderation = 0.5;
						$total_surface += $surface_value * $coef_de_ponderation;
						break;
					case ($surface_id == "p3" || $surface_id == "pk2") :
						$coef_de_ponderation = 0.2;
						$total_surface += $surface_value * $coef_de_ponderation;
						break;				
					default:
						$coef_de_ponderation = 0;
						break;
				}
			}

			return $total_surface;
		}


		/**
		 * Calcule la valeur locative revisee brute
		 * @param $surface_ponderee
		 * @param $tarif //ICI LE TARIF EST STATIC => plus tard il faudrait le recuperer de la base
		 * @param $coef_de_localisation
		 * @return Valeur locative revisee brute
		 */
		function get_vl_revisee_brute(float $surface_ponderee, float $tarif=255.0, float $coef_de_localisation){
			return $surface_ponderee * $tarif * $coef_de_localisation;
		}
		
		/**
		 * Calcule la valeur revisee neutralisee
		 * @param $valeur_locative_brute
		 * @param $coef_de_neutralisation 
		 * 		  //Si l'utilisateur ne renseigne pas, un valeur static est fourni. Qui est de 0.3
		 * @return valeur revisee neutralisee
		 */
		function get_vl_revisee_neutralisee(float $vl_revisee_brute, array $coef_de_neutralisation){
			$valeur_calcule_de_base = 0.3;
			$total_vl_revisee_neutralisee = [];

			foreach ($coef_de_neutralisation as $neut_colonne => $neut_valeur) {
				if($neut_valeur != $valeur_calcule_de_base){
					$total_vl_revisee_neutralisee[$neut_colonne] = $vl_revisee_brute * $neut_valeur;
				}else{
					$total_vl_revisee_neutralisee[$neut_colonne] = $vl_revisee_brute * $valeur_calcule_de_base;
				}
			}

			return $total_vl_revisee_neutralisee;
		}

		/**
		 * Calcule le valeur locative planchonnee
		 * @param $valeur_locative_revisee_neutralisee
		 * @param $valeur_locative_annee_avis
		 * @return valeur locative planchonee
		 */
		function get_vl_planchonee(float $vl_revisee_neutralisee, float $total_vl){
			$planchonnement = ($total_vl - $vl_revisee_neutralisee) / 2;
			$vl_planchonee = $vl_revisee_neutralisee + $planchonnement;
			return $vl_planchonee;
		}

		/**
		 * Calcule la base de cotisation de l'annee courante (current_year)
		 * @param $valeur_locative_planchonee
		 * @return valeur locative planchonee
		 */
		function get_base_cotisation_annee(float $vl_planchonee){
			return $vl_planchonee / 2;
		}


		/**
		* calcule les cotisations de l'annee courante en system actuel (sans frais de gestion)
		* /!\ INTENSION : c'est calculer avec la base de cotisation de l'annee de l'avis (current_year - 1)
		* @param $base_de_cotisation de l'annee de l'avis ( current_year - 1 )
		* @param $les_taux de l'annee de l'avis
		* @return la cotisation de l'annee courante 
		*/
		function get_cotisation_annee(float $base_cotisation_avis, float $le_taux){
			return $base_cotisation_avis * $le_taux;
		}

		/**
		* calcule les cotisations REVISÉÉ de l'annee courante en system actuel (sans frais de gestion)
		* /!\ INTENSION : c'est calculer avec la base de cotisation de l'annee courante (current_year)
		* @param $base_de_cotisation de l'annee courante (current_year)
		* @param $les_taux de l'annee de l'avis
		* @return la cotisation de l'annee courante 
		*/
		function get_cotisation_annee_revise(float $base_cotisation_annee, float $le_taux){
			return $base_cotisation_annee * $le_taux;
		}


	}

 ?>