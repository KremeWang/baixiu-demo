<?php 
	
	$currentPage = $_POST['currentPage'];
	$pageSize = $_POST['pageSize'];
	$offset = ($currentPage - 1) * $pageSize;

	include_once '../../public/connect.php';
	$conn = connect();

	$sql = "select c.id,c.content,c.author,c.created,c.`status`,p.title from comments c
			left join posts p on p.id = c.post_id
			limit $offset,$pageSize";

	$commentsArr = query($conn, $sql);

	$sqlCount = "select count(*) as count from comments as c";
	$count = query($conn, $sqlCount)[0]['count'];
	$maxPage = ceil($count/$pageSize);
	$response = array('code' => 0, 'msg' => '请求失败');
	if($commentsArr) {
		$response['code'] = 1;
		$response['msg'] = '请求成功'; 
		$response['data'] = $commentsArr;
		$response['maxPage'] = $maxPage;
	}
	echo json_encode($response);

 ?>