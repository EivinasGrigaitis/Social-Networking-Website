<?php
    require_once 'core/init.php';
    //post message
    if(isset($_POST['message'])){
        $message = $_POST['message'];
        $message = $getFromUser->checkInput($message);
        $conversation_id = $_POST['conversation_id'];
        $conversation_id = $getFromUser->checkInput($conversation_id);
        $user_from = $_POST['user_form'];
        $user_from = $getFromUser->checkInput($user_from);
        $user_to = $_POST['user_to'];
        $user_to = $getFromUser->checkInput($user_to);
 
        //decrypt the conversation_id,user_from,user_to
        $conversation_id = base64_decode($conversation_id);
        $user_from = base64_decode($user_from);
        $user_to = base64_decode($user_to);
 
        //insert into `messages`
        $query = $getMessageFromFriend->insertMessage($conversation_id, $user_from, $user_to, $message);
        if($query === true){
            echo "Nusiųsta";
        }else{

            echo "Įvyko klaida";
        }
    }
?>