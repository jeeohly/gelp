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


<nav class="navbar sticky-top navbar-light navbar-expand-md navigation-clean border-bottom">
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