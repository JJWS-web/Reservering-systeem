<?php

require_once 'source/autoloader.php';
  /**
     * this file is repsonible for the login of the user by calling
     * the login function from the ToanoUser class.
     * the input is received from the user and is checked if it is empty
     * if it is empty an exception is thrown.
     * json is used to encode the input and the result of the login function
     * is retuned as a json object.
     */
try {
    $autoloader = new ToanoLoader();
    $user = new ToanoUser();

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['mail']) || !isset($input['password'])) {
        throw new Exception("Missing email or password");
    }

    $loginResult = $user->login($input['mail'], $input['password']);

   
    ob_clean(); 
    echo json_encode($loginResult);
    exit;
    
} catch (Exception $e) {
   
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
}
