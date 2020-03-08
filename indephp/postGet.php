<?php
include_once '../fn.php';
$sql = "SELECT posts.*,users.nickname,categories.name from posts 
JOIN users on posts.user_id=users.id
JOIN categories on posts.category_id=categories.id
ORDER BY posts.id desc
LIMIT 0 ,5;";
//调用查询函数
$data = my_query($sql);
// /
// 转换成 json 格式
// $content = htmlspecialchars($data);

echo json_encode($data);



?>