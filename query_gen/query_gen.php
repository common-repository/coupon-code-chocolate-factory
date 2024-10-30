<?php

	$coupon_table = $wpdb->prefix."wpsc_coupon_codes";

	
	echo'<div class="wrap">
	<div id="icon-plugins" class="icon32"><br></div>
	';
	
	include('post_cleaner.php');

	if((isset($_POST['export_recent'])) || (isset($_POST['export_all']))){
	//include('query_gen/export_coupons.php');
		echo"<div class=\"feedback updated\"><p>Your coupon codes are currently downloading to your desktop.</p></div>";
	}

	
	if(isset($_POST['delete_coupons'])){
		include('is_set_delete.php');
	}

	if(isset($_POST['delete_one_coupon'])){
		include('is_set_delete_one_coupon.php');
	}
	
	//if(isset($_POST['delete_condition'])){
	//	include('is_set_delete_condition.php');
	//}
	
	if(isset($_POST['coupon_id_to_update'])){
		//include the post variable cleaner function, call like so: $the_var=postCleaner($the_var);
		include('get_post_variables.php');
		include('is_set_update_coupon.php');
	}
	
	if(isset($_POST['submit_coupon'])){
		if(!isset($_POST['coupon_id_to_update'])){
			//include the post variable cleaner function, call like so: $the_var=postCleaner($the_var);
			include('get_post_variables.php');
			include('is_set_insert.php');//also includes random_number_generator.php
		}
	}
	

$select_count =$wpdb->get_results( "SELECT COUNT(*) AS COUNT FROM ".$coupon_table.";" );
foreach($select_count as $before_rows){
	$before_rows = $before_rows->COUNT;
}
echo"<div class=\"feedback updated\" id=\"coupon_count\"><p>There";
if($before_rows == 1){
	echo" is";
}else{
	echo" are";
}

echo" currently $before_rows";
if($before_rows == 1){
	echo" coupon";
}else{
	echo" coupons";
}
echo" in the database.</p></div>";



echo"<h2>Coupon Code Chocolate Factory</h2>";

//the main form for adding new coupons
include("form.php");

if(isset($whole_query)){
	
	$select_recent_insert="SELECT * FROM ".$coupon_table." ORDER BY id DESC LIMIT $i;";
	$result=mysqli_query($wpdb, $select_recent_insert);
	echo"<table id=\"recent_inserts\">
	<thead>The $i ";if($i==1){echo"Coupon";}else{echo"Coupons";}echo" Added, Just Now. </thead>
	<tbody>
	<tr><th>ID</th><th>Code</th><th>Value</th><th>Type</th><th>Use Once?</th><th>Active?</th><th>Every Product?</th><th>Start</th><th>Expiry</th></tr>
	
	";
	
	while($row=mysqli_fetch_array($result)){
		$display_id=$row['id'];
		$display_coupon_code=$row['coupon_code'];
		$display_value=$row['value'];
		$display_discount_type=$row['is-percentage'];
		if($display_discount_type==0){$display_discount_type="\$";}
		if($display_discount_type==1){$display_discount_type="%";}
		if($display_discount_type==2){$display_discount_type="Free Shipping";}
		$display_use_once=$row['use-once'];
		if($display_use_once==0){$display_use_once="no";}
		if($display_use_once==1){$display_use_once="yes";}
		$display_active=$row['active'];
		if($display_active==0){$display_active="no";}
		if($display_active==1){$display_active="yes";}
		$display_every_product=$row['every_product'];
		if($display_every_product==0){$display_every_product="no";}
		if($display_every_product==1){$display_every_product="yes";}
		//$display_condition=$row['condition'];
		$display_start=$row['start'];
		$display_expiry=$row['expiry'];
		
		echo"<tr><td>$display_id</td><td>$display_coupon_code</td><td>$display_value</td><td>$display_discount_type</td><td>$display_use_once</td><td>$display_active</td><td>$display_every_product</td><td>$display_start</td><td>$display_expiry</td></tr>";
	
	}
	echo"</tbody></table>";

	echo "
		<form class=\"main round\" action=\"\" method=\"post\">
			<input class=\"button\" type=\"submit\" name=\"export_recent\" value=\"Click Here to Download These $i coupons to an Excel Spreadsheet on Your Desktop\">
		</form>
";

}

include('view_coupons.php');

if($advanced==1){
echo"
<form class=\"main round\" action=\"\" method=\"post\">
			<input class=\"button\" type=\"submit\" name=\"export_all\" value=\"Click Here to Download All $before_rows coupons to an Excel Spreadsheet on Your Desktop\">
		</form>
";
}else{
echo"
		<form class=\"main round\" action=\"\" method=\"post\">
			<input class=\"button\" type=\"submit\" name=\"get_advanced\" value=\"Click Here to Download the Advanced Version to you can Export Coupons Excel Spreadsheet on Your Desktop\">
		</form>
";


echo"	</div><!--end class=wrap div-->";
}

?>


