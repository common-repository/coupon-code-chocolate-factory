<?php
	//this is called by ../coupon_code_chocolate_factory.php upon form submission.
	//the form exists near the bottom of query_gen.php
	//it is called after output buffering has been established and before any text is sent to the browser
	//it tricks the browser into thinking it's seeing an excel document
	
	$filename='Coupon_Codes';
	$table_name=$wpdb->prefix."wpsc_coupon_codes";

	$orderBy = 'id';
	$orderDirection = 'DESC'; // can be left blank

	$query="
		SELECT *
		FROM $table_name
		ORDER BY $orderBy $orderDirection
	";
	
	$query_rsExport =$wpdb->get_results($query);

	$totalRows_rsExport = $wpdb->num_rows;
	//echo"<br>rows returned: $totalRows_rsExport<br>";
	//echo"<br>$query<br>";
	
	//these strings establish new cells and new rows in excel
	$d = "\t";
	$nl = "\n";

	//this variable is eventually sent to the excel document.  it will contain the entire table
	//one step at a time
	$contents = '';

	// write out fields
	$contents .='ID'.$d.'Coupon Code'.$d.'Value'.$d.'Is Percentage'.$d.'Use Once'.$d.'Is Used'.$d.'Active'.$d.'Every Product'.$d.'Start'.$d.'Expiry'.$d.'Condition'.$d    ;

	// close fields list
	$contents .= $nl;

	// write out data
	foreach($query_rsExport as $row){
		$id=$row->id;
		$coupon_code=$row->coupon_code;
		$value=$row->value;
		$is_percentage=$row->{'is-percentage'};
		$use_once=$row->{'use-once'};
		$is_used=$row->{'is-used'};
		$active=$row->active;
		$every_product=$row->every_product;
		$start=$row->start;
		$expiry=$row->expiry;
		$condition=$row->condition;
		
		$contents .= $id.$d;
		$contents .= $coupon_code.$d;
		$contents .= $value.$d;
		$contents .= $is_percentage.$d;
		$contents .= $use_once.$d;
		$contents .= $is_used.$d;
		$contents .= $active.$d;
		$contents .= $every_product.$d;
		$contents .= $start.$d;
		$contents .= $expiry.$d;
		$contents .= $condition.$d;
		$contents .= $nl;
	}

	// Send Headers
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);

	echo $contents;

	exit;
?> 