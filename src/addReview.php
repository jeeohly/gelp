<?php
 session_start(); 
 include_once("./config.php"); // To connect to the database
 // Check connection
 if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

 $userid1 =  $_SESSION['loggedIn'];
 $datetime = date('Y-m-d H:i:s');
//add Review 
 $sql="INSERT INTO review (userId1, userId2, comment, score, time)
 VALUES
 ('$userid1', '$_POST[userId2]','$_POST[comment]','$_POST[rating]', '$datetime')";

 if (!mysqli_query($con,$sql))
 {
 die('Error: ' . mysqli_error($con));
 }
 //get average

 $sql2="SELECT AVG(score) FROM review WHERE userId2 = '$_POST[userId2]'";

 $sql2q = mysqli_query($con, $sql2);
 $sql2r = mysqli_fetch_array($sql2q)[0];
 //update total

 $sql3="UPDATE user SET total = '$sql2r' WHERE id = '$_POST[userId2]'";

 if (!mysqli_query($con,$sql3))
 {
 die('Error: ' . mysqli_error($con));
}

 mysqli_close($con);
 
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
?>