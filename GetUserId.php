<?php
require_once 'lib/common.inc';

$pdo = db_connect();
$sql = 'SELECT MAX(user_id) AS MAX_ID FROM user;';
$ret = array();
$max_user_id = db_select_query($pdo, $sql, $ret);

$new_user_id = $max_user_id[0]['MAX_ID'] + 1;

$sql = 'INSERT INTO user(user_id) VALUES(?);';
$ret = array($new_user_id);
db_update_query($pdo, $sql, $ret);
$pdo = null;

$return = array();
$return['user_id'] = $new_user_id;

//JSONにエンコード
$json = json_encode( $return );

//JSON形式で吐き出す
header( 'Content-Type: text/javascript; charset=utf-8' );
echo $json;