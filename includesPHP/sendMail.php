<?php

function sendMail($email,$body,$subject)
{
    $mailto = $email;
    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail->IsSmtp();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(false);
    $mail->Username = "email";
    $mail->Password = "password";
    $mail->SetFrom("clubStack");
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($mailto);

    if (!$mail->Send()) {
        echo "Mail Could  Not be Sent";
        die();
    } else {
        ;
    }
}
?>