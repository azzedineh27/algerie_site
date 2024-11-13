<?php 
// Démarrer la session si elle n'est pas déjà active
if (session_id() === '') {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?controller=connexion&action=CONNECT");
    exit;
}

// Si l'utilisateur est connecté, récupérer ses informations
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$user_id = $_SESSION['user_id'];

require_once 'C:\wamp64\www\algerie_site\Models\Model_algerie.php';
$model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'Ultime10');

$erreur = '';
$succes = '';

// Traitement du formulaire de changement de mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changer_mdp'])) {
    $nomSaisi = $_POST['nom'];
    $prenomSaisi = $_POST['prenom'];
    $telSaisi = $_POST['tel'];
    $emailSaisi = $_POST['email'];
    $nouveauMdp = $_POST['nouveau_mdp'];

    // Initialiser un tableau d'erreurs
    $erreurs = [];

    // Vérifier chaque champ séparément en les comparant aux valeurs de la base de données
    $utilisateur = $model->getUtilisateurById($user_id); // Méthode à créer pour obtenir les infos de l'utilisateur actuel
    
    if ($utilisateur['nom'] !== $nomSaisi) {
        $erreurs[] = "Nom incorrect.";
    }
    if ($utilisateur['prenom'] !== $prenomSaisi) {
        $erreurs[] = "Prénom incorrect.";
    }
    if ($utilisateur['tel'] !== $telSaisi) {
        $erreurs[] = "Numéro de téléphone incorrect.";
    }
    if ($utilisateur['email'] !== $emailSaisi) {
        $erreurs[] = "Adresse e-mail incorrecte.";
    }

    // Si toutes les informations sont correctes
    if (empty($erreurs)) {
        // Changer le mot de passe
        $model->changerMotDePasse($user_id, $nouveauMdp);
        $succes = "Votre mot de passe a été changé avec succès.";
    } else {
        // Si des erreurs sont présentes, concaténer les messages d'erreur
        $erreur = implode("<br>", $erreurs);
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Membre - Consulat d'Algérie</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
        /* Global styles */
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
            display: flex;
            flex-direction: column;
            margin: 0;
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

        /* Espace Membre */
        .espace-section {
            padding: 120px 20px;
            background-color: #f9f9f9;
            text-align: center;
            margin-top: 100px;
            max-width: 500px;
            width: 100%;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .espace-section h2 {
            font-size: 2em;
            color: #006233;
            margin-bottom: 15px;
        }

        .success-message, .error-message {
            margin-bottom: 10px; /* Réduit l'espace sous les messages */
            padding: 10px; /* Réduit le padding pour des messages plus compacts */
            border-radius: 5px;
            font-weight: bold;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Formulaire de changement de mot de passe */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px; /* Réduit l'espacement entre les éléments */
        }

        form h3 {
            font-size: 1.4em;
            color: #333;
            margin-bottom: 8px; /* Réduit la marge sous le titre */
        }

        label {
            align-self: flex-start;
            margin-left: 10px; /* Diminue l'espacement à gauche */
            font-size: 0.85em;
            color: #555;
            margin-bottom: 3px; /* Réduit l'espace sous les labels */
        }

        input[type="text"], input[type="tel"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px; /* Réduit le padding pour des champs plus compacts */
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="tel"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #006233;
        }

        button[type="submit"] {
            background-color: #006233;
            color: white;
            font-size: 1.1em;
            padding: 8px 18px; /* Diminue le padding pour un bouton plus petit */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s;
        }

        button[type="submit"]:hover {
            background-color: #D52B1E;
        }

        button[type="submit"]:active {
            transform: scale(0.98);
        }

        .logout-btn {
            background-color: #D52B1E;
            color: white;
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #006233;
        }

        footer {
            background-color: #006233;
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: auto;
        }

    </style>
</head>
<body>

    <nav>
        <div class="logo">Consulat d'Algérie</div>
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
            <?php if ($prenom): ?>
                <span class="contact-btn">Bonjour, <?php echo htmlspecialchars($prenom); ?></span>
            <?php endif; ?>
            <a href="index.php?controller=connexion&action=CONNECT" class="contact-btn" title="Déconnexion"><span class="material-symbols-outlined">logout</span></a>
        </div>
    </nav>

    <div class="main-content">
        <section class="espace-section">
            <h2>Bienvenue, <?php echo htmlspecialchars($prenom) . " " . htmlspecialchars($nom); ?></h2>
            <p>Vous pouvez gérer vos informations ici.</p>

            <!-- Messages de succès ou d'erreur -->
            <?php if ($erreur): ?>
                <div class="error-message"><?php echo htmlspecialchars($erreur); ?></div>
            <?php endif; ?>
            <?php if ($succes): ?>
                <div class="success-message"><?php echo htmlspecialchars($succes); ?></div>
            <?php endif; ?>

            <!-- Formulaire de changement de mot de passe -->
            <form method="POST" action="">
                <h3>Changer votre mot de passe</h3>
                <label>Nom :</label>
                <input type="text" name="nom" required>
                
                <label>Prénom :</label>
                <input type="text" name="prenom" required>
                
                <label>Numéro de téléphone :</label>
                <input type="tel" name="tel" required>
                <label>Adresse Email :</label>
                <input type="email" name="email" required>
                
                <label>Nouveau mot de passe :</label>
                <input type="password" name="nouveau_mdp" required>
                
                <button type="submit" name="changer_mdp">Changer le mot de passe</button>
            </form>

            <!-- Bouton spécial pour l'ID 3 -->
            <?php if ($user_id == 3): ?>
                <form action="index.php" method="GET">
                    <input type="hidden" name="controller" value="pages">
                    <input type="hidden" name="action" value="ADMIN">
                    <button type="submit" class="logout-btn" style="margin-top: 10px;">Créer comptes</button>
                </form>
            <?php endif; ?>

            <!-- Bouton de déconnexion -->
            <form action="deconnexion.php" method="POST">
                <button type="submit" class="logout-btn">Se déconnecter</button>
            </form>
        </section>
    </div>

    <footer>
        <div class="footer-content">
            <div>© 2024 Consulat d'Algérie - Tous droits réservés</div>
        </div>
    </footer>

</body>
</html>