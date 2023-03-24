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

   #Questi paramentri sono statici ma dovremmo prenderli dalla pagina visualizza_domanda 
    $emailUtente = "Email";
    $IdDomanda = 13; #bisogna inserire l'id passato nell'url
    $tipologia = "APERTA";

    $testoRisposta = $_POST['testoRisposta'];


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
          $sql="CALL InserisciDomandaChiusa('$testoRisposta', '$IdDomanda', '$emailUtente')";
          $res=$pdo->exec($sql);
        } catch (PDOException $e) {
          echo("Abbiamo un problema: " . $e->getMessage());
          throw $e;
        }
        
      }

?>