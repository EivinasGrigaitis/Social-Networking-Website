<?php

/**
 * Created by PhpStorm.
 * User: Eivin
 * Date: 2017-12-13
 * Time: 20:45
 */
class Hobbie extends User
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertHobbies($user_id, $hobbie, $type)
    {
        foreach ($hobbie as $hobby) {
            $this->insertHobbieToDb($user_id, $hobby, $type);
        }
    }

    public function getUserHobbies($user_id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT hobbie_name, hobbie_type FROM hobbies WHERE user_id=:user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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

    public function getFullHobbieList()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT hobbie_name, hobbielist.hobie_type FROM hobbielist");
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

    public function purgeUserHobbies($user_id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM hobbies WHERE user_id=:user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insertHobbieToDb($user_id, $hobbie, $type)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO hobbies (hobbie_name, hobbie_type, user_id)
          VALUES (:hobbie_name, :hobbie_type, :user_id)");
            $stmt->bindParam(':hobbie_name', $hobbie, PDO::PARAM_STR);
            $stmt->bindParam(':hobbie_type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }

    }

    public function selectMatchUsers($user_id)
    {
        $matchedUsers = array();
        $userHobbies = $this->getUserHobbies($user_id);
        $peopleHobbie = $this->selectAllExceptUser($user_id);

        foreach ($userHobbies as $userHobby) {
            foreach ($peopleHobbie as $peopleHobby) {
                if ($userHobby->hobbie_name == $peopleHobby->hobbie_name) {
                    $matchedUsers[] = array(
                        'user_id' => $peopleHobby->user_id,
                        'hobbie_name' => $peopleHobby->hobbie_name,
                        'hobbie_type' => $peopleHobby->hobbie_type
                    );
                }
            }
        }
        $userHobbiesCount = $this->matchCount($matchedUsers);
        $vars = array();
        $vars['userHobbieList'] = $matchedUsers;
        $vars['userMatchCount'] = $userHobbiesCount;
        return $vars;
    }

    public function matchCount($arrayOfMatchUsers)
    {
        $userHobbiesCount = array();
        foreach ($arrayOfMatchUsers as $userMatch) {
            array_push($userHobbiesCount, $userMatch['user_id']);
        }
        $userHobbiesCount = array_count_values($userHobbiesCount);
        arsort($userHobbiesCount);
        return $userHobbiesCount;
    }

    public function selectAllExceptUser($user_id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT hobbie_name, hobbie_type, user_id FROM hobbies WHERE NOT user_id=:user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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

    public function suggestHobbie($hobbie, $type, $user_id)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO suggestedHobbies (suggest_name ,  suggest_type ,  suggest_user_id )
          VALUES (:hobbie_name, :hobbie_type, :user_id)");
            $stmt->bindParam(':hobbie_name', $hobbie, PDO::PARAM_STR);
            $stmt->bindParam(':hobbie_type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }

    }
    public function selectSuggestHobbies()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM suggestedHobbies");
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
    public function deleteSuggestHobby($sugges_id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM suggestedHobbies WHERE suggest_id=:suggest_id");
            $stmt->bindParam(':suggest_id', $sugges_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

}