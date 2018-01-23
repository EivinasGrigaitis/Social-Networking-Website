<?php

$user = 'root';
$pass = '';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=social_network', $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'Connected!';

} catch (PDOExeption $e) {
    echo 'Connection error!' . $e->getMessage();

}
