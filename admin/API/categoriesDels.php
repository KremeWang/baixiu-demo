<?php 
	
	$ids = $_POST['ids'];
	// echo $ids;

	include_once '../../public/connect.php';
	$conn = connect();
	$sql = "delete from categories where id in ($ids)";
	$bool = mysqli_query($conn,$sql);
	$response = array('code'=>0,'msg'=>'删除失败');
	if($bool){
		$response['code'] = 1;
		$response['msg'] = '删除成功';
	}

	echo json_encode($response);

 ?>