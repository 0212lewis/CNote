<?php
header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

$username = $_POST['username'];
$password = $_POST['password'];

include 'ConnectSQLite.php';

$sql = "SELECT username,authority from account where username='$username' and password='$password';";


$ret = $db->query($sql);

if ($row = $ret->fetcharray(SQLITE3_ASSOC)) {

    session_start();

    $username = $row['username'];
    $authority = $row['authority'];


    $_SESSION['username'] = $username;
    $_SESSION['authority'] = $authority;
    $uri = "";
    if ($authority == '0') {
        $uri = "http://localhost/CNote/pages/Homepage.html?username=".$username;
        header("Location:" . $uri);
    } else if ($authority == '1') {
//        setcookie("username", $username, time()+3600);
        $uri = "http://localhost/CNote/pages/Homepage.html?username=".$username;
        header("Location:" . $uri);
    } else {
        $message = '登录权限错误';
        echo "<script> alert('{$message}') </script>";
    }
} else {
    $message = '用户名或密码错误';
    echo "<script> alert('{$message}');window.location.href='../login.html'</script>";
}
?>
