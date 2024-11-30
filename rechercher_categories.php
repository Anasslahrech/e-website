<?php

if(isset($_GET['search'])) {
    $search = $_GET['search'];

    require_once 'include/database.php';
    $sqlState = $pdo->prepare("SELECT * FROM categorie WHERE libelle LIKE ?");
    $sqlState->execute(["%$search%"]);
    $categories = $sqlState->fetchAll(PDO::FETCH_ASSOC);

    header('Location: afficher_categories.php?search=' . urlencode($search));
    exit();
} else {
    
    header('Location: liste_des_categories.php');
    exit();
}
?>
