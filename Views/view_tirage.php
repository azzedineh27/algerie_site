<?php
// Démarrer la session si elle n'est pas déjà active
if (session_id() === '') {
    session_start();
}

// Vérifier si l'utilisateur est connecté et si son ID est égal à 3
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 3) {
    // Rediriger vers une page d'erreur si l'utilisateur n'est pas l'admin (ID 3)
    header('Location: index.php?controller=pages&action=ERREUR_TIRAGE');
    exit;
}

// Récupérer les informations de l'utilisateur connecté
$prenom = '';
$lien_account = 'index.php?controller=connexion&action=CONNECT';

if (isset($_SESSION['user_id'])) {
    $prenom = $_SESSION['prenom'];
    $lien_account = 'index.php?controller=connexion&action=ESPACE';
}

// Inclure le modèle pour interagir avec la base de données
require_once 'C:\wamp64\www\algerie_site\Models\Model_algerie.php';

// Initialiser l'objet du modèle avec les informations de connexion
$model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'Ultime10');

// Récupérer tous les utilisateurs
$utilisateurs = $model->getAllUserssansAlgerie();

// Effectuer le tirage au sort si le bouton est cliqué
$gagnant = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tirer_au_sort'])) {
    $gagnant = $model->tirerAuSortGagnant();
    if ($gagnant) {
        $model->marquerCommeGagnant($gagnant['id']);
        $model->validerDemandeVisa($gagnant['id']);
        
        // Mettre à jour la nationalité du gagnant en "Algérienne"
        $model->mettreAJourNationalite($gagnant['id']);

        // Mettre à jour l'affichage du gagnant
        $gagnant['nationalite'] = 'Algérienne';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tirage au sort - Consulat d'Algérie</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        /* Styles de base */
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

/* Navbar */
nav {
    position: fixed;
    top: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 50px;
    background: #ffffff; /* Couleur blanche opaque */
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

/* Table des utilisateurs */
.container {
    padding: 100px 50px;
    text-align: center;
}

.table-container {
    max-width: 800px;
    margin: 0 auto;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 0.9em;
}

th, td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background-color: #006233;
    color: white;
}

.tirage-btn {
    padding: 10px 20px;
    background-color: #006233;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 20px;
}

.tirage-btn:hover {
    background-color: #D52B1E;
}

.gagnant {
    margin-top: 20px;
    font-size: 1.2em;
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

/* Styles pour petits écrans */
@media (max-width: 768px) {
    .nav-links, .action-btns {
        display: none;
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
        z-index: 100;
    }

    .nav-links.active, .action-btns.active {
        display: flex;
    }

    .nav-links a, .action-btns a, .action-btns span {
        color: #006233;
        font-size: 1.2em;
        margin: 10px;
        text-align: center;
    }

    .menu-toggle {
        display: block;
        font-size: 1.5em;
        cursor: pointer;
        color: #006233;
    }

    .table-container {
        overflow-x: auto;
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

    <!-- Navbar -->
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

    <!-- Contenu de la page -->
    <div class="container">
        <h1>Liste des utilisateurs</h1>

        <!-- Tableau des utilisateurs dans une div pour contrôler la largeur -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Nationalité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $utilisateur): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($utilisateur['id']); ?></td>
                            <td><?php echo htmlspecialchars($utilisateur['nom']); ?></td>
                            <td><?php echo htmlspecialchars($utilisateur['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($utilisateur['email']); ?></td>
                            <td><?php echo htmlspecialchars($utilisateur['nationalite']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Bouton de tirage au sort -->
        <form method="POST">
            <button type="submit" name="tirer_au_sort" class="tirage-btn">Effectuer le tirage au sort</button>
        </form>

        <!-- Affichage du gagnant -->
        <?php if ($gagnant): ?>
            <div class="gagnant">
                <p>Le gagnant est : <strong><?php echo htmlspecialchars($gagnant['prenom'] . ' ' . $gagnant['nom']); ?></strong></p>
                <p>Email : <?php echo htmlspecialchars($gagnant['email']); ?></p>
                <p>Nouvelle nationalité : <?php echo htmlspecialchars($gagnant['nationalite']); ?></p>
            </div>
        <?php endif; ?>
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
