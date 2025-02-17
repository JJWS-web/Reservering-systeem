<?php

require_once 'source/autoloader.php';

try {
    // Initialize the autoloader
    $autoloader = new ToanoLoader();

    // Create a new user instance
    $user = new ToanoUser();

    // Attempt to log in
    $loginResult = $user->login('heysss12a@gmail.com', 'password123');

    if ($loginResult['success']) {
        echo "✅ " . $loginResult['message'] . "\n";
    } else {
        throw new Exception($loginResult['message']);
    }

} catch (Exception $e) {
    echo "❌ " . $e->getMessage();
}
?>