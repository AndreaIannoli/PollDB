<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aggiungi premio</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link href="../stylesheets/aggiungiPremio.css" rel="stylesheet">
    </head>
    <body>
        <?php
            require 'connectionManager.php';
            require 'accountManager.php';


            $pdo = connectToDB();




            if(isset($_POST["buttonAggiungi"])){
                try {
                    $sql = 'CALL inserisciPremio(?, ?, ?, ?, ?)';
                    $res = $pdo->prepare($sql);
                    $res->bindValue(1, $_POST["nome"], PDO::PARAM_STR);
                    $res->bindValue(2, $_POST["descrizione"], PDO::PARAM_STR);
                    $res->bindValue(3, $_POST["qui va la foto"], PDO::PARAM_STR);
                    $res->bindValue(4, $_POST["numeroMaxPartecipanti"], PDO::PARAM_STR);
                    $res->bindValue(5, $email, PDO::PARAM_STR);

                    $res->execute();
                } catch (PDOException $e){
                    echo 'exception: '.$e;
                }
                $row = $res->fetch();
                $utenteP = $row[0];
                $res->closeCursor();
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
                            <div class="navbar-btn d-none d-sm-inline-block">
                                <ul style="margin-bottom: 0px; padding-left: 0px;">
                                    <li>
                                        <a class="btn primary-btn-outline" href="login.php"
                                        >Login</a
                                        >
                                    </li>
                                    <li>
                                        <a class="btn primary-btn" href="registrationUser.php"
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
        <div class="container-md" id="premio-container">

            Aggiungi un nuovo premio

            <form class="row g-3 needs-validation" id="login-form" method="post">
                <div class="col-12">

                </div>
                <div class="col-12">
                    <label class="form-label">Nome</label>
                    <input type="text" id="nome" name="nome" placeholder="Nome premio" required>

                </div>
                <div class="col-12">

                    <label class="form-label">descrizione</label>
                    <textarea class="form-control" id="descrizione" rows="3"></textarea>


                </div>
                <div class="col-12">

                    <label class="form-label">Punti</label>
                    <input type="number" class="form-range" max="100" min="1" id="customRange2" name="numeroMaxPartecipanti" width="50" style="width: 100px" required>

                </div>

                <div class="col-12">

                    <input type="file" name="image">
                    <input type="submit" value="Carica immagine">


                    <?php
                        if(isset($_POST["submit"])) {
                            $target_dir = "uploads/";
                            $target_file = $target_dir . basename($_FILES["image"]["name"]);
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                            // Verifica se il file selezionato è un'immagine
                            $check = getimagesize($_FILES["image"]["tmp_name"]);
                            if($check === false) {
                                echo "Il file selezionato non è un'immagine.";
                                exit();
                            }

                            // Verifica se l'immagine rispetta le dimensioni e il tipo consentiti
                            if ($_FILES["image"]["size"] > 5000000 || $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                                echo "Sono consentiti solo file di tipo JPG, JPEG, PNG e GIF di dimensioni massime di 5MB.";
                                exit();
                            }

                            // Sposta l'immagine dalla sua posizione temporanea alla sua posizione definitiva sul server
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                echo "L'immagine ". basename( $_FILES["image"]["name"]). " è stata caricata con successo.";
                            } else {
                                echo "Si è verificato un errore durante il caricamento dell'immagine.";
                            }
                        }
                    ?>


                </div>
                <div id="premio-btn-container">
                    <button class="btn btn-primary" type="submit" name="buttonAggiungi">Aggiungi</button>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    </body>
</html>
