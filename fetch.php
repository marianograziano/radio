
<?php
include 'db.php';

$senal_distintiva = $_GET['senal_distintiva'];

$stmt = $pdo->prepare("SELECT * FROM licencias WHERE senal_distintiva = :senal_distintiva");
$stmt->execute(['senal_distintiva' => $senal_distintiva]);

$result = $stmt->fetch();

echo json_encode($result);
?>
