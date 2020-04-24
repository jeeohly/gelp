<?php
 include_once("./classes/config.php"); // To connect to the database
 session_start();
 // Check connection
 if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 //check password 
 if($_POST['Password'] != $_POST['Password2']){
 	die("Password does not match");
 }
 //check if username exists
 $userCheck = mysqli_query($con, "SELECT id FROM User WHERE username ='$_POST[Username]'");
 if($userCheck->num_rows > 0){
 	die("Username already exists");
 }
 // Form the SQL query (an INSERT query)
 $sql="INSERT INTO User (Username, Password)
 VALUES
 ('$_POST[Username]','$_POST[Password]')";

 if (!mysqli_query($con,$sql))
 {
 die('Error: ' . mysqli_error($con));
 }

 //Get user id after insertion
 $sql2= "SELECT id FROM User WHERE username='$_POST[Username]' AND password='$_POST[Password]'";
  if (!mysqli_query($con,$sql2))
  {
  die('Error: ' . mysqli_error($con));
  }
 $result = mysqli_query($con, $sql2);
 $rows = mysqli_num_rows($result);
 $one = mysqli_fetch_array($result)[0];

 echo "New User Registered"; // Output to user
 $_SESSION['loggedIn'] = $one;
 header('Location: ./index.php');
 mysqli_close($con);
?>