<?php 
//check if profile page 
$isprofile = 0;
if(isset($userid)){
    $isprofile = 1;
}else{
    $isprofile = 0;
    $userid = 0;
}
//get first last Review id to show
$empty = 0;
$queryAll1 = "SELECT id FROM Review ORDER BY id DESC LIMIT 1";
$resultAll1 = mysqli_query($con, $queryAll1);
if($isprofile == 1){
    $queryAll1 = "SELECT id FROM Review WHERE userid2 = '$userid' ORDER BY id DESC LIMIT 1";
    $resultAll1 = mysqli_query($con, $queryAll1);
}
$lastId = mysqli_fetch_array($resultAll1)[0] + 1;
// and check if empty
if($resultAll1->num_rows == 0){
    $empty = 1;
}
?>


<script type="text/javascript">
var empty = <?php echo $empty; ?>;
var lastId = parseInt(<?php echo $lastId; ?>);

//console.log(lastId);

//initial load
loadMoreData(lastId);

$(document).ready(function() {
    if(empty == 1){
        document.getElementById("postfeed").innerHTML += "<div class='card' style='margin-top:15px;'><div class='card-body'><h6><center>No reviews yet</center></h6></div></div>";
    }
    windowOnScroll();
});


function windowOnScroll() {
    $(window).on("scroll", function(e){
        if ($(window).scrollTop() == $(document).height() - $(window).height()){
            loadMoreData(lastReviewId);
        }
    });
}

function loadMoreData(lastId){
    var isprofile = <?php echo $isprofile; ?>;
    var userid = <?php echo $userid; ?>;
    var temp = lastId;
    $.ajax({
        type: "POST", 
        url: "./classes/loadMore.php",
        dataType: "json",
        data: {lastReviewId: temp, pass1: isprofile, pass2: userid},
        success: function(data){
            console.log(data);
            lastReviewId = parseInt(data.last);
            for(var i = 1; i <= data.size; i ++){
                document.getElementById("postfeed").innerHTML += "<div class='card' style='margin-top:15px;'><div class='card-header'><img class ='postprofileimg' src='https://i.imgur.com/wyYAmyX.jpg'><a href='./profile.php?id="+data[i][1]+"'><span class='postname' id='postreviewer'>"+data[i].postUser1+"</span></a> reviewed <a href='./profile.php?id="+data[i][2]+"'><span class='postname' id='postreviewing'>"+data[i].postUser2+"</span></a><span class='postdate'>"+data[i].timepast+"</span></div><ul class='list-group list-group-flush'><li class='list-group-item'>"+data[i][3]+"</li><li class='list-group-item'><div class='row'><div class='col-3 border-right'><center><span id='"+data[i][0]+"bar2'>"+data[i].trusthund+"%</span></center></div><div class='col-6'><div class='progress'><div class='progress-bar bg-secondary' role='progressbar' id='"+data[i][0]+"bar' style='width:"+data[i].trusthund+"%;'></div></div></div><div class='col-3 border-left'><center>"+data[i][4]+"</center></div></div></li><div id='"+data[i][0]+"d'></div></ul><div class='card-footer' style='padding-top:0px;padding-bottom:0px;'><div class='row'><div class='col-6'><button class='btn btn-light rounded-0 border-left border-right agreeload' style='width:100%;' id='"+data[i][0]+"'><div class='row'><div class='col-3'><span class='agreenum' id='"+data[i][0]+"num'>"+data[i][7]+"</span></div><div class='col-9' id='"+data[i][0]+"i1'>"+data[i].agreeIcon+"</div></div></button></div><div class='col-6'><button class='btn btn-light rounded-0 border-left border-right objectload' style='width:100%;' name='"+data[i][0]+"'><div class='row'><div class='col-3'><span class='objectnum' id='"+data[i][0]+"num2'>"+data[i][8]+"</span></div><div class='col-9' id='"+data[i][0]+"i2'>"+data[i].objectIcon+"</div></button></div></div></div></div><div style='display: none;' id='"+data[i][0]+"two'>"+data[i][1]+"</div>";

            }
        }, 
        error: function (xhr, ajaxOptions, thrownError){
            console.log(xhr);
            console.log(thrownError);
        } 
    });
}
//Agree system
$(document).on('click', '.agreeload', function(e){
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
            if(data.agreecheck == 0 && data.objectcheck == 0){
                var newagree = (parseInt(document.getElementById(passreviewid+"num").innerHTML) + 1).toString();
                document.getElementById(passreviewid+"num").innerHTML = newagree;

                var newtrust = data.final;
                document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                document.getElementById(passreviewid+"i1").innerHTML = "<i class='fas fa-thumbs-up'></i>";
            }if(data.agreecheck == 1 && data.objectcheck == 0){
                var newagree2 = (parseInt(document.getElementById(passreviewid+"num").innerHTML) - 1).toString();
                document.getElementById(passreviewid+"num").innerHTML = newagree2;

                var newtrust = data.final;
                document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                document.getElementById(passreviewid+"i1").innerHTML = "<i class='far fa-thumbs-up'></i>";
            }
        },
        error: function (xhr, ajaxOptions, thrownError){
            console.log(xhr.statusText);
            console.log(thrownError);
        }   
    });

});

$(document).on('click', '.objectload', function(e){
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
            if(data.agreecheck == 0 && data.objectcheck == 0){
                var newagree = (parseInt(document.getElementById(passreviewid+"num2").innerHTML) + 1).toString();
                document.getElementById(passreviewid+"num2").innerHTML = newagree;
                var newtrust = data.final;
                document.getElementById(passreviewid+"bar").style.width = newtrust+"%";
                document.getElementById(passreviewid+"bar2").innerHTML = newtrust+"%";
                document.getElementById(passreviewid+"i2").innerHTML = "<i class='fas fa-thumbs-down'></i>";
            }if(data.agreecheck == 0 && data.objectcheck == 1){
                var newagree2 = (parseInt(document.getElementById(passreviewid+"num2").innerHTML) - 1).toString();
                document.getElementById(passreviewid+"num2").innerHTML = newagree2;
                var newtrust = data.final;
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

</script>


