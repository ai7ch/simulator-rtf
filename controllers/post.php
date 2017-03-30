<?php 
/**
* Handles the data submitted by the form
*/
	$fields_data = $_GET;
	echo "<pre>";
		print_r($fields_data);
		foreach ($fields_data as $field_title => $field_value) {
			//$matched = preg_grep("/^base/", explode("\n", $field_title));
			//echo $field_title . '<br>';
		}
		$matched = preg_grep("/^base/", explode("\n", $field), $fields_data);
		print_r($matched);
		echo "<br>";
		echo count($_GET);
	echo "</pre>";