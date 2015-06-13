<?php
require_once 'lib/common.inc';

$mailFrom = "hoge@gmail.com";
$mailTo = "lss.ken8927@gmail.com";
$subject = "test"
$message = "hoge";
$smtp_option = array(
    'From' => $mailFrom,
    'To' => array($mailTo)
);
$smtp  = new SmtpSender(SMTP_SERVER, $smtp_option);
$smtp->setSubject($subject);
if (! $smtp->sendMail($message)) {
    throw new Exception('Mail send failed.' . $smtp->error['errorMessage']);
}