<?php require_once 'core/init.php'; ?>
<?php $navBarActive = "login"; ?>
<?php include 'header.php'; ?>
<?php $errorMssg = $_GET['errorMssg'];?>
<?php if(empty($errorMssg)){
    header('Location: login.php');
} ?>
<div class="SignupForm">
    <div class="container col-lg-12 block">
        <div class="row col-xs-6 block2 bg-primary center">
            <legend><p color="white">Svarbu!</p></legend>
            <p><?php if(!empty($errorMssg)){echo $errorMssg; }  ?></p>
        </div>
    </div>
</div>
<?php include 'footer.php';?>
