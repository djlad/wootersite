<h3><i class="fa fa-angle-right"></i> Sport Edit | {$info.name}</h3>

<div class="row mt">
	<div class="col-lg-12">
		<div class="form-panel">
			<form class="form-horizontal style-form" method="post" action="/admin/sports/ajax/edit/{$info.id}"  id="sport-edit" data-success="Sport Edited" data-redirect="/admin/sports" data-id="{$info.id}">
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Name</label>
					<div class="col-sm-3 controls">
					   <input type="text" class="form-control" name="name" id="name" value="{$info.name}" data-msg-required="Enter Name" style="width: 270px; float: left;" >&nbsp;<a class="btn btn-success gen-url" data-src="#name" data-target="#url">URL</a>
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Url</label>
					<div class="col-sm-3 controls">
					  <input type="text" class="form-control" name="url" id="url" value="{$info.url}" data-msg-required="Enter Url"  data-msg-callback="Url already use" data-msg-regexp="Enter valid url" >
					</div>
				</div>
				
				<div class="form-group control-label">
					<div class="col-sm-3 controls">
					  <button type="submit" class="btn btn-primary">Edit</button>
					</div>
				</div>
		  </form>
		</div>
	</div>
</div>