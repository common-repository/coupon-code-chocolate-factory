<?php
	//used in is_set_update.php and is_set_submit.php to generate random coupon codes
	//the seed is defined when the function is called
# Snippet from PHP Share: http://www.phpshare.org

/**
 * Generate and return a random string
 *
 * The default string returned is 8 alphanumeric characters.
 *
 * The type of string returned can be changed with the "seeds" parameter.
 * Four types are - by default - available: alpha, numeric, alphanum and hexidec. 
 *
 * If the "seeds" parameter does not match one of the above, then the string
 * supplied is used.
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     2.1.0
 * @link        http://aidanlister.com/repos/v/function.str_rand.php
 * @param       int     $length  Length of string to be generated
 * @param       string  $seeds   Seeds string should be generated from
 */
	if(!function_exists('str_rand')){
		function str_rand($length, $seeds)
		{
		    // Possible seeds
		    $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
		    $seedings['numeric'] = '0123456789';
		    $seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
		    $seedings['hexidec'] = '0123456789abcdef';
		    
		    // Choose seed
		    if (isset($seedings[$seeds]))
		    {
			$seeds = $seedings[$seeds];
		    }
		    
		    // Seed generator
		    list($usec, $sec) = explode(' ', microtime());
		    $seed = (float) $sec + ((float) $usec * 100000);
		    mt_srand($seed);
		    
		    // Generate
		    $str = '';
		    $seeds_count = strlen($seeds);
		    
		    for ($i = 0; $length > $i; $i++)
		    {
			$str .= $seeds{mt_rand(0, $seeds_count - 1)};
		    }
		    
		    return $str;
		}
	}
?> 