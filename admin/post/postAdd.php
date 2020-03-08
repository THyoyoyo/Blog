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

$title = $_POST['title'];
$content = $_POST['content'];  //内容
$slug = $_POST['slug'];
$category = $_POST['category'];
$created = $_POST['created'];
$status = $_POST['status'];
// 谁是作者
session_start();
$userid=$_SESSION['user_id'];
// 处理图片
$feature='';

//如果图片提交成功则保存图片
$file = $_FILES['feature'];
if($file['error']===0){
    $ext = explode('.',$file['name'])[1];
    $newName = time().rand(999,1000).'.'.$ext;
    move_uploaded_file($file['tmp_name'],'../../uploads/'.$newName);
    //图片是多个页面共享的，尽量选择相对路径
    $feature ='uploads/'.$newName;
} 
//将数据 和 图片 传入数据库

$sql = "insert into posts (title, content, slug, category_id, created, status, user_id, feature) 
values('$title', '$content', '$slug', $category, '$created', '$status', $userid, '$feature')";

my_exec($sql);

//跳转到文章列表页
    header('location:../posts.php');
?>