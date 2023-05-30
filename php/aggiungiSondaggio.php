<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>creazione sondaggio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/aggiungiSondaggio.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>

<body>

<?php

require "accountManager.php";
require "connectionManager.php";
require 'NotificationManager.php';
require 'LogsManager.php';
$pdo = connectToDB();
session_start();
$emailUtente = $_SESSION['emailLogged'];
$type = $_SESSION['type'];

echo(print_r($_SESSION));


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

$statoSondaggio = $_POST["statoSondaggioRadio"];


$dominiSelezionati = array();



if(isset($_POST["statoSondaggioRadio"])){
    $statoSondaggio = $_POST["statoSondaggioRadio"];
}else {
    $statoSondaggio = $_POST["statoSondaggioRadio2"];
}



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
                    <a class="navbar-brand" href="javascript:void(0)">
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
                                    <div class="sub-nav-toggler">
                                        <span><i class="lni lni-chevron-down"></i></span>
                                    </div>
                                </a>
                                <ul class="sub-menu collapse" id="sub-nav1">
                                    <li><a href="javascript:void(0)">Il progetto</a></li>
                                    <li><a href="javascript:void(0)">Il nostro team</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0)">GitHub</a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0)">Contatti</a>
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

        <div class="col" id="navLeft">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Dashboard</button>
                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profilo</button>
                <button class="nav-link" id="v-pills-permi-tab" data-bs-toggle="pill" data-bs-target="#v-pills-disabled" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false">Premi</button>
                <button class="nav-link" id="v-pills-inviti-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Inviti</button>
                <button class="nav-link" id="v-pills-indietro-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Indietro</button>
            </div>
        </div>

        <div class="col">

        </div>

        <div class="col" id="addPoll-container" style="max-width: 1000px">

            <form method="post" class="row g-3 needs-validation" id="addPoll-form" >

                <div class="col-12">
                    <label class="form-label">Aggiungi un sondaggio</label>
                </div>

                <div class="col-12">
                    <input type="text" name="nomeSondaggio" class="form-control" id="inputNomeSondaggio" placeholder="Name" value="<?php

                    if(isset($_POST["nomeSondaggio"])){
                        echo($nomeSondaggio);
                    }


                    ?>" required>

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
                        <button class="btn btn-lg btn-primary login-btn col-sm-2" type="submit">
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
                                //echo sizeof($domainNames);

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

                                    //echo 'ciclo'.$x.'';
                                    $domainName = $domainNames[$x];


                                    if(isset($_POST[$domainName]) and $_POST[$domainName] == 'notInterested'){



                                        array_push($_SESSION["dominiSelezionati"], $domainName);



                                    } else if(isset($_POST[$domainName]) and $_POST[$domainName] == 'interested'){
                                        //echo '      remove-------------------';

                                        //unset($_SESSION["dominiSelezionati"]);


                                        $domainKey = array_search($domainName, $_SESSION["dominiSelezionati"]);


                                        unset($_SESSION["dominiSelezionati"][$domainKey]);

                                    }

                                    $_POST[$domainName] = null;
                                    //echo in_array($domainName, $_SESSION["dominiSelezionati"])? ' EXIST' : ' NOT EXIST';
                                    if(in_array($domainName, $_SESSION["dominiSelezionati"]) == 'EXIST') {
                                        //echo('pulsante interested'.$x);
                                        echo("                                
                                                <button class='btn btn-primary login-btn d-grid wrap-content col-sm-3 btn-square-md' value='interested' type='submit' name='" . $domainName . "'><i class='bi bi-heart-fill'></i>" . $domainName . " </button>                            
                                             ");
                                    } else {
                                        //echo('pulsante NOT interested'.$x);
                                        echo("                                
                                                <button class='btn btn-primary login-btn d-grid wrap-content col-sm-3 btn-square-md' value='notInterested' type='submit' name='" . $domainName . "'><i class='bi bi-heart'></i>" . $domainName . " </button>                            
                                            ");
                                    }
                                    //echo 'fine ciclo'.$x;
                                    //print_r($domainNames);
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
                    <label for="customRange2" class="form-label">numero massimo di partecipanti</label>
                    <input type="number" class="form-range" max="100" min="1" id="customRange2" name="numeroMaxPartecipanti" value="<?php

                    if(isset($_POST["numeroMaxPartecipanti"])){
                        echo($_POST["numeroMaxPartecipanti"]);
                    }
                    ?>" width="50" required>

                </div>


                <div id="col-12">
                    <label for="start">Start date:</label>

                    <input type="date" id="chiusuraSondaggioData" name="chiusuraSondaggioData" min="<?php echo date('Y-m-d'); ?>" value="<?echo($dataChiusura)?>" required>
                </div>


                <div id="col-12">
                    Stato del sondaggio:

                    <div class="form-check">
                        <?php
                        echo($_POST['statoSondaggioRadio']);

                        if(!isset($_POST['statoSondaggioRadio']) or $_POST['statoSondaggioRadio'] == 'APERTO'){
                            echo('<input class="form-check-input" type="radio" name="statoSondaggioRadio" id="flexRadioDefault" value="" checked>');
                        } else {
                            echo('<input class="form-check-input" type="radio" name="statoSondaggioRadio" id="flexRadioDefault" value="APERTO">');
                        }
                        ?>

                        <label class="form-check-label" for="flexRadioDefault1">
                            Aperto
                        </label>
                    </div>
                    <div class="form-check">
                        <?php

                        if(isset($_POST['statoSondaggioRadio']) and $_POST['statoSondaggioRadio'] == 'CHIUSO'){
                            echo('<input class="form-check-input" type="radio" name="statoSondaggioRadio" id="flexRadioDefault2" value="" checked>');
                        } else {
                            echo('<input class="form-check-input" type="radio" name="statoSondaggioRadio" id="flexRadioDefault2" value="CHIUSO">');
                        }

                        ?>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Chiuso
                        </label>
                    </div>
                </div>


                <div id="login-btn-container">

                    <button class="btn btn-primary" type="submit" name="buttonAggiungi">Aggiungi</button>

                    <?php

                    $flag = false;
                    if (isset($_POST["buttonAggiungi"])) {

                        try {
                            // execute the stored procedure
                            $sql = "CALL addSondaggio('$nomeSondaggio', '$numMaxUtenti', '$dataChiusura', '$statoSondaggio', '$emailUtente')";
                            // call the stored procedure

                            echo( "data chiusura: ".$dataChiusura);

                            echo("stato: ".$statoSondaggio);

                            $res = $pdo -> prepare($sql);

                            $res -> execute();

                            $res->closeCursor();
                            insertLog("AddSondaggio", "Executed");
                        } catch (PDOException $e) {
                            echo("Error occurred:" . $e->getMessage());
                            insertLog("AddSondaggio", "Aborted");
                            exit();
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


                        for($i = 0; $i < sizeof($arrayNuovo); $i++){
                            try{
                                $sql = 'CALL AddAppartenenza(?, ?)';
                                $res = $pdo->prepare($sql);

                                $res->bindValue(1, $riga[0], PDO::PARAM_STR);
                                $res->bindValue(2, $arrayNuovo[$i], PDO::PARAM_STR);

                                $res->execute();

                                $res->closeCursor();
                                insertLog("AddAppartenenza", "Executed");
                            }catch(PDOException $e) {
                                echo 'exception: ' . $e;
                                insertLog("AddAppartenenza", "Aborted");
                            }
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