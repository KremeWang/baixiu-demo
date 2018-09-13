<?php 
    include_once './common/checkLogin.php';
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>Posts &laquo; Admin</title>
    <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
    <link rel="stylesheet" href="../static/assets/css/admin.css">
    <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
<script>NProgress.start()</script>

<div class="main">
    <?php include_once './common/nav-bar.php'; ?>

    <div class="container-fluid">
        <div class="page-title">
            <h1>所有文章</h1>
            <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
        </div>
        <!-- 有错误信息时展示 -->
        <div class="alert alert-danger" style="display: none;">
          <strong>错误！</strong><span id="error"></span>
        </div>
        <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" id="btnAll" href="javascript:;" style="display: none">批量删除</a>

            <form class="form-inline">
                <select name="" id="category" class="form-control input-sm">
                    <!-- 分类占位 -->
                </select>
                <select name="" id="status" class="form-control input-sm">
                    <option value="all">所有状态</option>
                    <option value="drafted">草稿</option>
                    <option value="published">已发布</option>
                    <option value="trashed">已作废</option>
                </select>
                <!-- <button class="btn btn-default btn-sm">筛选</button> -->
                <input type="button" class="btn btn-default btn-sm" value="筛选" id="btnFilter">
            </form>
            <ul class="pagination pagination-sm pull-right">
                <!-- 分页占位 -->
            </ul>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>标题</th>
                <th>作者</th>
                <th>分类</th>
                <th class="text-center">发表时间</th>
                <th class="text-center">状态</th>
                <th class="text-center" width="100">操作</th>
            </tr>
            </thead>
            <tbody>
                <!-- 表格占位 -->
            </tbody>
        </table>
    </div>
</div>

<?php include_once './common/aside.php'; ?>


<script src="../static/assets/vendors/jquery/jquery.js"></script>
<script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
<script>NProgress.done()</script>
<script src="/static/assets/vendors/art-template/template-web.js"></script>
<!-- 表格模板 -->
<script type="text/template" id="templateData">
    {{each data}}
        <tr data-categoryId="{{$value.id}}">
            <td class="text-center"><input type="checkbox"></td>
            <td>{{$value.title}}</td>
            <td>{{$value.nickname}}</td>
            <td>{{$value.name}}</td>
            <td class="text-center">{{$value.created}}</td>
            <td class="text-center">
                {{if($value.status == 'drafted')}}
                    草稿
                {{else if($value.status == 'published')}}
                    已发布
                {{else if($value.status == 'trashed')}}
                    已作废
                {{/if}}
            </td>
            <td class="text-center">
                <a href="javascript:;" data-postsId="{{$value.id}}" class="btn btn-default btn-xs" id="btnEdit">编辑</a>
                <a href="javascript:;" data-postsId="{{$value.id}}" class="btn btn-danger btn-xs" id="btnDel">删除</a>
            </td>
        </tr>
    {{/each}}
</script>
<!-- 分页模板 -->
<script type="text/template" id="pageTem">
    <li {{if(currentPage - 1 < 1)}} style="display: none;" {{/if}} data-page="{{currentPage - 1}}"><a href="#">上一页</a></li>
    <li {{if(currentPage - 2 < 1)}} style="display: none;" {{/if}} data-page="{{currentPage - 2}}"><a href="#">{{currentPage - 2}}</a></li>
    <li {{if(currentPage - 1 < 1)}} style="display: none;" {{/if}} data-page="{{currentPage - 1}}"><a href="#">{{currentPage - 1}}</a></li>
    <li class="active" data-page="{{currentPage}}"><a href="#">{{currentPage}}</a></li>
    <li {{if(currentPage + 1 > maxPage)}} style="display: none;" {{/if}} data-page="{{currentPage + 1}}"><a href="#">{{currentPage + 1}}</a></li>
    <li {{if(currentPage + 2 > maxPage)}} style="display: none;" {{/if}} data-page="{{currentPage + 2}}"><a href="#">{{currentPage + 2}}</a></li>
    <li {{if(currentPage + 1 > maxPage)}} style="display: none;" {{/if}} data-page="{{currentPage + 1}}"><a href="#">下一页</a></li>
