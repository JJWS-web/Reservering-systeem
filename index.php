<?php

require_once 'db_connection.php';

try {
    
    $db = new ToanoConnect();


    $pdo = $db->getConfig();

   
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
