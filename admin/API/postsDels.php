<?php 

	$ids = $_POST['ids'];
	include_once '../../public/connect.php';

	$conn = connect();
	$sql = "delete from posts where id in ($ids)";
	$delsArr = mysqli_query($conn, $sql);

	$response = array('code' => 0, 'msg' => '删除失败');
	if($delsArr) {
		$response['code'] = 1;
		$response['msg'] = '删除成功';
	}

	echo json_encode($response);

 ?>