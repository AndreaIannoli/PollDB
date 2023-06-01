<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aggiungi premio</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/basicstyle.css" rel="stylesheet">
    <link href="../stylesheets/aggiungiPremio.css" rel="stylesheet">
    <link href="../stylesheets/nav.css" rel="stylesheet">
    <link href="../stylesheets/button.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</head>
<body>

<?php
require 'connectionManager.php';
require 'accountManager.php';
require 'NotificationManager.php';
require 'LogsManager.php';
require "upload.php";

$pdo = connectToDB();
session_start();
requiredLogin();
requiredAdmin();
navBarCheck($pdo);
$userType = $_SESSION['userType'];
$emailUtente = $_SESSION['emailLogged'];

if(isset($_POST["buttonAggiungi"])){
    try {
        $sql = 'CALL AddPremio(?, ?, ?, ?, ?)';
        $res = $pdo->prepare($sql);

        $res->bindValue(1, $_POST["nome"], PDO::PARAM_STR);
        $res->bindValue(2, $_POST["descrizione"], PDO::PARAM_STR);
        $res->bindValue(3, uploadPrizePic(), PDO::PARAM_STR);
        $res->bindValue(4, $_POST["puntiMin"], PDO::PARAM_STR);
        $res->bindValue(5, $emailUtente, PDO::PARAM_STR);

        $res -> execute();
        $res->closeCursor();
        insertLog("AddPremio", "Executed");
    } catch (PDOException $e){
        echo 'exception: '.$e;
        insertLog("AddPremio", "Aborted");
    }
}



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
                                        href="javascript:void(0)"
                                >
                                    Home
                                    <div class="sub-nav-toggler">
                                        <span><i class="lni lni-chevron-down"></i></span>
                                    </div>
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

                    <div class="d-sm-flex flex-row">
                        <!-- Notification menu -->
                        <ul class="d-flex flex-row justify-content-center align-items-center gap-4 list-unstyled" style="margin-bottom: 0px; padding-left: 0px;">
                            <li class="d-flex align-items-center justify-content-center gap-2" style="display:flex; align-items: center; justify-content: center">
                                <div class="dropdown d-flex align-items-center justify-content-center gap-2">
                                    <?php
                                    echo("<p id='navbar-name'>Ciao, ".$_SESSION['nameLogged']."!</p>");
                                    ?>
                                    <button class="profile-container" style="background-color: transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php
                                        echo('
                                                 <img src="'.$_SESSION['userProPicURI'].'" alt="Profile Picture" class="profile-picture">
                                         ');
                                        ?>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="dropdown-item"><a href="AdminDashboard.php" style="color: black; font-weight: bold; text-decoration: none;">Dashboard</a></li>
                                        <hr>
                                        <li class="dropdown-item"><a href="home.php" style="color: black; font-weight: bold">Logout</a></li>
                                    </ul>
                                </div>
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
<div class="container-sm p-5 mt-3" id="premio-container">

    <h3>Aggiungi un nuovo premio</h3>

    <form class="row g-3 needs-validation" id="login-form" method="post" enctype="multipart/form-data">
        <div class="col-12">
        </div>
        <div class="col-12">
            <label class="form-label">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Nome premio" required>
        </div>
        <div class="col-12">
            <label class="form-label">descrizione</label>
            <textarea class="form-control" id="descrizione" name="descrizione" rows="3"></textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Punti</label>
            <input type="number" class="form-range" max="100" min="1" id="customRange2" name="puntiMin" width="50" style="width: 100px" required>
        </div>
        <div class="col-12">
            <label for="prizePicUpload" class="form-label">Immagine del premio</label>
            <input class="form-control" type="file" id="prizePicUpload" name="prizePicUpload" accept=".jpg,.gif,.png">
        </div>
        <div id="premio-btn-container">
            <button class="btn primary-btn" type="submit" name="buttonAggiungi">Aggiungi</button>
        </div>
    </form>
</div>
</body>
</html>
