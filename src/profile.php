<?php
session_start();
header("Content-type: text/html; charset=iso-8859-1");
include_once("./config.php");

$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query2);
$userid = $query2['id'];

$profileCheck = 0;
$status = "";

$userEntry = mysqli_query($con, "SELECT * FROM User WHERE id = '$userid'");
$userEntryResult = mysqli_fetch_array($userEntry);
$username = $userEntryResult[1];
$avgScore = $userEntryResult[6];
$agreeprofile = $userEntryResult[3];
$objectprofile = $userEntryResult[4];
$trust = $userEntryResult[5];

//check if its your profile
if($userid == $_SESSION['loggedIn']){
    $profileCheck = 1;
}

$queryAll = "SELECT * FROM Review WHERE userid2 = '$userid' ORDER BY id DESC";
$resultAll = mysqli_query($con, $queryAll);

//status check 
if($avgScore == NULL){
    $status = "Silver";
}
if($avgScore >= 1){
    $status = "Wood";
}
if($avgScore > 1.7){
    $status = "Iron";
}
if($avgScore > 2.5){
    $status = "Bronze";
}
if($avgScore > 3){
    $status = "Silver";
}
if($avgScore > 3.5){
    $status = "Gold";
}
if($avgScore > 4){
    $status = "Platinum";
}
if($avgScore > 4.5){
    $status = "Diamond";
}
if($avgScore > 4.7){
    $status = "Challenger";
}

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


<nav class="navbar sticky-top navbar-light navbar-expand-md navigation-clean border-bottom">
    <div class="container">
    	<a class="navbar-brand" href="./index.php">Gelp</a>
    	<input class="form-control" style="width:50%" type="text" placeholder="Search.." name="search">
    	<button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
    		<span class="sr-only">Toggle navigation</span>
    		<span class="navbar-toggler-icon"></span>
    	</button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item" role="presentation"><a class="nav-link" href="./index.php">Main</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="./profile.php?id=<?php echo $_SESSION['loggedIn'] ?>">Profile</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="./leaderboard.php">Users</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Store</a></li>
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
        	<!---Column 1--->
            <div class="col-md-6 col-xl-3 offset-xl-1">
            	<img class ="profileimg" src="https://i.imgur.com/wyYAmyX.jpg">
            	<center><h2><?php echo $username; ?></h2></center>
                <div class="card" style="margin-top:15px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h6><center><?php echo $status ?></center></h6>
                            </div>
                            <div class="col-6">
                                <h6><center><?php if($avgScore == NULL){echo "none";}else{ echo $avgScore;} ?></center></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($profileCheck == 0){ ?>
                    <div class="row">
                        <div class="col-6" style="padding-right:0px;">
                	       <button class="btn btn-secondary" style="margin-top:15px;width:100%;" role="button" data-toggle="modal" data-target="#myModal">Review</button>
                        </div>
                        <div class="col-6" style="padding-left:5px;">
                            <button class="btn btn-secondary" style="margin-top:15px;width:100%;">Report</button>
                        </div>
                        <div class="col-6" style="padding-right:0px;">
                        <button class="btn btn-secondary" style="margin-top:5px;width:100%;">Donate</button>
                        </div>
                        <div class="col-6" style="padding-left:5px;">
                            <button class="btn btn-secondary" style="margin-top:5px;width:100%;">Challenge</button>
                        </div>
                    </div>
                <?php } ?>
            	<div class="card" style="margin-top:15px;">
                    <div class="card-header">
                        <h6><center>Trustability</center></h6>
                        <div class="progress">
                            <div class="progress-bar bg-secondary" id="trustabilitybar" role="progressbar" style="width:<?php echo $trust; ?>%;"></div>
                        </div>
                    </div>
	            	<div class="card-body">
            			<div class="row">
	            			<div class="col-4">
                                <h6><center>Agree</center></h6>
                                <center><div id="agreeprofile"><?php echo $agreeprofile; ?></div></center>
	            			</div> 
                            <div class="col-4">
                                <h6><center>Object</center></h6>
                                <center><div id="objectprofile"><?php echo $objectprofile; ?></div></center>
                            </div> 
                            <div class="col-4">
                                <h6><center>%</center></h6>
                                <center><?php echo $trust; ?></center>
                            </div> 
            			</div>
            		</div>
            	</div>
            	<div class="card" style="margin-top:15px;">
                    <div class="card-header">
                        <h6><center>Arena</center></h6>
                        <div class="progress">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 50%"></div>
                        </div>
                    </div>
            		<div class="card-body">
            			<div class="row">
            				<div class="col-4">
            					<h6><center>Won</center></h6>
            					<div id="followers"><center>0</center></div>
            				</div>
            				<div class="col-4">
            					<h6><center>Lost</center></h6>
            					<div id="following"><center>0</center></div>
            				</div>
                            <div class="col-4">
                                <h6><center>%</center></h6>
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

                    <h6>Upload image</h6>
                    <input type="file" name="postimage">
          
			        <!--<div class="form-group" style="margin-top:15px;">
			            <h6>Rating</h6>
						<select class="form-control" name="rating">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
			        </div>-->
                    <h6 style="margin-top: 15px;">Score</h6>
                    <center><div class="ratingchoice" style="margin-top: 5px;">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" value="1">
                            <label class="form-check-label" for="inlineRadio1"> 1 Terrible </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" value="2">
                            <label class="form-check-label" for="inlineRadio2"> 2 Bad </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" value="3">
                            <label class="form-check-label" for="inlineRadio1"> 3 Okay </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" value="4">
                            <label class="form-check-label" for="inlineRadio2"> 4 Good </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" value="5">
                            <label class="form-check-label" for="inlineRadio2"> 5 Amazing </label>
                        </div>
                    </div></center>

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
    $postUser2 = mysqli_query($con, "SELECT username FROM User WHERE id = '$row[2]'");
    $postUser2r = mysqli_fetch_array($postUser2)[0];
    $trusthund = $row[10];
