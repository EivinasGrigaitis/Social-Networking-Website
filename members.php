<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$navBarActive = "members";
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}

if (isset($_POST['searchUser'])) {
    $email = $_POST['email'];
    $email = $getFromUser->checkInput($email);
    $result = $getFromUser->memberSearchResult($email, $user_id);
}
if (isset($_POST['addFriend'])) {
    $friendId = $_POST['requestUserId'];
    $friendId = $getFromUser->checkInput($friendId);
    $request = $getFromFriend->createRequest($user_id, $friendId);
    if ($request === true) {
        $getFromUser->phpAlertMessage('Pranešimas draugauti nusiųstas!');
        echo "<script>setTimeout(\"location.href = 'members.php';\",1500);</script>";
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida bandant pakviesti narį į kontaktus');
        echo "<script>setTimeout(\"location.href = 'members.php';\",1500);</script>";
    }
}
?>
<?php include "header.php" ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="" role="form">
                    <div class="messages"></div>
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label for="usertoFind"> Nariai*</label>
                                    <input type="text" name="email"
                                           value="" class="form-control"
                                           placeholder="Įveskite narį kurį norite surasti *" required="required"
                                           data-error="">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="searchUser" class="btn btn-info col-md-6 col-md-offset-3"
                               value="Ieškoti">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted"><strong>*</strong> Reikalaujami laukai </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- SEARCH RESULT -->
        <?php if (!empty($result)) {

        ?>
        <div class="row">
            <div class="col-md-8">
                <div class="members">
                    <h1 class="page-header">Nariai</h1>
                    <?php  foreach ($result

                    as $member) { ?>
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
                        if (((($relationshipStatus) === false)) && (($requestStatus) === false)) {
                            ?>

                            <div class="col-md-3">
                                <form method="POST">
                                    <strong>

                                        <input type="hidden" name="requestUserId"
                                               value="<?php echo $member->user_id; ?>">
                                        <a href="#" onClick="Ar tikrai norite pridėti į savo draugų sąrašą?')">
                                            <input class="btn btn-success btn-block" type="submit" name="addFriend"
                                                   value="Pridėti draugą"/></a>
                                    </strong>
                                </form>
                            </div>
                            <?php
                        } elseif (($relationshipStatus) === true) { ?>
                            <div class="col-md-3">
                                <p><a href="message.php?id=<?php echo $member->user_id ?>" class="btn btn-default btn-block"><i class="fa fa-envelope"></i> Nusiųsti
                                        žinutę</a></p>
                            </div>
                      <?php  } ?>


                        <div class="col-md-3">
                            <p><a href="profile.php?id=<?php echo $member->user_id ?>"
                                  class="btn btn-primary btn-block"><i class="fa fa-edit"></i> Peržiūrėti Profilį</a>
                            </p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php

    } ?>
</section>

<?php include "footer.php" ?>
