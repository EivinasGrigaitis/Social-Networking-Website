<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];
$navBarActive = "blacklist";
$getAllUsers = $getUserAdmin->getAllBlackListUsers();
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}
if ($user_role == 1) {
//    echo $user_role;
} else {
    header('Location: index.php');
}


if (isset($_POST['editUserBtn'])) {
    $userId = (int)$_POST['id'];
    $userEmail = $_POST['email'];
    $userName = $_POST['name'];
    $userPasswd = $_POST['password'];
    $userRole = $_POST['role'];
    $userWarning = $_POST['warning'];

    $userId = $getFromUser->checkInput($userId);
    $userEmail = $getFromUser->checkInput($userEmail);
    $userPasswd = $getFromUser->checkInput($userPasswd);
    $userName = $getFromUser->checkInput($userName);
    $userRole = $getFromUser->checkInput($userRole);
    $userWarning = $getFromUser->checkInput($userWarning);
//    echo " Id - ". $user_id. "| Email - ". $userEmail . "| NAME - " .$userName. "| Password - ". $userPasswd .
//        " |user Role - ".$userRole ."| Warning - ". $userWarning;


    if ($getUserAdmin->editUser($userId, $userName, $userEmail, $userRole, $userWarning) and $getUserAdmin->checkPassword($userId, $userPasswd)) {

        $getFromUser->phpAlertMessage('Naudotojo informacija paredaguota ');

        echo "<script>setTimeout(\"location.href = 'blacklist.php';\",1500);</script>";
    }

//    $checkIfUserAuthor = $getFromPost->CheckAuthor($postId, $user_id);
//    if ($checkIfUserAuthor === true) {
//
//    } else {
//        $getFromUser->phpAlertMessage('Įvyko klaida!');
//    }
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
                <label>Blokuoti nariai</label>
                <table class="table table-striped table-bordered" id="store-table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Slapyvardis</th>
                        <th>El-paštas</th>
                        <th>Slaptažodis</th>
                        <th>Veiksmas</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($getAllUsers)){
                    foreach ($getAllUsers as $users) { ?>
                        <tr>
                            <td width="5%;"><?php echo $users->user_id ?> </td>
                            <td style="width:30%;"><?php echo $users->name ?></td>
                            <td style="width:30%;"><?php echo $users->email ?></td>
                            <td style="width:35%;">********</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-xs edit_button"
                                        data-toggle="modal" data-target="#myModal"
                                        data-id="<?php echo $users->user_id ?>"
                                        data-name="<?php echo $users->name ?>"
                                        data-email="<?php echo $users->email ?>"
                                        data-password="<?php echo $users->password ?>"
                                        data-role="<?php echo $users->role ?>"
                                        data-warning="<?php echo $users->warning ?>"
                                >
                                    Redaguoti
                                </button>

                            </td>
                        </tr>
                    <?php }} ?>
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
                <h4 class="modal-title" id="myModalLabel">Redaguoti naudotoją</h4>
            </div>
            <form method="post" action="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="user_name">Slapyvardis</label>
                        <input class="form-control user_id" type="hidden" name="id">
                        <input class="form-control user_name" type="text" maxlength="20"
                               oninvalid="setCustomValidity('Maksimalus slapyvardžio ilgis - 6 simboliai')" name="name"
                               placeholder="Įvesti slapyvardį" required>
                    </div>
                    <div class="form-group">
                        <label for="user_email">El-paštas</label>
                        <input class="form-control user_email" type="hidden" name="email">
                        <input class="form-control user_email" name="email" placeholder="Įveskite el-paštą"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="user_password">Slaptažodis</label>
                        <input class="form-control user_password" type="hidden" name="password">
                        <input class="form-control user_password" minlength=6
                               oninvalid="setCustomValidity('Minimalus slaptažodžio ilgis - 6 simboliai')"
                               type="password" name="password"
                               placeholder="Įveskite slaptažodį"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="user_status">Statusas</label>
                        <input class="form-control user_role" type="hidden" name="role">
                        <input class="form-control user_role" type="number" min="0" max="1"
                               oninvalid="setCustomValidity('0 - neturi administratoriaus teisių, 1 - turi')"
                               name="role"
                               placeholder="0 - neturi administratoriaus teisių, 1 - turi"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="user_warning">Įspėjimai</label>
                        <input class="form-control user_warning" type="hidden" name="warning">
                        <input class="form-control user_warning" type="number" type="number" min="0" max="2"
                               oninvalid="setCustomValidity('0 - nėra įspėjimų, 1 - įspėjimas, 2 - blokas')"
                               name="warning"
                               placeholder="0 - nėra įspėjimų, 1 - įspėjimas, 2 - blokas"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Uždaryti</button>
                    <button type="submit" name="editUserBtn" class="btn btn-primary">Padaryti pakeitimus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal for Edit button -->
<script type="text/javascript">

    $(document).on("click", '.edit_button', function (e) {
        var name = $(this).data('name');
        var id = $(this).data('id');
        var email = $(this).data('email');
        var password = $(this).data('password');
        var role = $(this).data('role');
        var warning = $(this).data('warning');
        $(".user_id").val(id);
        $(".user_name").val(name);
        $(".user_password").val(password);
        $(".user_email").val(email);
        $(".user_warning").val(warning);
        $(".user_role").val(role);


    });
</script>
<?php include 'footer.php'; ?>
