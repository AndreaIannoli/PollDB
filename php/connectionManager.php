<?php
    function connectToDB(){
        $host = "localhost";
        $dbName = "PollDB";
        $username = "root";
        $pass = "root";
        try {
            $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $username, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
            exit();
        }
    }
?>
