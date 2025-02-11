<?php

require 'source/ulid.php';

class ToanoPerson {
    private $pdo;

    public function __construct()
    {
        $this->pdo = ToanoConnect::connect();
    }

    public function create($firstname, $lastname, $phonenumber, $preposition = null) {
        // Generate a ULID
        $ulidGenerator = new UlidGenerator();
        $ulid = $ulidGenerator->getUlid();

        $sql = "INSERT INTO person (ulid, firstname, preposition, lastname, phonenumber) VALUES (:ulid, :firstname, :preposition, :lastname, :phonenumber)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $ulid);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':preposition', $preposition);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':phonenumber', $phonenumber);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to create person: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public function read($ulid) {
        $sql = "SELECT * FROM person WHERE ulid = :ulid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $ulid);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                error_log("Person not found with ULID: $ulid");
                return null;
            }
        }

        error_log("Failed to read person: " . implode(", ", $stmt->errorInfo()));
        return null;
    }

    public function update($ulid, $firstname, $lastname, $phonenumber, $preposition = null) {
        $sql = "UPDATE person SET firstname = :firstname, preposition = :preposition, lastname = :lastname, phonenumber = :phonenumber WHERE ulid = :ulid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $ulid);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':preposition', $preposition);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':phonenumber', $phonenumber);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to update person: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public function delete($ulid) {
        $sql = "DELETE FROM person WHERE ulid = :ulid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $ulid);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to delete person: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }
}