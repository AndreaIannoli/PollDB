<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistiche Premium</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
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
    require 'NotificationManager.php';
    require 'accountManager.php';
    require 'connectionManager.php';
    $pdo = connectToDB();

    session_start();
    $userType = $_SESSION['userType'];
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
                                
                                      <ul class="dropdown-menu dropdown-menu-end">
                                          <?php
                                          
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
    
    <div class="container box2 mt-5">
        <h1 class="t3">Le tue statistiche</h1>
        <p class="t3" style="margin-bottom: 3%;">Visualizza le statistiche relative alle domande e ai sondaggi presenti sulla piattaforma. Ogni rettangolo contiene un sondaggio e le statistiche sulle domande e sulle risposte presenti in esso! </p>
        <!-- questa parte dovrebbe contenere i sondaggi che hai creato se sei premium, quelli a cui hai partecipato se sei utente-->
    </div>
        

        <!--Statistica: numero di risposte per ogni domanda -->
        <?php
            $stmt = $pdo->prepare("SELECT Codice, Titolo FROM Sondaggio");
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //per ogni sondaggio
            foreach ($res as $row) {
                echo '<div class="container box2 mt-5">';
                $codiceSondaggio = $row['Codice'];
                $titolo = $row['Titolo']; //titolo sondaggio (mi serve)
                echo "<h3>$titolo</h3>";

                //ora prendo le domande relative a quel sondaggio
                $stmt = $pdo->prepare("CALL GetDomande(?)");
                $stmt->bindParam(1, $codiceSondaggio, PDO::PARAM_INT);
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $labels = array();
                $data = array();
                

                //per ogni domanda del sondaggio
                foreach ($res as $row) {
                    $Id = $row['Id'];  
                    $Domanda = $row["Testo"];
                    $labels2 = array();
                    $data2 = array();                 
                    //adesso posso prendere il numero di risposte relative ad ogni singola domanda
                    $stmt = $pdo->prepare("CALL NumberRisposte(?)");
                    $stmt->bindParam(1, $Id, PDO::PARAM_INT);
                    $stmt->execute();
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($res as $index => $row) {
                        //echo '<p>Domanda: ' . $row["Testo"] . '</p>'; //testo domanda (mi serve)
                        $risultato = $row["C1"] + $row["C2"];   //conteggio risposte (mi serve)
                        $labels[] = $row["Testo"];
                        $data[] = $risultato;
                        //echo '<p>Numero Risposte:' . $risultato . '</p>';
                    }
                    //statistiche media, minimo e massimo
                    $stmt = $pdo->prepare("CALL GetStatisticaAperte(?)");
                    $stmt->bindParam(1, $Id, PDO::PARAM_INT);
                    $stmt->execute();
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($res as $index => $row) {
                        if (!empty($row["Minimo"])) {
                            echo '<div style="background-color:#9027e8; padding:30px; border-radius:30px; margin:50px 0px 50px 0px">';
                            echo '<h3 style="color:white;">' . $Domanda . '</h3>';
                            echo '<p style="color:white;">Valore minimo: ' . $row["Minimo"] . '</p>';
                            echo '<p style="color:white;">Valore medio: ' . $row["Medio"] . '</p>'; 
                            echo '<p style="color:white;">Valore massimo: ' . $row["Massimo"] . '</p>';  
                            echo '</div>';
                        }
                    }
                    //statistica sulle risposte chiuse
                    $stmt = $pdo->prepare("CALL GetStatisticaChiuse(?)");
                    $stmt->bindParam(1, $Id, PDO::PARAM_INT);
                    $stmt->execute();
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($res as $index => $row) {
                        $labels2[] = $row["Testo"];
                        $data2[] = $row["Conteggio"];
                        //echo '<p>Numero Risposte:' . $risultato . '</p>';
                    }
                    
                    //stampare il grafico rispostechiuse
                    if (!empty($labels2)) {
                        echo '<h3 style="">' . $Domanda . '</h3>';
                        echo '
                            <canvas id="istogramma3-' . $codiceSondaggio . '"></canvas>
                            <script>
                                var labels = ' . json_encode($labels2) . ';
                                var data = ' . json_encode($data2) . ';

                                var ctx = document.getElementById("istogramma3-' . $codiceSondaggio . '").getContext("2d");
                                var chart = new Chart(ctx, {
                                    type: "bar",
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: "Valori",
                                            data: data,
                                            backgroundColor: "black"
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: "Numero risposte:"
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>';
                    }
                }

                

                //stampare il grafico 1
                if (!empty($labels)) {
                    echo '<h3 style="margin: 30px 0px 30px 0px;">Questo grafo mostra il numero di risposte che ha ricevuto ciascuna domanda.</h3>';
                    echo '
                            <canvas id="istogramma1-' . $codiceSondaggio . '"></canvas>
                            <script>
                                var labels = ' . json_encode($labels) . ';
                                var data = ' . json_encode($data) . ';

                                var ctx = document.getElementById("istogramma1-' . $codiceSondaggio . '").getContext("2d");
                                var chart = new Chart(ctx, {
                                    type: "bar",
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: "Valori",
                                            data: data,
                                            backgroundColor: "black"
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: "Numero risposte:"
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>';
                    echo '<div style="height:50px;"></div>';
                }
                echo '</div>';
            }
        ?>

        <!--Statistica: numero di risposte per ogni domanda -->

    </div>

    

  </body>
</html>
