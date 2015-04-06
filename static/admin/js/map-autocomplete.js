$(document).ready (function (){
	
	var input = (document.getElementById('address'));
	
	var autocomplete = new google.maps.places.Autocomplete(input);
	
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		
		var loc = autocomplete.getPlace().geometry.location;
		
		var arr = loc.toString().replace(/[\(\)]/g,'').trim().split(',');
		
		$('.geo-x').val(arr[0]);
		$('.geo-y').val(arr[1]);
		
	});
	
});