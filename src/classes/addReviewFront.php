<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<form action="./classes/addReviewBack.php" method="post">
                <div class="modal-header">
                    <div class="input-group mr-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Review</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>User</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
			    <div class="modal-body">
			        <div class="form-group">
			            <textarea rows="1" class="form-control" name="comment" id="comment" style="resize: none;"></textarea>
			        </div>
          
                    <center>
                        <select class="form-control" name="rating">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </center>

					<input type="hidden" id="cov" name="userId2">
					<script>document.getElementById("cov").value = c;</script>
			    </div>
			    <div class="modal-footer">
			        <button class="btn btn-secondary submit-button" type="submit"> Submit</button>
			    </div>
			</form>
		</div>
	</div>
</div>