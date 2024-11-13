<?php
// Démarrer la session si elle n'est pas déjà active
if (session_id() === '') {
    session_start();
}

// Vérifier si l'utilisateur est connecté
$prenom = '';
$lien_account = 'index.php?controller=connexion&action=CONNECT';

if (isset($_SESSION['user_id'])) {
    $prenom = $_SESSION['prenom'];
    $lien_account = 'index.php?controller=connexion&action=ESPACE';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Consulat d'Algérie</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
        /* Styles communs de la page d'accueil */
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
            background: #ffffff; 
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

        /* Section FAQ */
        .faq-container {
            padding: 100px 50px;
            max-width: 1200px;
            margin: 100px auto 0;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .faq-title {
            font-size: 2.5em;
            color: #006233;
            text-align: center;
            margin-bottom: 30px;
        }

        .faq-item {
            margin-bottom: 20px;
            padding: 20px;
            border-bottom: 1px solid #ccc;
        }

        .faq-item h3 {
            font-size: 1.5em;
            color: #006233;
            cursor: pointer;
            margin: 0;
            transition: color 0.3s ease;
        }

        .faq-item h3:hover {
            color: #D52B1E;
        }

        .faq-answer {
            font-size: 1.1em;
            color: #555;
            line-height: 1.6;
            display: none;
            margin-top: 10px;
        }

        /* Footer */
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
    </style>

    <script>
        // Script pour afficher/masquer les réponses des FAQ
        document.addEventListener("DOMContentLoaded", function () {
            const faqItems = document.querySelectorAll(".faq-item h3");
            faqItems.forEach(item => {
                item.addEventListener("click", () => {
                    const answer = item.nextElementSibling;
                    answer.style.display = answer.style.display === "block" ? "none" : "block";
                });
            });
        });
    </script>
</head>
<body>
    <nav>
        <div class="logo">Consulat d'Algérie</div>
        <div class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="index.php?controller=pages&action=VISA">Visa</a>
            <a href="index.php?controller=pages&action=CULTURE">Culture</a>
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

    <section class="faq-container">
        <h2 class="faq-title">Foire Aux Questions (FAQ)</h2>

        <div class="faq-item">
            <h3>Comment puis-je faire une demande de visa pour l'Algérie ?</h3>
            <div class="faq-answer">
                Pour effectuer une demande de visa, rendez-vous sur notre page dédiée « Demande de Visa » et suivez les instructions détaillées.
            </div>
        </div>

        <div class="faq-item">
            <h3>Quels sont les documents requis pour une demande de visa ?</h3>
            <div class="faq-answer">
                Les documents varient en fonction du type de visa, mais incluent généralement le passeport, une photo d'identité, et des justificatifs de voyage. Consultez notre page visa pour plus de détails.
            </div>
        </div>

        <div class="faq-item">
            <h3>Comment contacter le consulat pour obtenir des informations ?</h3>
            <div class="faq-answer">
                Vous pouvez nous contacter via la page « Contact » où sont listés nos numéros de téléphone, adresses e-mail, et horaires d'ouverture.
            </div>
        </div>

        <div class="faq-item">
            <h3>Quelles sont les ressources disponibles pour la communauté algérienne à l'étranger ?</h3>
            <div class="faq-answer">
                Nous proposons divers services consulaires, d'aide et d'information pour la communauté algérienne résidant à l'étranger, y compris des informations sur la nationalité, le passeport, et l'état civil.
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
                    <li><a href="index.php?controller=pages&action=CULTURE" class="footer-link">Culture</a></li>
                    <li><a href="index.php?controller=pages&action=PRESSE" class="footer-link">Presse</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Informations</h4>
                <ul class="footer-links">
                    <li><a href="index.php?controller=footer&action=CONTACT" class="footer-link">Contact</a></li>
                    <li><a href="index.php?controller=footer&action=RGPD" class="footer-link">RGPD</a></li>
                    <li><a href="index.php?controller=footer&action=FAQ" class="footer-link">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Ressources</h4>
                <ul class="footer-links">
                    <li><a href="index.php?controller=pages&action=LOTERIE" class="footer-link">Loterie</a></li>
                    <li><a href="index.php?controller=footer&action=QUIZ" class="footer-link">Quiz</a></li>
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
