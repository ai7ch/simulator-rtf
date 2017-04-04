<?php 


	/**
	* 
	*/
	class fields
	{
		/**
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
		 * @param $base_cotisation
		 */
		function get_vl(int $base_cotisation){
			return $base_cotisation * 2;
		}

		/**
		 * 
		 */
		function get_surfaces_ponderees(array $get_surfaces){
			$surfaces = array();
			$total_surface ="";

			/**
			 * Isolate selected surface from the others
			 */
			foreach ($get_surfaces as $key => $value) {
				if(!empty($value)){
					$surfaces[$key] = $value;
				}
			}

			/**
			 * Loop through selected surface_id and calculate with their corresponding coef
			 * and then perfom addition of all selected surface
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
		 * @return Valeur locative revisee brute
		 */
		function get_vl_revisee_brute(int $surface_ponderee, int $tarif=255){
			$coef_de_localisation = 1;
			//get $tarif value, returned from tarif table
			$tarif = 255;

			return $surface_ponderee * $tarif * $coef_de_localisation;
		}
		
		/**
		 * 
		 */
		function get_vl_revisee_neutralisee(int $vl_revisee_brute){
			$coef_de_neutralisation = 0.3;
			return $vl_revisee_brute * $coef_de_neutralisation;
		}

		/**
		 * 
		 */
		function get_vl_planchonee(int $vl_revisee_neutralisee, int $total_vl){
			$planchonnement = ($total_vl - $vl_revisee_neutralisee) / 2;
			$vl_planchonee = $vl_revisee_neutralisee + $planchonnement;
			return $vl_planchonee;
		}


	}

 ?>