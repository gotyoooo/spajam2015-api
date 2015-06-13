<?php
require_once 'lib/common.inc';
$excuse_mail_id = $_GET['excuse_mail_id'];

$sql = "SELECT request_num FROM excuse_mail_rank WHERE excuse_mail_id = ?";
$ret = array($excuse_mail_id);

$sql2 = "UPDATE excuse_mail_rank SET request_num = ? WHERE excuse_mail_id = ?";

$pdo = db_connect();
$data_excuse_mail_rank_request_num = db_select_query($pdo, $sql, $ret);
$request_num = $data_excuse_mail_rank_request_num[0]['request_num'] + 1;
$ret2 = array($excuse_mail_id, $request_num);
db_update_query($pdo, $sql3, $ret3);
$pdo = null;
