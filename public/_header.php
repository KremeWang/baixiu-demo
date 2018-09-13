<?php 
    include_once './public/connect.php';
    // $conn = mysqli_connect('localhost', 'root', 'root', 'xiuer');
    $conn = connect();
    $sql = "select * from categories";
    // $res = mysqli_query($conn,$sql);
    // while($row = mysqli_fetch_assoc($res)) {
    //     $header_arr[] = $row;
    // }
    // var_dump($header_arr);
    $header_arr = query($conn, $sql);

 ?>

<div class="header">
    <h1 class="logo"><a href="index.php"><img src="static/assets/img/logo.png" alt=""></a></h1>
    <ul class="nav">
        <!-- <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li> -->
        <!-- <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li> -->
        <!-- <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li> -->
        <!-- <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li> -->
        <?php foreach ($header_arr as $value) { ?>
            <li>
                <a href="./list.php?categoryId=<?php echo $value['id']; ?>">
                    <i class="fa <?= $value['classname'] ?>"></i>
                    <?= $value['name'] ?>
                </a>
            </li>
        <?php } ?>
    </ul>
    <div class="search">
        <form>
            <input type="text" class="keys" placeholder="输入关键字">
            <input type="submit" class="btn" value="搜索">
        </form>
    </div>
    <div class="slink">
        <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
    </div>
</div>
