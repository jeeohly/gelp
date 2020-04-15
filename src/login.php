<?php
 session_start(); // Check connection
 include_once("./config.php"); // To connect to the database
 if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 // Form the SQL query (an INSERT query)
 $sql= "SELECT id FROM User WHERE username='$_POST[Username]' AND password='$_POST[Password]'";
 if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
 $result = mysqli_query($con, $sql);
 $rows = mysqli_num_rows($result);
 $one = mysqli_fetch_array($result)[0];

$_SESSION['loggedIn'] = 66; 
 if($rows == 1){
   echo "Logged in"; // Output to user
   $_SESSION['loggedIn'] = $one;
   header('Location: ./index.php');   
 }
 else{
   echo "Invalid username or password";
 }
 mysqli_close($con);
?>