<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PollDB - Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/basicstyle.css" rel="stylesheet">
    <link href="../stylesheets/nav.css" rel="stylesheet">
    <link href="../stylesheets/button.css" rel="stylesheet">
    <link href="../stylesheets/registrationChoice.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
<?php
    require "connectionManager.php";
    require "accountManager.php";
    session_start();
    $pdo = connectToDB();
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
                                        class="page-scroll"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#sub-nav1"
                                        aria-controls="sub-nav1"
                                        aria-expanded="false"
                                        aria-label="Toggle navigation"
                                        href="/php/home.php"
                                >
                                    Home
                                </a>
                                <ul class="sub-menu collapse" id="sub-nav1">
                                    <li><a href="/php/home.php#project">Il progetto</a></li>
                                    <li><a href="/php/home.php#team">Il nostro team</a></li>
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
<div class="container-md col-md-8 d-flex justify-content-center" id="registrationChoice-container">
    <form class="row g-6 needs-validation" id="login-form" method="post">
        <div class="col-6">
            <div class="card">
                <h5 class="card-header" style="font-size: 50px"><i class="bi bi-person-fill"></i><br>Utente</h5>
                <div class="card-body">
                    <p class="card-text">Registrati come utente per rispondere ai sondaggi. Diventa premium e divertiti a crearli!</p>
                    <a href="registrationUser.php" class="btn primary-btn">Registrati come utente</a>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <h5 class="card-header" style="font-size: 50px"><i class="bi bi-buildings-fill"></i><br>Azienda</h5>
                <div class="card-body">
                    <p class="card-text">Registrati come azienda per creare sondaggi e invitare i tuoi clienti a compilarli.</p>
                    <a href="registrationEnterprise.php" class="btn primary-btn">Registrati come azienda</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>
</html>