<?php 

        $categoryId = $_POST['categoryId'];
        $currentPage = $_POST['currentPage'];
        $pageSize = $_POST['pageSize'];

        include_once '../public/connect.php';

        $conn = connect();
        $offset = ($currentPage - 1) * $pageSize;
        $sql = "select p.id,p.title,p.created,p.content,p.views,p.likes,p.feature,c.name,u.nickname,
                (select count(*) from comments where post_id = p.id) as commentsCount
                from posts p
                left join categories c on c.id = p.category_id
                left join users u on u.id = p.user_id
                where p.category_id = {$categoryId}
                limit $offset, $pageSize";

        $newArr = query($conn, $sql);

        $count_sql = "select count(*) as count from posts where category_id=$categoryId";
        $count = query($conn,$count_sql)[0]['count'];  

        $response = array("code" => 0, "msg" => '请求失败');
        if($newArr) {
                $response['code'] = 1;
                $response['msg'] = '请求成功';
                $response['data'] = $newArr;
                $response['count'] = $count;
        }

        echo json_encode($response);

 ?>
