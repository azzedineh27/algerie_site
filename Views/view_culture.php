<?php
// Démarrer la session si elle est pas déjà active
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <title>Traditions culinaires - Algérie</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/ica-rubrik-black');
        @import url('https://fonts.cdnfonts.com/css/poppins');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 80px;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: #006233;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .logo {
            font-family: 'Roboto Slab', serif;
            font-size: 2em;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            margin-right: auto;
            padding-left: 50px;
        }

        .nav-links a {
            font-size: 1.1em;
            color: white;
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
            border: 2px solid white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            color: white;
            font-size: 1.1em;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .contact-btn:hover {
            background-color: white;
            color: #D52B1E;
        }

        /* Section Présentation */
        .presentation {
            background-color: #006233;
            color: white;
            padding: 50px;
            text-align: center;
        }

        .presentation h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .presentation p {
            font-size: 1.2em;
            line-height: 1.8em;
            margin-bottom: 10px;
        }

        /* Section Gastronomie */
        .gastronomie {
            background-color: #F5F5F5;
            padding: 50px;
            text-align: center;
        }

        .gastronomie h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #25283B;
        }

        .gastronomie .gastronomie-details {
            display: flex;
            justify-content: space-around;
            gap: 50px;
            flex-wrap: wrap;
        }

        .gastronomie .gastronomie-item {
            max-width: 300px;
            text-align: center;
        }

        .gastronomie .gastronomie-item img {
            width: 100%;
            height: 200px; /* Hauteur fixe pour uniformiser les images */
            object-fit: cover; /* Assure que l'image reste bien cadrée */
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .gastronomie .gastronomie-item img:hover {
            transform: scale(1.05);
        }

        .gastronomie .gastronomie-item p {
            font-size: 1.2em;
            margin-top: 10px;
            color: #25283B;
        }

        
        .banner {
            width: 100%;
            min-height: 100vh;
            text-align: center;
            overflow: visible;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 10;
        }

        .banner .message {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 40px;
            color: #25283B;
            z-index: 2;
            text-align: center;
            font-family: 'ICA Rubrik', sans-serif;
        }

        @media (max-width: 768px) {
            .banner .message {
                top: 15%;
                font-size: 40px;
            }
        }

        .banner .slider {
            position: relative;
            width: 120px;
            height: 300px;
            transform-style: preserve-3d;
            animation: autoRun 20s linear infinite;
            z-index: 10;
        }

        @keyframes autoRun {
            from {
                transform: perspective(1000px) rotateX(-16deg) rotateY(0deg);
            }
            to {
                transform: perspective(1000px) rotateX(-16deg) rotateY(360deg);
            }
        }

        .banner .slider .item {
            position: absolute;
            inset: 0 0 0 0;
            transform: rotateY(calc((var(--position) - 1) * (360 / var(--quantity)) * 1deg)) translateZ(300px);
        }

        .banner .slider .item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

    <!-- Section Présentation de l'Algérie -->
    <section class="presentation">
        <h2>Présentation de l'Algérie</h2>
        <p><strong>Population :</strong> 44 millions d'habitants</p>
        <p><strong>Langue officielle :</strong> Arabe, Amazigh</p>
        <p><strong>Capitale :</strong> Alger</p>
        <p><strong>Superficie :</strong> 2 381 741 km²</p>
        <p><strong>Monnaie :</strong> Dinar algérien (DZD)</p>
        <p>L'Algérie, un carrefour de cultures, est célèbre pour ses traditions et sa cuisine diversifiée, fusionnant des influences méditerranéennes, berbères, arabes et françaises.</p>
    </section>

    <!-- Section Gastronomie Algérienne -->
    <section class="gastronomie">
        <h2>Gastronomie Algérienne : Un Voyage de Saveurs</h2>
        <div class="gastronomie-details">
            <div class="gastronomie-item">
                <img src="Images/couscous.jpeg" alt="Couscous">
                <p><strong>Couscous :</strong> Le plat emblématique de l'Algérie, composé de semoule de blé dur, accompagné de légumes, de viande ou de poisson. Symbole de convivialité et de partage.</p>
            </div>
            <div class="gastronomie-item">
                <img src="Images/chorba.jpg" alt="Chorba">
                <p><strong>Chorba :</strong> Soupe épicée au mouton, poulet ou légumes, souvent consommée pendant le Ramadan pour ses saveurs réconfortantes et nourrissantes.</p>
            </div>
            <div class="gastronomie-item">
                <img src="Images/tajine.jpg" alt="Tajine">
                <p><strong>Tajine :</strong> Plat mijoté à base de légumes, épices et fruits secs, cuit lentement dans un récipient en terre cuite pour des saveurs intenses.</p>
            </div>
            <div class="gastronomie-item">
                <img src="Images/gateaux.jpg" alt="Pâtisseries Orientales">
                <p><strong>Pâtisseries Orientales :</strong> Délices sucrés comme les baklavas, makrouds et griwech, confectionnés à base de miel, d'amandes et de dattes, parfaits pour accompagner le thé à la menthe.</p>
            </div>
        </div>
    </section>

     
    <div class="banner">
        <div class="message">
            Découvrez les stars de l'équipe de foot d'Algérie !
        </div>
        <div class="slider" style="--quantity: 10">
            <div class="item" style="--position: 1"><img src="Images/azz.jpg" alt=""></div>
            <div class="item" style="--position: 2"><img src="Images/belmadi.jpg" alt=""></div>
            <div class="item" style="--position: 3"><img src="Images/bentaleb.webp" alt=""></div>
            <div class="item" style="--position: 4"><img src="Images/bougherra.jpg" alt=""></div>
            <div class="item" style="--position: 5"><img src="Images/brahimi.jpg" alt=""></div>
            <div class="item" style="--position: 6"><img src="Images/haliche.jpeg" alt=""></div>
            <div class="item" style="--position: 7"><img src="Images/madjer.jpeg" alt=""></div>
            <div class="item" style="--position: 8"><img src="Images/mahrez.jpg" alt=""></div>
            <div class="item" style="--position: 9"><img src="Images/slimani.jpg" alt=""></div>
            <div class="item" style="--position: 10"><img src="Images/ziani.jpeg" alt=""></div>
        </div>
    </div>


</body>

</html>
