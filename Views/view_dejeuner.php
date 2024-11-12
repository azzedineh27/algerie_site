<?php
// Inclure le modèle pour interagir avec la base de données
require_once 'Model_algerie.php';

// Initialiser le modèle
$model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'password'); // Remplacez 'password' par le mot de passe réel

// Variables pour les messages
$message = '';
$success = false;

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $prenom = $_POST['prenom'];

    // Vérifier et offrir le déjeuner
    if ($model->offrirDejeuner($email, $prenom)) {
        $message = "Merci ! Venez récupérer votre déjeuner ici : La salle R305 de l'IUT de Villetaneuse.";
        $success = true;
    } else {
        $message = "Les informations saisies ne correspondent à aucun utilisateur ou le déjeuner a déjà été offert.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déjeuner Gratuit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #006233;
        }
        .message {
            font-size: 1.2em;
            margin-top: 20px;
            color: <?= $success ? '#006233' : '#D52B1E' ?>;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #006233;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #D52B1E;
        }
        .home-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #006233;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
        }
        .home-button:hover {
            background-color: #D52B1E;
            box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Déjeuner Gratuit</h1>
        <p>Entrez votre e-mail et prénom pour confirmer votre déjeuner gratuit.</p>
        
        <form method="POST">
            <input type="email" name="email" placeholder="Votre e-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Veuillez entrer une adresse e-mail valide." required>
            <input type="text" name="prenom" placeholder="Votre prénom" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Le prénom ne peut contenir que des lettres, des espaces, des tirets et des apostrophes."required>
            <button type="submit">Confirmer</button>
        </form>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Bouton de redirection vers l'accueil -->
        <a href="index.php" class="home-button">Retour à l'accueil</a>
    </div>
</body>
</html>
