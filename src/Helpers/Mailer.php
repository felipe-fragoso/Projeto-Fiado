<?php

namespace Fiado\Helpers;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param string $altBody
     */
    public static function sendEmail(string $from, string $to, string $subject, string $body, string $altBody = '')
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = $_SERVER["SMTP_HOST"];
            $mail->SMTPAuth = true;
            $mail->Port = $_SERVER["SMTP_PORT"];
            $mail->Username = $_SERVER["SMTP_USER"];
            $mail->Password = $_SERVER["SMTP_PASS"];
            $mail->CharSet = $_SERVER["SMTP_CHARSET"];

            //Recipients
            $mail->setFrom($from);
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $altBody;

            $mail->send();

            return true;
        } catch (\Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    /**
     * @param string $name
     * @param array $data
     */
    public static function template(string $name, array $data)
    {
        if (file_exists($_SERVER["VIEWPATH"] . '/templates/' . $name . '.php')) {
            extract($data);

            return include $_SERVER["VIEWPATH"] . '/templates/' . $name . '.php';
        }

        return null;
    }
}