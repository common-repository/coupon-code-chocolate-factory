<?php
$coupon_page=1;
$coupons_per_page=10;

$limit=NULL;

if(isset($_GET['coupon_page'])){
	if(is_numeric($_GET['coupon_page'])){
		$coupon_page=$_GET['coupon_page'];
	}
}
if(isset($_GET['coupons_per_page'])){
	unset($_GET['submit_change_pagination']);
	if(is_numeric($_GET['coupons_per_page'])){
		$coupons_per_page=$_GET['coupons_per_page'];
	}
}

$limit = 'limit ' .($coupon_page - 1) * $coupons_per_page .',' .$coupons_per_page; 


$select_coupons =$wpdb->get_results( "SELECT * FROM ".$coupon_table." ORDER BY ID DESC $limit;" );
$select_count =$wpdb->get_results( "SELECT COUNT(*) AS COUNT FROM ".$coupon_table.";" );
foreach($select_count as $result_rows){
	$result_rows = $result_rows->COUNT;
}

if($result_rows > '0'){
	
	
	$number_of_coupon_pages=ceil(($result_rows / $coupons_per_page));
	$remainder=($result_rows % $coupons_per_page);
	$min=((($coupon_page-1)*$coupons_per_page)+1);
	$max=($coupon_page*$coupons_per_page);
	$range=$min.' - '.$max;

	echo"
	<div class=\"table_nav\">
		<form name=\"change_pagination\" method=\"get\" action=\"$url\">
			<p>Showing a maximum of
			<input type=\"text\" class=\"coupons_per_page\" value=\"$coupons_per_page\" name=\"coupons_per_page\"> results per page. Showing results $range of $result_rows total.
			<input type=\"submit\" value=\"Submit\" name=\"submit_change_pagination\">
			<input value=\"Coupon-Factory\" type=\"hidden\" name=\"page\">
			</p>
		</form>
	<ul class=\"pagination\">";
	$i=1;
	if($number_of_coupon_pages<11){	
		while($i<=$number_of_coupon_pages){
			if($i!=$coupon_page){
				echo"<li><a href=\"$url&coupon_page=$i&coupons_per_page=$coupons_per_page\">$i</a></li>";
			}else{
				echo"<li>$i</li>";
			}
			$i++;
		}
	}else{
	//there are more than 10 pages
		
		$i1=$coupon_page-3;
		$i2=$coupon_page-2;
		$i3=$coupon_page-1;
		$i4=$coupon_page+1;
		$i5=$coupon_page+2;
		$i6=$coupon_page+3;

		
		if($coupon_page>1){echo"<li><a href=\"$url&coupon_page=1&coupons_per_page=$coupons_per_page\">1</a>";{if($coupon_page>4)echo" ... ";}echo"</li>";}
		if($i1>1){echo"<li><a href=\"$url&coupon_page=$i1&coupons_per_page=$coupons_per_page\">$i1</a></li>";}
		if($i2>1){echo"<li><a href=\"$url&coupon_page=$i2&coupons_per_page=$coupons_per_page\">$i2</a></li>";}
		if($i3>1){echo"<li><a href=\"$url&coupon_page=$i3&coupons_per_page=$coupons_per_page\">$i3</a></li>";}
		echo"<li>$coupon_page</li>";
		if($i4<$number_of_coupon_pages){echo"<li><a href=\"$url&coupon_page=$i4&coupons_per_page=$coupons_per_page\">$i4</a></li>";}
		if($i5<$number_of_coupon_pages){echo"<li><a href=\"$url&coupon_page=$i5&coupons_per_page=$coupons_per_page\">$i5</a></li>";}
		if($i6<$number_of_coupon_pages){echo"<li><a href=\"$url&coupon_page=$i6&coupons_per_page=$coupons_per_page\">$i6</a></li>";}
		if($coupon_page<$number_of_coupon_pages){echo"<li>";if(($number_of_coupon_pages-$coupon_page>4)){echo" ... "; }echo"<a href=\"$url&coupon_page=$number_of_coupon_pages&coupons_per_page=$coupons_per_page\">$number_of_coupon_pages</a> (last)</li>";}
		
	}
	echo"
	</ul>
	</div>
	<table id=\"view_coupons\" class=\"result_table round group\">
		<thead>
		<tr>
		<!--<th>id</th>-->
		<th class=\"top_left first_column\">coupon_code</th>
		<th>value</th>
		<th>is-percentage</th>
		<th>use-once</th>
		<th>active</th>
		<th>every_product</th>
		<th>start</th>
		<th>expiry</th>
		<th>edit</th>
		<th class=\"top_right last_column\">delete</th>
		
		</tr>
		</thead>
		<tbody>
	";


foreach($select_coupons as $coupons){
	$id = $coupons->id;
	$coupon_code = $coupons->coupon_code;
	$value = $coupons->value;
	$is_percentage = $coupons->{'is-percentage'};
	$use_once = $coupons->{'use-once'};
	$active = $coupons->active;
	$every_product = $coupons->every_product;
	$start = $coupons->start;
	$view_start=substr($start,0, 10);
	$expiry = $coupons->expiry;
	$view_expiry=substr($expiry,0, 10);	
	$condition = $coupons->condition;
	//echo"$condition";

	$zebra++;

	echo"
		<tr";if($zebra&1){echo" class=\"odd_number\"";}echo" >
			<!--<td>$id</td>-->
			<td class=\"first_column\">$coupon_code</td>
			<td>$value</td>
			<td>$is_percentage</td>
			<td>$use_once</td>
			<td>$active</td>
			<td>$every_product</td>
			<td>$view_start</td>
			<td>$view_expiry</td>
			<td><span title=\"$coupon_code\" rel=\"$id\" class=\"wpsc_edit_coupon\"></span>
				<div class=\"toggle edit_coupon round\">";
				include('edit_coupon.php');
				echo"
				</div>
				
			</td>
			<td class=\"last_column\">
			<form action=\"#\" method=\"post\">
				<input type=\"hidden\" value=\"$id\" name=\"one_coupon_to_delete\">
				<input type=\"hidden\" value=\"$coupon_code\" name=\"coupon_code_to_delete\">
				<input type=\"submit\" class=\"delete_button\"value=\"X\" name=\"delete_one_coupon\">
			</form>
			</td>
		</tr>
	";
}
	
	$zebra++;

	echo"
	
	<tfoot>
		<tr";if($zebra&1){echo" class=\"odd_number\"";}echo" >
		<!--<th>id</th>-->
		<th class=\"bottom_left first_column\">coupon_code</th>
		<th>value</th>
		<th>is-percentage</th>
		<th>use-once</th>
		<th>active</th>
		<th>every_product</th>
		<th>start</th>
		<th>expiry</th>
		<th>edit</th>
		<th class=\"bottom_right last_column\">delete</th>
		
		</tr>
		</tfoot>
	
	</tbody></table>";
}

?>