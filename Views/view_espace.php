<?php
// Démarrer la session si elle est pas deja active
if (session_id() === '') {
    session_start();
  }

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}

// Si l'utilisateur est connecté, récupérer ses informations
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Membre - Consulat d'Algérie</title>
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

        /* Espace Membre */
        .espace-section {
            padding: 100px 50px;
            background-color: #f9f9f9;
            text-align: center;
            margin-top: 100px;
        }

        .espace-section h2 {
            font-size: 2.5em;
            color: #006233;
            margin-bottom: 30px;
        }

        .espace-section p {
            font-size: 1.5em;
            color: #333;
        }

        .espace-section .logout-btn {
            margin-top: 30px;
            background-color: #D52B1E;
            color: white;
            padding: 15px 30px;
            font-size: 1.2em;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .espace-section .logout-btn:hover {
            background-color: #006233;
        }

        footer {
            padding: 20px 0;
            background-color: #006233;
            color: white;
            text-align: center;
            margin-top: 50px;
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
        </div>
        <div class="action-btns">
            <a href="index.php?controller=footer&action=CONTACT" class="contact-btn">Contact</a>
            <a href="logout.php" class="contact-btn" title="Déconnexion"><span class="material-symbols-outlined">logout</span></a>
        </div>
    </nav>

    <!-- Espace Membre -->
    <section class="espace-section">
        <h2>Bienvenue dans votre Espace Membre, <?php echo $prenom . " " . $nom; ?></h2>
        <p>Cet espace est réservé aux utilisateurs connectés. Vous pouvez gérer vos informations ici.</p>

        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Se déconnecter</button>
        </form>
    </section>

    <footer>
        © 2024 Consulat d'Algérie - Tous droits réservés
    </footer>

</body>
</html>
