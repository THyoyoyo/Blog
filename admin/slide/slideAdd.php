<?php
include_once '../../fn.php';
// echo '<pre>';
// print_r($_POST); 
// echo '</pre>';

// echo '<pre>';
// print_r($_FILES); 
// echo '</pre>';
//---------获取图片-------------
$files = $_FILES['image'];
if($files['error']===0){
    $ext = explode('.',$files['name'])[1];
    $newNama = time().rand(1,100).'.'.$ext;
    move_uploaded_file($files['tmp_name'],'../../uploads/'.$newNama);
    // 用一维素组存储数据
    $info['image'] = 'uploads/'.$newNama;
    //---------获取数据-------------
    $info['text'] = $_POST['text'];
    $info['link'] = $_POST['link'];
    // ----------------------------------
$sql = "SELECT  value  FROM options where id = 10"; //查询
$data=my_query($sql)[0]['value'];                   //获取需要的数据-------返回的是 json 格式
$arr =json_decode($data);                           //对 json 字符串进行解码 ,转化成数组
$arr[]=$info;
$str = json_encode($arr,JSON_UNESCAPED_UNICODE);
// -------------将转成json格式的数据，更新到数据库--------------------- 
$sql1 = "update options set value ='$str' where id =10";
my_exec($sql1);
}
?>