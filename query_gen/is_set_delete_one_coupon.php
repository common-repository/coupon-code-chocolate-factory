<?php
	//called by query_gen.php upon form submission
	//an iteration of the form exists in each row of the results table
	if(is_numeric($_POST['one_coupon_to_delete'])){
		
		$one_coupon_to_delete = $_POST['one_coupon_to_delete'];
		//$coupon_table is established in query_gen.php
		$delete_query="
			DELETE
			FROM ".$coupon_table."
			WHERE id = '$one_coupon_to_delete'
			LIMIT 1
		";
		$wpdb->query($delete_query);
		$rows_deleted=$wpdb->rows_affected;
		$coupon_code_to_delete=postCleaner($_POST['coupon_code_to_delete']);
		//if(!empty($rows_deleted)){
			echo"<div class=\"feedback updated\"><p>You just deleted coupon '$coupon_code_to_delete'.</p></div>";
		//}else{
		//	echo"There was an error and coupon '$coupon_code_to_delete' could not be deleted.";
		//}
		
	}else{die;}

?>