<?php
session_start();
header("Content-type: text/html; charset=iso-8859-1");
include_once("./classes/config.php");
include "./classes/functions.php";

$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query2);
$userid = $query2['id'];

$profileCheck = 0;
$status = "";

//information of visiting profile
$userEntry = mysqli_query($con, "SELECT * FROM User WHERE id = '$userid'");
$userEntryResult = mysqli_fetch_array($userEntry);
$username = $userEntryResult[1];
$avgScore = $userEntryResult[6];
$agreeprofile = $userEntryResult[3];
$objectprofile = $userEntryResult[4];
$trust = $userEntryResult[5];

//status check 
$status = generate_rank($avgScore);

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
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gelp</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Search-Field-With-Icon.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body style="background-color: rgb(224,224,224);">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <div class="container">
        <div class="row" style="margin-top:50px;">
        	<!---Column 1--->
            <div class="col-md-5 col-xl-4">
                <div class="card" style="margin-top:15px;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-2">
                                <img class ="profileimg" src="https://i.imgur.com/wyYAmyX.jpg">
                            </div>
                            <div class="col-10">
                                <h4 class="profilenametext"><?php echo $username; ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding:15px;">
                        <div class="row">
                            <div class="col-6 border-right">
                                <h6><center><?php echo $status ?></center></h6>
                            </div>
                            <div class="col-6">
                                <h6><center><?php if($avgScore == NULL){echo "none";}else{ echo $avgScore;} ?></center></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top pb-0">
                        <div class="progress">
                            <div class="progress-bar bg-secondary" id="trustabilitybar" role="progressbar" style="width:<?php echo $trust; ?>%;"></div>
                        </div>
                    </div>
                    <div class="card-body" style="padding:15px;">
                        <div class="row">
                            <div class="col-4 border-right">
                                <h6><center><i class='far fa-thumbs-up ml-2'></i></center></h6>
                                <center><div id="agreeprofile"><?php echo $agreeprofile; ?></div></center>
                            </div> 
                            <div class="col-4 border-right">
                                <h6><center><i class='far fa-thumbs-down ml-2'></i></center></h6>
                                <center><div id="objectprofile"><?php echo $objectprofile; ?></div></center>
                            </div> 
                            <div class="col-4">
                                <h6><center><i class="fas fa-user-check"></i></center></h6>
                                <center><?php echo $trust; ?>%</center>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <!---Column 2--->
            <div class="col-md-7 col-xl-8" style="margin-bottom:100px;">
                <div id="postfeed">
                </div>
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