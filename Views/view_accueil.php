<?php
// Démarrer la session si elle est pas deja active
if (session_id() === '') {
    session_start();
  }

// Vérifier si l'utilisateur est connecté
$prenom = '';
$lien_account = 'index.php?controller=connexion&action=CONNECT'; // Par défaut, lien vers la page de connexion

if (isset($_SESSION['user_id'])) {
    // Si l'utilisateur est connecté, rediriger vers la page de l'espace membre
    $prenom = $_SESSION['prenom'];  // Récupérer le prénom de l'utilisateur
    $lien_account = 'index.php?controller=connexion&action=ESPACE';  // Lien vers l'espace membre
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
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
            color: #006233; /* Vert du drapeau */
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
            color: #D52B1E; /* Rouge du drapeau */
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

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            width: 100%;
            padding: 0 20px;
            z-index: 1;
        }


        .consulat-title {
            font-family: 'Roboto Slab', serif;
            font-size: 6em;
            color: white;
            text-align: center;
            margin-bottom: 10px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            transform-style: preserve-3d;
            perspective: 1000px;
            transition: transform 0.5s ease;
        }

        .consulat-title:hover {
            transform: rotateY(15deg) rotateX(5deg);
        }
        

        /* Section Présentation */
        .presentation {
            padding: 100px 50px;
            background-color: #fff;
            text-align: center;
        }

        .presentation h2 {
            font-size: 2.5em;
            color: #006233;
            margin-bottom: 20px;
        }

        .presentation p {
            font-size: 1.2em;
            color: #555;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Section Redirection */
        .section {
            padding: 100px 50px;
            display: flex;
            justify-content: space-around;
            background-color: #f9f9f9;
            text-align: center;
        }

        .section div {
            flex: 1;
            margin: 20px;
            padding: 40px;
            border-radius: 15px;
            background-color: #006233;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .section div:hover {
            transform: scale(1.05);
            background-color: #D52B1E;
        }

        .section h3 {
            font-size: 1.8em;
            margin-bottom: 15px;
        }

        .section a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 25px;
            color: white;
            text-decoration: none;
            font-size: 1.1em;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .section a:hover {
            background-color: white;
            color: #006233;
        }

        footer {
            padding: 40px 0;
            background-color: #006233;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: 'Open Sans', sans-serif;
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
            <a href="<?php echo $lien_account; ?>" class="contact-btn" title="Espace Membre">
                <span class="material-symbols-outlined">account_circle</span>
            </a>
        </div>
    </nav>

    <!-- Background Video Section -->
    <div class="background-video">
        <video autoplay muted loop id="bg-video">
            <source src="Video/algerie_video.mp4" type="video/mp4">
            Votre navigateur ne supporte pas la vidéo.
        </video>
        <div class="content fade-in">
            <h1 class="consulat-title animate-title">Consulat d'Algérie</h1>
        </div>
    </div>

    <!-- Présentation Section -->
    <section class="presentation">
        <h2>Bienvenue au Consulat d'Algérie</h2>
        <p>
            Le Consulat d'Algérie est à votre service pour faciliter vos démarches administratives. Nous nous engageons à promouvoir les relations bilatérales et à accompagner la diaspora algérienne à l'étranger. Découvrez toutes les ressources disponibles et les services offerts pour vous aider dans vos besoins.
        </p>
    </section>

    <!-- Redirections Section -->
    <section class="section">
        <div>
            <h3>Contactez-nous</h3>
            <p>Pour toute demande ou information, n'hésitez pas à nous contacter. Nous sommes à votre disposition.</p>
            <a href="contact.html">Page de Contact</a>
        </div>

        <div>
            <h3>Demande de Visa</h3>
            <p>Commencez votre demande de visa pour visiter l'Algérie. Cliquez ici pour en savoir plus.</p>
            <a href="visa.html">Demande de Visa</a>
        </div>

        <div>
            <h3>Découvrez la Culture Algérienne</h3>
            <p>Explorez la richesse culturelle de l'Algérie à travers notre page dédiée.</p>
            <a href="culture.html">Culture Algérienne</a>
        </div>
    </section>

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
                    <li><a href="about.html" class="footer-link">À propos de nous</a></li>
                    <li><a href="contact.html" class="footer-link">Contact</a></li>
                    <li><a href="terms.html" class="footer-link">Conditions d'utilisation</a></li>
                    <li><a href="privacy.html" class="footer-link">Politique de confidentialité</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Ressources</h4>
                <ul class="footer-links">
                    <li><a href="services.html" class="footer-link">Services Consulaires</a></li>
                    <li><a href="news.html" class="footer-link">Actualités</a></li>
                    <li><a href="guides.html" class="footer-link">Guides et conseils</a></li>
                    <li><a href="faq.html" class="footer-link">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Suivez-nous</h4>
                <ul class="footer-links">
                    <li><a href="#" class="footer-link">Facebook</a></li>
                    <li><a href="#" class="footer-link">Twitter</a></li>
                    <li><a href="#" class="footer-link">Instagram</a></li>
                    <li><a href="#" class="footer-link">LinkedIn</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            © 2024 Consulat d'Algérie - Tous droits réservés
        </div>
    </footer>

</body>
</html>
