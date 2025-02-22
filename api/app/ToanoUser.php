<?php

class ToanoUser {
       /**
     * declares a private property to store the pdo connection
     */
    private $pdo;

    /**
     * when an instance of the class is made it calls the connect method from the ToanoConnect class
     */
    public function __construct()
    {
        $this->pdo = ToanoConnect::connect();
    }

    /**
     * creates a user by inserting the mail and password into the database
     * and returns the mail
     */
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

    /**
     * reads a user by selecting the user from the database 
     * and returns the result
     */
    public function read($mail) {
        $sql = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * updates a user by updating the password in the database
     * and returns true if successful
     */
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

    /**
     * deletes a user by deleting the user from the database
     * and returns true if successful
     */

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

    /**
     * checks if the mail exists in the database
     * and returns true if it does
     */

    public function emailExists($mail) {
        $sql = "SELECT COUNT(*) FROM user WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * logs in a user by checking if the mail and password match
     * and returns a json object with the result
     */
    
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