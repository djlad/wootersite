<h3><i class="fa fa-angle-right"></i> {$info.name}</h3>
<form class="form-horizontal style-form" method="post" action="/admin/vendors/ajax/editSportInfo"  id="vendor-edit-sport" data-success="Sport edited" data-id="{$id_vendor}" data-redirect="/admin/vendors/section/{$id_vendor}">
	<div class="row mt">
		<div class="col-lg-12">
			<div class="form-panel">
				<h4><i class="fa fa-angle-right"></i> Feature Info</h4>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Image</label>
					<div class="col-sm-1 controls image">
					   <input id="fileupload" type="file" name="files[]" {if="!empty($sportInfo.image)"}style="display:none"{/if}>
					   {if="!empty($sportInfo.image)"}
							<img src="http://wooter.web-arts.com.ua{$sportInfo.image}" style="width: 300px;"><a href="#" onclick="$('#fileupload').click();">Edit</a>
							<input name="image" value="{$sportInfo.image}" type="hidden">
					   {/if}
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">About Sport</label>
					<div class="col-sm-10 controls">
					   <textarea id="about" class="form-control" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="about">
							{if="!empty($sportInfo.about)"}{$sportInfo.about}{/if}
					   </textarea>
					</div>
				</div>
				<div class="form-group control-label">
					<label class="col-sm-2 control-label">Map</label>
					<div class="col-sm-10 controls">
						<input type="text" id="addres" class="form-control" style="float: left; width:80%"/> &nbsp; <button class="send_adr btn btn-primary">Search</button>
						<div id="map_canvas" style="width:100%; height: 500px; margin-top:25px"></div>
						<input type="hidden" name="geo" {if="!empty($sportInfo.geo_x)"}value="({$sportInfo.geo_x}, {$sportInfo.geo_y})"{/if} />
					</div>
				</div>
				<input type="hidden" name="sport_id" id="sport_id" value="{$id_sport}" />
				<input type="hidden" name="vendor_id" id="vendor_id" value="{$id_vendor}" />

				<div class="form-group control-label">
					<div class="col-sm-3 controls">
						<button type="button" class="btn btn-primary add_promotion"> <i class="fa fa-plus"></i> Add Promotion </button>
						<button type="submit" class="btn btn-success"> Save </button>
					</div>
				</div>
				  
			</div>
		</div>
	</div>
	<div class="promotions">
	
		{if="$sportInfo.promotion"}
			{$i = 1}
			{foreach="$sportInfo.promotion as $p"}
		
				<div class="row mt" data-id="{$i}">
					<div class="col-lg-12">
						<div class="form-panel">
							<h4><i class="fa fa-angle-right"></i> Promotion {$i}</h4> <a href="#" class="delete_prom">delete</a>
							<div class="form-group control-label">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-3 controls">
									<input type="text" name="promotion[{$i}][name]" class="form-control" value = "{$p.name}">
								</div>
							</div>
							<div class="form-group control-label">
								<label class="col-sm-2 control-label">Age Group</label>
								<div class="col-sm-3 controls">
									<p>
										<label for="amount">Age range:&nbsp;</label>
										<input type="text" class="amount" readonly="" style="border:0; color:#f6931f; font-weight:bold;" value = "{$p.age_min} - {$p.age_max}">
										<input type="hidden" class="age_min" name="promotion[{$i}][age_min]" readonly="" value="{$p.age_min}">
										<input type="hidden" class="age_max" name="promotion[{$i}][age_max]" readonly="" value="{$p.age_max}">
									</p>
									<div class="slider-range-{$i}"></div>
								</div>
							</div>
							<div class="form-group control-label">
								<label class="col-sm-2 control-label">Skill Level</label>
								<div class="col-sm-3 controls">
									<div class="radio">
										<label>
										<input type="checkbox" name="promotion[{$i}][skill]" value="1" {if="$p.skill"}checked=""{/if}>&nbsp;Experienced&nbsp;</label>
									</div>
								</div>
							</div>
							<div class="form-group control-label">
								<label class="col-sm-2 control-label">Gender</label>
								<div class="col-sm-3 controls">
									<select name="promotion[{$i}][gender]" class="form-control">
										<option value = "all" {if="$p.gender == 'all'"}  selected {/if}>Co-Ed</option>
										<option value = "male" {if="$p.gender == 'male'"}  selected {/if}>Male</option>
										<option value = "female" {if="$p.gender == 'female'"}  selected {/if}>Female</option>
									</select>
								</div>
							</div>
							<div class="form-group control-label">
								<label class="col-sm-2 control-label">Sub Category</label>
								<input type="checkbox" name="promotion[{$i}][sub_1]" value="rent" {if="$p.sub_1=='rent'"}checked=""{/if}>&nbsp;Rent Any Court&nbsp;</label>
								<input type="checkbox" name="promotion[{$i}][sub_2]" value="experience" {if="$p.sub_2=='experience'"}checked=""{/if}>&nbsp;Experience&nbsp;</label>
								<input type="checkbox" name="promotion[{$i}][sub_3]" value="coach" {if="$p.sub_3=='coach'"}checked=""{/if}>&nbsp;Coach&nbsp;</label>
								<input type="checkbox" name="promotion[{$i}][sub_4]" value="league" {if="$p.sub_4=='league'"}checked=""{/if}>&nbsp;League&nbsp;</label>
								<input type="checkbox" name="promotion[{$i}][sub_5]" value="personal" {if="$p.sub_5=='personal'"}checked=""{/if}>&nbsp;Personal Fitness&nbsp;</label>
							</div>
							<div class="form-group control-label">
								<label class="col-sm-2 control-label">Schedule</label>
								<div class="col-sm-3 controls">
									{foreach="$days_array as $item_day"}
										<p>
											<label for="amount">{$item_day} :</label>
											<input type="text" class="time-{$item_day}" readonly="" style="border:0; color:#f6931f; font-weight:bold;">
											<input type="hidden" class="{$item_day}-time_min" name="promotion[{$i}][schedule][{$item_day}][time_min]" readonly="" value="{if="$p.schedule"}{$p['schedule'][$item_day]['time_min']}{/if}">
											<input type="hidden" class="{$item_day}-time_max" name="promotion[{$i}][schedule][{$item_day}][time_max]" readonly="" value="{if="$p.schedule"}{$p['schedule'][$item_day]['time_max']}{/if}">
										</p>
										<div class="slider-time-{$item_day}-{$i}"></div>
									{/foreach}
								</div>
							</div>
							<div class="form-group control-label">
							<label class="col-sm-2 control-label">Short Description</label>
							<div class="col-sm-10 controls">
							   <textarea class="form-control" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="desc" name="promotion[{$i}][s_desc]">
									{if="!empty($p.s_desc)"}{$p.s_desc}{/if}
							   </textarea>
							</div>
							</div>
							<div class="form-group control-label">
							<label class="col-sm-2 control-label">Full Description</label>
							<div class="col-sm-10 controls">
							   <textarea class="form-control" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="promotion[{$i}][f_desc]">
									{if="!empty($p.f_desc)"}{$p.f_desc}{/if}
							   </textarea>
							</div>
							</div>
							<div class="form-group control-label">
								<label class="col-sm-2 control-label">Image</label>
								<div class="col-sm-1 controls img">
								   <input id="fileuploads" type="file" name="files[]" data-id="{$i}" {if="!empty($p.img)"}style="display:none"{/if}>
								   {if="!empty($p.img)"}
										<img src="http://wooter.web-arts.com.ua{$p.img}" style="width: 300px;"><a href="#" onclick="$('#fileuploads').click();">Edit</a>
										<input name="promotion[{$i}][img]" value="{$p.img}" type="hidden">
								   {/if}
								</div>
							</div>
							<button type="button" class="btn btn-primary add_price"> <i class="fa fa-plus"></i> Add Price </button>
							<div class="form-panel price-panel">
							
								{if="$p.price"}
									{$p_i = 1}
									{foreach="$p.price as $price"}
									
										<div class="price" data-id="{$p_i}">
											<h4><i class="fa fa-angle-right"></i> Price {$p_i}</h4>
											<a href="#" class="delete_price">delete</a>
											<div class="form-group control-label">
												<label class="col-sm-2 control-label">Name</label>
												<div class="col-sm-3 controls">
													<input type="text" name="promotion[{$i}][price][{$p_i}][name]" class="form-control" value="{$price.name}">
												</div>
											</div>
											<div class="form-group control-label">
												<label class="col-sm-2 control-label">Old Price</label>
												<div class="col-sm-2 controls">
													<input type="text" name="promotion[{$i}][price][{$p_i}][old_price]" class="form-control" value="{$price.old_price}">
												</div>
											</div>
											<div class="form-group control-label">
												<label class="col-sm-2 control-label">New Price</label>
												<div class="col-sm-2 controls">
													<input type="text" name="promotion[{$i}][price][{$p_i}][new_price]" class="form-control" value="{$price.new_price}">
												</div>
											</div>
										</div>
										{$p_i = $p_i + 1}
									{/foreach}
								
								{/if}
							
							</div>
						</div>
					</div>
				</div>
				{foreach="$days_array as $item_day"}
					<script>
		
						$( ".slider-range-{$i}" ).slider({
						  range: true,
						  min: 0,
						  max: 100,
						  values: [<?=$p['age_min']?>, <?=$p['age_max']?>],
						  slide: function( event, ui ) {
							
							
							if (ui.values[ 0 ] == ui.values[ 1 ])
								return false;
							
							$(this).parent().find('.amount').val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
							$(this).parent().find('.age_min').val( ui.values[ 0 ]  );
							$(this).parent().find('.age_max').val( ui.values[ 1 ] );
						
						  }
						});	
						
						var val1 = {if="$p.schedule"}{$p.schedule[$item_day]['time_min']}{else}0{/else};
						var val2 = {if="$p.schedule"}{$p.schedule[$item_day]['time_max']}{else}0{/else};
						
						var h_min = Math.floor(val1/60);
						var h_max = Math.floor(val2/60);
						
						var m_min = val1 - (h_min*60);
						var m_max = val2 - (h_max*60);
						
						$(".slider-time-{$item_day}-{$i}").parent().find('.time-{$item_day}').val( getTime (h_min, m_min) + " - " + getTime (h_max, m_max) );
						
						$( ".slider-time-{$item_day}-{$i}" ).slider({
						  range: true,
						  min: 0,
						  values: [{if="$p.schedule"}{$p.schedule[$item_day]['time_min']}{else}0{/else}, {if="$p.schedule"}{$p.schedule[$item_day]['time_max']}{else}0{/else}],
						  max: 1440,
						  step:30,
						  slide: function( event, ui ) {
							
							var val1 = ui.values[ 0 ];
							var val2 = ui.values[ 1 ];
							
							var h_min = Math.floor(val1/60);
							var h_max = Math.floor(val2/60);
							
							var m_min = val1 - (h_min*60);
							var m_max = val2 - (h_max*60);

							if (val1 == val2)
								return false;

							$(this).parent().find('.time-{$item_day}').val( getTime (h_min, m_min) + " - " + getTime (h_max, m_max) );
							
							$(this).parent().find('.{$item_day}-time_min').val( val1 );
							$(this).parent().find('.{$item_day}-time_max').val( val2 );
							
						  }
						});
						
					</script>
				{/foreach}
				{$i = $i +1}
			{/foreach}
		
		{/if}
	
	</div>
