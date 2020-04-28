<?php 
session_start();
include_once("./config.php"); 
include_once("./functions.php"); 
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = array();
$counter = 0;

$logginuserid = $_SESSION['loggedIn'];
$sqlm = mysqli_query($con, "SELECT * FROM Review WHERE id < '$_POST[lastReviewId]' ORDER BY id DESC LIMIT 5");

if($_POST['pass1'] == 1){
	$sqlm = mysqli_query($con, "SELECT * FROM Review WHERE id < '$_POST[lastReviewId]' AND userid2 = '$_POST[pass2]' ORDER BY id DESC LIMIT 5");
}
while($row = mysqli_fetch_array($sqlm)){
	$col = array();

	$col[0] = $row[0];
	$col[1] = $row[1];
	$col[2] = $row[2];
	$col[3] = $row[3];
	$col[4] = $row[4];
	$col[5] = $row[5];
	$col[6] = $row[6];
	$col[7] = $row[7];
	$col[8] = $row[8];
	$col[9] = $row[9];
	$col[10] = $row[10];

	$counter = $counter + 1;
	$newlast = $row[0];
	$result["last"] = $newlast;
	$result["size"] = $counter;

	//retrieve names
	$postUser1 = mysqli_query($con, "SELECT username FROM User WHERE id = '$row[1]'");
    $postUser1r = mysqli_fetch_array($postUser1)[0];
    $postUser2 = mysqli_query($con, "SELECT username FROM User WHERE id = '$row[2]'");
    $postUser2r = mysqli_fetch_array($postUser2)[0];

    $col["postUser1"] = $postUser1r;
    $col["postUser2"] = $postUser2r;

    //set limit on trust view
    $trusthund = $row[10];
    if($trusthund > 100){
        $trusthund = 100;
    }
    if($trusthund < 0){
        $trusthund = 0;
    }
    $col["trusthund"] = $trusthund;

    //get time elapsed 
    $timepast = time_elapsed_string($row[5]);
    $col["timepast"] = $timepast;

    //agree/object stuff
    $agreeIcon = "<i class='far fa-thumbs-up'></i>";
    $objectIcon = "<i class='far fa-thumbs-down'></i>";

    $queryAgreeCheck = "SELECT id FROM Agree WHERE reviewId = '$row[0]' AND userId1 = '$logginuserid'";
    $resultAgreeCheck = mysqli_query($con, $queryAgreeCheck);
    if($resultAgreeCheck->num_rows > 0){
        $agreeIcon = "<i class='fas fa-thumbs-up'></i>";
    }

    $queryObjectCheck = "SELECT id FROM Object WHERE reviewId = '$row[0]' AND userId1 = '$logginuserid'";
    $resultObjectCheck = mysqli_query($con, $queryObjectCheck);
    if($resultObjectCheck->num_rows > 0){
        $objectIcon = "<i class='fas fa-thumbs-down'></i>";
    }
    $col['agreeIcon'] = $agreeIcon;
    $col['objectIcon'] = $objectIcon;

    $result[intval($counter)] = $col;
}
echo json_encode($result);
mysqli_close($con);
?>