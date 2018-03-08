<?php
/**
 * Created by IntelliJ IDEA.
 * User: pc
 * Date: 2017/11/17
 * Time: 0:53
 */
header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

include 'ConnectSQLite.php';

$act=$_GET['act'];

switch ($act){
    case 'getAllNotes':

        $username = $_GET['username'];
        $notebook = $_GET['notebook'];

        $sql = "select username,note,notebook,createTime from notes where username = '{$username}' and notebook = '{$notebook}'";

        $ret = $db->query($sql);
        $final = array();
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"note":"'.$row['note'].'"');
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
    case 'deleteNote':

        $username = $_GET['username'];
        $deleteNoteName = $_GET['deleteNoteName'];
        $notebookName = $_GET['notebookName'];
        $createTime = $_GET['createTime'];
        $deleteTime = $_GET['deleteTime'];

        $temp = "select content from notes where username = '{$username}' and note = '{$deleteNoteName}'";
        $sql1 = "delete from notes where username = '{$username}' and notebook = '{$notebookName}' and note = '{$deleteNoteName}'";
        $ret = $db->query($temp);
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $content = $row['content'];
            $db->query("insert into trashNotes(username,notebook,note,createTime,deleteTime,content,tag) values ('".$username."','".$notebookName."','".$deleteNoteName."','".$createTime."','".$deleteTime."','".$content."')","");
        }
        $exec1 = $db->query($sql1);

        if($exec1){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }

        break;
}