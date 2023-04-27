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

    function checkFiscalCode($fiscalCode, PDO $pdo) {
        try {
            $sql = "CALL CheckFiscalCode(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $fiscalCode, PDO::PARAM_STR);
            $res->execute();
            $count = $res->fetch();
            if($count[0]>0){
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL CheckFiscalCode() non riuscita. Errore: ".$e->getMessage());
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

    function getUser($email, PDO $pdo) {
        try {
            $sql = "CALL ReturnUtente(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->execute();
            return $res;
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL ReturnUtente() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function getName($email, PDO $pdo) {
        try {
            $sql = "CALL ReturnName(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->execute();
            return $res->fetch()['Nome'];
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL ReturnName() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function getAzienda($codice, PDO $pdo) {
        try {
            $sql = "CALL ReturnAzienda(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $codice, PDO::PARAM_STR);
            $res->execute();
            return $res;
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL ReturnAzienda() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function getPollCreator($pollCode, PDO $pdo) {
        try {
            $sql = "CALL ReturnPollCreator(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $pollCode, PDO::PARAM_INT);
            $res->execute();
            return $res;
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL ReturnPollCreator() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function getProPic($email, PDO $pdo){
        try {
            $sql = "CALL ReturnProPic(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->execute();
            return $res->fetch()['UrlFoto'];
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL ReturnProPic() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function checkType($email, PDO $pdo){
        try {
            $sql = "CALL ReturnUserType(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->execute();
            return $res->fetch()['Tipo'];
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL ReturnUserType() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

?>
