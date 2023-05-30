<?php
    $m = new MongoDB\Driver\Manager("mongodb://localhost:27017");

    $dbName = 'PollDB';
    $collection = 'Logs';


    function insertLog($action, $result){
        $document = array(
            "Data" => date('Y/m/d H:i:s'),
            "Azione" => "$action",
            "Esito" => "$result"
        );
        $bulkWrite = new MongoDB\Driver\BulkWrite;
        $bulkWrite->insert($document);
        global $m,$dbName,$collection;
        $m->executeBulkWrite("$dbName.$collection", $bulkWrite);
    }
?>
