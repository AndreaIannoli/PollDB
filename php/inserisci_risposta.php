<?php
    require 'accountManager.php';
    require 'connectionManager.php';
    require 'NotificationManager.php';
    require 'LogsManager.php';
    $pdo = connectToDB();

    session_start();
    $emailUtente = $_SESSION['emailLogged'];
    $IdDomanda = $_POST['IdDomanda'];
    $tipologia = $_POST['tipologia'];

    $testoRisposta = $_POST['testoRisposta'];
    $selections = $_POST['selections'];


    if ($tipologia == 'APERTA') {

        try{
          $sql="CALL AddRispostaAperta('$testoRisposta', '$IdDomanda', '$emailUtente')";
          $res=$pdo->exec($sql);
          insertLog("AddRispostaAperta", "Executed");
        } catch (PDOException $e) {
          echo("[Abbiamo un problema: " . $e->getMessage());
          insertLog("AddRispostaAperta", "Aborted");
          throw $e;
        }
  
      } else {
  
        try{
            $risposta = "";
            foreach($selections as $selection) {
                $risposta .= $selection . "\n";
            }
            $sql="CALL AddRispostaChiusa('$risposta', '$IdDomanda', '$emailUtente')";
            $res=$pdo->exec($sql);
            insertLog("AddRispostaChiusa", "Executed");
        } catch (PDOException $e) {
          echo("Abbiamo un problema: " . $e->getMessage());
          insertLog("AddRispostaChiusa", "Aborted");
          throw $e;
        }
        
      }

      //per tornare indietro una volta fatto tutto
      header('Location: visualizza_sondaggi.php');
      exit;

?>