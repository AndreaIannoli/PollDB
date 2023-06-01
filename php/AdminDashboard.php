<!DOCTYPE html>
<html lang="it" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PollDB - Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/basicstyle.css" rel="stylesheet">
    <link href="../stylesheets/nav.css" rel="stylesheet">
    <link href="../stylesheets/button.css" rel="stylesheet">
    <link href="../stylesheets/AdminDashboard.css" rel="stylesheet">
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

    session_start();
    requiredLogin();
    requiredAdmin();
    if(isset($_POST['searchField'])){
        $_SESSION['search'] = $_POST['searchField'];
    }

    $pdo = connectToDB();
    navBarCheck($pdo);
    if(!isset($_SESSION['authorized']) or $_SESSION['authorized'] == 0){
        session_unset();
        header('Location: login.php');
    }
    if($_SESSION['userType'] != 'Amministratore'){
        header('Location: visualizza_sondaggi.php');
    }

    function getInteressamento($email, PDO $pdo){
        try {
            $sql = 'CALL GetUserInteressamento(?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $email, PDO::PARAM_STR);
            $res->execute();
        } catch (PDOException $e){
            echo 'exception'.$e;
        }

        return $res;
    }

    if(isset($_POST['AcceptInvite'])){
        acceptInvite($_POST['AcceptInvite'], $pdo);
    } else if(isset($_POST['DenyInvite'])) {
        denyInvite($_POST['DenyInvite'], $pdo);
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
<div class="container-xl" id="adminDashboard-container">
    <div class="container-fluid row justify-content-center">
        <img src="../img/logoPollDBBlack.png" class="img-sm col-3" alt="...">
    </div>
    <form class="row g-6 needs-validation" id="login-form" method="post">
        <div class="col-4">
            <div class="card">
                <h5 class="card-header" style="font-size: 50px"><i class='bi bi-heart-fill'></i><br>Gestione Domini</h5>
                <div class="card-body">
                    <p class="card-text">Gestisci i domini d'interesse, eliminali e creane di nuovi!</p>
                    <a href="DomainDashboard.php" class="btn primary-btn">Vai alla gestione domini</a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <h5 class="card-header" style="font-size: 50px"><i class="bi bi-trophy-fill"></i><br>Gestione premi</h5>
                <div class="card-body">
                    <p class="card-text">Aggiungi nuovi premi per i tuoi utenti!</p>
                    <a href="aggiungiPremio.php" class="btn primary-btn">Aggiungi premio</a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <h5 class="card-header" style="font-size: 50px"><i class="bi bi-patch-plus-fill"></i><br>Gestione abbonamenti</h5>
                <div class="card-body">
                    <p class="card-text">Gestisci gli abbonamenti degli utenti premium</p>
                    <a href="SubscriptionsDashboard.php" class="btn primary-btn">Vai alla gestione abbonamenti</a>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>

