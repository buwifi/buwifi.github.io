<?php
ini_set('allow_url_fopen', true);
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('myphpmailer/vendor/autoload.php');

if(isset($_POST['emailSent'])) {

	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

		// Your Google reCAPTCHA generated Secret Key here
		$secret = '6LfaqG0bAAAAALuh3VLrcuKeYXisZUWrhlT--cZc';
		
		if( ini_get('allow_url_fopen') ) {
			//reCAPTCHA - Using file_get_contents()
			$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
			$responseData = json_decode($verifyResponse);
		} else if( function_exists('curl_version') ) {
			// reCAPTCHA - Using CURL
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
			$serverError = true;
		}

		if(empty($serverError)) {

			if($responseData->success) {

				// Step 1 - Enter your email address below.
				$email = 'murat@junivodigital.com';

				// If the e-mail is not working, change the debug option to 2 | $debug = 2;
				$debug = 0;

				$subject = $_POST['subject'];

				// Step 3 - Configure the fields list that you want to receive on the email.
				$fields = array(
					0 => array(
						'text' => 'Name',
						'val' => $_POST['name']
					),
					1 => array(
						'text' => 'Email address',
						'val' => $_POST['email']
					),
					2 => array(
						'text' => 'Message',
						'val' => $_POST['message']
					),
					3 => array(
						'text' => 'Checkboxes',
						'val' => implode($_POST['checkboxes'], ", ")
					),
					4 => array(
						'text' => 'Radios',
						'val' => $_POST['radios']
					)
				);

				$message = '';

				foreach($fields as $field) {
					$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
				}

				$mail = new PHPMailer(true);

				try {

					$mail->SMTPDebug = $debug;                            // Debug Mode

					// Step 3 (Optional) - If you don't receive the email, try to configure the parameters below:

					$mail->IsSMTP();                                         // Set mailer to use SMTP
					$mail->Host = 'smtp.gmail.com';				       // Specify main and backup server
					$mail->SMTPAuth = true;                                  // Enable SMTP authentication
					$mail->Username = 'murate@gmail.com';                    // SMTP username
					$mail->Password = 'lamiye488034!';                              // SMTP password
					$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
					$mail->Port = 587;   								       // TCP port to connect to

					$mail->AddAddress($email);	 						       // Add a recipient

					//$mail->AddAddress('person2@domain.com', 'Person 2');     // Add another recipient
					//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address. 
					//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address. 

					$mail->SetFrom($email, $_POST['name']);
					$mail->AddReplyTo($_POST['email'], $_POST['name']);

					$mail->IsHTML(true);                                  // Set email format to HTML

					$mail->CharSet = 'UTF-8';

					$mail->Subject = $subject;
					$mail->Body    = $message;

					// Step 4 - If you don't want to attach any files, remove that code below
					if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
						$mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
					}

					$mail->Send();

					$arrResult = array ('response'=>'success');

				} catch (phpmailerException $e) {
					$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
				} catch (Exception $e) {
					$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
				}

			} else {
				$arrResult = array ('response'=>'error','errorMessage'=>'Robot verification failed, please try again');
			}
		}

	} else { 
		$arrResult = array ('response'=>'error','errorMessage'=>'Please click on the reCAPTCHA box.');
	}

}
?>