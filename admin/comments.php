<?php 
    include_once './common/checkLogin.php';
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>Comments &laquo; Admin</title>
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
            <h1>所有评论</h1>
        </div>
        <!-- 有错误信息时展示 -->
        <!-- <div class="alert alert-danger">
          <strong>错误！</strong>发生XXX错误
        </div> -->
        <div class="page-action">
            <!-- show when multiple checked -->
            <div class="btn-batch" style="display: none">
                <button class="btn btn-info btn-sm">批量批准</button>
                <button class="btn btn-warning btn-sm">批量拒绝</button>
                <button class="btn btn-danger btn-sm">批量删除</button>
            </div>
            <ul class="pagination pagination-sm pull-right">
                <!-- 分页占位 -->
            </ul>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>作者</th>
                <th>评论</th>
                <th>评论在</th>
                <th>提交于</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
            </tr>
            </thead>
            <tbody>
                <!-- 数据占位 -->
            </tbody>
        </table>
    </div>
</div>
<?php include_once './common/aside.php'; ?>


<script src="../static/assets/vendors/jquery/jquery.js"></script>
<script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
<script>NProgress.done()</script>
<script src="/static/assets/vendors/art-template/template-web.js"></script>
<script src="/static/assets/vendors/twbs-pagination/jquery.twbspagination.js"></script>
<script type="text/template" id="commentsTem">
    {{each data}}
        <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{$value.author}}</td>
            <td width="400px">{{$value.content}}</td>
            <td>{{$value.title}}</td>
            <td>{{$value.created}}</td>
            <td>
                {{if($value.status == 'held')}}
                    已搁置
                {{else if($value.status == 'approved')}}
                    已批准
                {{else if($value.status == 'rejected')}}
                    已驳回
                {{/if}}
            </td>
            <td class="text-center">
                <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
                <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
        </tr>
    {{/each}}
</script>
<script>
    $(function() {
        
        var currentPage = 1;
        var pageSize = 10;
        
        //封装函数
        function getComments(currentPage, pageSize) {
            //获取数据
            $.ajax({
                type:'post',
                url:'./API/commentsDataGet.php',
                data:{
                    'currentPage':currentPage,
                    'pageSize':pageSize,
                },
                dataType:'json',
                success:function(res) {
                    if(res.code == 1) {
                        var html = template('commentsTem',res);
                        // console.log(html);
                        $('tbody').html(html);

                        //第三方插件显示分页数据
                        $('.pagination').twbsPagination({
                            totalPages: res.maxPage,
                            visiblePages : 7,
                            onPageClick:function(event, page) {
                                getComments(page,pageSize)
                            }
                        })
                    }
                }
            })
        }

        //页面加载时获取数据
        getComments(currentPage,pageSize); 

    })
</script>
</body>
</html>
