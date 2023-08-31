<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('phpmailer/src/Exception.php');
require('phpmailer/src/PHPMailer.php');
require('phpmailer/src/SMTP.php');

// send mail to customer ready for a delivery message.
class SendMail
{
    public function send_mail($email,$name)
    {
        $subject = "Ready for Delivery";
        $body = "
        <div style='border: 1px solid gray; border-radius: 5px;'>
		<p style='text-align: center;'>Bike Services</p>
		<hr>
        <p style='margin-left: 20px; margin-top: 30px;'>Dear $name,</p>
		<p style='margin-left: 20px; margin-top: 30px;'>Your bike is ready for a delivery. Please check your status.</p>
	</div>
	";
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'YOUR_EMAIL_ADDRESS';  
        $mail->Password = 'YOUR_APP_PASSWORD'; 
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('YOUR_EMAIL_ADDRESS');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}
