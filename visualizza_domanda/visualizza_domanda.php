<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserisci Domanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../stylesheets/visualizza_domanda.css">
    <link rel="stylesheet" href="../stylesheets/style.css">

  </head>
  <body>

  <?php
    $host = "localhost:3306";
    $dbName = "PollDB";
    $username = "root";
    $pass = "";
    try {
        $pdo = new PDO('mysql:host='.$host.';dbname='.$dbName, $username, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
        throw $e;
    }

    $IdDomanda = 17; #bisogna inserire l'id passato nell'url
    $tipologia = "APERTA";

    $sql="SELECT * FROM RispostaAperta WHERE IdDomanda='$IdDomanda'";
    $res=$pdo->query($sql);
    if ($res->rowCount() > 0) {
      $tipologia = "APERTA";
    } else {
      $tipologia = "CHIUSA";
    }

  ?>

    <!--====== NAVBAR ONE PART START ======-->
    <section class="navbar-area navbar-one">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <nav class="navbar navbar-expand-lg">
                      <a class="navbar-brand" href="../homepage/home.html">
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
                                  <a class="btn primary-btn-outline" href="../login/login.html"
                                  >Login</a
                                  >
                              </li>
                              <li>
                                  <a class="btn primary-btn" href="../login/register.html"
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
                $sql="SELECT Punteggio FROM Domanda WHERE Id='$IdDomanda'";
                $res=$pdo->query($sql);
                $row = $res->fetch();
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
              $sql="SELECT Testo FROM Domanda WHERE Id='$IdDomanda'";
              $res=$pdo->query($sql);
              $row = $res->fetch();
              $testo = $row['Testo'];
              echo $testo;
            ?>
          </p>
        </div>

        <?php
          if($tipologia == 'APERTA'){
            $sql="SELECT Testo FROM RispostaAperta WHERE IdDomanda='$IdDomanda'";
          }else{
            $sql="SELECT Testo FROM RispostaChiusa WHERE IdDomanda='$IdDomanda'";
          }
          $res=$pdo->query($sql);
          foreach($res as $row) {
            echo '<div class="box answer">';
            echo '<h4 class="t2">Risposta:</h4>';
            echo '<p class="t2">' . $row["Testo"] . '</p>';
            echo '</div>';
          }
        ?>

        

        

        <div class="floating" style="color:white"><button type="button" class="btn bfloat" data-bs-toggle="modal" data-bs-target="#inseriscirisposta"><i class="bi bi-plus ifloat"></i></button></div>

    </div>

    <div class="modal fade" id="inseriscirisposta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Inserisci risposta</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Testo della risposta:</label>
                <textarea class="form-control" rows="3"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Invia Risposta</button>
          </div>
        </div>
      </div>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>