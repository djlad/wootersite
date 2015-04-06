$(document).ready(function(){
   
	id = $('.admin_vendor_add').attr('data-id');
	sport_id = $('.admin_vendor_add').attr('data-sport-id');
	arr = [];
	check = true;
	
	$('.gallery_u_i').click (function (){
		
		$('.gallery_i_f').click();
	
	});
	
	$('.gallery_u_l').click (function (){
		
		$('.gallery_l_f').click();
	
	});
	
	$('.gallery_u_i_p').click (function (){
		
		$('.gallery_i_f_p').click();
	
	});
	
	$('.gallery_i_f').fileupload({
		url: '/admin/vendors/ajax/addGallery/'+id,
		dataType: 'json',
		done: function (e, data) {

			if (data.result.status == 'success') {
			
				$('.gallery_img_list').append ('<div class="gal_img_item"><img class="select_prom_img" alt="gallery" src="'+data.result.m_src+'"/><span class="del_image_gallery"></span></div>');

				$('#gallery_list').append ('<a class="fancybox-thumb" rel="fancybox-thumb" href="'+data.result.src+'" title=""><img class="gallery_img_item" src="'+data.result.m_src+'" alt="" /></a>');

			} else if (data.result.status == 'error') {
			
				alert(data.result.msg);
			
			}
			
		},
		progressall: function (e, data) {
		 
		},
		error: function () {

		

		}
	});	
	
	$('.gallery_i_f_p').click(function (){
		
		var url = (typeof this_promotion_row.attr('data-id') == 'undefined') ? '/admin/vendors/ajax/addPromImg/'+id+'/'+sport_id : '/admin/vendors/ajax/updatePromImg/'+this_promotion_row.attr('data-id');
		
		$('.gallery_i_f_p').fileupload({	// promotion image
			url: url,
			dataType: 'json',
			done: function (e, data) {

				if (data.result.status == 'success') {
					
					if (typeof data.result.id  != "undefined") {
						
						$(this_promotion_row).attr('data-id', data.result.id);
					
					}
					
					$(this_promotion_row).find('.adm_vendor_promotion_img').slideUp ("slow", function() {
						
						$(this_promotion_row).find('.adm_vendor_promotion_img').empty().append ('<img src="'+data.result.src+'" alt="">').slideDown("slow", function() {
							
							$('#s_image').modal('hide')
							
						});
						
					});
				
				} else if (data.result.status == 'error') {
				
					alert(data.result.msg);
				
				}
				
			},
			progressall: function (e, data) {
			 
			},
			error: function () {

			

			}
		});	
	});
	$('.gallery_l_f').fileupload({
		url: '/admin/vendors/ajax/addLogo/'+id,
		dataType: 'json',
		done: function (e, data) {

			if (data.result.status == 'success') {
				
				$('.img_logo').parent().remove();
				
				$('.gallery_img_list').prepend ('<div class="gal_img_item"><img class="img-rounded img_logo" alt="gallery" src="'+data.result.src+'"/><span class="del_image_gallery"></span></div>');
				
				$('.logo_block').prepend ('<a class="fancybox-thumb" rel="fancybox-thumb" href="'+data.result.src+'" title=""><img class="gallery_img_item img_logo" src="'+data.result.src+'" alt="" /></a>');
			
			} else if (data.result.status == 'error') {
			
				alert(data.result.msg);
			
			}
			
		},
		progressall: function (e, data) {
		 
		},
		error: function () {

		

		}
	});
	
	$(document).on("click", '.del_image_gallery', function () {
	
		var self = $(this).parent().find('img');
		var parent = $(this).parent();
		var src = self.attr ('src');
		var data = {'src':src}
		if (self.hasClass('img_logo'))
			data['logo'] = true;
		
		$.ajax({
			type: "POST",
			url: '/admin/vendors/ajax/deleteGallery/'+id,
			dataType: "json",
			data : data, 
			success : function (res) {
				
				if (res.status == "success"){
				
					self.remove();
					parent.remove();
					
					$("#gallery_list").change();
					
					$.each ($('img'), function (i, v){
						
						if ( $.trim($(v).attr('src')) ==  $.trim(src)) {
							
							if (!$(v).hasClass('prev_prom_img'))
								$(v).parent().remove();
							
						}
						
					});

					
				}
			
			},
			
			error : function (res) {
			
				//alert(1);
			
			}
		});
	
	});
	
	$('.choose_sport_input').keyup(function () {
	
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
							
						str += '<li><a href="/admin/vendors/company/'+id+'/'+v.id+'">'+v.name+'</a></li>';
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
			
				//alert(1);
			
			}
		});
	
	});
   
	$(document).on ("click", '.a_v_a_select_image', function (){

		this_promotion_row = $(this).parent().parent();
		
	});

	$(document).on ("click", '.select_prom_img', function (){

		var src = $(this).attr('src');
		
		if (typeof this_promotion_row.attr('data-id') != 'undefined'){
		
			var data = {src : src, prom_id :  this_promotion_row.attr('data-id')};
		
		} else {
		
			var data = {src : src, id : id, sport_id : sport_id};
		
		}
		
		$.ajax({
			type: "POST",
			url: '/admin/vendors/ajax/setPromImgFromGalerry',
			dataType: "json",
			data : data, 
			success : function (res) {
				
				if (res.status == 'success'){
					
					if (typeof res.id != "undefined") {
					
						$(this_promotion_row).attr('data-id', res.id);
					
					}
					
					$(this_promotion_row).find('.adm_vendor_promotion_img').slideUp ("slow", function() {
						
						$(this_promotion_row).find('.adm_vendor_promotion_img').empty().append ('<img src="'+res.src+'" alt="">').slideDown("slow", function() {
							
							$('#s_image').modal('hide');
							
						});
						
					});
					
				}
				
			},
			error : function (res) {
			
				//alert(1);
			
			}
		});

	});

	$(document).on('click', '.full_desc', function () {
		
		var self = $(this);
		prom_id = self.parents('.prom_id').attr('data-id');
		prom_row = self.parents('.prom_id');
		
		if (typeof prom_id != "undefined") {
		
			$.ajax({
				type: "POST",
				url: '/admin/vendors/ajax/getPromInfo/'+prom_id,
				dataType: "json",
				data : {key : 'f_desc'}, 
				success : function (res) {
					if (res.status == 'success') {
                        var data = res.res;
                        if (data.edit == 'false'){
                            $('.text_full_desc').empty().val();

                        } else {
                            $('.text_full_desc').empty().val(data.data);
                            $('.text_full_desc').data("wysihtml5").editor.setValue(data.data);
                        }
					}
				},
				error : function (res) {}
			});
		
		} else {
		
			$('.success').empty();
			$('.text_full_desc').val('');
		
		}

	});
	
	$(document).on('click', '.save_prom_f_desc', function (){
		
		if (typeof prom_id != 'undefined') {
			
			var text = $('.text_full_desc').val();
			
			$.ajax({
				type: "POST",
				url: '/admin/vendors/ajax/editPromoInfo/'+prom_id,
				dataType: "json",
				data : {value : text, name : 'f_desc'}, 
				success : function (res) {
					
					if (res.status == 'success') {
						
						setTimeout(function (){
						
							$('.success').empty();
							$('#full_description').modal('hide')
						
						}, 1000);
                        $('.promotion_'+prom_id+' .full_desc').html("Edit Full Description <span class='plus_icon'></span>").addClass("link_active");
					}
				
				},
				
				error : function (res) {
				
					//alert(1);
				
				}
			});
		
		} else {
		
			var text = $('.text_full_desc').val();
			
			$.ajax({
				type: "POST",
				url: '/admin/vendors/ajax/addPromInfo/'+id+'/'+sport_id,
				dataType: "json",
				data : {value : text, name : 'f_desc'}, 
				success : function (res) {
					
					if (res.status == 'success') {
					
						$('.success').append("SEVED");
						
						setTimeout(function (){
							
							$(prom_row).attr ('data-id', res.id);
							$('.success').empty();
							$('#full_description').modal('hide')
						
						}, 1000);
					
					}
				
				},
				
				error : function (res) {
				
					//alert(1);
				
				}
			});
	
		}
	
	});
	
	$(document).on('click', '.prom_add_price', function (){
	
		var self = $(this);
		
		prom_id = self.parents('.prom_id').attr('data-id');
		prom_row = self.parents('.prom_id');
		
		$('.price-body > form').empty();
		
		if (typeof prom_id == 'undefined') {
		
			$('.prom_b_price').css('display','none');
			$('.label-danger').removeClass ('hide');
			
			for (var i = 0; i < 5; i++) {

				$('.price-body > form').prepend('<div class="row"><div class="col-sm-12"><input type="text" placeholder="price description" name="price['+(i+1)+'][name]" class="price_name_i"/><input type="text" name="price['+(i+1)+'][old_price]" placeholder="old price" class="price_val_i"/><input type="text" name="price['+(i+1)+'][new_price]" placeholder="new price" class="price_val_i"/></div></div>');
			
			}
		
		} else {
		
			$('.prom_b_price').css('display','block');
			if (!$('.label-danger').hasClass('hide')) {
			
				$('.label-danger').addClass ('hide');
			
			}
			
			$.ajax({
				type: "POST",
				url: '/admin/vendors/ajax/getPromPrice/'+prom_id,
				dataType: "json",
				success : function (res) {
					
					if (res.status == 'success') {
					
						var count = res.data.length;
						
						for (var i = 0; i < 5 - count; i++) {

							$('.price-body > form').prepend('<div class="row"><div class="col-sm-12"><input type="text" placeholder="price description" name="price['+(i+1)+'][name]" class="price_name_i"/><input type="text" name="price['+(i+1)+'][old_price]" placeholder="old price" class="price_val_i"/><input type="text" name="price['+(i+1)+'][new_price]" placeholder="new price" class="price_val_i"/></div></div>');
						
						}
						
						$.each (res.data, function (index, value) {
							
							$('.price-body > form').prepend('<div class="row"><div class="col-sm-12"><input type="text" value="'+value.name+'" placeholder="price description" name="price['+(i+1)+'][name]" class="price_name_i" /><input type="text" name="price['+(i+1)+'][old_price]" value="'+value.old_price+'" placeholder="old price" class="price_val_i"/><input type="text" name="price['+(i+1)+'][new_price]" value="'+value.new_price+'" placeholder="new price" class="price_val_i"/></div></div>');
							
							i++;
							
						});
						
					}else if (res.status == 'fail') {
						
						for (var i = 0; i < 5; i++) {

							$('.price-body > form').prepend('<div class="row"><div class="col-sm-12"><input type="text" placeholder="price description" name="price['+(i+1)+'][name]" class="price_name_i" /><input type="text" name="price['+(i+1)+'][old_price]" placeholder="old price" class="price_val_i"/><input type="text" name="price['+(i+1)+'][new_price]" placeholder="new price" class="price_val_i"/></div></div>');
						
						}
					}
				
				},
				
				error : function (res) {
				
					//alert(1);
				
				}
				
			});
		
		}
	
	});
	
	$(document).on('click', '.prom_b_price', function () {
	
		data = $('.price-body > form').serialize();
		
		$.ajax({
			type: "POST",
			url: '/admin/vendors/ajax/addPrice/'+prom_id,
			dataType: "json",
			data : data, 
			success : function (res) {
				
				if (res.status == 'success') {
					
					var price_block = prom_row.find('.price_block_body');
					
					price_block.empty();
					
					$.each(res.data, function (index, value){
					
						price_block.append('<div class="row" data-id="'+value.id+'"><div class="col-sm-7 price_name">'+value.name+'</div><div class="col-sm-5 price_value">$ '+value.new_price+'<span class="price_delete"></span></div></div>')
					
					});
					
					$('#add_price').modal('hide');
				
				}
			
			},
			
			error : function (res) {
			
				//alert(1);
			
			}
		});
	
	});
	
	$(document).on('click', '.edit_prom_info, .add_category_p', function (){
		var self = $(this);
		
		prom_id = self.parents('.prom_id').attr('data-id');
		prom_row = self.parents('.prom_id');
		
		$.ajax({ 
			type: "POST",
			url: '/admin/vendors/ajax/getPromInfo/'+prom_id,
			dataType: "json",
			success : function (res) {
				
				if (res.status == 'success') {
					
					var data = res.res;
				
					/*---Ages Start---*/
					var min = data.age_min !=0 ? data.age_min : 1;
					var max = data.age_max !=0 ? data.age_max : 99;
					
					$('.age_min').html (min);
					$('.age_max').html (max);
					
					$( ".slider-range" ).slider({
						range: true,
						min: 1,
						max: 99,
						values: [min, max],
						slide: function( event, ui ) {

							if (ui.values[ 0 ] == ui.values[ 1 ])
								return false;
							
							$('.age_min').html (ui.values[ 0 ]);
							$('.age_max').html (ui.values[ 1 ]);
						},
						stop: function (event, ui) {
						
							$.ajax({ //Save Ages
								type: "POST",
								url: '/admin/vendors/ajax/editPromAges/'+prom_id,
								dataType: "json",
								data: {min : ui.values[ 0 ], max : ui.values[ 1 ]},
								
								success : function (res) {
								
									if (res.status == 'success') {
									
										prom_row.find('.age_val_min').empty().html(ui.values[ 0 ]);
										prom_row.find('.age_val_max').empty().html(ui.values[ 1 ]);

									
									}
								
								}
								
							});
						
						}
						
					});
					
					/*---Ages End---*/
					
					/*---Cat Start---*/
					
					$('.cat').prop ('checked', false);
					
					if (res.res.category.length > 0) {

						$.each (res.res.category, function (index, value){
							
							if ($('.cat').hasClass(value.value)) {
							
								$('.'+value.value).prop('checked', true);
								
							}
						
						});
					
					}
					
					/*---Cat End---*/
					
					/*---Gender Start---*/
					$('.prom_gender option[value="0"]').prop('selected', true);
					
					if (data.gender.length > 0) {
				
						$('.prom_gender option[value="'+data.gender+'"]').prop ('selected', true);
						$('.prom_gender option[value="0"]').hide();
					}

					/*---Gender End---*/
					
					/*---Day Slider Start---*/
						
					var schedule = data.schedule;
					
					var day = new Array();
					
					day['monday'] 		= {'min' : 0, 'max' : 1440};
					day['tuesday'] 		= {'min' : 0, 'max' : 1440};
					day['wednesday']	= {'min' : 0, 'max' : 1440};
					day['thursday'] 	= {'min' : 0, 'max' : 1440};
					day['friday']		= {'min' : 0, 'max' : 1440};
					day['saturday'] 	= {'min' : 0, 'max' : 1440};
					day['sunday'] 		= {'min' : 0, 'max' : 1440};
					
					$('.days').prop("checked", false);
					arr = [];
					
					if (schedule.length > 0) {
					
						$.each (schedule, function (index, value){
						
							day[value.day] = {'max' : value.time_max, 'min' : value.time_min};
						
						});
					
					}	
					
					for (var index in day){
					
						$('.schedule_list .'+index+' .time_min').html(getTime(day[index].min));
						$('.schedule_list .'+index+' .time_max').html(getTime(day[index].max));
						
						//prom_row.find ('.'+index+' .arrow_box').html('<span class="time_min">'+getTime(day[index].min)+'</span> - <span class="time_max">'+getTime(day[index].max)+'</span>');
						
						$( ".slider-range-"+index ).slider({
						range: true,
						min: 0,
						max: 1440,
						step:30,
						values: [day[index].min, day[index].max],
						slide: 
							function( event, ui ) {
								var min = getTime(ui.values[ 0 ]);
								var max = getTime(ui.values[ 1 ]);
								
								$(this).parent().find('.time_min').html(min);
								$(this).parent().find('.time_max').html(max);
								
								switch (true) {
								
									case ui.values[ 0 ] == 0 && ui.values[ 1 ] == 1440 :
										prom_row.find ('.'+$(this).parent().attr('class')+' .arrow_box').html('open all day ');
									break
									
									case ui.values[ 0 ] == 0 && ui.values[ 1 ] == 0 :
										prom_row.find ('.'+$(this).parent().attr('class')+' .arrow_box').html('closed');
									break
									
									default :
										prom_row.find ('.'+$(this).parent().attr('class')+' .arrow_box').html('<span class="time_min">'+min+'</span> - <span class="time_max">'+max+'</span>');
								
								}

								if ( arr.indexOf( $(this).parent().attr('class') ) >= 0 ) {
									
									$.each (arr, function (i, value){
									
										$('.slider-range-'+value).slider ({
										values : [ui.values[ 0 ], ui.values[ 1 ]],
										change : 
											function ( event, ui ){
												
												var min = getTime(ui.values[ 0 ]);
												var max = getTime(ui.values[ 1 ]);
												
												$(this).parent().find('.time_min').html(min);
												$(this).parent().find('.time_max').html(max);
												
												switch (true) {	
													case ui.values[ 0 ] == 0 && ui.values[ 1 ] == 1440 :
														prom_row.find ('.'+value+' .arrow_box').html('open all day ');
													break
													
													case ui.values[ 0 ] == 0 && ui.values[ 1 ] == 0 :
														prom_row.find ('.'+value+' .arrow_box').html('closed');
													break
													
													default :
														prom_row.find ('.'+value+' .arrow_box').html('<span class="time_min">'+min+'</span> - <span class="time_max">'+max+'</span>');
													
												}
											}
										});
									
									});
								
								}

							},
						stop: 
							function (event, ui) {
								$.ajax({ //Save time this day
									type: "POST",
									url: '/admin/vendors/ajax/editDay/'+prom_id,
									dataType: "json",
									data: {day : (arr.indexOf( $(this).parent().attr('class') ) >= 0 ? arr : $(this).parent().attr('class')), min : ui.values[ 0 ], max : ui.values[ 1 ]},
                                    asunc : false,
									done : function (res) {



									}
									
								});
                                $(prom_row).find('.edit_prom_info').addClass('link_active').html('Edit Schedule <span class="plus_icon"></span>');
							}
						});
					
					}

					/*---Day Slider End---*/
				}
			
			},
			
			error : function (res) {
			
				//alert(1);
			
			}
		});
	
	});
	
	$(document).on('click', '.cat', function (){
	
		var status 	= ($(this).prop("checked") ? 'add' : 'delete');
		var value 		= $(this).val();
		
		$.ajax({
			type: "POST",
			url: '/admin/vendors/ajax/editPromCat/'+prom_id,
			dataType: "json",
			data : {status : status, value : value}, 
			success : function (res) {

                $(".promotion_"+prom_id+" .add_category_p").addClass("link_active").html('Edit Category <span class="plus_icon"></span>');

				var list = prom_row.find('.list_scat_prom');
				list.empty();
				
				if (res.status != 'success') {
				
					return false;
				
				} else {
					
					if ( res.data.length > 0 ) {
					
						$.each (res.data, function (index, value) {
						
							list.append ('<span>'+value.value+'</span>');
						
						});
					
					}
				
				}
			
			},
			
			error : function (res) {
			
				//alert(1);
			
			}
		});
		
	
	});
	
	$(document).on('change', '.days', function (){
		
		var day = $(this).parent().attr('class');
		
		if ($(this).prop('checked')) {
		
			arr.push(day);
		
		} else {
		
			arr.splice(arr.indexOf(day));
		
		}
		
	});
	
	$(document).on('click', '.prom_golden', function (){
					
		var status = $(this).prop('checked');
		
		$.ajax({ //Save Golden
			type: "POST",
			url: '/admin/vendors/ajax/editPromGolden/'+id,
			dataType: "json",
			data: {status : status},
			success : function (res) {
			
				if (res.status == 'success') {
				
					
				
				}
			
			}
			
		});
	
	});
	
	$(document).on ('change', '.prom_gender', function (){
					
		var val = $(this).val();
		
		prom_id = $(this).parents('.prom_id').attr('data-id');
		
		$.ajax({ //Save Gender
			type: "POST",
			url: '/admin/vendors/ajax/editPromGender/'+prom_id,
			dataType: "json",
			data: {val : val},
			success : function (res) {
			
				if (res.status == 'success') {
				
					
				
				}
			
			}
			
		});
	 
	});
	
	$(document). on ('click', '.add_prom_block', function (){
		
		var sport_id = $('.admin_vendor_add').attr('data-sport-id');
		
		$.ajax({
			type: "POST",
			async : false,
			url: '/admin/vendors/ajax/addPromotion',
			dataType: "json",
			data : {sport_id : sport_id, id : id},
			success : function (res) {
			
				if (res.status == 'success'){
					 
					$('#big_promotion_list').append('<div class="row big_promotion promotion_'+res.info.id+' prom_id" data-id="'+res.info.id+'"><div class="prom_container"><div class="col-sm-4 promotion_slider"><div class="prom_slider_block"><img src="/static/admin/img/upload_img.png" class="prev_prom_img def_img"><div class="list_scat_prom"></div><a href="#" class="prom_img" data-toggle="modal" data-target="#prom_gallery" data-backdrop="static">Add Images</a></div><div class="promotion_image_list"></div></div><div class="col-sm-8"><div class="big_promotion_wrap"><div class="big_promotion_header"><div class="big_promotion_name"><div title="Click to edit..." class="i-edit-dinamic"><h2 class="edit_text">Promotion name</h2><span class="edit_label" data-url="/admin/vendors/ajax/editPromoInfo/" data-name="name"></span></div></div><div class="gender_block"><span>For</span><select class="prom_gender"><option value="0">Gender...</option><option value="all" selected="">Co-Ed</option><option value="male">Male</option><option value="female">Female</option></select></div><div class="edit_age_block"><span>Ages</span><div class="min_age_edit"><div title="Click to edit..." class="i-edit-dinamic"><input class="prom_age_min" value="1"></div></div><span>to</span><div class="max_age_edit"><div title="Click to edit..." class="i-edit-dinamic"><input class="prom_age_max" value="99"></div></div></div>   </div><div class="clear"></div><div class="big_promotion_content"><div class="promotion_describe"><div title="Click to edit..." class="t-edit-dinamic"><div class="edit_text active_edit">Describe your promotion.Input as much information as you can to answer any of the customer\'s questions.</div><span class="edit_textarea_prom edit_textarea" data-name="s_desc" data-url="/admin/vendors/ajax/editPromoInfo/"></span></div></div><div class="row prom_button_block"><div class="col-md-12"><nav class="skew-menu"><ul><li><a href="#" class="add_button_v_a full_desc" data-toggle="modal" data-target="#full_description" data-backdrop="static">Add Full Description <span class="plus_icon"></span></a></li><li><a href="#" class="add_button_v_a prom_map" data-toggle="modal" data-target="#add_address" data-backdrop="static">Select Address <span class="plus_icon"></span></a></li><li><a href="#" class="add_button_v_a edit_prom_info" data-toggle="modal" data-target="#edit_prom_info" data-backdrop="static">Select Schedule<span class="plus_icon"></span></a></li><li><a href="#" class="add_category_p" data-toggle="modal" data-target="#sub_category_modal">edit category <span class="plus_icon"></span></a></li></ul></nav></div></div><a data-original-title="Add promo price" href="#" onclick="return false" class="add_price_button" data-toggle="popover" title="" data-content=\'<button type="button" class="close"><span aria-hidden="true">×</span></button><form action="" method="POST" class="add_price_form"><div class="form_item"><label>Standard Price</label><span class="dollar_label">$</span><input type="text" class="standart_price" name="standart_price" placeholder="0"></div><div class="form_item"><label>Discount (Optional)</label><span class="discount_label">%</span><input type="text" class="discount_perc" placeholder="0" name="discount_perc" maxlength="3"></div><hr/><div class="form_item"><label class="final_label"> Final Price $ <input type="text" placeholder="0" class="final_price" name="final_price" readonly></label></div><hr/><div class="form_item"><textarea name="description_price" placeholder="Describe what is being sold." class="description_price"></textarea></div><button name="send" type="button">Publish Price</button></form>\'><span>Add Promo price</span> <span class="plus_icon"></span></a><div class="slider_p"><a data-jcarouselcontrol="true" class="left_arror_p left_arror_p'+res.info.id+'">1</a><div data-jcarousel="true" class="prom_price_slider prom_price_slider'+res.info.id+'"><div style="left: 0px; top: 0px;" class="price_slider_inner"></div></div><a data-jcarouselcontrol="true" class="right_arror_p right_arror_p'+res.info.id+'">1</a></div></div></div><div class="right_schedule"><a href="#" class="delete_prom"></a><div class="schedule_block"><ul><li class="sunday"><span class="arrow_box">open all day</span>Sun</li><li class="monday"><span class="arrow_box">open all day</span>Mon</li><li class="tuesday"><span class="arrow_box">open all day</span>Tue</li><li class="wednesday"><span class="arrow_box">open all day</span>Wed</li><li class="thursday"><span class="arrow_box">open all day</span>Thu</li><li class="friday"><span class="arrow_box">open all day</span>Fri</li><li class="saturday"><span class="arrow_box">open all day</span>Sat</li></ul></div></div></div></div></div>');

                    $('.prom_price_slider' + res.info.id).jcarousel({
                        wrap: 'circular'
                    });
                    $('.left_arror_p' + res.info.id)
                        .jcarouselControl({
                            target: '-=1'
                        });

                    $('.right_arror_p' + res.info.id)
                        .jcarouselControl({
                            target: '+=1'
                        });

                    $('[data-toggle="popover"]').popover({
                        html: true
                    });

                    $('[data-toggle="popover"]').on('shown.bs.popover', function () {

                        $('.add_price_form input[type=text]').keyup(function() {

                            discout = $('.discount_perc');
                            final = $('.final_price');
                            standart = $('.standart_price');
                            self = $(this);

                            if(discout.val() == "0" || discout.val() == ""){
                                final.val(standart.val());
                            }
                            else{
                                price = standart.val() - (standart.val()/100*discout.val());
                                final.val(price);
                            }
                            if(parseInt(discout.val())>100){
                                return false;
                            }
                            if(standart.val().length && (discout.val().length || final.val().length)){

                                if($(this).attr('class') == "discount_perc"){
                                    price = standart.val() - (standart.val()/100*discout.val());
                                    final.val(price);
                                }
                                if($(this).attr('class') == "final_price"){
                                    price = standart.val() - (final.val()/100*standart.val());
                                    discout.val(price);
                                }

                            }



                        });

                    });

				$('.i-edit-dinamic').editable('', 
					{
						tooltip   : 'Click to edit...',
						placeholder : '',
						default : {
							name : 'Promotion name'
						}
					}, function (t) {
						
						var data = $(t).find('input').val();
						var url = $(t).find('span').attr('data-url');
						var name = $(t).find('span').attr('data-name');
						var prom_id = $(t).parents('.prom_id').attr('data-id');
						
						if (typeof url == 'undefined')
							return;
						
						return {
							ajaxoptions : {
								url : url+prom_id, 
								data : {
									name : name, 
									value : data
								},
								success : function (res) {
									
									if (typeof res.text == 'undefined'){
										
										var text = data;
										
									} else {
										
										var text = res.text;
										
									}
									
									$(t).find('.edit_text').empty().append(text);
									
									if (res.status == 'success') {
										
										$(t).find('span').removeClass('save_label').addClass('ok_label');
										
									} else {
										
										$(t).find('span').removeClass('save_label');
										
									}

								}
							},
							name : name
						};
						
					}
					
				);
				
				$('.t-edit-dinamic').editable('', 
					{
						type      : 'textarea',
						tooltip   : 'Click to edit...',
						placeholder : '',
						default : {
							s_desc : 'Describe your promotion.Input as much information as you can to answer any of the customer\'s questions.'	 
						}
					},
					function (t){
						
						var data = $(t).find('textarea').val();
						var url = $(t).find('span').attr('data-url');
						var name = $(t).find('span').attr('data-name');
						var prom_id = $(t).parents('.prom_id').attr('data-id');
						
						if (typeof url == 'undefined')
							return;
						
						return {
							ajaxoptions : {
								url : url+prom_id, 
								data : {
									name : name, 
									value : data
								},
								success : function (res) {
									
									if (typeof res.text == 'undefined'){
										
										var text = data;
										
									} else {
										
										var text = res.text;
										
									}
									
									$(t).find('.edit_text').empty().append(text);
									
									if (res.status == 'success') {
										
										$(t).find('span').removeClass('save_label').addClass('ok_label');
										
									} else {
										
										$(t).find('span').removeClass('save_label');
										
									}

								}
							},
							name : name
						};
						
					}
				);
				
				$('.i-edit-price').editable('', 
					{
						tooltip   : 'Click to edit...',
						placeholder : '',
						default : {}
					},
					function (t){
						
						var data = $(t).find('input').val();
						var url = $(t).find('span').attr('data-url');
						var name = $(t).find('span').attr('data-name');
						var prom_id = $(t).parents('.prom_id').attr('data-id');
						var price_id = $(t).parents('.item_price').attr('data-id');
						
						if (typeof url == 'undefined')
							return;
						
						return {
							ajaxoptions : {
								url : url, 
								data : {
									name : name, 
									value : data,
									id : (typeof price_id == "undefined" ? prom_id : price_id),
									act : (typeof price_id == "undefined" ? 'add' : 'edit')
								},
								success : function (res) {
									
									if (typeof res.text == 'undefined'){
										
										var text = data;
										
									} else {
										
										var text = res.text;
										
									}
									
									$(t).find('.edit_text').empty().append(text);
									
									if (res.status == 'success') {
										
										$(t).find('span').removeClass('save_label').addClass('ok_label');
										
									} else {
										
										$(t).find('span').removeClass('save_label');
										
									}

								}
							},
							name : name
						};
						
					}
				);
				
				$('.i-edit-discount').editable('',
					{
						tooltip   : 'Click to edit...',
						placeholder : '',
						default : {}
					},
					function (t){

						var data = $(t).find('input').val();
						var url = $(t).find('span').attr('data-url');
						var name = $(t).find('span').attr('data-name');
						var prom_id = $(t).parents('.prom_id').attr('data-id');
						var price_id = $(t).parents('.item_price').attr('data-id');

						if (typeof url == 'undefined')
							return;

						return {
							ajaxoptions : {
								url : url,
								data : {
									name : name,
									value : data,
									id : (typeof price_id == "undefined" ? prom_id : price_id),
									act : (typeof price_id == "undefined" ? 'add' : 'edit')
								},
								success : function (res) {

									if (typeof res.text == 'undefined'){

										var text = data;

									} else {

										var text = res.text;

									}

									$(t).find('.edit_text').empty().append(text);

									if (res.status == 'success') {

										$(t).find('span').removeClass('save_label').addClass('ok_label');
										
										var n = $(t).parents('.item_price').find('.new_price_val');
										var val = $(t).parents('.item_price').find('.old_price_val').html();
										$(n).html(val - (val*(data/100)));

									} else {

										$(t).find('span').removeClass('save_label');

									}

									analize();

								}
							},
							name : name
						};

					}
				);
				
				$('.t-edit-price').editable('', 
					{	
						type : 'textarea',
						tooltip   : 'Click to edit...',
						placeholder : '',
						default : {}
					},
					function (t){
						
						var data = $(t).find('textarea').val();
						var url = $(t).find('span').attr('data-url');
						var name = $(t).find('span').attr('data-name');
						var prom_id = $(t).parents('.prom_id').attr('data-id');
						var price_id = $(t).parents('.item_price').attr('data-id');
						
						if (typeof url == 'undefined')
							return;
						
						return {
							ajaxoptions : {
								url : url, 
								data : {
									name : name, 
									value : data,
									id : (typeof price_id == "undefined" ? prom_id : price_id),
									act : (typeof price_id == "undefined" ? 'add' : 'edit')
								},
								success : function (res) {
									
									if (typeof res.text == 'undefined'){
										
										var text = data;
										
									} else {
										
										var text = res.text;
										
									}
									
									$(t).find('.edit_text').empty().append(text);
									
									if (res.status == 'success') {
										
										$(t).find('span').removeClass('save_label').addClass('ok_label');
										
									} else {
										
										$(t).find('span').removeClass('save_label');
										
									}

								}
							},
							name : name
						};
						
					}
				);
				
				
				}
				
				
				
			
			}
			
		});
		
		return false;
	});
	
	$(document).on ('click', '.price_delete', function (){
	
		var self = $(this);
		var price_parent = self.parent().parent();
		var price_id = price_parent.attr('data-id');
		
		$.ajax({ 
			type: "POST",
			url: '/admin/vendors/ajax/deletePrice',
			dataType: "json",
			data: {id : price_id},
			success : function (res) {
				if (res.status == 'success') {
					price_parent.slideUp ('fast', function (){
						price_parent.remove();					
					});				
				}
			}
		});
		
		return false;
		
	});
	
	$(document).on ('click', '.close-day', function (){
	
		var self = $(this);
		var parent = self.parent();
		var day = parent.attr('class');

		$('.slider-range-'+day).slider({
			values: [0, 0]
		});
		
		$.ajax({ //Save time this day
			type: "POST",
			url: '/admin/vendors/ajax/editDay/'+prom_id,
			dataType: "json",
			data: {day : day, min : 0, max : 0}
		});
		
		parent.find ('.time_min').empty().html("0:00 AM");
		parent.find ('.time_max').empty().html("0:00 AM");
		
		prom_row.find ('.'+day+' .arrow_box').html('closed');
				
		return false;
	
	});
		
	$('.t-edit').editable('/admin/vendors/ajax/editInfo', 
		{
			type      : 'textarea',
			tooltip   : 'Click to edit...',
			placeholder : '',
			default : {
				about : 'Describe your company\'s mission, history or achivments. This is your "pitch" to make your business stand out from the rest.'
			}
		}, 	
		function (t){
			var data = $(t).find('textarea').val();
			var name = $(t).find('span').attr('data-name');
			
			return {
				ajaxoptions : {
					data : {
						name : name, 
						value : data,
						id : id
					},
					success : function (res) {
						
						$(t).find('.edit_text').empty().html(res.text);
						
						if (res.status == 'success') {
							
							$(t).find('span').removeClass('save_label').addClass('ok_label');
							
						} else {
							
							$(t).find('span').removeClass('save_label');
							
						}
	
					}, 
					error : function (e) {
						
						alert(1);
						
					}
				}, 
				name : name
			};
		}
	);

	$('.i-edit').editable('', 
		{
			tooltip   : 'Click to edit...',
			placeholder : '',
			default : {
				name 					: 'Edit Bussines name',
				link 						: 'Company Link', 
				phone_number	: 'Company phone', 
				c_email 				: 'Company email'
			}
		},
		function (t){
			
			var data = $(t).find('input').val();
			var name = $(t).find('span').attr('data-name');
			var url  = $(t).find('span').attr('data-url'); 
			
			return {
				ajaxoptions : {
					data : {
						name : name, 
						value : data,
						id : id
					},
					url : (typeof url == 'undefined') ? '/admin/vendors/ajax/editInfo' : url,
					success : function (res) {
						
						$(t).find('.edit_text').empty().append(res.text);
						
						if (res.status == 'success') {
							
							$(t).find('span').removeClass('save_label').addClass('ok_label');
							
						} else {
							
							$(t).find('span').removeClass('save_label');
							
						}

					}
				},
				name : name
			};
		}
	);
	$('.i-edit-dinamic').editable('', 
		{
			tooltip   : 'Click to edit...',
			placeholder : '',
			default : {
				name : 'Promotion name'
			}
		}, function (t) {
			
			var data = $(t).find('input').val();
			var url = $(t).find('span').attr('data-url');
			var name = $(t).find('span').attr('data-name');
			var prom_id = $(t).parents('.prom_id').attr('data-id');
			
			if (typeof url == 'undefined')
				return;
			
			return {
				ajaxoptions : {
					url : url+prom_id, 
					data : {
						name : name, 
						value : data
					},
					success : function (res) {
						
						if (typeof res.text == 'undefined'){
							
							var text = data;
							
						} else {
							
							var text = res.text;
							
						}
						
						$(t).find('.edit_text').empty().append(text);
						
						if (res.status == 'success') {
							
							$(t).find('span').removeClass('save_label').addClass('ok_label');
							
						} else {
							
							$(t).find('span').removeClass('save_label');
							
						}

					}
				},
				name : name
			};
			
		}
		
	);
	
	$('.t-edit-dinamic').editable('', 
		{
			type      : 'textarea',
			tooltip   : 'Click to edit...',
			placeholder : '',
			default : {
				s_desc : 'Describe your promotion.Input as much information as you can to answer any of the customer\'s questions.'	
			}
		},
		function (t){
			
			var data = $(t).find('textarea').val();
			var url = $(t).find('span').attr('data-url');
			var name = $(t).find('span').attr('data-name');
			var prom_id = $(t).parents('.prom_id').attr('data-id');
			
			if (typeof url == 'undefined')
				return;
			
			return {
				ajaxoptions : {
					url : url+prom_id, 
					data : {
						name : name, 
						value : data
					},
					success : function (res) {
						
						if (typeof res.text == 'undefined'){
							
							var text = data;
							
						} else {
							
							var text = res.text;
							
						}
						
						$(t).find('.edit_text').empty().append(text);
						
						if (res.status == 'success') {
							
							$(t).find('span').removeClass('save_label').addClass('ok_label');
							
						} else {
							
							$(t).find('span').removeClass('save_label');
							
						}

					}
				},
				name : name
			};
			
		}
	);
	$('.i-edit-discount').editable('',
		{
			tooltip   : 'Click to edit...',
			placeholder : '',
			default : {}
		},
		function (t){

			var data = $(t).find('input').val();
			var url = $(t).find('span').attr('data-url');
			var name = $(t).find('span').attr('data-name');
			var prom_id = $(t).parents('.prom_id').attr('data-id');
			var price_id = $(t).parents('.item_price').attr('data-id');

			if (typeof url == 'undefined')
				return;

			return {
				ajaxoptions : {
					url : url,
					data : {
						name : name,
						value : data,
						id : (typeof price_id == "undefined" ? prom_id : price_id),
						act : (typeof price_id == "undefined" ? 'add' : 'edit')
					},
					success : function (res) {

						if (typeof res.text == 'undefined'){

							var text = data;

						} else {

							var text = res.text;

						}

						$(t).find('.edit_text').empty().append(text);

						if (res.status == 'success') {

							$(t).find('span').removeClass('save_label').addClass('ok_label');
							
							var n = $(t).parents('.item_price').find('.new_price_val');
							var val = parseInt($(t).parents('.item_price').find('.old_price_val').html());
							$(n).html(val - (val*(data/100)));

						} else {

							$(t).find('span').removeClass('save_label');

						}

					}
				},
				name : name
			};

		}
	);
	$('.i-edit-price').editable('', 
		{
			tooltip   : 'Click to edit...',
			placeholder : '',
			default : {}
		},
		function (t){
			
			var data = $(t).find('input').val();
			var url = $(t).find('span').attr('data-url');
			var name = $(t).find('span').attr('data-name');
			var prom_id = $(t).parents('.prom_id').attr('data-id');
			var price_id = $(t).parents('.item_price').attr('data-id');
			
			if (typeof url == 'undefined')
				return;
			
			return {
				ajaxoptions : {
					url : url, 
					data : {
						name : name, 
						value : data,
						id : (typeof price_id == "undefined" ? prom_id : price_id),
						act : (typeof price_id == "undefined" ? 'add' : 'edit')
					},
					success : function (res) {
						
						if (typeof res.text == 'undefined'){
							
							var text = data;
							
						} else {
							
							var text = res.text;
							
						}
						
						$(t).find('.edit_text').empty().append(text);
						
						if (res.status == 'success') {
							
							$(t).find('span').removeClass('save_label').addClass('ok_label');
							
						} else {
							
							$(t).find('span').removeClass('save_label');
							
						}

					}
				},
				name : name
			};
			
		}
	);
	
	$('.t-edit-price').editable('', 
		{	
			type : 'textarea',
			tooltip   : 'Click to edit...',
			placeholder : '',
			default : {}
		},
		function (t){
			
			var data = $(t).find('textarea').val();
			var url = $(t).find('span').attr('data-url');
			var name = $(t).find('span').attr('data-name');
			var prom_id = $(t).parents('.prom_id').attr('data-id');
			var price_id = $(t).parents('.item_price').attr('data-id');
			
			if (typeof url == 'undefined')
				return;
			
			return {
				ajaxoptions : {
					url : url, 
					data : {
						name : name, 
						value : data,
						id : (typeof price_id == "undefined" ? prom_id : price_id),
						act : (typeof price_id == "undefined" ? 'add' : 'edit')
					},
					success : function (res) {
						
						if (typeof res.text == 'undefined'){
							
							var text = data;
							
						} else {
							
							var text = res.text;
							
						}
						
						$(t).find('.edit_text').empty().append(text);
						
						if (res.status == 'success') {
							
							$(t).find('span').removeClass('save_label').addClass('ok_label');
							
						} else {
							
							$(t).find('span').removeClass('save_label');
							
						}

					}
				},
				name : name
			};
			
		}
	);
	
	/** Promotion Gallery**/
	
	$(document). on ('click', '.prom_img', function (){

		prom_row = $(this).parents('.prom_id');
		prom_id = prom_row.attr('data-id');
		var d;
		
		$.ajax ({
			async : false, 
			url : '/admin/vendors/ajax/getPromGallery',
			method : 'POST',
			dataType : 'json',
			data : {id : prom_id},
			success : function (res) {
				
				$('.prom_gallery_img_list').empty();
				
				if (res.status == 'success') {
					
					if (res.data.length > 0) {
						
						$.each(res.data, function (index, value) {
							
							$('.prom_gallery_img_list').append('<div class="gal_img_item"><img src="/uploads/vendors/'+id+'/p_'+value.src+'"><span class="del_image_gallery"></span></div>');

						});
						
					}
					
				}
				
			}
		});
		
		$(document).on ('click', '.prom_add_images', function (){
			
			$('.add_prom_img').click();
			
			$('.add_prom_img').fileupload({
				async : false, 
				dataType: 'json',
				url : '/admin/vendors/ajax/addPromGallery/'+prom_id+'/'+id,
				done: function (e, data) {
					
					var res = data.result;
					
					if (res.status == 'success'){
						
						//$('#prom_gallery').modal('hide');
						
						var slider = prom_row.find('.promotion_image_list');

                        if (slider.find('img').attr('src')== "/static/admin/img/no_image.png"){
                            slider.find('img').attr('src',res.src);
                        }

						$('.gallery_img_list').append ('<div class="gal_img_item"><img class="img" src="'+res.src+'" alt="gallery"/><span class="del_image_gallery"></span></div>');
						$('.prom_gallery_img_list').append ('<div class="gal_img_item"><img class="img" src="'+res.src+'" alt="gallery"/><span class="del_image_gallery"></span></div>');
						
						$('#gallery_list').append('<a class="fancybox-thumb" rel="fancybox-thumb" href="'+res.original+'" title=""><img class="gallery_img_item" src="'+res.src+'" alt="" /></a>');
							
						slider.append ('<a class="fancybox-thum-'+res.id+'" rel="fancybox-thumb-'+res.id+'" href="'+res.original+'" title=""><img src="'+res.src+'"/></a>');
						
						if (d = prom_row.find('.def_img')) {
							
							$(d).attr('src', res.src).removeClass('def_img');
							
						}

					}	
					
				}
			});
			
			return false;
			
		});
		
		$(document).on ('click', '.close-day', function (){
		
			var self = $(this);
			var parent = self.parent();
			var day = parent.attr('class');

			$('.slider-range-'+day).slider({
				values: [0, 0]
			});
			
			$.ajax({ //Save time this day
				type: "POST",
				url: '/admin/vendors/ajax/editDay/'+prom_id,
				dataType: "json",
				data: {day : day, min : 0, max : 0}
			});
			
			parent.find ('.time_min').empty().html("0:00 AM");
			parent.find ('.time_max').empty().html("0:00 AM");
			
			prom_row.find ('.'+day+' .arrow_box').html('closed');
					
			return false;
		
		});
		
	});
	
});
