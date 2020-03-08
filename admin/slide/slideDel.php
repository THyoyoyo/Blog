<?php
include_once '../../fn.php';
$id=$_GET['id'];                      //获取ID
$sql = "SELECT  value  FROM options where id = 10";          //查询
$data=my_query($sql)[0]['value'];    //获取需要的数据-------返回的是 json 格式
$arr =json_decode($data);            //对 json 字符串进行解码 ,转化成数组
array_splice($arr,$id,1);            //删除 前端 传递 过来的 id
$str = json_encode($arr,JSON_UNESCAPED_UNICODE);            //转成 json 格式


// -------------将转成json格式的数据，更新到数据库--------------------- 
$sql1 = "update options set value ='$str' where id =10";
my_exec($sql1);
?>