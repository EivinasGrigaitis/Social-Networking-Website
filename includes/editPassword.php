<?php
if (isset($_POST['changePasswordForm'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $newPassword2 = $_POST['newPassword2'];
    if (empty($oldPassword) or empty($newPassword) or empty($newPassword2)) {
        $errorMessage = "Prašome užpildyti visus laukus";
        $getFromUser->phpAlertMessage($errorMessage);
    } else {
        $oldPassword = $getFromUser->checkInput($oldPassword);
        $newPassword = $getFromUser->checkInput($newPassword);
        $newPassword2 = $getFromUser->checkInput($newPassword2);

        if ($newPassword !== $newPassword2) {
            $errorMessage = "Nauji slaptažodžiai nesutampa";
            $getFromUser->phpAlertMessage($errorMessage);
        } else {
            if (($getFromUser->checkIfPassword($oldPassword, $user_id)) === true) {
                if (($getFromUser->changeUserPassword($newPassword, $user_id)) === true) {
                    $errorMessage = "Slaptažodis pakeistas";
                    $getFromUser->phpAlertMessage($errorMessage);
                    echo "<script>setTimeout(\"location.href = 'passwordEdit.php';\",1500);</script>";
                } else {
                    $errorMessage = "Įvyko klaida";
                    $getFromUser->phpAlertMessage($errorMessage);
                }
            } else {
                $errorMessage = "Klaida! Senasis slaptažodis suvestas neteisingai.";
                $getFromUser->phpAlertMessage($errorMessage);
            }
        }
    }
}

?>
<div class="changePassword">
    <div class="container col-lg-12 block">
        <div class="row col-xs-6 block2 bg-primary center">
            <legend><p color="white">Slaptažodžio keitimas</p></legend>
            <form method="post" action="" class="form-horizontal" role="form" align="center">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="password">Slaptažodis<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="password" name="oldPassword" id="password" placeholder="Įveskite esamą slaptažodį"
                               required="true" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="newPassword">Naujas slaptažodis<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="password" name="newPassword" id="password"
                               placeholder="Slaptažodis turi būti daugiau nei 5 simboliai" required="true"
                               class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="newPassword2">Naujas slaptažodis<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="password" name="newPassword2" id="password"
                               placeholder="Pakartokite naują slaptažodį" required="true" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <input type="submit" name="changePasswordForm" id="changePasswordForm" value="Keisti"
                               class="btn btn-default"/>
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
