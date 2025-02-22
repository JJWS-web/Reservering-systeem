<?php


require_once __DIR__ . '/../source/autoloader.php';

  /**
     * this file is responsible for the registration of the user by calling
     * the register function from the ToanoCustomer class.
     * the input is received from the user and is checked if it is empty
     * if it is empty an exception is thrown.
     * json is used to encode the input and the result of the register function
     * is returned as a json object.
     */
try {
    $autoloader = new ToanoLoader();
    $customer = new ToanoCustomer();

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['firstname']) || !isset($input['lastname']) || !isset($input['mail']) || !isset($input['password']) || !isset($input['phonenumber'])) {
        throw new Exception("Missing required fields for registration");
    }

    $registerResult = $customer->register(
        $input['firstname'],
        $input['preposition'] ?? '',
        $input['lastname'],
        $input['phonenumber'],
        $input['mail'],
        $input['password']
    );

    ob_clean();
    echo json_encode($registerResult);
    exit;

} catch (Exception $e) {
    ob_clean();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
}