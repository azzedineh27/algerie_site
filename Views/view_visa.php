<?php
// Inclure le modèle
require_once 'Models/Model_algerie.php';
// Inclure FPDF
require 'vendor/autoload.php';


// Démarrer la session si pas deja fait
if (session_id() === '') {
    session_start();
}

// Vérifier si l'utilisateur est connecté
$prenom = '';
$lien_account = 'index.php?controller=connexion&action=CONNECT'; // Par défaut, lien vers la page de connexion

if (isset($_SESSION['user_id'])) {
    // Si l'utilisateur est connecté, récupérer les informations de l'utilisateur
    $prenom = $_SESSION['prenom'];
    $user_id = $_SESSION['user_id'];
    $lien_account = 'index.php?controller=connexion&action=ESPACE';
} else {
    // Rediriger si l'utilisateur n'est pas connecté
    header("Location: index.php?controller=connexion&action=ERREUR_VISA");
    exit;
}

// Connexion à la base de données
$model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'Ultime10');

// Récupérer les nationalités depuis la base de données
$nationalites = $model->getNationalites();

// Initialisation du message d'erreur ou de succès
$message = "";

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dossier de destination pour les passeports
    $dossierPasseports = 'C:/wamp64/www/algerie_site/Passeports/';
    
    // Vérifier si l'utilisateur a déjà une demande de visa
    if ($model->demandeVisaExiste($user_id)) {
        $message = "<div class='error-message'>Vous avez déjà une demande de visa en cours.</div>";
    } else {
        // Récupérer les données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $tel = $_POST['tel'];
        $nationalite = $_POST['nationalite'];
        $num_passeport = $_POST['passeport'];
        $date_creation = $_POST['datecreation'];
        $date_validite = $_POST['datevalidite'];

        // Vérification du délai de 10 ans entre la date de création et la date de validité du passeport
        $dateCreationObj = new DateTime($date_creation);
        $dateValiditeObj = new DateTime($date_validite);
        $interval = $dateCreationObj->diff($dateValiditeObj);

        if ($interval->y != 10 || $interval->m != 0 || $interval->d != 0) {
            // Si l'intervalle n'est pas exactement de 10 ans, afficher un message d'erreur
            $message = "<div class='error-message'>Le délai entre la création et la validité du passeport doit etre de 10 ans.</div>";
        } else {
            // Vérifier le fichier téléchargé
            if (isset($_FILES['fichier_passeport'])) {
                $fichierTmp = $_FILES['fichier_passeport']['tmp_name'];
                $fichierNom = basename($_FILES['fichier_passeport']['name']);
                $fichierType = strtolower(pathinfo($fichierNom, PATHINFO_EXTENSION));
                
                // Valider le type de fichier et la taille
                $typesPermis = ['pdf', 'jpg', 'jpeg', 'png'];
                if (!in_array($fichierType, $typesPermis)) {
                    $message = "<div class='error-message'>Le fichier doit être au format PDF, JPG, JPEG ou PNG et ne pas dépasser 5 Mo.</div>";
                } else {
                    // Générer un nom de fichier unique
                    $fichierNouveauNom = uniqid("passeport_{$user_id}_") . '.' . $fichierType;
                    $cheminFichierFinal = $dossierPasseports . $fichierNouveauNom;

                    // Déplacer le fichier vers le dossier de destination
                    if (move_uploaded_file($fichierTmp, $cheminFichierFinal)) {
                        // Créer une demande de visa
                        $nationalite_id = $model->getNationaliteId($nationalite);
                        $visa_id = $model->creerDemandeVisa($user_id, $num_passeport, $date_creation, $date_validite, $nationalite_id);

                        if ($visa_id) {
                            $message = "<div class='success-message'>Demande de visa créée avec succès et passeport téléchargé.</div>";

                            // Générer le PDF de confirmation
                            $pdf = new FPDF();
                            $pdf->AddPage();
                            $pdf->SetFont('Arial', 'B', 16);

                            // En-tête du PDF
                            $pdf->Cell(0, 10, 'Demande de Visa - Consulat d\'Algerie', 0, 1, 'C');
                            $pdf->Ln(10);

                            // Informations de la demande
                            $pdf->SetFont('Arial', '', 12);
                            $pdf->Cell(0, 10, 'Informations de la Demande:', 0, 1);
                            $pdf->Ln(5);

                            // Afficher les informations du demandeur
                            $pdf->SetFont('Arial', '', 12);
                            $pdf->Cell(50, 10, 'Nom:', 0, 0);
                            $pdf->Cell(0, 10, $nom, 0, 1);
                            $pdf->Cell(50, 10, 'Prenom:', 0, 0);
                            $pdf->Cell(0, 10, $prenom, 0, 1);
                            $pdf->Cell(50, 10, 'Telephone:', 0, 0);
                            $pdf->Cell(0, 10, $tel, 0, 1);
                            $pdf->Cell(50, 10, 'Nationalite:', 0, 0);
                            $pdf->Cell(0, 10, $nationalite, 0, 1);
                            $pdf->Cell(50, 10, 'Numero de Passeport:', 0, 0);
                            $pdf->Cell(0, 10, $num_passeport, 0, 1);
                            $pdf->Cell(50, 10, 'Date Creation Passeport:', 0, 0);
                            $pdf->Cell(0, 10, $date_creation, 0, 1);
                            $pdf->Cell(50, 10, 'Date Validite Passeport:', 0, 0);
                            $pdf->Cell(0, 10, $date_validite, 0, 1);
                            $pdf->Cell(50, 10, 'La demande de visa est en attente veuillez attendre la confirmation dans un delai de 2 à 4 semaines.', 0, 0);

                            // Sauvegarder et télécharger le PDF
                            $pdf_name = "Demande_Visa_{$user_id}.pdf";
                            $pdf->Output('D', $pdf_name);
                            exit;
                        } else {
                            $message = "<div class='error-message'>Erreur lors de la création de la demande.</div>";
                        }
                    } else {
                        $message = "<div class='error-message'>Erreur lors du téléchargement du fichier.</div>";
                    }
                }
            } else {
                $message = "<div class='error-message'>Veuillez télécharger un fichier de passeport valide.</div>";
            }
        }
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
            font-size: 1.8em;
            color: #006233;
        }
        .nav-links {
            display: flex;
            gap: 20px;
            margin-right: auto;
            padding-left: 50px;
        }
        .nav-links a {
            font-size: 1em;
            color: #006233;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .nav-links a:hover {
            color: #D52B1E;
        }
        .action-btns {
            display: flex;
            gap: 15px;
        }
        .contact-btn {
            border: 2px solid #006233;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            color: #006233;
            font-size: 1em;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .contact-btn:hover {
            background-color: #D52B1E;
            color: white;
        }

        /* Formulaire Visa */
        .visa-form-section {
            padding: 30px 20px;
            background-color: #f9f9f9;
            text-align: center;
            margin-top: 80px;
        }
        .visa-form-section h2 {
            font-size: 2em;
            color: #006233;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form div {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            font-size: 1em;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 8px;
            font-size: 0.9em;
            border: 2px solid #006233;
            border-radius: 5px;
            outline: none;
        }
        .visa-form-submit {
            margin-top: 20px;
            background-color: #006233;
            color: white;
            padding: 12px 25px;
            font-size: 1.1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .visa-form-submit:hover {
            background-color: #D52B1E;
        }
        .error-message {
            background-color: #D52B1E;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            text-align: left;
            border-radius: 5px;
        }
        .success-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            text-align: left;
            border-radius: 5px;
        }
        footer {
            padding: 15px 0;
            background-color: #006233;
            color: white;
            text-align: center;
            margin-top: 40px;
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

    <!-- Formulaire de demande de visa -->
    <section class="visa-form-section">
        <h2>Formulaire de Demande de Visa</h2>

        <!-- Message de validation ou d'erreur -->
        <?php echo $message; ?>

        <form id="visaForm" method="POST" enctype="multipart/form-data">
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
                    <?php foreach ($nationalites as $n): ?>
                        <option value="<?php echo htmlspecialchars($n['nationalite']); ?>">
                            <?php echo htmlspecialchars($n['nationalite']); ?>
                        </option>
                    <?php endforeach; ?>
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
                <label for="fichier_passeport">Télécharger le passeport :</label>
                <input type="file" id="fichier_passeport" name="fichier_passeport" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>

            <button type="submit" class="visa-form-submit">Soumettre la Demande</button>
        </form>
    </section>

    <footer>
        © 2024 Consulat d'Algérie - Tous droits réservés
    </footer>

</body>
</html>
