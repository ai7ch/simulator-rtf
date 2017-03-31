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
	if(isset($_POST)){
		echo "yes POSTED";
	}
	echo "<hr>";
	$fields = $_GET;
	$patterns = [
		'taux' => '^taux',
		'proprietes' => '[-]\d',
		'entreprise-avis' => '[-]ent$',
		'entreprise-cerfa' => '[-]ent[-]cerfa',
		'utilisateur' => '[-]u',
		'surfaces' => '[-](p|pk)\d',
	];
		
	$proprietes = groupFields($patterns['proprietes'], $fields);
	print_r($proprietes);

	/****************************************/	

	$arr_main_array = array('foo-test' => 123, 'other-test' => 456, 'foo-result' => 789);

	foreach($arr_main_array as $key => $value){
	    $exp_key = explode('-', $key);
	    if($exp_key[0] == 'foo'){
	         $arr_result[] = $value;
	    }
	}

	if(isset($arr_result)){
	    //print_r($arr_result);
	}

	/***************************************/


	echo "<br>";
	
	foreach ($proprietes as $key => $value) { 
		$id = explode('-', substr($key, -1));
		print_r($id);
	}

	//print_r($total_proprietes);

	echo '<br>';

	$propriete_unique = array_unique($proprietes);
	//print_r($propriete_unique);


echo "</pre>";