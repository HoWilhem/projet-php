<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=accueil">Wallets</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=accueil">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=wallet">Portefeuille</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=contact">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php 
                // Vérifier si l'utilisateur est connecté
                if (isset($_SESSION['user_id'])) {
                    // Si l'utilisateur est connecté, afficher le bouton de déconnexion
                    echo '<li class="nav-item">
                            <form method="post" action="">
                                <button type="submit" name="logout" class="nav-link btn btn-link text-white">Déconnexion</button>
                            </form>
                          </li>';
                } else {
                    // Sinon, afficher le bouton de connexion
                    echo '<li class="nav-item">
                            <a class="nav-link" href="index.php?page=connexion">Connexion</a>
                          </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>


    <?php
    // Traitement de la déconnexion
    if (isset($_POST['logout'])) {
        session_unset(); // Supprimer toutes les variables de session
        session_destroy(); // Détruire la session
        header("Location: index.php?page=connexion"); // Rediriger vers la page d'accueil après la déconnexion
        exit();
    }
    ?>
</body>
</html>


