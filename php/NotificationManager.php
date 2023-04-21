<?php
    function getUserNotifications($email, PDO $pdo) {
        try {
            $sql = 'CALL GetUserNotifica(?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $email, PDO::PARAM_STR);
            $res->execute();
        } catch (PDOException $e){
            echo 'exception: '.$e;
        }
        return $res;
    }

    function getNotificationType($notificationCode, PDO $pdo){
        try {
            $sql = 'CALL GetNotificationType(?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $notificationCode, PDO::PARAM_STR);
            $res->execute();
            return $res;
        } catch (PDOException $e){
            echo 'exception: '.$e;
        }
        return $res;
    }

    function getInvitePollCode($InviteCode, PDO $pdo){
        try {
            $sql = 'CALL returnCodiceSondaggioInvito(?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $InviteCode, PDO::PARAM_STR);
            $res->execute();
            return $res->fetch()[0];
        } catch (PDOException $e){
            echo 'exception: '.$e;
        }
        return $res;
    }

    function getInvitePoll($InviteCode, PDO $pdo){
        $res = null;
        try {
            $pollCode = getInvitePollCode($InviteCode, $pdo);
            $sql = 'CALL returnSondaggio(?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $pollCode, PDO::PARAM_STR);
            $res->execute();
            return $res;
        } catch (PDOException $e){
            echo 'exception: '.$e;
        }
        return $res;
    }

    function acceptInvite($notificationCode, PDO $pdo){
        try {
            $sql = "CALL AcceptInvito(?)";
            $res = $pdo->prepare($sql);
            $res->bindValue( 1, $notificationCode, PDO::PARAM_STR);
            $res->execute();
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL AcceptInvito() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

function denyInvite($notificationCode, PDO $pdo){
    try {
        $sql = "CALL DenyInvito(?)";
        $res = $pdo->prepare($sql);
        $res->bindValue( 1, $notificationCode, PDO::PARAM_STR);
        $res->execute();
    } catch (PDOException $e) {
        echo("[ERRORE] Query SQL DenyInvito() non riuscita. Errore: ".$e->getMessage());
        exit();
    }
}
?>
