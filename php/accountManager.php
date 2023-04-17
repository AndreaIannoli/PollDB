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
<<<<<<< HEAD
=======
    }

    function getUser($email, PDO $pdo) {
        try {
            $sql = "CALL ReturnUtente(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $email, PDO::PARAM_STR);
            $res->execute();
            return $res;
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL returnUser() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
>>>>>>> 0958797 (Random Invite users)
    }

    function checkType($email, PDO $pdo){
        $sql="SELECT * FROM Azienda WHERE IndirizzoEmail='$email'";
        $res=$pdo->query($sql);
        if($res->rowCount() > 0){
            return "Azienda";
        }else{
            $sql="SELECT * FROM UtentePremium WHERE Emailutente='$email'";
            $res=$pdo->query($sql);
            if($res->rowCount() > 0){
                return "Premium";
            }else{
                return "Utente";
            }
        }
    }

?>
