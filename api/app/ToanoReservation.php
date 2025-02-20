<?php

require_once '../source/ulid.php';

class ToanoReservation {
    private $pdo;
    private $ulidGenerator;

    public function __construct()
    {
        $this->pdo = ToanoConnect::connect();
        $this->ulidGenerator = new UlidGenerator();
    }

    public function create($customerUlid, $start, $end, $title, $description) {
        try {
            $this->pdo->beginTransaction();

            
            $reservationUlid = $this->ulidGenerator->getUlid();

            $sql = "INSERT INTO reservation (ulid, customer_ulid, start, end, title, description) 
                    VALUES (:ulid, :customer_ulid, :start, :end, :title, :description)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ulid', $reservationUlid);
            $stmt->bindParam(':customer_ulid', $customerUlid);
            $stmt->bindParam(':start', $start);
            $stmt->bindParam(':end', $end);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);

            if ($stmt->execute()) {
                $this->pdo->commit(); 
                return $reservationUlid; 
            } else {
                $this->pdo->rollBack(); 
                error_log("Failed to create reservation: " . implode(", ", $stmt->errorInfo()));
                return false;
            }
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function read($ulid) {
        $sql = "SELECT * FROM reservation WHERE ulid = :ulid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ulid', $ulid);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                error_log("Reservation not found with ULID: $ulid");
                return null;
            }
        }

        error_log("Failed to read reservation: " . implode(", ", $stmt->errorInfo()));
        return null;
    }

    public function update($ulid, $customerUlid, $start, $end, $title, $description) {
        try {
            $this->pdo->beginTransaction(); 

            $sql = "UPDATE reservation 
                    SET customer_ulid = :customer_ulid, start = :start, end = :end, title = :title, description = :description 
                    WHERE ulid = :ulid";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ulid', $ulid);
            $stmt->bindParam(':customer_ulid', $customerUlid);
            $stmt->bindParam(':start', $start);
            $stmt->bindParam(':end', $end);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);

            if ($stmt->execute()) {
                $this->pdo->commit(); 
                return true;
            } else {
                $this->pdo->rollBack();
                error_log("Failed to update reservation: " . implode(", ", $stmt->errorInfo()));
                return false;
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

            $sql = "DELETE FROM reservation WHERE ulid = :ulid";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ulid', $ulid);

            if ($stmt->execute()) {
                $this->pdo->commit();
                return true;
            } else {
                $this->pdo->rollBack(); 
                error_log("Failed to delete reservation: " . implode(", ", $stmt->errorInfo()));
                return false;
            }
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
}