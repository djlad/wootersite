<div class="row mt">
	<div class="col-lg-12">
	  <div class="form-panel">
		  <h4 class="mb"><i class="fa fa-angle-right"></i> Edit Password</h4>
		  <form class="form-horizontal style-form" method="post" action="/admin/ajax/EditPswd" id="admin-pswd-edit" data-success="Password change" data-redirect="/admin/login">
			  <div class="form-group">
				  <label class="col-sm-2 col-sm-2 control-label">Password</label>
				  <div class="col-sm-2 controls">
					  <input type="password" class="form-control" name="pswd" id="pswd" data-msg-required="Enter password">
				  </div>
			  </div>
			  <div class="form-group">
				  <label class="col-sm-2 col-sm-2 control-label">Password (confim)</label>
				  <div class="col-sm-2 controls">
					  <input type="password" class="form-control" name="re_pswd" id="re_pswd" data-msg-required="Confim password" data-msg-callback="Passwords do not match">
				  </div>
			  </div>
				<button type="submit" class="btn btn-success">Edit</button>
		  </form>
	  </div>
	</div><!-- col-lg-12-->      	
</div>