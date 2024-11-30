<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Résultats de la recherche</title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h2>Résultats de la recherche</h2>
    
    <?php
    
    if(isset($_GET['search'])) {
        $search = $_GET['search'];
   
        require_once 'include/database.php';
        $sqlState = $pdo->prepare("SELECT * FROM categorie WHERE libelle LIKE ?");
        $sqlState->execute(["%$search%"]);
        $categories = $sqlState->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($categories) > 0) {
        
            ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Libelle</th>
                        <th>Description</th>
                        <th>Icone</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categories as $categorie): ?>
                        <tr>
                            <td><?php echo $categorie['id'] ?></td>
                            <td><?php echo $categorie['libelle'] ?></td>
                            <td><?php echo $categorie['description'] ?></td>
                            <td><i class="fa <?php echo $categorie['icone'] ?>"></i></td>
                            <td><?php echo $categorie['date_creation'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
        } else {
           
            echo "<p>Aucune catégorie correspondante trouvée.</p>";
        }
    } else {
        
        header('Location: liste_des_categories.php');
        exit();
    }
    ?>
</div>
</body>
</html>
