<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Wallets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;   
            height: 100vh;     
        }

        header {
            background:rgba(141, 147, 148, 0.58);
            padding: 20px;
            text-align: center;
            color: white;
        }

        header h1 {
            font-size: 2.5rem;
        }

        header p {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        header img {
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 10px;
            margin-top: 20px;
        }

        main {
            padding: 40px 20px;
        }

        section {
            margin-bottom: 40px;
        }

        h2 {
            color: #333;
            font-size: 1.8rem;
        }

        p {
            color: #555;
            font-size: 1rem;
            margin-top: 10px;
        }

        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        footer ul {
            list-style: none;
            padding: 0;
        }

        footer ul li {
            display: inline;
            margin: 0 15px;
        }

        footer ul li a {
            color: #fff;
            text-decoration: none;
        }

        footer ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <?php 
            // Vérifier si l'utilisateur est connecté
            if (isset($_SESSION['user_id'])) {
                // Si l'utilisateur est connecté, afficher le bouton de déconnexion
                echo "<h1>Bonjour " . $_SESSION['username'] . ",</h1>";
                
            } else {
                echo "<h1>Bienvenue sur Wallets</h1>";
                echo '<p><a href="login.php" style="color: white;">Se connecter</a> ou <a href="register.php" style="color: white;">Créer un compte</a></p>';
            }
        ?>
        <p>Gérez vos finances facilement et en toute sécurité !</p>
        <img src="https://miro.medium.com/v2/resize:fit:1050/1*42VRxhX4ANc0YQt8fiokvA.png" alt="Wallets" style="width: 100%; max-width: 600px; height: auto; border-radius: 10px;">
    </header>

    <main>
        <section id="about">
            <h2>À propos de Wallets</h2>
            <p>Wallets est une plateforme sécurisée pour gérer votre solde, effectuer des retraits et des ajouts d'argent, et garder une trace de votre historique de transactions. Grâce à une interface simple et moderne, vous pouvez rapidement consulter votre solde et effectuer des opérations à tout moment.</p>
        </section>

        <section id="features">
            <h2>Nos fonctionnalités</h2>
            <p>Voici quelques-unes des fonctionnalités de Wallets :</p>
            <ul>
                <li><strong>Gestion de solde :</strong> Ajoutez, retirez et suivez vos fonds facilement.</li>
                <li><strong>Historique des transactions :</strong> Accédez à un historique détaillé de toutes vos transactions passées.</li>
                <li><strong>Sécurité :</strong> Profitez d'une protection renforcée pour vos informations financières.</li>
            </ul>
        </section>

        <section id="faq">
            <h2>Foire aux questions</h2>
            <p>Voici quelques réponses aux questions fréquemment posées :</p>
            <ul>
                <li><strong>Comment ajouter de l'argent à mon portefeuille ?</strong> Connectez-vous à votre compte et cliquez sur "Ajouter des fonds" dans votre tableau de bord.</li>
                <li><strong>Puis-je retirer des fonds à tout moment ?</strong> Oui, vous pouvez retirer des fonds quand vous le souhaitez, à condition d'avoir un solde suffisant.</li>
                <li><strong>Mon solde peut-il devenir négatif ?</strong> Non, des alertes seront affichées si votre solde est insuffisant pour effectuer une action.</li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Wallets - Tous droits réservés.</p>
        <nav>
            <ul>
                <li><a href="#about">À propos</a></li>
                <li><a href="#features">Fonctionnalités</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </footer>
</body>
</html>
