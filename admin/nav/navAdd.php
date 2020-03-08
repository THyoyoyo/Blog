<?php
include_once '../../fn.php';
// echo '<pre>';
// print_r($_POST); 
// echo '</pre>';
$info['icon'] = $_POST['icon'];
$info['text'] = $_POST['text'];
$info['title'] = $_POST['title'];
$info['link'] = $_POST['link'];

// -------------------------------------
$sql = "select value from options where id = 9";
$data = my_query($sql)[0]['value'];
$arr =json_decode($data);
$arr[]=$info;

$str = json_encode($arr,JSON_UNESCAPED_UNICODE);
$sql1 = "update options set value ='$str' where id =9";
my_exec($sql1);
?>