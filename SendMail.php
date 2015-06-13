<?php
require_once 'common.inc';

$smtp_option = array(
    'From' => $mailFrom,
    'To' => array($mailTo)
);
$obj  = new SmtpSender('localhost', $smtp_option);