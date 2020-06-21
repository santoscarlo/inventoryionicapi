<?php
require_once 'headers.php';
$conn = new mysqli('localhost', 'root', '', 'inventory');


if($_SERVER['REQUEST_METHOD'] === 'GET'){
	$data = array();
	$sql = $conn->query("SELECT sum(count) as totalout FROM caterprod WHERE status = 'out'");
	while ($d = $sql->fetch_assoc()) {
		$data[] = $d;
	}
	exit(json_encode($data));
}