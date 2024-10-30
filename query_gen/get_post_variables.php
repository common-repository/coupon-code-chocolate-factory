<?php
	//used by both is_set_submit and is_set_update
	//to handle new coupons and edited coupons, repectively
	//called upon form submission by query_gen.php
	//the postCleaner() function is used here a lot.
	//it is defined in post_cleaner.php, also called by query_gen.php
	//it removes any character other than letters, numbers, the underscore, the hyphen and the period
	//any form input used in a query either gets cleaned by postcleaner or gets filtered out by is_numeric.
	//several times in this script, we sniff out whether or not it's a new coupon or an edit.
	//we do this by looking for 'coupon_id_to_update'

	//echo"<h3>The variables for debugging purposes</h3>";
	
	//is it an edit?
	if(isset($_POST['coupon_id_to_update'])){
		if(is_numeric($_POST['coupon_id_to_update'])){
		$coupon_id_to_update=$_POST['coupon_id_to_update'];
	//			echo"coupon id to update:  {$_POST['coupon_id_to_update']}";
		
		}else{die;}
}

	if(isset($_POST['add_coupon_code'])){
		$add_coupon_code=postCleaner($_POST['add_coupon_code']);
//			echo"add coupon code: $add_coupon_code<br>";
	} else {
		die;
	}
	
	if(is_numeric($_POST['length_of_coupon_code'])){
		$length_of_coupon_code=$_POST['length_of_coupon_code'];
//			echo"length of coupon code: $length_of_coupon_code<br>";
	}else{$length_of_coupon_code=7;}
	
	if(is_numeric($_POST['number_of_coupons'])){
		$number_of_coupons=postCleaner($_POST['number_of_coupons']);
//			echo"number_of_coupons: $number_of_coupons<br>";
	} else {$number_of_coupons=1;}
	
	//if this is a serious limitation for anyone's business, then they have the resources to get in here and change this.
	//otherwise, I don't want people crashing their browser with huge numbers of queries.
	if($number_of_coupons > 5000){
		$number_of_coupons = 5000;
	}
	
	if(isset($_POST['add_discount'])){
		$discount=postCleaner($_POST['add_discount']);
//			echo"discount: $discount<br>";
	} else {
		die;
	}

	if(isset($_POST['add_discount_type'])){
		$is_percentage=postCleaner($_POST['add_discount_type']);
//			echo"add_discount_type: $add_discount_type<br>";
	} else {
		die;
	}

		//the jquery datepicker sends the dates in a different format if the form is pre-populated--we can determine which format by examining the strlen after the postCleaner removes any slashes
		if(isset($_POST['add_start'])){
			$start=postCleaner($_POST['add_start']);
			if(strlen($start)==8){
				$date=substr($start,2,2); 
			//	echo"date: $date <br>";
				$month=substr($start,0,2); 
			//	echo"month: $month <br>";
				$year=substr($start,4,4);
			//	echo"year: $year <br>";
									
			}elseif(strlen($start)==10){
				//echo" <br>cleaned start: $start<br>";
				$date=substr($start,8,2); 
				$month=substr($start,5,2); 
				$year=substr($start,0,4);
			}//else {echo" strlen start:".strlen($start);}
			$start=$year.'-'.$month.'-'.$date.' 00:00:00';
			//echo"<br>start: $start<br>";
		} else {die;}
		if(isset($_POST['add_end'])){
		$end=postCleaner($_POST['add_end']);
		if(strlen($end)==8){
				$date=substr($end,2,2); 
				//echo"date: $date <br>";
				$month=substr($end,0,2); 
			//	echo"month: $month <br>";
				$year=substr($end,4,4);
		//		echo"year: $year <br>";
									
			}elseif(strlen($end)==10){
				//echo" <br>cleaned end: $end<br>";
				$date=substr($end,8,2); 
				$month=substr($end,5,2); 
				$year=substr($end,0,4);
			}//else {echo" strlen end:".strlen($end);}
			$end=$year.'-'.$month.'-'.$date.' 00:00:00';
		} else {die;}
	
	if(isset($_POST['add_use-once'])){
		$use_once=postCleaner($_POST['add_use-once']);
//			echo"add_use_once: $add_use_once<br>";
	} else {
		die;
	}

	if(isset($_POST['add_active'])){
		$active=postCleaner($_POST['add_active']);
//			echo"add_active: $add_active<br>";
	} else {
		die;
	}

	if(isset($_POST['add_every_product'])){
		$every_product=postCleaner($_POST['add_every_product']);
//			echo"add_every_product: $add_every_product<br>";
	} else {
		die;
	}
	
	//if it's an update, we have to include the existing conditions in the array
	if(!isset($_POST['coupon_id_to_update'])){

		//handle conditions for a new coupon insert, as opposed to an update
		$rules = $_POST['rules'];
		foreach ($rules as $key => $rule) {
			foreach ($rule as $k => $r) {
				$new_rule[$k][$key] = $r;
			}
		}
		foreach($new_rule as $key => $rule) {
			if ($rule['value'] == '') {
				unset($new_rule[$key]);
			}
		}
		$condition=serialize($new_rule);
	}
		
		
		
		
	/*		if(isset($_POST['property'])){
				$property=postCleaner($_POST['property']);
	//			echo"property: $property<br>";
				if($property=='item_name'){$s1='9';}
				if($property=='item_quantity'){$s1='13';}
				if($property=='total_quantity'){$s1='14';}
				if($property=='subtotal_amount'){$s1='15';}

			} else {
				die;
			}

			if(isset($_POST['logic'])){
				$logic=postCleaner($_POST['logic']);
	//			echo"logic: $logic<br>";
				if($logic=='equal'){$s2='5';}
				if($logic=='greater'){$s2='7';}
				if($logic=='less'){$s2='4';}
				if($logic=='contains'){$s2='8';}
				if($logic=='not_contain'){$s2='11';}
				if($logic=='begins'){$s2='6';}
				if($logic=='ends'){$s2='4';}
				if($logic=='category'){$s2='8';}
			
			} else {
				die;
			}

			if(isset($_POST['value'])){
				$value=postCleaner($_POST['value']);
	//			echo"value: $value<br>";
				$s3= strlen($value);
			} else {
				die;
			}
			

			$condition = 'a:1:{i:0;a:3:{s:8:"property";s:'.$s1.':"'.$property.'";s:5:"logic";s:'.$s2.':"'.$logic.'";s:5:"value";s:'.$s3.':"'.$value.'";}}';
			if(strlen($value)==0){$condition='a:0:{}';} 
			
	//		echo"<hr>";
	*/		
?>