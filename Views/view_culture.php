<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <title>Document</title>
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
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    background-color: white;
    padding-top: 80px;
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
            color: white; /* Vert du drapeau */
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
            color: #D52B1E; /* Rouge du drapeau */
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


.banner {
    width: 100%;
    min-height: 100vh;
    text-align: center;
    overflow: visible;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 10;
}

.banner .message {
    position: absolute;
    top: 10%; 
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 60px;
    color: #25283B;
    z-index: 2;
    text-align: center;
    font-family: 'ICA Rubrik', sans-serif;
}

@media (max-width: 768px) {
    .banner .message {
        top: 15%; 
        font-size: 40px; 
    }
}


.banner .slider {
    position: relative;
    width: 160px;
    height: 400px;
    transform-style: preserve-3d;
    animation: autoRun 20s linear infinite;
    z-index: 10;
}

@keyframes autoRun {
    from {
        transform: perspective(1000px) rotateX(-16deg) rotateY(0deg);
    }
    to {
        transform: perspective(1000px) rotateX(-16deg) rotateY(360deg);
    }
}

.banner .slider .item {
    position: absolute;
    inset: 0 0 0 0;
    transform: rotateY(calc((var(--position) - 1) * (360 / var(--quantity)) * 1deg)) translateZ(300px);
}

.banner .slider .item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
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
            <a href="view_compte.php" class="contact-btn" title="Espace Membre"><span class="material-symbols-outlined">account_circle</span></a>
        </div>
    </nav>

    <div class="banner">
        <div class="message">
            Découvrez les stars de l'équipe de foot d'Algérie !
        </div>
        <div class="slider" style="--quantity: 10">
            <div class="item" style="--position: 1"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/slimani.jpg" alt=""></div>
            <div class="item" style="--position: 2"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/haliche.jpeg" alt=""></div>
            <div class="item" style="--position: 3"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/mahrez.jpg" alt=""></div>
            <div class="item" style="--position: 4"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/azz.jpg" alt=""></div>
            <div class="item" style="--position: 5"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/ziani.jpeg" alt=""></div>
            <div class="item" style="--position: 6"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/madjer.jpeg" alt=""></div>
            <div class="item" style="--position: 7"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/belmadi.jpg" alt=""></div>
            <div class="item" style="--position: 8"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/bougherra.jpg" alt=""></div>
            <div class="item" style="--position: 9"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/brahimi.jpg" alt=""></div>
            <div class="item" style="--position: 10"><img src="/home/student/905/12206506/Bureau/Mes_Montages/12206506/algerie_site/algerie_site/Images/bentaleb.webp" alt=""></div>
        </div>
    </div>
</body>

</html>