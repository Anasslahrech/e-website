<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Résultat de la recherche</title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h2>Résultat de la recherche</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Client</th>
                <th>Total</th>
                <th>Date</th>
                <th>Opérations</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(isset($_GET['id_commande']) && !empty($_GET['id_commande'])) {
           
            $idCommande = $_GET['id_commande'];
            
            require_once 'include/database.php';
            
            $stmt = $pdo->prepare("SELECT commande.*, utilisateur.login as 'login' FROM commande INNER JOIN utilisateur ON commande.id_client = utilisateur.id WHERE commande.id = ?");
            $stmt->execute([$idCommande]);
            $commande = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($commande) {
                ?>
                <tr>
                    <td><?= $commande['id'] ?></td>
                    <td><?= $commande['login'] ?></td>
                    <td><?= $commande['total'] ?> <i class="fa fa-solid fa-dollar"></i></td>
                    <td><?= $commande['date_creation'] ?></td>
                    <td><a class="btn btn-primary btn-sm" href="commande.php?id=<?= $commande['id'] ?>">Afficher détails</a></td>
                </tr>
                <?php
            } else {
               
                echo "<tr><td colspan='5'>Aucun résultat trouvé pour l'ID de commande spécifié.</td></tr>";
            }
        } else {
          
            echo "<tr><td colspan='5'>Veuillez spécifier un ID de commande pour effectuer la recherche.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
