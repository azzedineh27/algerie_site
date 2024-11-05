<?php
// Démarrer la session si elle n'est pas déjà active
if (session_id() === '') {
    session_start();
}

// Vérifier si l'utilisateur est connecté
$prenom = '';
$lien_account = 'index.php?controller=connexion&action=CONNECT'; // Par défaut, lien vers la page de connexion
$utilisateurConnecte = false; // Initialisation par défaut

if (isset($_SESSION['user_id'])) {
    $prenom = $_SESSION['prenom'];  // Récupérer le prénom de l'utilisateur
    $lien_account = 'index.php?controller=connexion&action=ESPACE';  // Lien vers l'espace membre
    $utilisateurConnecte = true;  // L'utilisateur est connecté
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Spin Wheel - Loterie Visa Algérien</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        *{
	        box-sizing: border-box;
        }

        body{
	        margin: 0;
	        padding: 0;
	        background-color: #1d2b36;
	        display: flex;
	        flex-direction: column;
	        align-items: center;
	        justify-content: center;
	        height: 100vh;
	        font-family: 'Arial', sans-serif;
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

        .big-title {
            font-size: 50px;
            color: #FFD700; /* Or pour attirer l'attention */
            margin-bottom: 20px;
            text-align: center;
        }

        /* Style de la roue */
        .container{
	        width: 500px;
	        height: 500px;
	        background-color: #ccc;
	        border-radius: 50%;
	        border: 15px solid #dde;
	        position: relative;
	        overflow: hidden;
	        transition: transform 5s cubic-bezier(0.33, 1, 0.68, 1); /* Smooth acceleration and deceleration */
	        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.5), inset 0px -5px 15px rgba(255, 255, 255, 0.2);
	        filter: brightness(1); /* Starting brightness */
        }

        .container.spin-active {
	        animation: glow 1s infinite alternate; /* Pulsating glow effect */
        }

        @keyframes glow {
	        from {
	            filter: brightness(1);
	        }
	        to {
	            filter: brightness(1.2);
	        }
        }

        .container div{
	        height: 50%;
	        width: 200px;
	        position: absolute;
	        clip-path: polygon(100% 0, 50% 100%, 0 0);
	        transform: translateX(-50%);
	        transform-origin: bottom;
	        text-align: center;
	        display: flex;
	        align-items: center;
	        justify-content: center;
	        font-size: 20px;
	        font-weight: bold;
	        color: #fff;
	        left: 135px;
        }

        .container .one, .container .three, .container .five, .container .seven {
	        background-color: #006233; /* Vert Algérie */
        }

        .container .two, .container .four, .container .six, .container .eight {
	        background-color: #ffffff; /* Blanc Algérie */
	        color: #333;
        }

        .container .two, .container .four {
	        background-color: #d52b1e; /* Rouge Algerie pour le Visa */
	        color: #fff;
	        border: 5px solid #fff;
        }

        .container .one{
	        left: 50%;
        }
        .container .two{
	        transform: rotate(45deg);
        }
        .container .three{
	        transform: rotate(90deg);
        }
        .container .four{
	        transform: rotate(135deg);
        }
        .container .five{
	        transform: rotate(180deg);
        }
        .container .six{
	        transform: rotate(225deg);
        }
        .container .seven{
	        transform: rotate(270deg);
        }
        .container .eight{
	        transform: rotate(315deg);
        }

        #spin{
	        position: absolute;
	        z-index: 10;
	        background-color: #ffffff;
	        text-transform: uppercase;
	        border: 8px solid #006233; /* Bordure verte */
	        font-weight: bold;
	        font-size: 20px;
	        color: #006233;
	        width: 100px;
	        height: 100px;
	        border-radius: 50%;
	        cursor: pointer;
	        outline: none;
	        letter-spacing: 1px;
	        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
        }

        #spin:active {
	        transform: scale(0.95); /* Slight scale on click */
        }


        #arrow {
            width: 0; 
            height: 0; 
            border-left: 25px solid transparent;
            border-right: 25px solid transparent;
            border-top: 50px solid red; /* Couleur de la flèche */
            position: absolute;
            top: calc(50% - 300px); /* Position au-dessus de la roue */
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }

        .message {
            background-color: #D52B1E; /* Rouge du drapeau algérien */
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .connexion-btn {
            padding: 15px 30px;
            background-color: #006233; /* Vert algérien */
            color: white;
            font-size: 18px;
            font-weight: bold;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2); /* Ombre subtile */
        }

        .connexion-btn:hover {
            background-color: #D52B1E; /* Rouge algérien au survol */
            box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.4); /* Augmentation de l'ombre au survol */
        }


        #obtained {
	        margin-top: 20px;
	        font-size: 24px;
	        color: #fff;
	        font-weight: bold;
	        text-align: center;
	        transition: opacity 1s ease;
        }

        #result{
	        margin-top: 10px;
	        font-size: 24px;
	        color: #fff;
	        font-weight: bold;
	        text-align: center;
	        transition: opacity 1s ease;
        }

        #result.hidden, #obtained.hidden{
	        opacity: 0;
        }

        #result.visible, #obtained.visible{
	        opacity: 1;
        }

        /* Ajoutez cette section à votre style CSS existant */

