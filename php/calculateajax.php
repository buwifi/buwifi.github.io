<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require 'config.php';
require 'configyandex.php';
require 'vendor/autoload.php';

$mail = new PHPMailer(true);


if (!isset($_POST['subject'])) {
    $subject = "Estimates from Junivo";
} else {
    $subject = $_POST['subject'];
}

reset($_POST);

$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
             <html>
             <head>
             <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
             <title>Sigma-email</title>
             </head>
             <body>
             <table border="0" cellpadding="0" cellspacing="0"
                    style="border-collapse: separate; mso-table-lspace: 0; mso-table-rspace: 0; width: 100%; padding-bottom: 64px;
                    box-sizing: border-box; min-width: 100% !important; background-color: #fafcff" bgcolor="#fafcff"
                    width="100%">
               <tr>
                 <td align="center" style="vertical-align: top; padding-top: 60px;" valign="top">
                   <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0;
                   mso-table-rspace: 0; width: 100%; max-width: 560px; background-color: #ffffff; border: solid 2px #ceddf2;
                    padding-top: 32px; padding-left: 8px; padding-right: 8px; padding-bottom: 20px" bgcolor="#ffffff">
                     <tr>
                       <td style="height: 85px; background: url(\'http://previews.aspirity.com/sigma/assets/img/Sigma_logo.png\');
                           background-position: center; background-repeat: no-repeat; background-size: contain;"
                           valign="top" height="85px">
                       </td>
                     </tr>
                     <tr>
                       <td style="font-family: sans-serif; font-size: 18px; vertical-align: top; text-align: center; color: #7d93b2;
                           padding-top: 36px" valign="top" align="center">Your custom plan is here!
                       </td>
                     </tr>
                     <tr>
                       <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align: center; color: #9eb4d2;
                           padding-top: 20px" valign="top" align="center">Thanks for using Sigma
                       </td>
                     </tr>';

    $body .= $_POST['bill'];

	$body .= '<tr>
                <td style="vertical-align: top; padding-top: 36px;" valign="top" align="center">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0;
                    mso-table-rspace: 0; width: 100%; max-width: 400px;">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align: center;
                        color: #9eb4d2;" valign="top" align="center">
                        If you decide to go ahead and build your custom plan, we would love the opportunity to talk about how
                        we can help :-)
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align: center; color: #9eb4d2;
                    padding-top: 20px; max-width: 400px;" valign="top" align="center">Click
                  <a href="" target="_blank" style="color: #ff5c72; text-decoration: none;"><b>here</b></a> to contact Sigma
                  about building your plan.
                </td>
              </tr>
              <tr>
                <td style="font-family: sans-serif; font-size: 24px; vertical-align: top; text-align: center;
                    padding-top: 36px; max-width: 400px;" valign="top" align="center">
                  <a href="" target="_blank" style="text-decoration: none !important; display: inline-block; padding-top: 20px;
                      padding-bottom: 20px; padding-right: 32px; padding-left: 32px; color: #ffffff; background-color: #ff5c72;
                      border-radius: 8px;">Get the Sigma</a></td>
              </tr>
              <tr>
                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align: center; color: #9eb4d2;
                    padding-top: 68px; max-width: 400px;" valign="top" align="center">PS. Checkout another great
                  <a href="http://themes.aspirity.com/" target="_blank" style="color: #ff5c72; text-decoration: none;">
                    Aspirity templates</a>.
                </td>
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
        // $mail->SetFrom(CONFIG['email']['ToAddress'], $name);
        // $mail->AddReplyTo($email, $name);
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
?>

