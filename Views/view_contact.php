<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Consulat d'Algérie</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(-45deg, #006233, #D52B1E, #fff);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .envelope-container {
            position: relative;
            width: 300px;
            height: 200px;
            transform-style: preserve-3d;
            perspective: 1000px;
            transition: transform 1s;
        }

        /* L'enveloppe elle-même */
        .envelope {
            position: absolute;
            width: 100%;
            height: 100%;
            background: #fff;
            border: 2px solid #006233;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            transition: transform 1s;
        }

        /* Rabat supérieur de l'enveloppe */
        .envelope:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #006233;
            clip-path: polygon(0 0, 100% 0, 50% 100%);
            transform-origin: bottom;
            transform: rotateX(-150deg); /* Par défaut, le rabat est ouvert */
            transition: transform 1s;
        }

        /* Fermeture de l'enveloppe (après la soumission) */
        .envelope-container.closed .envelope:before {
            transform: rotateX(0deg); /* Le rabat se ferme */
        }

        /* Formulaire de contact */
        .contact-form {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1;
        }

        /* Le formulaire disparaît après la soumission */
        .envelope-container.closed .contact-form {
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: opacity 1s, transform 1s;
        }

        h2 {
            margin-bottom: 15px;
            font-size: 24px;
            color: #006233;
            text-align: center;
        }

        label {
            color: #333;
            font-size: 12px;
            margin-bottom: 8px;
            display: block;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #006233;
            border-radius: 8px;
            background: #f0f0f0;
            outline: none;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #006233;
            color: white;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #D52B1E;
        }

        /* Message de confirmation */
        .confirmation-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #006233;
            font-size: 18px;
            text-align: center;
            opacity: 0;
            transition: opacity 1s;
            z-index: -1;
        }

        .envelope-container.closed .confirmation-message {
            opacity: 1;
            z-index: 2;
        }
    </style>
</head>
<body>

    <!-- Conteneur de l'enveloppe -->
    <div class="envelope-container" id="envelopeContainer">
        <!-- Enveloppe ouverte avec le formulaire -->
        <div class="envelope"></div>

        <!-- Formulaire de contact -->
        <div class="contact-form" id="contactForm">
            <h2>Contactez-nous</h2>
            <form id="contactFormFields">
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
                    <textarea id="message" name="message" rows="4" placeholder="Votre message" required></textarea>
                </div>
                <button type="submit">Envoyer</button>
            </form>
        </div>

        <!-- Message de confirmation -->
        <div class="confirmation-message" id="confirmationMessage">
            <p>Message envoyé avec succès !</p>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        const contactForm = document.getElementById('contactFormFields');
        const envelopeContainer = document.getElementById('envelopeContainer');
        const confirmationMessage = document.getElementById('confirmationMessage');

        // Gestion de la soumission du formulaire
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            
            // Fermeture de l'enveloppe et affichage du message de confirmation
            envelopeContainer.classList.add('closed');
        });
    </script>

</body>
</html>
