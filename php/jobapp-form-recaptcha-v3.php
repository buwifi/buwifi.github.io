<?php

namespace JunivoJobAppForm;

ini_set('allow_url_fopen', true);

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'myphpmailer/vendor/autoload.php';

session_start();

//print_r($_POST);

if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
	$secret = '6LfaqG0bAAAAALuh3VLrcuKeYXisZUWrhlT--cZc';
	
	if( ini_get('allow_url_fopen') ) {
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		$responseData = json_decode($verifyResponse);
	} else if( function_exists('curl_version') ) {
		$fields = array(
	        'secret'    =>  $secret,
	        'response'  =>  $_POST['g-recaptcha-response'],
	        'remoteip'  =>  $_SERVER['REMOTE_ADDR']
	    );

	    $verifyResponse = curl_init("https://www.google.com/recaptcha/api/siteverify");
	    curl_setopt($verifyResponse, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($verifyResponse, CURLOPT_TIMEOUT, 15);
	    curl_setopt($verifyResponse, CURLOPT_POSTFIELDS, http_build_query($fields));
	    $responseData = json_decode(curl_exec($verifyResponse));
	    curl_close($verifyResponse);
	} else {
		$arrResult = array ('response'=>'error','errorMessage'=>'You need CURL or file_get_contents() activated in your server. Please contact your host to activate.');
		echo json_encode($arrResult);
		die();
	}

	if($responseData->success) {
		$email = 'murat@junivodigital.com';
		$debug = 2;
		$subject = ( isset($_POST['subject']) ) ? $_POST['subject'] : 'Define subject in php/jobapp-form-recaptcha.php line 62';
		$message = '';
		foreach($_POST as $label => $value) {
			if( $label != 'g-recaptcha-response' ) {
				$label = ucwords($label);
				if( is_array($value) ) {
					$value = implode(', ', $value);
				}
				$message .= $label.": " . htmlspecialchars($value, ENT_QUOTES) . "<br>\n";
			}
		}
		print_r($message);

		$mail = new PHPMailer(true);

		try {
			$mail->SMTPDebug = $debug;                                 // Debug Mode
			$mail->IsSMTP();                                         // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';				       // Specify main and backup server
			$mail->SMTPAuth = true;                                  // Enable SMTP authentication
			$mail->Username = 'murate@gmail.com';                    // SMTP username
			$mail->Password = 'lamiye488034!';                              // SMTP password
			$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
			$mail->Port = 587;   								       // TCP port to connect to
			$mail->AddAddress($email);	 						       // Add another recipient

			//$mail->AddAddress('person2@domain.com', 'Person 2');     // Add a secondary recipient
			//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address. 
			//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address. 

			// From - Name
			$fromName = ( isset($_POST['name']) ) ? $_POST['name'] : 'Website User';
			$mail->SetFrom($email, $fromName);

			// Reply To
			if( isset($_POST['email']) ) {
				$mail->AddReplyTo($_POST['email'], $fromName);
			}

			$mail->IsHTML(true);                                  // Set email format to HTML
			$mail->CharSet = 'UTF-8';
			$mail->Subject = $subject;
			$mail->Body    = $message;

//			echo "CHECK_8<br>";
//			echo $_FILES['attachment']['error'];
			print_r($_FILES);
			// Step 4 - If you don't want to attach any files, remove that code below
			if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
				echo "CHECK_9<br>";
				$mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
			}

			$mail->Send();
			$arrResult = array ('response'=>'success');

		} catch (Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
		} catch (\Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
		}

		if ($debug == 0) {
			echo json_encode($arrResult);
		}

	} else {
		$arrResult = array ('response'=>'error','errorMessage'=>'reCaptcha Error: Verifcation failed (no success). Please contact the website administrator.');
		echo json_encode($arrResult);
	}

} else { 
	$arrResult = array ('response'=>'error','errorMessage'=>'reCaptcha Error: Invalid token. Please contact the website administrator.');
	echo json_encode($arrResult);
}