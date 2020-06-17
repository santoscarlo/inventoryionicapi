<?php
require_once 'headers.php';
$conn = new mysqli('localhost', 'root', '', 'inventory');


if($_SERVER['REQUEST_METHOD'] === 'GET'){
	$data = array();
	$sql = $conn->query("SELECT sum(count) as totalin FROM caterprod WHERE status = 'in'");
	while ($d = $sql->fetch_assoc()) {
		$data[] = $d;
	}
	exit(json_encode($data));
}