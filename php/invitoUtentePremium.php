<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserisci Domanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../stylesheets/style.css">
    <link href="../stylesheets/invitoUtentePremium.css" rel="stylesheet">

</head>
<body>

<?php

$host = "localhost";
$dbName = "PollDB";
$username = "root";
$pass = "root";
session_start();

//$_SESSION['emailCreatore'] = 'nome.esempio@email.com';



if(!isset($_SESSION["arrayDomini"])){

    $_SESSION["arrayDomini"] = array();

}

if(!isset($_SESSION['utentiSelezionati'])){

    $_SESSION["utentiSelezionati"] = array();

}

try {
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbName, $username, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
    exit();
}
?>

<?php

$email = $_GET['emailUtente'];
$CodiceSondaggio = $_GET['CodiceSondaggio'];
$TitoloSondaggio = $_GET['titoloSondaggio'];
$MaxUtenti = $_GET["MaxUtenti"];


try {
    $sql = 'CALL daNonInvitare(?)';
    $res = $pdo->prepare($sql);


    $res->bindValue(1, $CodiceSondaggio, PDO::PARAM_STR);

    //echo("codice sondaggio: ".$CodiceSondaggio);

    $res->execute();
} catch (PDOException $e){
    echo 'exception: '.$e;
}

$row = $res -> fetch();
$nonInvitare = $row["Result"];
$MaxUtenti = $MaxUtenti - $nonInvitare;
$res->closeCursor();

$dominiSelezionati = array();

if(isset($_POST["statoSondaggioRadio"])){
    $statoSondaggio = $_POST["statoSondaggioRadio"];
}else {
    $statoSondaggio = $_POST["statoSondaggioRadio2"];
}

$dataCreazione = $_POST[date("y-m-d")];

