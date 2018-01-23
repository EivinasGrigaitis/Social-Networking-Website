<?php

class Admin extends User
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers($user_id)
    {

        $stmt = $this->pdo->prepare("SELECT * FROM users");
//        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
        if ($count > 0) {
            return $result;
        }

    }

    public function getAllBlackListUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users where warning=2");
//        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
        if ($count > 0) {
            return $result;
        }
    }

    public function editUser($user_id, $name, $email, $role, $warning)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE users 
SET name=:name , email=:email, role=:role, warning=:warning  WHERE user_id=:user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':warning', $warning, PDO::PARAM_INT);
            $stmt->bindParam(':role', $role, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function checkPassword($user_id, $password)
    {
        $userpassword = $this->getUserPasswd($user_id);
        if ($password !== $userpassword) {
            $user_password_hash = password_hash($password, PASSWORD_DEFAULT);
            return $this->updateUserPassword($user_id, $user_password_hash);
        }
    }

    public function updateUserPassword($user_id, $password)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE users 
SET password=:password WHERE user_id=:user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserPasswd($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT password FROM users WHERE user_id=:user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
        if ($count > 0) {
            return $result->password;
        }

    }
    public function getAllHobbies()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT hobbie_id, hobbie_name, hobbielist.hobie_type FROM hobbielist");
            $stmt->execute();
            $resultHobbies = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return $resultHobbies;
            }
        } catch (PDOException $e) {
            return false;
        }

    }
    public function editHobbie($hobbie_id, $hobbie_name, $hobbie_type){
        try {
            $stmt = $this->pdo->prepare("UPDATE hobbielist 
SET hobbie_name=:hobbie_name, hobie_type=:hobie_type WHERE hobbie_id=:hobbie_id");
            $stmt->bindParam(':hobbie_id', $hobbie_id, PDO::PARAM_INT);
            $stmt->bindParam(':hobbie_name', $hobbie_name, PDO::PARAM_STR);
            $stmt->bindParam(':hobie_type', $hobbie_type, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function addHobby($hobbie_name, $hobie_type){
        try {

            $stmt = $this->pdo->prepare("INSERT INTO hobbielist (hobbie_name, hobie_type)
            VALUES (:hobbie_name, :hobie_type)");
            $stmt->bindParam(':hobbie_name', $hobbie_name, PDO::PARAM_STR);
            $stmt->bindParam(':hobie_type', $hobie_type, PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function deleteHobby($hobbie_id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM hobbielist WHERE hobbie_id=:hobbie_id");
            $stmt->bindParam(':hobbie_id', $hobbie_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
