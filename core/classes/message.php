<?php
class Message extends Friends
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    // public function createRequest($user_id, $friend_id)
    // {
    //     //Example from another class
    //     try {
    //         $stmt = $this->pdo->prepare("INSERT INTO friendRequest (sender_id, receiver_id)
    //       VALUES (:user_id, :friend_id)");
    //         $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    //         $stmt->bindParam(':friend_id', $friend_id, PDO::PARAM_INT);
    //         $stmt->execute();
    //         return true;
    //     } catch (PDOException $e) {
    //         return false;
    //     }
    // }
    public function showAllUsers($user_id)
    {
        //Example from another class friends
           try {
            $stmt = $this->pdo->prepare("SELECT user_id, name, profileImage FROM users WHERE user_id!=:user_id;");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $users  = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return $users;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function checkUser($user_id, $user_two){
         // $q = mysqli_query($con, "SELECT `id` FROM `user` WHERE id='$user_two' AND id!='$user_id'");
         //Example from another class
           try {
            $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE user_id=:user_two AND user_id!=:user_id;");
            $stmt->bindParam(':user_two', $user_two, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $users  = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function checkIfUserHaveCon($user_id, $user_two){
        //check $user_id and $user_two has conversation or not if no start one
         // mysqli_query($con, "SELECT * FROM `conversation` WHERE (user_one='$user_id' AND user_two='$user_two') OR (user_one='$user_two' AND user_two='$user_id')");
         try {
            $stmt = $this->pdo->prepare("SELECT * FROM conversation WHERE (user_one=:user_id AND user_two=:user_two) OR (user_one=:user_two AND user_two=:user_id); ");
            $stmt->bindParam(':user_id', $user_two, PDO::PARAM_INT);
            $stmt->bindParam(':user_two', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $conversation  = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count == 1) {
                return $conversation;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function inserConversation($user_id, $user_two){
            // $date = date('Y-m-d H:i:s');
        try{
             
            $stmt = $this->pdo->prepare("INSERT INTO conversation (user_one, user_two)
            VALUES (:user_id, :user_two)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_two', $user_two, PDO::PARAM_INT);
            $stmt->execute();
            $id = $this->pdo->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function GetAllConversationMessages($conversation_id){
          try {
            // $q = mysqli_query($con, "SELECT * FROM `messages` WHERE conversation_id='$conversation_id'");

            $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE conversation_id=:conversation_id");
            $stmt->bindParam(':conversation_id', $conversation_id, PDO::PARAM_INT);
            $stmt->execute();
            $conversation  = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count >0) {
                return $conversation;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function insertMessage($conversation_id, $user_form, $user_to, $message){
            // $date = date('Y-m-d H:i:s');
        try{
             
            // INSERT INTO `messages` VALUES ('','$conversation_id','$user_form','$user_to','$message'
            $stmt = $this->pdo->prepare("INSERT INTO messages (conversation_id, user_from, user_to, message)
            VALUES (:conversation_id, :user_form, :user_to, :message)");
            $stmt->bindParam(':conversation_id', $conversation_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_form', $user_form, PDO::PARAM_INT);
            $stmt->bindParam(':user_to', $user_to, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

}
