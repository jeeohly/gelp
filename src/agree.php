<?php

include_once("./config.php"); // To connect to the database
 session_start();
 // Check connection
 if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 // check if already agreed
 $agreeCheck = 0;
 $agreeCheckquery = mysqli_query($con, "SELECT id FROM Agree WHERE userId1 ='$_POST[userid1]' AND reviewId ='$_POST[reviewid]'");
 $agreeCheckid =  mysqli_fetch_array($agreeCheckquery)[0];

 if($agreeCheckquery->num_rows > 0){
 	$agreeCheck = 1;
 }
 $result = array();
 $result['check'] = $agreeCheck;

 echo json_encode($agreeCheck);
 // Form the SQL query (an INSERT query)
 if($agreeCheck == 0){
	 $sql="INSERT INTO Agree (userId1, userId2, reviewId)
	 VALUES
	 ('$_POST[userid1]','$_POST[userid2]', '$_POST[reviewid]')";

	 if (!mysqli_query($con,$sql))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update review 
	 $sql2="UPDATE Review SET agree = agree + 1 WHERE id='$_POST[reviewid]'";

	 if (!mysqli_query($con,$sql2))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update user 
	 $sql5="UPDATE User SET agree = agree + 1 WHERE id='$_POST[userid2]'";

	 if (!mysqli_query($con,$sql5))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
}else{
	//delete agree
	 $sql3="DELETE FROM Agree WHERE id = '$agreeCheckid'";

	 if (!mysqli_query($con,$sql3))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update review 
	 $sql4="UPDATE Review SET agree = agree - 1 WHERE id='$_POST[reviewid]'";

	 if (!mysqli_query($con,$sql4))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update user 
	 $sql6="UPDATE User SET agree = agree - 1 WHERE id='$_POST[userid2]'";

	 if (!mysqli_query($con,$sql6))
	 {
	 die('Error: ' . mysqli_error($con));
	 }

}
 mysqli_close($con);
 exit();
?>
