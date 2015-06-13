<?php
function __autoload($class_name) {
    $lib_path = './lib/';
    $class_file = $lib_path . $class_name . ".php";
    require_once $class_file;
}
require_once 'conf/common_config.php';

/*
 * MySQLデータベースに接続する
 *
 * @return resource
 */
function db_connect() {
    try {
        $pdo = new PDO(
                       DB_TYPE . ':host=' . DB_SERV .'; dbname=' . DB_NAME,
                       DB_USER, DB_PASS
                   );
        $pdo->query('SET NAMES utf8');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return $pdo;
    } catch(PDOException $e) {
        return false;
    }
}

/*
 * MySQLデータベースを参照する
 *
 * @param  resource $pdo DB接続リソース
 * @param  string   $sql 実行SQL
 * @param  array    $ret 挿入データ
 * @return array
 */
function db_select_query($pdo, $sql, $ret) {
    //var_dump($ret);
    //print $sql . '<br>';
    try {
        $sth = $pdo->prepare($sql);
        $sth->execute($ret);
    } catch(PDOException $e) {
        return false;
    }
    return  $sth->fetchAll();
}

/*
 * MySQLデータベースを1行更新する
 *
 * @param  resource $pdo DB接続リソース
 * @param  string   $sql 実行SQL
 * @param  array    $ret 挿入データ
 * @return array
 */
function db_update_query($pdo, $sql, $ret) {
    //var_dump($ret);
    //print $sql . '<br>';
    try {
        $sth = $pdo->prepare($sql);

        for ( $i = 0; $i < count($ret); $i++ ) {

            $sth->bindParam($i + 1, $return[$i]);
        }
        $sth->execute($ret);
    } catch(PDOException $e) {
        return false;
    }
    return  true;
}