<h3><i class="fa fa-angle-right"></i> Vendor Add</h3>

<div class="row mt">
	<div class="col-lg-12">
		<div class="form-panel">
			<form class="form-horizontal style-form" method="post" action="/admin/vendors/ajax/add"  id="vendor-add" data-success="Vendor Added" data-redirect="/admin/vendors/company/">
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
					<label class="col-sm-2 control-label">Phone Number</label>
					<div class="col-sm-3 controls">
					  <input type="text" class="form-control" name="phone_number" id="phone_number" >
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Address</label>
					<div class="col-sm-3 controls">
						<input type="text" name = "address" autocomplete="off" class="form-control" id="address" />
						
						<input type="hidden" name = "x" class="geo-x" value="0" />
						<input type="hidden" name = "y" class="geo-y" value="0" />
					</div>
				</div>	
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Tax ID</label>
					<div class="col-sm-3 controls">
						<input type="text" class="form-control"/> 
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

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>
<script src="/static/admin/js/map-autocomplete.js"></script> 