<?php

include_once("./classes/config.php"); // To connect to the database
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
 //check if object exists
 if($objectCheck == 1){
 	mysqli_close($con);
 	exit();
 }
 //get user1 trust
 $user1trustquery =  mysqli_query($con, "SELECT trust FROM User WHERE id ='$_POST[userid1]'");
 $user1trust =  mysqli_fetch_array($user1trustquery)[0]/100;
 //get review trust 
 $trust = mysqli_query($con, "SELECT trust FROM Review WHERE id ='$_POST[reviewid]'");
 $trust =  (int)mysqli_fetch_array($trust)[0];
 $trustadd = (int)round($user1trust*10, 0);

 if($agreeCheck == 0){
 	if($trustadd > 100 - $trust){
 		//$trustadd = 100 - $trust;
 		$trust = 100;
 	}else{
 		$trust = $trust + $trustadd;
 	}
 	 //insert agree
	 $sql="INSERT INTO Agree (userId1, userId2, reviewId, amount)
	 VALUES
	 ('$_POST[userid1]','$_POST[userid2]', '$_POST[reviewid]', '$trustadd')";

	 if (!mysqli_query($con,$sql))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update review 
	 $sql2="UPDATE Review SET agree = agree + 1, trust = trust + '$trustadd' WHERE id='$_POST[reviewid]'";

	 if (!mysqli_query($con,$sql2))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update user agree
	 $sql5="UPDATE User SET agree = agree + 1 WHERE id='$_POST[userid2]'";

	 if (!mysqli_query($con,$sql5))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
}else{
	 //get amount
	 $sql8 = mysqli_query($con, "SELECT amount FROM Agree WHERE userId1 = '$_POST[userid1]' AND reviewId = '$_POST[reviewid]'");
	 $trustadd = (int)mysqli_fetch_array($sql8)[0];
	 if($trustadd > $trust){
	 	//$trustadd = $trust;
	 	$trust = 0;
	 }else{
	 	$trust = $trust - $trustadd;
	 }
	 //update review 
	 $sql4="UPDATE Review SET agree = agree - 1, trust = trust - '$trustadd' WHERE id='$_POST[reviewid]'";

	 if (!mysqli_query($con,$sql4))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	//delete agree
	 $sql3="DELETE FROM Agree WHERE id = '$agreeCheckid'";

	 if (!mysqli_query($con,$sql3))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
	 //update user agree
	 $sql6="UPDATE User SET agree = agree - 1 WHERE id='$_POST[userid2]'";

	 if (!mysqli_query($con,$sql6))
	 {
	 die('Error: ' . mysqli_error($con));
	 }
}
 //update user trust
 $sql7="UPDATE User SET trust = IF(agree + object = 0, 50,ROUND(agree/(agree+object)*100, 0)) WHERE id='$_POST[userid2]'";

 if (!mysqli_query($con,$sql7))
 {
 die('Error: ' . mysqli_error($con));
 }
 $result = array();
 $result['agreecheck'] = $agreeCheck;
 $result['objectcheck'] = $objectCheck;
 $result['final'] = $trust;
 $result['add'] = $trustadd;

 echo json_encode($result);
 mysqli_close($con);
 exit();
?>
