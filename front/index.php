<!doctype html>
<html lang="en">
<head>
    <?php include '../include/head_front.php' ?>
    <title>Accueil</title>
    <style>
    
        #carouselExampleIndicators .carousel-inner .carousel-item img {
            max-height: 486px; 
            object-fit: cover; 
        }
    </style>
</head>
<body>
<?php include '../include/nav_front.php' ?>
<div class="container py-2">
    <?php
    require_once '../include/database.php';
    $categoryId = $_GET['id'] ?? NULL;
    $categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_OBJ);
    if (!is_null($categoryId)) {
        $sqlState = $pdo->prepare("SELECT * FROM produit WHERE id_categorie=? ORDER BY date_creation DESC");
        $sqlState->execute([$categoryId]);
        $produits = $sqlState->fetchAll(PDO::FETCH_OBJ);
    } else {
        $produits = $pdo->query("SELECT * FROM produit ORDER BY date_creation DESC")->fetchAll(PDO::FETCH_OBJ);
    }
    $activeClasses = 'active bg-success rounded border-success';
    ?>

    <div id="carouselExampleIndicators" class="carousel slide mb-4" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="4" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="slide4.png" class="d-block w-100" alt="Slide 4">
            </div>
            <div class="carousel-item">
                <img src="slide6.png" class="d-block w-100" alt="Slide 6">
            </div>
            <div class="carousel-item">
                <img src="slide5.png" class="d-block w-100" alt="Slide 5">
            </div>
            <div class="carousel-item">
                <img src="slide7.png" class="d-block w-100" alt="Slide 7">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <ul class="list-group list-group-flush position-sticky sticky-top">
                    <h4 class=" mt-4"><i class="fa fa-light fa-list"></i> Liste des catégories</h4>
                    <li class="list-group-item <?= $categoryId == NULL ? $activeClasses : '' ?>">
                        <a class="btn btn-default w-100" href="./">
                            <i class="fa fa-solid fa-border-all"></i> Voir tous les produits
                        </a>
                    </li>
                    <?php
                    foreach ($categories as $categorie) {
                        $active = $categoryId === $categorie->id ? $activeClasses : '';
                        ?>
                        <li class="list-group-item <?= $active ?>">
                            <a class="btn btn-default w-100"
                               href="index.php?id=<?php echo $categorie->id ?>">
                                <i class="fa <?php echo $categorie->icone ?>"></i> <?php echo $categorie->libelle ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="col mt-4">
                <div class="row">
                    <?php require_once '../include/front/product/afficher_product.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
