<?php
require_once 'headers.php';
$conn = new mysqli('localhost', 'root', '', 'inventory');


if($_SERVER['REQUEST_METHOD'] === 'PUT'){
	// echo 'Put';
	if(isset($_GET['id'])){
		$status = "out";
		$id = $conn->real_escape_string($_GET['id']);
		$data = json_decode(file_get_contents("php://input"));
		$sql = $conn->query("UPDATE prod SET item_count = item_count - '".$data->item_out."' WHERE id = '".$data->id."' ");

		$data = json_decode(file_get_contents("php://input"));
		$sql1 = $conn->query("INSERT INTO caterprod(prod_id, count, status)VALUES('".$data->id."', '".$data->item_out."', '".$status."')");

		if($sql && $sql1){
			exit(json_encode(array('status' => 'success')));
		}else{
			exit(json_encode(array('status' => 'error')));
		}
	}
		// // $id = $conn->real_escape_string($_GET['id']);
		// $data = json_decode(file_get_contents("php://input"));
		// $sql1 = $conn->query("INSERT INTO caterprod(prodid, count)VALUES('".$data->id."', '".$data->item_in."')");
		
}