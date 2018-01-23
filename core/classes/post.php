<?php

class POST extends Friends
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function postCommet($user_id, $description)
    {
        try {
            $date = date('Y-m-d H:i:s');
            $stmt = $this->pdo->prepare("INSERT INTO userpost (user_id, description, date)
            VALUES (:user_id, :description,:date)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->execute();
            return true;
            // $user_id = $this->pdo->lastInsertId();
            // $_SESSION['user_id']     = $user_id;
            // $_SESSION['user_status'] = 1;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getProfilePosts($user_id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT post_id, description, user_id, date FROM userpost WHERE user_id =:user_id ORDER BY date desc");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultPosts = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return $resultPosts;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getFriendAndUserPost($user_id)
    {
        try {
//            SELECT post_id
//   FROM userpost, friends WHERE userpost.user_id = 40 OR userpost.user_id IN  (SELECT user_friend_id
//   FROM friends WHERE friends.user_id = 40)
            $stmt = $this->pdo->prepare("SELECT userpost.post_id, userpost.description, userpost.user_id, userpost.date
FROM userpost WHERE userpost.user_id IN (SELECT user_friend_id FROM friends WHERE friends.user_id =:user_id) or userpost.user_id=:user_id ORDER By date desc");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultPosts = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return $resultPosts;
            }
        } catch (PDOException $e) {
            return false;
        }
        //Don't forget to complete
    }

    public function getAllPosts()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT post_id, description, user_id, date FROM userpost ORDER BY date desc");
            // $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultPosts = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return $resultPosts;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deletePost($post_id, $user_id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM userpost WHERE post_id=:post_id and user_id=:user_id");
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function deletePostAdmin($post_id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM userpost WHERE post_id=:post_id ");
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function editPost($post_id, $user_id, $post_content)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE userpost SET description=:post_content where post_id=:post_id");
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->bindParam(':post_content', $post_content, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function checkAuthor($post_id, $guessUser)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT user_id, date FROM userpost WHERE post_id =:post_id");
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultPosts = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                $user_id = $resultPosts->user_id;
                if ($guessUser === $user_id) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function findYoutubeLink($postString){
        preg_match('~(?:https?://)?(?:www.)?(?:youtube.com|youtu.be)/(?:watch\?v=)?([^\s]+)~', $postString, $match);
        return $match;
    }
    public function convertYoutube($string) {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
            $string
        );
    }
}
