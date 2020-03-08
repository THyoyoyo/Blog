<?php
//显示当前登录的头像 昵称
//通过 SESSION 取到 id ;
$id = $_SESSION['user_id'];
//根据 id 查询用户信息 获取数据
$sql = "select * from users where id = $id";
$data = my_query($sql)[0];

//判断当前是否是文章模块
$isPost = in_array($page, ['posts', 'post-add', 'categories']);
//判断当前页面是否是设置模块
$isSet = in_array($page, ['settings', 'slides', 'nav-menus']);

?>

<div class="aside">
    <div class="profile">
      <img class="avatar" src="../<?php echo $data['avatar']?>">
      <h3 class="name"><?php echo $data['nickname'] ?></h3>
    </div>
    <ul class="nav">
      <!-- 首页 -->
      <li class="<?php echo $page =='index1'? 'active':'' ?>">
        <a href="index1.php"><i class="fa fa-dashboard"></i>首页</a>
      </li>
      <!-- 文章 -->
      <li <?php echo $isPost?'active':''?>>
      <a href="#menu-posts" data-toggle="collapse" class="<?php echo $isPost?'':'collapsed' ?>" >
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo $isPost?'in':''?>">
          <li class="<?php echo $page =='posts'? 'active':'' ?>"><a href="posts.php">所有文章</a></li>
          <li class="<?php echo $page =='post-add'? 'active':'' ?>"><a href="post-add.php">写文章</a></li>
          <li class="<?php echo $page =='categories'? 'active':'' ?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <!-- 评论 -->
      <li class="<?php echo $page =='comments'? 'active':'' ?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <!-- 用户 -->
      <li class="<?php echo $page =='users'? 'active':'' ?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <!-- 设置 -->
      <li <?php echo $isSet?'active':''?>>
        <a href="#menu-settings" data-toggle="collapse" class="<?php echo $isSet?'':'collapsed' ?>">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo $isSet?'in':''?>">
          <li class="<?php echo $page =='nav-menus'? 'active':'' ?>"><a href="nav-menus.php">导航菜单</a></li>
          <li class="<?php echo $page =='slides'? 'active':'' ?>"><a href="slides.php">图片轮播</a></li>
          <!-- <li class="<?php echo $page =='settings'? 'active':'' ?>"><a href="settings.php">网站设置</a></li> -->
        </ul>
      </li>
    </ul>
  </div>