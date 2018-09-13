<?php

    $email = $_POST['email'];
    $password = $_POST['password'];

    include_once '../../public/connect.php';
    $conn = connect();
    $sql = "select * from users where email='$email' and password='$password' and status='activated'";
    $userLogin = query($conn, $sql);

    $response = array('code' => 0, 'msg' => '登录失败');
    if($userLogin) {
        session_start();
        $_SESSION['userInfo'] = $userLogin[0];

        $response['code'] = 1;
        $response['msg'] = '用户登录成功';
    }
    echo json_encode($response);

?>