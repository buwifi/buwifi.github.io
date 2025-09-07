<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'config.php';
require 'vendor/autoload.php';

function restructureArray(array $arr)
{
    $result = array();
    foreach ($arr as $key => $value) {
        for($i = 0; $i < count($value); $i++) {
            $result[$i][$key] = $value[$i];
        }
    }
    return $result;
}

function responseHandler($status, $msg)
{
    if($status) {
        http_response_code(200);
        $response = [
            "code" => 200,
            "message" => $msg
        ];
        echo json_encode($response);
    } else {
        http_response_code(500);
        $response = [
            "code" => 500,
            "message" => $msg
        ];
        echo json_encode($response);
    }
    exit;
}

  $files = [];
  if(!empty($_FILES['resume'])) {
      $files = restructureArray($_FILES['resume']);
  }

  //echo '<pre>';print_r($files);echo '</pre>';
  //echo '<pre>';print_r($_POST);echo '</pre>';
  //echo '<pre>';print_r($_FILES);echo '</pre>';
  //echo '<pre>';print_r(array_values($_POST) );echo '</pre>';
  
  list($name, $email, $phone, $position, $subject,  $message) = array_values($_POST);

  //echo '<pre>';print_r($name .'--'. $email .'--'. $phone .'--'. $position .'--'. $subject .'--'. $message);echo '</pre>';

  if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message']) )
  {


    // $name = $_POST['name'];
    // $email = $_POST['email'];
    // $phone = $_POST['phone'];
    // $position = $_POST['position'];
    // $subject = $_POST['subject'];
    // $message = $_POST['message'];


    $html ='<!DOCTYPE html>
    <html lang="en">
    <head>
        <link href="http://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <style>
            body{
                font-family: Ubuntu, sans-serif;
                bacground-color: #f0f3f4;
                margin:0 auto !important;
                padding:0 !important;
                height:100% !important;
                width:100% !important;
            }
    
            #users{
                border-collapse: collapse;
                width:100%;
            }
    
            #users td, #users th{
                border:1px solid #ddd;
                padding:8px;
            }
    
            #users tr:nth-child(even){background-color: #f2f2f2;}
    
            #users tr:hover {background-color:#ddd;}
    
            #users th {
                padding-top:12px;
                padding-bottom:12px;
                text-alive:left;
                background-color:#4caf50;
                color:white;
            }
            </style>
            </head>
            <body>';
    
    $html .= '<table style="width:100%;background-color: #f0f3f4;padding:20px;">
    <tr>
        <td>
            <table>
                <tr>
                    <td colspan="2">
                        Job Application Form Submission<br>
                        Hi,<br/>
                        <p> Here is new enquiry from <b> '.$name.'</b></p>
                    <td>
                <tr>
            </table>
            <table id="users" >
                <tr>
                    <th>Name</th>
                    <th>'.$name.'</th>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>'.$email.'</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>'.$phone.'</td>
                </tr>
                <tr>
                    <td>Position</td>
                    <td>'.$position.'</td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td>'.$subject.'</td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td>'.$message.'</td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
    </body>
    </html>';

    $mail = new PHPMailer(true);
    try
    {

        $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

      $mail->SMTPDebug = 0;
      $mail->isSMTP();

      $mail->Host         = CONFIG['email']['host'];
      $mail->SMTPAuth     = true;
      $mail->Port         = CONFIG['email']['port'];
      $mail->SMTPSecure   = CONFIG['email']['SMTPSecure']; 'ssl';
      $mail->Username     = CONFIG['email']['username'];
      $mail->Password     = CONFIG['email']['password'];
      $mail->CharSet      = CONFIG['email']['CharSet'];
  
      $mail->setFrom($email, $name);

      $mail->addAddress('murate@gmail.com');
    //   $mail->addAddress('murat@junivodigital.com', 'Murat Eren Work');

      $mail->isHTML(true);
      $mail->Subject = ("$email ($subject)");
      $mail->Body = $html;

      // Multiple Files
      if(!empty($files)) {
        foreach($files as $key => $file) {
            $mail->addAttachment(
                $file['tmp_name'],
                $file['name']
            );
        }
      }

      if(isset($_POST['grecaptcha']) && !empty($_POST['grecaptcha']))
      {
        $secretKey = '6LdeQ6obAAAAAL1Vq1mAcKn9QZsJR04C3S0rBNAM';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['grecaptcha']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success)
        {
          if ($mail->send())
          {
            echo "<fieldset>";
            echo "<div id='success_page'>";
            echo "<p>Thank you <strong>$name</strong>, your message has been submitted to us.</p>";
            echo "</div>";
            echo "</fieldset>";
          } else {
            echo 'Error sending mail';
          }
        }
        else
        { // verification failed
          echo "reCAPTCHA verification failed, please try again.";
        }
      }
      else
      {
        echo "Please go back and click on the reCAPTCHA box";
      }
    }
    catch (Exception $e)
    {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
  }
?>
