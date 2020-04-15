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
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Profile</a></li>
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
        	<!---Column 1--->
            <div class="col-md-6 col-xl-3 offset-xl-1">
            	<img class ="profileimg" src="https://www.biography.com/.image/t_share/MTE4MDAzNDEwNzg5ODI4MTEw/barack-obama-12782369-1-402.jpg">
            	<button class="btn btn-primary" style="margin-top:15px;width:100%;">Review</button>
            	<div class="card" style="margin-top:15px;">
	            	<div class="card-body">
            			<div class="row">
	            			<div class="col-6">
	            				<h6><center>Score:</center></h6>
	            			</div>
	            			<div class="col-6">
	            				<center>0</center>
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
            <div class="col-md-6 col-xl-7 offset-xl-0">
            	<div class="card" style="margin-top:15px;">
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
            			adsasd dsfasdfs fsdfhjksdfgjhkgfdjhklfdgshjklfgdkljhdfgjhklfgdshjklgfdlkjhfgdskjlhfgdslkjhdfgskljhgdfsjklhgfdsjklhgfsdkjhlgfdskjhlgfdskljhsfgdlkhjgfdsjkhlgsdfhjklgfsdhjlkdfsgjlkhsfgdkjlhgfdskjlhfgdsjklhjkhlgsfdjkhlgfdshkjgfsdjkhl
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
            	</div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
}
 else{
      header('Location: ./createAccount.html'); 
} 
?>