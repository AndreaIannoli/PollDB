<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserisci Domanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/basicstyle.css" rel="stylesheet">
    <link href="../stylesheets/inserisci_domanda.css" rel="stylesheet">
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
        require 'accountManager.php';
        require 'connectionManager.php';
        require 'NotificationManager.php';
        require 'LogsManager.php';
        $pdo = connectToDB();
        session_start();
        requiredLogin();
        requiredCreator();
        navBarCheck($pdo);
        $CodiceSondaggio = $_GET['CodiceSondaggio'];

        if(isset($_POST['searchField'])){
            $_SESSION['search'] = $_POST['searchField'];
        }

        if(isset($_POST['toAdd'])){
            addComposition($_POST['toAdd'], $_GET['CodiceSondaggio'], $pdo);
        }

        function addComposition($idDomanda, $codiceSondaggio, PDO $pdo) {
            try {
                $sql = "CALL AddComposizione(?, ?)";
                $res = $pdo->prepare($sql);
                $res->bindValue( 1, $idDomanda, PDO::PARAM_INT);
                $res->bindValue( 2, $codiceSondaggio, PDO::PARAM_INT);
                $res->execute();
                insertLog("AddComposizione", "Executed");
            } catch (PDOException $e) {
                echo("[ERRORE] Query SQL AddComposizione() non riuscita. Errore: ".$e->getMessage());
                insertLog("AddComposizione", "Aborted");
                exit();
            }
        }

        function searchDomanda(PDO $pdo){
            try {
                $sql = 'CALL SearchDomanda(?, ?)';
                $res = $pdo->prepare($sql);
                if(!empty($_SESSION['search'])) {
                    $res->bindValue(1, $_SESSION['search'], PDO::PARAM_STR);
                    $res->bindValue(2, $_GET['CodiceSondaggio'], PDO::PARAM_INT);
                } else {
                    $res->bindValue(1, '', PDO::PARAM_STR);
                    $res->bindValue(2, $_GET['CodiceSondaggio'], PDO::PARAM_INT);
                }
                $res->execute();
                return $res->fetchAll();
            } catch (PDOException $e){
                echo("[ERRORE] Query SQL SearchDomanda() non riuscita. Errore: ".$e->getMessage());
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
    
    <button type="button" class="btn btn-primary" id="uploadimage" data-bs-toggle="modal" data-bs-target="#uploadfile"> </button>

    <div class="container-md mt-5 p-5 mb-5" style="background-color: white; border-radius: 20px;" id="main">
        <h1>Seleziona una domanda</h1>
        <form class="row align-items-center justify-content-center gap-1" method="post">
            <div class="col-sm-9 p-0 form-floating">
                <?php
                if(!empty($_SESSION['search'])){
                    echo("<input type='text' class='form-control' id='searchField' name='searchField' value='".$_SESSION['search']."' placeholder='Nome del dominio di interesse' maxlength='30'>");
                } else {
                    echo("<input type='text' class='form-control' id='searchField' name='searchField' placeholder='Nome del dominio di interesse' maxlength='30'>");
                }
                ?>
                <label for="searchField">Testo della domanda</label>
            </div>
            <form method="post">
                <button class="btn btn-lg primary-btn login-btn col-sm-2" type="submit"><i class="bi bi-search" style="font-size: 150%"></i></button>
            </form>
            <div class="col-12 container-fluid mt-4">
                <form class="row justify-content-center gap-1" style="max-height: 250px; overflow-y: scroll;" method="post">
                    <?php

                    $answers = searchDomanda($pdo);

                    if(sizeof($answers)==0){
                        echo('Nessuna domanda trovata');
                    }
                    for($x=0; $x<sizeof($answers); $x++){
                        $answerText = $answers[$x]['Testo'];
                        $answerID = $answers[$x]['Id'];
                        $answerPoint = $answers[$x]['Punteggio'];
                        echo("
                            <div class='col-12 mb-3 p-4' style='background-color: #9027e8; color: white; border-radius: 25px; display: flex; justify-content: start; align-items: center'>"
                            .$answerText.'<br> Punteggio:'.$answerPoint.
                            "
                            <button class='btn primary-btn wrap-content col-sm-3 ms-auto' value='".$answerID."' type='submit' name='toAdd'>Aggiungi</button></div>
                        ");
                    }

                    ?>
                </form>
            </div>
        </form>
        <!--Fine aggiunta dinamica -->
        <h1 class="mt-5">Crea una domanda</h1>

        <form action="inserisci_domanda.php" method="post">
            <input type="hidden" name="CodiceSondaggio" value="<?php echo $CodiceSondaggio; ?>">
          
            <div class="mb-3">
              <label  class="form-label">Tipologia</label>
              <select id="tipologiaDomanda" class="form-select" name="tipologiaDomanda" onchange="mostraOpzioni()">
                  <option  value="APERTA" selected>Domanda a risposta aperta</option>
                  <option value="CHIUSA">Domanda a risposta chiusa</option>
              </select>              
            </div>
            
            <div class="mb-3">
                <label class="form-label">Testo domanda</label>
                <textarea class="form-control" name="testoDomanda" rows="3"  id="testoDomanda"></textarea>
              </div>

              <div class="mb-3">
                <label  class="form-label">Punteggio</label>
                <input type="number" class="form-control" name="punteggioDomanda">
                <div id="emailHelp" class="form-text">Inserisci un punteggio da assegnare agli utenti che risponderanno </div>
              </div>

            <div id="boxcaratteri" class="mb-3">
              <label  class="form-label">Max Caratteri</label>
              <input type="number" class="form-control" name="max_caratteri" id="max_caratteri">
              <div class="form-text">Inserisci il numero massimo di caratteri</div>
            </div>

            <div id="bloccoOpzioni" class="mb-3">
              <label  class="form-label">Inserisci opzioni domanda chiusa</label>
              <input type="text" class="form-control opzione" name="opzione1" id="opzione1" placeholder="Opzione 1">
              <input type="text" class="form-control opzione" name="opzione2" id="opzione2" placeholder="Opzione 2">
              <input type="text" class="form-control opzione" name="opzione3" id="opzione3" placeholder="Opzione 3">
              <input type="text" class="form-control opzione" name="opzione4" id="opzione4" placeholder="Opzione 4">
            </div>
           
            <button type="submit" class="btn primary-btn newq">Carica domanda nel sondaggio</button>

            <!-- Finestra per upload immagine -->
            <div class="modal fade" id="uploadfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Inserisci immagine</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Url immagine:</label>
                        <input type="text" class="form-control" name="urlfoto" id="ImageUrl">
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="uploadImage()">Upload image</button>
                  </div>
                </div>
              </div>
            </div>


          </form>

    </div>

    





    <script>

        function uploadImage(){
          var image = document.getElementById("uploadimage");
          var ImageUrl = document.getElementById("ImageUrl").value;
          image.style.backgroundImage = "url('" + ImageUrl + "')";
        }

        function mostraOpzioni() {
          var select = document.getElementById("tipologiaDomanda");
          if (select.value == "APERTA") {
            document.getElementById("bloccoOpzioni").style.display = "none";
            document.getElementById("boxcaratteri").style.display = "block";
          } else {
            document.getElementById("bloccoOpzioni").style.display = "block";
            document.getElementById("boxcaratteri").style.display = "none";
          }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>