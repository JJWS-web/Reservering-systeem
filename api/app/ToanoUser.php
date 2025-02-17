<?php

class ToanoUser {
    private $pdo;

    public function __construct()
    {
        $this->pdo = ToanoConnect::connect();
    }

    public function create($mail, $password) {
        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO user (mail, password) VALUES (:mail, :password)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':mail', $mail);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                $this->pdo->commit();
                return $mail;
            } else {
                throw new Exception("Failed to create user: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function read($mail) {
        $sql = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($mail, $password) {
        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE user SET password = :password WHERE mail = :mail";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':mail', $mail);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                $this->pdo->commit();
                return true;
            } else {
                throw new Exception("Failed to update user: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function delete($mail) {
        try {
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM user WHERE mail = :mail";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':mail', $mail);

            if ($stmt->execute()) {
                $this->pdo->commit();
                return true;
            } else {
                throw new Exception("Failed to delete user: " . implode(", ", $stmt->errorInfo()));
            }
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    public function emailExists($mail) {
        $sql = "SELECT COUNT(*) FROM user WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
    public function login($mail, $password) {
        $user = $this->read($mail);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user'] = $user;
            return [
                'success' => true,
                'message' => 'Login successful.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Invalid email or password.'
            ];
        }
    }
}
