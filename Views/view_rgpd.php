<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique de Confidentialité - RGPD</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        /* Navbar */
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

        /* Main Content */
        .container {
            max-width: 800px;
            margin: 100px auto 50px auto; /* Margin top increased to avoid overlap with fixed navbar */
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #006233;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 1.5em;
            margin-top: 20px;
        }
        p, ul {
            margin: 10px 0;
            font-size: 1em;
            color: #555;
        }
        ul {
            padding-left: 20px;
            list-style-type: disc;
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

    <!-- Navbar -->
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
            <a href="index.php?controller=connexion&action=CONNECT" class="contact-btn" title="Espace Membre">
                <span class="material-symbols-outlined">account_circle</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1>Politique de Confidentialité - RGPD</h1>
        <p>Bienvenue sur le site du Consulat d'Algérie. La protection de vos données personnelles est une priorité pour nous. Cette page vous informe sur la manière dont vos données sont collectées, utilisées et protégées conformément au Règlement Général sur la Protection des Données (RGPD).</p>

        <h2>1. Responsable du Traitement des Données</h2>
        <p>Le Consulat d'Algérie est responsable de la collecte et du traitement de vos données personnelles. Si vous avez des questions concernant l'utilisation de vos données, veuillez nous contacter à l'adresse indiquée dans la section "Contact".</p>

        <h2>2. Données Collectées</h2>
        <p>Dans le cadre de nos services, nous pouvons être amenés à collecter les informations suivantes :</p>
        <ul>
            <li>Identifiants personnels : nom, prénom, adresse email, numéro de téléphone.</li>
            <li>Informations de connexion : adresse IP, type de navigateur, date et heure d'accès.</li>
            <li>Informations spécifiques : nationalité, numéro de passeport, date de validité et documents d'identité téléchargés.</li>
        </ul>

        <h2>3. Finalités de la Collecte des Données</h2>
        <p>Les données collectées sont utilisées dans les cas suivants :</p>
        <ul>
            <li>Gestion de votre compte utilisateur et authentification sur notre site.</li>
            <li>Traitement des demandes de visa et gestion des informations associées.</li>
            <li>Amélioration de nos services et de votre expérience utilisateur.</li>
            <li>Respect de nos obligations légales et réglementaires.</li>
        </ul>

        <h2>4. Partage des Données</h2>
        <p>Vos données ne sont pas vendues, échangées ou partagées avec des tiers à des fins commerciales. Cependant, elles peuvent être partagées avec des services ou autorités lorsque cela est nécessaire pour remplir nos obligations légales.</p>

        <h2>5. Conservation des Données</h2>
        <p>Vos données personnelles sont conservées pendant la durée strictement nécessaire aux finalités décrites précédemment, sauf disposition légale contraire imposant une durée de conservation différente.</p>

        <h2>6. Vos Droits</h2>
        <p>Conformément au RGPD, vous disposez des droits suivants :</p>
        <ul>
            <li>Droit d'accès : Vous pouvez demander l'accès aux données personnelles que nous détenons sur vous.</li>
            <li>Droit de rectification : Vous pouvez demander la correction des informations inexactes ou incomplètes.</li>
            <li>Droit à l'effacement : Vous pouvez demander la suppression de vos données personnelles, dans les limites légales.</li>
            <li>Droit à la limitation du traitement : Vous pouvez demander que nous limitions le traitement de vos données.</li>
            <li>Droit d'opposition : Vous pouvez vous opposer au traitement de vos données dans certains cas.</li>
        </ul>
        <p>Pour exercer vos droits, veuillez nous contacter à l'adresse mentionnée dans la section "Contact".</p>

        <h2>7. Sécurité des Données</h2>
        <p>Nous mettons en œuvre des mesures techniques et organisationnelles pour protéger vos données personnelles contre les accès non autorisés, les altérations, les divulgations ou destructions non autorisées.</p>

        <h2>8. Modifications de la Politique de Confidentialité</h2>
        <p>Nous nous réservons le droit de mettre à jour cette politique de confidentialité en fonction des évolutions légales et réglementaires. Les modifications seront publiées sur cette page.</p>

        <h2>Contact</h2>
        <p>Pour toute question ou demande concernant cette politique de confidentialité ou l'exercice de vos droits, veuillez nous contacter par email à : <a href="mailto:contact@consulat-algerie.fr">contact@consulat-algerie.fr</a>.</p>
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
