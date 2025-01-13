<?php

require_once 'db_connection.php';

try {
    // Instantiate the Database class
    $db = new ToanoConnect();

    // Get the PDO connection
    $pdo = $db->getConfig();

   
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
