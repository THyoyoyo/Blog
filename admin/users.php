<?php
include_once '../fn.php';
isLogin();  //判断用户是否登录方法
$uids = $_SESSION['user_id'];
$uSlug = $_SESSION['user_slug'];
?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <title>Users &laquo; Admin</title>
        <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
        <link rel="stylesheet" href="../assets/css/admin.css">
        <script src="../assets/vendors/nprogress/nprogress.js"></script>
        <style>
            .passwordtxt {
                position: relative;
            }
            
            .showpass {
                cursor: pointer;
                position: absolute;
                top: 31px;
                right: 5px;
                font-size: 20px;
            }
        </style>
    </head>

    <body data-uid='<?php echo $uids?>' data-uSlug="<?php echo $uSlug?>">
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
                    <h1>用户</h1>
                </div>
                <!-- 有错误信息时展示 -->
                <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
                <div class="row">
                    <div class="col-md-4">
                        <form id="form" action="./user/userAdd.php" method="POST" enctype="multipart/form-data">
                            <h2 id="h2txt">添加新用户</h2>
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="email">邮箱</label>
                                <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
                            </div>
                            <div class="form-group">
                                <label for="slug">别名</label>
                                <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
                                <p class="help-block">https://zce.me/author/<strong id="slugTxt">slug</strong></p>
                            </div>
                            <div class="form-group">
                                <label for="nickname">昵称</label>
                                <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
                            </div>
                            <div class="form-group">
                                <label for="nickname">头像</label>
                                <img src="" alt="" id="img" style="display: none;width:100px;height:100px;margin-bottom: 10px;">
                                <input id="feature" class="form-control" name="feature" type="file" accept="image/*">
                            </div>

                            <div class="form-group passwordtxt">
                                <label for="password">密码</label>
                                <input id="password" class="form-control" name="password" type="password" placeholder="密码">
                                <i class="fa fa-eye-slash showpass"></i>
                            </div>

                            <div class="form-group">
                                <label for="statu">状态</label>
                                <select name="statu" id="statu" class="form-control">
                                   <!-- 动态渲染 -->
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary btn-add" type="submit" value="添加">
                                <input class="btn btn-primary btn-reset" type="reset" value="重置">
                                <input class="btn btn-primary btn-updata" type="button" value="修改" style="display: none;background-color: rgba(42, 190, 42, 0.932)">
                                <input class="btn btn-primary btn-out" type="button" value="放弃" style="display: none;background-color: rgba(197, 13, 13, 0.932)">
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
                                    <th class="text-center" width="40"><input type="checkbox" style="display: none">ID</th>
                                    <th class="text-center" width="80">头像</th>
                                    <th>邮箱</th>
                                    <th>别名</th>
                                    <th>昵称</th>
                                    <th>状态</th>
                                    <th class="text-center" width="100">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- 动态渲染 -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- 页面表示 -->
        <?php $page ='users'?>
        <!-- 引入公共侧边栏 -->
        <?php include_once './inc/asides.php'?>

        <script src="../assets/vendors/jquery/jquery.js"></script>
        <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
        <script src="../assets/vendors/template/template-web.js"></script>
        <script>
            NProgress.done()
        </script>
        <!-- 模板引擎 -->
        <script type="text/html" id="tmp">
            <tr>
                {{each list v i }}
                <td class="text-center"><input type="checkbox" style="display: none">{{v.id}}</td>
                <td class="text-center"><img class="avatar" src="../{{v.avatar}}"></td>
                <td>{{v.email}}</td>
                <td>{{v.slug}}</td>
                <td>{{v.nickname}}</td>
                <td>{{statu[v.status]}}</td>
                <td class="text-center" data-id={{v.id}}>
                    <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a> {{if v.id != uid}}
                    <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a> {{/if}}
                </td>
            </tr>
            {{ /each }}
        </script>
        <!-- 状态模板 -->
        <script type="text/html" id="tmp-state">
            {{each $data v k }}
            <option value="{{k}}">{{$data[k]}}</option>
            {{/each}}
        </script>

        <script>
            var uid = $('body').attr('data-uid');
            var uSlug = $('body').attr('data-uSlug');
            // 未激活（unactivated）/ 激活（activated）/ 禁止（forbidden）
            statu = {
                    activated: '激活',
                    unactivated: '未激活',
                    forbidden: '禁止'
                }
                //-----------------渲染页面-------------------
            function render() {
                $.ajax({
                    url: './user/userGet.php',
                    dataType: 'json',
                    success: function(info) {
                        // console.log(info);
                        $('tbody').html(template('tmp', {
                            list: info,
                            statu: statu,
                            uid: uid
                        }))
                    }
                })
            }
            render();
            // -- -- -- -- -- -- 删除-- -- -- -- -- -- --
            $('tbody').on('click', '.btn-del', function() {
                    var id = $(this).parent().attr('data-id')
                    $.ajax({
                        url: './user/userDel.php',
                        data: {
                            id: id
                        },
                        success: function(info) {
                            render();
                        }
                    })
                })
                //-----------------图片本地预览-----------
            $('#feature').on('change', function() {
                    var file = this.files[0];
                    var url = URL.createObjectURL(file);
                    $('#img').attr('src', url).slideDown();
                })
                //---------------状态数据填充------------          
            $('#statu').html(template('tmp-state', statu));
            // -------------------别名同步--------------
            $('#slug').on('input', function() {
                    $('#slugTxt').text($(this).val() || 'slug');
                })
                // ----------------------点击编辑按钮,填充数据------------------------------------
            $('tbody').on('click', '.btn-edit', function() {
                    var id = $(this).parent().attr('data-id');
                    $.ajax({
                        url: './user/userGetById.php',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(info) {
                            // console.log(info);
                            // 对数据进行填充
                            $('#email').val(info.email);
                            $('#slug').val(info.slug);
                            $('#slugTxt').text(info.slug);
                            $('#nickname').val(info.nickname);
                            $('#password').val(info.password);
                            $('#img').attr('src', '../' + info.avatar).slideDown();
                            $('#statu option[value=' + info.status + ']').prop('selected', true)
                            $('#id').val(info.id)
                                // ---------------按键替换/文本替换---------------------------
                            $('.btn-add').hide();
                            $('.btn-reset').hide();
                            $('.btn-updata').fadeIn();
                            $('.btn-out').fadeIn();
                            $('#h2txt').text('修改用户信息');
                            if (uid == id) { //判断是否是当前 id
                                $('.passwordtxt').slideDown()
                            } else if (uSlug == 'admin') { //判断是否是管理员
                                $('.passwordtxt').slideDown()
                            } else {
                                $('.passwordtxt').slideUp()
                            }

                        }
                    })
                })
                // ------------------------放弃--------------------------------
            $('.btn-out').click(function() {
                    $('.btn-add').fadeIn();
                    $('.btn-reset').fadeIn();
                    $('.btn-updata').hide()
                    $('.btn-out').hide()
                    $('#h2txt').text('添加新用户');
                    $('form')[0].reset();
                    $('#img').slideUp();
                    $('.passwordtxt').show();
                })
                // ------------------------修改-------------------------
            $('.btn-updata').click(function() {
                    var fd = new FormData($('#form')[0]);
                    // console.log(fd);

                    $.ajax({
                        url: './user/userUpdeta.php',
                        type: 'post',
                        data: fd,
                        contentType: false, //不让 ajxa 设置头
                        processData: false, //告诉 ajax 不需要转换数据，数据已经通过 FormData 处理了
                        success: function(info) {
                            // 后台成功响应后
                            render();
                            $('.btn-add').fadeIn();
                            $('.btn-reset').fadeIn();
                            $('.btn-updata').hide()
                            $('.btn-out').hide()
                            $('#h2txt').text('添加新用户');
                            $('form')[0].reset();
                            $('#img').slideUp();
                            $('.passwordtxt').show();
                        }
                    })
                })
                //--------------- 密码显示切换--------------------
            var flag = 0 //显示密码的切换
            $('.showpass').on('click', function() {
                if (flag) {
                    $(this).removeClass('fa-eye-slash')
                    $(this).addClass('fa-eye');
                    flag = 0;
                    $(this).siblings('input').prop('type', 'texe')
                } else {
                    $(this).removeClass('fa-eye')
                    $(this).addClass('fa-eye-slash');
                    flag = 1;
                    $(this).siblings('input').prop('type', 'password')
                }
            })
        </script>
    </body>

    </html>