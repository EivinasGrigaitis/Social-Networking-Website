<!DOCTYPE html>
 <html>
    <head>
       <meta charset="utf-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>Socialinis tinklas</title>
       <!-- Bootstrap core CSS -->
       <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css" />
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
       <link rel="stylesheet" href="assets/css/style.css"/>
        <link href="assets/css/ekko-lightbox.css" rel="stylesheet">
    </head>
    <body <?php if((!empty($navBarActive)) && ($navBarActive ==="login")){?> class="backgroundLogin" <?php } ?> >
       <div class="navMenu">
         <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
               <div class="navbar-header">
                  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="index.php">Socialinis tinklas</a>
               </div>
               <center>
                  <div class="navbar-collapse collapse" id="navbar-main">
                     <?php
                     if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                         include 'includes/userInfoField.php';
                     } else {
                         include 'includes/login.php';
                     }
                     ?>
                  </div>
               </center>
            </div>
         </div>
         <div class="container col-lg-12 spacer"></div>
       </div>
