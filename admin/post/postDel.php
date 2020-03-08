<?php
include_once '../../fn.php';
$id = $_GET['id'];

$sql ="DELETE from posts WHERE id in ($id);";
my_exec($sql);
// -----------删除副作用------------- 需要删除后重新查询数据库的评论数


$sql1 = "SELECT count(*) as 'total' from posts 
JOIN users on posts.user_id=users.id
JOIN categories on posts.category_id=categories.id";

$data = my_query($sql1)[0];
// 返回删除后评论总数
echo json_encode($data);
?>