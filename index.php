<?php

require 'source/autoloader.php';


$autoloader = new ToanoLoader();

try {
    // Manually load the database connection
    // $autoloader->loadDBConnection(); 

    $autoloader->app_Loader();
    $autoloader->source_Loader();

    // Create a new user
    $user = new ToanoUser();
    $result = $user->create('yaboypforlife@gmail.com', 'password123');

    if ($result) {
        echo "User inserted successfully.\n";
    } else {
        echo "Failed to insert user.\n";
    }

    // Generate a ULID
    $ulidGenerator = new UlidGenerator();
    $ulid = $ulidGenerator->getUlid();
    echo "Generated ULID: $ulid\n";

} catch (Exception $e) {
    echo $e->getMessage();
}
?>