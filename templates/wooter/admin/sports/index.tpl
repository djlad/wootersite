<h3><i class="fa fa-angle-right"></i> Sports</h3>
<div class="row">
	<div class="col-md-12">
	  <div class="content-panel">
		  
		  <table class="table" data-target="/admin/sports/ajax/delete" data-msg="Delete Sport?">
			  <thead>
			  <tr>
				  <th>#</th>
				  <th>Name</th>
				  <th>Url</th>
				   <th style="width: 130px;">Options</th>
			  </tr>
			  </thead>
			  <tbody>
			  {foreach="$info as $val"}
				<tr data-id="{$val.id}">
					<td>{$val.id}</td>
					<td>{$val.name}</td>
					<td>{$val.url}</td>
					<td>
						<a href="/admin/sports/edit/{$val.id}" alt="Edit Sport Info" title="Edit Sport Info"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
						<button class="btn btn-danger btn-xs delete" alt="Delete Sport" title="Delete Sport"><i class="fa fa-trash-o "></i></button>
					</td>
				</tr>
			  {/foreach}
			  </tbody>
		  </table>
	  </div><!-- --/content-panel ---->
	</div>
</div>