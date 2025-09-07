<?php
/*
Author @CreativForm (on GitHub)
Source: https://gist.github.com/jonathanstark/dfb30bdfb522318fc819#gistcomment-2189252
*/

function junivo_debug($var, $exit = 0)
{
        // if ($_SERVER['HTTP_HOST'] != 'localhost')
        // {
        //     return;
        // }

        echo "\n[BEGIN]<pre>\n";
        echo var_export($var, 1);
        echo "\n</pre>[END]\n";

        if ($exit)
            exit;
}


function validate_recaptcha($response){
	// Verifying the user's response (https://developers.google.com/recaptcha/docs/verify)
	$verifyURL = 'https://www.google.com/recaptcha/api/siteverify';

	// $secretkey = '6Leo-3IiAAAAAN62Qy-KHANa-WdM3zYahZDn4OHi'; // PROD
	$secretkey = '6LcldnIiAAAAACCCwG7Jet2gFUv5FrjLd-bVn9eD'; // DEV
	
	$query_data = [
		'secret' => $secretkey,
		'response' => $response,
		'remoteip' => (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'])
	];

	// Collect and build POST data
	$post_data = http_build_query($query_data, '', '&');

	// junivo_debug($post_data);
	
	// Send data on the best possible way
	if(function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec')) {
		// Use cURL to get data 10x faster than using file_get_contents or other methods
		// echo "using curl";
		$ch =  curl_init($verifyURL);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-type: application/x-www-form-urlencoded'));
			$response = curl_exec($ch);
		curl_close($ch);
	} else {
		// If server not have active cURL module, use file_get_contents
		// echo "using other";
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $post_data
			)
		);
		$context  = stream_context_create($opts);
		$response = file_get_contents($verifyURL, false, $context);
	}

	// junivo_debug($response);

	// Verify all reponses and avoid PHP errors
	if($response) {
		$result = json_decode($response);
		if ($result->success===true) {
			return true;
		} else {
			return $result;
		}
	}

	// Dead end
	return false; 
}


