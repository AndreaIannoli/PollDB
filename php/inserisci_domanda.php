<?php
    require 'accountManager.php';
    require 'connectionManager.php';
    require 'NotificationManager.php';
    require 'LogsManager.php';
    $pdo = connectToDB();
    session_start();


    $max_caratteri = $_POST['max_caratteri'];
    $testoDomanda = $_POST['testoDomanda'];
    $punteggioDomanda = $_POST['punteggioDomanda'];
    $tipologiaDomanda = $_POST['tipologiaDomanda'];
    $urlfoto = $_POST['urlfoto'];

    $opzione1 = $_POST['opzione1'];
    $opzione2 = $_POST['opzione2'];
    $opzione3 = $_POST['opzione3'];
    $opzione4 = $_POST['opzione4'];

    $CodiceSondaggio = $_POST['CodiceSondaggio'];


    if ($_POST['tipologiaDomanda'] == 'APERTA') {

      try{
        $sql="CALL AddDomandaAperta('$testoDomanda', '$punteggioDomanda', '$urlfoto', '$max_caratteri', '$CodiceSondaggio')";
        $res=$pdo->exec($sql);
        insertLog("AddDomandaAperta", "Executed");
      } catch (PDOException $e) {
        echo("[Abbiamo un problema: " . $e->getMessage());
        insertLog("AddDomandaAperta", "Aborted");
        throw $e;
      }

    } else {

      try{
        $sql="CALL AddDomandaChiusa('$testoDomanda', '$punteggioDomanda', '$urlfoto', '$opzione1', '$opzione2', '$opzione3', '$opzione4','$CodiceSondaggio')";
        $res=$pdo->exec($sql);
        insertLog("AddDomandaChiusa", "Executed");
      } catch (PDOException $e) {
        echo("Abbiamo un problema: " . $e->getMessage());
        insertLog("AddDomandaChiusa", "Aborted");
        throw $e;
      }
      
    }

    //per tornare indietro una volta fatto tutto
    header('Location: visualizza_sondaggi.php');
    exit;

?>