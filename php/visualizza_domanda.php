<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visualizza Domanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../stylesheets/visualizza_domanda.css">
    <link rel="stylesheet" href="../stylesheets/style.css">

  </head>
  <body>

  <?php
     require 'accountManager.php';
     require 'connectionManager.php';
     require 'NotificationManager.php';
     $pdo = connectToDB();

    session_start();
    navBarCheck($pdo);
    requiredLogin();
    requiredNotAdmin();
    $emailUtente = $_SESSION['emailLogged'];
    $type = $_SESSION['type'];
    $IdDomanda = $_GET['IdDomanda']; #bisogna inserire l'id passato nell'url
    $tipologia = "CHIUSA";

    /*
    $sql="SELECT * FROM DomandaAperta WHERE Id='$IdDomanda'";
    $res=$pdo->query($sql);
    */
    try{
      $sql = 'CALL CheckTipoDomanda(?)';
      $res = $pdo->prepare($sql);
      $res->bindValue(1, $IdDomanda, PDO::PARAM_INT);
      $res->execute();
      if ($res->rowCount() > 0) {
        $tipologia = "APERTA";
      } else {
        $tipologia = "CHIUSA";
      }
      $res->closeCursor();
    }catch (PDOException $e){
        echo 'exception'.$e;
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
    
      <div id="uploadimage"> </div>

    <div class="container pt-5" id="main">
        <h1 class="t2">Informazioni</h1>
        <div class="row">
          <div class="col-5 col-sm-5 col-md-3 col-lg-2">
            <div class="tag">
              <p class="t3">
                <?php
                  echo $IdDomanda;
                ?>
              </p>
            </div>
          </div>
          <div class="col-5 col-sm-5 col-md-3 col-lg-2">
            <div class="tag">
              <p class="t3">
              <?php
                $sql = "SELECT Punteggio FROM Domanda WHERE Id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $IdDomanda, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch();
                $punteggio = $row['Punteggio'];
                echo $punteggio;
                
                ?>
              <i class="bi bi-coin"></i></p>
            </div>
          </div>
        </div>

        <div class="box question">
          <h4 class="t2">Domanda:</h4  >
          <p class="t2">
            <?php
              $sql = "SELECT Testo FROM Domanda WHERE Id = ?";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(1, $IdDomanda, PDO::PARAM_INT);
              $stmt->execute();
              $row = $stmt->fetch();
              $testo = $row['Testo'];
              echo $testo;              
            ?>
          </p>
        </div>

        <!--PREMIUM ONLY!!! forse da togliere visto che anche gli utenti normali possono visualizzare le risposte dei sondaggi a cui hanno partecipato-->
        <?php
          //if($type == "Premium"){
            if ($tipologia == 'APERTA') {
              $sql = "SELECT Testo FROM RispostaAperta WHERE IdDomanda = ?";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(1, $IdDomanda, PDO::PARAM_INT);
              $stmt->execute();
              foreach ($stmt as $row) {
                  echo '<div class="box answer">';
                  echo '<h4 class="t2">Risposta:</h4>';
                  echo '<p class="t2">' . $row["Testo"] . '</p>';
                  echo '</div>';
              }
            } else {
              //prende tutte le risposte relative a quella domanda
              $sql = "SELECT Id FROM RispostaChiusa WHERE RispostaChiusa.IdDomanda = ?";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(1, $IdDomanda, PDO::PARAM_INT);
              $stmt->execute();
              foreach ($stmt as $row2) {
                echo '<div class="box answer">';
                echo '<h4 class="t2">Risposta:</h4>';
                //per ogni risposta prendiamo il suo id e cerchiamo le opzioni corrispondenti
                $sql2 = "SELECT Testo FROM Selezione JOIN Opzione ON Selezione.NumeroOpzione = Opzione.Numero WHERE Selezione.IdRisposta = ?";
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->bindParam(1, $row2["Id"], PDO::PARAM_INT);
                $stmt2->execute();
                foreach ($stmt2 as $row3) { 
                  echo '<p class="t2">' . $row3["Testo"] . '</p>';
                }
                echo '</div>';              
              }
            }
            
          
          //} 
        ?>
         <!--PREMIUM ONLY!!!-->

        <div class="floating" style="color:white"><button type="button" class="btn bfloat" data-bs-toggle="modal" data-bs-target="#inseriscirisposta"><i class="bi bi-plus ifloat"></i></button></div>

    </div>

    <!--inserimento risposta -->
    <div class="modal fade" id="inseriscirisposta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Inserisci risposta</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="inserisci_risposta.php" method="post">
            <input type="hidden" name="IdDomanda" value="<?php echo $IdDomanda; ?>">
            <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
            <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Testo della risposta:</label>
                <?php
                  if($tipologia == "APERTA"){
                    echo '<textarea class="form-control" rows="3" name="testoRisposta"></textarea>';
                  }else{
                    $sql = "SELECT Numero, Testo FROM Opzione WHERE IdDomanda = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $IdDomanda, PDO::PARAM_INT);
                    $stmt->execute();
                    foreach ($stmt as $row) {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="checkbox" name="selections[]" value="' . $row["Numero"] . '">';
                        echo $row["Testo"];
                        echo '</div>';
                    }
                  }
                ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="send">Invia Risposta</button>
          </div>
          </form>
        </div>
      </div>
    </div>
   <!--inserimento risposta -->
    

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>