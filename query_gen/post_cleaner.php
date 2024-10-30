<?php
	//called by query_gen.php, used by get_post_variables.php for anything not protected by is_numeric().
	//only letters, numbers, periods, hyphens, and underscores.
	
	function postCleaner($var) {
		$var=trim($var);
		$var=strip_tags($var);
		$var=preg_replace("/[^a-z0-9._-]/i", "", $var);
		return $var;
	}

?>