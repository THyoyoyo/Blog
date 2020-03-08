<?php 
include_once '../fn.php';

// 准备sql 语句
$sql = "SELECT comments.* , posts.title ,users.avatar from comments 
JOIN posts on comments.post_id=posts.id 
JOIN users on comments.parent_id=users.id 
LIMIT 1 ,6;";
//调用查询函数
$data = my_query($sql);
// 转换成 json 格式
echo json_encode($data);
?>