<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserisci Domanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="../stylesheets/rank.css" rel="stylesheet">
    <link rel="stylesheet" href="../stylesheets/style.css">

  </head>
  <body>

  <?php
      require 'accountManager.php';
      require 'NotificationManager.php';
      require 'LogsManager.php';
      require 'connectionManager.php';
      $pdo = connectToDB();
      session_start();
      navBarCheck($pdo);
      requiredLogin();
      requiredNotAdmin();
      $emailUtente = $_SESSION['emailLogged'];
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
    
    <div class="container box2">
        <h1 class="t3">Classifica Utenti</h1>
        <p class="t3" style="margin-bottom: 8%;">Visualizza la classifica degli utenti e cerca di ottenere sempre più punti per vincere premi più prestigiosi</p>

        <!-- questa parte dovrebbe contenere i sondaggi che hai creato se sei premium, quelli a cui hai partecipato se sei utente-->

    <table class="table">
    <tr>
        <th class="tcampo"></th>
        <th class="tcampo">Nome</th>
        <th class="tcampo">Cognome</th>
        <th class="punteggio">Totale Bonus</th>
    </tr>
    <?php     
                /*
                $sql="SELECT Nome, Cognome, TotaleBonus FROM Utente ORDER BY TotaleBonus DESC";
                $res=$pdo->query($sql);
                */
                try{
                    $stmt = $pdo->prepare("CALL GetRank()");
                    $stmt->execute();
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                }catch (PDOException $e){
                    echo 'exception'.$e;
                }
                foreach($res as $index => $row) {
                    $Nome = $row["Nome"];
                    $Cognome = $row["Cognome"];
                    $TotaleBonus = $row["TotaleBonus"];
                    echo '<tr class="riga">';
                    echo '<td class="tcampo">' . $index+1 . '</td>';
                    echo '<td class="tcampo">' . $row["Nome"] . '</td>';
                    echo '<td class="tcampo">' . $row["Cognome"] .  '</td>';
                    echo '<td class="punteggio">' . $row["TotaleBonus"] .  '</td>';
                    echo '</tr>';
                }
        ?>
    </table>

         
    </div>
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>
