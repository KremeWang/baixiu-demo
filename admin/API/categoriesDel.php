<?php 

	$id = $_POST['id'];
	include_once '../../public/connect.php';
	$conn = connect();
	$sql = "delete from categories where id = $id";

	$bool = mysqli_query($conn, $sql);
	$delArr = array('code'=>0,'msg'=>'删除失败');
	if($bool) {
		$delArr['code'] = 1;
		$delArr['msg'] = '删除成功';
	}

	echo json_encode($delArr);

 ?>