?>
    <script>
        document.getElementById("postfeed").innerHTML += "<div class='card' style='margin-top:15px;'><div class='card-header'><img class ='postprofileimg' src='https://i.imgur.com/wyYAmyX.jpg'><a href='./profile.php?id=<?php echo $row[1]; ?>'><span class='postname' id='postreviewer'><?php echo $postUser1r; ?></span></a> is reviewing <a href='./profile.php?id=<?php echo $row[2]; ?>'><span class='postname' id='postreviewing'><?php echo $postUser2r; ?></span></a><span class='postdate'><?php echo $row[5]; ?></span></div><ul class='list-group list-group-flush'><li class='list-group-item'><?php echo $row[3]; ?></li><li class='list-group-item'><div class='row'><div class='col-3 border-right'><center><span class='objectnum' id='<?php echo $row[0]; ?>bar2'><?php echo $trusthund; ?>%</span></center></div><div class='col-6'><div class='progress'><div class='progress-bar bg-secondary' role='progressbar' id='<?php echo $row[0]; ?>bar' style='width:<?php echo $trusthund; ?>%;'></div></div></div><div class='col-3 border-left'><center><span class='objectnum'><?php echo $row[4]; ?></span> Score</center></div></div></li><div id='<?php echo $row[0]; ?>d'></div></ul><div class='card-footer' style='padding-top:0px;padding-bottom:0px;'><div class='row'><div class='col-6'><button class='btn btn-light agreeload' style='width:100%;' id='<?php echo $row[0]; ?>'><center><span class='agreenum' id='<?php echo $row[0]; ?>num'><?php echo $row[7]; ?></span> Agree</center></button></div><div class='col-6'><button class='btn btn-light objectload' style='width:100%;' name='<?php echo $row[0]; ?>'><center><span class='objectnum' id='<?php echo $row[0]; ?>num2'><?php echo $row[8]; ?></span> Object</center></button></div></div></div></div><div style='display: none;' id='<?php echo $row[0]; ?>two'><?php echo $row[1]; ?></div>";
        if( '<?php echo $row[2] ?>' == '<?php echo $_SESSION['loggedIn'] ?>'){
            document.getElementById('<?php echo $row[0]; ?>d').innerHTML += "<li class='list-group-item border-top'><div class='row'><div class='col-4 border-right'><button class='btn btn-outline-secondary replyload' style='width:100%;' id='<?php echo $row[0]; ?>dd'>Reply</button></div><div class='col-8'><textarea class='form-control' rows='1' style='resize:none;'></textarea></div></div></li>";
        }
    </script>
