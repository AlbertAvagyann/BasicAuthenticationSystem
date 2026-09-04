<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

function sendMail(string $toEmail, string $toName, string $subject, string $htmlBody): bool
{
    $config = require __DIR__ . '/../config/mail.php';
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        $mail->SMTPSecure = $config['encryption'];
        $mail->Port       = $config['port'];
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($toEmail, $toName);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        $mail->send();
        return true;
    } catch (PHPMailerException $e) {
        error_log('Mail send failed: ' . $mail->ErrorInfo);
        return false;
    }
}

function sendVerificationEmail(string $toEmail, string $toName, string $rawToken): bool
{
    $config = require __DIR__ . '/../config/mail.php';
    $link = rtrim($config['app_url'], '/') . '/features/verification/verify_email.php?token=' . urlencode($rawToken);
    $body = '<p>Hi ' . htmlspecialchars($toName) . ',</p>'
        . '<p>Confirm your email: <a href="' . htmlspecialchars($link) . '">Verify my email</a></p>'
        . '<p>This link expires in 60 minutes.</p>';
    return sendMail($toEmail, $toName, 'Verify your email address', $body);
}

function sendPasswordResetEmail(string $toEmail, string $toName, string $rawToken): bool
{
    $config = require __DIR__ . '/../config/mail.php';
    $link = rtrim($config['app_url'], '/') . '/features/password/reset_password.php?token=' . urlencode($rawToken);
    $body = '<p>Hi ' . htmlspecialchars($toName) . ',</p>'
        . '<p>Reset your password: <a href="' . htmlspecialchars($link) . '">Reset my password</a></p>'
        . '<p>This link expires in 30 minutes.</p>';
    return sendMail($toEmail, $toName, 'Reset your password', $body);
}