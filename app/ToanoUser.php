<?php



class ToanoUser {
    private $pdo;

    public function __construct()
    {
       
        $this->pdo = ToanoConnect::connect();
    }

    public function create($mail, $password) {
        $sql = "INSERT INTO user (mail, password) VALUES (:mail, :password)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':mail', $mail);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Secure password hashing
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to create user: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public function read($mail) {
        $sql = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail', $mail);

        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                return $user;
            } else {
                error_log("User not found with mail: $mail");
                return null;
            }
        }
        
        error_log("Failed to read user: " . implode(", ", $stmt->errorInfo()));
        return null;
    }

    public function update($mail, $password) {
        $sql = "UPDATE user SET password = :password WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail', $mail);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to update user: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public function delete($mail) {
        $sql = "DELETE FROM user WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail', $mail);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to delete user: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public function verifyPassword($mail, $password) {
        $user = $this->read($mail);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }

        error_log("Password verification failed for user: $mail");
        return false;
    }
}
