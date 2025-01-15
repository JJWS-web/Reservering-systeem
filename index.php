<?php

require 'source/autoloader.php';
require 'source/ulid.php';

$autoloader = new ToanoLoader();

try {

    $autoloader->loadConnection();

   


    $UlidGenerator = new UlidGenerator();
    $ulid = $UlidGenerator->getUlid();
    echo "Generated ULID: $ulid\n";

    $db = new ToanoConnect();


    $pdo = $db->getConfig();

   
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
