<?php
// edit post
if (isset($_POST['editPostButton'])) {
    $postId = (int)$_POST['post_content_id'];
    $postContent = $_POST['post_content'];
    $postId = $getFromUser->checkInput($postId);
    $postContent = $getFromUser->checkInput($postContent);

    $checkIfUserAuthor = $getFromPost->CheckAuthor($postId, $user_id);
    if ($checkIfUserAuthor === true) {
        if ($getFromPost->editPost($postId, $user_id, $postContent)) {
            $getFromUser->phpAlertMessage('Įrašas paredaguotas!');
            echo "<script>setTimeout(\"location.href = 'profile.php';\",1500);</script>";
        }
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida!');
    }
}
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Redaguoti įrašą</h4>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control post_content_id" type="hidden" name="post_content_id">
                        <!-- <input class="form-control business_skill_name" name="name" placeholder="Enter Skill" required> -->
                    </div>
                    <div class="form-group">
                        <input class="form-control post_content col-md-12 " type="hidden" name="post_content">
                        <!-- <label for="heading">Komentaro tekstas</label> -->
                        <textarea id="post_content" style="width: 100%" name="post_content"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Uždaryti</button>
                    <button type="submit" name="editPostButton" class="btn btn-primary">Patvirtinti ir išsaugoti
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal for Edit button -->
<script type="text/javascript">
    $(document).on("click", '.edit_button', function (e) {
        var id = $(this).data('id');
        var description = $(this).data('content');

        $(".post_content_id").val(id);
        $("#post_content").val(description);
        // tinyMCE.get('business_skill_content').setContent(content);
    });
</script>
