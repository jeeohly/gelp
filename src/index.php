<?php
session_start();
header("Content-type: text/html; charset=iso-8859-1");
include_once("./classes/config.php");
include "./classes/functions.php";

if(isset($_SESSION['loggedIn'])){
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gelp</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Search-Field-With-Icon.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>

<body style="background-color: rgb(224,224,224);">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xl-8 offset-xl-2" id="postfeed" style="margin-top:50px;margin-bottom:100px;">

            </div>
        </div>
    </div>
</body>
<?php include "./classes/addReviewFront.php"; ?>
</html>
<?php
include "./classes/posts.php";
}else{
      header('Location: ./createAccount.php'); 
} 
?>
<?php include "./classes/nav.php"; ?>

