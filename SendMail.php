<?php
require_once 'lib/common.inc';

$mail_from = $_GET['mail_from'];
$mail_to   = $_GET['mail_to'];
$subject   = $_GET['subject'];
$message   = $_GET['message'];

$smtp_option = array(
    'From' => $mail_from,
    'To' => array($mail_to)
);
$smtp  = new SmtpSender(SMTP_SERVER, $smtp_option);
$smtp->setSubject($subject);
if (! $smtp->sendMail($message)) {
    throw new Exception('Mail send failed.' . $smtp->error['errorMessage']);
}