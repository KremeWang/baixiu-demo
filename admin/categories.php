<?php 
    include_once './common/checkLogin.php';
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>Categories &laquo; Admin</title>
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
            <h1>分类目录</h1>
        </div>
        <!-- 有错误信息时展示 -->
        <div class="alert alert-danger" style="display: none;">
          <strong>错误！</strong><span id="error"></span>
        </div>
        <div class="row">
            <div class="col-md-4">
                <form>
                    <h2>添加新分类目录</h2>

                    <div class="form-group">
                        <label for="name">名称</label>
                        <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
                    </div>
                    <div class="form-group">
                        <label for="slug">别名</label>
                        <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
                    </div>                    
                    <div class="form-group">
                        <label for="slug">类名</label>
                        <input id="classname" class="form-control" name="classname" type="text" placeholder="classname">
                    </div>
                    <div class="form-group">
                        <!-- <button class="btn btn-primary" type="submit">添加</button> -->
                        <input type="button" class="btn btn-primary" value="添加" id="btnAdd">
                        <input style="display: none;" type="button" class="btn btn-primary" value="编辑分类" id="btnEdit">
                        <input style="display: none;" type="button" class="btn btn-primary" value="取消编辑" id="btnCancel">
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                <div class="page-action">
                    <!-- show when multiple checked -->
                    <a class="btn btn-danger btn-sm" id="delAll" href="javascript:;" style="display: none">批量删除</a>
                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="text-center" width="40"><input type="checkbox"></th>
                        <th>名称</th>
                        <th>Slug</th>
                        <th>类名</th>
                        <th class="text-center" width="100">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once './common/aside.php'; ?>

<script src="../static/assets/vendors/jquery/jquery.js"></script>
<script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
<script>NProgress.done()</script>
<script src="/static/assets/vendors/art-template/template-web.js"></script>
<!-- 模板引擎1 -->
<script type="text/template" id="categoryTem">
    {{each data}}
        <tr data-categoryId="{{$value.id}}">
            <td class="text-center"><input type="checkbox"></td>
            <td>{{$value.name}}</td>
            <td>{{$value.slug}}</td>
            <td>{{$value.classname}}</td>
            <td class="text-center">
                <a href="javascript:;" data-categoryId="{{$value.id}}" class="edit btn btn-info btn-xs">编辑</a>
                <a href="javascript:;" class="delete btn btn-danger btn-xs">删除</a>
            </td>
        </tr>
    {{/each}}
</script>
<!-- 模板引擎2 -->
<script type="text/template" id="addCategoryTem">
    <tr data-categoryId="{{id}}">
        <td class="text-center"><input type="checkbox"></td>
        <td>{{name}}</td>
        <td>{{slug}}</td>
        <td>{{classname}}</td>
        <td class="text-center">
            <a href="javascript:;" data-categoryId="{{id}}" class="edit btn btn-info btn-xs">编辑</a>
            <a href="javascript:;" class="delete btn btn-danger btn-xs">删除</a>
        </td>
    </tr>
