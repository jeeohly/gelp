<?php
session_start();
header("Content-type: text/html; charset=iso-8859-1");
include_once("./config.php");

$queryAll = "SELECT * FROM Review ORDER BY id DESC";
$resultAll = mysqli_query($con, $queryAll);

if(isset($_SESSION['loggedIn'])){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gelp</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Search-Field-With-Icon.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>


<nav class="navbar navbar-light navbar-expand-md navigation-clean">
    <div class="container">
    	<a class="navbar-brand" href="#">Gelp</a>
    	<input class="form-control" style="width:50%" type="text" placeholder="Search.." name="search">
    	<button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
    		<span class="sr-only">Toggle navigation</span>
    		<span class="navbar-toggler-icon"></span>
    	</button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Main</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="./profile.php?id=<?php echo $_SESSION['loggedIn'] ?>">Profile</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="./leaderboard.php">Leaderboard</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Arena</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="./logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<body>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xl-8 offset-xl-2" id="postfeed" style="margin-bottom:30px;">
            </div>
        </div>
    </div>
</body>

</html>
<?php while($row = mysqli_fetch_array($resultAll)):
    $postUser1 = mysqli_query($con, "SELECT username FROM User WHERE id = '$row[1]'");
    $postUser1r = mysqli_fetch_array($postUser1)[0];
    $postUser2 = mysqli_query($con, "SELECT username FROM User WHERE id = '$row[2]'");
    $postUser2r = mysqli_fetch_array($postUser2)[0];
?>
    <script>
        document.getElementById("postfeed").innerHTML += "<div class='card' style='margin-top:15px;'><div class='card-header'><img class ='postprofileimg' src='https://i.imgur.com/wyYAmyX.jpg'><a href='./profile.php?id=<?php echo $row[1]; ?>'><span class='postname' id='postreviewer'><?php echo $postUser1r; ?></span></a> is reviewing <a href='./profile.php?id=<?php echo $row[2]; ?>''><span class='postname' id='postreviewing'><?php echo $postUser2r; ?></span></a><span class='postdate'><?php echo $row[5]; ?></span></div><div class='card-body'><?php echo $row[3]; ?></div><div class='card-footer' style='padding-top:0px;padding-bottom:0px;'><div class='row'><div class='col-4'><button class='btn btn-light' style='width:100%;'><center><span class='likenumber'>0 Agree</span></center></button></div><div class='col-4'><button class='btn btn-light' style='width:100%;'><center><span class='likenumber'>0 Object</span></center></button></div><div class='col-4'><button class='btn btn-light' disabled='disabled' style='width:100%;'><center><span class='likenumber'>Score <?php echo $row[4]; ?></span></center></button></div></div></div></div>";
    </script>

<?php endwhile; ?>

<?php
}
 else{
      header('Location: ./createAccount.html'); 
} 
?>