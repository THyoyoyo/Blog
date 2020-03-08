<?php 
//查询有效的评论总数，要判断 文章名 是否存在
include_once '../../fn.php';

$sql = "SELECT count(*) as 'total' from comments 
JOIN posts on comments.post_id=posts.id";

$data = my_query($sql)[0];
echo json_encode($data);
?>
