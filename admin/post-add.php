<?php
include_once '../fn.php';
isLogin()  //判断用户是否登录方法
?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <title>Add new post &laquo; Admin</title>
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
                    <h1>写文章</h1>
                </div>
                <!-- 有错误信息时展示 -->
                <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
                <form class="row" action="./post/postAdd.php" method="POST" enctype="multipart/form-data">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="title">标题</label>
                            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="content">内容</label>
                            <textarea id="content" class="form-control input-lg hide" name="content" cols="30" rows="10" placeholder="内容"></textarea>
                            <!-- 福文本编辑器 -->
                            <div id="content-box">
                                <!-- <p></p> 初始化内容 -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="slug">别名</label>
                            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
                            <p class="help-block">https://zce.me/post/<strong id="slugTxt">slug</strong></p>
                        </div>
                        <div class="form-group">
                            <label for="feature">特色图像</label>
                            <!-- show when image chose -->
                            <img class="help-block thumbnail" id="img" style="display: none;width:100px;height:100px">
                            <input id="feature" class="form-control" name="feature" type="file" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="category">所属分类</label>
                            <select id="category" class="form-control" name="category">
                              <!-- 动态渲染 -->
             
              <option value="2">潮生活</option>
            </select>
                        </div>
                        <div class="form-group">
                            <label for="created">发布时间</label>
                            <input id="created" class="form-control" name="created" type="datetime-local">
                        </div>
                        <div class="form-group">
                            <label for="status">状态</label>
                            <select id="status" class="form-control" name="status">
              <!-- 动态生成 -->
              <option value="published">已发布</option>
                 </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- 页面表示 -->
        <?php $page ='post-add'?>
        <!-- 引入公共侧边栏 -->
        <?php include_once './inc/asides.php'?>

        <script src="../assets/vendors/jquery/jquery.js"></script>
        <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
        <script src="../assets/vendors/template/template-web.js"></script>
        <script src="../assets/vendors/moment/moment.js"></script>
        <script src="../assets/vendors/wangEditor/wangEditor.js"></script>
        <script>
            NProgress.done()
        </script>
        <!-- 分类模板引擎 -->
        <script type="text/html" id="tmp-cate">
            {{each list v i }}
            <option value="{{v.id}}">{{v.name}}</option>
            {{/each}}
        </script>
        <!-- 状态模板 -->
        <script type="text/html" id="tmp-state">
            {{each $data v k }}
            <option value="{{k}}">{{$data[k]}}</option>
            {{/each}}
        </script>
        <script>
            //准备 写文章的页面

            //  ------------填充下拉菜单--------------
            $.ajax({
                    url: './category/cateGet.php',
                    dataType: 'json',
                    success: function(info) {
                        $('#category').html(template('tmp-cate', {
                            list: info
                        }))
                    }
                })
                // ------------状态设置-------------
            var state = {
                drafted: '草稿',
                published: '已发布',
                trashed: '回收站'

            }

            //---------------状态数据填充------------          
            $('#status').html(template('tmp-state', state));

            // -------------------别名同步--------------
            $('#slug').on('input', function() {
                $('#slugTxt').text($(this).val() || 'slug');
            })

            //-----------------图片本地预览-----------
            $('#feature').on('change', function() {
                    var file = this.files[0];
                    var url = URL.createObjectURL(file);
                    $('#img').attr('src', url).fadeIn();
                })
                //------------发布时间同步------------
            $('#created').val(moment().format('YYYY-MM-DDTHH:mm'));
            // ------------福文档编辑------------------
            var E = window.wangEditor
            var editor = new E('#content-box');
            var $text1 = $('#content');
            editor.customConfig.onchange = function(html) {
                    // 监控变化，同步更新到 textarea
                    $text1.val(html)
                }
                //  配置菜单
            editor.customConfig.menus = [
                'head', // 标题
                'bold', // 粗体
                'fontSize', // 字号
                'fontName', // 字体
                'italic', // 斜体
                'underline', // 下划线
                'strikeThrough', // 删除线
                'foreColor', // 文字颜色
                'backColor', // 背景颜色
                'link', // 插入链接
                'list', // 列表
                'justify', // 对齐方式
                'code', // 插入代码
                'undo', // 撤销
                'redo' // 重复
            ]
            editor.create()
        </script>
    </body>

    </html>