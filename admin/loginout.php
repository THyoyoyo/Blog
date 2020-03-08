<?php
//删除标记
session_start();
unset($_SESSION['user_id']);
header('location:./login.php');  
?>