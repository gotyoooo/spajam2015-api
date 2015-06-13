<?php
require_once 'lib/common.inc';

$pdo = db_connect();
$sql = 'SELECT excuse_tel_name,excuse_tel_group FROM excuse_tel ORDER BY excuse_tel_id DESC LIMIT 10;';
$ret = array();
$data_excuse_tel = db_select_query($pdo, $sql, $ret);

//JSONにエンコード
$json = json_encode($data_excuse_tel);

//JSON形式で吐き出す
header( 'Content-Type: text/json; charset=utf-8' );
header("Access-Control-Allow-Origin:*");
echo $json;