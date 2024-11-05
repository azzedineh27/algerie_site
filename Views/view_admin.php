<?php
// Démarrer la session si elle n'est pas déjà active
if (session_id() === '') {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: index.php?controller=connexion&action=CONNECT");
    exit;
}

// Vérifier si l'utilisateur a l'ID 3 (Admin)
if ($_SESSION['user_id'] != 3) {
    // Rediriger vers une page d'erreur ou la page d'accueil si ce n'est pas l'utilisateur avec l'ID 3
    header("Location: index.php?controller=connexion&action=CONNECT");
    exit;
}

// Inclure le fichier de modèle pour interagir avec la base de données
require_once 'Models/Model_algerie.php';

// Instancier le modèle pour interagir avec la base de données
$model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'Ultime10');

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email_base = $_POST['email']; // Base de l'email
    $tel = $_POST['tel'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $nombre_comptes = (int)$_POST['nombre_comptes']; // Nombre de comptes à créer

    // Initialiser le compteur de succès
    $comptes_crees = 0;

    // Créer plusieurs comptes selon le nombre spécifié
    for ($i = 1; $i <= $nombre_comptes; $i++) {
        // Générer un email unique pour chaque compte
        $email = $email_base . $i; // Modifier l'email pour éviter les doublons
        
        // Vérifier si l'email existe déjà
        if (!$model->emailExiste($email)) {
            // Ajouter l'utilisateur dans la base de données
            $user_id = $model->ajouterUtilisateur($nom, $prenom, $email, $tel, $mot_de_passe);

            if ($user_id) {
                $comptes_crees++;
            }
        }
    }

    // Stocker un message unique dans la session avec le nombre de comptes créés
    if ($comptes_crees > 0) {
        $_SESSION['message'] = "$comptes_crees comptes ont été créés avec succès !";
    } else {
        $_SESSION['message'] = "Aucun compte n'a été créé. Les adresses e-mail existent déjà.";
    }

    // Rediriger après l'opération pour afficher le message de confirmation
    header("Location: index.php?controller=pages&action=ADMIN");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer des comptes - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
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

        .nav-links {
            display: flex;
            gap: 30px;
            margin-right: auto;
            padding-left: 50px;
        }

        .nav-links a {
            font-size: 1.1em;
            color: #006233;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #D52B1E;
        }

        .action-btns {
            display: flex;
            gap: 20px;
        }

        .contact-btn {
            border: 2px solid #006233;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            color: #006233;
            font-size: 1.1em;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .contact-btn:hover {
            background-color: #D52B1E;
            color: white;
        }

        /* Formulaire Admin */
        .admin-form-section {
            padding: 50px 50px;
            background-color: #f9f9f9;
            text-align: center;
            margin-top: 100px;
        }

        .admin-form-section h2 {
            font-size: 2.5em;
            color: #006233;
            margin-bottom: 30px;
        }

        form {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form div {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 2px solid #006233;
            border-radius: 5px;
            outline: none;
        }

        .admin-form-submit {
            margin-top: 30px;
            background-color: #006233;
            color: white;
            padding: 15px 30px;
            font-size: 1.2em;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .admin-form-submit:hover {
            background-color: #D52B1E;
        }

        footer {
            padding: 20px 0;
            background-color: #006233;
            color: white;
            text-align: center;
            margin-top: 50px;
        }

        .notification {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            opacity: 1;
            transition: opacity 0.5s ease;
            z-index: 1000; /* Pour s'assurer que la notification est au-dessus des autres éléments */
        }


    </style>
</head>
<body>

      <!-- Navbar -->
      <nav>
        <div class="logo">Admin - Consulat d'Algérie</div>
        <div class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="index.php?controller=pages&action=VISA">Visa</a>
            <a href="index.php?controller=pages&action=CULTURE">Culture de l'Algérie</a>
            <a href="index.php?controller=pages&action=PRESSE">Presse</a>
            <a href="index.php?controller=pages&action=LOTERIE">Loterie</a>
            <a href="index.php?controller=pages&action=TIRAGE">Tirage</a>
        </div>
        <div class="action-btns">
            <a href="index.php?controller=footer&action=CONTACT" class="contact-btn">Contact</a>
            <a href="index.php?controller=connexion&action=ESPACE" class="contact-btn">Espace Membre</a>
        </div>
    </nav>

    <!-- Formulaire Admin -->
    <section class="admin-form-section">
        <h2>Créer plusieurs comptes utilisateur</h2>

        <form method="POST">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div>
                <label for="email">Adresse email de base :</label>
                <input type="email" id="email" name="email" placeholder="ex: base_email@example.com" required>
            </div>

            <div>
                <label for="tel">Téléphone :</label>
                <input type="tel" id="tel" name="tel" required>
            </div>

            <div>
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div>
                <label for="nombre_comptes">Nombre de comptes à créer :</label>
                <input type="number" id="nombre_comptes" name="nombre_comptes" min="1" max="100" required>
            </div>

            <button type="submit" class="admin-form-submit">Créer les utilisateurs</button>
        </form>
    </section>

    <footer>
        © 2024 Consulat d'Algérie - Tous droits réservés
    </footer>

<!-- Notification -->
<div id="message-container" class="notification">
    <?php 
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']); // Supprimer le message après l'affichage
    }
    ?>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var notification = document.getElementById('message-container');
    
    if (notification.innerHTML.trim() !== "") {
        notification.style.display = 'block';
        setTimeout(function() {
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 1000); // Délai pour la transition de disparition
        }, 3000); // Durée d'affichage de la notification (3 secondes)
    }
});

</script>

</body>
</html>
