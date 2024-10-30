<?php
	//The main form for adding new coupons
	//called near the middle of query_gen.php, just after the h2 tags
?>

<div id="add_coupon_box">

	<form id="insert" class="main round" name="add_coupon" method="post" action="#">
		<h3>Add New Coupons</h3>
		<ul class="hints">
			<li>Add as many new coupons as you would like, as long as it's less than 5,000 at a time. Any more than that, and things would just be crazy.  </li>
			<li>If you don't enter anything for the number of coupons, or if you just enter "1", then it's just going to make one coupon. </li>
			<li>If you enter a value for "Coupon Code", then every coupon will have that as it's code.</li>
			<li>If you leave "Coupon Code" blank, then they will all be randomly generated from a character pool consisting of letters, numbers, the underscore, and the hyphen.</li>
			<li>If you let the codes be random like that, you can at least choose how long the code will be.
				And if you leave that blank too, then the codes will all be 7 characters long.
			</li>
		</ul>
		<div class="group">
			<fieldset title="If left blank, codes will be random and unique; If filled in, all coupons will be generated with this code.">

		<legend>
		Coupon Code
		</legend>

		<input name="add_coupon_code" type="text"/>


		</fieldset>

		<fieldset title="max 5000"><legend>
		Number of Coupons
		</legend>
		<input value="3"  name="number_of_coupons" type="text" class="required"/>
		</fieldset>

		<fieldset title="This only applies if COUPON CODE is left blank."><legend>
		Length of Coupon Code</legend>
		<input value="7"  name="length_of_coupon_code" type="text" class=""/>
		</fieldset>


		</div>

		<div class="group">
			<fieldset>
				<legend>Discount</legend>
				<input value="" size="3" name="add_discount" type="text"/>
				<select name="add_discount_type">
					<option value="0">$</option>
					<option value="1">%</option>
					<option value="2">Free shipping</option>
				</select>
				</fieldset>
			<fieldset>
				<legend>Start</legend>
				<input class="pickdate required" type="text" size="11" id="popupDatepicker1" name="add_start"/>
			</fieldset>

			<fieldset>
				<legend>Expiry</legend>
				<input class="pickdate required" type="text" size="11" id="popupDatepicker2" name="add_end"/>
			</fieldset>

			<fieldset>
				<legend>Use Once</legend>
				<input value="0" name="add_use-once" type="hidden"/>
				<input value="1" name="add_use-once" type="checkbox"/>
			</fieldset>

			<fieldset>
				<legend>Active</legend>
				<input value="0" name="add_active" type="hidden"/>
				<input value="1" checked="checked" name="add_active" type="checkbox"/>
			</fieldset>
		</div>

		<fieldset id="conditions" class="group">
			<legend>Conditions</legend>
			
		<div class='coupon_condition' >
			<div class='first_condition'>

				<select class="ruleprops" name="rules[property][]">
					<option value="item_name" rel="order">Item name</option>
					<option value="item_quantity" rel="order">Item quantity</option>
					<option value="total_quantity" rel="order">Total quantity</option>
					<option value="subtotal_amount" rel="order">Subtotal amount</option>
					<?php echo apply_filters( 'wpsc_coupon_rule_property_options', '' ); ?>
				</select>
				<select name="rules[logic][]">
					<option value="equal">Is equal to</option>
					<option value="greater">Is greater than</option>
					<option value="less">Is less than</option>
					<option value="contains">Contains</option>
					<option value="not_contain">Does not contain</option>
					<option value="begins">Begins with</option>
					<option value="ends">Ends with</option>
					<option value="category">In Category</option>
				</select>
				<input name="rules[value][]" type="text"/>			

			<script>
					var coupon_number=1;
					function add_another_property(this_button){
						var new_property='<div class="coupon_condition">\n'+
							'<div><img height="16" width="16" class="delete" alt="Delete" src="<?php echo WPSC_URL; ?>/images/cross.png" onclick="jQuery(this).parent().remove();"/> \n'+
								'<select class="ruleprops" name="rules[property][]"> \n'+
									'<option value="item_name" rel="order">Item name</option> \n'+
									'<option value="item_quantity" rel="order">Item quantity</option>\n'+
									'<option value="total_quantity" rel="order">Total quantity</option>\n'+ 
									'<option value="subtotal_amount" rel="order">Subtotal amount</option>\n'+ 
									'<?php echo apply_filters( 'wpsc_coupon_rule_property_options', '' ); ?>'+
								'</select> \n'+
								'<select name="rules[logic][]"> \n'+
									'<option value="equal">Is equal to</option> \n'+
									'<option value="greater">Is greater than</option> \n'+
									'<option value="less">Is less than</option> \n'+
									'<option value="contains">Contains</option> \n'+
									'<option value="not_contain">Does not contain</option> \n'+
									'<option value="begins">Begins with</option> \n'+
									'<option value="ends">Ends with</option> \n'+
								'</select> \n'+
								'<span> \n'+
									'<input type="text" name="rules[value][]"/> \n'+
								'</span>  \n'+
							'</div> \n'+
						'</div> ';
			
						jQuery('.coupon_condition :first').after(new_property);
						coupon_number++;
					}
					</script>
				
				
			</div>
		</div>
		<a class="wpsc_coupons_condition_add" onclick="add_another_property(jQuery(this));">
			<?php _e('Add New Condition','wpsc'); ?>
		</a>
		</fieldset>

		<fieldset id="apply_all">
		<legend>
			Apply On All Products
			</legend>
			<input value="0" name="add_every_product" type="hidden"/>
			<input value="1" name="add_every_product" type="checkbox"/>
		</fieldset>

		<input value="Add Coupon" name="submit_coupon" class="button-primary" type="submit"/>
	</form>  


	<form class="main round" id="delete_coupons" name="delete_coupons" method="post" action="#">
		<fieldset>
			<span>Permanently delete the </span>
			<input type="text" name="delete_coupons" value="0">
			<span> most recently added coupons.</span>
			<input type="submit" name="submit_delete" class="button" value="Permanently Delete These Coupons" />
		</fieldset>
	</form>
</div>