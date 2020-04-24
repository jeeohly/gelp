<?php 
    $loggedinUserId = $_SESSION['loggedIn'];
    $loggedinUserInfoQuery = mysqli_query($con, "SELECT trust, total FROM User WHERE id = '$loggedinUserId'");
    $loggedinUserInfoResult = mysqli_fetch_array($loggedinUserInfoQuery);
    $loggedinUserTrust = $loggedinUserInfoResult[0];
    $loggedinUserTotal = $loggedinUserInfoResult[1];
?>
<!DOCTYPE html>
<nav class="navbar sticky-top navbar-light bg-light navbar-expand-md border-bottom">
    <div class="container">
        <a class="navbar-brand mb-0 h1" href="./index.php">Gelp</a>
        <div class="input-group ml-auto mr-auto" style="width:80%;">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>
    </div>
</nav>
<nav class="navbar navbar-light bg-light navbar-expand-md fixed-bottom border-top">
    <div class="container">
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
            <div class="btn-group mr-2" role="group">
                <button type="button" class="btn btn-outline-secondary" disabled><i class="fas fa-user-plus mr-2"></i><?php echo $loggedinUserTotal ?></button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary" disabled><i class="fas fa-user-check mr-2"></i><?php echo $loggedinUserTrust ?>%</button>
            </div>
        </div>
    </div>
</nav>
<script>
function toggleMenu(){
    console.log(document.getElementById("menutoggle").innerHTML);
    var menustring = "<div id='menutoggle' style='display: none;'>on</div><div class='btn-group mr-2' role='group'><button type='button' class='btn btn-outline-secondary usermenu' onclick='toggleMenu()'><i class='fa fa-toggle-off'></i></button></div><div class='btn-group mr-2' role='group'><a href='./leaderboard.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-users'></i></button></a></div><div class='btn-group mr-2' role='group'><a href='#''><button type='button' class='btn btn-outline-secondary' role='button' data-toggle='modal' data-target='#myModal'><i class='fas fa-pencil-square-o'></i></button></a></div><div class='btn-group mr-2' role='group'><button type='button' class='btn btn-outline-secondary' disabled><i class='fas fa-user-plus'></i> <?php echo $loggedinUserTotal ?></button></div><div class='btn-group' role='group'><button type='button' class='btn btn-outline-secondary' disabled><i class='fas fa-user-check'></i> <?php echo $loggedinUserTrust ?>%</button></div>";
    var x = document.getElementById("menutoggle").innerHTML;
    if(x == 'on'){
        document.getElementById("toolbar").innerHTML = "<div id='menutoggle' style='display: none;'>off</div><div class='btn-group mr-2' role='group'><button type='button' class='btn btn-outline-secondary usermenu' onclick='toggleMenu()'><i class='fa fa-toggle-on'></i></button></div><div class='btn-group mr-2' role='group'><a href='./index.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-home'></i></button></a></div><div class='btn-group mr-2' role='group'><a href='./profile.php?id=<?php echo $loggedinUserId ?>'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-user'></i></button></a></div><div class='btn-group mr-2' role='group'><a href='./logout.php'><button type='button' class='btn btn-outline-secondary'><i class='fas fa-sign-out-alt'></i></button></a></div>";
    }
    if(x == 'off'){
        document.getElementById("toolbar").innerHTML =  menustring;
    }
}
</script>