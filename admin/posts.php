<?php
include_once '../fn.php';
isLogin()  //判断用户是否登录方法
?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <title>Posts &laquo; Admin</title>
        <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
        <link rel="stylesheet" href="../assets/css/admin.css">
        <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
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
                    <h1>所有文章</h1>
                    <a href="post-add.html" class="btn btn-primary btn-xs hide">写文章</a>
                </div>
                <!-- 有错误信息时展示 -->
                <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
                <div class="page-action">
                    <!-- show when multiple checked -->
                    <a class="btn btn-danger btn-sm btn-dels" href="javascript:;" style="display: bloak">批量删除</a>
                    <div class="page-box pull-right">

                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="40"><input type="checkbox" class="th-check"></th>
                            <th>标题</th>
                            <th>作者</th>
                            <th>分类</th>
                            <th class="text-center">发表时间</th>
                            <th class="text-center">状态</th>
                            <th class="text-center" width="100">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 动态渲染 -->
                       
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 页面表示 -->
        <?php $page ='posts'?>
        <!-- 引入公共侧边栏 -->
        <?php include_once './inc/asides.php'?>
        <!-- 模态框 -->
        <?php include_once './inc/edit.php'?>

        <script src="../assets/vendors/jquery/jquery.js"></script>
        <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
        <script src="../assets/vendors/template/template-web.js"></script>
        <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
        <script src="../assets/vendors/wangEditor/wangEditor.js"></script>
        <script src="../assets/vendors/moment/moment.js"></script>
        <script>
            NProgress.done()
        </script>
        <!-- 模板引擎 -->
        <script type="text/html" id='tmp'>
            {{each list v i}}
            <tr>
                <td class="text-center" data-id="{{v.id}}"><input type="checkbox" class="td-check"></td>
                <td>{{v.title}}</td>
                <td>{{v.nickname}}</td>
                <td>{{v.name}}</td>
                <td class="text-center">{{v.created}}</td>
                <td class="text-center">{{state[v.status]}}</td>
                <td class="text-center" data-id="{{v.id}}">
                    <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a>
                    <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
                </td>
            </tr>
            {{ /each }}
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
            // ---------------状态转换----------------
            var state = {
                    drafted: '草稿',
                    published: '已发布',
                    trashed: '回收站'

                }
                //--------------记录当前页--------------
            var currentPage = 1;
            //-------------封装一个请求指定页面的数据函数渲染----------------
            function render(page) {
                $.ajax({
                    url: './post/postGet.php',
                    data: {
                        page: page || 1,
                        pageSize: 15
                    },
                    dataType: 'json',
                    success: function(info) {
                        console.log(1);
                        $('tbody').html(template('tmp', {
                            list: info,
                            state: state,
                        }));
                        $('.th-check').prop('checked', false);
                    }
                })
            }
            // ---初始页面渲染----
            render();
            //--------------------分页标签----------------------------
            function setPage(page) {
                $.ajax({
                    url: './post/postTotal.php',
                    dataType: 'json',
                    success: function(info) {
                        console.log(info);
                        // 分页插件
                        $('.page-box').pagination(info.total, {
                            prev_text: '上一页',
                            next_text: '下一页',
                            num_display_entries: 5,
                            num_edge_entries: 1,
                            items_per_page: 15,
                            current_page: page - 1 || 0, //指定页码 默认：0 , 页码比pag 大一 所以减一
                            load_first_page: false,
                            callback: function(index) { //点击分页标签的回调函数  index：页码
                                //记录当前页
                                currentPage = index + 1;
                                //渲染点击的页面数据
                                render(index + 1);
                            },

                        });
                    }
                })

            }
            setPage();
            // ----------------删除---利用事件委托---------------------
            $('tbody').on('click', '.btn-del', function() {
                    var id = $(this).parent().attr('data-id');
                    console.log(id);
                    $.ajax({
                        url: './post/postDel.php',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(info) {
                            // 当前服务器最大页码
                            var maxPage = Math.ceil(info.total / 15);
                            // 判断当前页面是否大于 服务器的最大页面
                            if (currentPage > maxPage) {
                                currentPage = maxPage;
                            }
                            console.log(info);
                            //成功后，重新渲染当前页
                            render(currentPage);
                            //重新调用分页插件
                            setPage(currentPage);
                        }
                    })
                })
                //---------------------全选按钮----------------------------
            $('.th-check').on('change', function() {
                    var val = $(this).prop('checked');
                    $('.td-check').prop('checked', val);
                })
                //当小盒子 全部选中时
            $('tbody').on('change', '.td-check', function() {
                    //通过判断  .td-check:checked.length 来判断有多少个被点击了
                    if ($('.td-check:checked').length === $('.td-check').length) {
                        $('.th-check').prop('checked', true);
                    } else {
                        $('.th-check').prop('checked', false);
                    }
                })
                //---------------------批量选取id方法----------------------------
            function getId() {
                var idS = [];
                $('.td-check:checked').each(function(v, i) {
                    var s = $(i).parent().attr('data-id');
                    idS.push(s);
                })
                idS = idS.join() //不加参数默认逗号
                return idS;
            }
            // -------------------------批量删除-----------------------------------
            $('.btn-dels').click(function() {
                    ids = getId();
                    $.ajax({
                        url: './post/postDel.php',
                        data: {
                            id: ids
                        },
                        dataType: 'json',
                        success: function(info) {
                            var maxPage = Math.ceil(info.total / 15);
                            if (currentPage > maxPage) {
                                currentPage = maxPage;
                            }
                            render(currentPage);
                            setPage(currentPage);
                        }
                    })
                })
                // -----------------------模态框的设置--------------------------------
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
                    $('#strong').text($(this).val() || 'slug');
                })
                //------------发布时间同步------------
            $('#created').val(moment().format('YYYY-MM-DDTHH:mm'));
            //-----------------图片本地预览-----------
            $('#feature').on('change', function() {
                    var file = this.files[0];
                    var url = URL.createObjectURL(file);
                    $('#img').attr('src', url).fadeIn();
                })
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
                // --------------------------模态框内容填充------------------------
            $('tbody').on('click', '.btn-edit', function() {
                    var id = $(this).parent().attr('data-id');
                    $.ajax({
                        url: "./post/postGetById.php",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(info) {
                            console.log(info);
                            //显示模态框
                            $('.edit-box').fadeIn();
                            // ---------返回的数据填充到模态框--------------
                            //标题
                            $('#title').val(info.title);
                            // 别名-----#strong 也要修改
                            $('#slug').val(info.slug);
                            $('#strong').text(info.slug);
                            //图像
                            $('#img').attr('src', '../' + info.feature).fadeIn();
                            //时间
                            $('#created').val(moment(info.created).format('YYYY-MM-DDTHH:mm'));
                            // 正文   tear*** 要同步
                            editor.txt.html(info.content);
                            $('#content').val(info.content);
                            //分类标签
                            $('#category option[value=' + info.category_id + ']').prop('selected', true)
                                // 状态
                            $('#status option[value=' + info.status + ']').prop('selected', true)
                                // 设置id
                            $('#id').val(info.id);
                        }
                    })
                })
                // ----------模态框----放弃-----------
            $('#btn-cancel').click(function() {
                    $('.edit-box').fadeOut();
                })
                // ----------模态框----保存--------------
            $('#btn-update').click(function() {
                //获取表单数据
                var fd = new FormData($('#editForm')[0]);
                $.ajax({
                    url: './post/postUpdata.php',
                    type: 'post',
                    data: fd,
                    contentType: false, //不让 ajxa 设置头
                    processData: false, //告诉 ajax 不需要转换数据，数据已经通过 FormData 处理了
                    success: function(info) {
                        // 后台成功响应后
                        render(currentPage);
                        $('.edit-box').fadeOut();
                    }

                })
            })
        </script>
    </body>

    </html>