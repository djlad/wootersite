$(document).ready(function(){
	map = new google.maps.Map(
		document.getElementById("map_canvas"),
		{
			zoom: 8,
			maxZoom: 14,
            center:new google.maps.LatLng(40.7056258, -73.97968),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
		}
	);

    google.maps.event.addListener(map, 'click', function(event){
        this.setOptions({scrollwheel:true});
    });

    google.maps.event.addListener(map, 'mouseout', function(event){
        this.setOptions({scrollwheel:false});
    });
	if (typeof $('#map_canvas_s') !="undefined") {
	
		map_s = new google.maps.Map(
			document.getElementById("map_canvas_s"),
			{
				zoom: 8,
				maxZoom: 14,
				center: new google.maps.LatLng(40.7056258, -73.97968),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		);
		
		markerShadow = new google.maps.Marker({
			map: map_s
		});
	
	}
	
	markerMap = new google.maps.Marker({
		map: map
	});
	
	$.ajax({
		type: "POST",
		url: '/admin/vendors/ajax/getAllMaps',
		data : {v_id : id, s_id:sport_id},
		dataType: "json",
		success : function (res) {
			
			if (res.status == 'success') {
				var bounds = new google.maps.LatLngBounds();
                data = res.data;

                $.each(data, function(index, value){

                    var coord = new google.maps.LatLng(value.x, value.y);

                    bounds.extend(coord);

                    var contentString = '<div style="width:250px; height:auto"><p><a href="/promotion/'+value.vendor_id+'/'+value.sport_id+'">'+value.name+'</a></p><img src="/uploads/vendors/'+value.vendor_id+'/'+value.img+'" style="height:150px"></div>';
                    var infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });

                    var marker = new google.maps.Marker({
                        map: map
                    });

                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.open(map,marker);
                    });

                    marker.setPosition(coord);
                    marker.setVisible(true);

                    //markers.push(marker);

                });
				
				map.fitBounds(bounds);
				

			}
			
		
		},
		
		error : function (res) {
		
			alert(1);
		
		}
		
	});

			
	if (typeof $('#map_canvas_s') !="undefined") {
	
		$("#add_address").on('shown.bs.modal', function () {
			
			google.maps.event.trigger(map_s, 'resize'); // фикс для модалки
			
			map_s.setCenter(new google.maps.LatLng(40.7056258, -73.97968));
			
		});
		
		var input = (document.getElementById('addres'));
		
		var autocomplete = new google.maps.places.Autocomplete(input);
		
		autocomplete.bindTo('bounds', map_s);
		
		var marker = new google.maps.Marker({
			map: map_s,
			anchorPoint: new google.maps.Point(0, -29)
		});
		
	}
	
	if (typeof $('#map_canvas_s') !="undefined") {
	
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			marker.setPosition(place.geometry.location);
			markerShadow.setPosition(place.geometry.location);
			marker.setVisible(true);

			var location = place.geometry.location;
			var name = $("#addres").val();
			
			map_s.setCenter(location);
			map_s.setZoom(17);  // Why 17? Because it looks good.
			
			if (typeof prom_id != 'undefined'){
			
				$.ajax({
					type: "POST",
					url: '/admin/vendors/ajax/addMark/'+prom_id+'/'+name+'/'+location, //тупой Google Maps не дает отправить POST
					dataType: "json",
					success : function (res) {

                        $('.prom_map').addClass('link_active').html("Edit address <span class=\"plus_icon\"></span>");

						if (res.status == 'success') {
						
							$('.marks').append ('<li><a href="#" class="setMap" data-lang="'+location+'">'+name+'</a> <a href="#" class="delete_map" data-id="'+res.id+'">delete</a></li>');

						}else if (res.status == 'fail') {
							
							
						}
                        
					},
					
					error : function (res) {
					
						alert(1);
					
					}
					
				});
		
			}
		});
	
	}
	
	$(document).on('click', '.setMap', function (){
		
		var lang = $(this).attr('data-lang');
		var arr = lang.replace(/[\(\)]/g,'').trim().split(',');
		var coord = new google.maps.LatLng(arr[0], arr[1]);
		
		map_s.setZoom(17);
		map_s.setCenter(coord);
		//marker.setPosition(coord);
		
		return false;
	
	});
	
	$(document).on ('click', '.prom_map', function () {
		
		$('.marks').empty();
		$('.used_addres').empty();
		
		prom_id = $(this).parents('.prom_id').attr('data-id');
		
		if (typeof prom_id != "undefined") {
		
			$.ajax({
				type: "POST",
				url: '/admin/vendors/ajax/getPromMaps/'+prom_id,
				dataType: "json",
				
				success : function (res) {
					
					if (res.status == 'success') {
						
						var boundsMap = new google.maps.LatLngBounds();
						
						$.each (res.data, function (index, value){
						
							$('.marks').append ('<li><a href="#" class="setMap" data-lang="('+value.x+', '+value.y+')">'+value.name+'</a> <a href="#" class="delete_map" data-id="'+value.id+'">delete</a></li>');	
							
							var coord = new google.maps.LatLng(value.x, value.y);
							
							boundsMap.extend(coord);
						
							markerMap = new google.maps.Marker({
								map: map_s
							});

							markerMap.setPosition(coord);
							
						});
						
						//map.fitBounds(boundsMap);
						
					}else if (res.status == 'fail') {
						
						
					}
				
				},
				
				error : function (res) {
				
					alert(1);
				
				}
				
			});
			
			$.ajax({
				type: "POST",
				url: '/admin/vendors/ajax/getAllMap/'+id+'/'+sport_id+'/'+prom_id,
				dataType: "json",
				success : function (res) {
					
					if (res.status == 'success'){

                        if (res.status != 'fail'){

                            $.each (res.data, function (index, value){

                                $('.used_addres').append ('<a href="#" class="add_adress" data-id="'+value.id+'">'+value.name+'</a></br>');

                            });
                            
                        }

					}
					
					
				},
				
				error : function (res) {
				
					alert(1);
				
				}
				
			});
		
		}

	});
	
	$(document).on ('click', '.add_adress', function (){
		
		var id = $(this).attr ('data-id');
		var self = $(this);
		
		$.ajax({
			type: "POST",
			url: '/admin/vendors/ajax/addPromMark/'+prom_id,
			dataType: "json",
			data : {map:id}, 
			success : function (res) {

                $('.prom_map').addClass('link_active').html("Edit address <span class=\"plus_icon\"></span>");

				var value = res.data;
				
				$('.marks').append ('<li><a href="#" class="setMap" data-lang="('+value.x+', '+value.y+')">'+value.name+'</a> <a href="#" class="delete_map" data-id="'+value.id+'">delete</a></li>');	
				
				self.remove();
				
				var boundsMap = new google.maps.LatLngBounds();

				var coord = new google.maps.LatLng(value.x, value.y);
					
				boundsMap.extend(coord);
				
				markerMap = new google.maps.Marker({
					map: map_s
				});

				markerMap.setPosition(coord);
				
				//map.fitBounds(boundsMap);
				
			},
			
			error : function (res) {
			
				alert(1);
			
			}
			
		});
		
		
		return false;
	
	});
	
	$(document).on ('click', '.delete_map', function (){
	
		var self = $(this);
		
		var id = self.attr ('data-id');
		if (typeof id != 'undefined') {
			$.ajax({
				type: "POST",
				url: '/admin/vendors/ajax/deletePromMap/'+id,
				dataType: "json",
				success : function (res) {
					
					if (res.status == 'success') {
						
						self.parent().remove();

					}else if (res.status == 'fail') {
						
						
					}
				
				},
				
				error : function (res) {
				
					alert(1);
				
				}
				
			});
		}
		
		return false;
	});
});	