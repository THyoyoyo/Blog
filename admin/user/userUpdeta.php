<?php
include_once '../../fn.php';
header ('content-type:text/html;charset=utf-8');

// // 获取数据
$id = $_POST['id'];
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
// 判断用户是否传送数据
if(empty($feature)){
    $sql = "update users set email='$email', slug='$slug', nickname='$nickname',
    password='$password', status='$statu' where id=$id";
}else{
    $sql = "update users set email='$email', slug='$slug', nickname='$nickname',
    password='$password', status='$statu', avatar='$feature' where id=$id";
}
// echo $sql;
my_exec($sql);

?>