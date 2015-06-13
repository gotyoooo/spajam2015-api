<?php
require_once 'lib/common.inc';

$user_id          = $_GET['user_id'];
$excuse_tel_name  = $_GET['excuse_tel_name'];
$excuse_tel_group = $_GET['excuse_tel_group'];

$sql = "INSERT INTO excuse_tel(user_id,excuse_tel_name,excuse_tel_group) VALUES(?,'?','?');";

$pdo = db_connect();
$ret = array($user_id, $excuse_tel_name, $excuse_tel_group);
db_update_query($pdo, $sql, $ret);
$pdo = null;

