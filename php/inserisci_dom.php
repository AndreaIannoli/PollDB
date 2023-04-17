<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserisci Domanda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../stylesheets/inserisci_domanda.css">
    <link rel="stylesheet" href="../stylesheets/style.css">
  </head>
  <body>
    <?php
          $CodiceSondaggio = $_GET['CodiceSondaggio']; 
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
    
    <button type="button" class="btn btn-primary" id="uploadimage" data-bs-toggle="modal" data-bs-target="#uploadfile"> </button>

    <div class="container pt-5" id="main">
        <h1>Inserisci informazioni</h1>

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
           
            <button type="submit" class="btn primary-btn">Carica domanda nel sondaggio</button>

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