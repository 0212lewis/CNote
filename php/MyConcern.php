<?php
/**
 * Created by IntelliJ IDEA.
 * User: pc
 * Date: 2017/12/6
 * Time: 11:13
 */

include 'ConnectSQLite.php';

$username = $_GET['username'];

$act = $_GET['act'];

switch ($act){
    case 'getAllConcernUsers':
        $sql = "select * from concern where username = '{$username}'";

        $ret = $db->query($sql);
        $final = array();
        while($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');

            array_push($arr,'"concernUser":"'.$row['concernUser'].'"');
            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"errorCode":1}';
        }
        break;

    case 'deleteConcern':
        $concernUser = $_GET['concernUser'];
        $sql = "delete from concern where username = '{$username}' and concernUser = '{$concernUser}'";
        $ret = $db->query($sql);
        if($ret){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;
    case 'share':
        $noteName = $_GET['note'];
        $notebook = $_GET['notebook'];
        $concernUser = $_GET['concernUser'];

        $sql = "insert into shareNotes(username,concernUser,note,notebook) values('".$username."','".$concernUser."','".$noteName."','".$notebook."')";
        $ret = $db->query($sql);

        if($ret){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;
}