<?php endwhile; ?>
<!--Agree system-->
<script type="text/javascript">
    $(document).ready(function() {
        $('.agreeload').click(function(e){
            var passreviewid = jQuery(this).attr("id");  
            var passuserid1 = <?php echo $_SESSION['loggedIn']; ?>;
            var passuserid2 = document.getElementById(passreviewid+"two").innerHTML;

            $.ajax({
                type: "POST", 
                url: "./agree.php",
                dataType: "json",
                data: {userid1:passuserid1, userid2:passuserid2, reviewid:passreviewid},
                success: function(data){
                    console.log(data);
                    if(data.agreecheck == 0 && data.objectcheck == 0){
                        var newagree = (parseInt(document.getElementById(passreviewid+"num").innerHTML) + 1).toString();
                        document.getElementById(passreviewid+"num").innerHTML = newagree;

                        var newtrust = data.final;
                        document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                        document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                        //var newagreeprofile = (parseInt(document.getElementById("agreeprofile").innerHTML) + 1).toString();
                        //document.getElementById("agreeprofile").innerHTML = newagreeprofile;
                    }if(data.agreecheck == 1 && data.objectcheck == 0){
                        var newagree2 = (parseInt(document.getElementById(passreviewid+"num").innerHTML) - 1).toString();
                        document.getElementById(passreviewid+"num").innerHTML = newagree2;

                        var newtrust = data.final;
                        document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                        document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                        //var newagreeprofile2 = (parseInt(document.getElementById("agreeprofile").innerHTML) - 1).toString();
                        //document.getElementById("agreeprofile").innerHTML = newagreeprofile2;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError){
                    console.log(xhr.statusText);
                    console.log(thrownError);
                }   
            });

        });
        $('.objectload').click(function(e){
            var passreviewid = jQuery(this).attr("name"); 
            var passuserid1 = <?php echo $_SESSION['loggedIn']; ?>;
            var passuserid2 = document.getElementById(passreviewid+"two").innerHTML;
            $.ajax({
                type: "POST", 
                url: "./object.php",
                dataType: "json",
                data: {userid1:passuserid1, userid2:passuserid2, reviewid:passreviewid},
                success: function(data){
                    console.log(data);
                    if(data.agreecheck == 0 && data.objectcheck == 0){
                        var newagree = (parseInt(document.getElementById(passreviewid+"num2").innerHTML) + 1).toString();
                        document.getElementById(passreviewid+"num2").innerHTML = newagree;
                        var newtrust = data.final;
                        document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                        document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                        //var newagreeprofile = (parseInt(document.getElementById("agreeprofile").innerHTML) + 1).toString();
                        //document.getElementById("agreeprofile").innerHTML = newagreeprofile;
                    }if(data.agreecheck == 0 && data.objectcheck == 1){
                        var newagree2 = (parseInt(document.getElementById(passreviewid+"num2").innerHTML) - 1).toString();
                        document.getElementById(passreviewid+"num2").innerHTML = newagree2;
                        var newtrust = data.final;
                        document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                        document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                        //var newagreeprofile2 = (parseInt(document.getElementById("agreeprofile").innerHTML) - 1).toString();
                        //document.getElementById("agreeprofile").innerHTML = newagreeprofile2;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError){
                    console.log(xhr.statusText);
                    console.log(thrownError);
                }   
            });

        });
        $('.replyload').click(function(e){

        });
    });
</script>

<?php
}
 else{
      header('Location: ./createAccount.html'); 
} 
?>