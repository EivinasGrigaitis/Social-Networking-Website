<?php
if (isset($_POST['loginForm']) && !empty($_POST['loginForm'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!empty($email) or !empty($password)) {
        $email = $getFromUser->checkInput($email);
        $password = $getFromUser->checkInput($password);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Netinkamas el. pašto formatas!";
            $getFromUser->phpAlertMessage($errorMessage);
        } else {
            if ($getFromUser->login($email, $password) === false) {
                $errorMessage = "Prašau įveskite el.paštą ir slaptažodį!";
                $getFromUser->phpAlertMessage($errorMessage);
            }
        }
    } else {
        $errorMessage =
            "Prašau įveskite teisingą el. paštą ir slaptažodį!";
        $getFromUser->phpAlertMessage($errorMessage);
    }
}
?>

<div class="login-div">
<form method="post" class="navbar-form navbar-right" role="search">
    <div class="form-group">
<!--        <input type="text" class="form-control" name="email" placeholder="El. paštas" value="petras@gmail.com">-->
    PRISIJUNGIMAS -
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="email" placeholder="El. paštas" value="admin@testmail.com">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Slaptažodis" value="Testas1">
    </div>
    <input type="submit" name="loginForm" class="btn btn-default" value="Prisijungti">
</form>
</div>
