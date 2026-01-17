<?php
// mail_handler.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function sendVerificationMail($email, $kod) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kizilkayazat@gmail.com'; 
        $mail->Password   = 'ixuaooixcxpoaodj'; // Boşluksuz yazdığından emin ol
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('kizilkayazat@gmail.com', 'FORSY GİYİM');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'FORSY GIYIM - Dogrulama Kodunuz';
        $mail->Body    = "
            <div style='background-color: #000; font-family: Arial, sans-serif; padding: 40px; text-align: center; color: #fff;'>
                <div style='max-width: 500px; margin: 0 auto; background-color: #111; border: 1px solid #222; padding: 40px; border-radius: 8px;'>
                    <h1 style='font-family: \"Arial Black\", sans-serif; letter-spacing: 4px; border-bottom: 2px solid #E84D35; padding-bottom: 10px; display: inline-block; margin-bottom: 30px;'>FORSY GİYİM</h1>
                    
                    <p style='color: #aaa; font-size: 16px; margin-bottom: 30px;'>Forsy Giyim ailesine hoş geldiniz.<br>Hesabınızı doğrulamak için lütfen aşağıdaki kodu kullanın.</p>
                    
                    <div style='background-color: #000; border: 1px dashed #444; padding: 20px; font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #E84D35; margin-bottom: 30px;'>
                        $kod
                    </div>
                    
                    <p style='color: #666; font-size: 12px; margin-top: 40px;'>Bu e-postayı siz talep etmediyseniz lütfen dikkate almayınız.<br>&copy; 2026 Forsy Giyim</p>
                </div>
            </div>";

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
?>