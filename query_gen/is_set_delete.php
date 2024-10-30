<?php
	//called by query_gen.php upon submission of delete recent coupons form
	if(is_numeric($_POST['delete_coupons'])){
		
		$delete_coupons = $_POST['delete_coupons'];
		
		//the $coupon_table variable is established in query_gen.php
		$delete_query="
			DELETE
			FROM ".$coupon_table."
			ORDER BY id
			DESC
			LIMIT $delete_coupons
		";
		$wpdb->query($delete_query);
		//I cannot for the life of me get wpdb-> rows affected to return the number of rows deleted.
		$rows_deleted=$wpdb->rows_affected;
		//if(empty($rows_deleted)){
			echo"<div class=\"feedback updated\"><p>You just deleted the $delete_coupons most recently created coupons!</p></div>";
		//}else{
			echo"There was an error and the coupons could not be deleted.";
		//}
	}else{die;}

?>