//salva i dati nel database
if(isset($_POST['buttonAggiungi'])) {

    $dominioSondaggio = $_POST['selectDominio'];
    //$email = $_SESSION["emailCreatore"];
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


        <div class="col">

        </div>

        <div class="col">

        </div>

        <div class="col-12" id="addPoll-container" style="max-width: 1000px">



            <form method="post" class="row g-3 needs-validation" id="addPoll-form" >




                <div class="col">
                    <div class="row align-items-center justify-content-center gap-1">



                        <label >Invita utenti per il sondaggio: <?php echo($TitoloSondaggio); ?></label>

                        <!--<div class="col-sm-9 p-0 form-floating">

                                        <?php
                        //echo($CodiceSondaggio);

                        /*
                                if(isset($_POST['searchField'])){
                                    echo("<input type='text' class='form-control' id='searchField' name='searchField' value='".$_POST['searchField']."' placeholder='Nome del dominio di interesse'>");
                                } else {
                                    echo("<input type='text' class='form-control' id='searchField' name='searchField' placeholder='Nome del dominio di interesse'>");
                                }
                        */
                        ?>
                                        <label for="searchField">Nome del dominio di interesse</label>
                                    </div>-->



                        <div  class="col container-fluid mt-4">

                            <div class="row justify-content-center gap-1" style="max-height: 250px; overflow-y: scroll;" method="post">

                                <?php
                                $flag = false;




                                try {
                                    $sql = 'CALL returnUtenti(?)';
                                    $res = $pdo->prepare($sql);


                                    $res->bindValue(1, $CodiceSondaggio, PDO::PARAM_STR);

                                    //echo("codice sondaggio: ".$CodiceSondaggio);

                                    $res->execute();
                                } catch (PDOException $e){
                                    echo 'exception: '.$e;
                                }

                                //unset($_SESSION["utentiSelezionati"]);

                                $utenti = [];
                                for($x=0; $x < $res -> rowCount(); $x++){

                                    $row = $res->fetch();

                                    if($row[0] != $email){
                                        array_push($utenti, $row[0]);

                                    }
                                }

                                $res->closeCursor();
                                //echo sizeof($utenti);

                                if(sizeof($utenti) == 0){
                                    echo('Nessun utente trovato');
                                }


                                for($x=0; $x < sizeof($utenti); $x++){

                                    //echo 'ciclo'.$x.'';
                                    $utente = $utenti[$x];


                                    if(isset($_POST[$x]) and $_POST[$x] == 'notInterested'
                                        and sizeof($_SESSION["utentiSelezionati"]) < $MaxUtenti){

                                        //echo("sono dentro");

                                        array_push($_SESSION["utentiSelezionati"], $utente);

                                        //print_r($_SESSION["utentiSelezionati"]);

                                    }else if(isset($_POST[$x]) and $_POST[$x] == 'interested'){
                                        //echo '      remove-------------------';

                                        //unset($_SESSION["utentiSelezionati"]);


                                        $userKey = array_search($utente, $_SESSION["utentiSelezionati"]);


                                        unset($_SESSION["utentiSelezionati"][$userKey]);

                                    }else if(sizeof($_SESSION["utentiSelezionati"]) == $MaxUtenti){
                                        //echo("hai raggiunto il numero massimo di utenti selezionabili");
                                        $flag = true;
                                        //print_r($_SESSION["utentiSelezionati"]);
                                    }else{
                                        $flag = false;
                                    }


                                    //echo isset($_POST[$utente])? ' EXIST' : ' NOT EXIST';

                                    $_POST[$x] = null;
                                    //echo in_array($utente, $_SESSION["utentiSelezionati"])? ' EXIST' : ' NOT EXIST';
                                    if(in_array($utente, $_SESSION["utentiSelezionati"]) == 'EXIST') {
                                        //echo('pulsante interested'.$x);
                                        echo("                                
                                                        <button class='btn btn-secondary d-grid wrap-content col-sm-3 btn-square-md' value='interested' type='submit' name='" . $x . "'>" . $utente . "</button>                            
                                                     ");
                                    } else {
                                        //echo('pulsante NOT interested'.$x);
                                        echo("                                
                                                        <button class='btn btn-primary login-btn d-grid wrap-content col-sm-3 btn-square-md' value='notInterested' type='submit' name='" . $x . "'>" . $utente . "</button>                            
                                                    ");
                                    }
                                    //echo 'fine ciclo'.$x;
                                    //print_r($utenti);
                                }

                                echo('<div>');
                                if($flag == true){
                                    echo ("hai raggiunto il numero massimo di utenti");
                                }

                                echo('</div>');

                                ?>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">

                    <div class="col-12">

                    </div>
                </div>



                <div id="login-btn-container">

                    <button class="btn btn-primary" type="submit" name="buttonAggiungi">Aggiungi</button>



                    <?php

                    $flag = false;


                    if (isset($_POST["buttonAggiungi"])) {
                        $arrayNuovo = array();
                        $i = 0;

                        while (!empty($_SESSION["utentiSelezionati"])) {

                            $elemento = array_shift($_SESSION["utentiSelezionati"]);
                            $arrayNuovo[$i] = $elemento;

                            $i++;
                        }

                        $_SESSION["utentiSelezionati"] = $arrayNuovo;

                        try {

                            for($x=0; $x < sizeof($_SESSION["utentiSelezionati"]); $x++) {

                                $emailUtente = $_SESSION["utentiSelezionati"][$x];

                                echo($emailUtente."  ");


                                // execute the stored procedure
                                $sql = "CALL creaInvito(?, ?)";
                                // call the stored procedure

                                $res = $pdo -> prepare($sql);

                                $res->bindValue(1, $CodiceSondaggio, PDO::PARAM_STR);
                                $res->bindValue(2, $emailUtente, PDO::PARAM_STR);

                                $res -> execute();

                                $res->closeCursor();

                            }



                        } catch (PDOException $e) {
                            die("Error occurred:" . $e->getMessage());
                        }

                        /*
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

                        while (!empty($_SESSION["utentiSelezionati"])) {

                            $elemento = array_shift($_SESSION["utentiSelezionati"]);
                            $arrayNuovo[$i] = $elemento;

                            $i++;

                        }

                        $res->closeCursor();


                        for($i = 0; $i < sizeof($arrayNuovo); $i++){

                            try{

                                $sql = 'CALL AggiungiAppartenenza(?, ?)';
                                $res = $pdo->prepare($sql);

                                $res->bindValue(1, $riga[0], PDO::PARAM_STR);
                                $res->bindValue(2, $arrayNuovo[$i], PDO::PARAM_STR);



                                $res->execute();

                                $res->closeCursor();


                            }catch(PDOException $e) {
                                echo 'exception: ' . $e;
                            }
                        }

                        */

                        unset($_SESSION["utentiSelezionati"]);

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