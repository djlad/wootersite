<h3><i class="fa fa-angle-right"></i> Purchase</h3>
<div class="row">
	<div class="col-md-12">
	  <div class="content-panel">
		  
		  <table class="table">
			  <thead>
			  <tr>
				  <th>Company Name</th>
				  <th>Price</th>
				  <th>Promotion Name</th>
				  <th>Sport</th>
				  <th>User</th>
				   <th style="width: 130px;">Options</th>
			  </tr>
			  </thead>
			  <tbody>
			  {foreach="$info as $val"}
				<tr>
					<td>{$val.company_name}</td>
					<td>{$val.price}</td>
					<td>{$val.promotion_name}</td>
					<td>{$val.sport_name}</td>
					<td>{$val.user_first_name} {$val.user_last_name}</td>
					<td>
						<a href="/admin/purchase/{$val.id}" alt="Show Info" title="Show Info"><button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button></a>
					</td>
				</tr>
			  {/foreach}
			  </tbody>
		  </table>
	  </div><!-- --/content-panel ---->
	</div>
</div>