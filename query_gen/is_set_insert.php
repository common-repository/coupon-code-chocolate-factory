<?php
	//called by query_gen.php up submission of new coupons.
	
	//variables are cleaned here:
	include('get_post_variables.php');
	
	if(empty($_POST['add_coupon_code'])){			
		echo"<div class=\"feedback updated\"><p>You did not enter a coupon code, which is fine; it just means all the codes will be random.</p></div>";
	}
	
	echo"<div class=\"feedback updated\"><p>Coupons added.</p></div>";

	//Let's make a loop to create the designated amount of coupon codes
	$i = 1; 
	//user decides how many coupons.  if blank, it defaults to 1.
	while ( $i <= $number_of_coupons ) {

		//this value will hold the randomly generated coupon code.  It needs to be set back to '' during each
		//iteration of the loop, otherwise the random characters would keep on appending to each previous code
		//and the code would eventually be hundreds of characters long.
		$coupon_code=NULL;
		
		//establish the str_rand function
		include('random_generator.php');
		
		$coupon_code = str_rand($length_of_coupon_code, '01234567890abcdefghijklmnopqrstuvwxyz-_.');
		
		//Did the user enter a value for a coupon code?  If not, then we will be generating random ones.
		if(!empty($_POST['add_coupon_code'])){
			$coupon_code=$add_coupon_code;	
		}

		
		//advance the loop by one (the loop persists while i is less than the number of coupons)
		$i++;
		$data = array(
			"coupon_code" => "$coupon_code",
			"value" => "$discount",
			"is-percentage" => "$is_percentage",
			"use-once" => "$use_once",
			"active" => "$active",
			"every_product" => "$every_product",
			"start" => "$start",
			"expiry" => "$end",
			"condition" => "$condition"
		);
		$format = array(
			'%s', '%f', '%d', '%d', '%d','%d', '%s', '%s', '%s'
		);
	
		$wpdb->insert($coupon_table, $data, $format);
		//print_r($data);
	
	}
	
?>