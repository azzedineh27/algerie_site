<?php
// Inclure le fichier du modèle pour interagir avec la base de données
require_once 'Models/Model_algerie.php';

// Démarrer la session pour vérifier si l'utilisateur est connecté
if (session_id() === '') {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: index.php?controller=connexion&action=CONNECT");
    exit;
}

// Récupérer les informations utilisateur
$user_id = $_SESSION['user_id'];
$prenom = $_SESSION['prenom'];

// Connexion à la base de données
$model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'Ultime10');

// Initialiser un message de succès ou d'erreur
$message = "";

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commentaire']) && isset($_POST['note'])) {
    $commentaire = $_POST['commentaire'];
    $note = (int)$_POST['note'];

    // Vérifier que la note est entre 1 et 10
    if ($note < 1 || $note > 10) {
        $message = "<div class='error-message'>La note doit être comprise entre 1 et 10.</div>";
    } else {
        // Insérer l'avis et la note dans la base de données
        $success = $model->ajouterFeedback($user_id, $commentaire, $note);

        if ($success) {
            $message = "<div class='success-message'>Merci pour votre avis !</div>";
        } else {
            $message = "<div class='error-message'>Erreur lors de l'enregistrement de votre avis.</div>";
        }
    }
}

// Récupérer la liste des avis et calculer la moyenne des notes
$feedbacks = $model->getAllFeedbacks();
$moyenne = $model->calculerMoyenneNotes();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Consulat d'Algérie</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body, html {
            height: 100%;
            font-family: 'Open Sans', sans-serif;
            background-color: #f1f1f1;
            color: #333;
            scroll-behavior: smooth;
        }
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }
        .logo {
            font-family: 'Roboto Slab', serif;
            font-size: 2em;
            color: #006233;
        }
        .container {
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #006233;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-size: 1.1em;
            color: #333;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #006233;
            border-radius: 5px;
            outline: none;
            margin-top: 5px;
        }
        .feedback-submit {
            background-color: #006233;
            color: white;
            padding: 10px 20px;
            font-size: 1.1em;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .feedback-submit:hover {
            background-color: #D52B1E;
        }
        .feedback-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
        }
        .error-message, .success-message {
            padding: 10px;
            color: white;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .error-message {
            background-color: #D52B1E;
        }
        .success-message {
            background-color: #28a745;
        }
        footer {
            padding: 15px 0;
            background-color: #006233;
            color: white;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav>
        <div class="logo">Consulat d'Algérie</div>
    </nav>

    <!-- Feedback Section -->
    <div class="container">
        <h1>Donnez votre avis</h1>
        
        <!-- Message de succès ou d'erreur -->
        <?php echo $message; ?>

        <!-- Formulaire d'avis -->
        <form method="POST">
            <div class="form-group">
                <label for="note">Note (sur 10) :</label>
                <input type="number" id="note" name="note" min="1" max="10" required>
            </div>
            <div class="form-group">
                <label for="commentaire">Commentaire :</label>
                <textarea id="commentaire" name="commentaire" rows="4" required></textarea>
            </div>
            <button type="submit" class="feedback-submit">Soumettre votre avis</button>
        </form>

        <!-- Affichage de la moyenne des notes -->
        <h2>Moyenne des avis : <?php echo round($moyenne, 1); ?> / 10</h2>

        <!-- Liste des avis -->
        <h3>Avis des utilisateurs :</h3>
        <?php foreach ($feedbacks as $feedback): ?>
            <div class="feedback-item">
                <p><strong>Note : <?php echo htmlspecialchars($feedback['note']); ?>/10</strong></p>
                <p><?php echo htmlspecialchars($feedback['commentaire']); ?></p>
                <p><em>Posté le <?php echo htmlspecialchars($feedback['date']); ?></em></p>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        © 2024 Consulat d'Algérie - Tous droits réservés
    </footer>

</body>
</html>
