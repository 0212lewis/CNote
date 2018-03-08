<?php
/**
 * Created by IntelliJ IDEA.
 * User: pc
 * Date: 2017/11/19
 * Time: 13:35
 */

header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

include 'ConnectSQLite.php';

$act = $_GET['act'];

switch ($act){
    case 'getNoteDetail':

        $username = $_GET['username'];
        $notebook = $_GET['notebook'];
        $note = $_GET['note'];

        $sql = "select content from notes where username = '{$username}' and notebook = '{$notebook}' and note = '{$note}'";
        $ret = $db->query($sql);
        $row=$ret->fetchArray(SQLITE3_ASSOC);
        $content =$row['content'];

            echo $content;
        break;

    case 'saveNote':

        $username = $_GET['username'];
        $note = $_GET['note'];
        $notebook = $_GET['notebook'];
        $content = $_GET['content'];
        $createTime = $_GET['createTime'];
//        $sql = "select tag from notes where username = '{$username}' and notebook = '{$notebook}' and note = '{$note}'";
//        $ret = $db->query($sql);
//        $row=$ret->fetchArray(SQLITE3_ASSOC);
//        $tag = $row['tag'];
        $sql = "update notes set content = '{$content}' where username = '{$username}' and note = '$note' and notebook = '$notebook'";

        $ret=$db->query($sql);

        if($ret){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;
}