</form>

<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCzxIKQIdroBQjYlSBdPGN0vtz3IW5Khxs&sensor=false">
 </script>

<script>

/* jslint unparam: true */
/* global window, $ */
$(function () {
	
	$('#about').wysihtml5({
		'image': false,
		'link':false
	});
	
    'use strict';
    // Change this to the location of your server-side upload handler:
	var id = $("#vendor-edit-sport").attr('data-id');
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
		
	$('#fileuploads').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
           if (data.result.status == "success") {
		   
				$("#fileuploads").hide();
				$('.img > img').remove();
				$('.img > a').remove();
				$('.img > input[type=hidden]').remove();
				$('.img').append("<input type=\"hidden\" name=\"promotion["+$(this).attr('data-id')+"][img]\" value='"+data.result.info+"'/><img src='http://wooter.web-arts.com.ua"+data.result.info+"' style='width: 300px;'/><a href=\"#\" onclick=\"$('#fileuploads').click();\">Edit</a>");
		   
		   }
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
		
	var markers = [];
	var mapOptions = {
	  center: new google.maps.LatLng({if="!empty($sportInfo.geo_x)"}{$sportInfo.geo_x}, {$sportInfo.geo_y}{else}50.25465, 28.658667{/else}),
	  zoom: 8,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas"),
		mapOptions);
		
	google.maps.event.addListener(map, 'click', function(event) {
		
		placeMarker(event.latLng);
		
	});
	
	 function placeMarker(location) {
		console.log(location);
		setAllMap(null);
		var marker = new google.maps.Marker({
		  position: location,
		  map: map
		});
		$('input[name=geo]').val(location);
		markers.push(marker)

	}
	
	
	

	{if="!empty($sportInfo.geo_x)"}
		placeMarker ( new google.maps.LatLng({$sportInfo.geo_x}, {$sportInfo.geo_y}));
	{/if}
	
	function setAllMap(map) {
	  for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(map);
	  }
	}
	
	$('.send_adr').click (function (){
	  
		var adr = $('#addres').val();
				
		$.getJSON( "http://maps.googleapis.com/maps/api/geocode/json?address="+adr, function( data ) {
				
			if (data.status == "OK") {
						
				map.setCenter(data.results[0].geometry.location);
				map.setZoom (18);

			}
				
		});
		
		return false;
	});
});
</script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en-AU"></script>
        <script>
            var autocomplete = new google.maps.places.Autocomplete($("#addres")[0], {});
			
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                console.log(place.address_components);
            });
        </script>