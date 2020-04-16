<?php
session_start();
header("Content-type: text/html; charset=iso-8859-1");
include_once("./config.php");

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
    	<a class="navbar-brand" href="./index.php">Gelp</a>
    	<input class="form-control" style="width:50%" type="text" placeholder="Search.." name="search">
    	<button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
    		<span class="sr-only">Toggle navigation</span>
    		<span class="navbar-toggler-icon"></span>
    	</button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item" role="presentation"><a class="nav-link" href="./profile.php?id=<?php echo $_SESSION['loggedIn'] ?>">Profile</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Leaderboard</a></li>
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
            <div class="col-md-12 col-xl-6 offset-xl-3" id="leaderboardz" style="margin-bottom:30px;">
            </div>
        </div>
    </div>

</body>

</html>
<?php
$leadsql = mysqli_query($con, "SELECT id, username, total FROM User ORDER BY total DESC");
while($row = mysqli_fetch_array($leadsql)): ?>
    <script>
        document.getElementById("leaderboardz").innerHTML += "<div class='card' style='margin-top:15px;'><a href='./profile.php?id=<?php echo $row[0] ?>'><div class='card-body'><div class='row'><div class='col-4'><img class ='postprofileimg' src='https://i.imgur.com/wyYAmyX.jpg'><span class='postname'><?php echo $row[1] ?></span></div><div class='col-4'><span class='postname'>Total likes: 000</span></div><div class='col-4'><span class='postname'>Profile score: <?php echo $row[2] ?></span></div></div></div></a></div>";
    </script>
<?php endwhile; ?>
<?php 
}
 else{
      header('Location: ./createAccount.html'); 
} 
?>