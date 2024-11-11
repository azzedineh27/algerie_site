<?php
// Démarrer la session pour stocker le score si nécessaire
if (session_id() === '') {
    session_start();
}

$prenom = '';
$lien_account = 'index.php?controller=connexion&action=CONNECT';

if (isset($_SESSION['user_id'])) {
    $prenom = $_SESSION['prenom'];
    $lien_account = 'index.php?controller=connexion&action=ESPACE';
}

// Initialiser les variables pour les résultats
$score = 0;
$showResult = false;

// Traitement du formulaire lorsque le quiz est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $showResult = true;

    // Vérification des réponses aux questions faciles
    $answers_easy = [
        'question1' => 'Abdelmajid Tebboune', // Président actuel
        'question2' => 'Dinar', // Monnaie
        'question3' => 'Alger' // Capitale
    ];

    foreach ($answers_easy as $question => $correct_answer) {
        if (isset($_POST[$question]) && strtolower(trim($_POST[$question])) == strtolower($correct_answer)) {
            $score += 4; // Chaque question facile vaut 4 points
        }
    }

    // Vérification des réponses de reconnaissance de personnes
    $correct_people = ['azzedine', 'belmadi', 'bentaleb', 'bougherra', 'brahimi', 'haliche', 'madjer', 'mahrez', 'slimani', 'ziani'];
    $recognized_people = 0;

    // Boucle sur les réponses des utilisateurs pour les personnes célèbres
    for ($i = 1; $i <= 5; $i++) {
        $person = 'person' . $i;
        if (isset($_POST[$person]) && in_array(strtolower(trim($_POST[$person])), $correct_people)) {
            $recognized_people++;
        }
    }
    
    $score += $recognized_people * 2; // Chaque bonne réponse dans cette section vaut 2 points
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz sur l'Algérie</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        @import url('https://fonts.cdnfonts.com/css/ica-rubrik-black');
        @import url('https://fonts.cdnfonts.com/css/poppins');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 80px;
            color: #333;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: #006233;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .logo {
            font-family: 'Roboto Slab', serif;
            font-size: 2em;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            margin-right: auto;
            padding-left: 50px;
        }

        .nav-links a {
            font-size: 1.1em;
            color: white;
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
            border: 2px solid white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            color: white;
            font-size: 1.1em;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .contact-btn:hover {
            background-color: white;
            color: #D52B1E;
        }

        /* Quiz Section */
        .quiz-container {
            width: 80%;
            max-width: 800px;
            margin-top: 50px;
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .quiz-container h2 {
            color: #006233;
            margin-bottom: 20px;
        }

        .quiz-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .quiz-section h3 {
            color: #25283B;
            margin-bottom: 10px;
        }

        .quiz-section p {
            font-size: 1.1em;
            color: #25283B;
        }

        .quiz-section input[type="text"] {
            margin-top: 5px;
            margin-bottom: 10px;
            display: block;
            width: 100%;
            padding: 8px;
            border: 2px solid #006233;
            border-radius: 5px;
            outline: none;
        }

        .submit-btn {
            background-color: #006233;
            color: white;
            padding: 12px 25px;
            font-size: 1.1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #D52B1E;
        }

        .result {
            margin-top: 20px;
            font-size: 1.3em;
            color: #006233;
        }
    </style>
</head>
<body>
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

    <!-- Quiz Section -->
    <div class="quiz-container">
        <h2>Quiz sur l'Algérie</h2>
        
        <form method="POST">
            <!-- Section 1: Questions Faciles -->
            <div class="quiz-section">
                <h3>Questions Faciles</h3>
                <p>1. Qui est le président actuel de l'Algérie ?</p>
                <input type="text" name="question1" required>

                <p>2. Quelle est la monnaie officielle de l'Algérie ?</p>
                <input type="text" name="question2" required>

                <p>3. Quelle est la capitale de l'Algérie ?</p>
                <input type="text" name="question3" required>
            </div>

            <!-- Section 2: Reconnaissance de Personnes -->
            <div class="quiz-section">
                <h3>Reconnaissance de Personnes</h3>
                <p>4. Nommez 5 personnes célèbres parmi les stars de l'équipe de foot d'Algérie visibles dans le carrousel.</p>
                <input type="text" name="person1" placeholder="Personne 1" required>
                <input type="text" name="person2" placeholder="Personne 2" required>
                <input type="text" name="person3" placeholder="Personne 3" required>
                <input type="text" name="person4" placeholder="Personne 4" required>
                <input type="text" name="person5" placeholder="Personne 5" required>
            </div>

            <button type="submit" class="submit-btn">Soumettre le Quiz</button>
        </form>

        <?php
        if ($showResult) {
            echo "<div class='result'>Votre score : $score / 20</div>";
        }
        ?>
    </div>
</body>
</html>
