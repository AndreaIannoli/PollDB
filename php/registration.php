<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PollDB - Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/registration.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
    <?php
        require "connectionManager.php";
        require "accountManager.php";

        $pdo = connectToDB();
        $emailInserted = false;
        $passInserted = false;
        $ageInserted = false;
        $checkEmailRes = true;
        $checkPassRes = false;
        $checkAgeRes = false;

        function checkPasswordLength($pass){
            if(strlen($pass) >= 8){
                return true;
            } else {
                return false;
            }
        }

        function checkAge($date){
            $minimumYear  = date("Y") - 18;
            $minimumMonth = date("m");
            $minimumDay = date("d");
            if(date('Y', strtotime($date)) <= $minimumYear and date('m', strtotime($date)) <= $minimumMonth and date('d', strtotime($date)) <= $minimumDay){
                return true;
            } else {
                return false;
            }
        }

        $emailInserted = isset($_POST['email']);
        if($emailInserted){
            $checkEmailRes = checkEmail($_POST['email'], $pdo);
        }

        $passInserted = $_POST['password'];
        if($passInserted){
            $checkPassRes = checkPasswordLength($_POST['password']);
        }

        $ageInserted = isset($_POST['date']);
        if($ageInserted){
            $checkAgeRes = checkAge($_POST['age']);
        }

        if(!$checkEmailRes and $checkPassRes and $checkAgeRes){
            $sql = 'CALL RegistrazioneUtenteSemplice(?, ?, ?, ?, ?, ?, ?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $_POST['email'], PDO::PARAM_STR);
            $res->bindValue(2, $_POST['password'], PDO::PARAM_STR);
            $res->bindValue(3, $_POST['name'], PDO::PARAM_STR);
            $res->bindValue(4, $_POST['surname'], PDO::PARAM_STR);
            $res->bindValue(5, $_POST['date'], PDO::PARAM_STR);
            $res->bindValue(6, $_POST['placeOfBirth'], PDO::PARAM_STR);
            $res->bindValue(7, 0, PDO::PARAM_INT);
            $res->execute();
            session_start();
            $_SESSION['authorized'] = 1;
            $_SESSION['loggedEmail'] = $_POST['email'];
            header("domainChoice.php");
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
                                <a class="btn primary-btn" href="registration.php"
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
<div class="container-md" id="login-container">
    <img src="../img/logoPollDBBlack.png" class="img-fluid" alt="...">
    <form class="row g-3 needs-validation" id="login-form" method="post">
        <div class="col-12">
            <label for="email">Email</label>
            <input type="email" <?php
                if($emailInserted and !$checkEmailRes){
                    echo("class='form-control is-valid'");
                } else if($emailInserted) {
                    echo("class='form-control is-invalid'");
                } else {
                    echo("class='form-control'");
                }
            ?> id="email" name="email" placeholder="Email" required>
            <div class="valid-feedback">
                Email valida!
            </div>
            <div class="invalid-feedback">
                Email non valida o già in uso!
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Password</label>
            <input type="password" <?php
                if($passInserted and $checkPassRes){
                    echo("class='form-control is-valid'");
                } else if($passInserted) {
                    echo("class='form-control is-invalid'");
                } else {
                    echo("class='form-control'");
                }
            ?>class="form-control" id="password" name="password" placeholder="Password" required>
            <div class="valid-feedback">
                Password valida!
            </div>
            <div class="invalid-feedback">
                Password non valida! (ATTENZIONE: La password deve essere lunga almeno 8 caratteri)
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nome" required>
            <div class="valid-feedback">
                Nome valido!
            </div>
            <div class="invalid-feedback">
                Nome non valido!
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Cognome</label>
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Cognome" required>
            <div class="valid-feedback">
                Cognome valido!
            </div>
            <div class="invalid-feedback">
                Congnome non valido!
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Luogo di nascita</label>
            <input type="text" class="form-control" id="placeOfBirth" name="placeOfBirth" placeholder="Luogo di nascita" required>
            <div class="valid-feedback">
                Luogo di nascita valido!
            </div>
            <div class="invalid-feedback">
                Luogo di nascita non valido!
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Anno di nascita</label>
            <div class="input-group date">
                <input type="date" <?php
                    if($ageInserted and $checkAgeRes){
                        echo("class='form-control is-valid'");
                    } else if($ageInserted) {
                        echo("class='form-control is-invalid'");
                    } else {
                        echo("class='form-control'");
                    }
                ?>class="form-control" id="date" name="date" required>
            </div>
            <div class="valid-feedback">
                Anno di nascita valido!
            </div>
            <div class="invalid-feedback">
                Anno di nascita non valido!
            </div>
        </div>
        <div id="login-btn-container">
            <button class="btn btn-primary login-btn" type="submit">Registrati</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>
</html>

