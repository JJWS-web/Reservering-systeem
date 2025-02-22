<?php

require_once '../source/ulid.php';

class ToanoPerson {

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
     * creates a person by generating a ulid and inserting the ulid, first name, preposition, last name and phone number into the database
     * and returns the ulid
     */

    public function create($firstName, $preposition, $lastName, $phoneNumber) {
        try {
            $personUlid = $this->ulidGenerator->getUlid();

            $sql = "INSERT INTO person (ulid, firstname, preposition, lastname, phonenumber) 
                    VALUES (:ulid, :firstname, :preposition, :lastname, :phonenumber)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ulid', $personUlid);
            $stmt->bindParam(':firstname', $firstName);
            $stmt->bindParam(':preposition', $preposition);
            $stmt->bindParam(':lastname', $lastName);
            $stmt->bindParam(':phonenumber', $phoneNumber);

            if ($stmt->execute()) {
                return $personUlid;  
            } else {
                throw new Exception("Failed to create person: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $e) {
            error_log("❌ ToanoPerson::create ERROR: " . $e->getMessage());
            return false;
        }
    }

    /**
     * reads a person by selecting the person from the database 
     * and returns the result
     */

    public function read($ulid) {
        $sql = "SELECT * FROM person WHERE ulid = :ulid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $ulid);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        }

        error_log("Failed to read person: " . implode(", ", $stmt->errorInfo()));
        return null;
    }

    /**
     * updates a person by updating the first name, preposition, last name and phone number in the database
     * and returns true if the update was successful
     */

    public function update($ulid, $firstName, $lastName, $phoneNumber, $preposition = null) {
        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE person SET firstname = :firstname, preposition = :preposition, lastname = :lastname, phonenumber = :phonenumber WHERE ulid = :ulid";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ulid', $ulid);
            $stmt->bindParam(':firstname', $firstName);
            $stmt->bindParam(':preposition', $preposition);
            $stmt->bindParam(':lastname', $lastName);
            $stmt->bindParam(':phonenumber', $phoneNumber);

            if ($stmt->execute()) {
                $this->pdo->commit();
                return true;
            } else {
                throw new Exception("Failed to update person: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * deletes a person by deleting the person from the database
     * and returns true if the delete was successful
     */
    
    public function delete($ulid) {
        try {
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM person WHERE ulid = :ulid";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ulid', $ulid);

            if ($stmt->execute()) {
                $this->pdo->commit();
                return true;
            } else {
                throw new Exception("Failed to delete person: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
}