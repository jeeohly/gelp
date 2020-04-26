<?php 
    $loggedinUserId = $_SESSION['loggedIn'];
    $loggedinUserInfoQuery = mysqli_query($con, "SELECT trust, total, username FROM User WHERE id = '$loggedinUserId'");
    $loggedinUserInfoResult = mysqli_fetch_array($loggedinUserInfoQuery);
    $loggedinUserTrust = $loggedinUserInfoResult[0];
    $loggedinUserTotal = $loggedinUserInfoResult[1];
    $loggedinUsername = $loggedinUserInfoResult[2];
?>
<nav class="navbar navbar-light bg-light fixed-top border-bottom">
    <!--mobile-->
    <div class="d-xl-none d-lg-none d-md-block d-sm-block d-xs-block">
        <div class="btn-toolbar" role="toolbar" id="toolbar">
            <div id="menutoggle" style="display: none;">on</div>
            <div class="btn-group mr-2" role="group">
                <button type="button" class="btn btn-outline-secondary usermenu" onclick="toggleMenu()"><i class="fa fa-toggle-off"></i></button>
            </div>
            <div class="btn-group mr-2" role="group">
                <a href="./leaderboard.php"><button type="button" class="btn btn-outline-secondary"><i class="fas fa-users"></i></button></a>
            </div>
            <div class="btn-group mr-2" role="group">
                <a href="#"><button type="button" class="btn btn-outline-secondary" role="button" data-toggle="modal" data-target="#myModal"><i class="fas fa-pencil-square-o"></i></button></a>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-secondary" disabled><i class="fas fa-user-plus mr-2"></i><span class="latestTotal"><?php echo $loggedinUserTotal ?></span></button>
                <button type="button" class="btn btn-secondary" disabled><i class="fas fa-user-check mr-2"></i><span class="latestTrust"><?php echo $loggedinUserTrust ?>%</span></button>
            </div>
        </div>
    </div>
    
    <!--tablet-->
    <div class="container d-none d-xl-none d-lg-block">
        <button type="button" class="btn btn-primary mr-4" disabled>GELP</button>
        <a href='./index.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-home'></i></button></a>
        <a href='./profile.php?id=<?php echo $loggedinUserId ?>'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-user'></i></button></a>
        <a href="./leaderboard.php"><button type="button" class="btn btn-outline-secondary"><i class="fas fa-users"></i></button></a>
        <a href="#"><button type="button" class="btn btn-outline-secondary" role="button" data-toggle="modal" data-target="#myModal"><i class="fas fa-pencil-square-o"></i></button></a>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary ml-4" disabled><?php echo $loggedinUsername ?></button>
            <button type="button" class="btn btn-secondary" disabled><i class="fas fa-user-plus mr-2"></i><span class="latestTotal"><?php echo $loggedinUserTotal ?></span></button>
            <button type="button" class="btn btn-secondary" disabled><span class="latestRank"><?php echo generate_rank($loggedinUserTotal) ?></span></button>
            <button type="button" class="btn btn-secondary mr-4" disabled><i class="fas fa-user-check mr-2"></i><span class="latestTrust"><?php echo $loggedinUserTrust ?>%</span></button>
        </div>
        <a href="#">
            <button type="button" class="btn btn-outline-secondary">
                <i class="fas fa-bell"></i>
                <sup><span class="badge badge-secondary">9</span></sup>
            </button>
        </a>
        <a href='./logout.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-sign-out-alt'></i></button></a>
    </div>
    <!--Desktop-->
    <div class="container d-none d-xl-block">
        <button type="button" class="btn btn-primary mr-4" disabled>GELP</button>
        <a href='./index.php'><button type='button' class='btn btn-outline-secondary'>Home<i class='fas fa-home ml-2'></i></button></a>
        <a href='./profile.php?id=<?php echo $loggedinUserId ?>'><button type='button' class='btn btn-outline-secondary'>Profile<i class='fas fa-user ml-2'></i></button></a>
        <a href="./leaderboard.php"><button type="button" class="btn btn-outline-secondary">Rankings<i class="fas fa-users ml-2"></i></button></a>
        <a href="#"><button type="button" class="btn btn-outline-secondary" role="button" data-toggle="modal" data-target="#myModal">Review<i class="fas fa-pencil-square-o ml-2"></i></button></a>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary ml-4" disabled><?php echo $loggedinUsername ?></button>
            <button type="button" class="btn btn-secondary" disabled><i class="fas fa-user-plus mr-2"></i><span class="latestTotal"><?php echo $loggedinUserTotal ?></span></button>
            <button type="button" class="btn btn-secondary" disabled><span class="latestRank"><?php echo generate_rank($loggedinUserTotal) ?></span></button>
            <button type="button" class="btn btn-secondary mr-4" disabled><i class="fas fa-user-check mr-2"></i><span class="latestTrust"><?php echo $loggedinUserTrust ?>%</span></button>
        </div>
        <a href="#">
            <button type="button" class="btn btn-outline-secondary">
                <i class="fas fa-bell"></i>
                <sup><span class="badge badge-secondary">9</span></sup>
            </button>
        </a>
        <a href='./logout.php'><button type='button' class='btn btn-outline-secondary'>Logout</button></a>
    </div>
    
</nav>
<script>
function toggleMenu(){
    console.log(document.getElementById("menutoggle").innerHTML);
    var menustring = "<div id='menutoggle' style='display: none;'>on</div><div class='btn-group mr-2' role='group'><button type='button' class='btn btn-outline-secondary usermenu' onclick='toggleMenu()'><i class='fa fa-toggle-off'></i></button></div><div class='btn-group mr-2' role='group'><a href='./leaderboard.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-users'></i></button></a></div><div class='btn-group mr-2' role='group'><a href='#''><button type='button' class='btn btn-outline-secondary' role='button' data-toggle='modal' data-target='#myModal'><i class='fas fa-pencil-square-o'></i></button></a></div><div class='btn-group' role='group'><button type='button' class='btn btn-secondary' disabled><i class='fas fa-user-plus mr-2'></i><span class='latestTotal'><?php echo $loggedinUserTotal ?></span></button><button type='button' class='btn btn-secondary' disabled><i class='fas fa-user-check mr-2'></i><span class='latestTrust'><?php echo $loggedinUserTrust ?>%</span></button></div>";
    var x = document.getElementById("menutoggle").innerHTML;
    if(x == 'on'){
        document.getElementById("toolbar").innerHTML = "<div id='menutoggle' style='display: none;'>off</div><div class='btn-group mr-2' role='group'><button type='button' class='btn btn-outline-secondary usermenu' onclick='toggleMenu()'><i class='fa fa-toggle-on'></i></button></div><div class='btn-group mr-2' role='group'><a href='./index.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-home'></i></button></a></div><div class='btn-group mr-2' role='group'><a href='./profile.php?id=<?php echo $loggedinUserId ?>'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-user'></i></button></a></div><div class='btn-group' role='group'><a href='./logout.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-sign-out-alt'></i></button></a></div>";
    }
    if(x == 'off'){
        document.getElementById("toolbar").innerHTML =  menustring;
    }
}

$(document).ready(function(){
    function loadLatestResults(){
        var passuserid = <?php echo $_SESSION['loggedIn']; ?>;
        $.ajax({
            type: "POST", 
            url: "./classes/update.php",
            dataType: "json",
            data: {userid:passuserid},
            success: function(data){
                $('.latestTrust').html(data.trust+"%");
                $('.latestRank').html(data.rank);
                $('.latestTotal').html(data.total);
            }
        });
    }
    setInterval(function(){
        loadLatestResults();
    }, 2000);
});

</script>