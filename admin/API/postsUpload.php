<?php 

	$file = $_FILES['file'];

	$ext = strrchr($file['name'], '.');

	$filename = time().rand(1, 9999).$ext;

	$bool = move_uploaded_file($file['tmp_name'], "../../static/uploads/" . $filename);

	$response = array('code' => 0, 'msg' => '上传失败');

	if($bool) {
		$response['code'] = 1;
		$response['msg'] = '上传成功';
		$response['src'] = '/static/uploads/' . $filename;
	}

	echo json_encode($response);

 ?>