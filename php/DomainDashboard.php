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
    <link href="../stylesheets/DomainDashboard.css" rel="stylesheet">
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
    $domainInserted = false;
    $checkDomainRes = true;

    $domainInserted = isset($_POST['domainName']);
    if($domainInserted){
        $checkDomainRes = checkDomain($_POST['domainName'], $pdo);
    }

    if(isset($_POST['searchField'])){
        $_SESSION['search'] = $_POST['searchField'];
    }

    if(!isset($_SESSION['authorized']) or $_SESSION['authorized'] == 0){
        session_unset();
        header('Location: login.php');
    }

    if(isset($_POST['AcceptInvite'])){
        acceptInvite($_POST['AcceptInvite'], $pdo);
    } else if(isset($_POST['DenyInvite'])) {
        denyInvite($_POST['DenyInvite'], $pdo);
    }

    if(isset($_POST['toDelete'])){
        deleteDomain($_POST['toDelete'], $pdo);
    }

    if($domainInserted and !$checkDomainRes and isset($_POST['addDomainBtn'])){
        echo 'added';
        addDomain($_POST['domainName'], $_POST['description'], $pdo);
    }

    function deleteDomain($domainName, PDO $pdo){
        try {
            $sql = "CALL RemoveDomain(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $domainName, PDO::PARAM_STR);
            $res->execute();
            insertLog("RemoveDomain", "Executed");
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL RemoveDomain() non riuscita. Errore: ".$e->getMessage());
            insertLog("RemoveDomain", "Aborted");
            exit();
        }
    }

    function addDomain($domainName, $domainDescription, PDO $pdo){
        try {
            $sql = "CALL AddDomain(?, ?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $domainName, PDO::PARAM_STR);
            $res->bindValue( 2, $domainDescription, PDO::PARAM_STR);
            $res->execute();
            insertLog("AddDomain", "Executed");
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL AddDomain() non riuscita. Errore: ".$e->getMessage());
            insertLog("AddDomain", "Aborted");
            exit();
        }
    }

    function searchDomain(PDO $pdo){
        try {
            $sql = 'CALL SearchDominio(?)';
            $res = $pdo->prepare($sql);
            if(!empty($_SESSION['search'])) {
                $res->bindValue(1, $_SESSION['search'], PDO::PARAM_STR);
            } else {
                $res->bindValue(1, '', PDO::PARAM_STR);
            }
            $res->execute();
            return $res->fetchAll();
        } catch (PDOException $e){
            echo("[ERRORE] Query SQL SearchDominio() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }
    function checkDomain($domainName, PDO $pdo){
        try {
            $sql = "CALL CheckDomain(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $domainName, PDO::PARAM_STR);
            $res->execute();
            $count = $res->fetch();
            if($count[0]>0){
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL CheckDomain() non riuscita. Errore: ".$e->getMessage());
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
<div class="container-xl" id="domainDashboard-container">
    <div class="container-fluid row justify-content-center">
        <img src="../img/logoPollDBBlack.png" class="img-sm col-6" alt="...">
    </div>
    <h2>Elimina domini</h2>
    <form class="row align-items-center justify-content-center gap-1" method="post">
        <div class="col-sm-9 p-0 form-floating">
            <?php
                if(!empty($_SESSION['search'])){
                    echo("<input type='text' class='form-control' id='searchField' name='searchField' value='".$_SESSION['search']."' placeholder='Nome del dominio di interesse'>");
                } else {
                    echo("<input type='text' class='form-control' id='searchField' name='searchField' placeholder='Nome del dominio di interesse'>");
                }
            ?>
            <label for="searchField">Nome del dominio di interesse da eliminare</label>
        </div>
        <form method="post">
            <button class="btn btn-lg primary-btn login-btn col-sm-2" type="submit"><i class="bi bi-search" style="font-size: 150%"></i></button>
        </form>
        <div class="col-12 container-fluid mt-4">
            <form class="row justify-content-center gap-1" style="max-height: 250px; overflow-y: scroll;" method="post">
                <?php
                    $domainNames = searchDomain($pdo);

                    if(sizeof($domainNames)==0){
                        echo('Nessun dominio di interesse trovato');
                    }
                    for($x=0; $x<sizeof($domainNames); $x++){
                        $domainName = $domainNames[$x]['Argomento'];
                        echo("
                                <button class='btn primary-btn login-btn d-grid wrap-content col-sm-3 btn-square-md' value='".$domainName."' type='submit' name='toDelete'><i class='bi bi-x-lg' style='font-size: 30px'></i>" . $domainName . "</button>
                        ");
                    }
                ?>
            </form>
        </div>
        <h2>Crea domini</h2>
        <form method="post">
            <div class="col-5">
                <label class="form-label" for="domainName">Argomento dominio d'interesse</label>
                <input type="text" <?php
                if($domainInserted and !$checkDomainRes){
                    echo("class='form-control is-valid'");
                } else if($domainInserted) {
                    echo("class='form-control is-invalid'");
                } else {
                    echo("class='form-control'");
                }
                ?> id="domainName" name="domainName" placeholder="Argomento dominio d'interesse" maxlength="30" required>
                <div class="valid-feedback">
                    Argomento dominio valido!
                </div>
                <div class="invalid-feedback">
                    Argomento dominio non valido o già in uso!
                </div>
            </div>
            <div class="col-12 mt-3">
                <label class="form-label" for="description">Descrizione</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Descrizione" maxlength="30" required>
                <div class="valid-feedback">
                    Descrizione valida!
                </div>
                <div class="invalid-feedback">
                    Descrizione non valida!
                </div>
            </div>
            <button class="btn primary-btn login-btn mt-4" type="submit" id="addDomainBtn" name="addDomainBtn" value="addDomainBtn">Crea</button>
        </form>
    </form>

</div>
</body>
</html>

