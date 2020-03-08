<?php
include_once '../../fn.php';
header ('content-type:text/html;charset=utf-8');
// echo 'add';
// echo '<pre>';
// print_r($_POST); 
// echo '</pre>';

// echo '<pre>';
// print_r($_FILES); 
// echo '</pre>';


// [email] => 522307026@qq.com
// [slug] => 别名
// [nickname] => thyo
// [password] => 213213

// // 获取数据
$email = $_POST['email'];
$slug = $_POST['slug'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
$statu = $_POST['statu'];
$feature = '';

// //如果图片提交成功则保存图片
$file = $_FILES['feature'];
if($file['error']===0){
    $ext = explode('.',$file['name'])[1];
    $newName = time().rand(100,999).'.'.$ext;
    move_uploaded_file($file['tmp_name'],'../../uploads/'.$newName);
    $feature ='uploads/'.$newName;
};
// //将数据 和 图片 传入数据库
$sql = "insert into users (email, slug, nickname, password, avatar,status) 
values('$email', '$slug', '$nickname', $password, '$feature','$statu')";
// echo $sql;
my_exec($sql);
//跳转到文章列表页
header('location:../users.php');
?>