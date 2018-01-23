<?php
if (isset($_POST['postTextBtn'])) {
    // $getFromUser->phpAlertMessage();
    $textArea = $_POST['textArea'];
    if(!empty($textArea)){
        $textArea = $getFromUser->checkInput($textArea);

        if($getFromPost->postCommet($user_id, $textArea) === true){
            $successMessage = "Paskelbtas pranešimas";
            $getFromUser->phpAlertMessage($successMessage);
            echo "<script>setTimeout(\"location.href = 'profile.php';\",1500);</script>";
        }
        else{
            $errorMessage = "Įvyko klaida";
            $getFromUser->phpAlertMessage($errorMessage);
        }
    }
    else{
        $errorMessage = "Užpildykite pranešimą";
        $getFromUser->phpAlertMessage($errorMessage);
    }
}
 ?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Profilio siena</h3>
      </div>
      <div class="panel-body">
        <form method="post">
          <div class="form-group">
            <textarea class="form-control" name="textArea" placeholder="Rašyti ant sienos"></textarea>
          </div>
          <button type="submit" name="postTextBtn" class="btn btn-default">Paskelbti</button>
          <div class="pull-right">
            <div class="btn-toolbar">
<!--              <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i>Text</button>-->
<!--              <button type="button" class="btn btn-default"><i class="fa fa-file-image-o"></i>Image</button>-->
<!--              <button type="button" class="btn btn-default"><i class="fa fa-file-video-o"></i>Video</button>-->
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
