<?php
/**
 * Created by IntelliJ IDEA.
 * User: pc
 * Date: 2017/11/16
 * Time: 16:14
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

        $sql = "select * from notebooks where username = '{$username}'";

        $ret = $db->query($sql);
        $final = array();
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"notebook":"'.$row['notebook'].'"');
            array_push($arr,'"createTime":"'.$row['createTime'].'"');
            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"errorCode":1}';
        }
        break;

    case 'deleteNotebook':

        $username = $_GET['username'];
        $notebook = $_GET['deleteNotebookName'];
        $createTime = $_GET['createTime'];
        $deleteTime = $_GET['deleteTime'];

        $sql = "delete from notebooks where username = '{$username}' and notebook = '{$notebook}'";

        $sql1 = "delete from notes where username = '{$username}' and notebook = '{$notebook}'";

        $sql2 = "insert into trashNotebooks(username,notebook,createTime,deleteTime) values ('".$username."','".$notebook."','".$createTime."','".$deleteTime."')";

        $temp = "select note,content from notes where username = '{$username}' and notebook = '{$notebook}'";

        $ret = $db->query($temp);

        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $note = $row['note'];
            $content = $row['content'];
            $db->query("insert into trashNotes(username,notebook,note,createTime,deleteTime,content) values ('".$username."','".$notebook."','".$note."','".$createTime."','".$deleteTime."','".$content."')");
        }

        $exec1 = $db->query($sql);
        $exec2 = $db->query($sql1);
        $exec3 = $db->query($sql2);

        if($exec1&&$exec2&&$sql2){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }

        break;

    case 'createNewNotebook':
        $username = $_GET['username'];
        $newNotebookName = $_GET['newNotebookName'];
        $createTime = $_GET['createTime'];
        $sql = "insert into notebooks(username,notebook,createTime,tag)  values('".$username."','".$newNotebookName."','".$createTime."','')";

        $ret=$db->query($sql);
        if($ret){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;


}