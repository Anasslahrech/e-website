
<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Résultats de la recherche</title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h2>Résultats de la recherche</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Libelle</th>
                <th>Prix</th>
                <th>Discount</th>
                <th>Catégorie</th>
                <th>Image</th>
                <th>Date de création</th>
                <th>Opérations</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(isset($_GET['q']) && !empty($_GET['q'])) {
            
            $searchTerm = $_GET['q'];
            
            require_once 'include/database.php';
            
          
            $stmt = $pdo->prepare("SELECT produit.*, categorie.libelle AS 'categorie_libelle' FROM produit INNER JOIN categorie ON produit.id_categorie = categorie.id WHERE produit.libelle LIKE ?");

            $stmt->execute(["%$searchTerm%"]);
            $produits = $stmt->fetchAll(PDO::FETCH_OBJ);
            
          
            foreach ($produits as $produit) {
                $prix = $produit->prix;
                $discount = $produit->discount;
                $prixFinale = $prix - (($prix * $discount) / 100);
                ?>
                <tr>
                    <td><?= $produit->id ?></td>
                    <td><?= $produit->libelle ?></td>
                    <td><?= $prix ?> <i class="fa fa-solid fa-dollar"></i></td>
                    <td><?= $discount ?> %</td>
                    <td><?= $produit->categorie_libelle ?></td>
                    <td><?= $produit->date_creation ?></td>
                    <td><img class="img-fluid" width="90" src="upload/produit/<?= $produit->image ?>" alt="<?= $produit->libelle ?>"></td>
                    <td>
                        <a class="btn btn-primary" href="modifier_produit.php?id=<?= $produit->id ?>">Modifier</a>
                        <a class="btn btn-danger" href="supprimer_produit.php?id=<?= $produit->id ?>" onclick="return confirm('Voulez-vous vraiment supprimer le produit <?= $produit->libelle ?> ?')">Supprimer</a>
                    </td>
                </tr>
                <?php
            }
        } else {
           
            echo "<tr><td colspan='8'>Aucun résultat trouvé.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
