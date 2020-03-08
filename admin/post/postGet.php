<?php
include_once '../../fn.php';

//根据前端，传递的页吗，每页的数据条数。返回对应的数据
$page = $_GET['page'];  //获取页码
$pageSize =$_GET['pageSize'];  //每页条数

$start = ($page-1)*$pageSize;// 初始索引
// 准备sql 语句
$sql = "SELECT posts.*,users.nickname,categories.name from posts 
JOIN users on posts.user_id=users.id
JOIN categories on posts.category_id=categories.id
ORDER BY posts.id desc
LIMIT $start ,$pageSize;";
//调用查询函数
$data = my_query($sql);
// 转换成 json 格式
echo json_encode($data);
?>