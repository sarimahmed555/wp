<?php
/**
 * PHPMailer implementation for the pet service form
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send email using PHPMailer
function petcare_send_email($to, $subject, $message, $attachments = array()) {
    // Include PHPMailer
    require_once get_template_directory() . '/vendor/phpmailer/src/Exception.php';
    require_once get_template_directory() . '/vendor/phpmailer/src/PHPMailer.php';
    require_once get_template_directory() . '/vendor/phpmailer/src/SMTP.php';
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = get_option('petcare_smtp_host', 'smtp.example.com');
        $mail->SMTPAuth = true;
        $mail->Username = get_option('petcare_smtp_username', '');
        $mail->Password = get_option('petcare_smtp_password', '');
        
        // Set encryption type
        $encryption = get_option('petcare_smtp_encryption', 'tls');
        if ($encryption === 'tls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } elseif ($encryption === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = '';
            $mail->SMTPAutoTLS = false;
        }
        
        $mail->Port = get_option('petcare_smtp_port', 587);
        
        // Recipients
        $mail->setFrom(
            get_option('petcare_from_email', get_option('admin_email')),
            get_option('petcare_from_name', get_bloginfo('name'))
        );
        $mail->addAddress($to);
        $mail->addReplyTo(get_option('petcare_from_email', get_option('admin_email')));
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        
        // Convert plain text message to HTML
        $html_message = nl2br($message);
        $mail->Body = $html_message;
        $mail->AltBody = strip_tags($message);
        
        // Add attachments
        if (!empty($attachments) && is_array($attachments)) {
            foreach ($attachments as $attachment) {
                if (file_exists($attachment['path'])) {
                    $mail->addAttachment(
                        $attachment['path'],
                        $attachment['name'],
                        PHPMailer::ENCODING_BASE64,
                        $attachment['type']
                    );
                }
            }
        }
        
        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the error
        error_log('PHPMailer Error: ' . $mail->ErrorInfo);
        return false;
    }
}