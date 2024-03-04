<?php
include 'db.php';

$term = $_GET['term'];

$stmt = $pdo->prepare("SELECT senal_distintiva FROM licencias WHERE senal_distintiva LIKE :term LIMIT 10");
$stmt->execute(['term' => "%$term%"]);
$results = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($results);
?>