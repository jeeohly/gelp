<?php 
$logginuserid = $_SESSION['loggedIn'];

while($row = mysqli_fetch_array($resultAll)):
    $postUser1 = mysqli_query($con, "SELECT username FROM User WHERE id = '$row[1]'");
    $postUser1r = mysqli_fetch_array($postUser1)[0];
    $postUser2 = mysqli_query($con, "SELECT username FROM User WHERE id = '$row[2]'");
    $postUser2r = mysqli_fetch_array($postUser2)[0];

    $trusthund = $row[10];
    if($trusthund > 100){
        $trusthund = 100;
    }
    if($trusthund < 0){
        $trusthund = 0;
    }
    $timepast = time_elapsed_string($row[5]);

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
?>
    <script>
        document.getElementById("postfeed").innerHTML += "<div class='card' style='margin-top:15px;'><div class='card-header'><img class ='postprofileimg' src='https://i.imgur.com/wyYAmyX.jpg'><a href='./profile.php?id=<?php echo $row[1]; ?>'><span class='postname' id='postreviewer'><?php echo $postUser1r; ?></span></a> reviewed <a href='./profile.php?id=<?php echo $row[2]; ?>'><span class='postname' id='postreviewing'><?php echo $postUser2r; ?></span></a><span class='postdate'><?php echo $timepast ?></span></div><ul class='list-group list-group-flush'><li class='list-group-item'><?php echo $row[3]; ?></li><li class='list-group-item'><div class='row'><div class='col-3 border-right'><center><span id='<?php echo $row[0]; ?>bar2'><?php echo $trusthund; ?>%</span></center></div><div class='col-6'><div class='progress'><div class='progress-bar bg-secondary' role='progressbar' id='<?php echo $row[0]; ?>bar' style='width:<?php echo $trusthund; ?>%;'></div></div></div><div class='col-3 border-left'><center><?php echo $row[4]; ?></center></div></div></li><div id='<?php echo $row[0]; ?>d'></div></ul><div class='card-footer' style='padding-top:0px;padding-bottom:0px;'><div class='row'><div class='col-6'><button class='btn btn-light rounded-0 border-left border-right agreeload' style='width:100%;' id='<?php echo $row[0]; ?>'><div class='row'><div class='col-3'><span class='agreenum' id='<?php echo $row[0]; ?>num'><?php echo $row[7]; ?></span></div><div class='col-9' id='<?php echo $row[0]; ?>i1'><?php echo $agreeIcon ?></div></div></button></div><div class='col-6'><button class='btn btn-light rounded-0 border-left border-right objectload' style='width:100%;' name='<?php echo $row[0]; ?>'><div class='row'><div class='col-3'><span class='objectnum' id='<?php echo $row[0]; ?>num2'><?php echo $row[8]; ?></span></div><div class='col-9' id='<?php echo $row[0]; ?>i2'><?php echo $objectIcon ?></div></button></div></div></div></div><div style='display: none;' id='<?php echo $row[0]; ?>two'><?php echo $row[1]; ?></div>";
        //if( '<?php echo $row[2] ?>' == '<?php echo $_SESSION['loggedIn'] ?>'){
            //document.getElementById('<?php echo $row[0]; ?>d').innerHTML += "<li class='list-group-item border-top'><div class='row'><div class='col-4 border-right'><button class='btn btn-outline-secondary replyload' style='width:100%;' id='<?php echo $row[0]; ?>dd'>Reply</button></div><div class='col-8'><textarea class='form-control' rows='1' style='resize:none;'></textarea></div></div></li>";
        //}
    </script>
<?php endwhile; ?>
<!--Agree system-->
<script type="text/javascript">
    $(document).ready(function() {
        $('.agreeload').click(function(e){
            var passreviewid = jQuery(this).attr("id");  
            var passuserid1 = <?php echo $_SESSION['loggedIn']; ?>;
            var passuserid2 = document.getElementById(passreviewid+"two").innerHTML;

            $.ajax({
                type: "POST", 
                url: "./agree.php",
                dataType: "json",
                data: {userid1:passuserid1, userid2:passuserid2, reviewid:passreviewid},
                success: function(data){
                    console.log(data);
		    var newtrust = data.final;
		    if(newtrust >= 100){
			newtrust = 100;
		    }
		    if(newtrust <= 0){
			newtrust = 0;
		    }
                    if(data.agreecheck == 0 && data.objectcheck == 0){
                        var newagree = (parseInt(document.getElementById(passreviewid+"num").innerHTML) + 1).toString();
                        document.getElementById(passreviewid+"num").innerHTML = newagree;

                        document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                        document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                        document.getElementById(passreviewid+"i1").innerHTML = "<i class='fas fa-thumbs-up'></i>";
                    }if(data.agreecheck == 1 && data.objectcheck == 0){
                        var newagree2 = (parseInt(document.getElementById(passreviewid+"num").innerHTML) - 1).toString();
                        document.getElementById(passreviewid+"num").innerHTML = newagree2;

                        document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                        document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                        document.getElementById(passreviewid+"i1").innerHTML = "<i class='far fa-thumbs-up'></i>";
                    }
                },
                error: function (xhr, ajaxOptions, thrownError){
                    console.log(xhr);
                    console.log(thrownError);
                }   
            });

        });
        $('.objectload').click(function(e){
            var passreviewid = jQuery(this).attr("name"); 
            var passuserid1 = <?php echo $_SESSION['loggedIn']; ?>;
            var passuserid2 = document.getElementById(passreviewid+"two").innerHTML;
            $.ajax({
                type: "POST", 
                url: "./object.php",
                dataType: "json",
                data: {userid1:passuserid1, userid2:passuserid2, reviewid:passreviewid},
                success: function(data){
                    console.log(data);
		    var newtrust = data.final;
		    if(newtrust >= 100){
			newtrust = 100;
		    }
		    if(newtrust <= 0){
			newtrust = 0;
		    }
                    if(data.agreecheck == 0 && data.objectcheck == 0){
                        var newagree = (parseInt(document.getElementById(passreviewid+"num2").innerHTML) + 1).toString();
                        document.getElementById(passreviewid+"num2").innerHTML = newagree;
                        
                        document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                        document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                        document.getElementById(passreviewid+"i2").innerHTML = "<i class='fas fa-thumbs-down'></i>";
                    }if(data.agreecheck == 0 && data.objectcheck == 1){
                        var newagree2 = (parseInt(document.getElementById(passreviewid+"num2").innerHTML) - 1).toString();
                        document.getElementById(passreviewid+"num2").innerHTML = newagree2;
                        
                        document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                        document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                        document.getElementById(passreviewid+"i2").innerHTML = "<i class='far fa-thumbs-down'></i>";
                    }
                },
                error: function (xhr, ajaxOptions, thrownError){
                    console.log(xhr.statusText);
                    console.log(thrownError);
                }   
            });

        });
    });
</script>

<?php 
if($resultAll->num_rows == 0){
?>   
    <script>
        document.getElementById("postfeed").innerHTML += "<div class='card' style='margin-top:15px;'><div class='card-body'><h6><center>No reviews yet</center></h6></div></div>";
    </script>
<?php } ?>
