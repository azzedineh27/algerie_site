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
	        top: 50%;
	        left: 50%;
	        transform: translate(-50%, -50%);
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
	        transition: background-color 0.3s ease, transform 0.3s ease;
	        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
        }

        #spin:active {
	        transform: scale(0.95); /* Slight scale on click */
        }

        #result{
	        margin-top: 20px;
	        font-size: 24px;
	        color: #fff;
	        font-weight: bold;
	        text-align: center;
	        transition: opacity 1s ease;
        }

        #result.hidden{
	        opacity: 0;
        }

        #result.visible{
	        opacity: 1;
        }

    </style>
</head>
<body>

    <nav>
        <div class="logo">Consulat d'Algérie</div>
        <div class="nav-links">
            <a href="index.php?controller=pages&action=VISA">Visa</a>
            <a href="#">Culture de l'Algérie</a>
            <a href="index.php?controller=pages&action=PRESSE">Presse</a>
            <a href="index.php?controller=pages&action=LOTERIE">Loterie</a>
        </div>
        <div class="action-btns">
            <a href="contact.html" class="contact-btn">Contact</a>
            <a href="#" class="contact-btn" title="Espace Membre"><span class="material-symbols-outlined">account_circle</span></a>
        </div>
    </nav>

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
    <div id="result" class="hidden"></div>
    
    <script>
        let container = document.querySelector(".container");
        let btn = document.getElementById("spin");
        let resultDiv = document.getElementById("result");

        // Table des segments avec plus d'entrées pour les autres cases
        let segments = [
            "1", "3", "5", "6", "7", "8", // 6 segments normaux
            "Visa", "Visa",               // 2 segments pour le visa
        ];

        // Ajout de segments multiples pour ajuster les probabilités
        let weightedSegments = [
            ...Array(211).fill("1"), // Augmenter les chances d'obtenir d'autres numéros
            "Visa", "Visa"           // Probabilité plus faible d'obtenir un visa (2 chances sur 213)
        ];

        let clicks = 0;
        btn.onclick = function () {
            clicks += 1;
            if (clicks == 1) {
                // Masquer le résultat initialement
                resultDiv.classList.remove('visible');
                resultDiv.classList.add('hidden');
                
                // Ajout de la classe d'animation pour l'effet lumineux
                container.classList.add('spin-active');

                // Sélection aléatoire basée sur les probabilités
                let randomSegment = Math.floor(Math.random() * weightedSegments.length);
                let chosenSegment = weightedSegments[randomSegment];

                let segmentIndex = segments.indexOf(chosenSegment);
                let degree = segmentIndex * 45; // Chaque segment fait 45 degrés
                let rotation = 3600 + degree;   // Rotation multiple (3600 pour plusieurs tours)

                container.style.transform = "rotate(" + rotation + "deg)";

                // Afficher le résultat après l'animation
                setTimeout(function () {
                    // Supprimer l'effet lumineux
                    container.classList.remove('spin-active');

                    resultDiv.classList.remove('hidden');
                    resultDiv.classList.add('visible');
                    
                    if (chosenSegment === "Visa") {
                        resultDiv.innerText = "Tu as gagné un visa algérien!";
                    } else {
                        resultDiv.innerText = "Pas de visa algérien pour toi";
                    }
                }, 5000); // Attendre 5 secondes pour correspondre à la durée de l'animation
            }
        }
    </script>
</body>
</html>
