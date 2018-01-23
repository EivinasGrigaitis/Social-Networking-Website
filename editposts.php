<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];
$navBarActive = "posts";
$getAllUsersPost = $getFromPost->getAllPosts($user_id);

if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}
if ($user_role == 1) {
//    echo $user_role;
} else {
    header('Location: index.php');
}


if (isset($_POST['editUserBtn'])) {
    $userId = (int)$_POST['user_id'];
    $userPostId = $_POST['post_id'];
    $userDescription = $_POST['description'];


    $userId = $getFromUser->checkInput($userId);
    $userPostId = $getFromUser->checkInput($userPostId);
    $userDescription = $getFromUser->checkInput($userDescription);

    if ($getFromPost->editPost($userPostId, $userId, $userDescription)) {

        $getFromUser->phpAlertMessage('Pranešimas paredaguotas');

        echo "<script>setTimeout(\"location.href = 'editPosts.php';\",500);</script>";
    }


}
if (isset($_POST['deletePost'])) {
    $post_id = (int)$_POST['post_id'];
    $post_id = $getFromUser->checkInput($post_id);

    if ($getFromPost->deletePostAdmin($post_id)) {
        $getFromUser->phpAlertMessage('Pranešimas ištrintas!');
        echo "<script>setTimeout(\"location.href = 'editPosts.php';\",500);</script>";
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida!');
    }


}
if (isset($_POST['searchUser'])) {
    $email = $_POST['email'];
    $email = $getFromUser->checkInput($email);

    $result = $getFromUser->getUserIdByEmail($email);

    $getAllUsersPost = $getFromPost->getProfilePosts($result);
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
                <form method="post" action="" role="form">
                    <div class="messages"></div>
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label for="usertoFind"> Ieškoti pagal el. paštą*</label>
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
        <div class="row">
            <div class="col-md-12">
                <label>Naudotojų pranešimai</label>
                <table class="table table-striped table-bordered" id="store-table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Naudotojas</th>
                        <th>Aprašymas</th>
                        <th>Veiksmas</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($getAllUsersPost)){ ?>
                    <?php foreach ($getAllUsersPost as $post) { ?>
                        <tr>
                            <td width="5%;"><?php echo $post->post_id ?> </td>
                            <td style="width:30%;"><?php echo $getFromUser->getUserNameById($post->user_id) ?></td>
                            <td style="width:60%;"><?php echo $post->description ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-xs edit_button"
                                        data-toggle="modal" data-target="#myModal"
                                        data-id="<?php echo $post->post_id ?>"
                                        data-userid="<?php echo $post->user_id ?>"
                                        data-description="<?php echo $post->description ?>"
                                >
                                    Redaguoti
                                </button>

                            </td>
                            <td>
                                <form method="POST">
                                    <strong>
                                        <input type="hidden" name="post_id"
                                               value="<?php echo $post->post_id ?>">
                                        <a href="#" onClick="return confirm('Ar tikrai norite ištrinti pranešimą?')">
                                            <input class="btn btn-danger btn-xs delete_button" type="submit"
                                                   name="deletePost" value="Ištrinti"/></a>
                                    </strong>
                                </form>
                            </td>
                        </tr>
                    <?php } ?><?php } ?>
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
                <h4 class="modal-title" id="myModalLabel">Redaguoti pranešimą</h4>
            </div>
            <form method="post" action="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="user_name">Pranešimo tekstas</label>
                        <input class="form-control post_id" type="hidden" name="post_id">
                        <input class="form-control user_id" type="hidden" name="user_id">
                        <textarea class="form-control description" type="hidden" name="description"
                                  placeholder="Pranešimo tekstas" required></textarea>
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
        var user_id = $(this).data('userid');
        var post_id = $(this).data('id');
        var description = $(this).data('description');
        $(".post_id").val(post_id);
        $(".user_id").val(user_id);
        $(".description").val(description);


    });
</script>
<?php include 'footer.php'; ?>
