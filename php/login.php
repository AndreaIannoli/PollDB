<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PollDB - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../stylesheets/login.css" rel="stylesheet">
</head>
<body>
    <?php
    try {
        $pdo=new PDO('mysql:host=localhost;dbname=PollDB','root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo("[ERRORE] Connessione al DB non riuscita. Errore: ".$e->getMessage());
        exit();
    }
    ?>
    <div class="container-md" id="login-container">
        <img src="../img/logoPollDB.png" class="img-fluid" alt="...">
        <form class="row g-3 needs-validation" id="login-form">
            <div class="col-12">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Username" required>
                <div class="valid-feedback">
                    Username valido!
                </div>
                <div class="invalid-feedback">
                    Username non valido!
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">Password</label>
                <input type="text" class="form-control" id="password" placeholder="Password" required>
                <div class="valid-feedback">
                    Password corretta!
                </div>
                <div class="invalid-feedback">
                    Password non corretta!
                </div>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck">
                    <label class="form-check-label">
                        Ricordami
                    </label>
                    <div class="invalid-feedback">
                        You must agree before submitting.
                    </div>
                </div>
            </div>
            <div id="login-btn-container">
                <button class="btn btn-primary" type="submit">Login</button>
            </div>
        </form>
    </div>
    <h1>Hello, world!</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>
</html>
