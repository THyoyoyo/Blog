<?php 
//查询有效的文章，必须有作者 有分类
include_once '../../fn.php';

$sql = "SELECT count(*) as 'total' from posts 
JOIN users on posts.user_id=users.id
JOIN categories on posts.category_id=categories.id";

$data = my_query($sql)[0];
echo json_encode($data);
?>