/* Classe pour faire apparaître le message en grand et avec une animation incroyable */
.big-text {
    font-size: 50px; /* Taille énorme pour un impact */
    color: #FFD700; /* Couleur or pour attirer l'attention */
    text-shadow: 0 0 20px rgba(6, 158, 59, 0.8), 
                 0 0 40px rgba(6, 158, 59, 0.8), 
                 0 0 60px rgba(6, 158, 59, 0.8); /* Effet lumineux */
    transition: all 1s ease-in-out;
    animation: pulse 2s infinite; /* Animation de pulsation infinie */
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.2); /* Grossit légèrement */
    }
    100% {
        transform: scale(1);
    }
}

/* Style du bouton "Page de Visa Gratuit" */
#visa-button {
    display: none; /* Initialement caché */
    margin-top: 20px;
    padding: 15px 30px;
    background-color: #006233; /* Vert algérien */
    color: white;
    font-size: 18px;
    font-weight: bold;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2); /* Ombre subtile */
}

#visa-button:hover {
    background-color: #D52B1E; /* Rouge algérien au survol */
    box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.4); /* Augmentation de l'ombre au survol */
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

    <!-- Titre principal -->
    <h1 class="big-title">Gagnez gratuitement un visa algérien</h1>

    <?php if ($utilisateurConnecte): ?>
        <!-- Flèche au-dessus de la roue -->
        <div id="arrow"></div>

        <!-- Spin Wheel Section -->
        <button id="spin">Spin</button>
        <div class="container">
            <div class="one">1</div>
            <div class="two">Visa</div>
            <div class="three">3</div>
            <div class="four">Visa</div>
            <div class="five">5</div>
            <div class="six">6</div>
            <div class="seven">7</div>
            <div class="eight">8</div>
        </div>        
        
        <!-- Ajouter le texte pour afficher la case obtenue -->
        <div id="obtained" class="hidden"></div> <!-- Affiche le résultat obtenu -->
        <div id="result" class="hidden"></div>   <!-- Affiche si tu as gagné ou perdu -->

    <!-- Ajouter le bouton pour la demande de visa gratuit -->
    <a href="index.php?controller=pages&action=GRATUIT" id="visa-button">Page de Visa Gratuit</a>
    <?php else: ?>
        <!-- Message demandant de se connecter -->
        <div class="message">
            Vous devez être connecté pour tourner la roue et tenter de gagner un visa gratuit.
        </div>
        <a href="index.php?controller=connexion&action=CONNECT" class="connexion-btn">Se connecter</a>


    <?php endif; ?>

    <script>
    const spinButton = document.getElementById('spin');
    const resultDiv = document.getElementById('result');
    const obtainedDiv = document.getElementById('obtained');
    const wheel = document.querySelector('.container');
    let spinning = false;

    // Les valeurs de la roue (2 chances sur 8 pour obtenir un visa)
    const cases = ['1', 'Visa', '3', 'Visa', '5', '6', '7', '8'];

    // Fonction pour lancer la rotation de la roue
    function spinWheel() {
        if (spinning) return; // Empêche le démarrage d'une nouvelle rotation si déjà en cours
        spinning = true;
        resultDiv.classList.remove('visible');
        resultDiv.classList.remove('big-text');
        obtainedDiv.classList.add('hidden');
        spinButton.disabled = true; // Désactiver le bouton après le premier clic

        // Calcul d'une rotation aléatoire entre 2000 et 5000 degrés pour créer une impression de rotation longue
        const randomDegree = Math.floor(Math.random() * 3000) + 2000;
        wheel.style.transition = 'transform 5s cubic-bezier(0.33, 1, 0.68, 1)';
        wheel.style.transform = `rotate(${randomDegree}deg)`;

        // Calcul du résultat après 5 secondes (durée de l'animation)
        setTimeout(() => {
            spinning = false;
            const finalDegree = randomDegree % 360; // Garde la rotation finale entre 0 et 360 degrés

            // Calcul pour déterminer quelle case est sous la flèche
            const caseAngleSize = 360 / cases.length; // Chaque case occupe un certain angle (45° ici)

            // Ajuster l'angle pour éviter les erreurs d'arrondi
            let correctedDegree = (360 - finalDegree) + (caseAngleSize / 2);
            if (correctedDegree > 360) {
                correctedDegree = correctedDegree - 360; // Corrige pour rester dans la limite 0-360°
            }

            // Trouver l'index correspondant à la case où s'arrête la roue
            const index = Math.floor(correctedDegree / caseAngleSize);

            // Récupère la case sélectionnée
            const selectedCase = cases[index];

            // Affiche le résultat
            displayResult(selectedCase);
        }, 5000);
    }

    // Fonction pour afficher le résultat
    function displayResult(selectedCase) {
        obtainedDiv.classList.remove('hidden');
        resultDiv.classList.add('visible');

        // Affiche la case obtenue (Visa ou nombre)
        obtainedDiv.textContent = `Résultat obtenu : ${selectedCase}`;

        // Si la case obtenue est "Visa", c'est un gain avec effet spécial
        if (selectedCase === 'Visa') {
            resultDiv.textContent = "Tu as gagné un visa algérien !";
            resultDiv.classList.add('big-text'); // Animation spéciale pour le gain

            // Afficher le bouton pour la page de visa gratuit
            const visaButton = document.getElementById('visa-button');
            visaButton.style.display = 'block'; // Afficher le bouton
        } else {
            resultDiv.textContent = "Tu as perdu, donc pas de visa pour toi.";
            resultDiv.classList.add('big-text'); // Applique aussi la classe pour l'effet incroyable
        }
    }



    // Assigner la fonction de rotation au bouton Spin
    spinButton.addEventListener('click', spinWheel);
    </script>


</body>
</html>
