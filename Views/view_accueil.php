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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body, html {
    margin: 0;
    padding: 0;
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
    color: #D52B1E;
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

/* Styles pour les écrans larges */
.nav-links, .action-btns {
    display: flex;
}

/* Styles pour les écrans petits */
@media (max-width: 768px) {
    .nav-links, .action-btns {
        display: none; /* Masque les liens par défaut */
        flex-direction: column;
        background-color: rgba(255, 255, 255, 0.9);
        position: fixed;
        top: 60px;
        right: 0;
        width: 70%;
        height: 100vh;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        padding-top: 20px;
        gap: 20px;
        z-index: 100; /* Ajoute un niveau de z-index pour être au-dessus du contenu */
    }

    .nav-links.active, .action-btns.active {
        display: flex; /* Affiche les éléments lorsque la classe active est ajoutée */
    }

    .nav-links a, .action-btns a, .action-btns span {
        margin: 10px 20px;
        font-size: 1.2em;
        text-align: center;
    }

    .menu-toggle {
        display: block;
        font-size: 1.5em;
        cursor: pointer;
        color: #006233;
    }
}

/* Sections pour écrans petits */
@media (max-width: 768px) {
    .presentation, .section {
        padding: 50px 20px;
        text-align: center;
    }

    .section {
        flex-direction: column;
    }

    .footer-content {
        flex-direction: column;
        gap: 20px;
        padding: 20px;
    }

    .footer-section h4, .footer-links li {
        font-size: 1em;
    }
}
  
    </style>
</head>
<body>
    <nav>
        <div class="logo">Consulat d'Algérie</div>
        <div class="menu-toggle"><i class="fa-solid fa-bars"></i></div>
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
            <a href="index.php?controller=footer&action=CONTACT">Page de Contact</a>
        </div>

        <div>
            <h3>Demande de Visa</h3>
            <p>Commencez votre demande de visa pour visiter l'Algérie. Cliquez ici pour en savoir plus.</p>
            <a href="index.php?controller=pages&action=VISA">Demande de Visa</a>
        </div>

        <div>
            <h3>Découvrez la Culture Algérienne</h3>
            <p>Explorez la richesse culturelle de l'Algérie à travers notre page dédiée.</p>
            <a href="index.php?controller=pages&action=CULTURE">Culture Algérienne</a>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const menuToggle = document.querySelector(".menu-toggle");
        const navLinks = document.querySelector(".nav-links");
        const actionBtns = document.querySelector(".action-btns");

            menuToggle.addEventListener("click", () => {
                navLinks.classList.toggle("active");
                actionBtns.classList.toggle("active");
            });
        });
    </script>
</body>
</html>
