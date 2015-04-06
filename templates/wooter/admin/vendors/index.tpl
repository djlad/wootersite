<h3><i class="fa fa-angle-right"></i> Vendors</h3>
<div class="row">
	<div class="col-md-12">
		<div class="content-panel">
		  
			<table class="table" data-target="/admin/vendors/ajax/delete" data-msg="Delete Vendor?">
				<thead>
				<tr>
                    <th>#</th>
					<th>Business id ()</th>
					<th><a href="/admin/vendors/order/company_name/{if="$order=='asc'"}desc{else}asc{/else}">Business Name</a></th>
                    <th><a href="/admin/vendors/order/color/{if="$order=='asc'"}desc{else}asc{/else}">Completeness Color</a></th>
                    <th><a href="/admin/vendors/order/percent/{if="$order=='asc'"}desc{else}asc{/else}">Percentage Complete</a></th>
                    <th><a href="/admin/vendors/order/cdate/{if="$order=='asc'"}desc{else}asc{/else}">Creation Date</a></th>
                    <th><a href="/admin/vendors/order/modified/{if="$order=='asc'"}desc{else}asc{/else}">Last Modified/Edited</a></th>
					<th><a href="/admin/vendors/order/sport_count/{if="$order=='asc'"}desc{else}asc{/else}"># of activities</a></th>
					<th><a href="/admin/vendors/order/prom_count/{if="$order=='asc'"}desc{else}asc{/else}"># of promotions</a></th>
                    <th>Total # of transactions sold</th>
                    <th>Total # of transactions redeemed</th>
                    <th>Total revenue</th>
                    <th>Balance Remaining</th>
					<th style="width: 130px;">Options</th>
				</tr>
				</thead>
				<tbody>
				{foreach="$info as $k => $val"}
					<tr data-id="{$val.id}">
                        <td>{$k+1}</td>
						<td><a href="#" onclick="return false" data-toggle="popover" title="Company info" data-trigger="focus" data-content="{$val.email}<br>{$val.phone_number}<br>{$val.address}<br><a href='/admin/vendors/edit/{$val.id}' alt='Edit Section' title='Edit Section'><button class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i></button></a>">{$val.id}</a></td>
                        <td>
                            <a href="/admin/vendors/company/{$val.id}" >{$val.company_name}</a>
                        </td>
						<td><a href="#" onclick="return false" class="btn{if="$val.color == 'green'"} btn-success{/if}{if="$val.color == 'yellow'"} btn-warning{/if}{if="$val.color == 'red'"} btn-danger{/if}"  data-toggle="popover" title="Change color" data-trigger="click" data-content="
						    <form name='prom_color'>
                                <select name='prom_colors' class='prom_colors' prom-id='{$val.id}'>
                                  <option value='green' {if="$val.color == 'green'"}selected=''{/if}>Green</option>
                                  <option value='yellow' {if="$val.color == 'yellow'"}selected=''{/if}>Yellow</option>
                                  <option value='red' {if="$val.color == 'red'"}selected=''{/if}>Red</option>
                                </select>
                            </from>
                        "><span class="glyphicon glyphicon-tasks"></span></a></td>
						<td>{$val.percent}%</td>
						<td>{$val.cdate}</td>
                        <th>{$val.modified}</th>
                        <th>{$val.sport_count}</th>
                        <th>{$val.prom_count}</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
						<td>
							<a href="/admin/vendors/company/{$val.id}" alt="Add Section" title="Add Section"><button class="btn btn-primary "><i class="fa fa-pencil"></i></button></a>
							<button class="btn btn-danger delete" alt="Delete Vendor" title="Delete Vendor"><i class="fa fa-trash-o "></i></button>
						</td>
					</tr>
				{/foreach}
				</tbody>
			</table>
		</div><!-- --/content-panel ---->
	</div>
</div>