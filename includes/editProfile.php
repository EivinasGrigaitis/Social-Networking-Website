<?php
$ageLimit = date('Y-m-d', strtotime('-14 year'));
if (isset($_POST['editProfileForm'])) {
    $name = $_POST['name'];
    $birthDate = $_POST['birthDate'];
    $genre;
    if (isset($_POST['genre'])) {
        if ($_POST['genre'] === "M" or $_POST['genre'] === "F" or $_POST['genre'] === "U") {
            $genre = $_POST['genre'];
        }
    } else {
        $genre = "U";
    }
    if (empty($name) or empty($birthDate)) {
        $errorMesage = 'Prašau užpildykite visus laukus';
        $getFromUser->phpAlertMessage($errorMesage);
    } else {
        $name = $getFromUser->checkInput($name);
        if (strlen($name) > 20) {
            $errorMessage = 'Vardas per ilgas maksimalus vardo simbolių skaičius yra 20';
            $getFromUser->phpAlertMessage($errorMessage);
        } elseif ($birthDate === null) {
            $errorMessage = 'Užpildykite lytį';
            $getFromUser->phpAlertMessage($errorMessage);
        } else {
            if ($getFromUser->editUserProfileDate($user_id, $name, $birthDate, $genre) === true) {
                //
                // header('Location: profileEdit.php');
                $succesMessage = 'Informacija atnaujinta';
                $getFromUser->phpAlertMessage($succesMessage);
                echo "<script>setTimeout(\"location.href = 'profileEdit.php';\",1500);</script>";

            }
        }
    }
}
?>
<div class="EditProfile">
    <div class="container col-lg-12 block">
        <div class="row col-xs-6 block2 bg-primary center">
            <legend><p color="white">Profilio redagavimas</p></legend>
            <form method="post" action="" class="form-horizontal" role="form" align="center">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="name">Vardas<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="text" name="name" id="name" placeholder="Įveskite vardą"
                               value="<?php echo $user->name ?>" required="true" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="birthDate" class="col-sm-3 control-label">Gimimo data</label>
                    <div class="col-sm-8 col-xs-12">
                        <input type="date" id="birthDate" max="<?php echo $ageLimit ?>" min="1905-01-01" name="birthDate" value="<?php echo $user->birthDate ?>"
                               class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Lytis</label>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input required="true" type="radio" <?php if (($user->genre) === "M") {
                                    ?>checked="checked"<?php
                                    } ?> name="genre" id="genreRadio" value="M">Vyras
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input required="true" type="radio" <?php if (($user->genre) === "F") {
                                    ?>checked="checked"<?php
                                    } ?> name="genre" id="genreRadio" value="F">Moteris
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input required="true" type="radio" <?php if (($user->genre) === "U") {
                                    ?>checked="checked"<?php
                                    } ?> name="genre" id="genreRadio" value="U">Nenurodyti
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <input type="submit" name="editProfileForm" id="editProfileForm" value="Keisti"
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
