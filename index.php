<?php

require 'source/autoloader.php';


$autoloader = new ToanoLoader();

try {
  

     // Create a new reservation
     $reservation = new ToanoReservation();
    
 
     // Read the reservation
     $reservationData = $reservation->read('01JKTJQEDSJFMC7F0E1A2BFKK4');
 
     if ($reservationData) {
         echo "Reservation data: " . print_r($reservationData, true) . "\n";
     } else {
         echo "Failed to read reservation.\n";
     }
   

} catch (Exception $e) {
    echo $e->getMessage();
}
?>