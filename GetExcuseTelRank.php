<?php
require_once 'lib/common.inc';

$pdo = db_connect();
$sql = 'SELECT a.excuse_tel_id as excuse_tel_id,excuse_tel_name,excuse_tel_group,request_num FROM excuse_tel as a LEFT OUTER JOIN excuse_tel_rank as b ON a.excuse_tel_id = b.excuse_tel_id ORDER BY request_num DESC LIMIT 10;';
$ret = array();
$data_excuse_tel = db_select_query($pdo, $sql, $ret);

//JSONにエンコード
$json = json_encode($data_excuse_tel);

//JSON形式で吐き出す
header( 'Content-Type: text/json; charset=utf-8' );
header("Access-Control-Allow-Origin:*");
echo $json;