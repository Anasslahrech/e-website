<?php
require_once 'include/database.php';
$idCommande = $_GET['id'];
$sqlState = $pdo->prepare('SELECT commande.*, utilisateur.login as "login" FROM commande 
            INNER JOIN utilisateur ON commande.id_client = utilisateur.id 
            WHERE commande.id = ?
            ORDER BY commande.date_creation DESC');
$sqlState->execute([$idCommande]);
$commande = $sqlState->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
 
    echo "Commande not found.";
    exit;
}

?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Commande | Numéro <?= htmlspecialchars($commande['id']) ?> </title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h2>Détails Commandes</h2>
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
        $sqlStateLigneCommandes = $pdo->prepare('SELECT ligne_commande.*, produit.libelle, produit.image FROM ligne_commande
                                                        INNER JOIN produit ON ligne_commande.id_produit = produit.id
                                                        WHERE id_commande = ?
                                                        ');
        $sqlStateLigneCommandes->execute([$idCommande]);
        $lignesCommandes = $sqlStateLigneCommandes->fetchAll(PDO::FETCH_OBJ);
        ?>
        <tr>
            <td><?php echo htmlspecialchars($commande['id']) ?></td>
            <td><?php echo htmlspecialchars($commande['login']) ?></td>
            <td><?php echo htmlspecialchars($commande['total']) ?> <i class="fa fa-solid fa-dollar"></i></td>
            <td><?php echo htmlspecialchars($commande['date_creation']) ?></td>
            <td>
                <?php if (isset($commande['valide']) && $commande['valide'] == 0) : ?>
                    <a class="btn btn-success btn-sm" href="valider_commande.php?id=<?= htmlspecialchars($commande['id']) ?>&etat=1">Valider la commande</a>
                <?php else: ?>
                    <a class="btn btn-danger btn-sm" href="valider_commande.php?id=<?= htmlspecialchars($commande['id']) ?>&etat=0">Annuler la commande</a>
                <?php endif; ?>
            </td>
            <td>
            </td>
        </tr>
        <?php
        ?>
        </tbody>
    </table>
    <hr>
    <h2>Produits : </h2>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#ID</th>
            <th>Produit</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lignesCommandes as $lignesCommande) : ?>
            <tr>
                <td><?php echo htmlspecialchars($lignesCommande->id) ?></td>
                <td><?php echo htmlspecialchars($lignesCommande->libelle) ?></td>
                <td><?php echo htmlspecialchars($lignesCommande->prix) ?> <i class="fa fa-solid fa-dollar"></i></td>
                <td>x <?php echo htmlspecialchars($lignesCommande->quantite) ?></td>
                <td><?php echo htmlspecialchars($lignesCommande->total) ?> <i class="fa fa-solid fa-dollar"></i></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
