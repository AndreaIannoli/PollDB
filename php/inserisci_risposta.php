<?php

    $host = "localhost:3306";
    $dbName = "PollDB";
    $username = "root";
    $pass = "PollDB";
    try {
        $pdo = new PDO('mysql:host='.$host.';dbname='.$dbName, $username, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo("[ERRORE] Connessione al DB non riuscita. Errore: " . $e->getMessage());
        throw $e;
    }

    session_start();
    $emailUtente = $_SESSION['emailLogged'];
    $IdDomanda = $_POST['IdDomanda'];
    $tipologia = $_POST['tipologia'];

    $testoRisposta = $_POST['testoRisposta'];
    $selections = $_POST['selections'];


    if ($tipologia == 'APERTA') {

        try{
          $sql="CALL InserisciRispostaAperta('$testoRisposta', '$IdDomanda', '$emailUtente')";
          $res=$pdo->exec($sql);
        } catch (PDOException $e) {
          echo("[Abbiamo un problema: " . $e->getMessage());
          throw $e;
        }
  
      } else {
  
        try{
            $risposta = "";
            foreach($selections as $selection) {
                $risposta .= $selection . "\n";
            }
            $sql="CALL InserisciRispostaChiusa('$risposta', '$IdDomanda', '$emailUtente')";
            $res=$pdo->exec($sql); 
        } catch (PDOException $e) {
          echo("Abbiamo un problema: " . $e->getMessage());
          throw $e;
        }
        
      }

      header('Location: ' . $_SERVER['HTTP_REFERER']);

?>