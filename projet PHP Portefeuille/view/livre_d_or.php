<?php
include './model/bdd.php'; // Inclure ton fichier de connexion

// Connexion à la base de données
$pdo = Bdd::connexion();

// Vérification de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    // Récupérer le montant du formulaire
    $montant = htmlspecialchars($_POST['montant']); // Sécuriser le montant pour éviter les injections XSS
    
    // Récupérer l'ID de l'utilisateur connecté
    $user_id = $_SESSION['user_id'];
    
    // Vérifier si l'utilisateur a déjà un solde dans la table
    $sql = "SELECT * FROM solde WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $solde = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($solde) {
        // Si un solde existe, vérifier s'il est suffisant pour le retrait
        if ($montant < 0 && abs($montant) > $solde['solde']) {
            // Si le retrait est trop important et entraîne un solde négatif, afficher un message d'erreur
            $message = "Vous n'avez pas assez de fonds pour effectuer ce retrait.";
        } else {
            // Calculer le nouveau solde
            $new_solde = $solde['solde'] + $montant;
            $sql = "UPDATE solde SET solde = :new_solde, last_updated = NOW() WHERE user_id = :user_id";
            $action = $montant >= 0 ? 'ajout' : 'retrait'; // Si le montant est positif => 'ajout', sinon => 'retrait'
            
            // Préparer la requête pour mettre à jour le solde
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':new_solde', $new_solde, PDO::PARAM_STR);
            if ($stmt->execute()) {
                // Enregistrer l'historique
                $sql_history = "INSERT INTO solde_history (user_id, montant, action) VALUES (:user_id, :montant, :action)";
                $stmt_history = $pdo->prepare($sql_history);
                $stmt_history->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt_history->bindParam(':montant', $montant, PDO::PARAM_STR);
                $stmt_history->bindParam(':action', $action, PDO::PARAM_STR);
                $stmt_history->execute();
                
                
            } else {
                $message = "Erreur lors de la mise à jour du solde.";
            }
        }
    } else {
        $message = "Erreur : aucun solde trouvé pour cet utilisateur.";
    }
}

// Vérification que l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    // Récupérer le solde de l'utilisateur connecté uniquement
    $user_id = $_SESSION['user_id'];
    $sql_solde = "SELECT solde, last_updated FROM solde WHERE user_id = :user_id";
    $stmt_solde = $pdo->prepare($sql_solde);
    $stmt_solde->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_solde->execute();
    $solde = $stmt_solde->fetch(PDO::FETCH_ASSOC);

    // Récupérer l'historique des mises à jour du solde pour l'utilisateur connecté
    $sql_history = "SELECT sh.montant, sh.action, sh.created_at FROM solde_history sh
                    WHERE sh.user_id = :user_id
                    ORDER BY sh.created_at DESC";
    $stmt_history = $pdo->prepare($sql_history);
    $stmt_history->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_history->execute();
    $history = $stmt_history->fetchAll(PDO::FETCH_ASSOC);
} else {
    $message = "Veuillez vous connecter pour voir votre solde.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solde Utilisateur</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
    }

    h1 {
        text-align: center;
    }

    .container {
        width: 80%;
        margin: 0 auto;
    }

    .solde {
        margin: 20px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .solde p {
        margin: 0;
    }

    .username {
        font-weight: bold;
        color: #333;
    }

    .date {
        font-size: 0.9em;
        color: #777;
    }

    .history {
        margin-top: 30px;
        padding: 10px;
        border: 1px solid #ddd;
        background-color: #f1f1f1;
    }

    .history h3 {
        margin-bottom: 20px;
    }

    .history-item {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .alert {
        color: white;
        background-color: red;
        padding: 10px;
        margin: 10px;
        border-radius: 5px;
        display: none; /* Masquer initialement */
    }
</style>
</head>
<body>
    <h1>Gestion du Solde</h1>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <p>Veuillez vous <a href="index.php?page=connexion">connecter</a> pour consulter et mettre à jour votre solde.</p>
    <?php else: ?>

        <!-- Message d'avertissement (rouge) -->
        <?php if (isset($message)): ?>
            <div class="alert" id="alertMessage"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="container">
        <h2>Solde de votre compte</h2>
        <div class="solde-zone">
            <?php if ($solde): ?>
                <div class="solde">
                    <p>Solde actuel : <?php echo number_format($solde['solde'], 2, ',', ' '); ?> €</p>
                    <p class="date">Dernière mise à jour : <?php echo $solde['last_updated']; ?></p>
                </div>
            <?php else: ?>
                <p>Aucun solde enregistré.</p>
            <?php endif; ?>
        </div>

        <h3>Ajouter ou Modifier votre solde</h3>
        <form method="POST">
        <input type="number" name="montant" placeholder="Montant à ajouter ou retirer" required style="width: 80%; height: 40px;"><br>
            <button type="submit">Mettre à jour le solde</button>
        </form>

        <!-- Affichage de l'historique -->
        <div class="history">
            <h3>Historique des mises à jour de solde</h3>
            <?php if (count($history) > 0): ?>
                <?php foreach ($history as $entry): ?>
                    <div class="history-item">
                        <p><?php echo $entry['action'] == 'ajout' ? 'Ajout' : 'Retrait'; ?> de <?php echo number_format($entry['montant'], 2, ',', ' '); ?> €</p>
                        <p class="date">Date : <?php echo $entry['created_at']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune mise à jour de solde dans l'historique.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Afficher le message d'avertissement et le faire disparaître après 3 secondes
        const alertMessage = document.getElementById('alertMessage');
        if (alertMessage) {
            alertMessage.style.display = 'block'; // Afficher le message
            setTimeout(() => {
                alertMessage.style.display = 'none'; // Cacher le message après 3 secondes
            }, 3000);
        }
    </script>

</body>
</html>
