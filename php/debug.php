<?php

// print_r($_POST);

if($_POST['g-recaptcha-response']) 
{
  $captcha = $_POST['g-recaptcha-response'];
  $secret = "6LdeQ6obAAAAAL1Vq1mAcKn9QZsJR04C3S0rBNAM";
  $json = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=". $secret . "&response=" . $captcha), true);

  print_r($json);

  if($json['success']) {
      echo "ok";
  } else {
      echo "recaptcha error";
  }
}  else {
    echo "repsonse error";
}