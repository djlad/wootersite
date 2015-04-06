<h3><i class="fa fa-angle-right"></i> Company Info</h3>
<div class="row mt">
	<div class="col-lg-12">
		<div class="form-panel">
		
			<form class="form-horizontal style-form" method="post" action="/admin/vendors/ajax/addSectionInfo/{$id}"  id="vendor-add-section" data-success="Info edited" data-id="{$id}">
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Name</label>
					<div class="col-sm-3 controls">
					  <input type="text" class="form-control" name="name" id="name" {if="!empty($info.name)"}value="{$info.name}"{/if} data-msg-required="Enter Name" style="width: 265px; float: left;" >&nbsp;<a class="btn btn-success gen-url" data-src="#name" data-target="#url">URL</a>
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Url</label>
					<div class="col-sm-3 controls">
					  <input type="text" class="form-control" name="url" id="url"  {if="!empty($info.url)"}value="{$info.url}"{/if} data-msg-required="Enter Url"  data-msg-callback="Url already use" data-msg-regexp="Enter valid url" >
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Link</label>
					<div class="col-sm-3 controls">
					  <input type="text" class="form-control" name="link" id="link"  {if="!empty($info.link)"}value="{$info.link}"{/if} >
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Image</label>
					<div class="col-sm-1 controls image">
					   <input id="fileupload" type="file" name="files[]" {if="!empty($info.image)"}style="display:none"{/if}>
					   <input name="image" value="{if="!empty($info.image)"}{$info.image}{/if}" id="discount" type="hidden">
					   {if="!empty($info.image)"}
							<img src="http://wooter.web-arts.com.ua{$info.image}" style="width: 300px;"><a href="#" onclick="$('#fileupload').click();">Edit</a>
					   {/if}
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">About Company</label>
					<div class="col-sm-10 controls">
					   <textarea id="about" class="form-control" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="about">
							{if="!empty($info.about)"}{$info.about}{/if}
					   </textarea>
					</div>
				</div>
				<div class="form-group control-label">
					<div class="col-sm-3 controls">
					  <button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
		  </form>
		  
		</div>
	</div>
</div>

<h3><i class="fa fa-angle-right"></i> Add Feature</h3>
<div class="row mt">
	<div class="col-lg-12">
		<div class="form-panel">
			<ul>
				{foreach="$sports as $s"}
					<li><a href="/admin/vendors/sport/{$id}/add/{$s.id}">{$s.name}</a></li>
				{/foreach}
			</ul>
		</div>
	</div>
</div>

<h3><i class="fa fa-angle-right"></i> Feature List</h3>
<div class="row mt">
	<div class="col-lg-12">
		<div class="form-panel">
			{if="$sportsInfo"}
				 <table class="table" data-target="/admin/vendors/ajax/deleteSport/{$id}" data-msg="Delete Sport?">
					  <thead>
					  <tr>
						  <th>#</th>
						  <th>Name</th>
						   <th style="width: 130px;">Options</th>
					  </tr>
					  </thead>
					  <tbody>
					  {foreach="$sportsInfo as $val"}
						<tr data-id="{$val.id}">
							<td>{$val.id}</td>
							<td>{$val.name}</td>
							<td>
								<a href="/admin/vendors/sport/{$id}/edit/{$val.id}" alt="Edit Sport Info" title="Edit Sport Info"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
								<button class="btn btn-danger btn-xs delete" alt="Delete Sport" title="Delete Sport"><i class="fa fa-trash-o "></i></button>
							</td>
						</tr>
					  {/foreach}
					  </tbody>
				  </table>
			{else}
				Sport not found 
			{/else}
		</div>
	</div>
</div>
 
<script>

/*jslint unparam: true */
/*global window, $ */
$(function () {
	
	$('#about').wysihtml5({
		'image': false,
		'link':false
	});
	
    'use strict';
    // Change this to the location of your server-side upload handler:
	var id = $("#vendor-add-section").attr('data-id');
    var url = "/admin/vendors/ajax/uploadImage/"+id
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
           if (data.result.status == "success") {
		   
				$("#fileupload").hide();
				$('.image > img').remove();
				$('.image > a').remove();
				$('.image > input[type=hidden]').remove();
				$('.image').append("<input type=\"hidden\" name=\"image\" value='"+data.result.info+"'/><img src='http://wooter.web-arts.com.ua"+data.result.info+"' style='width: 300px;'/><a href=\"#\" onclick=\"$('#fileupload').click();\">Edit</a>");
		   
		   }
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

});	

</script>