</script>
<script>
    //获取信息
    $.ajax({
        type:'post',
        url:'./API/categoriesGet.php',
        dataType:'json',
        success:function(res) {
            // console.log(res);
            if(res.code == 1) {
                var html = template('categoryTem', res);
                $('tbody').html(html);
            }
        }
    })

    //添加信息
    $('#btnAdd').click(function() {
        var name = $('#name').val();
        var slug = $('#slug').val();
        var classname = $('#classname').val();

        $.ajax({
            type:'post',
            url:'./API/categoriesAdd.php',
            data:{
                name:name,
                slug:slug,
                classname:classname
            },
            dataType:'json',
            beforeSend:function() {
                if(name.trim() == '') {
                    $('.alert').show();
                    $('#error').text('请填写完整姓名!')
                    return false;
                }else if(slug.trim() == '') {
                    $('.alert').show();
                    $('#error').text('请填写完整别名!')
                    return false;
                }else if(classname.trim() == '') {
                    $('.alert').show();
                    $('#error').text('请填写完整类名!')
                    return false;
                }
            },
            success:function(res) {
                if(res.code == 1) {
                    console.log(res);
                    var html = template('addCategoryTem',{'id':res.addId,"name":name,"slug":slug,"classname":classname});
                    // console.log(html);
                    $(html).appendTo('tbody');
                    //清空
                    $('#name').val("");
                    $('#slug').val("");
                    $('#classname').val("");
                }else {
                    $('.alert').show();
                    $('#error').text(res.msg)
                }
            }
        })
    })

    //编辑信息
    var that;
    $('tbody').on('click', '.edit', function() {
        //绑定id
        var categoryId = $(this).attr('data-categoryId');
        // alert(categoryId);
        $('#btnEdit').attr('data-categoryId', categoryId);
        //获取数据显示在编辑页面
        that = this;

        var name = $(this).parent().parent().children().eq(1).text();
        var slug = $(this).parent().parent().children().eq(2).text();
        var classname = $(this).parent().parent().children().eq(3).text();
        $('#name').val(name);
        $('#slug').val(slug);
        $('#classname').val(classname);

        //按钮的显示隐藏
        $('#btnAdd').hide();
        $('#btnEdit').show();
        $('#btnCancel').show();
    })

    $('#btnEdit').on('click', function () {
        // 收集更新数据
        var id = $(this).attr('data-categoryId');
        var name = $('#name').val();
        var slug = $('#slug').val();
        var classname = $('#classname').val();

        // 发送更新信息
        $.ajax({
            type: 'post',
            url: './API/categoriesEdit.php',
            data: {
                id: id, 
                name: name, 
                slug: slug, 
                classname: classname
            },
            beforeSend: function () {
                if(name.trim() == '') {
                    $('.alert').show();
                    $('#error').text('请填写完整姓名!')
                    return false;
                }else if(slug.trim() == '') {
                    $('.alert').show();
                    $('#error').text('请填写完整别名!')
                    return false;
                }else if(classname.trim() == '') {
                    $('.alert').show();
                    $('#error').text('请填写完整类名!')
                    return false;
                }else {
                    $('.alert').hide();
                    $('#error').text('');
                }
            },
            dataType: 'json',
            success: function (res) {
                // console.log(res);
                if (res.code == 1) {
                    $(that).parent().parent().children().eq(1).text(name);
                    $(that).parent().parent().children().eq(2).text(slug);
                    $(that).parent().parent().children().eq(3).text(classname);

                    $('#name').val('');
                    $('#slug').val('');
                    $('#classname').val('');

                    $('#btnAdd').show();
                    $('#btnEdit').hide();
                    $('#btnCancel').hide();
                } else {
                    $('.alert').show();
                    $('#error').text(res.msg);
                }
            }
        })
    })

    //编辑取消
    $('#btnCancel').on('click', function() {
        $('#name').val('');
        $('#slug').val('');
        $('#classname').val('');

        $('#btnAdd').show();
        $('#btnEdit').hide();
        $('#btnCancel').hide();
    })


    //删除信息
    $('tbody').on('click', '.delete', function() {
        var categoryId = $(this).parent().parent().attr('data-categoryId');
        // console.log(categoryId);
        var current = this;
        $.ajax({
            type:'post',
            url:'./API/categoriesDel.php',
            dataType:'json',
            data:{id:categoryId},
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

    //复选框全选按钮事件
    $('thead :checkbox').on('click',function(){
        var status = $(this).prop('checked');
        var cks  = $('tbody :checkbox');
       
        cks.prop('checked',status);
        // 批量显示铵钮是否显示
        if(status){
            $('#delAll').show();
        }else{
            $('#delAll').hide();
        }
    })

    // 检测复选框是否全选及批量删除是否显示
    $('tbody').on('click',':checkbox',function(){
        var checkedbox = $('tbody :checkbox:checked');
        var cks = $('tbody :checkbox');
        var All = $('thead :checkbox');

        if(checkedbox.length == cks.length){
            All.prop('checked',true);
        }else {
            All.prop('checked', false);
        }
        if(checkedbox.length >= 2){
            $('#delAll').show();
        }else{
            $('#delAll').hide();
        }
    })


    // 批量删除
    $('#delAll').on('click',function(){
        var checkedList = $('tbody :checkbox:checked');
        var arr = [];
        checkedList.each(function(index,dom){
          id = $(dom).parent().parent().attr('data-categoryId');
          // console.log(id);
          arr.push(id);
        })
        ids = arr.join(',');
        // console.log(ids);
        $.ajax({
            type:'post',
            url:'./API/categoriesDels.php',
            data:{
                ids:ids
            },
            dataType:'json',
            success:function(res){
                // console.log(res);
                if(res.code == 1){
                    checkedList.parent().parent().remove();
                    // alert(13);
                    $('#delAll').hide();
                }
            }
        })
    })

</script>
</body>
</html>
