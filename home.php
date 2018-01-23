<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$user = $getFromUser->userData($user_id);
$navBarActive = "home";
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}
$userPosts = $getFromPost->getFriendAndUserPost($user_id);
// GetUserFriends
$userFriends = $getFromFriend->getFiveUserFriends($user_id);
// Delete Post
if (isset($_POST['deletePost'])) {
    $postId = (int)$_POST['post_id'];
    $postId = $getFromUser->checkInput($postId);
    $checkIfUserAuthor = $getFromPost->CheckAuthor($postId, $user_id);
    if ($checkIfUserAuthor === true) {
        if ($getFromPost->deletePost($postId, $user_id)) {
            $getFromUser->phpAlertMessage('Pranešimas ištrintas!');
            echo "<script>setTimeout(\"location.href = 'home.php';\",1500);</script>";
        }
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida!');
    }

}
?>

<?php include 'header.php'; ?>
<!-- User profile Image php echo $user->userProfileImage;  -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php include 'includes/profileWall.php' ?>
                <?php if (!empty($userPosts)) {
                    foreach ($userPosts as $post) {
                        ?>
                        <div class="panel panel-default post">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <a href="profile.php?id=<?php echo $post->user_id ?>"
                                           class="post-avatar thumbnail"><img
                                                    src="<?php echo $getFromUser->getUserProfilePic($post->user_id) ?>"
                                                    alt="">
                                            <div class="text-center"><?php echo $getFromUser->getUserNameById($post->user_id) ?></div>
                                        </a>
                                        <div class="likes text-center">
                                            <?php echo $post->date ?></div>
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

                                                <?php $match = $getFromPost->findYoutubeLink($post->description); ?>
                                                <?php if (!empty($match)) { ?>
                                                    <div class="video-container">
                                                        <div class="videoWrapper">
                                                            <?php echo $getFromPost->convertYoutube($match[0]); ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                            <div class="pointer-border"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } ?>
            </div>
            <!-- Addition panel -->
            <div class="col-md-4">
                <div class="panel panel-default friends">
                    <div class="panel-heading">
                        <h3 class="panel-title">Mano Draugai</h3>
                    </div>
                    <div class="panel-body">
                        <ul>
                            <?php if (!empty($userFriends)) { ?>
                                <?php foreach ($userFriends as $friend) { ?>
                                    <li><a href="profile.php?id=<?php echo $friend->user_id ?>" class="thumbnail"><img
                                                    src="<?php echo $getFromUser->getUserProfilePic($friend->user_id) ?>"
                                                    alt=""></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                        <div class="clearfix"></div>
                        <a class="btn btn-primary" href="contact.php">Peržiūrėti visus draugus</a>
                    </div>
                </div>
                <div class="panel panel-default groups">
                    <div class="panel-heading">
                        <h3 class="panel-title">Žmonės su bendrais interesais</h3>
                    </div>
                    <div class="panel-body">
                        <div class="group-item">
                            <img src="img/group.png" alt="">
                            <h4><a href="#" class="">Naudotojai turintis bendrus pomėgius</a></h4>
                            <p>Jeigu esate užpildė pomėgių anketą jums bus atrinkti naudotojai pagal bendrus
                                interesus.</p>
                        </div>
                        <div class="clearfix"></div>
                        <a href="match.php" class="btn btn-primary">Peržiūrėti atitikimus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- profile cover /assets/images/defaultProfileImage.png -->
<?php include 'includes/editPostForm.php' ?>
<?php include 'footer.php' ?>
