<?php

class User
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function checkInput($var)
    {
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripslashes($var);
        return $var;
    }

    public function checkIfInputIsEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    //Logn method
    public function login($email, $password)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT user_id,password, role, warning FROM users WHERE email =:email");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            // $stmt ->bindParam(":password",$password , PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();

            if ($count > 0) {
                $hashedPassword = $user->password;
                //Compares password with result
                if (password_verify($password, $hashedPassword)) {
                    if ($user->warning == 2) {
                        $errorMssg = urlencode("Jūsų paskyra yra užblokuota dėl taisyklių nesilaikymo!");
                        header('Location: bann.php?errorMssg=' . $errorMssg);

                    } else {
                        $_SESSION['user_id'] = $user->user_id; //Nusetinu reikšmę iš objekto
                        $_SESSION['user_status'] = 1;
                        $_SESSION['user_role'] = $user->role;
                        $this->createFolderForUser($user->user_id);
                        header('Location: home.php');
                    }

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //GetUserData
    public function userData($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id =:user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    public function editUserProfileDate($user_id, $name, $birthDate, $genre)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET name=:name, birthDate=:birthDate, genre=:genre WHERE user_id=:user_id");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':birthDate', $birthDate, PDO::PARAM_STR);
            $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function checkIfPassword($oldPassword, $user_id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT password FROM users WHERE user_id=:user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->execute();
            // $error = "Jums pavyko";
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                $hashedPassword = $user->password;
                //Compares password with result
                if (password_verify($oldPassword, $hashedPassword)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
        }
    }

    public function changeUserPassword($newPassword, $user_id)
    {
        try {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE users SET password=:hashedNewPassword WHERE user_id=:user_id");
            $stmt->bindParam(':hashedNewPassword', $hashedNewPassword, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
        }
    }

    public function logOut()
    {
        //Delete user session
        $_SESSION = array();
        session_destroy();
        header('Location: ../index.php');
    }

    //Check If email exist
    public function checkEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email =:email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    //register method
    public function register($email, $name, $password, $genre, $birthDate)
    {
        $role = 0;
        $user_password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (email, password, name, profileImage, genre, role, birthDate)
      VALUES (:email,:password, :name, 'assets/images/defaultProfileImage.png', :genre,:role, :birthDate)");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $user_password_hash, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);
        $stmt->bindParam(':birthDate', $birthDate, PDO::PARAM_STR);
        $stmt->execute();
        $user_id = $this->pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_status'] = 1;
        $_SESSION['user_role'] = 0;
        $this->createFolderForUser($user_id);

    }

    public function createFolderForUser($user_id)
    {
        //Create file with Id
        $pathToFile = 'uploads/' . $user_id;
        if (!file_exists($pathToFile)) {
            mkdir($pathToFile, 0777, true);
        }
    }

    //Check if user is LoggenIn
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_status']) and $_SESSION['user_status'] == 1) {
            return true;
        }
        // by default return false
        return false;
    }

    public function checkifIsValid()
    {
        if ($getFromUser->isUserLoggedIn() === false) {
            header('Location: index.php');
        }
    }

    public function checkGenre($genre)
    {
        if ($genre === "M") {
            return "Vyras";
        } elseif ($genre === "F") {
            return "Moteris";
        } else {
            return "Nenurodyta";
        }
    }

    public function phpAlertMessage($msg)
    {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    public function getUserNameById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT email FROM users WHERE user_id=:user_id");
            $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);
            $stmt->execute();
            // $error = "Jums pavyko";
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                $email = $user->email;
                return $email;
            }
        } catch (PDOException $e) {
        }
    }

    public function getUserProfilePic($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT profileImage FROM users WHERE user_id=:user_id");
            $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);
            $stmt->execute();
            // $error = "Jums pavyko";
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                $profileImage = $user->profileImage;
                return $profileImage;
            }
        } catch (PDOException $e) {
        }
    }
    public function getUserIdByEmail($email)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE email=:email");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            if ($count > 0) {
                $profileId = $user->user_id;
                return $profileId;
            }
        } catch (PDOException $e) {
        }
    }
    // new methods
    public function memberSearchResult($email, $user_id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email LIKE :email and not  user_id=:user_id;");
            $stmt->bindValue(":email", '%' . $email . '%', PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_OBJ);
            // $count = $stmt->rowCount();
            return $user;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserNameAndImage($user_from)
    {
        try {
            //get name and image of $user_form from `user` table
            $stmt = $this->pdo->prepare("SELECT name, profileImage FROM users WHERE user_id=:user_from;");
            $stmt->bindParam(":user_from", $user_from, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            // $count = $stmt->rowCount();
            return $user;

        } catch (PDOException $e) {
            return false;
        }
    }
}
