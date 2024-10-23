<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Algérie - Consulat d'Algérie</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body, html {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('Images/algerie_contact.jpg'); /* Utilisation de ton image en fond */
            background-size: cover;
            background-position: center;
            font-family: 'Open Sans', sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Légèrement transparent pour laisser apparaître le fond */
            border-radius: 15px;
            padding: 30px;
            width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #006233; /* Vert du drapeau algérien */
            margin-bottom: 20px;
            font-size: 24px;
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

        input,
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #006233;
            border-radius: 5px;
            background-color: #f9f9f9;
            outline: none;
        }

        input:focus,
        textarea:focus {
            border-color: #D52B1E; /* Rouge du drapeau algérien */
        }

        textarea {
            resize: none;
            height: 100px;
        }

        button {
            background-color: #006233;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #D52B1E;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Contactez-nous</h2>
        <form>
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
