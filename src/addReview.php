<?php
 session_start(); 
 include_once("./config.php"); // To connect to the database
 include('./classes/image.php');
 // Check connection
 if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

 $userid1 =  $_SESSION['loggedIn'];
 $datetime = date('Y-m-d H:i:s');
 //Get trust from user
 $sql4= mysqli_query($con, "SELECT agree, object FROM User WHERE id='$userid1'");
 $sql4q = mysqli_fetch_array($sql4);
 $agree = $sql4q[0];
 $object = $sql4q[1];

 $trust = 0;
 $trustdenom = $agree + $object;
 if($trustdenom == 0){
    $trust = 100;
 }else{
    $trust = floor($agree/$trustdenom*100);
 }

//add Review 
 $sql="INSERT INTO review (userId1, userId2, comment, score, time, trust)
 VALUES
 ('$userid1', '$_POST[userId2]','$_POST[comment]','$_POST[rating]', '$datetime', '$trust')";

 if (!mysqli_query($con,$sql))
 {
 die('Error: ' . mysqli_error($con));
 }
 //get average

 $sql2="SELECT SUM(score*trust/100)/SUM(trust/100) FROM review WHERE userId2 = '$_POST[userId2]'";

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