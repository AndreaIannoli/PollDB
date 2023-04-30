<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PollDB - Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link href="../stylesheets/basicstyle.css" rel="stylesheet">
        <link href="../stylesheets/nav.css" rel="stylesheet">
        <link href="../stylesheets/button.css" rel="stylesheet">
        <link href="../stylesheets/login.css" rel="stylesheet">
    </head>
    <body>
        <?php
            require 'connectionManager.php';
            require 'accountManager.php';


            $pdo = connectToDB();
            $checkEmailRes = false;
            $checkPassRes = false;

            $emailInserted = isset($_POST['email']);
            $passwordInserted = isset($_POST['password']);

            if($emailInserted){
                $checkEmailRes = checkEmail($_POST['email'], $pdo);
            }

            if($passwordInserted and $checkEmailRes){
                $checkPassRes = checkCredentials($_POST['email'], $_POST['password'], $pdo);
                $tipo = checkType($_POST['email'],$pdo);
                if($checkPassRes){
                    session_start();
                    session_unset();
                    $_SESSION['authorized'] = 1;
                    $_SESSION['emailLogged'] = $_POST['email'];
                    $_SESSION['nameLogged'] = getName($_POST['email'], $pdo);
                    $_SESSION['userType'] = $tipo;
                    $_SESSION['userProPicURI'] = getProPic($_POST['email'], $pdo);
                    if($_SESSION['userType'] == 'Amministratore'){
                        header('Location: AdminDashboard.php');
                    } else {
                        header('Location: visualizza_sondaggi.php');
                    }
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
                                                href="/php/home.php"
                                        >
                                            Home
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
                                        <a class="btn primary-btn" href="registrationChoice.php"
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
                    <label class="form-label">Email</label>
                    <input type="text" <?php
                        if($emailInserted and $checkEmailRes){
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
                        Non risulta nessun account con questa email!
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Password</label>
                    <input type="password" <?php
                    if($passwordInserted and $checkPassRes){
                        echo("class='form-control is-valid'");
                    } else if($passwordInserted) {
                        echo("class='form-control is-invalid'");
                    } else {
                        echo("class='form-control'");
                    }
                    ?> id="password" name="password" placeholder="Password" required>
                    <div class="valid-feedback">
                        Password corretta!
                    </div>
                    <div class="invalid-feedback">
                        Password non corretta!
                    </div>
                </div>
                <div id="login-btn-container">
                    <button class="btn primary-btn" type="submit">Login</button>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    </body>
</html>
