<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require 'config.php';
require 'configyandex.php';
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

// var_dump($_POST);
// print_r($_POST);
// foreach ($_POST as $key => $value)  echo $key.'='.$value.'<br />';
// echo str_replace('  ', '&nbsp; ', nl2br(print_r($_POST, true)));
// echo str_replace('  ', '&nbsp; ', nl2br(var_export($_POST, true)));

if (! function_exists('d'))
{
    function d($var, $exit = 0)
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
}

d($_POST);



if ( isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message']) )
{
   if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
   { 
        $name           = $_POST['name'];
        $email          = $_POST['email'];
        $subject        = $_POST['subject'];
        $message        = nl2br(str_replace("\r\n", "\n", $_POST['message']));

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
                            Contact Form:<br>
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

        try
        {    
            $mail->isSMTP();
            $mail->SMTPDebug    = SMTP::DEBUG_OFF;
            $mail->SMTPAuth     = true;
            $mail->Host         = CONFIG['email']['host'];
            $mail->Port         = CONFIG['email']['port'];
            $mail->SMTPSecure   = CONFIG['email']['SMTPSecure'];
            $mail->Username     = CONFIG['email']['username'];
            $mail->Password     = CONFIG['email']['password'];
            $mail->CharSet      = CONFIG['email']['CharSet'];

            $mail->SetFrom(CONFIG['email']['ToAddress'], $name);
            $mail->AddReplyTo($email, $name);
            $mail->addAddress(CONFIG['email']['ToAddress']);
            $mail->isHTML(true);
            $mail->Subject  = ("$email ($subject)");
            $mail->Subject  = "[Contact Form] "."$email ($subject)";
            $mail->WordWrap = 80;
            $mail->Body     = $html;

            $secretKey  = '6Leo-3IiAAAAAN62Qy-KHANa-WdM3zYahZDn4OHi'; // prod
            // $secretKey  = '6LcldnIiAAAAACCCwG7Jet2gFUv5FrjLd-bVn9eD'; // dev

            $response   = $_POST["g-recaptcha-response"];
            $ip         = $_SERVER['REMOTE_ADDR'];

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
                'secret' => $secretKey,
                'response' => $response,
                'remoteip'=> $ip
            );

            d($data);

            $options = array(
                   'http' => array (
                   'method' => 'POST',
                   'content' => http_build_query($data),
                   'header' => 'Content-Type: application/x-www-form-urlencoded'
                )
            );

            d($options);


            $context  = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success=json_decode($verify);

            d($context);
            d($verify);
            d($captcha_success);

            if ($captcha_success->success==false) {
                echo "Captcha wrong";
            } else if ($captcha_success->success==true) {
                if(!$mail->Send()) {
                    echo '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Sorry!</strong> Problem in contact us</div>';
                } else {
                    echo "<div id='success_page'>";
                    echo "<p>Thank you <strong>$name</strong> ($email). Your message has been submitted to us.</p>";
                    echo "</div>";
                }	
            }
        }
        catch (Exception $e)
        {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }else{
        echo 'Captcha Verification Failed.';
    }

}else{
    echo 'Fill the form Verification Failed.';
}