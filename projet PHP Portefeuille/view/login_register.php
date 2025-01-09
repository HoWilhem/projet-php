<?php
// Inclure la classe Bdd
require_once './model/bdd.php';

// Connexion à la base de données via la classe Bdd
$pdo = Bdd::connexion();

$message = '';

// Déterminer l'action actuelle (signup ou login)
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'signup') {
        // Inscription
        $user = $_POST['username'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$user, $email, $pass]);
            $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
        // Connexion
        $email = $_POST['email'];
        $pass = $_POST['password'];
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id']; // Enregistrer l'id utilisateur dans la session
            $_SESSION['username'] = $user['username']; 
            header("Location: index.php?page=accueil");
            $message = "Connexion réussie ! Bienvenue, " . htmlspecialchars($user['username']) . ".";
        } else {
            $message = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription / Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0px;
            background-color: #f0f0f0;}

        .container {
            width: 400px;
            background-color: white;
            margin-top: 100px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            color: #333;
            margin-top: 10px;
        }
        .switch {
            text-align: center;
            margin-top: 10px;
        }
        .switch a {
            color: #4CAF50;
            text-decoration: none;
        }
        .switch a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="signupForm" style="display: none;">
            <h2>Inscription</h2>
            <form method="POST">
                <input type="hidden" name="action" value="signup">
                <input type="text" name="username" placeholder="Nom d'utilisateur" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit">S'inscrire</button>
            </form>
            <div class="switch">
                <p>Déjà un compte ? <a href="javascript:void(0);" onclick="switchForm('login')">Se connecter</a></p>
            </div>
        </div>

        <div id="loginForm">
            <h2>Connexion</h2>
            <form method="POST">
                <input type="hidden" name="action" value="login">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
            <div class="switch">
                <p>Pas de compte ? <a href="javascript:void(0);" onclick="switchForm('signup')">Créer un compte</a></p>
            </div>
        </div>

        <div class="message"><?= htmlspecialchars($message) ?></div>
    </div>

    <script>
        function switchForm(form) {
            if (form === 'signup') {
                document.getElementById('loginForm').style.display = 'none';
                document.getElementById('signupForm').style.display = 'block';
            } else {
                document.getElementById('signupForm').style.display = 'none';
                document.getElementById('loginForm').style.display = 'block';
            }
        }

        // Par défaut, afficher le formulaire de connexion
        window.onload = function() {
            switchForm('login');
        }
    </script>
</body>
</html>
