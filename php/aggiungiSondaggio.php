<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>creazione sondaggio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="../stylesheets/basicstyle.css" rel="stylesheet">
    <link href="../stylesheets/nav.css" rel="stylesheet">
    <link href="../stylesheets/button.css" rel="stylesheet">
    <link href="../stylesheets/aggiungiSondaggio.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</head>

<body>

<?php
require "accountManager.php";
require "connectionManager.php";
require "NotificationManager.php";
require "LogsManager.php";
$pdo = connectToDB();
session_start();
requiredLogin();
requiredCreator();
navBarCheck($pdo);

$emailUtente = $_SESSION['emailLogged'];
$type = $_SESSION['type'];

if(!isset($_SESSION["arrayDomini"])){
    $_SESSION["arrayDomini"] = array();
}

if(!isset($_SESSION['dominiSelezionati'])){
    $_SESSION["dominiSelezionati"] = array();
}

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
    exit();
}
?>

<?php

$nomeSondaggio = $_POST["nomeSondaggio"];
$numMaxUtenti = $_POST["numeroMaxPartecipanti"];
$dataChiusura = $_POST["chiusuraSondaggioData"];
$statoSondaggio = "APERTO";
$dominiSelezionati = array();
$dataCreazione = $_POST[date("y-m-d")];

if(isset($_POST["chiusuraSondaggioData"])){
    $dataChiusura = $_POST["chiusuraSondaggioData"];
}

if(isset($_POST['buttonAggiungi'])) {

    $dominioSondaggio = $_POST['selectDominio'];
    $email = $_SESSION["emailCreatore"];
}

function getDominiSelezionati(){

    $domini = $_SESSION["arrayDomini"];
    return $domini;
}
?>

