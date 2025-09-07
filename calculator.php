<?php
	$emailTo = $_POST['email'];

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: <murate@gmail.com>\r\n"; //enter your email

	if (!isset($_POST['subject'])) {
		$subject = "Estimates from Sigma"; // Enter your subject here
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

	if( mail($emailTo, $subject, $body, $headers) ){
		$mail_sent = true;
	} else {
		$mail_sent = false;
	}
?>