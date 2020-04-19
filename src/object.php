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
// check if already objected
 $objectCheck = 0;
 $objectCheckquery = mysqli_query($con, "SELECT id FROM Object WHERE userId1 ='$_POST[userid1]' AND reviewId ='$_POST[reviewid]'");
 $objectCheckid =  mysqli_fetch_array($objectCheckquery)[0];

 if($objectCheckquery->num_rows > 0){
 	$objectCheck = 1;
 }

 $result = array();
 $result['agreecheck'] = $agreeCheck;
 $result['objectcheck'] = $objectCheck;

 echo json_encode($result);
 // Form the SQL query (an INSERT query)
 //check if object exists
 if($agreeCheck == 1){
 	mysqli_close($con);
 	exit();
 }
 // Form the SQL query (an INSERT query)
 if($objectCheck == 0){
	 $sql="INSERT INTO Object (userId1, userId2, reviewId)
	 VALUES
	 ('$_POST[userid1]','$_POST[userid2]', '$_POST[reviewid]')";

	 if (!mysqli_query($con,$sql))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update review 
	 $sql2="UPDATE Review SET object = object + 1 WHERE id='$_POST[reviewid]'";

	 if (!mysqli_query($con,$sql2))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update user 
	 $sql5="UPDATE User SET object = object + 1 WHERE id='$_POST[userid2]'";

	 if (!mysqli_query($con,$sql5))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
}else{
	//delete agree
	 $sql3="DELETE FROM Object WHERE id = '$objectCheckid'";

	 if (!mysqli_query($con,$sql3))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update review 
	 $sql4="UPDATE Review SET object = object - 1 WHERE id='$_POST[reviewid]'";

	 if (!mysqli_query($con,$sql4))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update user 
	 $sql6="UPDATE User SET object = object - 1 WHERE id='$_POST[userid2]'";

	 if (!mysqli_query($con,$sql6))
	 {
	 die('Error: ' . mysqli_error($con));
	 }

}
 mysqli_close($con);
 exit();
?>
