<?php
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];
$user = $getFromUser->userData($user_id);
$checkFriendRequest = $getFromFriend->checkFriendRequest($user_id);
// $getFromFriend->getAllUserFriends($user_id);
?>

<ul class="nav navbar-nav">
    <li <?php if ((!empty($navBarActive)) && ($navBarActive === "home")) { ?> class="active" <?php } ?> ><a
                href="home.php">Pagrindinis</a></li>
    <li <?php if ((!empty($navBarActive)) && ($navBarActive === "profile")) { ?> class="active" <?php } ?>><a
                href="profile.php">Profilis</a></li>
    <li <?php if ((!empty($navBarActive)) && ($navBarActive === "members")) { ?> class="active" <?php } ?> ><a
                href="members.php">Narių paieška</a></li>
    <li <?php if ($checkFriendRequest === true) { ?> class="requestFlag" <?php } ?> <?php if ((!empty($navBarActive)) && ($navBarActive === "contact")) { ?> class="active" <?php } ?>>
        <a href="contact.php">Mano draugai</a></li>
    <li <?php if ((!empty($navBarActive)) && ($navBarActive === "photos")) { ?> class="active" <?php } ?>><a
                href="photos.php">Nuotraukos</a></li>

    <li <?php if ((!empty($navBarActive)) && ($navBarActive === "message")) { ?> class="active" <?php } ?>><a
                href="message.php">Žinutės</a></li>
    <?php if ($user_role == 1) { ?>
        <li <?php if ((!empty($navBarActive)) && ($navBarActive === "admin")) { ?> class="active" <?php } ?>><a
                    href="admin.php"><b>Admin</b></a></li>  <?php } ?>
</ul>
<div class="logout-div">
<form action="includes/logout.php" class="navbar-form navbar-right" role="search">
    <div class="form-group">
        <label class="control-label col-sm-3"><?php echo $user->email; ?><em>*</em></label>
    </div>
    <input type="submit" name="logoutForm" class="btn btn-default" value="Atsijungti">
</form>
</div>
