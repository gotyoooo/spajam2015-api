<?php
require_once 'lib/common.inc';
$excuse_tel_id = $_GET['excuse_tel_id'];

$sql = "SELECT request_num FROM excuse_tel_rank WHERE excuse_tel_id = ?";
$ret = array($excuse_tel_id);

$sql2 = "UPDATE excuse_tel_rank SET request_num = ? WHERE excuse_tel_id = ?";

$pdo = db_connect();
$data_excuse_tel_rank_request_num = db_select_query($pdo, $sql, $ret);
$request_num = $data_excuse_tel_rank_request_num[0]['request_num'] + 1;
$ret2 = array($excuse_tel_id, $request_num);
db_update_query($pdo, $sql2, $ret2);
$pdo = null;
header("Access-Control-Allow-Origin:*");