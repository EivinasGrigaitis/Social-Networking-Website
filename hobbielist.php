<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];
$navBarActive = "hobbielist";
$getAllHobbies = $getUserAdmin->getAllHobbies();
$getSuggestHobbies = $getUserHobbie->selectSuggestHobbies();
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}
if ($user_role == 1) {
//    echo $user_role;
} else {
    header('Location: index.php');
}


if (isset($_POST['editHobbieBtn'])) {
    $hobbieId = (int)$_POST['id'];
    $hobbieName = $_POST['name'];
    $hobbieType = $_POST['type'];

    $hobbieId = $getFromUser->checkInput($hobbieId);
    $hobbieName = $getFromUser->checkInput($hobbieName);
    $hobbieType = $getFromUser->checkInput($hobbieType);
//    echo " Id - ". $user_id. "| Email - ". $userEmail . "| NAME - " .$userName. "| Password - ". $userPasswd .
//        " |user Role - ".$userRole ."| Warning - ". $userWarning;

    $question = $getUserAdmin->editHobbie($hobbieId, $hobbieName, $hobbieType);
    if (($question)) {
        $getFromUser->phpAlertMessage('Pomėgio informacija paredaguota');
        echo "<script>setTimeout(\"location.href = 'hobbielist.php';\",1500);</script>";
    }

}
if (isset($_POST['addHobbieBtn'])) {

    $hobbieName = $_POST['name'];
    $hobbieType = $_POST['type'];

    $hobbieName = $getFromUser->checkInput($hobbieName);
    $hobbieType = $getFromUser->checkInput($hobbieType);
    echo $hobbieName . " Type -" . $hobbieType;

    $addHobbie = $getUserAdmin->addHobby($hobbieName, $hobbieType);
    if (($addHobbie)) {
        $getFromUser->phpAlertMessage('Pomėgis pridėtas');
        echo "<script>setTimeout(\"location.href = 'hobbielist.php';\",500);</script>";
    }
}
//delete hobby
if (isset($_POST['deleteHobby'])) {
    $hobbyId = (int)$_POST['hobby_id'];
    $hobbyId = $getFromUser->checkInput($hobbyId);

    if ($getUserAdmin->deleteHobby($hobbyId)) {
        $getFromUser->phpAlertMessage('Pomėgis ištrintas!');
        echo "<script>setTimeout(\"location.href = 'hobbielist.php';\",500);</script>";
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida!');
    }


}
if(isset($_POST['suggestHobbieBtn'])){
    $hobbieId = (int)$_POST['id'];
    $hobbieName = $_POST['name'];
    $hobbieType = $_POST['type'];

    $hobbieId = $getFromUser->checkInput($hobbieId);
    $hobbieName = $getFromUser->checkInput($hobbieName);
    $hobbieType = $getFromUser->checkInput($hobbieType);
    $addHobbie = $getUserAdmin->addHobby($hobbieName, $hobbieType);
    if (($addHobbie)) {

        $getSuggestHobbies = $getUserHobbie->deleteSuggestHobby($hobbieId);
        $getSuggestHobbies = $getUserHobbie->selectSuggestHobbies();
        $getFromUser->phpAlertMessage('Pomėgis pridėtas');
        echo "<script>setTimeout(\"location.href = 'hobbielist.php';\",100);</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Socialinis tinklas</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link href="assets/css/ekko-lightbox.css" rel="stylesheet">
</head>
<body <?php if ((!empty($navBarActive)) && ($navBarActive === "login")) { ?> class="backgroundLogin" <?php } ?> >
<div class="navMenu">
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Grįžti atgal</a>
            </div>
            <center>
                <div class="navbar-collapse collapse" id="navbar-main">
                    <?php
                    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                        include 'includes/adminInfoField.php';
                    }
                    ?>
                </div>
            </center>
        </div>
    </div>
    <div class="container col-lg-12 spacer"></div>
</div>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <label>Narių pasiūlyti pomėgiai</label>
                <table class="table table-striped table-bordered" id="store-table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Pomėgis</th>
                        <th>Tipas</th>
                        <th>Nario id</th>
                        <th>Redaguoti</th>
                        <th>Trinti</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($getSuggestHobbies)) {
                        foreach ($getSuggestHobbies as $hobby) { ?>
                            <tr>
                                <td width="5%;"><?php echo $hobby->suggest_id ?> </td>
                                <td style="width:45%;"><?php echo $hobby->suggest_name ?></td>
                                <td style="width:25%;"><?php echo $hobby->suggest_type ?></td>
                                <td style="width:25%;"><?php echo $hobby->suggest_user_id?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-xs edit_button"
                                            data-toggle="modal" data-target="#suggestModel"
                                            data-id="<?php echo $hobby->suggest_id ?>"
                                            data-name="<?php echo $hobby->suggest_name ?>"
                                            data-type="<?php echo $hobby->suggest_type ?>"
                                    >
                                        Peržiūrėti
                                    </button>
                                </td>
                                <td>
                                    <form method="POST">
                                        <strong>
                                            <input type="hidden" name="suggest_id"
                                                   value="<?php echo $hobby->suggest_id  ?>">
                                            <a href="#" onClick="return confirm('Ar tikrai norite ištrinti pomėgį?')">
                                                <input class="btn btn-danger btn-xs delete_button" type="submit"
                                                       name="deleteSuggestHobby" value="Ištrinti"/></a>
                                        </strong>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Pomėgių sąrašas</label>
                <table class="table table-striped table-bordered" id="store-table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Pomėgis
                            <button type="button" class="btn btn-success btn-xs edit_button"
                                    data-toggle="modal" data-target="#myModalAddHobby"
                            >
                                Pridėti pomėgį
                            </button>
                        </th>
                        <th>Tipas</th>
                        <th>Redaguoti</th>
                        <th>Trinti</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($getAllHobbies)) {
                        foreach ($getAllHobbies as $hobby) { ?>
                            <tr>
                                <td width="5%;"><?php echo $hobby->hobbie_id ?> </td>
                                <td style="width:45%;"><?php echo $hobby->hobbie_name ?></td>
                                <td style="width:30%;"><?php echo $hobby->hobie_type ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-xs edit_button"
                                            data-toggle="modal" data-target="#myModal"
                                            data-id="<?php echo $hobby->hobbie_id ?>"
                                            data-name="<?php echo $hobby->hobbie_name ?>"
                                            data-type="<?php echo $hobby->hobie_type ?>"
                                    >
                                        Redaguoti
                                    </button>
                                </td>
                                <td>
                                    <form method="POST">
                                        <strong>
                                            <input type="hidden" name="hobby_id"
                                                   value="<?php echo $hobby->hobbie_id ?>">
                                            <a href="#" onClick="return confirm('Ar tikrai norite ištrinti pomėgį?')">
                                                <input class="btn btn-danger btn-xs delete_button" type="submit"
                                                       name="deleteHobby" value="Ištrinti pomėgį"/></a>
                                        </strong>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<!-- Modal for Edit button -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pomėgio redagavimas</h4>
            </div>
            <form method="post" action="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="user_name">Pavadinimas</label>
                        <input class="form-control hobbie_id" type="hidden" name="id">
                        <input class="form-control hobbie_name" type="text" maxlength="20"
                               oninvalid="setCustomValidity('Minimalus vardas - 3 simboliai')" name="name"
                               placeholder="Įvesti pavadinimą" required>
                    </div>
                    <div class="form-group">
                        <label for="user_email">Tipas</label>
                        <input class="form-control hobbie_type" type="hidden" name="type">
                        <input class="form-control hobbie_type" name="type" placeholder="Įveskite tipą"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Uždaryti</button>
                    <button type="submit" name="editHobbieBtn" class="btn btn-primary">Padaryti pakeitimus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal for Edit button -->
<!-- Modal for Adding Hobby-->
<div class="modal fade" id="myModalAddHobby" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pridėti pomėgį</h4>
            </div>
            <form method="post" action="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="hobby_name">Pavadinimas</label>
                        <input class="form-control hobbie_name" type="text" minlength="3"
                               oninvalid="setCustomValidity(' ')" name="name"
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
                    <button type="submit" name="addHobbieBtn" class="btn btn-primary">Pridėti</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--End of Modal for Adding hobby -->
<!--Suggest Model-->
<div class="modal fade" id="suggestModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Peržiūrėti pomėgio pasiūlymą</h4>
            </div>
            <form method="post" action="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="user_name">Pavadinimas</label>
                        <input class="form-control hobbie_id" type="hidden" name="id">
                        <input class="form-control hobbie_name" type="text" maxlength="20"
                               oninvalid="setCustomValidity('Minimalus vardas - 3 simboliai')" name="name"
                               placeholder="Įvesti pavadinimą" required>
                    </div>
                    <div class="form-group">
                        <label for="user_email">Tipas</label>
                        <input class="form-control hobbie_type" type="hidden" name="type">
                        <input class="form-control hobbie_type" name="type" placeholder="Įveskite tipą"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Uždaryti</button>
                    <button type="submit" name="suggestHobbieBtn" class="btn btn-primary">Patvirtinti</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).on("click", '.edit_button', function (e) {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var type = $(this).data('type');
        $(".hobbie_id").val(id);
        $(".hobbie_name").val(name);
        $(".hobbie_type").val(type);

    });
</script>
<?php include 'footer.php'; ?>
