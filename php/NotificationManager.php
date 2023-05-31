<?php
    function getUserNotifications($email, PDO $pdo) {
        try {
            $sql = 'CALL GetUserNotifica(?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $email, PDO::PARAM_STR);
            $res->execute();
        } catch (PDOException $e){
            echo("[ERRORE] Query SQL GetUserNotifica() non riuscita. Errore: ".$e->getMessage());
            exit();
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
            echo("[ERRORE] Query SQL getNotificationType() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function getInvitePollCode($InviteCode, PDO $pdo){
        try {
            $sql = 'CALL returnCodiceSondaggioInvito(?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $InviteCode, PDO::PARAM_STR);
            $res->execute();
            return $res->fetch()[0];
        } catch (PDOException $e){
            echo("[ERRORE] Query SQL returnCodiceSondaggioInvito() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function getNotificationPrize($notificationCode, PDO $pdo){
        try {
            $sql = 'CALL ReturnNotificationPrize(?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $notificationCode, PDO::PARAM_STR);
            $res->execute();
            return $res;
        } catch (PDOException $e){
            echo("[ERRORE] Query SQL ReturnNotificationPrize() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
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
            echo("[ERRORE] Query SQL getInvitePollCode() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
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

    function archiveNotification($notificationCode, PDO $pdo){
        try {
            if(getNotificationType($notificationCode, $pdo) != "Invito") {
                $sql = "CALL ArchiveNotifica(?)";
                $res = $pdo->prepare($sql);
                $res->bindValue(1, $notificationCode, PDO::PARAM_STR);
                $res->execute();
            } else {
                denyInvite($notificationCode, $pdo);
            }
        } catch (PDOException $e) {
            echo("[ERRORE] Query SQL ArchiveNotifica() non riuscita. Errore: ".$e->getMessage());
            exit();
        }
    }

    function navBarCheck(PDO $pdo){
        if(isset($_POST['AcceptInvite'])){
            acceptInvite($_POST['AcceptInvite'], $pdo);
            unset($_POST['AcceptInvite']);
        } else if(isset($_POST['DenyInvite'])) {
            denyInvite($_POST['DenyInvite'], $pdo);
            unset($_POST['DenyInvite']);
        } else if(isset($_POST['toArchive'])){
            archiveNotification($_POST['toArchive'], $pdo);
            unset($_POST['toArchive']);
        }
    }
?>
