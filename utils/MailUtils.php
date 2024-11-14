<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class MailUtils {
    public static function sendEmail($to, $subject, $body) {
        $mail = new PHPMailer(true);
        
        try {
            // Configuration du serveur SMTP pour Mailjet
            $mail->isSMTP();
            $mail->Host = 'in-v3.mailjet.com';
            $mail->SMTPAuth = true;
            $mail->Username = '2c32017dbc718fb8a119429c85e34fee'; // Clé API publique Mailjet
            $mail->Password = '16d1bb1c89c7fdd39a47b1acf4c1224d'; // Clé API privée Mailjet
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Définition de l'expéditeur et du destinataire
            $mail->setFrom('zooarcadianord@gmail.com', 'Zoo Arcadia');
            $mail->addAddress($to);

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Envoi de l'email
            $mail->send();
            return 'Email envoyé avec succès!';
        } catch (Exception $e) {
            return "Le message n'a pas pu être envoyé. Erreur de PHPMailer: {$mail->ErrorInfo}";
        }
    }
}
?>