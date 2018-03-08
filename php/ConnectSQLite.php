<?php
/**
 * Created by cyz.
 * User: pc
 * Date: 2017/11/14
 * Time: 16:37
 */
header('Access-Control-Allow-Origin:*');
header("Content-type: text/html; charset=utf-8");
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');


class MyDB extends SQLite3
{
    function MyDB(){
        $this->open('../web.db');
    }
}

$db=new MyDB();
if(!$db){
    echo $db->lastErrorMsg();
}else{
//	echo "open web.db successfully!\n";
}
