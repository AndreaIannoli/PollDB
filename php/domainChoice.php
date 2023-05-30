<!DOCTYPE html>
<html lang="it" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PollDB - Registration</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/domainChoice.css" rel="stylesheet">
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
    if(isset($_POST['searchField'])){
        $_SESSION['search'] = $_POST['searchField'];
    }

    $pdo = connectToDB();
    if(!isset($_SESSION['authorized']) or $_SESSION['authorized'] == 0){
        session_unset();
        header('Location: login.php');
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
                                                $typeRes = getNotificationType($row['Codice'], $pdo)->fetch();
                                                $type = $typeRes[0];
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
<div class="container-xl" id="login-container">
    <div class="container-fluid row justify-content-center">
        <img src="../img/logoPollDBBlack.png" class="img-sm col-6" alt="...">
    </div>
    <form class="row align-items-center justify-content-center gap-1" method="post">
        <div class="col-sm-9 p-0 form-floating">
            <!-- TODO add search mechanism to still on the search maybe with a session's variable -->
            <?php
                if(!empty($_SESSION['search'])){
                    echo("<input type='text' class='form-control' id='searchField' name='searchField' value='".$_SESSION['search']."' placeholder='Nome del dominio di interesse'>");
                } else {
                    echo("<input type='text' class='form-control' id='searchField' name='searchField' placeholder='Nome del dominio di interesse'>");
                }
            ?>
            <label for="searchField">Nome del dominio di interesse</label>
        </div>
        <form method="post">
            <button class="btn btn-lg btn-primary login-btn col-sm-2" type="submit"><i class="bi bi-search-heart" style="font-size: 150%"></i></button>
        </form>
        <div class="col-12 container-fluid mt-4">
            <form class="row justify-content-center gap-1" style="max-height: 250px; overflow-y: scroll;" method="post">
                <?php
                    try {
                        $sql = 'CALL SearchDominio(?)';
                        $res = $pdo->prepare($sql);
                        if(!empty($_SESSION['search'])) {
                            $res->bindValue(1, $_SESSION['search'], PDO::PARAM_STR);
                        } else {
                            $res->bindValue(1, '', PDO::PARAM_STR);
                        }
                        $res->execute();
                    } catch (PDOException $e){
                        echo 'exception: '.$e;
                    }

                    $domainNames = [];
                    for($x=0; $x<$res->rowCount(); $x++){
                        $row = $res->fetch();
                        array_push($domainNames, $row[0]);
                    }
                    $res->closeCursor();
                    if(sizeof($domainNames)==0){
                        echo('Nessun dominio di interesse trovato');
                    }
                    $interests = getInteressamento($_SESSION['emailLogged'], $pdo);
                    $interestsArguments = [];

                    for($x=0; $x<$interests->rowCount(); $x++){
                        $interestRow = $interests->fetch();
                        array_push($interestsArguments, $interestRow[0]);
                    }
                    $interests->closeCursor();
                    for($x=0; $x<sizeof($domainNames); $x++){
                        $domainName = $domainNames[$x];
                        if(isset($_POST[$domainName]) and $_POST[$domainName] == 'notInterested'){
                            try {
                                $sqlToAdd = 'CALL AddInteressamento(?, ?)';
                                $res = $pdo->prepare($sqlToAdd);
                                $res->bindValue(1, $domainName, PDO::PARAM_STR);
                                $res->bindValue(2, $_SESSION['emailLogged'], PDO::PARAM_STR);
                                $res->execute();
                                $res->closeCursor();
                                unset($_POST[$domainName]);
                                insertLog("AddInteressamento", "Executed");
                            } catch (PDOException $e) {
                                echo('Failed to execute Add query: '.$e);
                                insertLog("AddInteressamento", "Aborted");
                            }
                            $interests = getInteressamento($_SESSION['emailLogged'], $pdo);
                            $interestsArguments = [];

                            for($i=0; $i<$interests->rowCount(); $i++){
                                $interestRow = $interests->fetch();
                                array_push($interestsArguments, $interestRow[0]);
                            }
                            $interests->closeCursor();
                        } else if(isset($_POST[$domainName]) and $_POST[$domainName] == 'interested'){
                            try {
                                $sqlToRemove = 'CALL RemoveInteressamento(?, ?)';
                                $res = $pdo->prepare($sqlToRemove);
                                $res->bindValue(1, $domainName, PDO::PARAM_STR);
                                $res->bindValue(2, $_SESSION['emailLogged'], PDO::PARAM_STR);
                                $res->execute();
                                $res->closeCursor();
                                unset($_POST[$domainName]);
                                insertLog("RemoveInteressamento", "Executed");
                            } catch (PDOException $e) {
                                echo('Failed to execute Remove query: '.$e);
                                insertLog("RemoveInteressamento", "Aborted");
                            }
                            $interests = getInteressamento($_SESSION['emailLogged'], $pdo);
                            $interestsArguments = [];

                            for($i=0; $i<$interests->rowCount(); $i++){
                                $interestRow = $interests->fetch();
                                array_push($interestsArguments, $interestRow[0]);
                            }
                            $interests->closeCursor();
                        }
                        $_POST[$domainName] = null;
                        if(in_array($domainName, $interestsArguments)) {
                            echo("
                                <button class='btn btn-primary login-btn d-grid wrap-content col-sm-3 btn-square-md' value='interested' type='submit' name='" . $domainName . "'><i class='bi bi-heart-fill'></i>" . $domainName . "</button>
                            ");
                        } else {
                            echo("
                                <button class='btn btn-primary login-btn d-grid wrap-content col-sm-3 btn-square-md' value='notInterested' type='submit' name='" . $domainName . "'><i class='bi bi-heart'></i>" . $domainName . "</button>
                            ");
                        }
                    }
                ?>
            </form>
            <div class="d-flex justify-content-end mt-5">
                <button class="btn btn-primary login-btn" onclick="window.location.href='visualizza_sondaggi.php';">Avanti</button>
            </div>
        </div>
    </form>

</div>
</body>
</html>

