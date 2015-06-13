<?php
require_once 'lib/common.inc';

$mail_from = "hoge@gmail.com";
$mail_to = "lss.ken.gotyoooo@ezweb.ne.jp";
$subject = "test";
$message = "hoge";

$smtp_option = array(
    'From' => $mail_from,
    'To' => array($mail_to)
);
$smtp  = new SmtpSender(SMTP_SERVER, $smtp_option);
$smtp->setSubject($subject);
if (! $smtp->sendMail($message)) {
    throw new Exception('Mail send failed.' . $smtp->error['errorMessage']);
}