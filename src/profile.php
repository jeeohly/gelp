<?php
session_start();
header("Content-type: text/html; charset=iso-8859-1");
include_once("./config.php");

$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query2);
$userid = $query2['id'];

$userEntry = mysqli_query($con, "SELECT * FROM User WHERE id = '$userid'");
$username = mysqli_fetch_array($userEntry)[1];
$userEntry2 = mysqli_query($con, "SELECT * FROM User WHERE id = '$userid'");
$avgScore = mysqli_fetch_array($userEntry2)[5];


$queryAll = "SELECT * FROM Review WHERE userid2 = '$userid' ORDER BY id DESC";
$resultAll = mysqli_query($con, $queryAll);

if(isset($_SESSION['loggedIn'])){
?>


<!DOCTYPE html>
<script>
    var url_string = window.location.href;
    var url = new URL(url_string);
    var c = url.searchParams.get("id");
    c = decodeURI(c);
</script>
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
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Profile</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="./leaderboard.php">Leaderboard</a></li>
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
        	<!---Column 1--->
            <div class="col-md-6 col-xl-3 offset-xl-1">
            	<img class ="profileimg" src="https://i.imgur.com/wyYAmyX.jpg">
            	<div style="margin-top: 15px;"><center><h2><?php echo $username; ?></h2></center></div>
            	<button class="btn btn-primary" style="margin-top:15px;width:100%;" role="button" data-toggle="modal" data-target="#myModal">Review</button>
            	<div class="card" style="margin-top:15px;">
	            	<div class="card-body">
            			<div class="row">
	            			<div class="col-6">
	            				<h6><center>Score:</center></h6>
	            			</div>
	            			<div class="col-6">
	            				<center><?php echo $avgScore; ?></center>
	            			</div> 
            			</div>
            		</div>
            	</div>
            	<button class="btn btn-primary" style="margin-top:15px;width:100%;">Follow</button>
            	<div class="card" style="margin-top:15px;">
            		<div class="card-body">
            			<div class="row">
            				<div class="col-6">
            					<h6><center>Followers</center></h6>
            					<div id="followers"><center>0</center></div>
            				</div>
            				<div class="col-6">
            					<h6><center>Following</center></h6>
            					<div id="following"><center>0</center></div>
            				</div>
            			</div>
            		</div>
	            </div>
            </div>
            <!---Column 2--->
            <div class="col-md-6 col-xl-7 offset-xl-0" id="postfeed" style="margin-bottom:30px;">
            	<!--<div class="card" style="margin-top:15px;">
            		<div class="card-header">
            			
        				<img class ="postprofileimg" src="https://www.biography.com/.image/t_share/MTE4MDAzNDEwNzg5ODI4MTEw/barack-obama-12782369-1-402.jpg">
        				<a href="#">
            				<span class="postname" id="postreviewer">
            				name
            				</span>
            			</a>
            			 is reviewing
            			<a href="#">
            				<span class="postname" id="postreviewing">
            				name2
            				</span>
            			</a>
        				<span class="postdate">
        					date
        				</span>
            			
            		</div>
            		<div class="card-body">
            			Comment
            		</div>
            		<div class="card-footer">
            			<div class="row">
            				<div class="col-4">
            					<a href="#" class="postfooterbutton"><center><span class="likenumber">0 </span>Like</center></a>
            				</div>
            				<div class="col-4">
            					<a href="#" class="postfooterbutton"><center><span class="dislikenumber">0 </span>Dislike</center></a>
            				</div>
            				<div class="col-4">
            					<center>Score: <span class="postscore"> 0</span></center>
            				</div>
            			</div>
            		</div>
            	</div>-->
            </div>
        </div>
    </div>
</body>
<!-- Add Restauraunt Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h5>Add Review</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form action="addReview.php" method="post">
			    <div class="modal-body">
			        <div class="form-group">
			            <h6>Comment</h6>
			            <textarea rows="5" class="form-control" name="comment" id="comment"></textarea>
			        </div>
			        <div class="form-group">
			            <h6>Rating</h6>
						<select class="form-control" name="rating">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
			        </div>
					<input type="hidden" id="cov" name="userId2">
					<script>document.getElementById("cov").value = c;</script>
			    </div>
			    <div class="modal-footer">
			        <button class="btn btn-light submit-button" type="submit"> Submit</button>
			    </div>
			</form>
		</div>
	</div>
</div>
</html>
<?php while($row = mysqli_fetch_array($resultAll)):
    $postUser1 = mysqli_query($con, "SELECT username FROM User WHERE id = '$row[1]'");
    $postUser1r = mysqli_fetch_array($postUser1)[0];
?>
	<script>
		document.getElementById("postfeed").innerHTML += "<div class='card' style='margin-top:15px;'><div class='card-header'><img class ='postprofileimg' src='https://i.imgur.com/wyYAmyX.jpg'><a href='./profile.php?id=<?php echo $row[1]; ?>'><span class='postname' id='postreviewer'><?php echo $postUser1r; ?></span></a> is reviewing <a href='./profile.php?id=<?php echo $row[2]; ?>''><span class='postname' id='postreviewing'><?php echo $username; ?></span></a><span class='postdate'><?php echo $row[5]; ?></span></div><div class='card-body'><?php echo $row[3]; ?></div><div class='card-footer'><div class='row'><div class='col-4'><a href='#'' class='postfooterbutton'><center><span class='likenumber'>0 </span>Like</center></a></div><div class='col-4'><a href='#' class='postfooterbutton'><center><span class='dislikenumber'>0 </span>Dislike</center></a></div><div class='col-4'><center>Score: <span class='postscore'> <?php echo $row[4]; ?></span></center></div></div></div></div>";
	</script>
<?php endwhile; ?>

<?php
}
 else{
      header('Location: ./createAccount.html'); 
} 
?>