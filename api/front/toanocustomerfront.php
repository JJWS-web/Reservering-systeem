<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../source/autoloader.php';

try {
    $autoloader = new ToanoLoader();
    $customer = new ToanoCustomer();

    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['firstname']) || !isset($input['lastname']) || !isset($input['mail']) || !isset($input['password']) || !isset($input['phonenumber'])) {
        throw new Exception("Missing required fields for registration");
    }
    die();

    $registerResult = $customer->register(
        $input['firstname'],
        $input['preposition'] ?? '',
        $input['lastname'],
        $input['phonenumber'],
        $input['mail'],
        $input['password']
    );

   

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}