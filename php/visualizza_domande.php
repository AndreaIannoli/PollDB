<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserisci Domanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="../stylesheets/basicstyle.css" rel="stylesheet">
    <link href="../stylesheets/visualizza_sondaggi.css" rel="stylesheet">
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
    $pdo = connectToDB();
    navBarCheck($pdo);

    $CodiceSondaggio = $_GET['CodiceSondaggio']; 
    $TitoloSondaggio = $_GET['titoloSondaggio']; 

    session_start();
    $type = $_SESSION['userType'];
    requiredLogin();
    requiredNotAdmin();


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
    
    <div class="container box2" style="margin-top:3%">
        <h1 class="t3">
            <?php
                echo $TitoloSondaggio;
            ?>
        </h1>
        <p class="t3" style="margin-bottom: 8%;">Visualizza la lista delle domande di questo sondaggio. Non perderti mai nessuna informazione e resta aggiornato sui risultati dei sondaggi!</p>


        <?php
        /*
          $sql="SELECT IdDomanda FROM Composizione WHERE CodiceSondaggio='$CodiceSondaggio'";
          $res=$pdo->query($sql);
          */

          try{
            /*
            $sql="SELECT IdDomanda FROM Composizione WHERE CodiceSondaggio='$CodiceSondaggio'";
            $res=$pdo->query($sql);
            */
            $stmt = $pdo->prepare("CALL GetDomande(?)");
            $stmt->bindParam(1, $CodiceSondaggio, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC); 
          }catch (PDOException $e){
            echo 'exception'.$e;
          }
          foreach($res as $row) {
            $iddomanda = $row["Id"];
            /*
            $sql="SELECT Id, Testo, Punteggio FROM Domanda WHERE Id='$iddomanda'";
            $res=$pdo->query($sql);
            $row2 = $res->fetch();
            */
            echo '<div class="box answer">';
            echo '<h4 class="t2">Domanda: ' . $row["Id"] . '</h4>';
            echo '<p class="t2">' . $row["Testo"] . '</p>';
            echo '<p class="info"> Punteggio: ' . $row["Punteggio"] .  '</p>';
            echo '<a href="../php/visualizza_domanda.php?IdDomanda=' . $iddomanda . '"><button style="display: inline-block; position: absolute; right: 20px;" type="button" class="btn btn-light">Visualizza Domanda</button></a>';
            echo '</div>';
          }
        ?>
   
   <?php
        
        if($type != "Utente"){
            echo '<button class="btn btn-primary newq" onclick="location.href=\'inserisci_dom.php?CodiceSondaggio=\' + encodeURIComponent(\'' . $CodiceSondaggio . '\')">Crea nuova domanda</button>';        
        }
    ?>

    </div>
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>