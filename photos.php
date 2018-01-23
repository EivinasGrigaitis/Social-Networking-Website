<?php
/**
 * User: eivinas
 * Date: 17.11.17
 * Time: 13.54
 */
require_once 'core/init.php';
$user_id = $_SESSION['user_id'];
$navBarActive = "photos";
if ($getFromUser->isUserLoggedIn() === false) {
    header('Location: index.php');
}
//Upload Photo
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 400000) {
                //If picture size lesser than 4000 kb ~4MB
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $user_id . '/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                if ($getUserPhoto->insertPhoto($user_id, $fileNameNew, $fileDestination) === true) {

                    $getFromUser->phpAlertMessage('Nuotrauka įkelta!');
                    header("Location: photos.php?uploadsuccess");
                } else {
                    $getFromUser->phpAlertMessage('Kažkas atsitiko!');
                }
            } else {
                $getFromUser->phpAlertMessage('Nuotrauka perdidelė! Negali viršyti 4MB!');
            }
        } else {
            $getFromUser->phpAlertMessage('Įvyko klaida bandant įkelti nuotrauką!"');
        }
    } else {
        $getFromUser->phpAlertMessage('Nuotraukos formatas netinkamas! Prašome įkelti nuotrauką');
    }
}
//Make main photo
if (isset($_POST['makeMainPicture'])) {
    $picture_Id = $_POST['picture_id'];
    if ($getUserPhoto->makePictureMain($user_id, $picture_Id) === true) {
        $getFromUser->phpAlertMessage("Profilio nuotrauka pakeista!");
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida');
    }
}
//Delete picture
if (isset($_POST['deletePicture'])) {
    $picture_Id = $_POST['picture_id'];
    if ($getUserPhoto->deletePicture($user_id, $picture_Id) === true) {
        $getFromUser->phpAlertMessage('Nuotrauka ištrinta');
    } else {
        $getFromUser->phpAlertMessage('Įvyko klaida trinant nuotrauka');
    }

}
//Get User pictures
$userPictures = $getUserPhoto->getUserPictures($user_id);
?>



<?php include 'header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <b>Įkelkite nuotrauką</b>
                <form action="" method="POST" enctype="multipart/form-data">
                    
                    <input type="file" name="file">
                    <button type="submit" name="submit">Įkelti nuotrauką</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Nuotraukos</h1>
                <ul class="photos gallery-parent">
                    <div class="row">
                        <?php if (!empty($userPictures)) { ?>
                            <?php foreach ($userPictures as $picture) { ?>
                                <li style="text-align: center"><a href="<?php echo $picture->picture_link ?>"
                                                                  data-hover="tooltip"
                                                                  data-placement="top" title="image"
                                                                  data-gallery="mygallery" data-parent=".gallery-parent"
                                                                  data-title="Nuotrauka"
                                                                  data-footer="Antraštė" data-toggle="lightbox"><img
                                                src="<?php echo $picture->picture_link ?>"
                                                class="img-thumbnail" alt=""></a>
                                    <div class="options">
                                        <form method="POST">
                                            <strong>
                                                <input type="hidden" name="picture_id"
                                                       value="<?php echo $picture->picture_Id; ?>">
                                                <a href="#"
                                                   onClick="return confirm('Ar norite padaryti paveikslą profilio nuotrauka?')">
                                                    <input class="btn btn-success btn-xs delete_button" type="submit"
                                                           name="makeMainPicture" value="Padaryti pagrindine"/></a>
                                            </strong>
                                        </form>
                                        |
                                        <form method="POST">
                                            <strong>
                                                <input type="hidden" name="picture_id"
                                                       value="<?php echo $picture->picture_Id; ?>">
                                                <a href="#" onClick="return confirm('Ar norite ištrinti nuotrauką?')">
                                                    <input class="btn btn-danger btn-xs delete_button" type="submit"
                                                           name="deletePicture" value="Ištrinti paveikslą"/></a>
                                            </strong>
                                        </form>
                                    </div>
                                </li>

                            <?php } ?>
                        <?php } ?>

                    </div>


                </ul>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
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
