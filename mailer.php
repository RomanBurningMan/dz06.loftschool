<?php
/**
 * Created by PhpStorm.
 * User: пользователь
 * Date: 25.11.2017
 * Time: 11:38
 */

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer {
    public $email;
    public $name;
    public $subject;
    public $htmlForMail;
    public $simpleMail;

    public function __construct($email, $name, $subject, $htmlForMail, $simpleMail)
    {
        $this->email = $email;
        $this->name = $name;
        $this->subject = $subject;
        $this->htmlForMail = $htmlForMail;
        $this->simpleMail = $simpleMail;
    }

    public function sendMail()
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'bro4test4bro@gmail.com';                 // SMTP username
            $mail->Password = 'qwertyuiop123456789';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('bro4test4bro@gmail.com', 'Your best friend!');
            $mail->addAddress($this->email, $this->name);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('bro4test4bro@gmail.com', 'Reply');
        //    $mail->addCC('cc@example.com');
        //    $mail->addBCC('bcc@example.com');
            $mail->CharSet = 'UTF-8';
            //Attachments
            //$mail->addAttachment('img/my_photo.jpg', '1.jpg');         // Add attachments
        //    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->subject;
            $mail->Body    = $this->htmlForMail;
            $mail->AltBody = $this->simpleMail;

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
