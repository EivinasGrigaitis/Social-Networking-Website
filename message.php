<?php
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$user = $getFromUser->userData($user_id);
//$user = $getFromFriend->getAllUserFriends($user_id);
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}
?>
<?php include 'header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="message-body">
                <div class="message-left">
                    <p><b>KONTAKTAI </b></p>
                    <ul>
                        <?php
                        //show all the users expect me
                        // s
                        //                    $userQuery = $getMessageFromFriend->showAllUsers($user_id);
                        $userQuery = $getFromFriend->getAllUserFriends($user_id);
                        // $q = mysqli_query($con, "SELECT * FROM `user` WHERE id!='$user_id'");
                        //display all the results
                        if(!empty($userQuery)){
                            {
                                foreach ($userQuery as $user) {
                                    echo "<a href='message.php?id={$user->user_id}'><li><img src='{$user->profileImage}'> {$user->name}</li></a>";
                                }
                            }
                        }
                        else{
                            echo "Paskyra neturi kontaktų";
                        }

                        // while($row = mysqli_fetch_assoc($q)){
                        //     echo "<a href='message.php?id={$row['id']}'><li><img src='{$row['img']}'> {$row['username']}</li></a>";
                        // }
                        ?>
                    </ul>
                </div>

                <div class="message-right">
                    <!-- display message -->
                    <div class="display-message">
                        <?php
                        //check $_GET['id'] is set
                        if (isset($_GET['id'])) {
                            // $user_two = trim(mysqli_real_escape_string($con, $_GET['id']));
                            $user_two = $_GET['id'];
                            $user_two = $getFromUser->checkInput($user_two);
                            //check $user_two is valid
                            // $q = mysqli_query($con, "SELECT `id` FROM `user` WHERE id='$user_two' AND id!='$user_id'");
                            //valid $user_two
                            $validUserTwo = $getMessageFromFriend->checkUser($user_id, $user_two);
                            if ($validUserTwo === true) {
                                //check $user_id and $user_two has conversation or not if no start one
                                $conver = $getMessageFromFriend->checkIfUserHaveCon($user_id, $user_two);

                                //they have a conversation
                                if ($conver !== false) {
                                    //fetch the converstaion id
                                    // $fetch = mysqli_fetch_assoc($conver);
                                    $conversation_id = $conver->id;
                                } else if ($conver === false) { //they do not have a conversation
                                    //start a new converstaion and fetch its id

                                    $conversation_id = $getMessageFromFriend->inserConversation($user_id, $user_two);
                                }
                            } else {
                                die("Invalid $_GET ID.");
                            }
                        } else {
                            die("Pasirinkite kontaktą");
                        }
                        ?>
                    </div>
                    <!-- /display message -->

                    <!-- send message -->
                    <div class="send-message">
                        <!-- store conversation_id, user_from, user_to so that we can send send this values to post_message_ajax.php -->
                        <input type="hidden" id="conversation_id"
                               value="<?php echo base64_encode($conversation_id); ?>">
                        <input type="hidden" id="user_form" value="<?php echo base64_encode($user_id); ?>">
                        <input type="hidden" id="user_to" value="<?php echo base64_encode($user_two); ?>">
                        <div class="form-group">
                            <textarea class="form-control" id="message" placeholder="Rašykite žinutę"></textarea>
                        </div>
                        <button class="btn btn-primary" id="reply">Siųsti</button>
                        <span id="error"></span>
                    </div>
                    <!-- / send message -->
                </div>
            </div>
            <script type="text/javascript" src="assets/js/jquery.min.js"></script>
            <script type="text/javascript" src="assets/js/script.js"></script>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
