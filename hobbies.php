<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$user = $getFromUser->userData($user_id);
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}
$getFullHobbiesList = $getUserHobbie->getFullHobbieList();
$userHobbies = $getUserHobbie->getUserHobbies($user_id);

if (isset($_POST['actionHobbieBtn'])) {
    $hobbySport;
    $hobbyBooks;
    $hobbyMusic;
    $otherHobbies;
    $getUserHobbie->purgeUserHobbies($user_id);
    if (isset($_POST['sport'])) {
        $hobbySport = $_POST['sport'];
        $getUserHobbie->insertHobbies($user_id, $hobbySport, "sport");
    }
    if (isset($_POST['music'])) {
        $hobieMusic = ($_POST['music']);
        $getUserHobbie->insertHobbies($user_id, $hobieMusic, "music");
    }
    if (isset($_POST['books'])) {
        $hobbyBooks = $_POST['books'];
        $getUserHobbie->insertHobbies($user_id, $hobbyBooks, "books");
    }
    if (isset($_POST['otherHobbies'])) {
        $otherHobbies = $_POST['otherHobbies'];
        $getUserHobbie->insertHobbies($user_id, $otherHobbies, "other");
    }
    $userHobbies = $getUserHobbie->getUserHobbies($user_id);
    header('Location: match.php');

}
if (isset($_GET['matchNotFound'])) {
    $matchNotFound = $_GET['matchNotFound'];
    if (!empty($matchNotFound)) {
        $getFromUser->phpAlertMessage($matchNotFound);
        header('Location: hobbies.php');
    }

}
if (isset($_POST['suggestHobbieBtn'])){
    $suggestName = $_POST['name'];
    $suggetType = $_POST['type'];

//    $getFromUser->phpAlertMessage($test);
    if($getUserHobbie->suggestHobbie($suggestName, $suggetType, $user_id)== true){
        $getFromUser->phpAlertMessage("Pomėgio pasiūlymas nusiųstas patvirtinimui.");
    };
}


?>
<?php include 'header.php' ?>
<div class="EditProfile">
    <div class="container col-lg-12 block">
        <div class="row col-xs-6 block2 bg-primary center">
            <legend><p color="white">Pasirinkite pomėgius</p></legend>
            <form style="text-align: right" method="post">
                Nerandate pomėgio?
                <button data-toggle="modal" data-target="#myModalSuggestHobby" style="background: #991ae3 " type="button" name="suggestBtn" value="Pasiūlyti Pomėgį"/>Pasiūlykite</button>
            </form>


            <form method="post" action="" class="form-horizontal" role="form" align="">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="name">Patinkantis Sportai<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <?php if (!empty($getFullHobbiesList)) { ?>
                            <?php foreach ($getFullHobbiesList as $sport) {
                                if ($sport->hobie_type == "Sport") { ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sport[]"
                                                      <?php
                                                      if (!empty($userHobbies)){
                                                      foreach ($userHobbies

                                                      as $userHobbieSport) {
                                                      if ($userHobbieSport->hobbie_name === $sport->hobbie_name) {
                                                      ?>checked <?php
                                            }
                                            }
                                            }
                                            ?>
                                                      value="<?php echo $sport->hobbie_name ?>"><?php echo $sport->hobbie_name ?>
                                        </label>
                                    </div>
                                <?php }
                            }
                        } ?>
                    </div>


                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="name">Patinkantis muzikos stilius<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <?php if (!empty($getFullHobbiesList)) { ?>
                            <?php foreach ($getFullHobbiesList as $music) {
                                if ($music->hobie_type == "Music") { ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="music[]"
                                                      <?php
                                                      if (!empty($userHobbies)){
                                                      foreach ($userHobbies

                                                      as $userHobbieMusic) {
                                                      if ($userHobbieMusic->hobbie_name === $music->hobbie_name) {
                                                      ?>checked <?php
                                            }
                                            }
                                            }

                                            ?>
                                                      value="<?php echo $music->hobbie_name ?>"><?php echo $music->hobbie_name ?>
                                        </label>
                                    </div>
                                <?php }
                            }
                        } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="name">Patinkantis knygų žanras<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <?php if (!empty($getFullHobbiesList)) { ?>
                            <?php foreach ($getFullHobbiesList as $book) {
                                if ($book->hobie_type == "Books") { ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="books[]"
                                                      <?php
                                                      if (!empty($userHobbies)){
                                                      foreach ($userHobbies

                                                      as $userHobbieBook) {
                                                      if ($userHobbieBook->hobbie_name === $book->hobbie_name) {
                                                      ?>checked <?php
                                            }
                                            }
                                            }

                                            ?>
                                                      value="<?php echo $book->hobbie_name ?>"><?php echo $book->hobbie_name ?>
                                        </label>
                                    </div>
                                <?php }
                            }
                        } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="name">Kiti pomėgiai<em>*</em></label>
                    <div class="col-sm-8 col-xs-12">
                        <?php if (!empty($getFullHobbiesList)) { ?>
                            <?php foreach ($getFullHobbiesList as $other) {
                                if ($other->hobie_type == "Other") { ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="otherHobbies[]"
                                                      <?php
                                                      if (!empty($userHobbies)){
                                                      foreach ($userHobbies

                                                      as $userHobbieOther) {
                                                      if ($userHobbieOther->hobbie_name === $other->hobbie_name) {
                                                      ?>checked <?php
                                            }
                                            }
                                            }

                                            ?>
                                                      value="<?php echo $other->hobbie_name ?>"><?php echo $other->hobbie_name ?>
                                        </label>
                                    </div>
                                <?php }
                            }
                        } ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <input type="submit" name="actionHobbieBtn" id="editProfileForm" value="Patvirtinti"
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
<div class="modal fade" id="myModalSuggestHobby" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Redaguoti naudotoją</h4>
            </div>
            <form method="post" action="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="hobby_name">Pavadinimas</label>
                        <input class="form-control hobbie_name" type="text" minlength="3"
                              name="name"  oninvalid="setCustomValidity('Minimalus pavadinimo ilgis - 3 simboliai!')"
                               oninput="setCustomValidity('')"
                               placeholder="Įvesti pavadinimą" required>
                    </div>
                    <div class="form-group">
                        <label for="hobby_type">Tipas</label>
                        <select name="type">
                            <option value="Sport">Sportas</option>
                            <option value="Music">Muzika</option>
                            <option value="Books">Knygos</option>
                            <option value="Other">Kiti pomėgiai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Uždaryti</button>
                    <button type="submit" name="suggestHobbieBtn" class="btn btn-primary">Pridėti</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal for Edit button -->
<script type="text/javascript">
    $(document).on("click", '.edit_button', function (e) {
        var id = $(this).data('id');
        var description = $(this).data('content');

        $(".post_content_id").val(id);
        $("#post_content").val(description);
        // tinyMCE.get('business_skill_content').setContent(content);
    });
</script>

<?php include 'footer.php' ?>
