<?php if(!class_exists('Template')){exit;}?><h3><i class="fa fa-angle-right"></i> Vendors</h3>
<div class="row">
<div class="col-md-12">
<div class="content-panel">
  
<table class="table" data-target="/admin/vendors/ajax/delete" data-msg="Delete Vendor?">
<thead>
<tr>
                    <th>#</th>
<th>Business id ()</th>
<th><a href="/admin/vendors/order/company_name/<?php if( $order=='asc' ){ ?>desc<?php }else{ ?>asc<?php } ?>">Business Name</a></th>
                    <th><a href="/admin/vendors/order/color/<?php if( $order=='asc' ){ ?>desc<?php }else{ ?>asc<?php } ?>">Completeness Color</a></th>
                    <th><a href="/admin/vendors/order/percent/<?php if( $order=='asc' ){ ?>desc<?php }else{ ?>asc<?php } ?>">Percentage Complete</a></th>
                    <th><a href="/admin/vendors/order/cdate/<?php if( $order=='asc' ){ ?>desc<?php }else{ ?>asc<?php } ?>">Creation Date</a></th>
                    <th><a href="/admin/vendors/order/modified/<?php if( $order=='asc' ){ ?>desc<?php }else{ ?>asc<?php } ?>">Last Modified/Edited</a></th>
<th><a href="/admin/vendors/order/sport_count/<?php if( $order=='asc' ){ ?>desc<?php }else{ ?>asc<?php } ?>"># of activities</a></th>
<th><a href="/admin/vendors/order/prom_count/<?php if( $order=='asc' ){ ?>desc<?php }else{ ?>asc<?php } ?>"># of promotions</a></th>
                    <th>Total # of transactions sold</th>
                    <th>Total # of transactions redeemed</th>
                    <th>Total revenue</th>
                    <th>Balance Remaining</th>
<th style="width: 130px;">Options</th>
</tr>
</thead>
<tbody>
<?php foreach( $info as $k=>$val ){ ?>
<tr data-id="<? echo $val["id"];?>">
                        <td><? echo $k+1;?></td>
<td><a href="#" onclick="return false" data-toggle="popover" title="Company info" data-trigger="focus" data-content="<? echo $val["email"];?><br><? echo $val["phone_number"];?><br><? echo $val["address"];?><br><a href='/admin/vendors/edit/<? echo $val["id"];?>' alt='Edit Section' title='Edit Section'><button class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i></button></a>"><? echo $val["id"];?></a></td>
                        <td>
                            <a href="/admin/vendors/company/<? echo $val["id"];?>" ><? echo $val["company_name"];?></a>
                        </td>
<td><a href="#" onclick="return false" class="btn<?php if( $val["color"] == 'green' ){ ?> btn-success<?php } ?><?php if( $val["color"] == 'yellow' ){ ?> btn-warning<?php } ?><?php if( $val["color"] == 'red' ){ ?> btn-danger<?php } ?>"  data-toggle="popover" title="Change color" data-trigger="click" data-content="
    <form name='prom_color'>
                                <select name='prom_colors' class='prom_colors' prom-id='<? echo $val["id"];?>'>
                                  <option value='green' <?php if( $val["color"] == 'green' ){ ?>selected=''<?php } ?>>Green</option>
                                  <option value='yellow' <?php if( $val["color"] == 'yellow' ){ ?>selected=''<?php } ?>>Yellow</option>
                                  <option value='red' <?php if( $val["color"] == 'red' ){ ?>selected=''<?php } ?>>Red</option>
                                </select>
                            </from>
                        "><span class="glyphicon glyphicon-tasks"></span></a></td>
<td><? echo $val["percent"];?>%</td>
<td><? echo $val["cdate"];?></td>
                        <th><? echo $val["modified"];?></th>
                        <th><? echo $val["sport_count"];?></th>
                        <th><? echo $val["prom_count"];?></th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
<td>
<a href="/admin/vendors/company/<? echo $val["id"];?>" alt="Add Section" title="Add Section"><button class="btn btn-primary "><i class="fa fa-pencil"></i></button></a>
<button class="btn btn-danger delete" alt="Delete Vendor" title="Delete Vendor"><i class="fa fa-trash-o "></i></button>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div><!-- --/content-panel ---->
</div>
</div>