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
 // Form the SQL query (an INSERT query)
 //check if object exists
 if($objectCheck == 1){
 	mysqli_close($con);
 	exit();
 }
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
 //get total agree
 $agreeCount = mysqli_query($con, "SELECT agree FROM Review WHERE id ='$_POST[reviewid]'");
 $agreeCount =  mysqli_fetch_array($agreeCount)[0];
 //get total object
 $objectCount = mysqli_query($con, "SELECT object FROM Review WHERE id ='$_POST[reviewid]'");
 $objectCount =  mysqli_fetch_array($objectCount)[0];
 //get trustability
 $trust = mysqli_query($con, "SELECT trust FROM Review WHERE id ='$_POST[reviewid]'");
 $trust=  mysqli_fetch_array($trust)[0];
 
 $result = array();
 $result['agreecheck'] = $agreeCheck;
 $result['objectcheck'] = $objectCheck;
 $result['agreecount'] = $agreeCount;
 $result['objectcount'] = $objectCount;
 $result['trust'] = $trust;

 echo json_encode($result);
 mysqli_close($con);
 exit();
?>
