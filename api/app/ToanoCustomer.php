<?php

require_once '../source/ulid.php';

class ToanoCustomer {
      /**
     * declares a private property to store the pdo connection
     * and an instance of the UlidGenerator class
     */
    private $pdo;
    private $ulidGenerator;

  /**
     * when an instance of the class is made it calls the connect method from the ToanoConnect class
     * and creates an instance of the UlidGenerator class
     */

    public function __construct()
    {
        $this->pdo = ToanoConnect::connect();
        $this->ulidGenerator = new UlidGenerator();
    }

      /**
     * creates a customer by generating a ulid and inserting the ulid, person ulid and user mail into the database
     * and returns the ulid
     */
    public function create($personUlid, $userMail) {
        $customerUlid = $this->ulidGenerator->getUlid();

        $sql = "INSERT INTO customer (ulid, person_ulid, user_mail) VALUES (:ulid, :person_ulid, :user_mail)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $customerUlid);
        $stmt->bindParam(':person_ulid', $personUlid);
        $stmt->bindParam(':user_mail', $userMail);

        if ($stmt->execute()) {
            return $customerUlid; 
        } else {
            error_log("Failed to create customer: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

      /**
     * reads a customer by selecting the customer from the database 
     * and returns the result
     */

    public function read($customerUlid) {
        $sql = "SELECT * FROM customer WHERE ulid = :ulid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $customerUlid);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                error_log("Customer not found with ULID: $customerUlid");
                return null;
            }
        }

        error_log("Failed to read customer: " . implode(", ", $stmt->errorInfo()));
        return null;
    }

        /**
         * updates a customer by updating the person ulid and user mail in the database
         * and returns true if the update was successful
         */

    public function update($customerUlid, $personUlid, $userMail) {
        $sql = "UPDATE customer SET person_ulid = :person_ulid, user_mail = :user_mail WHERE ulid = :ulid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $customerUlid);
        $stmt->bindParam(':person_ulid', $personUlid);
        $stmt->bindParam(':user_mail', $userMail);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to update customer: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

        /**
         * deletes a customer by deleting the customer from the database
         * and returns true if the delete was successful
         */
    public function delete($customerUlid) {
        $sql = "DELETE FROM customer WHERE ulid = :ulid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $customerUlid);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to delete customer: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

        /**
         * registers a customer by calling the create method from the ToanoPerson class
         * and the create method from the ToanoUser class
         * and the create method from this class
         * and returns a json object with the result
         */

    public function register($firstName, $preposition, $lastName, $phoneNumber, $mail, $password) {
        try {
            $this->pdo->beginTransaction();
    
            $person = new ToanoPerson();
            $personUlid = $person->create($firstName, $preposition, $lastName, $phoneNumber);
    
            if (!$personUlid) {
                throw new Exception("Failed to create person.");
            }
    
            $user = new ToanoUser();
            $userMail = $user->create($mail, $password);
    
            if (!$userMail) {
                throw new Exception("Failed to create user.");
            }
    
            $customerUlid = $this->create($personUlid, $userMail);
            if (!$customerUlid) {
                throw new Exception("Failed to create customer.");
            }
    
            $this->pdo->commit();  
    
            return [
                'success' => true,
                'customerUlid' => $customerUlid
            ];
        } catch (Exception $e) {
            $this->pdo->rollBack();  
            error_log($e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
      /**
     * creates a customer reservation by calling the create method from the ToanoReservation class
     * and returns a json object with the result
     */

    public function createCustomerReservation($customerUlid, $start, $end, $title, $description) {
        $reservation = new ToanoReservation();
        $reservationUlid = $reservation->create($customerUlid, $start, $end, $title, $description);

        if (!$reservationUlid) {
            return [
                'success' => false,
                'message' => 'Failed to create reservation.'
            ];
        }

        return [
            'success' => true,
            'reservationUlid' => $reservationUlid,
            'customerUlid' => $customerUlid
        ];
    }
}