<!DOCTYPE html>
<html lang="it" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PollDB - Registration</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/basicstyle.css" rel="stylesheet">
    <link href="../stylesheets/nav.css" rel="stylesheet">
    <link href="../stylesheets/button.css" rel="stylesheet">
    <link href="../stylesheets/SubscriptionsDashboard.css" rel="stylesheet">
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

    $pdo = connectToDB();
    session_start();

    if(!isset($_SESSION['authorized']) or $_SESSION['authorized'] == 0){
        session_unset();
        header('Location: login.php');
    }

    $emailInserted = false;
    $checkEmailRes = false;
    $checkPremiumRes = true;
    $endDateInserted = false;
    $checkEndDateRes = false;
    $costInserted = false;
    $checkCostRes = false;

    $emailInserted = isset($_POST['email']);
    if($emailInserted and strlen($_POST['email'])<30){
        $checkEmailRes = checkEmail($_POST['email'], $pdo);
        if($checkEmailRes and checkType($_POST['email'], $pdo) == "Utente"){
            $checkPremiumRes = false;
        }
    }

    $endDateInserted = isset($_POST['dateOfEnd']);
    if($endDateInserted){
        $checkEndDateRes = checkDateValidity($_POST['dateOfEnd']);
    }

    $costInserted = isset($_POST['cost']);
    if($costInserted and $_POST['cost']>0){
        $checkCostRes = true;
    }

    if(isset($_POST['searchField'])){
        $_SESSION['search'] = $_POST['searchField'];
    }

    if(isset($_POST['searchField'])){
        $_SESSION['search'] = $_POST['searchField'];
    }

    if(isset($_POST['AcceptInvite'])){
        acceptInvite($_POST['AcceptInvite'], $pdo);
    } else if(isset($_POST['DenyInvite'])) {
        denyInvite($_POST['DenyInvite'], $pdo);
    }

    if(isset($_POST['toDelete'])){
        deleteSubscription($_POST['toDelete'], $pdo);
    }

    if($emailInserted and !$checkPremiumRes and isset($_POST['addSubscriptionBtn'])){
        addSubscription($_POST['email'], $_POST['dateOfEnd'], $_POST['cost'], $pdo);
    }

    if(isset($_POST['toDelete'])){
        deleteSubscription($_POST['toDelete'], $pdo);
        unset($_POST['toDelete']);
    } else if(isset($_POST['toIncrease1'])){
        increaseSubscription($_POST['toIncrease1'], 1, $pdo);
        unset($_POST['toIncrease1']);
    } else if(isset($_POST['toIncrease2'])) {
        increaseSubscription($_POST['toIncrease2'], 2, $pdo);
        unset($_POST['toIncrease2']);
    } else if(isset($_POST['toIncrease3'])) {
        increaseSubscription($_POST['toIncrease3'], 3, $pdo);
        unset($_POST['toIncrease3']);
    } else if(isset($_POST['toDecrease1'])){
        decreaseSubscription($_POST['toDecrease1'], 1, $pdo);
        unset($_POST['toDecrease1']);
    } else if(isset($_POST['toDecrease2'])) {
        decreaseSubscription($_POST['toDecrease2'], 2, $pdo);
        unset($_POST['toDecrease2']);
    } else if(isset($_POST['toDecrease3'])) {
        decreaseSubscription($_POST['toDecrease3'], 3, $pdo);
        unset($_POST['toDecrease3']);
    }

    function checkDateValidity($date){
        $minimumYear  = date("Y");
        $minimumMonth = date("m");
        $minimumDay = date("d");
        if(date('Y', strtotime($date)) >= $minimumYear and (date('m', strtotime($date)) >= $minimumMonth or date('d', strtotime($date)) >= $minimumDay)){
            return true;
        } else {
            return false;
        }
    }

    function addSubscription($email, $endSubscription, $cost, PDO $pdo) {
        try {
            $sql = "CALL AddSubscription(?, ?, ?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->bindValue( 2, $endSubscription, PDO::PARAM_STR);
            $res->bindValue( 3, $cost, PDO::PARAM_STR);
            $res->execute();
            insertLog("AddSubscription", "Executed");
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL AddSubscription() non riuscita. Errore: ".$e->getMessage());
            insertLog("AddSubscription", "Aborted");
            exit();
        }
    }

    function deleteSubscription($email, PDO $pdo) {
        try {
            $sql = "CALL RemoveSubscription(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->execute();
            insertLog("RemoveSubscription", "Executed");
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL AddSubscription() non riuscita. Errore: ".$e->getMessage());
            insertLog("RemoveSubscription", "Aborted");
            exit();
        }
    }

    function increaseSubscription($email, $typeOfIncrement, PDO $pdo) {
        try {
            $sql = "CALL IncreaseSubscription(?, ?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->bindValue( 2, $typeOfIncrement, PDO::PARAM_INT);
            $res->execute();
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL IncreaseSubscription() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function decreaseSubscription($email, $typeOfDecrement, PDO $pdo) {
        try {
            $sql = "CALL DecreaseSubscription(?, ?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->bindValue( 2, $typeOfDecrement, PDO::PARAM_INT);
            $res->execute();
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL DecreaseSubscription() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function searchPremiums(PDO $pdo){
        try {
            $sql = 'CALL SearchPremiums(?)';
            $res = $pdo->prepare($sql);
            if(!empty($_SESSION['search'])) {
                $res->bindValue(1, $_SESSION['search'], PDO::PARAM_STR);
            } else {
                $res->bindValue(1, '', PDO::PARAM_STR);
            }
            $res->execute();
            return $res->fetchAll();
        } catch (PDOException $e){
            echo("[ERRORE] Query SQL SearchPremiums() non riuscita. Errore: ".$e->getMessage());
            exit();
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

                                            for($x=0; $x < $nOfNotifications; $x++){
                                                $row = $notifications[$x];
                                                $type = $row['Type'];
                                                if($type == 'Invito'){
                                                    $poll = getInvitePoll($row['Codice'], $pdo)->fetch();
                                                    $pollCreator = getPollCreator($poll['Codice'], $pdo)->fetch();
                                                    if(array_key_exists('EmailUtentePremium', $pollCreator)) {
                                                        $userSender = getUser($pollCreator['EmailUtentePremium'], $pdo)->fetch();
                                                        $sender = $userSender['Nome'].' '.$userSender['Cognome'];
                                                        $senderProPic = getUserProPic($userSender['Email'], $pdo);
                                                    } else if(array_key_exists('CodiceAzienda', $pollCreator)){
                                                        $sender = getAzienda($pollCreator['CodiceAzienda'], $pdo)->fetch()['Nome'];
                                                    }
                                                  echo(
                                                    '<li class="dropdown-item-text" style="width: max-content;">
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
                                                }
                                            }

                                        ?>
                                        <li class="dropdown-item-text" style="width: max-content;">
                                            <div class="d-flex align-items-center justify-content-center fw-bold">Invito da ...</div>
                                            <div class="d-inline-flex gap-3 align-items-center justify-content-center" style="width: 350px">
                                                <div>
                                                    <div class="profile-container">
                                                        <img src="http://www.cs.unibo.it/~roccetti/marco-old.jpg" alt="Profile Picture" class="profile-picture">
                                                    </div>
                                                </div>
                                                <div class="vr" style="width: 2px">
                                                </div>
                                                <div class="text-wrap">
                                                    Nome ti ha invitato a partecipare al sondaggio NomeSondaggio
                                                    <form class="d-flex align-items-center justify-content-center gap-2 mt-1">
                                                        <a class="btn primary-btn-outline" href="javascript:void(0)">
                                                            Accetta
                                                        </a>
                                                        <a class="btn primary-btn" href="javascript:void(0)">
                                                            Rifiuta
                                                        </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                        <hr>
                                        <li class="dropdown-item">Another action</li>
                                        <li class="dropdown-item">Something else here</li>
                                    </ul>
                                </div>
                            </li>
                            <li class="d-flex align-items-center justify-content-center gap-2" style="display:flex; align-items: center; justify-content: center">
                                <?php
                                    echo("<p id='navbar-name'>Ciao, ".$_SESSION['nameLogged']."!</p>");
                                ?>
                                <div class="profile-container">
                                    <?php
                                     echo('
                                             <img src="'.$_SESSION['userProPicURI'].'" alt="Profile Picture" class="profile-picture">
                                     ');
                                    ?>
                                    <img src="http://www.cs.unibo.it/~roccetti/marco-old.jpg" alt="Profile Picture" class="profile-picture">
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
<div class="container-xl" id="subscriptionsDashboard-container">
    <div class="container-fluid row justify-content-center">
        <img src="../img/logoPollDBBlack.png" class="img-sm col-6" alt="...">
    </div>
    <h2>Gestione abbonamenti Premium</h2>
    <form class="row align-items-center justify-content-center gap-1" method="post">
        <div class="col-sm-9 p-0 form-floating">
            <?php
                if(!empty($_SESSION['search'])){
                    echo("<input type='text' class='form-control' id='searchField' name='searchField' value='".$_SESSION['search']."' placeholder='Nome del dominio di interesse' maxlength='30'>");
                } else {
                    echo("<input type='text' class='form-control' id='searchField' name='searchField' placeholder='Nome del dominio di interesse' maxlength='30'>");
                }
            ?>
            <label for="searchField">Email Utente</label>
        </div>
        <form method="post">
            <button class="btn btn-lg primary-btn login-btn col-sm-2" type="submit"><i class="bi bi-search" style="font-size: 150%"></i></button>
        </form>
        <div class="col-12 container-fluid mt-4">
            <form class="row justify-content-center gap-1" style="max-height: 250px; overflow-y: scroll;" method="post">
                <?php

                    $premiums = searchPremiums($pdo);
                    echo($premiums[0]['Emailutente']);

                    if(sizeof($premiums)==0){
                        echo('Nessun utente premium trovato');
                    }
                    for($x=0; $x<sizeof($premiums); $x++){
                        $premiumName = $premiums[$x]['Emailutente'];
                        $subscriptionStartDate = $premiums[$x]['InizioAbbonamento'];
                        $subscriptionEndDate = $premiums[$x]['FineAbbonamento'];
                        echo("
                            <div class='col-12 mb-3' style='background-color: grey; height: 50px; color: white; border-radius: 25px; display: flex; justify-content: start; align-items: center'>"
                            .$premiumName.
                            "<button class='btn primary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md ms-auto me-1' value='".$premiumName."' type='submit' name='toDecrease3'>-1Y</button>
                            <button class='btn primary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md mx-1' value='".$premiumName."' type='submit' name='toDecrease2'>-1M</button>
                            <button class='btn primary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md ms-1 me-3' value='".$premiumName."' type='submit' name='toDecrease1'>-1D</button>
                            <button class='btn primary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md ms-3 me-1' value='".$premiumName."' type='submit' name='toIncrease1'>+1D</button>
                            <button class='btn primary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md mx-1' value='".$premiumName."' type='submit' name='toIncrease2'>+1M</button>
                            <button class='btn primary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md mx-1' value='".$premiumName."' type='submit' name='toIncrease3'>+1Y</button>
                            <button class='btn secondary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md mx-1' value='".$premiumName."' type='submit' name='toDelete'><i class='bi bi-x-lg' style='font-size: 15px'></i></button></div>
                        ");
                    }

                ?>
            </form>
        </div>
        <h2>Aggiungi nuovo abbonamento Premium</h2>
        <form method="post">
            <div class="col-5">
                <label class="form-label" for="email">Email Utente</label>
                <input type="text" <?php
                if($emailInserted and $checkEmailRes and !$checkPremiumRes){
                    echo("class='form-control is-valid'");
                } else if($emailInserted) {
                    echo("class='form-control is-invalid'");
                } else {
                    echo("class='form-control'");
                }
                ?> id="email" name="email" placeholder="Email utente" maxlength="30" required>
                <div class="valid-feedback">
                    Email utente valida!
                </div>
                <div class="invalid-feedback">
                    Email utente non valida o già premium!
                </div>
            </div>
            <div class="col-5 mt-3">
                <label class="form-label">Data di fine abbonamento</label>
                <div class="input-group date">
                    <input type="date" <?php
                    if($endDateInserted and $checkEndDateRes){
                        echo("class='form-control is-valid'");
                    } else if($endDateInserted) {
                        echo("class='form-control is-invalid'");
                    } else {
                        echo("class='form-control'");
                    }
                    ?>class="form-control" id="dateOfEnd" name="dateOfEnd" required>
                </div>
                <div class="valid-feedback">
                    Data di fine valida!
                </div>
                <div class="invalid-feedback">
                    Data di fine non valida!
                </div>
            </div>
            <div class="col-5 mt-3">
                <label class="form-label" for="cost">Costo</label>
                <input type="number" step="0.01" min="0" <?php
                if($costInserted and $checkCostRes){
                    echo("class='form-control is-valid'");
                } else if($costInserted) {
                    echo("class='form-control is-invalid'");
                } else {
                    echo("class='form-control'");
                }
                ?> class="form-control" id="cost" name="cost" required>
                <div class="valid-feedback">
                    Costo valido!
                </div>
                <div class="invalid-feedback">
                    Costo non valido!
                </div>
            </div>
            <button class="btn primary-btn login-btn mt-4" type="submit" id="addSubscriptionBtn" name="addSubscriptionBtn" value="addSubscriptionBtn">Aggiungi Abbonamento</button>
        </form>
    </form>

</div>
</body>
</html>