<!--====== ------------------------------------------------------------- ======-->

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
                            <li>
                                <div class="dropdown">
                                    <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="notificationButton">
                                        <i class="bi bi-bell-fill"></i>
                                    </button>
                                    <?php
                                    $res = getUserNotifications($_SESSION['emailLogged'], $pdo);
                                    $nOfNotifications = $res->rowCount();
                                    if($nOfNotifications != 0){
                                        echo('
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    '.$nOfNotifications.'
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            ');
                                    }
                                    ?>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <?php
                                        $notifications = $res->fetchAll();
                                        $res->closeCursor();
                                        if($nOfNotifications == 0){
                                            echo("Non ci sono notifiche");
                                        }
                                        for($x=0; $x < $nOfNotifications; $x++){
                                            $row = $notifications[$x];
                                            $typeRes = getNotificationType($row['Codice'], $pdo)->fetch();
                                            $type = $typeRes[0];
                                            if($type == 'Invito'){
                                                $poll = getInvitePoll($row['Codice'], $pdo)->fetch();
                                                $pollCreator = getPollCreator($poll['Codice'], $pdo)->fetch();
                                                if(array_key_exists('EmailCreatorePremium', $pollCreator)) {
                                                    $userSender = getUser($pollCreator['EmailCreatorePremium'], $pdo)->fetch();
                                                    $sender = $userSender['Nome'].' '.$userSender['Cognome'];
                                                    $senderProPic = $userSender['UrlFoto'];
                                                } else if(array_key_exists('CodiceAzienda', $pollCreator)){
                                                    $userSender = getAzienda($pollCreator['CodiceAzienda'], $pdo)->fetch();
                                                    $sender = $userSender['Nome'];
                                                    $senderProPic = $userSender['UrlFoto'];
                                                }
                                                echo(
                                                    '<li class="dropdown-item-text" style="width: max-content;">
                                                        <form class="d-flex align-items-center justify-content-end fw-bold mb-0 mt-0" method="post">
                                                            <button class="btn secondary-btn" name="toArchive" value="'.$row['Codice'].'" type="submit">
                                                            x
                                                            </button>
                                                        </form>
                                                        <div class="d-flex align-items-center justify-content-center fw-bold">Invito da '.$sender.'</div>
                                                        <div class="d-inline-flex gap-3 align-items-center justify-content-center" style="width: 350px">
                                                            <div>
                                                                <div class="profile-container">
                                                                    <img src="'.$senderProPic.'" alt="Profile Picture" class="profile-picture">
                                                                </div>
                                                            </div>
                                                            <div class="vr" style="width: 2px">
                                                            </div>
                                                            <div class="text-wrap">
                                                                '.$sender.' ti ha invitato a partecipare al sondaggio '.$poll['Titolo'].'
                                                                <form class="d-flex align-items-center justify-content-center gap-2 mt-1" method="post">
                                                                    <button class="btn primary-btn-outline" name="AcceptInvite" value="'.$row['Codice'].'" type="submit">
                                                                        Accetta
                                                                    </button>
                                                                    <button class="btn primary-btn" name="DenyInvite" value="'.$row['Codice'].'" type="submit">
                                                                        Rifiuta
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>'
                                                );
                                            } else {
                                                $prize = getNotificationPrize($row['Codice'], $pdo)->fetch();
                                                echo(
                                                    '<li class="dropdown-item-text" style="width: max-content;">
                                                        <form class="d-flex align-items-center justify-content-end fw-bold mb-0 mt-0" method="post">
                                                            <button class="btn secondary-btn" name="toArchive" value="'.$row['Codice'].'" type="submit">
                                                            x
                                                            </button>
                                                        </form>
                                                        <div class="d-flex align-items-center justify-content-center fw-bold">Hai vinto '.$prize['Nome'].'</div>
                                                        <div class="d-inline-flex gap-3 align-items-center justify-content-center" style="width: 350px">
                                                            <div>
                                                                <div class="profile-container">
                                                                    <img src="'.$prize['Foto'].'" alt="Profile Picture" class="profile-picture">
                                                                </div>
                                                            </div>
                                                            <div class="vr" style="width: 2px">
                                                            </div>
                                                            <div class="text-wrap">
                                                                '.'Hai vinto il premio '.$prize['Nome'].'! Complimenti per aver raggiunto più di '.$prize['PuntiMin'].' punti!'.'
                                                                <form class="d-flex align-items-center justify-content-center gap-2 mt-1" method="post">
                                                                    <button class="btn primary-btn-outline" name="toArchive" value="'.$row['Codice'].'" type="submit">
                                                                        OK
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>'
                                                );
                                            }
                                        }

                                        ?>
                                    </ul>
                                </div>
                            </li>
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
                                        <li class="dropdown-item"><a href="visualizza_sondaggi.php" style="color: black; font-weight: bold; text-decoration: none;">Dashboard</a></li>
                                        <li class="dropdown-item"><a href="statistics.php" style="color: black; font-weight: bold; text-decoration: none;">Statistiche</a></li>
                                        <li class="dropdown-item"><a href="rank.php" style="color: black; font-weight: bold; text-decoration: none;">Classifica</a></li>
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

<!--====== ------------------------------------------------------------- ======-->

<div class="container text-center">

    <div class="row align-items-center" id="rowAlignCenter">
        <div class="col" id=""></div>
        <div class="col"></div>
        <div class="col p-5 mt-3" id="addPoll-container" style="max-width: 1000px">

            <form method="post" class="row g-3 needs-validation" id="addPoll-form" >

                <div class="col-12">
                    <label class="form-label">Aggiungi un sondaggio</label>
                </div>

                <div class="col-12">
                    <input type="text" name="nomeSondaggio" class="form-control" id="inputNomeSondaggio" placeholder="Name" value="<?php

                    if(isset($_POST["nomeSondaggio"])){
                        echo($nomeSondaggio);
                    }
                    ?>" >

                </div>

                <div class="col-12">
                    <div class="row align-items-center justify-content-center gap-1">

                        <div class="col-sm-9 p-0 form-floating">

                            <?php
                            if(isset($_POST['searchField'])){
                                echo("<input type='text' class='form-control' id='searchField' name='searchField' value='".$_POST['searchField']."' placeholder='Nome del dominio di interesse'>");
                            } else {
                                echo("<input type='text' class='form-control' id='searchField' name='searchField' placeholder='Nome del dominio di interesse'>");
                            }
                            ?>
                            <label for="searchField">Nome del dominio di interesse</label>
                        </div>

                        <!--<form method="post">-->
                        <button class="btn btn-lg primary-btn login-btn col-sm-2" type="submit">
                            <i class="bi bi-search-heart" style="font-size: 150%"></i>
                        </button>
                        <!--</form>-->

                        <div  class="col-12 container-fluid mt-4">

                            <div class="row justify-content-center gap-1" style="max-height: 250px; overflow-y: scroll;" method="post">

                                <?php
                                try {
                                    $sql = 'CALL SearchDominio(?)';
                                    $res = $pdo->prepare($sql);
                                    if(isset($_POST['searchField'])) {
                                        $res->bindValue(1, $_POST['searchField'], PDO::PARAM_STR);
                                    } else {
                                        $res->bindValue(1, '', PDO::PARAM_STR);
                                    }
                                    $res->execute();
                                } catch (PDOException $e){
                                    echo 'exception: '.$e;
                                }

                                $domainNames = [];
                                for($x=0; $x < $res -> rowCount(); $x++){
                                    $row = $res->fetch();
                                    array_push($domainNames, $row[0]);
                                }

                                $res->closeCursor();

                                if(sizeof($domainNames) == 0){
                                    echo('Nessun dominio di interesse trovato');
                                }

                                $interests = array();
                                $interests = getDominiSelezionati();
                                $interestsArguments = [];

                                for($x=0; $x < sizeof($interests); $x++){

                                    $interestRow = $interests->fetch();
                                    array_push($interestsArguments, $interestRow[0]);
                                }

                                for($x=0; $x < sizeof($domainNames); $x++){
                                    $domainName = $domainNames[$x];

                                    if(isset($_POST[$domainName]) and $_POST[$domainName] == 'notInterested'){
                                        array_push($_SESSION["dominiSelezionati"], $domainName);

                                    } else if(isset($_POST[$domainName]) and $_POST[$domainName] == 'interested'){

                                        $domainKey = array_search($domainName, $_SESSION["dominiSelezionati"]);
                                        unset($_SESSION["dominiSelezionati"][$domainKey]);
                                    }

                                    $_POST[$domainName] = null;
                                    if(in_array($domainName, $_SESSION["dominiSelezionati"]) == 'EXIST') {
                                        echo("                                
                                                <button class='btn primary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md' value='interested' type='submit' name='" . $domainName . "'><i class='bi bi-heart-fill'></i>" . $domainName . " </button>                            
                                             ");
                                    } else {
                                        echo("                                
                                                <button class='btn primary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md' value='notInterested' type='submit' name='" . $domainName . "'><i class='bi bi-heart'></i>" . $domainName . " </button>                            
                                            ");
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12"></div>
                </div>

                <div id="col-12">

                    <label for="customRange" class="form-label">Numero partecipanti: </label>
                    <input type="number" class = "form-range" style="width: 150px" max="100" min="1" id="customRange" name="numeroMaxPartecipanti" value="<?php

                    if(isset($_POST["numeroMaxPartecipanti"])){
                        echo($_POST["numeroMaxPartecipanti"]);
                    }
                    ?>">
                </div>

                <div id="col-12">
                    <label for="start">Chiusura sondaggio:</label>

                    <input type="date" id="chiusuraSondaggioData"  name="chiusuraSondaggioData"
                           min="<?php echo date('Y-m-d'); ?>" value="<?php echo($dataChiusura)?>" >
                </div>
                <div id="login-btn-container">
                    <button class="btn primary-btn" type="submit" name="buttonAggiungi">Aggiungi</button>
                    <?php
                    $flag = false;
                    if (isset($_POST["buttonAggiungi"])) {
                        //echo(empty($_SESSION["dominiSelezionati"]));
                        if($dataChiusura != "" && $numMaxUtenti != "" && $nomeSondaggio != "" && empty($_SESSION["dominiSelezionati"]) != 1){

                            try {
                                // execute the stored procedure
                                $sql = "CALL addSondaggio('$nomeSondaggio', '$numMaxUtenti', '$dataChiusura', '$statoSondaggio', '$emailUtente')";
                                // call the stored procedure
                                $res = $pdo -> prepare($sql);
                                $res -> execute();
                                $res->closeCursor();
                                insertLog("addSondaggio", "Executed");
                            } catch (PDOException $e) {
                                insertLog("addSondaggio", "Aborted");
                                die("Error occurred:" . $e->getMessage());
                            }

                            try {
                                $sql = 'CALL SearchCodiceSondaggio(?)';
                                $res = $pdo->prepare($sql);

                                $res->bindValue(1, $nomeSondaggio, PDO::PARAM_STR);

                                $res->execute();

                            } catch (PDOException $e) {
                                echo 'exception: ' . $e;
                            }

                            $riga = $res->fetch();

                            $arrayNuovo = array();
                            $i = 0;

                            while (!empty($_SESSION["dominiSelezionati"])) {
                                $elemento = array_shift($_SESSION["dominiSelezionati"]);
                                $arrayNuovo[$i] = $elemento;

                                $i++;
                            }

                            $res->closeCursor();

                            for($i = 0; $i < sizeof($arrayNuovo); $i++) {
                                try {
                                    $sql = 'CALL AddAppartenenza(?, ?)';
                                    $res = $pdo->prepare($sql);

                                    $res->bindValue(1, $riga[0], PDO::PARAM_STR);
                                    $res->bindValue(2, $arrayNuovo[$i], PDO::PARAM_STR);

                                    $res->execute();

                                    $res->closeCursor();
                                    insertLog("AddAppartenenza", "Executed");
                                } catch (PDOException $e) {
                                    insertLog("AddAppartenenza", "Aborted");
                                    echo 'exception: ' . $e;
                                }
                            }

                        }else{
                            echo("seleziona ttutti i campi");
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
        <div class="col">
        </div>
        <div class="col">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!--====== ------------------------------------------------------------- ======-->

    <script>
        //===== close navbar-collapse when a  clicked
        let navbarTogglerOne = document.querySelector(
            ".navbar-one .navbar-toggler"
        );
        navbarTogglerOne.addEventListener("click", function () {
            navbarTogglerOne.classList.toggle("active");
        });
    </script>

    <!--====== ------------------------------------------------------------- ======-->
</body>
</html>