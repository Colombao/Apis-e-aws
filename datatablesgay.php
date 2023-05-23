<?php
include "conexao.php";

$db = new Db();
$conn = $db->conn();

$sql = "SELECT * FROM csv";
$stmt = $conn->query($sql);

$data = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
