<?php

include_once '../../fn.php';
$id = $_GET['id'];
$sql = "select * from users where id=$id";
$data=my_query($sql)[0];
echo json_encode($data);
?>