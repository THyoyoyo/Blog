<?php
include_once '../../fn.php';
$id = $_GET['id'];

$sql ="update comments set status ='approved' where id in ($id) and status='held'";
if (my_exec($sql)) {
    echo '批准成功';
} else {
    echo '批准失败';
}
?>