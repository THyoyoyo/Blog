<?php
include_once '../fn.php';
$sql = "SELECT posts.*,users.nickname,categories.name from posts 
JOIN users on posts.user_id=users.id
JOIN categories on posts.category_id=categories.id
ORDER BY posts.id desc
LIMIT 1 ,4;";   //可随机
//调用查询函数
$data = my_query($sql);


echo json_encode($data);
