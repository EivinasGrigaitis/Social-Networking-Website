<?php
class Friends extends User
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createRequest($user_id, $friend_id)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO friendRequest (sender_id, receiver_id)
          VALUES (:user_id, :friend_id)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':friend_id', $friend_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function ApproveRequest($user_id, $friend_id, $action)
    {
        if ($action === 0) {
            return $this->rejectRequest($user_id, $friend_id);
        } elseif ($action === 1) {
            $firstUser  = $this->AddFriend($user_id, $friend_id);
            $secondUser = $this->AddFriend($friend_id, $user_id);
            $this->rejectRequest($user_id, $friend_id);
            if ($firstUser === true && $secondUser === true) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function rejectRequest($user_id, $friend_id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM friendrequest  WHERE sender_id=:friend_id and receiver_id=:user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':friend_id', $friend_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function AddFriend($user_id, $friend_id)
    {
        try {
            $date = date('Y-m-d H:i:s');
            $stmt = $this->pdo->prepare("INSERT INTO friends (user_id, user_friend_id, date)
          VALUES (:user_id, :friend_id, :date)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':friend_id', $friend_id, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function removeRelationShip($user_id, $friend_id){
        $firstRelationship = $this->RemoveFriend($user_id, $friend_id);
        $secondRelationship =$this->RemoveFriend($friend_id, $user_id);
        if($firstRelationship === true && $secondRelationship===true){
            return true;
        }
        else{
            return false;
        }
    }
    public function RemoveFriend($user_id, $friend_id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM friends  WHERE user_id=:user_id and user_friend_id=:friend_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':friend_id', $friend_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getAllUserFriends($user_id)
    {
        try {
            $stmt = $this->pdo->prepare("Select users.user_id, name, profileImage FROM friends, users  WHERE friends.user_id=:user_id and users.user_id = friends.user_friend_id;");
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
    public function getFiveUserFriends($user_id)
    {
        try {
            $stmt = $this->pdo->prepare("Select users.user_id, name, profileImage FROM friends, users  WHERE friends.user_id=:user_id and users.user_id = friends.user_friend_id LIMIT 5");
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
    public function checkIfUserIsFriend($user_id, $friend_id)
    {
        try {
            $stmt = $this->pdo->prepare("Select * FROM friends WHERE user_id=:user_id and user_friend_id=:friend_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':friend_id', $friend_id, PDO::PARAM_INT);
            $stmt->execute();
            $user  = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return true;
            } else {
                return false;
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function checkIfRequestExist($user_id, $friend_id)
    {
        try {
            $stmt = $this->pdo->prepare("Select request_id  FROM friendrequest  WHERE sender_id=:user_id and receiver_id=:friend_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':friend_id', $friend_id, PDO::PARAM_INT);
            $stmt->execute();
            $user  = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return true;
            } else {
                return false;
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function checkFriendRequest($user_id){
         try {
            $stmt = $this->pdo->prepare("Select request_id  FROM friendrequest  WHERE receiver_id=:user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $user  = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return true;
            } else {
                return false;
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getFriendRequest($user_id)
    {
        try {
            $stmt = $this->pdo->prepare("Select user_id, name, profileImage FROM friendrequest, users  WHERE friendrequest.receiver_id=:user_id and friendrequest.sender_id = users.user_id");
            // $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $friendRequest = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count         = $stmt->rowCount();
            if ($count > 0) {
                return $friendRequest;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return false;
        }
    }

}
