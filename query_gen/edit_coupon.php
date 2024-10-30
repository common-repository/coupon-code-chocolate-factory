<?php		
	//Displays a form to edit existing coupons.
	//The form is hidden behind a javascript onClick in the results table.
	//each coupon has it's own form in the far right cell of its row in the table.
	//called in each row of the results table by view_coupons.php.
	
	echo"
		<form name=\"edit_coupon\" id=\"update\" method=\"post\" action=\"#\">
			<div class=\"group\">
				<fieldset title=\"If left blank, codes will be random and unique; If filled in, all coupons will be generated with this code.\">
					<legend>Coupon Code</legend>
					<input name=\"add_coupon_code\" value=\"$coupon_code\" type=\"text\"/>
				</fieldset>
			
				<fieldset>
					<legend>Discount</legend>
					<input value=\"$value\" size=\"5\" name=\"add_discount\" type=\"text\"/>
					<select name=\"add_discount_type\">
						<option value=\"0\" ";if($is_percentage==0){echo" selected=\"selected\"";}echo ">$</option>
						<option value=\"1\" ";if($is_percentage==1){echo" selected=\"selected\"";}echo" >%</option>
						<option value=\"2\" ";if($is_percentage==2){echo" selected=\"selected\"";}echo" >Free shipping</option>
					</select>
				</fieldset>
			</div>
			<div class=\"group\">
				
			<fieldset>
				<legend>Start</legend>
				<input class=\"pickdate required\" type=\"text\" value=\"$view_start\" size=\"11\" id=\"popupDatepicker3\" name=\"add_start\"/>
			</fieldset>

			<fieldset>
				<legend>Expiry</legend>
				<input class=\"pickdate required\" type=\"text\" size=\"11\"  value=\"$view_expiry\" id=\"popupDatepicker4\" name=\"add_end\"/>
			</fieldset>

			<fieldset><legend>Use Once</legend>
				<input value=\"0\" name=\"add_use-once\" type=\"hidden\"/>
				<input value=\"1\" ";if($use_once==1){echo" checked=\"checked\" ";}echo"name=\"add_use-once\" type=\"checkbox\"/>
			</fieldset>

			<fieldset><legend>
			Active
			</legend>
			<input value=\"0\" name=\"add_active\" type=\"hidden\"/>
			<input value=\"1\" ";if($active==1){echo" checked=\"checked\" ";}echo" name=\"add_active\" type=\"checkbox\"/>
			</fieldset>
			</div>
			
			
			<fieldset id=\"apply_all\">
				<legend>Apply On All Products</legend>
				<input value=\"0\" name=\"add_every_product\" type=\"hidden\"/>
				<input value=\"1\" ";if($every_product==1){echo" checked=\"checked\" ";} echo" name=\"add_every_product\" type=\"checkbox\"/>
			</fieldset>
			
				
			<input value=\"Edit Coupon\" name=\"submit_coupon\" class=\"button-primary\" type=\"submit\"/>
			<input value=\"$id\" name=\"coupon_id_to_update\" type=\"hidden\"/>

		</form>
	";
	
	//the conditions are stored in the database as a string,
	//but we'll use php to turn them into an array so we can decipher how many there are and what they mean
	$conditions = unserialize($condition);
	//echo"<br>$condition<br>";

	if($conditions != null){

		echo"
		<!--<form name=\"delete_conditions\" class=\"delete_conditions round\" action=\"\" method=\"post\">
				<fieldset id=\"delete_conditions\" class=\"group\">-->
				<table class=\"view_conditions\">
					<thead>
						<tr>
							<th colspan=\"3\">Conditions</th>
						</tr>
						<tr>
							<!--<th>Delete</th>-->
							<th>Property</th>
							<th>Logic</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>
		";
	
	
		$i=0;
		
		//we turned the conditions string into an array.  now we can read values from it
		foreach ($conditions as $condition){
//			$a_value=substr(serialize($conditions), 2, 1)

			echo"
				<tr><!--<td>
				<input type=\"hidden\" name=\"coupon_id_delete_condition\" value=\"$id\" >
				<button value=\"$a_value\" class=\"delete_button\" name=\"delete_condition\" >X</button>
				--></td>";
				echo"<td>";
				echo$condition['property'];
				echo"</td><td>";
				echo$condition['logic'];
				echo"</td><td>";
				echo$condition['value'];
				echo"</td></tr>";
			$i++;
		}
		echo"</tbody></table></fieldset></form>";
	}
?>