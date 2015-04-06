<h3><i class="fa fa-angle-right"></i> User Add</h3>

<div class="row mt">
	<div class="col-lg-12">
		<div class="form-panel">
			<form class="form-horizontal style-form" method="post" action="/admin/users/ajax/add"  id="user-add" data-success="User Added" data-redirect="/admin/users">
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-3 controls">
					  <input type="text" class="form-control" name="email" id="email" data-msg-required="Enter Email" data-msg-callback="Email already use" data-msg-regexp="Enter valid email">
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Password</label>
					<div class="col-sm-3 controls">
					  <input type="password" class="form-control" name="pswd" id="pswd" data-msg-required="Enter Password" >
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Password (Confim)</label>
					<div class="col-sm-3 controls">
					  <input type="password" class="form-control" name="re_pswd" id="re_pswd" data-msg-required="Confim Password"  data-msg-callback="Passwords do not match" >
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">First Name</label>
					<div class="col-sm-3 controls">
					  <input type="text" class="form-control" name="first_name" id="first_name" data-msg-required="Enter First Name"  >
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Last Name</label>
					<div class="col-sm-3 controls">
					  <input type="text" class="form-control" name="last_name" id="last_name" data-msg-required="Enter Last Name"  >
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Zip Code</label>
					<div class="col-sm-3 controls">
					  <input type="text" class="form-control" name="code" id="code">
					</div>
				</div>
				<div class="form-group control-label">
					<div class="col-sm-3 controls">
					  <button type="submit" class="btn btn-primary">Add</button>
					</div>
				</div>
		  </form>
		</div>
	</div>
</div>