<?php
    function getUserNotifications($email, PDO $pdo) {
        try {
            $sql = 'CALL GetUserNotifica(?)';
            $res = $pdo->prepare($sql);
            $res->bindValue(1, $email, PDO::PARAM_STR);
            $res->execute();
        } catch (PDOException $e){
            echo 'exception'.$e;
        }
        return $res;
    }
?>
