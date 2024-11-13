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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <title>Traditions culinaires - Algérie</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/ica-rubrik-black');
        @import url('https://fonts.cdnfonts.com/css/poppins');

/* Styles de base */
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
    justify-content: space-between;
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

/* Section contenant Gastronomie et Palmarès */
.content-sections {
    display: flex;
    flex-direction: column;
    width: 100%;
    background-color: #F5F5F5;
}

/* Section Gastronomie */
.gastronomie {
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
    height: 200px;
    object-fit: cover;
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

/* Section Palmarès */
.section_trophies {
    padding: 50px;
    text-align: center;
    overflow: visible;
    background: #F5F5F5;
}

.section_trophies h2 {
    font-size: 2.5em;
    color: #25283B;
    margin-bottom: 20px;
}

.trophies {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.trophy-item {
    width: 200px;
    background-color: #006233;
    color: white;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.trophy-item:hover {
    transform: scale(1.05);
}

.trophy-item h3 {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.trophy-item p {
    font-size: 1.1em;
}

footer {
    width: 100%;
    padding: 40px 0;
    background-color: #006233;
    color: white;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: auto;
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

/* Styles pour le menu hamburger sur petits écrans */
@media (max-width: 768px) {
    .nav-links, .action-btns {
        display: none;
        flex-direction: column;
        background-color: rgba(0, 98, 51, 0.9);
        position: fixed;
        top: 60px;
        right: 0;
        width: 70%;
        height: 100vh;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        padding-top: 20px;
        gap: 20px;
        z-index: 100;
    }

    .nav-links.active, .action-btns.active {
        display: flex; /* Affiche les éléments lorsque la classe active est ajoutée */
    }

    .nav-links a, .action-btns a, .action-btns span {
        color: white;
        font-size: 1.2em;
        margin: 10px;
        text-align: center;
    }

    .menu-toggle {
        display: block;
        font-size: 1.5em;
        cursor: pointer;
        color: white;
    }

    .content-sections, .presentation {
        padding: 20px;
        text-align: center;
    }

    .footer-content {
        flex-direction: column;
        gap: 20px;
        padding: 20px;
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

    <!-- Section Présentation de l'Algérie -->
    <section class="presentation">
        <h2>Présentation de l'Algérie</h2>
        <p><strong>Population :</strong> 44 millions d'habitants</p>
        <p><strong>Langue officielle :</strong> Arabe, Amazigh</p>
        <p><strong>Capitale :</strong> Alger</p>
        <p><strong>Superficie :</strong> 2 381 741 km²</p>
        <p><strong>Monnaie :</strong> Dinar algérien (DZD)</p>
        <p><strong>Président :</strong> Abdelmajid Tebboune</p>
        <p>L'Algérie, un carrefour de cultures, est célèbre pour ses traditions et sa cuisine diversifiée, fusionnant des influences méditerranéennes, berbères, arabes et françaises.</p>
    </section>

    <!-- Conteneur pour Gastronomie et Palmarès -->
    <div class="content-sections">
        <!-- Section Gastronomie Algérienne -->
        <section class="gastronomie">
            <h2>Gastronomie Algérienne : Un Voyage de Saveurs</h2>
            <div class="gastronomie-details">
                <div class="gastronomie-item">
                    <img src="Images/couscous.jpeg" alt="Couscous">
                    <p><strong>Couscous :</strong> Le plat emblématique de l'Algérie, composé de semoule de blé dur, accompagné de légumes et de viande.</p>
                </div>
                <div class="gastronomie-item">
                    <img src="Images/chorba.jpg" alt="Chorba">
                    <p><strong>Chorba :</strong> Soupe épicée, souvent consommée pendant le Ramadan.</p>
                </div>
                <div class="gastronomie-item">
                    <img src="Images/tajine.jpg" alt="Tajine">
                    <p><strong>Tajine :</strong> Plat mijoté à base de légumes et épices.</p>
                </div>
                <div class="gastronomie-item">
                    <img src="Images/gateaux.jpg" alt="Pâtisseries Orientales">
                    <p><strong>Pâtisseries Orientales :</strong> Délices sucrés comme les baklavas, makrouds et griwech.</p>
                </div>
            </div>
        </section>

        <!-- Section Palmarès -->
        <section class="section_trophies">
            <h2>Palmarès de la Sélection Nationale d'Algérie</h2>
            <div class="trophies">
                <div class="trophy-item">
                    <h3>JO 2024</h3>
                    <p><strong>Médailles d'Or :</strong> 3</p>
                    <p><strong>Médailles d'Argent :</strong> 2</p>
                    <p><strong>Médailles de Bronze :</strong> 1</p>
                </div>
                <div class="trophy-item">
                    <h3>Coupe d'Afrique des Nations</h3>
                    <p><strong>Victoires :</strong> 2 (1990, 2019)</p>
                    <p><strong>Finaliste :</strong> 1</p>
                </div>
                <div class="trophy-item">
                    <h3>Coupe du Monde</h3>
                    <p><strong>Meilleur Résultat :</strong> Huitièmes de finale (1982, 2014)</p>
                    <p><strong>Participations :</strong> 4 (1982, 1986, 2010, 2014)</p>
                </div>
            </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.menu-toggle');
            const navLinks = document.querySelector('.nav-links');
            const actionBtns = document.querySelector('.action-btns');

            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                actionBtns.classList.toggle('active');
            });
        });
</script>

</body>
</html>
