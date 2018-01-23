<?php
    // require_once("connect.php");
    require_once 'core/init.php';
    // $user_id      = $_SESSION['user_id'];
    if(isset($_GET['c_id'])){
        //get the conversation id and
        $conversation_id = base64_decode($_GET['c_id']);
        //fetch all the messages of $user_id(loggedin user) and $user_two from their conversation
        // $q = mysqli_query($con, "SELECT * FROM `messages` WHERE conversation_id='$conversation_id'");
        $selectAllConversationMessages = $getMessageFromFriend->GetAllConversationMessages($conversation_id);

        //check their are any messages
        if($selectAllConversationMessages !== false){
            foreach ($selectAllConversationMessages as $conversationInfo) {
            // while ($m = mysqli_fetch_assoc($q)) {
                //format the message and display it to the user
                // $user_form = $m['user_from'];
                // $user_to = $m['user_to'];
                // $message = $m['message'];
                $user_from =$conversationInfo->user_from;
                $user_to =$conversationInfo->user_to;
                $message =$conversationInfo->message;
 
                //get name and image of $user_form from `user` table
                // $user = mysqli_query($con, "SELECT username,img FROM `user` WHERE id='$user_form'");
                $userInfo = $getFromUser->getUserNameAndImage($user_from);
                // $user_fetch = mysqli_fetch_assoc($user);
                // $user_form_username = $user_fetch['username'];
                // $user_form_img = $user_fetch['img'];
                
                //display the message
                echo "
                            <div class='message'>
                                <div class='img-con'>
                                    <img src='{$userInfo->profileImage}'>
                                </div>
                                <div class='text-con'>
                                    <a href='#''>{$userInfo->name}</a>
                                    <p>{$message}</p>
                                </div>
                            </div>
                            <hr>";
 
            }
        }else{
            echo "Nėra žinučių";
        }
    }
 
?>