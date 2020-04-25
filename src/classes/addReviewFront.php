<?php 
    $queryUsersAll = "SELECT id, username FROM User ORDER BY username";
    $resultUsersAll = mysqli_query($con, $queryUsersAll);
?>
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<form action="./classes/addReviewBack.php" method="post">
			    <div class="modal-body pb-0 pt-0">
                    <div class="row pl-2 pr-2 pt-2">
                        <div class="col-6 p-0">
                            <div class="input-group mr-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01"><i class='fas fa-user'></i></label>
                                </div>
                                <select class="custom-select border-right-0" style="border-radius:0px;" id="inputGroupSelect01" name="userId2">
                                    <?php if(isset($userid) && $userid != $_SESSION['loggedIn']){ ?>
                                        <option selected value="<?php echo $userid ?>"><?php echo $username ?></option>
                                        <?php while($user = mysqli_fetch_array($resultUsersAll)): 
                                            if($userid != $user[0] && $user[0] != $_SESSION['loggedIn']){
                                        ?>
                                            <option value="<?php echo $user[0]; ?>"><?php echo $user[1]; ?></option>
                                        <?php }endwhile; ?>
                                    <?php }else{ ?>
                                        <?php while($user = mysqli_fetch_array($resultUsersAll)): 
                                            if($user[0] != $_SESSION['loggedIn']){
                                        ?>
                                            <option value="<?php echo $user[0]; ?>"><?php echo $user[1]; ?></option>
                                        <?php }endwhile; ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 p-0">
                            <div class="input-group mr-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect02" style="border-radius:0px"><i class="fas fa-plus-circle"></i></label>
                                </div>
                                <select class="custom-select" id="inputGroupSelect02" name="rating">
                                    
                                    <option selected value="1">1 Terrible</option>
                                    <option value="2">2 Bad</option>
                                    <option value="3">3 Okay</option>
                                    <option value="4">4 Good</option>
                                    <option value="5">5 Excellent</option>
                                </select>
                            </div>
                        </div>
                    </div>
			        <textarea rows="3" class="form-control mt-3" name="comment" id="comment" style="resize: none;"></textarea>

                    <div class="row border-top mt-3" style="border-radius:0px 0px 5px 5px;background-color:rgb(244,244,244);">
                        <div class="col-6 p-3 border-right">
                            <center><button class="btn btn-light" style="width:100%;" type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button></center>
                        </div>
                        <div class="col-6 p-3">
                            <center><button class="btn btn-light submit-button" style="width:100%;" type="submit"><i class="fas fa-pencil-square-o"></i></button></center>
                        </div>
                    </div>

			    </div>
			</form>
		</div>
	</div>
</div>