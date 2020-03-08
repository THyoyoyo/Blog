<?php
include_once '../fn.php';
isLogin()  //判断用户是否登录方法
?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <title>Navigation menus &laquo; Admin</title>
        <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
        <link rel="stylesheet" href="../assets/css/admin.css">
        <script src="../assets/vendors/nprogress/nprogress.js"></script>
    </head>

    <body>
        <script>
            NProgress.start()
        </script>

        <div class="main">
            <nav class="navbar">
                <button class="btn btn-default navbar-btn fa fa-bars"></button>
                <ul class="nav navbar-nav navbar-right">
                    <!-- <li><a href="profile.php"><i class="fa fa-user"></i>个人中心</a></li> -->
                    <li><a href="./loginout.php"><i class="fa fa-sign-out"></i>退出</a></li>
                </ul>
            </nav>
            <div class="container-fluid">
                <div class="page-title">
                    <h1>导航菜单</h1>
                </div>
                <!-- 有错误信息时展示 -->
                <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
                <div class="row">
                    <div class="col-md-4">
                        <form id="form">
                            <h2>添加新导航链接</h2>
                            <div class="form-group">
                                <label for="text">文本</label>
                                <input id="text" class="form-control" name="text" type="text" placeholder="文本">
                            </div>
                            <div class="form-group">
                                <label for="title">标题</label>
                                <input id="title" class="form-control" name="title" type="text" placeholder="标题">
                            </div>
                            <div class="form-group">
                                <label for="link">链接</label>
                                <input id="link" class="form-control" name="link" type="text" placeholder="链接">
                            </div>
                            <div class="form-group">
                                <label for="href">图标</label><br>
                                <input type="radio" name="icon" value="fa fa-glass" checked><i class="fa fa-glass"></i> &nbsp; &nbsp;
                                <input type="radio" name="icon" value="fa fa-fire"><i class="fa fa-fire"></i> &nbsp; &nbsp;
                                <input type="radio" name="icon" value="fa fa-gift"><i class="fa fa-gift"></i> &nbsp; &nbsp;
                                <input type="radio" name="icon" value="fa fa-phone"><i class="fa fa-phone"></i> &nbsp; &nbsp;
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary btn-add" type="button" value="添加">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <div class="page-action">
                            <!-- show when multiple checked -->
                            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
                        </div>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>文本</th>
                                    <th>标题</th>
                                    <th>链接</th>
                                    <th class="text-center" width="100">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- 动态生成 -->
                                <tr>
                                    <td><i class="fa fa-glass"></i>奇趣事</td>
                                    <td>奇趣事</td>
                                    <td>#</td>
                                    <td class="text-center">
                                        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-phone"></i>潮科技</td>
                                    <td>潮科技</td>
                                    <td>#</td>
                                    <td class="text-center">
                                        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-fire"></i>会生活</td>
                                    <td>会生活</td>
                                    <td>#</td>
                                    <td class="text-center">
                                        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- 页面表示 -->
        <?php $page ='nav-menus'?>
        <!-- 引入公共侧边栏 -->
        <?php include_once './inc/asides.php'?>

        <script src="../assets/vendors/jquery/jquery.js"></script>
        <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
        <script src="../assets/vendors/template/template-web.js"></script>
        <script>
            NProgress.done()
        </script>
        <script type="text/html" id="tmp">
            {{ each list v i }}
            <tr>
                <td><i class="{{v.icon}}"></i>{{v.title}}</td>
                <td>{{v.text}}</td>
                <td>{{v.link}}</td>
                <td class="text-center" data-id="{{i}}">
                    <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
                </td>
            </tr>
            {{ /each }}
        </script>
        <script>
            //-----------------------数据渲染----------------------------
            function rander() {
                $.ajax({
                    url: './nav/navGet.php',
                    dataType: 'json',
                    success: function(info) {
                        // console.log(info);
                        $('tbody').html(template('tmp', {
                            list: info
                        }))
                    }
                })
            }
            rander();
            //----------------删除--------------------------
            $('tbody').on('click', '.btn-del', function() {
                    var id = $(this).parent().attr('data-id');
                    console.log(id);
                    $.ajax({
                        url: './nav/navDel.php',
                        data: {
                            id: id
                        },
                        success: function() {
                            rander();
                        }
                    })
                })
                // -------------------添加--------------------------
            $('.btn-add').click(function() {
                var fd = new FormData($('#form')[0])
                $.ajax({
                    url: './nav/navAdd.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(info) {
                        rander();
                        $('form')[0].reset();
                    }
                })
            })
        </script>
    </body>

    </html>