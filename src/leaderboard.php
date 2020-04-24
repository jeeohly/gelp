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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gelp</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Search-Field-With-Icon.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>


<?php include "./classes/nav.php"; ?>

<body style="background-color: rgb(224,224,224);">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xl-8 offset-xl-2" id="leaderboardz" style="margin-bottom:100px;">
                <table id="restTable" class="table table-striped table-bordered" style="margin-top: 15px;background-color: rgb(255,255,255);border-radius:5px;" cellspacing="0">
                    <thead id="restHead">
                        <tr>
                            <th>User</th>
                            <th>Rank</th>
                            <th>Score</th>
                            <!--<th>Likes</th>
                            <th>Dislikes</th>
                            <th>%</th>-->
                        </tr>
                    </thead>
                    <tbody id="restBody">
                        <?php $leadsql = mysqli_query($con, "SELECT id, username, total FROM User ORDER BY total DESC");
                        while($row = mysqli_fetch_array($leadsql)):
                            $avgScore = $row[2];
                            //status check 
                            $status = generate_rank($avgScore);
                        ?>
                        <tr>
                            <td>
                                <img class ='postprofileimg' src='https://i.imgur.com/wyYAmyX.jpg'>
                                <a href='./profile.php?id=<?php echo $row[0]; ?>'>
                                    <span class='postname'><?php echo $row[1]; ?></span>
                                </a>
                            </td>
                            <td><span class='postname'><?php echo $status; ?></span></td>
                            <td><span class='postname'><?php if($avgScore == NULL){echo "none";}else{ echo $avgScore;} ?></span></td>
                            <!--<td>2.22</td>
                            <td>2.22</td>
                            <td>2.22</td>-->
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
<script>
function toggleMenu(){
    console.log(document.getElementById("menutoggle").innerHTML);
    var menustring = "<div id='menutoggle' style='display: none;'>on</div><div class='btn-group mr-2' role='group'><button type='button' class='btn btn-outline-secondary usermenu' onclick='toggleMenu()'><i class='fa fa-toggle-off'></i></button></div><div class='btn-group mr-2' role='group'><a href='./leaderboard.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-users'></i></button></a></div><div class='btn-group mr-2' role='group'><a href='#''><button type='button' class='btn btn-outline-secondary'><i class='fas fa-pencil-square-o'></i></button></a></div><div class='btn-group mr-2' role='group'><button type='button' class='btn btn-outline-secondary' disabled><i class='fas fa-user-plus'></i> 3.33</button></div><div class='btn-group' role='group'><button type='button' class='btn btn-outline-secondary' disabled><i class='fas fa-user-check'></i> 50%</button></div>";
    var x = document.getElementById("menutoggle").innerHTML;
    if(x == 'on'){
        document.getElementById("toolbar").innerHTML = "<div id='menutoggle' style='display: none;'>off</div><div class='btn-group mr-2' role='group'><button type='button' class='btn btn-outline-secondary usermenu' onclick='toggleMenu()'><i class='fa fa-toggle-on'></i></button></div><div class='btn-group mr-2' role='group'><a href='./index.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-home'></i></button></a></div><div class='btn-group mr-2' role='group'><a href='./profile.php?id=<?php echo $_SESSION['loggedIn'] ?>'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-user'></i></button></a></div><div class='btn-group mr-2' role='group'><a href='./logout.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-sign-out-alt'></i></button></a></div>";
    }
    if(x == 'off'){
        document.getElementById("toolbar").innerHTML =  menustring;
    }
}
</script>
<?php
//$leadsql = mysqli_query($con, "SELECT id, username, total FROM User ORDER BY total DESC");
//while($row = mysqli_fetch_array($leadsql)): 
//missing status check
?>
    <!--<script>
        document.getElementById("leaderboardz").innerHTML += "<div class='card' style='margin-top:15px;'><a href='./profile.php?id=<?php echo $row[0]; ?>'><div class='card-body'><div class='row'><div class='col-3'><img class ='postprofileimg' src='https://i.imgur.com/wyYAmyX.jpg'><span class='postname'><?php echo $row[1]; ?></span></div><div class='col-3'><span class='postname'><?php echo $status ?></span></div><div class='col-3'><span class='postname'>Total likes: 000</span></div><div class='col-3'><span class='postname'>Profile score: <?php echo $row[2]; ?></span></div></div></div></a></div>";
    </script>-->
<?php //endwhile; ?>
<?php 
}
 else{
      header('Location: ./createAccount.html'); 
} 
?>