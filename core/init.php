<?php
    include 'core/database/connection.php';
    include 'classes/user.php';
    include 'classes/friends.php';
    include 'classes/post.php';
    include 'classes/message.php';
    include 'classes/photo.php';
    include 'classes/admin.php';
    include 'classes/hobbie.php';
    global $pdo;


    session_start();

    $getFromUser = new User($pdo);
    $getFromPost = new Post($pdo);
    $getFromFriend = new Friends($pdo);
    $getMessageFromFriend = new Message($pdo);
    $getUserPhoto = new Photo($pdo);
    $getUserHobbie = new Hobbie($pdo);
    $getUserAdmin = new Admin($pdo);

    define("BASE_URL", "http://localhost/socialinisTinklas/");
?>
