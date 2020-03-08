<?php
header('Content-type:application/json;charset=utf-8');
include_once '../fn.php';
isLogin()  //判断用户是否登录方法
?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <title>Categories &laquo; Admin</title>
        <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
        <link rel="stylesheet" href="../assets/css/admin.css">
        <script src="../assets/vendors/nprogress/nprogress.js"></script>
    </head>
    <style>

    </style>

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
                    <h1>分类目录</h1>
                </div>
                <!-- 有错误信息时展示 -->
                <div class="alert alert-danger" style="display: none">
                    <strong>错误！</strong>内容未填写完整
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <form id="form">
                            <input type="hidden" name='id' id="id">
                            <h2 id="h2str">添加新分类目录</h2>
                            <div class="form-group">
                                <label for="name">名称</label>
                                <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
                            </div>
                            <div class="form-group">
                                <label for="slug">别名</label>
                                <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
                                <p class="help-block">https://zce.me/category/<strong id=str>slug</strong></p>
                            </div>
                            <div class="form-group">
                                <input type="button" class="btn btn-primary btn-add" value="添加">
                                <input type="button" class="btn btn-primary btn-sev" value="修改" style="display: none;background-color: rgba(42, 190, 42, 0.932)">
                                <input type="reset" class="btn btn-primary btn-reset" value="重置">
                                <input type="button" class="btn btn-primary btn-out" value="放弃" style="display: none;background-color: rgba(197, 13, 13, 0.932)">
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
                                    <th class="text-center" width="40"><input type="checkbox" style="display: none"></th>
                                    <th>名称</th>
                                    <th>别名</th>
                                    <th class="text-center" width="100">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- -------------------模板渲染----------------- -->
                                <tr>
                                    <td class="text-center"><input type="checkbox"></td>
                                    <td>未分类</td>
                                    <td>uncategorized</td>
                                    <td class="text-center">
                                        <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
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
        <?php $page ='categories'?>
        <!-- 引入公共侧边栏 -->
        <?php include_once './inc/asides.php'?>
        <script src="../assets/vendors/jquery/jquery.js"></script>
        <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
        <script src="../assets/vendors/template/template-web.js"></script>
        <script>
            NProgress.done()
        </script>
        <!-- 分类模板引擎 -->
        <script type="text/html" id='tmp'>
            {{each list v i}}
            <tr>
                <td class="text-center"><input type="checkbox" data-id={{v.id}}></td>
                <td>{{v.name}}</td>
                <td>{{v.slug}}</td>
                <td class="text-center" data-id={{v.id}}>
                    <a href="javascript:;" class="btn btn-info btn-xs btn-edit">编辑</a>
                    <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
                </td>
            </tr>
            {{ /each }}
        </script>

        <script>
            // ------------渲染分类数据------------------
            function rander() {
                $.ajax({
                    url: './category/cateGet.php',
                    dataType: 'json',
                    success: function(info) {
                        console.log(info);
                        obj = {
                            list: info
                        }
                        $('tbody').html(template('tmp', obj))


                    }
                })
            }
            rander();
            //-------------删除---------------------
            $('tbody').on('click', '.btn-del', function() {
                    id = $(this).parent().attr('data-id')
                        // console.log(id);
                    $.ajax({
                        url: './category/cateDel.php',
                        data: {
                            id: id
                        },
                        success: function() {
                            rander();
                        }

                    })
                })
                //------------添加-----------------------------
            $('.btn-add').click(function() {
                    // -----表单序列化获取数据-----
                    var str = $('#form').serialize();
                    $.ajax({
                        url: './category/cateAdd.php',
                        data: str,
                        beforeSend: function() {
                            //对数据进行验证是否为空
                            if ($('#name').val().trim().length == 0 || $('#slug').val().trim().length == 0) {
                                $('.alert-danger').slideDown().delay("3000").slideUp()
                                return false;
                            }
                        },
                        success: function(info) {
                            // $('.btn-reset').trigger('click')
                            rander();
                            $('form')[0].reset(); ///重置表单

                        }
                    })
                })
                //----------别名同步---------------
            $('#slug').on('input', function() {
                $('#str').text($(this).val() || 'slug');
            })

            // --------点击编辑事件--------------
            $('tbody').on('click', '.btn-edit', function() {
                    id = $(this).parent().attr('data-id')
                    $.ajax({
                        url: './category/cateGetById.php',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(info) {
                            //渲染到页面
                            $('#name').val(info.name);
                            $('#slug').val(info.slug);
                            $('#id').val(info.id);
                            $('.btn-add').hide();
                            $('.btn-reset').hide();
                            $('.btn-sev').show();
                            $('.btn-out').show();
                            $('#h2str').text('修改分类目录');
                        }
                    })
                })
                // ---------修改保存按钮------------
            $('.btn-sev').click(function() {
                var str = $('#form').serialize()
                $.ajax({
                    url: './category/cateupdate.php',
                    data: str,
                    success: function() {
                        $('.btn-add').show();
                        $('.btn-reset').show();
                        $('.btn-sev').hide();
                        $('.btn-out').hide();
                        $('#h2str').text('添加新分类目录');
                        rander(); //重新渲染
                        $('form')[0].reset(); //重置表单
                    }
                })

            })
            $('.btn-out').click(function() {
                $('.btn-add').show();
                $('.btn-reset').show();
                $('.btn-sev').hide();
                $('.btn-out').hide();
                $('#h2str').text('添加新分类目录');
                $('form')[0].reset(); //重置表单
            })
        </script>
    </body>

    </html>