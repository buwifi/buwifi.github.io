<?php
	$emailTo = "murate@gmail.com"; // Enter your email for feedbacks here

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: ".$_POST['email']."\r\n";

	if (!isset($_POST['subject'])) {
		$subject = "Get sigma"; // Enter your subject here
	} else {
		$subject = $_POST['subject'];
	}

	reset($_POST);

	$body = "";
	$body .= "<p><b>Name: </b>".$_POST['name']."</p>";
	$body .= "<p><b>Last name: </b>".$_POST['lastName']."</p>";
	$body .= "<p><b>Email: </b>".$_POST['email']."</p>";
	$body .= "<p><b>phone: </b>".$_POST['phone']."</p>";
	$body .= "<p><b>Subject: </b>".$subject."</p>";
	$body .= "<p><b>Company: </b>".$_POST['company']."</p>";
	$body .= "<p><b>Company size: </b>".$_POST['size']."</p>";

	if( mail($emailTo, $subject, $body, $headers) ){
		$mail_sent = true;
	} else {
		$mail_sent = false;
	}
	if(!isset($resp)){
		echo json_encode($mail_sent);
	}
?>