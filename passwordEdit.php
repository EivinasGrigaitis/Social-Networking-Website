<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$user    = $getFromUser->userData($user_id);
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}

?>
<?php include 'header.php'?>
<?php include 'includes/editPassword.php'; ?>
<?php include 'footer.php'?>
