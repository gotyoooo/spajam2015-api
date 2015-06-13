<?php
require_once 'lib/common.inc';

$pdo = db_connect();
$sql = 'SELECT MAX(user_id) FROM user;';
$ret = array();
$max_user_id = db_select_query($pdo, $sql, $ret);

var_dump($max_user_id);