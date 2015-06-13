<?php
require_once 'lib/common.inc';

$user_id          = $_GET['user_id'];
$excuse_mail_subject  = $_GET['excuse_mail_subject'];
$excuse_mail_message = $_GET['excuse_mail_message'];

$sql = "INSERT INTO excuse_mail(user_id,excuse_mail_subject,excuse_mail_message) VALUES(?,'?','?');";

$pdo = db_connect();
$ret = array($user_id, $excuse_mail_subject, $excuse_mail_message);
db_update_query($pdo, $sql, $ret);
$pdo = null;

