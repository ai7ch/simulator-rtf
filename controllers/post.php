<?php 
/**
* Handles the data submitted by the form
*/
	/**
	* This method is used to filter FORM input fields
	* @param $pattern, regexp the keys to isolate
	* @param $input, array list to fetch in the keys
	* @return 
	*	# an array of field keys and their values;
	*	# or Null if not
	*/
	function groupFields($pattern, array $input){
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


	echo "<pre>";

	$fields = $_GET;
	$patterns = [
		'taux' => '^taux',
		'proprietes' => '[-]\d',
		'entreprise-avis' => '[-]ent$',
		'entreprise-cerfa' => '[-]ent[-]cerfa',
		'utilisateur' => '[-]u',
		'surfaces' => '[-](p|pk)\d',
	];
		
	$les_taux = groupFields($patterns['proprietes'], $fields);
	print_r($les_taux);

	echo '<br>';
	print_r($fields);


echo "</pre>";