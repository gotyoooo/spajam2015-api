<?php
require_once 'lib/common.inc';

$pdo = db_connect();
$sql = 'SELECT a.excuse_mail_id as excuse_mail_id,excuse_mail_subject,excuse_mail_message,request_num FROM excuse_mail as a LEFT OUTER JOIN excuse_mail_rank as b ON a.excuse_mail_id = b.excuse_mail_id ORDER BY request_num DESC LIMIT 10;';
$ret = array();
$data_excuse_mail = db_select_query($pdo, $sql, $ret);

//JSONにエンコード
$json = json_encode($data_excuse_mail);

//JSON形式で吐き出す
header( 'Content-Type: text/json; charset=utf-8' );
header("Access-Control-Allow-Origin:*");
echo $json;