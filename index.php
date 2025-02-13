<?php

require_once 'source/autoloader.php';

try {
    // Initialize the autoloader
    $autoloader = new ToanoLoader();

    // Create a new customer and reservation
    $customer = new ToanoCustomer(); 
    $customerResult = $customer->createPersonUserCustomer(
        'Jayden', 'van', 'Do', '1234567890', 'test@gmail.com', 'password123'
    ); 

    if (!$customerResult['success']) {
        throw new Exception("Failed to insert customer: " . $customerResult['message']);
    } 

    echo "✅ Customer inserted successfully with ULID: " . $customerResult['customerUlid'] . "\n";

    $customerUlid = $customerResult['customerUlid'];

    $reservationResult = $customer->createCustomerReservation(
        $customerUlid,
        '2023-10-01 10:00:00',
        '2023-10-01 12:00:00',
        'coolss',
        'Project discussion'
    ); 

    if (!$reservationResult['success']) {
        throw new Exception("Failed to insert reservation: " . $reservationResult['message']);
    }

    echo "✅ Reservation inserted successfully with ULID: " . $reservationResult['reservationUlid'] . "\n";
    echo "✅ Customer ULID: " . $reservationResult['customerUlid'] . "\n";

} catch (Exception $e) {
    if (strpos($e->getMessage(), 'Email already exists') !== false) {
        echo "❌ Duplicate email error: " . $e->getMessage();
    } else {
        echo "❌ " . $e->getMessage();
    }
}
?>