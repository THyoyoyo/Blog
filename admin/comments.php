<?php
header ('content-type:text/html;charset=utf-8');
include_once '../fn.php';
isLogin()  //判断用户是否登录方法
?>
    <!DOCTYPE html>
    <html lang="zh-CN">

    <head>
        <meta charset="utf-8">
        <title>Comments &laquo; Admin</title>
        <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
        <link rel="stylesheet" href="../assets/css/admin.css">
        <script src="../assets/vendors/nprogress/nprogress.js"></script>
        <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
        <style>
            .yy {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>
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
                    <h1>所有评论</h1>
                </div>
                <!-- 有错误信息时展示 -->
                <!-- <div class="alert alert-danger">
    <strong>错误！</strong>发生XXX错误
    </div> -->
                <div class="page-action">
                    <!-- show when multiple checked -->
                    <div class="btn-batch pull-left" style="display: block">
                        <button class="btn btn-info btn-sm btn-approveds">批量批准</button>
                        <button class="btn btn-warning btn-sm btn-rejected">批量拒绝</button>
                        <button class="btn btn-danger btn-sm btn-dels">批量删除</button>
                    </div>
                    <!-- -------分页动态-------------- -->
                    <div class="page-box pull-right">

                    </div>

                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="40"><input type="checkbox" class="th-check"></th>
                            <th>作者</th>
                            <th>评论</th>
                            <th>评论在</th>
                            <th>提交于</th>
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
        <!-- 页面表示 -->
        <?php $page ='comments'?>
        <!-- 引入公共侧边栏 -->
        <?php include_once './inc/asides.php'?>
        <script src="../assets/vendors/jquery/jquery.js"></script>
        <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
        <script src="../assets/vendors/template/template-web.js"></script>
        <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
        <script>
            NProgress.done()
        </script>
        <!-- 模板 -->
        <script type="text/html" id='tmp'>
            {{each list v i}}
            <tr>
                <td class="text-center" data-id={{v.id}}><input type="checkbox" class="td-check"></td>
                <td>{{v.author}}</td>
                <td class=''>{{v.content.substr(0,50)+'...'}}</td>
                <td>{{v.title}}</td>
                <td>{{v.created}}</td>
                <td>{{state[v.status]}}</td>
                <td class="text-right" data-id={{v.id}}>
                    {{if v.status=='held'}}
                    <a href="javascript:;" class="btn btn-info btn-xs btn-approved">批准</a> {{/if}}
                    <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
                </td>
            </tr>
            {{ /each }}
        </script>
        <script>
            // 评论的状态转换
            var state = {
                    held: '待审核',
                    approved: '准许',
                    rejected: '拒绝',
                    trashed: '回收站'
                }
                //记录当前页
            var currentPage = 1;

            //封装一个请求指定页面的数据函数渲染
            function render(page) {
                $.ajax({
                    url: './comment/comGet.php',
                    data: {
                        page: page || 1,
                        pageSize: 15
                    },
                    dataType: 'json',
                    success: function(info) {

                        $('tbody').html(template('tmp', {
                            list: info,
                            state: state
                        }));
                        $('.th-check').prop('checked', false);
                    }
                })
            }
            //打开页面后 获取 第一屏数据
            render();
            // ---------生成分页便签----------
            function setPage(page) {
                $.ajax({
                    url: './comment/comTotal.php',
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
                            current_page: page - 1 || 0, //默认0 , 页码比pag 大一 所以减一
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
            // ----------------批准---利用事件委托---------------------
            $('tbody').on('click', '.btn-approved', function() {
                    var id = $(this).parent().attr('data-id'); //获取保存的自定义属性
                    console.log(id);
                    $.ajax({
                        url: './comment/comApproved.php',
                        data: {
                            id: id
                        },
                        success: function(info) {
                            //成功后，重新渲染当前页
                            render(currentPage);
                        }
                    })
                })
                // ----------------删除---利用事件委托---------------------
            $('tbody').on('click', '.btn-del', function() {
                    var id = $(this).parent().attr('data-id');
                    console.log(id);
                    $.ajax({
                        url: './comment/comremove.php',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(info) {

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
                // ---------------全选按钮-------------------
            $('.th-check').on('change', function() {
                    var val = $(this).prop('checked');
                    $('.td-check').prop('checked', val);
                })
                // 当小盒子全部选中后 勾选全选
            $('tbody').on('change', '.td-check', function() {
                //通过判断  .td-check:checked.length 来判断有多少个被点击了
                if ($('.td-check:checked').length === $('.td-check').length) {
                    $('.th-check').prop('checked', true);
                } else {
                    $('.th-check').prop('checked', false);
                }
            })


            // ------------批量选取方法--------------------
            function getId() {
                var idS = [];
                $('.td-check:checked').each(function(v, i) {
                    var s = $(i).parent().attr('data-id');
                    idS.push(s);

                })
                idS = idS.join() //不加参数默认逗号
                console.log(idS);
                return idS;
            }
            //---------------点击批量批准----------------------
            $('.btn-approveds').click(function() {
                    ids = getId();
                    $.ajax({
                        url: './comment/comapproved.php',
                        data: {
                            id: ids
                        },
                        success: function(info) {
                            //成功后，重新渲染当前页
                            render(currentPage);
                        }
                    })
                })
                // -------------------------批量删除-----------------------------------
            $('.btn-dels').click(function() {
                    ids = getId();
                    $.ajax({
                        url: './comment/comremove.php',
                        data: {
                            id: ids
                        },
                        dataType: 'json',
                        success: function(info) {
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
                // --------------------批量拒绝------------------
            $('.btn-rejected').click(function() {
                ids = getId();
                $.ajax({
                    url: './comment/comrejected.php',
                    data: {
                        id: ids
                    },
                    success: function(info) {
                        //成功后，重新渲染当前页
                        render(currentPage);
                    }
                })
            })
        </script>
    </body>

    </html>