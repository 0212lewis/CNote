<?php
/**
 * Created by cyz
 * User: pc
 * Date: 2017/11/14
 * Time: 19:33
 */
header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

include 'ConnectSQLite.php';

$act=$_GET['act'];

switch ($act){
    case 'getAuthority':
        $username = $_GET['username'];
        $sql = "select authority from account where username='{$username}'";
        $ret=$db->query($sql);
        $final = array();
        if($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"authority":"'.$row['authority'].'"');
            array_push($final,implode(',',$arr));
        }
        if(count($final)>0){
//            echo '[{'.implode('},{',$final).'}]';
            echo $row['authority'];
        }
        else{
            echo '{"error":0}';
        }
        break;

    case 'getAccountInfo':

        $username = $_GET['username'];
        $sql="select username,sex,phone,email,address,unit,authority from accountInfo where username='{$username}'";
        $ret=$db->query($sql);
        $final = array();
        if($row=$ret->fetchArray(SQLITE3_ASSOC)){
            $arr=array();
            array_push($arr,'"username":"'.$row['username'].'"');
            array_push($arr,'"sex":"'.$row['sex'].'"');
            array_push($arr,'"phone":"'.$row['phone'].'"');
            array_push($arr,'"email":"'.$row['email'].'"');
            array_push($arr,'"address":"'.$row['address'].'"');
            array_push($arr,'"unit":"'.$row['unit'].'"');
            array_push($arr,'"authority":"'.$row['authority'].'"');

            array_push($final,implode(',',$arr));
        }

        if(count($final)>0){
            echo '[{'.implode('},{',$final).'}]';
        }
        else{
            echo '{"error":0}';
        }
        break;


    case 'saveInfo':
        //获取传递的参数
        $username = $_GET['username'];
        $sex = $_GET['sex'];
        $phone = $_GET['phone'];
        $email = $_GET['email'];
        $address = $_GET['address'];
        $unit = $_GET['unit'];

        $sql = "update accountInfo set sex = '{$sex}',phone = '{$phone}',email = '{$email}',address = '{$address}',unit = '{$unit}' where username = '{$username}'";
        $ret = $db->query($sql);
        if ($ret){
            echo '{"errorCode":0}';
        }else{
            echo '{"errorCode":1}';
        }
        break;
}
