<?php
require_once 'lib/common.inc';

$smtp_option = array(
    'From' => $mailFrom,
    'To' => array($mailTo)
);
$smtp  = new SmtpSender(SMTP_SERVER, $smtp_option);