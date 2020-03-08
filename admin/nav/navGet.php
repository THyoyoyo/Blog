<?php
include_once '../../fn.php';
$sql = "select value from options where id = 9";
$data = my_query($sql)[0]['value'];
echo $data;
?>