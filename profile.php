<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$navBarActive = "profile";
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}
//Post
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (!empty($id)) {
    $id = $getFromUser->checkInput($id);
    if ($id === $user_id) {
        $profile = "user";
        // echo 'user equal to guest';
        $userPostsBar = true;
        $userProfileInfo = $getFromUser->userData($user_id);
        $userPosts = $getFromPost->getProfilePosts($user_id);
        $userPictures = $getUserPhoto->getUserPictures($user_id);
    } else {
        $profile = "guest";
        // echo 'guest';
        $userPostsBar = false;
        $userProfileInfo = $getFromUser->userData($id);
        $userPosts = $getFromPost->getProfilePosts($id);
        $userPictures = $getUserPhoto->getUserPictures($id);
    }
} else {
    $profile = "user";
    // echo 'user';
    $userPostsBar = true;
    $userProfileInfo = $getFromUser->userData($user_id);
    $userPosts = $getFromPost->getProfilePosts($user_id);
    $userPictures = $getUserPhoto->getUserPictures($user_id);
}
if (isset($_POST['deletePost'])) {
    $postId = (int)$_POST['post_id'];
    $postId = $getFromUser->checkInput($postId);
    $checkIfUserAuthor = $getFromPost->CheckAuthor($postId, $user_id);
    if ($checkIfUserAuthor === true) {
        if ($getFromPost->deletePost($postId, $user_id)) {
            $getFromUser->phpAlertMessage('Pranešimas ištrintas!');
            echo "<script>setTimeout(\"location.href = 'profile.php';\",1500);</script>";
        }
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida!');
    }

}

?>
<?php include 'header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <!-- profile -->
            <div class="col-md-8">
                <div class="profile">
                    <h1 class="page-header"><?php echo $userProfileInfo->email; ?></h1>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?php echo $userProfileInfo->profileImage; ?>" class="img-thumbnail" alt="">
                        </div>

                        <div class="col-md-8">
                            <ul>
                                <li><strong>Vardas: </strong><?php echo $userProfileInfo->name ?></
                                </li>
                                <li><strong>El. Paštas: </strong><?php echo $userProfileInfo->email; ?></li>
                                <li>
                                    <strong>Lytis: </strong><?php echo $getFromUser->checkGenre($userProfileInfo->genre) ?>
                                </li>
                                <li><strong>Gimimo data: </strong><?php echo $userProfileInfo->birthDate; ?></li>
                                 <li><strong>Įspėjimai: </strong><?php echo $userProfileInfo->warning; ?></li>
                                <?php if ($profile === "user") { ?>
                                    <li><strong><a href="profileEdit.php">Redaguoti Profilį</a></strong></li>
                                    <li><strong><a href="passwordEdit.php">Keisti slaptažodį</a></strong></li>
                                    <li><strong><a href="hobbies.php">Redaguoti pomėgius</a></strong></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h1 class="page-header">Nuotraukos</h1>
                        <ul class="photos gallery-parent">
                            <div class="row">
                                <?php if (!empty($userPictures)) { ?>
                                    <?php foreach ($userPictures as $picture) { ?>
                                        <li style="text-align: center"><a href="<?php echo $picture->picture_link ?>"
                                                                          data-hover="tooltip"
                                                                          data-placement="top" title="image"
                                                                          data-gallery="mygallery"
                                                                          data-parent=".gallery-parent"
                                                                          data-title="Nuotrauka"
                                                                          data-footer="Antraštė" data-toggle="lightbox"><img
                                                        src="<?php echo $picture->picture_link ?>"
                                                        class="img-thumbnail" alt=""></a>
                                        </li>

                                    <?php } ?>
                                <?php } ?>

                            </div>
                        </ul>
                    </div>
                    <br><br>
                    <!-- WALL -->
                    <?php
                    if ($userPostsBar === true) {
                        include 'includes/profileWall.php';
                    } else { ?>
                        <div class="row"></div>
                    <?php }
                    ?>

                    <?php if (!empty($userPosts)) {
                        foreach ($userPosts

                                 as $post) { ?>
                            <div class="panel panel-default post">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <a href="profile.php" class="post-avatar thumbnail">
                                                <img src="<?php echo $getFromUser->getUserProfilePic($post->user_id) ?>"
                                                     alt="">
                                                <div class="text-center"><?php echo $getFromUser->getUserNameById($post->user_id) ?></div>
                                            </a>
                                            <div class="text-center"><?php echo $post->date ?></div>

                                        </div>
                                        <div class="col-sm-9">
                                            <?php if ($user_id === $post->user_id) { ?>
                                                <div class="options ">
                                                    <strong>
                                                        <button type="button" class="btn btn-primary btn-xs edit_button"
                                                                data-toggle="modal" data-target="#myModal"
                                                                data-content="<?php echo $post->description; ?>"
                                                                data-id="<?php echo $post->post_id; ?>">
                                                            Redaguoti
                                                        </button>
                                                    </strong>
                                                    |
                                                    <form method="POST">
                                                        <strong>
                                                            <input type="hidden" name="post_id"
                                                                   value="<?php echo $post->post_id; ?>">
                                                            <a href="#"
                                                               onClick="return confirm('Ar norite ištrinti pranešimą?')">
                                                                <input class="btn btn-danger btn-xs delete_button"
                                                                       type="submit" name="deletePost"
                                                                       value="Ištrinti pranešimą"/></a>
                                                        </strong>
                                                    </form>
                                                </div>
                                            <?php } ?>
                                            <div class="bubble">
                                                <div class="pointer">
                                                    <p><?php echo $post->description; ?></p>
                                                    <?php
                                                    $match = $getFromPost->findYoutubeLink($post->description);
                                                    if (!empty($match)) { ?>
                                                    <div class="video-container">
                                                        <div class="videoWrapper">
                                                        <?php echo $getFromPost->convertYoutube($match[0]);
                                                        } ?></div></div>

                                                </div>
                                                <div class="pointer-border"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hidden edit bar -->
<!-- Modal for Edit button -->
<?php include 'includes/editPostForm.php' ?>
<!-- End of Modal for Edit button -->
<?php include 'footer.php' ?>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/ekko-lightbox.js"></script>
<script>
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
    $(function () {
        $('[data-hover="tooltip"]').tooltip()
    })

</script>

