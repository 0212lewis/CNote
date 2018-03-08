<?php
/**
 * Created by cyz.
 * User: pc
 * Date: 2017/11/15
 * Time: 19:39
 */
header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

include 'ConnectSQLite.php';

$act=$_GET['act'];

switch ($act){

    case 'getAllManagers':

        $authority="0";
        $sql = "select * from accountInfo where authority = '{$authority}'";
        $ret = $db->query($sql);
        $final = array();
        if($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"sex":"'.$row['sex'].'"');
            array_push($arr,'"phone":"'.$row['phone'].'"');
            array_push($arr,'"email":"'.$row['email'].'"');
            array_push($arr,'"address":"'.$row['address'].'"');
            array_push($arr,'"unit":"'.$row['unit'].'"');
            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"error":0}';
        }
        break;
    case 'getAllUsers':

        $authority="1";
        $sql = "select * from accountInfo where authority = '{$authority}'";
        $ret = $db->query($sql);
        $final = array();
        if($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"sex":"'.$row['sex'].'"');
            array_push($arr,'"phone":"'.$row['phone'].'"');
            array_push($arr,'"email":"'.$row['email'].'"');
            array_push($arr,'"address":"'.$row['address'].'"');
            array_push($arr,'"unit":"'.$row['unit'].'"');
            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"error":0}';
        }
        break;

    case 'deleteAccount':
        $deleteName = $_GET['deleteName'];
        $sql = "delete from accountInfo where username = '{$deleteName}'";
        $sql1 = "delete from account where username = '{$deleteName}'";

        $exec1 = $db->query($sql);
        $exec2 = $db->query($sql1);

        if($exec1&&$exec2){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }

}