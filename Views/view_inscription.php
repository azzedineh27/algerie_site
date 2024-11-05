

<?php
// Inclure le fichier de modèle
require_once 'Models/Model_algerie.php';


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

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Instancier le modèle pour interagir avec la base de données
    $model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'Ultime10');

    // Vérifier si l'email existe déjà
    if ($model->emailExiste($email)) {
        echo "L'adresse email est déjà utilisée.";
    } else {
        // Ajouter l'utilisateur dans la base de données
        $user_id = $model->ajouterUtilisateur($nom, $prenom, $email, $tel, $mot_de_passe);
        
        if ($user_id) {
            // Rediriger l'utilisateur après inscription réussie
            header("Location: index.php?controller=connexion&action=ESPACE");
            exit;
        } else {
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Consulat d'Algérie</title>
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

        /* Formulaire Inscription */
        .signup-form-section {
            padding: 50px 50px;
            background-color: #f9f9f9;
            text-align: center;
            margin-top: 100px;
        }

        .signup-form-section h2 {
            font-size: 2.5em;
            color: #006233;
            margin-bottom: 30px;
        }

        form {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form div {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 2px solid #006233;
            border-radius: 5px;
            outline: none;
        }

        .signup-form-submit {
            margin-top: 30px;
            background-color: #006233;
            color: white;
            padding: 15px 30px;
            font-size: 1.2em;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .signup-form-submit:hover {
            background-color: #D52B1E;
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

    <!-- Formulaire d'inscription -->
    <section class="signup-form-section">
        <h2>Créer un compte</h2>

        <form  method="POST">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div>
                <label for="email">Adresse email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="tel">Téléphone :</label>
                <input type="tel" id="tel" name="tel" required>
            </div>

            <div>
                <label for="nationalite">Nationalité :</label>
                <input type="text" id="nationalite" name="nationalite" required>
            </div>

            <div>
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <button type="submit" class="signup-form-submit">S'inscrire</button>
            <a href="index.php?controller=connexion&action=CONNECT" class="signup-form-submit">Connexion</a>
        </form>
    </section>

    <footer>
        © 2024 Consulat d'Algérie - Tous droits réservés
    </footer>

</body>
</html>
