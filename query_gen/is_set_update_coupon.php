<?php
	//called by query_gen.php upon coupon edit
	//the variables are already clean thanks to postcleaner.php

	if(empty($_POST['add_coupon_code'])){			
		echo"<div class=\"feedback updated\"><p>You did not enter a coupon code, which is fine; it just means the code was randomly generated for you.  By me.</p></div>";
	}
	
	if(empty($_POST['add_coupon_code'])){
		
		//this value will hold the randomly generated coupon code.  It needs to be set back to '' during each
		//iteration of the loop, otherwise the random characters would keep on appending to each previous code
		//and the code would eventually be hundreds of characters long.
		include('random_generator.php');
		$coupon_code = str_rand($length_of_coupon_code, '01234567890abcdefghijklmnopqrstuvwxyz-_.');
		//Did the user enter a value for a coupon code?  If not, then we will be generating random ones.
	}
	
	
	if(!empty($_POST['add_coupon_code'])){
		$coupon_code=$add_coupon_code;	
	}
	
	echo"<div class=\"feedback updated\"><p>Coupon '$coupon_code' updated.</p></div>";

	$data = array(
		"coupon_code" => "$coupon_code",
		"value" => "$discount",
		"is-percentage" => "$is_percentage",
		"use-once" => "$use_once",
		"active" => "$active",
		"every_product" => "$every_product",
		"start" => "$start",
		"expiry" => "$end"
	);
		
	$where = array(id=>$coupon_id_to_update);
	$format = array(
		'%s', '%f', '%d', '%d', '%d','%d', '%s', '%s', '%s'
	);
	$where_format = array( '%d' );
	
	$query=$wpdb->update($coupon_table, $data, $where, $format, $where_format);
	//echo"<br>$coupon_table<br>";
	//print_r($data);
	//print_r($where);
	//print_r($format);
	//print_r($where_format);
	
	//echo"<br><br>$query<br>";
	
?>