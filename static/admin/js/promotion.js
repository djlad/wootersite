$(document).ready(function(){

	id = $('.admin_vendor_add').attr('data-id');
	
	$('.choose_sport_input').keyup (function () {
	
		$.ajax({
			type: "POST",
			url: '/admin/vendors/ajax/searchVendorSports/'+id,
			dataType: "json",
			data : {'q':$('.choose_sport_input').val()}, 
			success : function (res) {
				
				if (res.status == "success"){
				
					$('.v_sport_list_add_s').empty();
					var str = '';
					k = 0;
		
					$.each (res.elements, function (count, v){
						
						if(k == 0) 
							str += '<ul>';
							
						str += '<li><a href="/admin/vendors/promotion/'+id+'/'+v.id+'">'+v.name+'</a></li>';
						k++;
						if(k == 15 || count == (res.elements.length -1) )  {
							
							str += '</ul>';
							k = 0;
							
						}
					
					});
					
					$('.v_sport_list_add_s').append(str);
		
				} else if (res.status == "fail") {
				
					$('.v_sport_list_add_s').empty().html("No results");
				
				}
			
			},
			
			error : function (res) {
			
				alert(1);
			
			}
		});
	
	});

});