<?php
require_once 'headers.php';
$conn = new mysqli('localhost', 'root', '', 'inventory');


if($_SERVER['REQUEST_METHOD'] === 'PUT'){
	// echo 'Put';
	if(isset($_GET['id'])){

		$status = "out";
		$id = $conn->real_escape_string($_GET['id']);
		$data = json_decode(file_get_contents("php://input"));


		$data1 = $conn->query("SELECT item_count FROM prod WHERE id = '".$data->id."'");
		$res = $data1->fetch_array();
		$ss = array_shift($res);
		if($ss == 0){
			echo json_encode('insufficient');
		}elseif($data->item_out >  $ss) {
			echo json_encode('ops');
		}
		
		else{

		$sql = $conn->query("UPDATE prod SET item_count = item_count - '".$data->item_out."' WHERE id = '".$data->id."' ");

		// $data = json_decode(file_get_contents("php://input"));
		$sql1 = $conn->query("INSERT INTO caterprod(prod_id, count, status)VALUES('".$data->id."', '".$data->item_out."', '".$status."')");

		if($sql && $sql1){
			// exit(json_encode(array('status' => 'success')));
			echo json_encode('success');
		}else{
			echo json_encode('error')
			// exit(json_encode(array('status' => 'error')));
		}

		}



	
	}
		// // $id = $conn->real_escape_string($_GET['id']);
		// $data = json_decode(file_get_contents("php://input"));
		// $sql1 = $conn->query("INSERT INTO caterprod(prodid, count)VALUES('".$data->id."', '".$data->item_in."')");
		
}