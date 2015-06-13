<?php
require_once 'lib/common.inc';

$pdo = db_connect();
$sql = 'SELECT excuse_mail_subject,excuse_mail_message FROM excuse_mail ORDER BY excuse_mail_id DESC LIMIT 10;';
$ret = array();
$data_excuse_mail = db_select_query($pdo, $sql, $ret);

//JSONにエンコード
$json = json_encode($data_excuse_mail);

//JSON形式で吐き出す
header( 'Content-Type: text/json; charset=utf-8' );
echo $json;