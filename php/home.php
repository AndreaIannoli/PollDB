
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PollDB - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/home.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
<?php
    require 'accountManager.php';
    logout();
?>
<!--====== NAVBAR ONE PART START ======-->
<section class="navbar-area navbar-one">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="index.php">
                        <img src="../img/logoPollDBWhite.png" alt="Logo"  style="width: 150px"/>
                    </a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarOne"
                        aria-controls="navbarOne"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarOne">
                        <ul class="navbar-nav m-auto">
                            <li class="nav-item">
                                <a
                                    class="page-scroll active"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#sub-nav1"
                                    aria-controls="sub-nav1"
                                    aria-expanded="false"
                                    aria-label="Toggle navigation"
                                    href="javascript:void(0)"
                                >
                                    Home
                                </a>
                                <ul class="sub-menu collapse" id="sub-nav1">
                                    <li><a href="#project">Il progetto</a></li>
                                    <li><a href="#team">Il nostro team</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="https://github.com/AndreaIannoli/PollDB" target="_blank">GitHub</a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0)">Contatti</a>
                            </li>
                        </ul>
                    </div>
                    <div class="navbar-btn d-none d-sm-inline-block">
                        <ul style="margin-bottom: 0px; padding-left: 0px;">
                            <li>
                                <a class="btn primary-btn-outline" href="login.php"
                                >Login</a
                                >
                            </li>
                            <li>
                                <a class="btn primary-btn" href="registrationChoice.php"
                                >Registrati</a
                                >
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- navbar -->
            </div>
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!--====== NAVBAR ONE PART ENDS ======-->
<div class="container-md">
    <div class="row" id="section1-container">
        <div class="col-4">
            <h1 class="display-1" id="heading1">Scopri cosa pensano di te!</h1>
        </div>
        <div class="col-6">
            <lottie-player src="../img/headingWobbler.json" speed="1"  style="width: 100%; z-index: 0;" autoplay loop id="heading-wobbler"></lottie-player>
            <lottie-player src="../img/survey.json" background="transparent"  speed="0.6"  style="width: 100%; z-index: 1;" autoplay loop id="heading-image"></lottie-player>
        </div>
    </div>
</div>
<!--====== FEATURE ONE PART START ======-->
<lottie-player src="../img/borderWoobler.json" background="transparent"  speed="1" autoplay loop class="section-top-border" style="z-index: 0"></lottie-player>
<section class="features-area features-one" style="z-index: 1; position: relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title text-center">
                    <h3 class="title">Cosa potrai fare...</h3>
                    <p class="text">
                        Basta perdere tempo per analizzare i risultati dei tuoi sondaggi!
                    </p>
                </div>
                <!-- row -->
            </div>
        </div>
        <!-- row -->
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-7 col-sm-9">
                <div class="features-style-one text-center">
                    <div class="features-icon">
                        <i class="bi bi-patch-plus-fill"></i>
                    </div>
                    <div class="features-content">
                        <h4 class="features-title">Crea sondaggi</h4>
                        <p class="text">
                            Crea facilmente sondaggi con nuove domande o già create in precedenza
                        </p>
                    </div>
                </div>
                <!-- single features -->
            </div>
            <div class="col-lg-4 col-md-7 col-sm-9">
                <div class="features-style-one text-center">
                    <div class="features-icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div class="features-content">
                        <h4 class="features-title">Premia i tuoi utenti</h4>
                        <p class="text">
                            Metti in palio premi per gli utenti che risponderanno ai sondaggi
                        </p>
                    </div>
                </div>
                <!-- single features -->
            </div>
            <div class="col-lg-4 col-md-7 col-sm-9">
                <div class="features-style-one text-center">
                    <div class="features-icon">
                        <i class="bi bi-clipboard-data-fill"></i>
                    </div>
                    <div class="features-content">
                        <h4 class="features-title">Analizza i risultati</h4>
                        <p class="text">
                            Analizza facilmente le statistiche sui risultati dei tuoi sondaggi
                        </p>
                    </div>
                </div>
                <!-- single features -->
            </div>
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<lottie-player src="../img/borderWoobler.json" background="transparent"  speed="1" autoplay loop class="section-bottom-border" style="z-index: 0"></lottie-player>
<!--====== FEATURE ONE PART ENDS ======-->
<!--====== CLIENT LOGO PART START ======-->
<div class="container-fluid" style="display: flex; align-items: center; justify-content: center">
    <section class="client-logo-area client-logo-one" style="background: white; z-index: 1; position: relative; width: 80vw; border-radius: 8px">
        <!--======  Start Section Title Two ======-->
        <div class="section-title-two">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="content">
                            <h2 class="fw-bold" id="project">Il progetto...</h2>
                            <p>
                                Questo progetto è stato iniziato grazie al corso di Basi di dati tenuto presso l'università di Bologna
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- container -->
        </div>
        <!--====== End Section Title Two ======-->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-3 col-6">
                    <div class="single-client text-center">
                        <img src="../img/Seal_of_the_University_of_Bologna.png" alt="Logo" style="width: 150px; margin: -50px 0px 0px 0px"/>
                    </div>
                    <!-- single client -->
                </div>
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </section>
</div>
<!--====== CLIENT LOGO PART ENDS ======-->
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<!--====== Bootstrap js ======-->
<script src="https://cdn.ayroui.com/1.0/js/bootstrap.bundle.min.js"></script>

<script>
    //===== close navbar-collapse when a  clicked
    let navbarTogglerOne = document.querySelector(
        ".navbar-one .navbar-toggler"
    );
    navbarTogglerOne.addEventListener("click", function () {
        navbarTogglerOne.classList.toggle("active");
    });
</script>
</body>
</html>
