<?php
include_once '../../fn.php';
$id= $_GET['id'];
$sql ="DELETE from users WHERE id in ($id)";
my_exec($sql);
?>
