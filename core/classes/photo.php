<?php

class Photo extends user
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertPhoto($user_id, $photoName, $pictureLink)
    {
        // $date = date('Y-m-d H:i:s');
        try {
            $stmt = $this->pdo->prepare("INSERT INTO userpictures (user_id, name, picture_link)
            VALUES (:user_id, :photoName, :pictureLink)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':photoName', $photoName, PDO::PARAM_STR);
            $stmt->bindParam(':pictureLink', $pictureLink, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserPictures($user_id)
    {
        try {

            $stmt = $this->pdo->prepare("SELECT * FROM userpictures WHERE user_id=:user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $pictures = $stmt->fetchAll(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return $pictures;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function makePictureMain($user_id, $picture_id)
    {
        try {

            $stmt = $this->pdo->prepare("SELECT * FROM userpictures WHERE picture_id=:picture_id and user_id =:user_id");
            $stmt->bindParam(':picture_id', $picture_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $picture = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                $stmt2 = $this->pdo->prepare("UPDATE users SET profileImage=:profileImage WHERE user_id=:user_id");
                $stmt2->bindParam(':profileImage', $picture->picture_link, PDO::PARAM_STR);
                $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt2->execute();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserPictureLink($picture_id)
    {
        try {

            $stmt = $this->pdo->prepare("SELECT picture_link FROM userpictures WHERE picture_id=:picture_id");
            $stmt->bindParam(':user_id', $picture_id, PDO::PARAM_INT);
            $stmt->execute();
            $picture = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                return $picture;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deletePicture($user_id, $picture_id)
    {
        try {
            //Get picturelink
            $stmt = $this->pdo->prepare("SELECT picture_link FROM userpictures WHERE picture_id=:picture_id and user_id=:user_id");
            $stmt->bindParam(':picture_id', $picture_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $picture = $stmt->fetch(PDO::FETCH_OBJ);
            $link = $picture->picture_link;
            //Check if picture is profile Image
            //
            $this->checkIfPictureIsProfile($user_id, $link);
            //Delete Picture
            $stmt2 = $this->pdo->prepare("DELETE FROM userpictures WHERE picture_id=:picture_id and user_id=:user_id");
            $stmt2->bindParam(':picture_id', $picture_id, PDO::PARAM_INT);
            $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt2->execute();
//            Delete Picture From user folder
            unlink($picture->picture_link);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

//    assets/images/defaultProfileImage.png
    public function checkIfPictureIsProfile($user_id, $profile_link)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT user_id, profileImage FROM users WHERE profileImage=:picture_link and user_id=:user_id");
            $stmt->bindParam(':picture_link', $profile_link, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $picture = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                if ($profile_link === $picture->profileImage) {
                    $defaultImage = 'assets/images/defaultProfileImage.png';
                    $stmt2 = $this->pdo->prepare("UPDATE users SET profileImage=:profileImage WHERE user_id=:user_id");
                    $stmt2->bindParam(':profileImage', $defaultImage, PDO::PARAM_STR);
                    $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt2->execute();
                    return true;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

}
