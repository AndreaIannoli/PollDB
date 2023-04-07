<?php
    function checkEmail($email, PDO $pdo) {

        try {
            $sql = "CALL CheckEmail(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->execute();
            $count = $res->fetch();
            if($count[0]>0){
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL CheckEmail() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function checkCredentials($email, $password, PDO $pdo) {
        try {
            $sql = "CALL CheckCredentials(?, ?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->bindValue( 2, $password, PDO::PARAM_STR);
            $res->execute();
            $count = $res->fetch();
            if($count[0]>0){
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL CheckCredentials() non riuscita. Errore: ".$e->getMessage());
            exit();
        }

    }
?>
