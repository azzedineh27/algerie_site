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

        /* Section Presse */
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

        /* Vertical Card Style for Articles */
        .article-container {
            padding: 50px;
            display: flex;
            flex-direction: column;
            gap: 50px;
            background-color: #f9f9f9;
        }

        .article-card {
            background-color: #ffffff;
            border: 2px solid #006233;
            border-radius: 15px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
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
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        footer {
            padding: 20px 0;
            background-color: #006233;
            color: white;
            text-align: center;
        }

    </style>
</head>
<body>

    <nav>
        <div class="logo">Consulat d'Algérie</div>
        <div class="nav-links">
            <a href="index.php?controller=pages&action=VISA">Visa</a>
            <a href="index.php?controller=pages&action=CULTURE">Culture de l'Algérie</a>
            <a href="index.php?controller=pages&action=PRESSE">Presse</a>
            <a href="index.php?controller=pages&action=LOTERIE">Loterie</a>
        </div>
        <div class="action-btns">
            <a href="contact.html" class="contact-btn">Contact</a>
            <a href="#" class="contact-btn" title="Espace Membre"><span class="material-symbols-outlined">account_circle</span></a>
        </div>
    </nav>

    <!-- Header Section for the Presse page -->
    <section class="presse-header">
        <h1>Presse Algérienne</h1>
        <p>Découvrez les dernières nouvelles, vidéos et ressources multimédia du Consulat d'Algérie.</p>
    </section>

    <!-- Vertical Section for Articles -->
    <section class="article-container">

        <!-- Example article card with the link you provided -->
        <div class="article-card">
            <img src="visa_photo.webp" alt="Visa Algérien">
            <h2>Visa Algérien : Nouvelles régulations pour les voyageurs</h2>
            <p>Les voyageurs désireux de se rendre en Algérie doivent prendre en compte les nouvelles régulations concernant le visa. Ces changements concernent principalement la durée de validité et les catégories de voyageurs.</p>
            <a href="https://www.destination-algerie.net/actualite/30112-visa-algerien-voyageurs/" target="_blank">Lire l'article complet</a>
        </div>

        <!-- Add other article cards below in the same vertical format -->
        <div class="article-card">
            <img src="https://via.placeholder.com/800x400" alt="Actualité politique">
            <h2>Actualité politique en Algérie</h2>
            <p>Analyse des récents développements dans la politique intérieure de l'Algérie. Cet article se concentre sur les changements au sein du gouvernement et les impacts sur la société algérienne.</p>
            <a href="article1.html">Lire l'article complet</a>
        </div>

        <div class="article-card">
            <img src="https://via.placeholder.com/800x400" alt="Développement économique">
            <h2>Développement économique en Algérie</h2>
            <p>Le secteur économique algérien se transforme avec de nouveaux projets d'investissement. Découvrez les initiatives en cours et les opportunités pour les entreprises locales et internationales.</p>
            <a href="article2.html">Lire l'article complet</a>
        </div>

    </section>

    <footer>
        © 2024 Consulat d'Algérie - Tous droits réservés
    </footer>

</body>
</html>
