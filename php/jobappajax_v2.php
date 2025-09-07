<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'config.php';
require 'configyandex.php';
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

if(
       isset($_POST['name']) 
    && isset($_POST['email'])
    && isset($_POST['subject'])
    && isset($_POST['message'])
  )
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

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
                        Job Application Form:<br>
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
        $mail->SMTPDebug = 0;
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

        // if(is_array($_FILES)) 
        // {
        //     if(is_uploaded_file($_FILES['attachmentFile']['tmp_name'])) 
        //     {
        //         $sourcePath = $_FILES['attachmentFile']['tmp_name'];
        //         $targetPath = "../attachments/".$_FILES['attachmentFile']['name'];
        //         if(move_uploaded_file($sourcePath,$targetPath)) {
        //             $mail->AddAttachment($targetPath); // Provide file path and name of the attachments 
        //         }
        //     }
        // }

        if(!empty($_FILES['attachmentFile'])) {
            $mail->addAttachment(
                $_FILES['attachmentFile']['tmp_name'],
                $_FILES['attachmentFile']['name']
            );
        }

        if(!$mail->Send()) {
            echo '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Sorry!</strong> Problem in contact us</div>';
        } else {
            echo "<div id='success_page'>";
            echo "<p>Thank you <strong>$name</strong> ($email). Your application has been submitted to us.</p>";
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
}
?>