</script>
<script>
    $(function() {
        
        var currentPage = 1;
        var pageSize = 10;
        var category = 'all';
        var status = 'all';
        //获取数据
        $.ajax({
            type:'post',
            url:'./API/postsGet.php',
            data:{
                'currentPage':currentPage,
                'pageSize':pageSize,
                'category':category,
                'status':status
            },
            dataType:'json',
            success:function(res) {
                if(res.code == 1) {
                    var html = template('templateData',res);
                    // console.log(html);
                    $('tbody').html(html);

                    var maxPage = Math.ceil(res.count/pageSize);
                    var pageTemHtml = template('pageTem',{'currentPage':currentPage,'maxPage':maxPage});
                    $('.pagination').html(pageTemHtml);
                }
            }
        })

        //分页显示
        $('.pagination').on('click', 'li', function() {
            var currentPage = parseInt($(this).attr('data-page'));
            $.ajax({
                type:'post',
                url:'./API/postsGet.php',
                data:{
                    'currentPage':currentPage,
                    'pageSize':pageSize,
                    'category':category,
                    'status':status
                },
                dataType:'json',
                success:function(res) {
                    if(res.code == 1) {
                        var html = template('templateData',res);
                        $('tbody').html(html);

                        var maxPage = Math.ceil(res.count/pageSize);
                        var pageTemHtml = template('pageTem',{'currentPage':currentPage,'maxPage':maxPage});
                        $('.pagination').html(pageTemHtml);
                    }
                }
            })
        })

        //分类数据获取
        $.ajax({
            type:'post',
            url:'./API/categoriesGet.php',
            dataType:'json',
            success:function(res) {
                if(res.code == 1) {
                    var str = '<option value="all">所有分类</option>';
                    $.each(res.data, function(index, value) {
                        str += '<option value="'+value.id+'">'+value.name+'</option>';
                    })
                    $('#category').html(str);
                }
            }
        })

        //筛选事件绑定
        $('#btnFilter').on('click', function() {
            category = $('#category').val();
            status = $('#status').val();
            // alert(category + '------' + status);
            $.ajax({
                type:'post',
                url:'./API/postsGet.php',
                data:{
                    'currentPage':currentPage,
                    'pageSize':pageSize,
                    'category':category,
                    'status':status
                },
                dataType:'json',
                success:function(res) {
                    // console.log(res);
                    if(res.code == 1) {
                        var html = template('templateData',res);
                        $('tbody').html(html);

                        var maxPage = Math.ceil(res.count/pageSize);
                        var pageTemHtml = template('pageTem',{'currentPage':currentPage,'maxPage':maxPage});
                        $('.pagination').html(pageTemHtml);
                    }
                }
            })
        })

        //删除数据
        $('tbody').on('click', '#btnDel', function() {
            var postsId = $(this).attr('data-postsId');
            // console.log(postsId);
            var current = this;
            $.ajax({
                type:'post',
                url:'./API/postsDel.php',
                dataType:'json',
                data:{
                    id:postsId
                },
                success:function(res) {
                    if(res.code == 1) {
                        $(current).parent().parent().remove();
                    }else {
                        $('.alert').show();
                        $('#error').text(res.msg);
                    }
                }
            })
        })

        //全选与反选
        //全选框按钮注册点击事件
        $('thead :checkbox').on('click',function() {
            var status = $(this).prop('checked');  //获取当前全选按钮的checked状态
            var navStatus = $('tbody :checkbox');  //获取所有子选框
            navStatus.prop('checked', status);     //将全选按钮的状态同步到所有的子选框
            if(status) { 
                $('#btnAll').show();
            }else {
                $('#btnAll').hide();
            }
        })

        //子选框按钮注册点击事件
        $('tbody').on('click', ':checkbox', function() {
            var navChecked = $('tbody :checkbox:checked');  //获取所有被选中的子选框
            var navCheckbox = $('tbody :checkbox');  //获取子选框
            var allCheckbox = $('thead :checkbox');  //获取全选框
            if(navChecked.length == navCheckbox.length) {
                allCheckbox.prop('checked', true);
            }else {
                allCheckbox.prop('checked', false);
            }
            if(navChecked.length >= 2){
                $('#btnAll').show();
            }else{
                $('#btnAll').hide();
            }
        })

        //给批量删除按钮注册点击事件
        $('#btnAll').on('click', function() {
            //获取被选中的子选框
            var navCheckboxLists = $('tbody :checkbox:checked');
            var arr = [];
            //遍历被选中的子选框,获取id对应的一栏
            navCheckboxLists.each(function(index,dom) {
                id = $(dom).parent().parent().attr('data-categoryId');
                // console.log(id);
                arr.push(id);
            }) 
            ids = arr.join(',');
            // console.log(ids);
            $.ajax({
                type: 'post',
                url: './API/postsDels.php',
                data: {
                    ids: ids
                },
                dataType: 'json',
                success: function(res) {
                    // console.log(res);
                    if(res.code == 1) {
                        navCheckboxLists.parent().parent().remove();
                        $('#btnAll').hide();
                    }
                }
            })

        })

        //编辑文章内容,给编辑按钮注册点击事件
        $('tbody').on('click', '#btnEdit' ,function() {
            //获取id对应的id值
            var postId = $(this).attr('data-postsId');
            // console.log(postId);
            $.ajax({
                type: 'post',
                url: './API/postsEdit.php',
                data: {
                    id: postId
                },
                dataType: 'json',
                success: function(res) {
                    // console.log(res);
                    if(res.code == 1) {
                        // alert(111);
                        window.location.href = "http://www.xiuer.com/admin/post-add.php";
                    }
                }
            })
        })

    })

</script>
</body>
</html>
