<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$navBarActive = "match";
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}

$result = $getUserHobbie->selectMatchUsers($user_id);
$userHobbieList = $result['userHobbieList'];
$userMatchCount = $result['userMatchCount'];
//print_r($userHobbieList);
//print_r($userMatchCount);

$userMatchCount = array_keys($userMatchCount);
if(empty($userMatchCount)){
    $matchNotFound = "Prašome pasirinkti daugiau pomėgių!";
    header('Location: hobbies.php?matchNotFound=' . $matchNotFound);
}

?>
<?php
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
            <!-- SEARCH RESULT -->
            <div class="row">
                <div class="col-md-12">
                    <div class="members">
                        <?php $calc = 1 ?>
                        <h1 class="page-header">Nariai turintis bendrų pomėgių</h1>

                        <?php if (!empty($userMatchCount)) {
                            foreach ($userMatchCount as $match) { ?>
                                <div class="row member-row">
                                    <p><?php echo $calc . ")" ?></p>
                                    <?php $calc++ ?>
                                    <div class="col-md-3">

                                        <?php $relationshipStatus = $getFromFriend->checkIfUserIsFriend($user_id, $match); ?>
                                        <?php $requestStatus = $getFromFriend->checkIfRequestExist($user_id, $match); ?>
                                        <img src="<?php echo $getFromUser->getUserProfilePic($match) ?>"
                                             class="img-thumbnail"
                                             alt="">
                                        <div class="text-center">
                                            <?php echo $getFromUser->getUserNameById($match) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <p><b>Patinkančių sporto šakų sutapimas - </b></p>
                                        <?php foreach ($userHobbieList as $hobby) {
                                            if ($hobby['user_id'] == $match) {
                                                if ($hobby['hobbie_type'] == "sport")
                                                    echo " *" . $hobby['hobbie_name'];
                                            }
                                        } ?>
                                        <p><b>Muzikos skonio sutapimas - </b></p>
                                        <?php foreach ($userHobbieList as $hobby) {
                                            if ($hobby['user_id'] == $match) {
                                                if ($hobby['hobbie_type'] == "music")
                                                    echo " *" . $hobby['hobbie_name'];
                                            }
                                        } ?>
                                        <p><b>Patinkantis knygų žanrai - </b></p>
                                        <?php foreach ($userHobbieList as $hobby) {
                                            if ($hobby['user_id'] == $match) {
                                                if ($hobby['hobbie_type'] == "books")
                                                    echo " *" . $hobby['hobbie_name'];
                                            }
                                        } ?>

                                        <p><b>Kiti bendri pomėgiai - </b></p>
                                        <?php foreach ($userHobbieList as $hobby) {
                                            if ($hobby['user_id'] == $match) {
                                                if ($hobby['hobbie_type'] == "other")
                                                    echo " *" . $hobby['hobbie_name'];
                                            }
                                        } ?>
                                    </div>

                                    <?php if ($relationshipStatus == true) { ?>
                                        <div class="col-md-3">
                                            <p><a href="message.php?id=<?php echo $match ?>"
                                                  class="btn btn-default btn-block"><i class="fa fa-envelope"></i>
                                                    Nusiųsti
                                                    žinutę</a></p>
                                        </div>
                                    <?php } elseif ($requestStatus == false) { ?>
                                        <div class="col-md-3">
                                            <form method="POST">
                                                <strong>
                                                    <input type="hidden" name="requestUserId"
                                                           value="<?php echo $match; ?>">
                                                    <a href="#"
                                                       onClick="Ar tikrai norite pridėti į savo draugų sąrašą?')">
                                                        <input class="btn btn-success btn-block" type="submit"
                                                               name="addFriend"
                                                               value="Pakviesti draugauti"/></a>
                                                </strong>
                                            </form>
                                        </div>
                                    <?php } ?>

                                    <div class="col-md-3">
                                        <p><a href="profile.php?id=<?php echo $match ?>"
                                              class="btn btn-primary btn-block"><i class="fa fa-edit"></i> Peržiūrėti
                                                Profilį</a>
                                        </p>
                                    </div>

                                </div>
                            <?php }
                        } ?>
                        <?php if (empty($userHobbieList)) { ?>
                            <p>Atitikimų nerasta. Prašome užpildyti - <strong><a
                                            href="hobbies.php">Pomėgius</a></strong></li></p>
                        <?php } ?>


                    </div>
                </div>
            </div>
        </div>

    </section>


<?php include "footer.php" ?>