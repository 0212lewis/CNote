<?php
/**
 * Created by IntelliJ IDEA.
 * User: pc
 * Date: 2017/11/17
 * Time: 18:42
 */
header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

include 'ConnectSQLite.php';

$act = $_GET['act'];

switch ($act){
    case 'getAllDeleteNotebooks':
        $username = $_GET['username'];

        $sql = "select username,notebook,createTime,deleteTime from trashNotebooks where username = '{$username}'";
        $ret = $db->query($sql);
        $final = array();
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"notebook":"'.$row['notebook'].'"');
            array_push($arr,'"createTime":"'.$row['createTime'].'"');
            array_push($arr,'"deleteTime":"'.$row['deleteTime'].'"');
            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"errorCode":1}';
        }
        break;


    case 'getAllDeleteNotes':
        $username = $_GET['username'];

        $sql = "select username,note,notebook,createTime,deleteTime,content from trashNotes where username = '{$username}'";
        $ret = $db->query($sql);
        $final = array();
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"notebook":"'.$row['notebook'].'"');
            array_push($arr,'"note":"'.$row['note'].'"');
            array_push($arr,'"createTime":"'.$row['createTime'].'"');
            array_push($arr,'"deleteTime":"'.$row['deleteTime'].'"');
            array_push($arr,'"content":"'.$row['content'].'"');
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

        $sql = "delete from trashNotes where username = '{$username}' and note = '{$deleteNoteName}'";
        $exec1 = $db->query($sql);
        if($exec1){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;

    case 'recoverNotebook':
        $username = $_GET['username'];
        $recoverNotebook = $_GET['recoverNotebook'];
        $recoverCreateTime = $_GET['recoverCreateTime'];

        $sql = "select * from trashNotes where username = '{$username}' and notebook = '{$recoverNotebook}'";
        $ret = $db->query($sql);
       while($row=$ret->fetchArray(SQLITE3_ASSOC)){
           $user = $row['username'];
           $notebook = $row['notebook'];
           $note = $row['note'];
           $createTime = $row['createTime'];
           $content = $row['content'];

           $db->query("insert into notes(username,notebook,note,createTime,content,tag) values ('".$user."','".$notebook."','".$note."','".$createTime."','".$content."')",'');
       }

        $sql1 = "insert into notebooks(username,notebook,createTime,tag) values ('".$username."','".$recoverNotebook."','".$recoverCreateTime."','')";
        $sql2 = "insert into notebooks(username,notebook,createTime,tag) values ('".$username."','".$recoverNotebook."','".$recoverCreateTime."','')";

        $sql3 = "delete from trashNotebooks where username = '{$username}' and notebook = '{$recoverNotebook}'";
        $sql4 = "delete from trashNotes where username = '{$username}' and notebook = '{$recoverNotebook}'";

        $exec1 = $db->query($sql);
        $exec2 = $db->query($sql2);
        $exec3 = $db->query($sql3);
        $exec4 = $db->query($sql4);

        if($exec1&&$exec3&&$exec4){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;

    case 'recoverNote':
        $username = $_GET['username'];
        $recoverNotebook = $_GET['recoverNotebook'];
        $recoverNote = $_GET['recoverNote'];
        $recoverCreateTime = $_GET['recoverCreateTime'];

        $sql = "select content from trashNotes where username = '{$username}' and notebook = '{$recoverNotebook}'and note = '{$recoverNote}'";
        $ret = $db->query($sql);
        $row=$ret->fetchArray(SQLITE3_ASSOC);
            $content = $row['content'];
        $exec2 =  $db->query("insert into notes(username,notebook,note,createTime,content,tag) values ('".$username."','".$recoverNotebook."','".$recoverNote."','".$recoverCreateTime."','".$content."')",'');

        $sql = "delete from trashNotes where username = '{$username}' and notebook = '{$recoverNotebook}' and note = '{$recoverNote}'";
        $exec = $db->query($sql);
        if($exec&&$exec2){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;


}