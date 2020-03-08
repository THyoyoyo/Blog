<?php
include_once '../fn.php';
//如果是post请求方式  则进行处理
if(!empty($_POST)){
  $email = $_POST['email'];
  $pws = $_POST['password'];
  //判断用户名和密码是否为空
  if(empty($email) || empty($pws)){
    $msg = '邮箱或密码为空';
  //如果不为空 根据用户名去查询密码
  }else{
    $sql = "SELECT * from users where email='$email'";
    $data = my_query($sql);
    // 判断是否有返回的查询结果，如果没得则说明用户名不存在
    if(empty($data)){
      $msg = '用户名不存在';
    } 
    //如果查询结果不为空则，判断密码是否正确
    else{
      $data = $data[0];
      if($pws ===$data['password']){
        //给登录成功的添加标记
        session_start();   //开起服务
        //向 session储存标记
        $_SESSION['user_id']=$data['id'];
        $_SESSION['user_slug']=$data['slug'];          //记住别名
        //登录成功去首页
        header('location:./index1.php');
      }
     else{
      $msg = '密码错误';
    }
  }
  }
}

?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <title>Sign in &laquo; Admin</title>
        <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/css/admin.css">
        <style>

        </style>
    </head>

    <body>
        <div class="login">
            <!-- action 为空，提交给当前页面 -->
            <form class="login-wrap" action="" method="post">
                <img class="avatar" src="../assets/img/default.png">

                <!-- 有错误信息时展示 -->
                <?php if(!empty($msg)) { ?>
                <div class="alert alert-danger">
                    <strong>错误！</strong>
                    <?php echo $msg ?>
                </div>
                <?php } ?>

                <div class="form-group">
                    <label for="email" class="sr-only">邮箱</label>
                    <input id="email" type="email" class="form-control" placeholder="邮箱" name='email' value="<?php echo !empty($msg)? $email : '';?>">
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">密码</label>
                    <input id="password" type="password" class="form-control" placeholder="密码" name="password">
                </div>
                <input class="btn btn-primary btn-block" type="submit" value="登录">
            </form>
        </div>
    </body>

    </html>