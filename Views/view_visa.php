<?php
// Démarrer la session si elle n'est pas déjà active
if (session_id() === '') {
    session_start();
}

// Inclure le modèle de connexion à la base de données et FPDF
require_once 'Models/Model_algerie.php';
require 'vendor/autoload.php';

// Connexion à la base de données
$model = new Model_algerie('localhost', 'consulat_algerie', 'root', 'Ultime10');

// Vérifier si l'utilisateur est connecté
$prenom = '';
$lien_account = 'index.php?controller=connexion&action=CONNECT';

if (isset($_SESSION['user_id'])) {
    $prenom = $_SESSION['prenom'];
    $user_id = $_SESSION['user_id'];
    $lien_account = 'index.php?controller=connexion&action=ESPACE';

    // Vérifier si une demande de visa est déjà en cours
    if ($model->demandeVisaExiste($user_id)) {
        // Rediriger l'utilisateur vers une page indiquant une demande de visa en cours
        header("Location: index.php?controller=pages&action=VISA_EXISTANT");
        exit;
    }
} else {
    // Si l'utilisateur n'est pas connecté, le rediriger vers une page d'erreur ou de connexion
    header("Location: index.php?controller=connexion&action=ERREUR_VISA");
    exit;
}

$nationalites = $model->getNationalites();
$message = "";
$showPaymentForm = false; // Indique si le formulaire de carte bancaire doit être affiché
$errors = []; // Pour stocker les erreurs du formulaire de paiement

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['visaFormSubmit'])) {
        // Récupérer les données du formulaire de visa
        $_SESSION['visa_data'] = [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'tel' => $_POST['tel'],
            'nationalite' => trim($_POST['nationalite']),
            'num_passeport' => $_POST['passeport'],
            'date_creation' => $_POST['datecreation'],
            'date_validite' => $_POST['datevalidite']
        ];

            // Vérification du délai de 10 ans entre la date de création et la date de validité du passeport
            $dateCreationObj = new DateTime($_SESSION['visa_data']['date_creation']);
            $dateValiditeObj = new DateTime($_SESSION['visa_data']['date_validite']);
            $interval = $dateCreationObj->diff($dateValiditeObj);

            $dateLimite = new DateTime('2024-11-14');

            
                // Vérifier le fichier téléchargé
                if (isset($_FILES['fichier_passeport'])) {
                    $fichierTmp = $_FILES['fichier_passeport']['tmp_name'];
                    $fichierNom = basename($_FILES['fichier_passeport']['name']);
                    $fichierType = strtolower(pathinfo($fichierNom, PATHINFO_EXTENSION));
                    $tailleFichier = $_FILES['fichier_passeport']['size'];
                    
                    // Valider le type de fichier et la taille (5 Mo maximum)
                    $typesPermis = ['pdf', 'jpg', 'jpeg', 'png'];
                    if (!in_array($fichierType, $typesPermis) || $tailleFichier > 5242880) {
                        $message = "<div class='error-message'>Le fichier doit être au format PDF, JPG, JPEG ou PNG et ne pas dépasser 5 Mo.</div>";
                    } else {
                        // Toutes les validations de formulaire de visa sont réussies, afficher le formulaire de carte bancaire
                        $showPaymentForm = true;
                    }
                } else {
                    $message = "<div class='error-message'>Veuillez télécharger un fichier de passeport valide.</div>";
                }
        } elseif (isset($_POST['paymentFormSubmit'])) {
        // Récupérer les données de session du formulaire de visa
        if (isset($_SESSION['visa_data'])) {
            $nom = $_SESSION['visa_data']['nom'];
            $prenom = $_SESSION['visa_data']['prenom'];
            $tel = $_SESSION['visa_data']['tel'];
            $nationalite = $_SESSION['visa_data']['nationalite'];
            $num_passeport = $_SESSION['visa_data']['num_passeport'];
            $date_creation = $_SESSION['visa_data']['date_creation'];
            $date_validite = $_SESSION['visa_data']['date_validite'];
        } else {
            $message = "<div class='error-message'>Erreur : Les informations du formulaire de visa sont manquantes.</div>";
        }

        // Validation du formulaire de carte bancaire
        $card_number = $_POST['card_number'];
        $cvv = $_POST['cvv'];
        $expiration_date = $_POST['expiration_date'];
        $currentDate = new DateTime('now');
        $expirationDate = DateTime::createFromFormat('Y-m', $expiration_date);
        
        // Si pas d'erreurs de paiement, créer la demande de visa
        if (empty($errors)) {
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
                
                // Supprimer les données de session après la soumission réussie
                unset($_SESSION['visa_data']);
                
                exit;
            } else {
                $message = "<div class='error-message'>Erreur lors de la création de la demande.</div>";
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

.payment-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.payment-form {
    position: relative;
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.payment-form input {
    width: 100%;
    padding: 8px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.payment-form button {
    width: 100%;
    padding: 10px;
    background-color: #006233;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.payment-form button:hover {
    background-color: #D52B1E;
}

.close-button {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close-button:hover {
    color: #D52B1E;
}

footer {
    padding: 40px 0;
    background-color: #006233;
    color: white;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
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

/* Responsive Styles */
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

    .menu-toggle {
        display: block;
        font-size: 1.5em;
        cursor: pointer;
        color: #006233;
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
    <section id="visaFormSection" class="visa-form-section" <?php echo $showPaymentForm ? 'style="filter: blur(4px);"' : ''; ?>>
        <h2>Formulaire de Demande de Visa</h2>
        <?php echo $message; ?>

        <!-- Message de validation ou d'erreur -->
        <?php echo $message; ?>

        <form id="visaForm" method="POST" enctype="multipart/form-data">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Le nom ne peut contenir que des lettres, des espaces, des tirets et des apostrophes." required>
            </div>

            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div>
                <label for="tel">Téléphone :</label>
                <input type="tel" id="tel" name="tel" pattern="\d{10}" title="Le numéro de téléphone doit contenir 10 chiffres." required>
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

            <button type="submit" name="visaFormSubmit" class="visa-form-submit">Soumettre la Demande</button>
        </form>
    </section>

<!-- Formulaire de carte bancaire en superposition -->
<div class="payment-overlay" id="paymentOverlay">
    <div class="payment-form">
        <!-- Bouton de fermeture -->
        <span class="close-button" onclick="closePaymentForm()">×</span>
        
        <h3>Informations de Paiement</h3>
        <form method="POST">
            <input type="text" name="card_number" placeholder="Numéro de Carte (16 chiffres)" required>
            <?php if (isset($errors['card_number'])) echo "<div class='error-message'>{$errors['card_number']}</div>"; ?>
            
            <input type="text" name="cvv" placeholder="Code CVV (3 chiffres)" required>
            <?php if (isset($errors['cvv'])) echo "<div class='error-message'>{$errors['cvv']}</div>"; ?>
            
            <input type="month" name="expiration_date" placeholder="Date d'Expiration (MM/AA)" required>
            <?php if (isset($errors['expiration_date'])) echo "<div class='error-message'>{$errors['expiration_date']}</div>"; ?>
            
            <button type="submit" name="paymentFormSubmit">Valider le Paiement</button>
        </form>
    </div>
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

    // Liste des nationalités interdites
const nationalitesInterdites = ['Israelienne', 'Taiwanaise'];

    function closePaymentForm() {
    document.getElementById("paymentOverlay").style.display = "none";
    document.getElementById("visaFormSection").style.filter = "none"; // Enlever le flou
}
document.addEventListener("DOMContentLoaded", function () {
    const visaForm = document.getElementById("visaForm");

    // Date limite de référence pour la création et la validité du passeport
    const dateLimite = new Date('2024-11-14');

    // Validation du formulaire de demande de visa
    visaForm.addEventListener("submit", function (event) {
        const dateCreation = new Date(visaForm.datecreation.value);
        const dateValidite = new Date(visaForm.datevalidite.value);
        const tenYearsLater = new Date(dateCreation);
        tenYearsLater.setFullYear(dateCreation.getFullYear() + 10);

        

        // Vérification que la date de création n'est pas après le 14 novembre 2024
        if (dateCreation > dateLimite) {
            alert("La date de création ne peut pas être postérieure au 14 novembre 2024.");
            event.preventDefault();
            return;
        }

        // Vérification que la date de validité n'est pas avant le 14 novembre 2024
        if (dateValidite < dateLimite) {
            alert("La date de validité ne peut pas être antérieure au 14 novembre 2024.");
            event.preventDefault();
            return;
        }
        // Vérification du délai de 10 ans entre date de création et de validité
        if (tenYearsLater.toISOString().split("T")[0] !== visaForm.datevalidite.value) {
            alert("Le délai entre la création et la validité du passeport doit être de 10 ans.");
            event.preventDefault();
            return;
        }
        // Vérification de la nationalité interdite
        const nationalitesInterdites = ['Israelienne', 'Taiwanaise'];
        const nationalite = visaForm.nationalite.value.trim();
        if (nationalitesInterdites.includes(nationalite)) {
            alert("La nationalité sélectionnée n'est pas autorisée pour une demande de visa.");
            event.preventDefault();
            return;
        }

        // Vérification des chiffres identiques dans le numéro de passeport
        const numPasseport = visaForm.passeport.value.trim();
        if (/^(\d)\1*$/.test(numPasseport)) {
            alert("Le numéro de passeport ne doit pas comporter une série de chiffres identiques.");
            event.preventDefault();
            return;
        }
    });
});

        // Validation du formulaire de paiement
        paymentForm.addEventListener("submit", function (event) {
            const cardNumber = paymentForm.card_number.value;
            const cvv = paymentForm.cvv.value;
            const expirationDate = paymentForm.expiration_date.value;
            const currentDate = new Date();
            const expDate = new Date(expirationDate + "-01");

            if (!/^\d{16}$/.test(cardNumber)) {
                alert("Le numéro de carte bancaire doit comporter 16 chiffres.");
                event.preventDefault();
            }
            if (!/^\d{3}$/.test(cvv)) {
                alert("Le code CVV doit comporter 3 chiffres.");
                event.preventDefault();
            }
            if (expDate <= currentDate) {
                alert("La date d'expiration de la carte doit être postérieure à la date actuelle.");
                event.preventDefault();
            }
        });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuToggle = document.querySelector(".menu-toggle");
        const navLinks = document.querySelector(".nav-links");
        const actionBtns = document.querySelector(".action-btns");

        menuToggle.addEventListener("click", () => {
            navLinks.classList.toggle("active");
            actionBtns.classList.toggle("active");
        });
    });

    function closePaymentForm() {
        document.getElementById("paymentOverlay").style.display = "none";
        document.getElementById("visaFormSection").style.filter = "none"; // Enlever le flou
    }
</script>



</body>
</html>