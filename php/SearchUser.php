<?php
/**
 * Created by IntelliJ IDEA.
 * User: pc
 * Date: 2017/12/7
 * Time: 16:35
 */
header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

$username = $_GET['username'];
$act = $_GET['act'];
include 'ConnectSQLite.php';

switch ($act){
    case 'search':
        $sql = "select username from account where username = '{$username}'";

        $ret = $db->query($sql);
        $final = array();
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"errorCode":1}';
        }
        break;
    case 'concern':
        $concernUser = $_GET['concernUser'];
        $sql = "insert into concern(username,concernUser) values('".$username."','".$concernUser."')";

        $ret = $db->query($sql);

        if($ret){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
}