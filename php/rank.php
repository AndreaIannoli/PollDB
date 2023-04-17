<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserisci Domanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../stylesheets/style.css">
    <link href="../stylesheets/rank.css" rel="stylesheet">

  </head>
  <body>

  <?php
      require 'connectionManager.php';
      $pdo = connectToDB();
      session_start();
      $emailUtente = $_SESSION['emailLogged'];
      $type = $_SESSION['type'];
  ?>

    <!--====== NAVBAR ONE PART START ======-->
    <section class="navbar-area navbar-one">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="home.php">
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
                        <div class="navbar-btn d-none d-sm-inline-block">
                            <ul>
                                <li>
                                    <a class="btn primary-btn-outline" href="../php/login.php"
                                    >Login</a
                                    >
                                </li>
                                <li>
                                    <a class="btn primary-btn" href="../php/registration.php"
                                    >Registrati</a
                                    >
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
                $sql="SELECT Nome, Cognome, TotaleBonus FROM Utente ORDER BY TotaleBonus DESC";
                $res=$pdo->query($sql);
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