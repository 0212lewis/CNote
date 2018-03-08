<?php
/**
 * Created by IntelliJ IDEA.
 * User: pc
 * Date: 2017/11/16
 * Time: 19:27
 */
header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

include 'ConnectSQLite.php';

$act=$_GET['act'];

//$content = $_POST['editor1'];
switch ($act){

    case 'saveCreate':

        $username = $_GET['username'];
        $note = $_GET['noteName'];
        $notebook = $_GET['notebook'];
        $content = $_GET['content'];
        $createTime = $_GET['createTime'];
        $tag = "";
        $sql = "insert into notes(username,notebook,note,createTime,content,tag) values('".$username."','".$notebook."','".$note."','".$createTime."','".$content."','".$tag."')";

        $ret=$db->query($sql);

        if($ret){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;
}