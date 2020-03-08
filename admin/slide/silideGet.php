<?php
include_once '../../fn.php';
$sql = "SELECT  value  FROM options where id = 10";
$data=my_query($sql)[0]['value'];
echo $data;
?>
