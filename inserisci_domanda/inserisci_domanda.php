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

    $max_caratteri = $_POST['max_caratteri'];
    $testoDomanda = $_POST['testoDomanda'];
    $punteggioDomanda = $_POST['punteggioDomanda'];
    $tipologiaDomanda = $_POST['tipologiaDomanda'];
    $urlfoto = $_POST['urlfoto'];

    $opzione1 = $_POST['opzione1'];
    $opzione2 = $_POST['opzione2'];
    $opzione3 = $_POST['opzione3'];
    $opzione4 = $_POST['opzione4'];





    if ($_POST['tipologiaDomanda'] == 'APERTA') {

      try{
        $sql="CALL InserisciDomandaAperta('$testoDomanda', '$punteggioDomanda', '$urlfoto', '$max_caratteri')";
        $res=$pdo->exec($sql);
      } catch (PDOException $e) {
        echo("[Abbiamo un problema: " . $e->getMessage());
        throw $e;
      }

    } else {

      try{
        $sql="CALL InserisciDomandaChiusa('$testoDomanda', '$punteggioDomanda', '$urlfoto', '$opzione1', '$opzione2', '$opzione3', '$opzione4')";
        $res=$pdo->exec($sql);
      } catch (PDOException $e) {
        echo("Abbiamo un problema: " . $e->getMessage());
        throw $e;
      }
      
    }

   
  


?>