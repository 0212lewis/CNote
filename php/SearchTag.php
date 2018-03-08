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
    case 'getAllNoteNames':

        $username=$_GET['username'];
        $sql = "select note from notes where username = '{$username}'";
        $ret=$db->query($sql);
        $final = array();

        while($row=$ret->fetchArray(SQLITE3_ASSOC)) {
            $arr = array();
            array_push($arr,'"note":"'.$row['note'].'"');
            array_push($final,implode(',',$arr));
        }

        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }else{
            echo '{"errorCode":1}';
        }
        break;
    case 'getAllNotebookNames':

        $username=$_GET['username'];
        $sql = "select notebook from notebooks where username = '{$username}'";
        $ret=$db->query($sql);
        $final = array();

        while($row=$ret->fetchArray(SQLITE3_ASSOC)) {
            $arr = array();
            array_push($arr,'"notebook":"'.$row['notebook'].'"');
            array_push($final,implode(',',$arr));
        }

        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }else{
            echo '{"errorCode":1}';
        }
        break;

    case 'getNotes':

        $username=$_GET['username'];
        $notebook=$_GET['notebook'];
        $sql = "select note from notes where username = '{$username}' and notebook = '{$notebook}'";
        $ret=$db->query($sql);
        $final = array();

        while($row=$ret->fetchArray(SQLITE3_ASSOC)) {
            $arr = array();
            array_push($arr,'"noteNames":"'.$row['note'].'"');
            array_push($final,implode(',',$arr));
        }

        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }else{
            echo '{"errorCode":1}';
        }
        break;

    case 'createNewNoteTag':
        $username = $_GET['username'];
        $noteName = $_GET['noteName'];
        $notebook = $_GET['notebook'];
        $tag = $_GET['tag'];

        $sq="select tag from notes where username = '{$username}' and note = '{$noteName}' and notebook='{$notebook}' and note='{$noteName}'";
        $ret=$db->query($sq);
        $row=$ret->fetchArray(SQLITE3_ASSOC);
        $temp = $row['tag'];
        $tag = $tag.$temp;

        $sql = "update notes set tag = '{$tag}' where username = '{$username}' and notebook='{$notebook}' and note='{$noteName}'";
        $ret=$db->query($sql);
        if($ret){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;

    case 'createNewNotebookTag':
        $username = $_GET['username'];
        $notebook = $_GET['notebook'];
        $tag = $_GET['tag'];
        $sq="select tag from notebooks where username = '{$username}' and notebook='{$notebook}'";
        $ret=$db->query($sq);
        $row=$ret->fetchArray(SQLITE3_ASSOC);
        $temp = $row['tag'];
        $tag = $tag.$temp;
        $sql = "update notebooks set tag = '{$tag}' where username = '{$username}'and notebook='{$notebook}'";

        $ret=$db->query($sql);
        if($ret){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;

    case 'getAllNotes':

        $username = $_GET['username'];

        $sql = "select username,note,notebook,createTime,tag from notes where username = '{$username}'";

        $ret = $db->query($sql);
        $final = array();
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"note":"'.$row['note'].'"');
            array_push($arr,'"notebook":"'.$row['notebook'].'"');
            array_push($arr,'"createTime":"'.$row['createTime'].'"');
            array_push($arr,'"tag":"'.$row['tag'].'"');
            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"errorCode":1}';
        }
        break;
    case 'getAllNotebooks':

        $username = $_GET['username'];

        $sql = "select username,notebook,createTime,tag from notebooks where username = '{$username}'";

        $ret = $db->query($sql);
        $final = array();
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"notebook":"'.$row['notebook'].'"');
            array_push($arr,'"createTime":"'.$row['createTime'].'"');
            array_push($arr,'"tag":"'.$row['tag'].'"');
            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"errorCode":1}';
        }
        break;

}