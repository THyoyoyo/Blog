<?php 
include_once '../../fn.php';
// 获取前端传递过来的id
$id=$_GET['id'];
$sql = "select * from posts where id=$id";
$data = my_query($sql)[0];

echo json_encode($data);

?>