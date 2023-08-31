<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('phpmailer/src/Exception.php');
require('phpmailer/src/PHPMailer.php');
require('phpmailer/src/SMTP.php');

class SendMail
{
    // send mail verfication link customer
    public function send_mail($email, $token)
    {
        $subject = "Email verfication";
        $body = "
        <div style='border: 1px solid gray; border-radius: 5px;'>
		<p style='text-align: center;'>Bike Services</p>
		<h3 style='text-align: center;'>Verfication email</h3>
		<hr>
		<p style='margin-left: 20px; margin-top: 30px;'>Please use the verfication link below to click verify email</p>
		<a href='http://localhost/bike-service/email-verification?token=$token' style='margin-left: 20px; margin-top: 30px; font-size: 14px;'>Click here</a>
		<p style='margin-left: 20px;'>Don't share link with anyone.This link expire with in 15 minutes</p>
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

    // if book service customer send mail to admin.
    public function order_send($email,$customer_name,$phone,$name,$price,$date,$admin_email){
        $subject = "Booking Service Order";
        $body = "
        <div style='border: 1px solid gray; border-radius: 5px;'>
		<p style='text-align: center;'>Bike Services</p>
		<h3 style='text-align: center;'>Order From $customer_name</h3>
		<hr>
		<p style='margin-left: 50px; margin-top: 30px;'>Order Datails</p>
		<p style='margin-left: 20px; margin-top: 30px;'>Name: <b>$customer_name</b></p>
        <p style='margin-left: 20px; margin-top: 30px;'>Email: <b>$email</b></p>
        <p style='margin-left: 20px; margin-top: 30px;'>Phone no: <b>$phone</b></p>
        <p style='margin-left: 20px; margin-top: 30px;'>Service Name: <b>$name</b></p>
        <p style='margin-left: 20px; margin-top: 30px;'>Service Price: <b>$price</b></p>
        <p style='margin-left: 20px; margin-top: 30px;'>Order Date: <b>$date</b></p>
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
        $mail->addAddress($admin_email);
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
