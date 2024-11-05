<?php
// Démarrer la session si elle n'est pas déjà active
if (session_id() === '') {
    session_start();
}

// Vérifier si l'utilisateur est connecté
$prenom = '';
$lien_account = 'index.php?controller=connexion&action=CONNECT'; // Par défaut, lien vers la page de connexion

if (isset($_SESSION['user_id'])) {
    $prenom = $_SESSION['prenom'];
    $lien_account = 'index.php?controller=connexion&action=ESPACE';
}

// Inclure le modèle pour interagir avec la base de données
require_once 'C:\wamp64\www\algerie_site\Models\Model_algerie.php';

// Initialiser l'objet du modèle avec les informations de connexion
$model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'Ultime10');

// Récupérer tous les utilisateurs
$utilisateurs = $model->getAllUsers();

// Effectuer le tirage au sort si le bouton est cliqué
$gagnant = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tirer_au_sort'])) {
    $gagnant = $model->tirerAuSortGagnant();
    if ($gagnant) {
        $model->marquerCommeGagnant($gagnant['id']);
        $model->validerDemandeVisa($gagnant['id']);
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
            font-size: 0.9em; /* Réduire la taille de la police */
        }

        th, td {
            padding: 8px; /* Réduire le padding pour compacter le tableau */
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

</body>
</html>
