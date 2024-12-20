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

// Inclusion de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer Autoload

// Initialisation du message de confirmation d'envoi
$message_envoye = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $message_content = $_POST['message'];

    // Configuration de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Remplacez par votre serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'azzedinehatem@gmail.com'; // Utilisez votre adresse e-mail réelle
        $mail->Password = 'mdpgoogle'; // Utilisez votre mot de passe réel ou mot de passe d'application
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinataire et expéditeur
        $mail->setFrom('azzedinehatem@gmail.com', 'Expediteur'); // Utilisez votre adresse e-mail réelle comme expéditeur
        $mail->addAddress('azzedinehatem@gmail.com', 'Nom du Destinataire');

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];
        

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message depuis le formulaire de contact';
        $mail->Body = "
            <h2>Nouveau message de contact</h2>
            <p><strong>Nom :</strong> $nom</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Téléphone :</strong> $tel</p>
            <p><strong>Message :</strong><br>$message_content</p>
        ";
        $mail->AltBody = "Nom : $nom\nEmail : $email\nTéléphone : $tel\nMessage : $message_content";
        

        // Envoi de l'email
        $mail->send();
        $message_envoye = 'Votre message a été envoyé avec succès !';
    } catch (Exception $e) {
        $message_envoye = "Erreur lors de l'envoi : " . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Algérie - Consulat d'Algérie</title>
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
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            background-image: url('Images/algerie_contact.jpg'); /* Image en fond */
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Fixe l'image pour éviter le décalage */
            font-family: 'Open Sans', sans-serif;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
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

        .container {
            background-color: rgba(255, 255, 255, 0.5); /* Opacité légèrement réduite */
            border-radius: 15px;
            padding: 30px;
            width: 400px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            backdrop-filter: blur(8px); /* Augmentation légère du flou */
            position: relative; /* Position relative pour ajuster la couche */
            margin-top: 100px; /* Pour éviter que le formulaire soit caché par la navbar */
        }

        h2 {
            color: #006233; /* Vert du drapeau algérien */
            font-size: 24px;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #006233;
            border-radius: 6px;
            background-color: rgba(255, 255, 255, 0.95); /* Plus de contraste pour lisibilité */
            outline: none;
        }

        input:focus, textarea:focus {
            border-color: #D52B1E; /* Rouge du drapeau algérien */
        }

        textarea {
            resize: none;
            height: 100px;
        }

        button {
            background-color: #006233;
            color: white;
            padding: 12px 0;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
        }

        button:hover {
            background-color: #D52B1E;
            transform: scale(1.03); /* Animation plus subtile lors du survol */
        }
    </style>
</head>
<body>

<!-- Barre de navigation -->
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
            <!-- Lien vers l'espace membre (connecté ou non) -->
            <a href="index.php?controller=connexion&action=CONNECT" class="contact-btn" title="Espace Membre">
                <span class="material-symbols-outlined">account_circle</span>
            </a>
        </div>
</nav>

<!-- Formulaire de contact -->
<div class="container">
    <h2>Contactez-nous</h2>
    <?php if ($message_envoye): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message_envoye); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Votre email" required>
        </div>
        <div class="form-group">
            <label for="tel">Téléphone</label>
            <input type="tel" id="tel" name="tel" placeholder="Votre téléphone" required>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Votre message" required></textarea>
        </div>
        <button type="submit">Envoyer</button>
    </form>
</div>

</body>
</html>
