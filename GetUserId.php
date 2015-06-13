<?php
require_once 'lib/common.inc';

$pdo = db_connect();
$sql = 'SELECT MAX(user_id) AS MAX_ID FROM user;';
$ret = array();
$max_user_id = db_select_query($pdo, $sql, $ret);

$new_user_id = $max_user_id['MAX_ID'];

$return = array();
$return['user_id'] = $new_user_id;

//JSONにエンコード
$json = json_encode( $return );

//JSON形式で吐き出す
header( 'Content-Type: text/javascript; charset=utf-8' );
echo $json;