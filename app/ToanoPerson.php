<?php

require_once 'source/ulid.php';

class ToanoPerson {
    private $pdo;
    private $ulidGenerator;

    public function __construct()
    {
        $this->pdo = ToanoConnect::connect();
        $this->ulidGenerator = new UlidGenerator();
    }

    public function create($firstname, $preposition, $lastname, $phonenumber) {
        try {
            $this->pdo->beginTransaction();

            // Generate a ULID
            $personUlid = $this->ulidGenerator->getUlid();

            $sql = "INSERT INTO person (ulid, firstname, preposition, lastname, phonenumber) 
                    VALUES (:ulid, :firstname, :preposition, :lastname, :phonenumber)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ulid', $personUlid);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':preposition', $preposition);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':phonenumber', $phonenumber);

            if ($stmt->execute()) {
                $this->pdo->commit(); 
                return $personUlid; 
            } else {
                throw new Exception("Failed to create person: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

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

    public function update($ulid, $firstname, $lastname, $phonenumber, $preposition = null) {
        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE person SET firstname = :firstname, preposition = :preposition, lastname = :lastname, phonenumber = :phonenumber WHERE ulid = :ulid";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ulid', $ulid);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':preposition', $preposition);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':phonenumber', $phonenumber);

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
