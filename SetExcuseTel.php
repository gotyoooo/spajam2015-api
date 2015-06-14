<?php
require_once 'lib/common.inc';

$user_id          = $_GET['user_id'];
$excuse_tel_name  = $_GET['excuse_tel_name'];
$excuse_tel_group = $_GET['excuse_tel_group'];

$sql = "INSERT INTO excuse_tel(user_id,excuse_tel_name,excuse_tel_group) VALUES(?,'?','?');";
$ret = array($user_id, $excuse_tel_name, $excuse_tel_group);
$sql2 = "SELECT max(excuse_tel_id) as max_excuse_tel_id FROM excuse_tel WHERE user_id = ?";
$ret2 = array($user_id);
$sql3 = "INSERT INTO excuse_tel_rank(excuse_tel_id, request_num) VALUES(?, ?);";

$pdo = db_connect();
db_update_query($pdo, $sql, $ret);
$data_excuse_tel = db_select_query($pdo, $sql2, $ret2);
$excuse_tel_id = $data_excuse_tel[0]['max_excuse_tel_id'];
$ret3 = array($excuse_tel_id, 1);
db_update_query($pdo, $sql3, $ret3);
$pdo = null;
