<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Ajouter utilisateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h4>Ajouter utilisateur</h4>
    <?php
    if (isset($_POST['ajouter'])) {
        $login = $_POST['login'];
        $pwd = $_POST['password'];

        if (!empty($login) && !empty($pwd)) {
            require_once 'include/database.php';
            $date = date('Y-m-d');
            $sqlState = $pdo->prepare('INSERT INTO utilisateur VALUES(null,?,?,?)');
            $sqlState->execute([$login, $pwd, $date]);
            header('location: connexion.php');
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                Login et mot de passe sont obligatoires.
            </div>
            <?php
        }

    }
    ?>
    <form method="post" autocomplete="off">
        <div class="form-group">
            <label for="login" class="form-label">Login</label>
            <input type="text" class="form-control" id="login" name="login">
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary my-2" name="ajouter">Ajouter utilisateur</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
