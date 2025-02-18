<?php

//header('Content-Type: application/json');

require_once 'source/autoloader.php';

try {
   
    $autoloader = new ToanoLoader();
    
    $user = new ToanoUser();

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['mail']) || !isset($input['password'])) {
        throw new Exception("Missing email or password");
    }

    $loginResult = $user->login($input['mail'], $input['password']);


    echo json_encode($loginResult);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
