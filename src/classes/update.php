<?php
session_start(); 
include_once("./config.php"); // To connect to the database
include "./functions.php";
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

 
$sql99 = mysqli_query($con, "SELECT agree, object, trust, total FROM User WHERE id='$_POST[userid]'");
$sqlr99 = mysqli_fetch_array($sql99);
$agree99 = $sqlr99[0];
$object99 = $sqlr99[1];
$trust99 = $sqlr99[2];
$total99 = $sqlr99[3];

$rank99 = generate_rank($total99);

$result99 = array();
$result99['trust'] = $trust99;
$result99['total'] = $total99;
$result99['rank'] = $rank99;

echo json_encode($result99);
mysqli_close($con);
?>