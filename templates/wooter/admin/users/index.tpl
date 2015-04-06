<h3><i class="fa fa-angle-right"></i> Users</h3>
<div class="row">
	<div class="col-md-12">
	  <div class="content-panel">
		  
		  <table class="table" data-target="/admin/users/ajax/delete" data-msg="Delete User?">
			  <thead>
			  <tr>
				  <th>#</th>
				  <th>E-mail</th>
				  <th>First Name</th>
				  <th>Last Name</th>
				  <th>Code</th>
				  <th>Create Date</th>
				   <th style="width: 130px;">Options</th>
			  </tr>
			  </thead>
			  <tbody>
			  {foreach="$info as $val"}
				<tr data-id="{$val.id}">
					<td>{$val.id}</td>
					<td>{$val.email}</td>
					<td>{$val.first_name}</td>
					<td>{$val.last_name}</td>
					<td>{$val.code}</td>
					<td>{$val.cdate}</td>
					<td>
						<a href="/admin/users/show/{$val.id}" alt="Show User Info" title="Show User Info"><button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button></a>
						<button class="btn btn-danger btn-xs delete" alt="Delete User" title="Delete User"><i class="fa fa-trash-o "></i></button>
					</td>
				</tr>
			  {/foreach}
			  </tbody>
		  </table>
	  </div><!-- --/content-panel ---->
	</div>
</div>