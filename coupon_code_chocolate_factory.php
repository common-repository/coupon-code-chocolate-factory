<?php	



/*

Plugin Name: WPEC Coupon Code Chocolate Factory 

Plugin URI: http://www.scottfennell.com

Description: Plugin allows users to create an arbitrary amount of coupons for WP E-commerce with a single entry.

Author: Scott

Version: 1.0

Author URI: http://www.scottfennell.com

License: GPL2



Copyright 2011  Scott Fennell  (email : scofennell@gmail.com)



This program is free software; you can redistribute it and/or modify

it under the terms of the GNU General Public License, version 2, as 

published by the Free Software Foundation.



This program is distributed in the hope that it will be useful,

but WITHOUT ANY WARRANTY; without even the implied warranty of

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

GNU General Public License for more details.



You should have received a copy of the GNU General Public License

along with this program; if not, write to the Free Software

Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA



*/



//this is to prevent the headers already sent error message when exporting to excel.

ob_start();



//if it doesn't already exist, add the coupon table to the db.

//the table is identical in structure to the wp ecommerce coupon code table.

add_action('activate_coupon_code_chocolate_factory/coupon_code_chocolate_factory.php', 'sjf_create_factory');

function sjf_create_factory() {

	global $wpdb;



//	echo"prefix:".$wpdb->prefix;

	$coupon_table = $wpdb->prefix."wpsc_coupon_codes";

	$structure=

	"

		CREATE TABLE IF NOT EXISTS $coupon_table(

			`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,

			`coupon_code` varchar(255) DEFAULT '',

			`value` decimal(11,2) NOT NULL DEFAULT '0.00',

			`is-percentage` char(1) NOT NULL DEFAULT '0',

			`use-once` char(1) NOT NULL DEFAULT '0',

			`is-used` char(1) NOT NULL DEFAULT '0',

			`active` char(1) NOT NULL DEFAULT '1',

			`every_product` varchar(255) NOT NULL DEFAULT '',

			`start` datetime NOT NULL,

			`expiry` datetime NOT NULL,

			`condition` text,

			PRIMARY KEY (`id`),

			KEY `coupon_code` (`coupon_code`),

			KEY `active` (`active`),

			KEY `start` (`start`),

			KEY `expiry` (`expiry`)

		)

		ENGINE=MyISAM  DEFAULT CHARSET=utf8;

	";

//	echo"<br>table: $table<br>";

	$wpdb->query($structure);

}





//we are handling this here, before any text is sent to the browser, to avoid header already sent errors.

add_action('admin_init', 'when_to_export');

function when_to_export(){

	$coupon_table = $wpdb->prefix."wpsc_coupon_codes";



	global $wpdb;

	if((isset($_POST['export_recent'])) || (isset($_POST['export_all']))){

		include('query_gen/export_coupons.php');

		echo"<div class=\"feedback updated\"><p>Your coupon codes are currently downloading to your desktop.</p></div>";

	}

}





//query_gen.php is the main business file that handles $_POST activity and calls include files.

function coupon_menu()

{

	global $wpdb;

	global $url;

	include('query_gen/query_gen.php');

}







//add a link in the plugin menu on the admin sidebar

add_action('admin_menu', 'sjf_coupon_code_chocolate_factory_admin_actions');

function sjf_coupon_code_chocolate_factory_admin_actions()

{

	add_submenu_page("plugins.php", "Coupon Factory", "Coupon Factory", 1, "Coupon-Factory","coupon_menu");

}





//the url for the coupon factory

$url=admin_url().'plugins.php?page=Coupon-Factory';



//only call scripts and styles if the user is on the coupon factory page.

//if(isset($_GET['page'])){
//	if(($_GET['page'])=='Coupon-Factory'){

		//add styles

		add_action('admin_menu', 'sjf_add_my_stylesheet');

		function sjf_add_my_stylesheet() {

			$myStyleUrl = WP_PLUGIN_URL . '/coupon-code-chocolate-factory/layout/sjf_coupon_styles.css';

			$myStyleFile = WP_PLUGIN_DIR . '/coupon-code-chocolate-factory/layout/sjf_coupon_styles.css';

			$mydateStyleUrl1 = WP_PLUGIN_URL . '/coupon-code-chocolate-factory/jquery/jquery.datepick.css';

			$mydateStyleFile1 = WP_PLUGIN_DIR . '/coupon-code-chocolate-factory/jquery/jquery.datepick.css';

			$mydateStyleUrl2 = WP_PLUGIN_URL . '/coupon-code-chocolate-factory/jquery/ui-cupertino.datepick.css';

			$mydateStyleFile2 = WP_PLUGIN_DIR . '/coupon-code-chocolate-factory/jquery/ui-cupertino.datepick.css';

			

			//if ( file_exists($myStyleFile) ) {

				wp_register_style('myStyleSheets', $myStyleUrl);

				wp_enqueue_style( 'myStyleSheets');

			//}	

			//if ( file_exists($mydateStyleFile1) ) {

				wp_register_style('mydateStyleSheets1', $mydateStyleUrl1);

				wp_enqueue_style( 'mydateStyleSheets1');

			//}

			//if ( file_exists($mydateStyleFile2) ) {			

				wp_register_style('mydateStyleSheets2', $mydateStyleUrl2);

				wp_enqueue_style( 'mydateStyleSheets2');

			//}

		}

		

		//add scripts

		add_action('admin_menu', 'sjf_add_my_script');

		function sjf_add_my_script() {

			wp_enqueue_script("jquery");

			$mydateScriptUrl1 = WP_PLUGIN_URL . '/coupon-code-chocolate-factory/jquery/jquery.datepick.js';

			$mydateScriptFile1 = WP_PLUGIN_DIR . '/coupon-code-chocolate-factory/jquery/jquery.datepick.js';

			$myvalidateScriptUrl1 = WP_PLUGIN_URL . '/coupon-code-chocolate-factory/jquery/jquery.validate.js';

			$myvalidateScriptFile1 = WP_PLUGIN_DIR . '/coupon-code-chocolate-factory/jquery/jquery.validate.js';

			$call_scriptsUrl = WP_PLUGIN_URL . '/coupon-code-chocolate-factory/jquery/call_scripts.js';

			$call_scriptsFile = WP_PLUGIN_DIR . '/coupon-code-chocolate-factory/jquery/call_scripts.js';

			

			//if ( file_exists($mydateScriptFile1) ) {

				wp_register_script('mydateScript1', $mydateScriptUrl1);

				wp_enqueue_script( 'mydateScript1');

			//}

			//if ( file_exists($myvalidateScriptFile1) ) {

				wp_register_script('myvalidateScript1', $myvalidateScriptUrl1);

				wp_enqueue_script( 'myvalidateScript1');

			//}			

		}

		

		//add the file that contains the html <script tags> and instantiates the javascript functions.  this gets called in the html head.

		add_action('admin_head', 'sjf_call_my_script');

		function sjf_call_my_script() {

			include('query_gen/call_scripts.htm');

		}

//	}

//}

?>