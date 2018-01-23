<?php
$user_id = $_SESSION['user_id'];
$user_status = $_SESSION['user_status'];
$user = $getFromUser->userData($user_id);
//$checkFriendRequest = $getFromFriend->checkFriendRequest($user_id);
// $getFromFriend->getAllUserFriends($user_id);
?>

<ul class="nav navbar-nav">
<!--    <li --><?php //if ((!empty($navBarActive)) && ($navBarActive === "home")) { ?><!-- class="active" --><?php //} ?><!-- ><a-->
<!--            href="home.php">Pagrindinis</a></li>-->
    <li <?php if ((!empty($navBarActive)) && ($navBarActive === "admin")) { ?> class="active" <?php } ?> ><a
            href="admin.php">Narių redagavimas</a></li>
    <li <?php if ((!empty($navBarActive)) && ($navBarActive === "blacklist")) { ?> class="active" <?php } ?> ><a
            href="blacklist.php">Blokuoti Nariai</a></li>
    <li <?php if ((!empty($navBarActive)) && ($navBarActive === "posts")) { ?> class="active" <?php } ?> ><a
                href="editPosts.php">Naudotojų pranešimai</a></li>
    <li <?php if ((!empty($navBarActive)) && ($navBarActive === "hobbielist")) { ?> class="active" <?php } ?> ><a
            href="hobbielist.php">Pomėgių sąrašas</a></li>


</ul>
<div class="logout-div">
<form action="includes/logout.php" class="navbar-form navbar-right" role="search">
    <div class="form-group">
        <label class="control-label col-sm-3"><?php echo $user->email; ?><em>*</em></label>
    </div>
    <input type="submit" name="logoutForm" class="btn btn-default" value="Atsijungti">
</form>
</div>
