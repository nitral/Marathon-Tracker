<?php

	function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	function check_required_fields($required_array) {
		$field_errors = array();
		foreach($required_array as $fieldname) {
			if (!isset($_GET[$fieldname]) || (empty($_GET[$fieldname]) && $_GET[$fieldname] != 0)) { 
				$field_errors[] = $fieldname; 
			}
		}
		return $field_errors;
	}
	function confirm_query($result_set) {
			if (!$result_set) {
				die("Database query failed: " . mysql_error());
			}
	}
	function redirect_to( $location = NULL ) {
			if ($location != NULL) {
				header("Location: {$location}");
				exit;
			}
	}
?>