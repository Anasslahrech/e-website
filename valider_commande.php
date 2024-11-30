<?php
include_once 'include/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$etat = isset($_GET['etat']) ? (int)$_GET['etat'] : 0;

if ($id <= 0 || ($etat !== 0 && $etat !== 1)) {
    die('Invalid parameters.');
}

try {
    $sqlState = $pdo->prepare('UPDATE commande SET valide = ? WHERE id = ?');
    $sqlState->execute([$etat, $id]);
    header('Location: commande.php?id=' . $id);
    exit;
} catch (PDOException $e) {
 
    die('Database error: ' . $e->getMessage());
}
?>
