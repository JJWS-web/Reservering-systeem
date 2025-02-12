<?php

require_once 'source/ulid.php';

class ToanoCustomer {
    private $pdo;
    private $ulidGenerator;

    public function __construct()
    {
        $this->pdo = ToanoConnect::connect();
        $this->ulidGenerator = new UlidGenerator();
    }

    public function create($personUlid, $userMail) {
        // Generate a ULID for the customer
        $customerUlid = $this->ulidGenerator->getUlid();

        $sql = "INSERT INTO customer (ulid, person_ulid, user_mail) VALUES (:ulid, :person_ulid, :user_mail)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $customerUlid);
        $stmt->bindParam(':person_ulid', $personUlid);
        $stmt->bindParam(':user_mail', $userMail);

        if ($stmt->execute()) {
            return $customerUlid; // Return the ULID of the newly created customer
        } else {
            error_log("Failed to create customer: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

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

    public function createPersonUserCustomer($firstname, $preposition, $lastname, $phonenumber, $mail, $password) {
        $person = new ToanoPerson();
        $personUlid = $person->create($firstname, $preposition, $lastname, $phonenumber);

        if (!$personUlid) {
            return false;
        }

        $user = new ToanoUser();
        $userMail = $user->create($mail, $password);

        if (!$userMail) {
            return false;
        }

        $customerUlid = $this->create($personUlid, $userMail);
        if (!$customerUlid) {
            return false;
        }

        return [
            'success' => true,
            'customerUlid' => $customerUlid
        ];
    }

    public function createCustomerReservation($firstname, $preposition, $lastname, $phonenumber, $mail, $password, $start, $end, $title, $description) {
        // Create a new customer with person and user
        $result = $this->createPersonUserCustomer($firstname, $preposition, $lastname, $phonenumber, $mail, $password);

        if (!$result['success']) {
            return false;
        }

        $customerUlid = $result['customerUlid'];

        // Create a new reservation for the customer
        $reservation = new ToanoReservation();
        $reservationUlid = $reservation->create($customerUlid, $start, $end, $title, $description);

        if (!$reservationUlid) {
            return false;
        }

        return [
            'success' => true,
            'reservationUlid' => $reservationUlid,
            'customerUlid' => $customerUlid
        ];
    }
}