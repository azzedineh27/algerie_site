<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès refusé</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8d7da;
            color: #721c24;
        }

        .error-container {
            text-align: center;
            padding: 20px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            max-width: 500px;
        }

        h1 {
            font-size: 2em;
            color: #721c24;
        }

        p {
            margin-top: 10px;
            font-size: 1.2em;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #006233;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #D52B1E;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Accès refusé</h1>
        <p>Vous n'avez pas l'autorisation d'accéder à cette page car vous n'êtes pas l'administrateur.</p>
        <a href="index.php">Retour à l'accueil</a>
    </div>
</body>
</html>
