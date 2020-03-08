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

// 获取的数据
$title = $_POST['title'];
$content = $_POST['content'];
$slug = $_POST['slug'];
$category = $_POST['category'];
$created = $_POST['created'];
$status = $_POST['status'];
$id = $_POST['id'];
$feature='';
// ------保存图片-------
$file = $_FILES['feature'];
if($file['error']===0){
    $ext = explode('.',$file['name'])[1];
    $newName = time().rand(999,1000).'.'.$ext;
    move_uploaded_file($file['tmp_name'],'../../uploads/'.$newName);
    //图片是多个页面共享的，尽量选择相对路径
    $feature ='uploads/'.$newName;
};
//如果没有上传图片，则保留原图，上传了更新图片
//将数据 和 图片  更新传入数据库
if(empty($feature)){
    $sql = "update posts set title='$title', content='$content', slug='$slug',
    category_id=$category, created='$created', status='$status' where id=$id";
}else{
    $sql = "update posts set title='$title', content='$content', slug='$slug',
    category_id=$category, created='$created', status='$status',feature='$feature' where id=$id";
}
echo $sql;
echo my_exec($sql);
?>