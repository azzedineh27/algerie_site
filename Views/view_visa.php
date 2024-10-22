<?php
// Inclure le modèle (supposons qu'il est dans le répertoire "models")
require_once 'Models/Model_algerie.php';

// Connexion à la base de données (modifier les paramètres avec les bons)
$model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'Ultime10');

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $nationalite = $_POST['nationalite'];
    $num_passeport = $_POST['passeport'];
    $date_creation = $_POST['datecreation'];
    $date_validite = $_POST['datevalidite'];
    
    // Gérer les documents téléchargés
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['documents']['tmp_name'];
        $fileName = $_FILES['documents']['name'];
        $fileSize = $_FILES['documents']['size'];
        $fileType = $_FILES['documents']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedfileExtensions = array('png', 'jpg', 'pdf');
        
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Spécifier le chemin de stockage des fichiers
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $fileName;

            // Déplacer le fichier dans le dossier souhaité
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Appeler le modèle pour créer une demande de visa
                $nationalite_id = $model->getNationaliteId($nationalite);  // Hypothèse que cette méthode existe
                $visa_id = $model->creerDemandeVisa($user_id, $num_passeport, $date_creation, $date_validite, $nationalite_id);

                // Ajouter le document associé à la demande de visa
                $model->ajouterDocument($visa_id, $fileName, $dest_path);

                echo "Demande de visa créée avec succès.";
            } else {
                echo "Erreur lors du téléversement du fichier.";
            }
        } else {
            echo "Type de fichier non autorisé.";
        }
    } else {
        echo "Erreur lors de la soumission du fichier.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Visa - Consulat d'Algérie</title>
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

        /* Formulaire Visa */
        .visa-header {
            padding: 100px 50px;
            text-align: center;
            background-color: #006233;
            color: white;
        }

        .visa-header h1 {
            font-family: 'Roboto Slab', serif;
            font-size: 3em;
            margin-bottom: 10px;
        }

        .visa-header p {
            font-size: 1.3em;
            margin: 0;
        }

        .visa-form-section {
            padding: 50px 50px;
            background-color: #f9f9f9;
            text-align: center;
        }

        .visa-form-section h2 {
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

        input, select {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 2px solid #006233;
            border-radius: 5px;
            outline: none;
        }

        input[type="date"] {
            padding: 9px;
        }

        input[type="file"] {
            border: none;
        }

        .visa-form-submit {
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

        .visa-form-submit:hover {
            background-color: #D52B1E;
        }

        footer {
            padding: 20px 0;
            background-color: #006233;
            color: white;
            text-align: center;
            margin-top: 50px;
        }

        /* Red Section for error message (e.g., invalid passport or forbidden nationalities) */
        .error-message {
            background-color: #D52B1E;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            text-align: left;
            border-radius: 5px;
            display: none; /* Hidden by default */
        }

    </style>
</head>
<body>

    <!-- Navbar -->
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

    <!-- Header Section for the Visa page -->
    <section class="visa-header">
        <h1>Demande de Visa</h1>
        <p>Veuillez remplir le formulaire ci-dessous pour soumettre votre demande de visa.</p>
    </section>

    <!-- Formulaire de demande de visa -->
    <section class="visa-form-section">
        <h2>Formulaire de Demande de Visa</h2>

        <!-- Error Message Example (Hidden by Default) -->
        <div class="error-message" id="errorMessage">
            Votre passeport est invalide ou votre nationalité ne permet pas de demander un visa.
        </div>

        <form id="visaForm">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div>
                <label for="tel">Téléphone :</label>
                <input type="tel" id="tel" name="tel" required>
            </div>

            <div>
                <label for="nationalite">Nationalité :</label>
                <select id="nationalite" name="nationalite" required>
                    <option value="algérienne">Algérienne</option>
                    <option value="française">Française</option>
                    <option value="marocaine">Marocaine</option>
                    <option value="espagnole">Espagnole</option>
                    <!-- Ajouter d'autres nationalités ici -->
                </select>
            </div>

            <div>
                <label for="passeport">Numéro de Passeport :</label>
                <input type="text" id="passeport" name="passeport" required>
            </div>

            <div>
                <label for="datecreation">Date de Création du Passeport :</label>
                <input type="date" id="datecreation" name="datecreation" required>
            </div>

            <div>
                <label for="datevalidite">Date de Validité du Passeport :</label>
                <input type="date" id="datevalidite" name="datevalidite" required>
            </div>

            <div>
                <label for="documents">Télécharger vos documents (format .png, .jpg, .pdf) :</label>
                <input type="file" id="documents" name="documents" accept=".png, .jpg, .pdf" required>
            </div>

            <button type="submit" class="visa-form-submit">Soumettre la Demande</button>
        </form>
    </section>

    <footer>
        © 2024 Consulat d'Algérie - Tous droits réservés
    </footer>

</body>
</html>
