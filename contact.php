<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$navBarActive = "contact";
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}

$requestResult = $getFromFriend->getFriendRequest($user_id);
$userFriends = $getFromFriend->getAllUserFriends($user_id);
if (isset($_POST['addFriend'])) {
    $friendId = $_POST['requestUserId'];
    $friendId = $getFromUser->checkInput($friendId);

    $result = $getFromFriend->ApproveRequest($user_id, $friendId, 1);
    if ($result === true) {
        $getFromUser->phpAlertMessage('Draugas pridėtas');
        echo "<script>setTimeout(\"location.href = 'contact.php';\",1500);</script>";
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida bandat pridėti narį į kontaktus');
        echo "<script>setTimeout(\"location.href = 'contact.php';\",1500);</script>";
    }
}
if (isset($_POST['rejectFriend'])) {
    $friendId = $_POST['requestUserId'];
    $friendId = $getFromUser->checkInput($friendId);

    $result = $getFromFriend->ApproveRequest($user_id, $friendId, 0);
    if ($result === true) {
        $getFromUser->phpAlertMessage('Užklausa atlikta');
        echo "<script>setTimeout(\"location.href = 'home.php';\",1500);</script>";
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida');
        echo "<script>setTimeout(\"location.href = 'home.php';\",1500);</script>";
    }
}

if (isset($_POST['deleteFriend'])) {
    $friendId = $_POST['deleteUserId'];
    $friendId = $getFromUser->checkInput($friendId);

    $result = $getFromFriend->removeRelationShip($user_id, $friendId);
    if ($result === true) {
        $getFromUser->phpAlertMessage('Užklausa atlikta');
        echo "<script>setTimeout(\"location.href = 'home.php';\",1500);</script>";
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida');
        echo "<script>setTimeout(\"location.href = 'home.php';\",1500);</script>";
    }
}
?>
<?php include "header.php" ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($requestResult)) {
                    foreach ($requestResult as $requestUser) {
                        ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="members">
                                    <h1 class="page-header">Kontaktai kurie norėtų jūs pridėti į draugus</h1>
                                    <div class="row member-row">
                                        <div class="col-md-3">
                                            <img src="<?php echo $requestUser->profileImage ?>" class="img-thumbnail"
                                                 alt="">
                                            <div class="text-center">
                                                <?php echo $requestUser->name ?>
                                            </div>
                                        </div>
                                        <!-- friend request -->
                                        <div class="col-md-3">
                                            <form method="POST">
                                                <strong>
                                                    <input type="hidden" name="requestUserId"
                                                           value="<?php echo $requestUser->user_id; ?>">
                                                    <a href="#">
                                                        <input class="btn btn-success btn-block" type="submit"
                                                               name="addFriend" value="Pridėti draugą"/></a>
                                                </strong>
                                            </form>
                                        </div>
                                        <div class="col-md-3">
                                            <form method="POST">
                                                <strong>
                                                    <input type="hidden" name="requestUserId"
                                                           value="<?php echo $requestUser->user_id; ?>">
                                                    <a href="#" onClick="Ar tikrai norite atšaukti pakvietimą?')">
                                                        <input class="btn btn-danger btn-block" type="submit"
                                                               name="rejectFriend" value="Atšaukti pakvietimą"/></a>
                                                </strong>
                                            </form>
                                        </div>
                                        <div class="col-md-3">
                                            <p><a href="profile.php?id=<?php echo $requestUser->user_id ?>"
                                                  class="btn btn-primary btn-block"><i class="fa fa-edit"></i>
                                                    Peržiūrėti Profilį</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } ?>
            </div>
        </div>
        <!-- SEARCH RESULT -->

        <div class="row">
            <div class="col-md-8">
                <div class="members">
                    <h1 class="page-header">Nariai</h1>
                    <?php if (!empty($userFriends)) {
                        foreach ($userFriends as $member) {
                            ?>
                            <div class="row member-row">

                                <div class="col-md-3">
                                    <img src="<?php echo $member->profileImage ?>" class="img-thumbnail" alt="">
                                    <div class="text-center">
                                        <?php echo $member->name ?>
                                    </div>
                                </div>
                                <!-- SEND friend request -->
                                <?php
                                $relationshipStatus = $getFromFriend->checkIfUserIsFriend($user_id, $member->user_id);
                                $requestStatus = $getFromFriend->checkIfRequestExist($user_id, $member->user_id);
                                if (((($relationshipStatus) === true)) && (($requestStatus) === false)) {
                                    ?>
                                    <div class="col-md-3">
                                        <form method="POST">
                                            <strong>
                                                <input type="hidden" name="deleteUserId"
                                                       value="<?php echo $member->user_id; ?>">
                                                <a href="#"
                                                   onClick="Ar tikrai norite pašalinti iš naudotoją iš kontaktų?')">
                                                    <input class="btn btn-danger btn-block" type="submit"
                                                           name="deleteFriend"
                                                           value="Pašalinti draugą"/></a>
                                            </strong>
                                        </form>
                                    </div>
                                    <?php
                                } elseif (($relationshipStatus) === true) {

                                } ?>
                                <div class="col-md-3">
                                    <p><a href="message.php?id=<?php echo $member->user_id ?>" class="btn btn-default btn-block"><i class="fa fa-envelope"></i>
                                            Nusiųsti
                                            žinutę</a></p>
                                </div>
                                <div class="col-md-3">
                                    <p><a href="profile.php?id=<?php echo $member->user_id ?>"
                                          class="btn btn-primary btn-block"><i class="fa fa-edit"></i> Peržiūrėti
                                            Profilį</a>
                                    </p>
                                </div>

                            </div>
                        <?php }  ?><?php

                    } else{
                        echo "Neturi kontaktų. Prašau pakvieskite draugus";
                    } ?>
                </div>
            </div>
        </div>
    </div>

</section>
<?php include "footer.php" ?>
