<?php

require_once 'source/autoloader.php';


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Initialize the autoloader
    $autoloader = new ToanoLoader();

    // Start a database transaction
    $pdo = ToanoConnect::connect();
    $pdo->beginTransaction();

    // Create a new customer and reservation
    $customer = new ToanoCustomer();
    $result = $customer->createCustomerReservation(
        'Jayden', 'van', 'Do', '1234567890', 'test1234@gmail.com', 'password123',
        '2023-10-01 10:00:00',
        '2023-10-01 12:00:00',
        'cool',
        'Project discussion'
    );

    if (!$result['success']) {
        throw new Exception("Failed to insert reservation.");
    }

    echo "✅ Reservation inserted successfully with ULID: " . $result['reservationUlid'] . "\n";
    echo "✅ Customer ULID: " . $result['customerUlid'] . "\n";

    // Commit the transaction
    $pdo->commit();

} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $pdo->rollBack();
    echo "❌ " . $e->getMessage();
}
?>