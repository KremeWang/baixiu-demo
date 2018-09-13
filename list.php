<?php

    $categoryId = $_GET['categoryId'];
    include_once './public/connect.php';
    $conn = connect();
    $sql = "select p.id,p.title,p.created,p.content,p.views,p.likes,p.feature,c.name,u.nickname,
            (select count(*) from comments where post_id = p.id) as commentsCount
            from posts p
            left join categories c on c.id = p.category_id
            left join users u on u.id = p.user_id
            where p.category_id = {$categoryId}
            limit 10";
    $listArr = query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>阿里百秀-发现生活，发现美!</title>
    <link rel="stylesheet" href="static/assets/css/style.css">
    <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
<div class="wrapper">
    <!-- <div class="topnav">
        <ul>
            <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
            <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
            <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
        </ul>
    </div> -->
    <?php include_once './public/_header.php' ?>
    <?php include_once './public/_aside.php' ?>
    <div class="content">
        <div class="panel new">
            <h3><?=$listArr[3]['name'] ?></h3>
            <?php foreach($listArr as $value) : ?>
            <div class="entry">
                <div class="head">
                    <a href="./detail.php?articleId=<?php echo $value['id'] ?>"> <?php echo $value['title']; ?> </a>
                </div>
                <div class="main">
                    <p class="info"> <?php echo $value['nickname']; ?>  发表于  <?php echo $value['created']; ?> </p>

                    <p class="brief"> <?php echo $value['content']; ?> <p class="extra">
                        <span class="reading">阅读( <?php echo $value['views']; ?> )</span>
                        <span class="comment">评论( <?php echo $value['commentsCount']; ?> )</span>
                        <a href="javascript:;" class="like">
                            <i class="fa fa-thumbs-up"></i>
                            <span>赞( <?php echo $value['likes']; ?> )</span>
                        </a>
                        <a href="javascript:;" class="tags">
                            分类：<span> <?php echo $value['name']; ?> </span>
                        </a>
                    </p>
                    <a href="javascript:;" class="thumb">
                        <img src=" <?php echo $value['feature']; ?> " alt="">
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="loadmore">
                <span class="btn">加载更多</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
</div>

<script src="./static/assets/vendors/jquery/jquery.js"></script>
<script src="./static/assets/vendors/art-template/template-web.js"></script>
<script type="text/template" id="listTem">
    {{each data}}
        <div class="entry">
            <div class="head">
                <a href="./detail.php?articleId={{$value.id}}">{{$value.title}}</a>
            </div>
            <div class="main">
                <p class="info"> {{$value.nickname}} 发表于 {{$value.created}} </p>
                <p class="brief"> {{$value.content}} <p class="extra">
                    <span class="reading">阅读({{$value.views}})</span>
                    <span class="comment">评论({{$value.commentsCount}})</span>
                    <a href="javascript:;" class="like">
                        <i class="fa fa-thumbs-up"></i>
                        <span>赞({{$value.likes}})</span>
                    </a>
                    <a href="javascript:;" class="tags">
                        分类：<span>{{$value.name}}</span>
                    </a>
                </p>
                <a href="javascript:;" class="thumb">
                    <img src="{{$value.feature}}" alt="">
                </a>
            </div>
        </div>
    {{/each}}
</script>
<script>
    //获取分类id
    var categoryId = location.search.split('=')[1];
    var currentPage = 1;
    var pageSize = 10;
    $('.btn').on('click', function() {
        // alert(123);
        $.ajax({
            type:'post',
            url:'./API/getMorePost.php',
            data:{
                categoryId: categoryId,
                currentPage: ++currentPage,
                pageSize:pageSize
            },
            dataType:'json',
            success:function(res) {
                console.log(res);
                var html = template("listTem", res);
                $(html).insertBefore(".loadmore");

                var maxPage = Math.ceil(res.count/pageSize);
                if(currentPage == maxPage){
                    $('.loadmore .btn').hide();
                }
            }
        })
    })
</script>
</body>
</html>