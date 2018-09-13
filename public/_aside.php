<?php 

    // $conn = mysqli_connect('localhost', 'root', 'root', 'xiuer');
    // $sql = "select id,title,feature,views from posts order by rand() limit 5";
    // $res = mysqli_query($conn,$sql);
    // while($row = mysqli_fetch_assoc($res)) {
    //     $aside_arr[] = $row;
    // }
    include_once './public/connect.php';
    $conn = connect();
    $sql = "select id,title,feature,views from posts order by rand() limit 5";
    $aside_arr = query($conn, $sql);

 ?>

<div class="aside">
    <div class="widgets">
        <h4>搜索</h4>

        <div class="body search">
            <form>
                <input type="text" class="keys" placeholder="输入关键字">
                <input type="submit" class="btn" value="搜索">
            </form>
        </div>
    </div>
    <div class="widgets">
        <h4>随机推荐</h4>
        <ul class="body random">
        <?php foreach($aside_arr as $value) { ?>
            <li>
                <a href="javascript:void(0);">
                    <p class="title"><?= $value['title'] ?></p>
                    <p class="reading">阅读(<?= $value['views'] ?>)</p>
                    <div class="pic">
                        <img src="<?php echo $value['feature'] ?>" alt="">
                    </div>
                </a>
            </li>
        <?php } ?>
        </ul>
    </div>
    <div class="widgets">
        <h4>最新评论</h4>
        <ul class="body discuz">
            <li>
                <a href="javascript:;">
                    <div class="avatar">
                        <img src="static/uploads/avatar_1.jpg" alt="">
                    </div>
                    <div class="txt">
                        <p>
                            <span>鲜活</span>9个月前(08-14)说:
                        </p>

                        <p>挺会玩的</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <div class="avatar">
                        <img src="static/uploads/avatar_1.jpg" alt="">
                    </div>
                    <div class="txt">
                        <p>
                            <span>鲜活</span>9个月前(08-14)说:
                        </p>

                        <p>挺会玩的</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <div class="avatar">
                        <img src="static/uploads/avatar_2.jpg" alt="">
                    </div>
                    <div class="txt">
                        <p>
                            <span>鲜活</span>9个月前(08-14)说:
                        </p>

                        <p>挺会玩的</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <div class="avatar">
                        <img src="static/uploads/avatar_1.jpg" alt="">
                    </div>
                    <div class="txt">
                        <p>
                            <span>鲜活</span>9个月前(08-14)说:
                        </p>

                        <p>挺会玩的</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <div class="avatar">
                        <img src="static/uploads/avatar_2.jpg" alt="">
                    </div>
                    <div class="txt">
                        <p>
                            <span>鲜活</span>9个月前(08-14)说:
                        </p>

                        <p>挺会玩的</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <div class="avatar">
                        <img src="static/uploads/avatar_1.jpg" alt="">
                    </div>
                    <div class="txt">
                        <p>
                            <span>鲜活</span>9个月前(08-14)说:
                        </p>

                        <p>挺会玩的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>