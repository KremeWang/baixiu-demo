<?php 

	$name = $_POST['name'];
	$slug = $_POST['slug'];
	$classname = $_POST['classname'];

	include_once '../../public/connect.php';

	$conn = connect();
	$sql = "select count(*) as count from categories where name = '$name'";
	$cateArr = query($conn, $sql);

	$response = array('code' => 0, 'msg' => '信息添加失败');
	if($cateArr[0]['count'] > 0) {
		$response['msg'] = '姓名重复,请重新输入';
	}else {
		$sqlAdd = "insert into categories values(null, '$slug', '$name', '$classname')";
		$bool = mysqli_query($conn,$sqlAdd);
		$addId = mysqli_insert_id($conn);
		if($bool) {
			$response['code'] = 1;
			$response['msg'] = '信息添加成功';
			$response['addId'] = $addId;
		}
	}

	echo json_encode($response);

 ?>