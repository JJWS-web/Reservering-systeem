<?php

require 'source/ulid.php';

class ToanoCustomer {
    private $pdo;

    public function __construct()
    {
        $this->pdo = ToanoConnect::connect();
    }

    public function create($personUlid, $userMail) {
        // Generate a ULID for the customer
        $ulidGenerator = new UlidGenerator();
        $customerUlid = $ulidGenerator->getUlid();

        $sql = "INSERT INTO customer (ulid, person_ulid, user_mail) VALUES (:ulid, :person_ulid, :user_mail)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':ulid', $customerUlid);
        $stmt->bindParam(':person_ulid', $personUlid);
        $stmt->bindParam(':user_mail', $userMail);

        if ($stmt->execute()) {
            return true;
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
}