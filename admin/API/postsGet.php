<?php 
	
	$currentPage = $_POST['currentPage'];
	$pageSize = $_POST['pageSize'];
	$category = $_POST['category'];
	$status = $_POST['status'];
	$offset = ($currentPage - 1) * $pageSize;

	include_once '../../public/connect.php';
	$conn = connect();
	
	$where = " 1=1 ";
	if($category != 'all') {
		$where .= " and p.category_id = '$category'";
	}
	if($status != 'all') {
		$where .= " and p.status = '$status'";
	}

	$sql = "select p.id,p.title,p.created,p.status,u.nickname,c.name from posts p 
			left join users u on u.id = p.user_id
			left join categories c on c.id = p.category_id
			where $where
			order by p.created desc
			limit $offset,$pageSize";
	$getArr = query($conn, $sql);
	// echo $getArr
	
	$sqlCount = "select count(*) as count from posts as p where $where";
	$count = query($conn, $sqlCount)[0]['count'];

	$response = array('code'=>1,'msg'=>'请求失败');
	
	if($getArr) {
		$response['code'] = 1;
		$response['msg'] = '请求成功';
		$response['data'] = $getArr;
		$response['count'] = $count;
	}
	echo json_encode($response);

 ?>