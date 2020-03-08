<?php 
header ('content-type:text/html;charset=utf-8');
define('HOST', '127.0.0.1');
define('UNAME', 's7881983');
define('PWD', 'qbCZ85vhFW');
define('DB', 's7881983');

//封装非查询语句方法
//参数：sql

function my_exec($sql){
//链接数据库
$link= mysqli_connect(HOST,UNAME,PWD,DB);
mysqli_query($link,"set names utf8");
// 执行
$result = mysqli_query($link,$sql);
//判断
// if($result){
//     // echo '成功';
// }else{
//     // echo '失败';
// }
//关闭数据库返回结果
 mysqli_close($link);
 return $result;

}

//封装执行查询语句方法
function my_query($sql){
//链接数据库
$link= mysqli_connect(HOST,UNAME,PWD,DB);
mysqli_query($link,"set names utf8");
// 执行
$result = mysqli_query($link,$sql);
$num = mysqli_num_rows($result);
//判断是否查询到结果
if(!$result || $num == 0){
    // echo '未获取到数据';
    return false;
}
//保存获取的数据
$data = [];
for($i=0;$i<$num;$i++){
    $data[] = mysqli_fetch_assoc($result);
}
//关闭数据库返回结果
mysqli_close($link);
return $data;

}

//判断是否登录过
function isLogin(){
//判断永辉是否登录
// 判断是否有PHPSESSID
if(empty($_COOKIE['PHPSESSID'])){
    header('location:./login.php');
    die();
  }else{
    // 判断 $_SESSION 是否有数据
    session_start();  //先开启服务
    if(empty($_SESSION['user_id'])){
      header('location:./login.php');   
    }
  }
}

?>