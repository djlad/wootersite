<h3><i class="fa fa-angle-right"></i> {$info.name}</h3>
<form class="form-horizontal style-form" method="post" action="/admin/vendors/ajax/addSportInfo"  id="vendor-add-sport" data-success="Sport added" data-id="{$id_vendor}" data-redirect="/admin/vendors/section/{$id_vendor}">
	<div class="row mt">
		<div class="col-lg-12">
			<div class="form-panel">
				<h4><i class="fa fa-angle-right"></i> Feature Info</h4>
					<div class="form-group control-label">
						<label class="col-sm-2 control-label">Image</label>
						<div class="col-sm-1 controls image">
						   <input id="fileupload" type="file" name="files[]" {if="!empty($info.image)"}style="display:none"{/if}>
						</div>
					</div>
					<div class="form-group control-label">
						<label class="col-sm-2 control-label">About Sport</label>
						<div class="col-sm-10 controls">
						   <textarea id="about" class="form-control" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="about">
								
						   </textarea>
						</div>
					</div>
					<div class="form-group control-label">
						<label class="col-sm-2 control-label">Map</label>
						<div class="col-sm-10 controls">
							<input type="text" id="addres" class="form-control" style="float: left; width:80%"/> &nbsp; <button class="send_adr btn btn-primary">Search</button>
							<div id="map_canvas" style="width:100%; height: 500px; margin-top:25px"></div>
							<input type="hidden" name="geo" {if="!empty($info.geo_x)"}value="({$info.geo_x}, {$info.geo_y})"{/if} />
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

	</div>
</form>

<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCzxIKQIdroBQjYlSBdPGN0vtz3IW5Khxs&sensor=false">
 </script>
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
	var id = $("#vendor-add-sport").attr('data-id');
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
		
	$( ".slider-range" ).slider({
      range: true,
      min: 0,
      max: 100,
      slide: function( event, ui ) {
		
		
		if (ui.values[ 0 ] == ui.values[ 1 ])
			return false;
		
		$(this).parent().find('.amount').val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
		$(this).parent().find('.age_min').val( ui.values[ 0 ]  );
		$(this).parent().find('.age_max').val( ui.values[ 1 ] );
	
      }
    });
	
	$( ".slider-time" ).slider({
      range: true,
      min: 0,
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

		$(this).parent().find('.time-operation').val( getTime (h_min, m_min) + " - " + getTime (h_max, m_max) );
		
		$(this).parent().find('.time_min').val( val1  );
		$(this).parent().find('.time_max').val( val2 );
		
      }
    });
	
	
	
	
	var markers = [];
	var mapOptions = {
	  center: new google.maps.LatLng({if="!empty($info.geo_x)"}{$info.geo_x}, {$info.geo_y}{else}50.25465, 28.658667{/else}),
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
	
	{if="!empty($info.geo_x)"}
		placeMarker ( new google.maps.LatLng({$info.geo_x}, {$info.geo_y}));
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