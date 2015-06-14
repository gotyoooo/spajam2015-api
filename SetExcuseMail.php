<?php
require_once 'lib/common.inc';

$user_id          = $_GET['user_id'];
$excuse_mail_subject  = $_GET['excuse_mail_subject'];
$excuse_mail_message = $_GET['excuse_mail_message'];

$sql = "INSERT INTO excuse_mail(user_id,excuse_mail_subject,excuse_mail_message) VALUES(?,'?','?');";
$ret = array($user_id, $excuse_mail_subject, $excuse_mail_message);
$sql2 = "SELECT max(excuse_mail_id) as max_excuse_mail_id FROM excuse_mail WHERE user_id = ?";
$ret2 = array($user_id);
$sql3 = "INSERT INTO excuse_mail_rank(excuse_mail_id, request_num) VALUES(?, ?);";

$pdo = db_connect();
db_update_query($pdo, $sql, $ret);
$data_excuse_mail = db_select_query($pdo, $sql2, $ret2);
$excuse_mail_id = $data_excuse_mail[0]['max_excuse_mail_id'];
$ret3 = array($excuse_mail_id, 1);
db_update_query($pdo, $sql3, $ret3);
$pdo = null;

