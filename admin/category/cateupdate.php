<?php
include_once '../../fn.php';
$id = $_GET['id'];
$name = $_GET['name'];
$slug = $_GET['slug'];
$sql ="UPDATE categories set name='$name',slug='$slug' WHERE id=$id";
my_exec($sql);

?>