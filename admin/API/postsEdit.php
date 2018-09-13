<?php 

    $postId = $_POST['id'];
    // echo $postId;
    include_once '../../public/connect.php';
    $conn = connect();
    $sql = "select p.id,p.title,p.`status`,p.slug,p.created,p.content,c.`name` from posts p
            left join categories c on p.category_id = c.id
            where p.id = $postId";
    $editArr = query($conn, $sql);

    $response = array('code' => 0, 'msg' => '请求失败');
    if($editArr) {
    	//将获取的数据放入本地存储
    	session_start();
        $_SESSION['editInfo'] = $editArr;

        $response['code'] = 1;
        $response['msg'] = '请求成功';
        $response['data'] = $editArr;
    }

    echo json_encode($response);

?>