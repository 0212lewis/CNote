<?php
/**
 * Created by cyz.
 * User: pc
 * Date: 2017/11/16
 * Time: 16:07
 */

header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

include 'ConnectSQLite.php';

$act=$_GET['act'];

switch ($act){
    case 'getAllNotebooks':

        $username = $_GET['username'];

        $sql = "select username,notebook from notebooks where username = '{$username}'";
        $ret = $db->query($sql);
        $final = array();
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"notebook":"'.$row['notebook'].'"');

            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"error":0}';
        }
        break;

    case 'getNoteNames':

        $username=$_GET['username'];
        $notebook = $_GET['notebook'];
        $sql = "select note from notes where username = '{$username}' and notebook = '{$notebook}'";
        $ret=$db->query($sql);
        $final = array();

        while($row=$ret->fetchArray(SQLITE3_ASSOC)) {
            $arr = array();
            array_push($arr,'"noteName":"'.$row['note'].'"');
            array_push($final,implode(',',$arr));
        }

        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }else{
            echo '{"errorCode":1}';
        }
        break;






}