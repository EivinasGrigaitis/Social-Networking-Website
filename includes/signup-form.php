<?php

$name = '';
$email = '';
$ageLimit = date('Y-m-d', strtotime('-14 year'));
if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];
    $birthDate = $_POST['birthDate'];
    if (isset($_POST['genre'])) {
        if ($_POST['genre'] === "M" or $_POST['genre'] === "F" or $_POST['genre'] === "U") {
            $genre = $_POST['genre'];
        }
    } else {
        $genre = "U";
    }
    if (empty($name) or empty($password) or empty($password2) or empty($email) or empty($birthDate)) {
        $errorMessage = 'Prašau užpildykite visus laukus';
        $getFromUser->phpAlertMessage($errorMessage);
    } else {
        $name = $getFromUser->checkInput($name);
        $email = $getFromUser->checkInput($email);
        $password = $getFromUser->checkInput($password);
        $password2 = $getFromUser->checkInput($password2);

        if (!($getFromUser->checkIfInputIsEmail($email))) {
            $errorMessage = 'Netinkamas el. pašto adresas!';
            $getFromUser->phpAlertMessage($errorMessage);
        } else if (strlen($name) > 20) {
            $errorMessage = 'Vardas per ilgas maksimalus vardo simbolių skaičius yra 20';
            $getFromUser->phpAlertMessage($errorMessage);
        } else if (strlen($password) < 5) {
            $errorMessage = 'Slaptažodis per trumpas';
            $getFromUser->phpAlertMessage($errorMessage);
        } else if ($birthDate === Null) {
            $errorMessage = 'Užpildykite lytį';
            $getFromUser->phpAlertMessage($errorMessage);
        } else if ($password !== $password2) {
            $errorMessage = 'Slaptažodžiai nesutampa';
            $getFromUser->phpAlertMessage($errorMessage);
        } else {
            if ($getFromUser->checkEmail($email) === true) {
                $errorMessage = 'El. pašto adresas jau yra naudojamas';
                $getFromUser->phpAlertMessage($errorMessage);
            } else {
                $getFromUser->register($email, $name, $password, $genre, $birthDate);
                header('Location:hobbies.php');
            }
        }
    }
}
?>
<div class="SignupForm">
    <div class="container col-lg-12 block">
        <div class="row col-xs-6 block2 bg-primary center">
            <legend><p color="white">REGISTRACIJA </p></legend>
            <form method="post" action="" class="form-horizontal" role="form" align="center">

                <div class="form-group">
                    <label class="control-label col-sm-3" for="name">Įveskite vardą<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="text" name="name" id="name" value="<?php echo $name ?>" placeholder="Vardą bus galima keisti" required="true"
                               class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="email">El. paštas<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="text" name="email" id="email" value="<?php echo $email ?>" placeholder="El. pašto nebus galima keisti"
                               required="true" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="password">Slaptažodis<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="password" name="password" id="password" placeholder="Netrumpesnis nei 6 simboliai"
                               required="true" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="password">Pakartoti slaptažodį<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="password" name="password2" id="password" placeholder="Netrumpesnis nei 6 simboliai"
                               required="true" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">

                    <label for="birthDate" class="col-sm-3 control-label">Gimimo data</label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="date" max="<?php echo $ageLimit ?>" min="1905-01-01" id="birthDate" name="birthDate" class="form-control">
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Lytis</label>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input required="true" type="radio" name="genre" id="genreRadio" value="M">Vyras
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input required="true" type="radio" name="genre" id="genreRadio" value="F">Moteris
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input required="true" type="radio" name="genre" id="genreRadio" value="U">Nenurodyti
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <input type="submit" name="signup" id="signup" value="Registruotis" class="btn btn-default"/>
                    </div>

                </div>
                <?php
                if (isset($error)) {
                    echo '<li class="error-li"> <div class ="span-fp-error">' . $error . '</div></li>';
                }
                ?>
            </form>
        </div>
    </div>
</div>
