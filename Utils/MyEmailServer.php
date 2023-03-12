<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('EmailServerInterface.php');

class MyEmailServer implements EmailServerInterface {
    private $to;
    private $subject;
    private $message;

    public function setTo($to) {
        $this->to = $to;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getStatus() {
        return 'OK';
    }

    public function sendEmail($to, $subject, $message) {
        require 'vendor/phpmailer/phpmailer/src/Exception.php';
        require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require 'vendor/phpmailer/phpmailer/src/SMTP.php';

        $mail = new PHPMailer();

        $mail->SMTPDebug = FALSE; // Enable verbose debug output
        $mail->isSMTP(); // gửi mail SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'thiennbnk@gmail.com'; // SMTP username
        $mail->Password = 'irzrdytodungadin'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port = 587; // TCP port to connect to
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('thiennbnk@gmail.com', 'Thien35');
        $mail->addAddress($this->to);
        $mail->Subject = $this->subject;
        $mail->Body = $this->message;

        if (!$mail->send()) {
            throw new Exception('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }
    }
}
