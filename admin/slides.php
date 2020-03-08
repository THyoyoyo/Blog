<?php
include_once '../fn.php';
isLogin()  //判断用户是否登录方法
?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <title>Slides &laquo; Admin</title>
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
                    <!-- <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li> -->
                    <li><a href="./loginout.php"><i class="fa fa-sign-out"></i>退出</a></li>
                </ul>
            </nav>
            <div class="container-fluid">
                <div class="page-title">
                    <h1>图片轮播</h1>
                </div>
                <!-- 有错误信息时展示 -->
                <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
                <div class="row">
                    <div class="col-md-4">
                        <form id="form">
                            <h2>添加新轮播内容</h2>
                            <div class="form-group">
                                <label for="image">图片</label>
                                <!-- show when image chose -->
                                <img class="help-block thumbnail" style="display: none">
                                <input id="image" class="form-control" name="image" type="file">
                            </div>
                            <div class="form-group">
                                <label for="text">文本</label>
                                <input id="text" class="form-control" name="text" type="text" placeholder="文本">
                            </div>
                            <div class="form-group">
                                <label for="link">链接</label>
                                <input id="link" class="form-control" name="link" type="text" placeholder="链接">
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
                                    <th class="text-center">图片</th>
                                    <th>文本</th>
                                    <th>链接</th>
                                    <th class="text-center" width="100">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><img class="slide" src="../uploads/slide_1.jpg"></td>
                                    <td>XIU功能演示</td>
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
        <?php $page ='slides'?>
        <!-- 引入公共侧边栏 -->
        <?php include_once './inc/asides.php'?>

        <script src="../assets/vendors/jquery/jquery.js"></script>
        <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
        <script src="../assets/vendors/template/template-web.js"></script>
        <script>
            NProgress.done()
        </script>
        <!-- /模板引擎 -->
        <script type="text/html" id="tmp">
            {{each list v i }}
            <tr>
                <td class="text-center"><img class="slide" src="../{{v.image}}"></td>
                <td>{{v.text}}</td>
                <td>{{v.link}}</td>
                <td class="text-center" data-id={{i}}>
                    <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
                </td>
            </tr>
            {{ /each}}
        </script>


        <script>
            //-----------------渲染轮播----------------------
            function render() {
                $.ajax({
                    url: './slide/silideGet.php',
                    dataType: 'json',
                    success: function(info) {
                        obj = {
                            list: info
                        }
                        $('tbody').html(template('tmp', obj))
                    }
                })
            }
            render();
            //--------------------删除---------------------
            $('tbody').on('click', '.btn-del', function() {
                    var id = $(this).parent().attr('data-id');

                    $.ajax({
                        url: './slide/slideDel.php',
                        data: {
                            id: id
                        },
                        success: function() {
                            render();
                        }
                    })
                })
                //-----------------添加--------------------
            $('.btn-add').click(function() {
                var fd = new FormData($('#form')[0]);
                $.ajax({
                    url: './slide/slideAdd.php',
                    type: 'post',
                    data: fd,
                    contentType: false, //不让 ajxa 设置头
                    processData: false, //告诉 ajax 不需要转换数据，数据已经通过 FormData 处理了
                    success: function(info) {
                        render();
                        $('form')[0].reset();
                    }
                })
            })
        </script>
    </body>

    </html>