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
    <title>Presse - Consulat d'Algérie</title>
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

        .presse-header {
            padding: 100px 50px;
            text-align: center;
            background-color: #006233;
            color: white;
        }

        .presse-header h1 {
            font-family: 'Roboto Slab', serif;
            font-size: 3em;
            margin-bottom: 10px;
        }

        .presse-header p {
            font-size: 1.3em;
            margin: 0;
        }

        .article-container {
            padding: 50px;
            display: flex;
            flex-direction: column;
            gap: 50px;
            background-color: #f9f9f9;
        }

        .article-container .row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 50px;
        }

        .article-card {
            background-color: #ffffff;
            border: 2px solid #006233;
            border-radius: 15px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            min-height: 500px;
            flex: 1;
        }

        .article-card:hover {
            transform: scale(1.05);
        }

        .article-card h2 {
            color: #006233;
            font-size: 1.8em;
            margin-bottom: 15px;
        }

        .article-card p {
            font-size: 1.1em;
            margin-bottom: 15px;
            color: #555;
        }

        .article-card a {
            text-decoration: none;
            font-size: 1.1em;
            color: #D52B1E;
            transition: color 0.3s ease;
        }

        .article-card a:hover {
            color: #006233;
        }

        .article-card img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .article-container .row {
                flex-direction: column;
            }
            .article-card img {
                max-height: 200px;
            }
            .article-card {
                min-height: auto;
            }
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

    <section class="presse-header">
        <h1>Presse Algérienne</h1>
        <p>Découvrez les dernières nouvelles, vidéos et ressources multimédia du Consulat d'Algérie.</p>
    </section>

    <section class="article-container">
        <!-- Row for first two articles -->
        <div class="row">
            <div class="article-card">
                <img src="Images/visa.png" alt="Visa Algérien">
                <h2>Visa Algérien : Nouvelles régulations pour les voyageurs</h2>
                <p>Les voyageurs désireux de se rendre en Algérie doivent prendre en compte les nouvelles régulations concernant le visa. Ces changements concernent principalement la durée de validité et les catégories de voyageurs.</p>
                <a href="https://www.destination-algerie.net/actualite/30112-visa-algerien-voyageurs/" target="_blank">Lire l'article complet</a>
            </div>

            <div class="article-card">
                <img src="Images/im2" alt="Actualité politique">
                <h2>Actualité politique en Algérie</h2>
                <p>Analyse des récents développements dans la politique intérieure de l'Algérie. Cet article se concentre sur les changements au sein du gouvernement et les impacts sur la société algérienne.</p>
                <a href="https://www.algerie360.com/category/algerie/politique/" target="_blank">Lire l'article complet</a>
            </div>
        </div>

        <!-- Row for next two articles -->
        <div class="row">
            <div class="article-card">
                <img src="Images/im4" alt="Développement économique">
                <h2>Développement économique en Algérie</h2>
                <p>Le secteur économique algérien se transforme avec de nouveaux projets d'investissement. Découvrez les initiatives en cours et les opportunités pour les entreprises locales et internationales.</p>
                <a href="https://www.banquemondiale.org/fr/news/feature/2024/07/22/algeria-s-ambitious-path-for-development" target="_blank">Lire l'article complet</a>
            </div>

            <div class="article-card">
                <img src="Images/im5" alt="Tourisme en Algérie">
                <h2>Tourisme en Algérie : Opportunités et défis</h2>
                <p>Le secteur du tourisme en Algérie connaît une évolution, avec des efforts pour attirer plus de visiteurs. Cet article explore les stratégies en place pour développer cette industrie.</p>
                <a href="https://www.algerie-tourisme.com/" target="_blank">Lire l'article complet</a>
            </div>
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
