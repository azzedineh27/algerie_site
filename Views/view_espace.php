<?php 
// Démarrer la session si elle n'est pas déjà active
if (session_id() === '') {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
    header("Location: index.php?controller=connexion&action=CONNECT");
    exit;
}

// Si l'utilisateur est connecté, récupérer ses informations
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$user_id = $_SESSION['user_id']; // Récupérer l'ID de l'utilisateur
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
            /* Garde la barre de navigation fixe en haut */
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
            padding: 100px 50px;
            background-color: #f9f9f9;
            text-align: center;
            margin-top: 100px;
        }

        .espace-section h2 {
            font-size: 2.5em;
            color: #006233;
            margin-bottom: 30px;
        }

        .espace-section p {
            font-size: 1.5em;
            color: #333;
        }

        .espace-section .logout-btn {
            margin-top: 30px;
            background-color: #D52B1E;
            color: white;
            padding: 15px 30px;
            font-size: 1.2em;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .espace-section .logout-btn:hover {
            background-color: #006233;
        }

        /* Bouton Admin */
        .admin-btn {
            position : absolute; 
            margin-top: 20px;
            background-color: #006233;
            color: white;
            padding: 15px 30px;
            font-size: 1.2em;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            top : 52%;
            left: 42%;
            text-decoration: none;
        }

        .admin-btn:hover {
            background-color: #D52B1E;
        }

        .main-content {
            /* Espace sous la barre de navigation pour le contenu principal */
            flex: 1;
            margin-top: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        footer {
            /* Footer en bas de page */
            background-color: #006233;
            color: white;
            padding: 40px 0;
            text-align: center;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            max-width: 1200px;
            width: 100%;
        }

        .footer-link {
            color: white;
            text-decoration: none;
            font-size: 1.1em;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: #D52B1E; /* Rouge du drapeau */
        }

        .footer-section {
            text-align: center;
        }

        .footer-section h4 {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #D0D0D0;
            font-family: 'Roboto Slab', serif;
        }

        .footer-links {
            list-style-type: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-bottom {
            margin-top: 30px;
            font-size: 0.9em;
            color: #D0D0D0;
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
            <!-- Espace Membre -->
        <section class="espace-section">
            <h2>Bienvenue dans votre Espace Membre, <?php echo $prenom . " " . $nom; ?></h2>
            <p>Cet espace est réservé aux utilisateurs connectés. Vous pouvez gérer vos informations ici.</p>

            <!-- Afficher un bouton supplémentaire pour l'admin si l'utilisateur a l'ID 3 -->
            <?php if ($user_id == 3): ?>
                <a href="index.php?controller=pages&action=ADMIN" class="admin-btn">Créer des comptes utilisateur</a>
            <?php endif; ?>

            <form action="deconnexion.php" method="POST">
                <button type="submit" class="logout-btn">Se déconnecter</button>
            </form>
        </section>
    </div>

    

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>Navigation</h4>
                <ul class="footer-links">
                    <li><a href="index.php" class="footer-link">Accueil</a></li>
                    <li><a href="index.php?controller=pages&action=VISA" class="footer-link">Visa</a></li>
                    <li><a href="index.php?controller=pages&action=CULTURE" class="footer-link">Culture de l'Algérie</a></li>
                    <li><a href="index.php?controller=pages&action=PRESSE" class="footer-link">Presse</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Informations</h4>
                <ul class="footer-links">
                    <li><a href="index.php?controller=footer&action=CONTACT" class="footer-link">Contact</a></li>
                    <li><a href="index.php?controller=footer&action=RGPD" class="footer-link">Conditions d'utilisation des données</a></li>
                    <li><a href="index.php?controller=footer&action=FAQ" class="footer-link">FAQ</a></li>
                    <li><a href="index.php?controller=footer&action=AVIS" class="footer-link">Avis</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Ressources</h4>
                <ul class="footer-links">
                    <li><a href="index.php?controller=pages&action=LOTERIE" class="footer-link">Loterie</a></li>
                    <li><a href="index.php?controller=footer&action=QUIZ " class="footer-link">Quiz</a></li>
                    
                </ul>
            </div>
            <div class="footer-section">
                <h4>Suivez-nous</h4>
                <ul class="footer-links">
                    <li><a href="https://www.facebook.com/people/Consulat-G%C3%A9n%C3%A9ral-dAlg%C3%A9rie-%C3%A0-Paris/100090892071356/" class="footer-link">Facebook</a></li>
                    <li><a href="https://x.com/cgalgerieparis" class="footer-link">Twitter</a></li>
                    <li><a href="https://www.instagram.com/explore/locations/244265384/consulat-algerie-paris/" class="footer-link">Instagram</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            © 2024 Consulat d'Algérie - Tous droits réservés
        </div>
    </footer>

</body>
</html>