<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/phpmailer/phpmailer/src/PHPMailer.php'; //confirm this path
// require 'vendor/phpmailer/phpmailer/src/SMTP.php';      //confirm this path
// require 'vendor/phpmailer/phpmailer/src/Exception.php'; //confirm this path


require 'config.php';
// require 'configyandex.php';
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

if (
        isset($_POST['name']) && 
        isset($_POST['email']) && 
        isset($_POST['subject']) && 
        isset($_POST['message'])
        isset($_POST['g-recaptcha-response'])
   )
{
    $name           = $_POST['name'];
    $email          = $_POST['email'];
    $subject        = $_POST['subject'];
    $message        = $_POST['message'];


    $captcha        = $_POST['g-recaptcha-response'];
    $secretKey      = "6LdeQ6obAAAAAL1Vq1mAcKn9QZsJR04C3S0rBNAM";
    $ip             = $_SERVER['REMOTE_ADDR'];
    $url            = 'https://www.google.com/recaptcha/api/siteverify?secret=' 
                        . urlencode($secretKey) 
                        . '&response=' 
                        . urlencode($captcha);
    $response       = file_get_contents($url);
    $responseKeys   = json_decode($response,true);

    if($responseKeys["success"]) {

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
            $mail->SMTPDebug    = 0;
            $mail->isSMTP();
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
            $mail->WordWrap = 80;
            $mail->Body     = $html;

            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
                );

            if(!$mail->Send()) {
                echo '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Sorry!</strong> Problem in contact us</div>';
            } else {
                echo "<div id='success_page'>";
                echo "<p>Thank you <strong>$name</strong> ($email). Your message has been submitted to us.</p>";
                echo "</div>";
            }	
            if(!empty($targetPath)) {
                unlink($targetPath);  
            }
        }
        catch (Exception $e)
        {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }else{
        // $_SESSION['result'] = 'Please fill up the form first';
        //$msg="Verification failed";
        echo 'Verification Failed.';
    }
}
?>

