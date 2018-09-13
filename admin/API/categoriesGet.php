<?php 

	include_once '../../public/connect.php';
	$conn = connect();
	$sql = "select * from categories";
	$cateArr = query($conn, $sql);
	$response = array('code' => 0, 'msg' => '数据获取失败');
	if($cateArr) {
		$response['code'] = 1;
		$response['msg'] = '数据获取成功';
		$response['data'] = $cateArr;
	}

	echo json_encode($response);

 ?>