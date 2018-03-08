<?php
/**
 * Created by cyz.
 * User: pc
 * Date: 2017/11/14
 * Time: 16:30
 */

header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

include 'ConnectSQLite.php';

$username=$_POST['username'];
$password=$_POST['password'];
$passwordConfirm=$_POST['passwordConfirm'];
$authority="1";
if($password!=$passwordConfirm){

    echo "<script> alert('密码不一致！');window.location.href='../Register.html'</script>";
}

$sql="select count(*) from account where username='$username' and authority='$authority';";
    $ret = $db->query($sql);
		if ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $num=$row['count(*)'];
            if($num==1){
                echo "<script> alert('该用户名已存在!');window.location.href='../Register.html'</script>";
            }
        }else{

        }
$sql = "insert into account(username,password,authority) values ('".$username."','".$password."','".$authority."');";
		$emptyString = "";
		$sql1 = "insert into accountInfo(username,sex,phone,email,address,unit,authority) values ('".$username."','".$emptyString."','".$emptyString."','".$emptyString."','".$emptyString."','".$emptyString."','".$authority."');";

		$exec1=$db->query($sql);
		$exec2=$db->query($sql1);

		if($exec1&&$exec2){
    echo "<script> alert('注册成功!');window.location.href='../login.html'</script>";
}else{
    echo "<script> alert('注册失败！')</script>";
}
