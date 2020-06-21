<?php
require_once 'headers.php';
$conn = new mysqli('localhost', 'root', '', 'inventory');

if($_SERVER['REQUEST_METHOD'] === 'GET'){
	// echo 'Get';
	if(isset($_GET['id'])){
		$id =$conn->real_escape_string($_GET['id']);
		$sql = $conn->query("SELECT * FROM prod WHERE id = '$id'");
		$data = $sql->fetch_assoc();
	}else{
		$data = array();
		$sql = $conn->query("SELECT * FROM prod");
		while($d = $sql->fetch_assoc()){
			$data[] = $d;
		}
	}
	exit(json_encode($data));
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	// echo 'Post';
	
	$data = json_decode(file_get_contents("php://input"));

	$sql1 = $conn->query("SELECT item_name FROM prod WHERE item_name = '".$data->item_name."'");
	if(mysqli_num_rows($sql1) > 0){
		echo json_encode('item exist');
	}
	else{
		$sql = $conn->query("INSERT INTO prod(item_name, item_desc, item_count) VALUES('".$data->item_name."', '".$data->item_desc."', '".$data->item_count."')");

	if($sql){
		// $data->id = $conn->insert_id;
		echo json_encode('created');
	}else{
		// exit(json_encode(array('status' => 'error')));

	}
	}


	
}
if($_SERVER['REQUEST_METHOD'] === 'PUT'){
	// echo 'Put';
	if(isset($_GET['id'])){
		$id = $conn->real_escape_string($_GET['id']);
		$data = json_decode(file_get_contents("php://input"));
		$sql = $conn->query("UPDATE prod SET item_name = '".$data->item_name."', item_desc = '".$data->item_desc."', item_count = '".$data->item_count."' WHERE id = '$id'");
		if($sql){
			echo json_encode('success');
			// exit(json_encode(array('status' => 'success')));
		}else{
			echo json_encode('error');
			// exit(json_encode(array('status' => 'error')));
		}
	}
}
if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
	// echo 'Delete';
	if(isset($_GET['id'])){
		$id = $conn->real_escape_string($_GET['id']);
		$sql = $conn->query("DELETE FROM prod WHERE id = '$id'");
		if($sql){
			exit(json_encode(array('status' => 'success')));
		}else{
			exit(json_encode(array('status' => 'error')));
		}
	}
}
?>