<?php
session_start();
$connecte = false;
if (isset($_SESSION['utilisateur'])) {
    $connecte = true;
}

// Connexion à la base de données (à remplacer par vos propres informations de connexion)
$servername = "localhost";
$username = "votre_nom_utilisateur";
$password = "votre_mot_de_passe";
$dbname = "votre_base_de_données";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifier si une recherche a été soumise
if(isset($_GET['q'])) {
    $search_query = $_GET['q'];
    // Requête SQL pour rechercher des produits par nom ou description
    $sql_products = "SELECT * FROM produits WHERE nom LIKE '%$search_query%' OR description LIKE '%$search_query%'";
    $result_products = $conn->query($sql_products);

    // Requête SQL pour rechercher des catégories par nom
    $sql_categories = "SELECT * FROM categories WHERE nom LIKE '%$search_query%'";
    $result_categories = $conn->query($sql_categories);

    // Affichage des résultats
    echo "<h3>Résultats de la recherche :</h3>";
    echo "<ul>";
    // Affichage des produits
    if ($result_products->num_rows > 0) {
        echo "<h4>Produits :</h4>";
        while($row = $result_products->fetch_assoc()) {
            echo "<li>Produit: " . $row["nom"]. " - Description: " . $row["description"]. "</li>";
        }
    }

    // Affichage des catégories
    if ($result_categories->num_rows > 0) {
        echo "<h4>Catégories :</h4>";
        while($row = $result_categories->fetch_assoc()) {
            echo "<li>Catégorie: " . $row["nom"]. "</li>";
        }
    }

    echo "</ul>";
}

$conn->close();
?>
