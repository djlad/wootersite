<h3><i class="fa fa-angle-right"></i> Promotion</h3>
<div class="row">
	<div class="col-md-12">
	  <div class="content-panel">
		  {if="$info"}
		  <table class="table" data-target="/admin/promotion/ajax/delete" data-msg="Delete Promotion?">
			  <thead>
			  <tr>
				  <th>#</th>
				  <th>Name</th>
				   <th style="width: 130px;">Options</th>
			  </tr>
			  </thead>
			  <tbody>
			  {foreach="$info as $val"}
				<tr data-id="{$val.id}">
					<td>{$val.id}</td>
					<td>{$val.name}</td>
					<td>
						<a href="/admin/vendors/sport/{$val.vendor_id}/edit/{$val.sport_id}" alt="Promotion Info" title="Promotion Info"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
						<button class="btn btn-danger btn-xs delete" alt="Delete Sport" title="Delete Sport"><i class="fa fa-trash-o "></i></button>
					</td>
				</tr>
			  {/foreach}
			  </tbody>
		  </table>
		  {else}
			Promotion Not Found
		  {/else}
	  </div><!-- --/content-panel ---->
	</div>
</div>