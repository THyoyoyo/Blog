<?php
include_once '../fn.php';
isLogin();  //判断用户是否登录方法
// 动态渲染仪表盘数据
// 查询文章总数
$postSql="SELECT COUNT(*) as'num' from posts";
// 查询草稿总数
$draSql="SELECT COUNT(*) as'num' from posts where status='drafted'";
// 分类总数
$cateSql="SELECT COUNT(*) as'num' from categories";
// 评论总数
$comSql="SELECT COUNT(*) as'num' from comments";
// 评论待审核总数
$heldSql="SELECT COUNT(*) as'num' from comments WHERE status='held'";

$postNum = my_query($postSql)[0]['num'];
$draNum = my_query($draSql)[0]['num'];
$cateNum = my_query($cateSql)[0]['num'];
$comNum = my_query($comSql)[0]['num'];
$heldNum = my_query($heldSql)[0]['num'];



?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li> -->
        <li><a href="./loginout.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>代码越写越快乐</h1>
        <p>YOYO</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $postNum ?></strong>篇文章（<strong><?php echo $draNum?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $cateNum ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $comNum ?></strong>条评论（<strong><?php echo $heldNum ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>
  <!// 页面表示 //>
  <?php $page ='index1'?> 
  <!// 引入公共侧边栏 //>
  <?php include_once './inc/asides.php'?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
