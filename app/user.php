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
        $stmt->bindParam(':mail',$mail);
        $stmt->bindParam(':password',$password);
        return $stmt->execute();
    }

    public function read($mail) {
        $sql = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail',$mail);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

    public function update($mail, $password) {
        $sql = "UPDATE user SET password = :password WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail',$mail);
        $stmt->bindParam(':password',$password);
        return $stmt->execute();
    }

    public function delete($mail) {
        $sql = "DELETE FROM user WHERE mail = :mail";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mail',$mail);
        return $stmt->execute();
    }

}