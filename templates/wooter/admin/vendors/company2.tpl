<div class="admin_vendor_add" data-id="{$id}" {if="isset($sport_id)"}data-sport-id="{$sport_id}"{/if}>
		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active a_v_a_inner_block">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-6 col-md-5 col-lg-5">
							<div class="co_name">
								<h2 class="edit_text">{if="isset($info) && !empty ($info.name)"}{$info.name}{else}Edit Bussines name{/else}</h2>
								<span data-target="/admin/vendors/ajax/editInfo" class="edit_label glyphicon glyphicon-pencil" data-name="name"></span>
							</div>
                            <div class="clear"></div>
                            <input type="checkbox" name="golde_promotion" class="prom_golden" {if="$info.is_golden"} checked {/if}><span>Golden Promotion</span>
							<div class="clear"></div>
							<div class="co_link">
								
								<div class="edit_text">{if="isset($info) && $info.link"}{$info.link}{else}Company Link{/else}</div>
								<span data-target="/admin/vendors/ajax/editInfo" class="edit_label glyphicon glyphicon-pencil" data-name="link"></span>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
							<div class="a_v_a_gallery_block">
								<!--<a href="#" class="a_v_a_add_image" data-toggle="modal" data-target="#gallery" data-backdrop="static"><span class="glyphicon glyphicon-plus"></span>Add Image</a>-->
								<div class="image_list">
									{if="isset($info.image) && ($info.image)"}
									<a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/vendors/{$id}/{$info.image}" title="">
										<img class="gallery_img_item img_logo" src="/uploads/vendors/{$id}/{$info.image}" alt="" />
									</a>
									{/if}
									<span id="gallery_list">
									{foreach="$gallery_prev as $g_item"}
										<a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/vendors/{$id}/{$g_item.src}" title="">
											<img class="gallery_img_item" src="/uploads/vendors/{$id}/{$g_item.src}" alt="" />
										</a>
								    {/foreach}
									</span>
								</div>
								<a href="#" class="a_v_a_add_image" data-toggle="modal" data-target="#gallery" data-backdrop="static"></a>
							</div>
							<div class="co_phone">
								<div class="edit_text">{if="isset($info) && $info.phone_number"}{$info.phone_number}{else}Company phone{/else}</div>
								<span data-target="/admin/vendors/ajax/editInfo" class="edit_label glyphicon glyphicon-pencil" data-name="phone_number"></span>
								<div class="clear"></div>
							</div>
							<div class="co_email">
								<div class="edit_text">{if="isset($info) && $info.c_email"}{$info.c_email}{else}Company email{/else}</div>
								<span data-target="/admin/vendors/ajax/editInfo" class="edit_label glyphicon glyphicon-pencil" data-name="c_email"></span>
								<div class="clear"></div>
							</div>
							
							<div class="desrcibe_block">
								
								<div class="edit_text edit_textare">{if="isset($info) && $info.about"}{$info.about}{else}Describe your company's mission, history or achivments. This is your "pitch" to make your business stand out from the rest.  {/else}</div>
								<span data-target="/admin/vendors/ajax/editInfo" class="edit_textarea glyphicon glyphicon-pencil" data-name="about"></span>
							</div>
						</div>
						<div class="col-xs-6 col-md-7 col-lg-7">
							<div class="map_shadow" id="map_shadow" style="width:100%; height:475px; frameborder:0; border:0;">
								
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 sport_list_block">
							<!-- Button trigger modal -->
							{if="is_array($vendorSport) && count ($vendorSport) > 0"}
								
								{foreach="$vendorSport as $v_sport_item"}
									
									<a href="/admin/vendors/promotion/{$id}/{$v_sport_item.id}" class="vendor_feature_list_link {if="$sport_id == $v_sport_item.id"}active{/if}">{$v_sport_item.name}<span class='delete_sport glyphicon glyphicon-remove-circle'></span></a>
									{if="$sport_id == $v_sport_item.id"}
										{$hasSport = true}
									{/if}
								{/foreach}
		
							{/if}
							
							{if="!$hasSport && $sport_id"}
								<a href="/admin/vendors/promotion/{$id}/{$sportInfo.id}" class="vendor_feature_list_link active">{$sportInfo.name}</a>
							{/if}
							
							<a href="#" data-toggle="modal" data-target="#enter_sport" class="vendor_add_feauture_button"><span class="glyphicon glyphicon-plus"></span> New Feature</a>
						</div>
					</div>
					<div id="promotions_list">
					{if="$promInfo"}
						{foreach="$promInfo as $pron_item"}
							<div class="row promotion promotion_{$pron_item.id}" data-id="{$pron_item.id}">
								<div class="col-md-3">
									<a href="#" class="a_v_a_select_image" data-toggle="modal" data-target="#s_image" data-backdrop="static"><span class="glyphicon glyphicon-plus"></span> Select image</a>
									<a href="javascript:void(0)" class="adm_vendor_promotion_img">
										<img src='{if="$pron_item.img"}/uploads/vendors/{$id}/{$pron_item.img}{else}/static/admin/img/upload_img.png{/else}'/>
										<span class="miles_away"></span>
										<div class="list_scat_prom">
											{foreach="$pron_item.category as $cat_item"}
												<span>{$cat_item.value}</span>
											{/foreach}
										</div>
									</a>
									 
								</div> 
								<div class="col-md-9">
									<div class="row">
										<div class="col-md-8 padding_clear">
											<a href="#" class="delete_prom">Delete promotion <span class="glyphicon glyphicon-remove-circle"></span></a>
											<div class="prom_desc_block">
												<div class="bottom_line">
													<h2 class="edit_text active_edit">{if="$pron_item.name"}{$pron_item.name}{else}Promotion Name{/else}</h2>
													<span class="edit_label_prom glyphicon glyphicon-pencil" data-name="name"></span>
													<div class="age_block">Age: <span class="age_val_min">{$pron_item.age_min}</span> to <span class="age_val_max">{$pron_item.age_max}</span></div>
												</div>
												<div class="clear"></div>
												<div class="promotion_describe">
													<div class="edit_text active_edit">
														{if="$pron_item.s_desc"}{$pron_item.s_desc}{else}Describe your promotion.
														Input as much information as you can to answer any of the customer’s questions.{/else}
													</div>
													<span class="edit_textarea_prom glyphicon glyphicon-pencil" data-name="s_desc"></span>
												</div>
												<div class="row prom_button_block">
													<div class="col-md-12">
														<a href="#" class="add_button_v_a full_desc button" data-toggle="modal" data-target="#full_description" data-backdrop="static"><span class="glyphicon glyphicon-plus"></span> Add Full Description</a>
														<a href="#" class="add_button_v_a prom_map button" data-toggle="modal" data-target="#add_address" data-backdrop="static"><span class="glyphicon glyphicon-plus"></span> Select Address</a>
														<a href="#" class="add_button_v_a edit_prom_info button" data-toggle="modal" data-target="#edit_prom_info" data-backdrop="static"><span class="glyphicon glyphicon-plus"></span> Edit Promotion Info</a>
													</div>
												</div>
											</div>
											<div class="schedule_block">
												<ul>
													<li class="sunday">
														<span class="arrow_box">
															{if="isset ($pron_item.schedule.sunday)"}
																{if="$pron_item.schedule.sunday.time_min == 0 && $pron_item.schedule.sunday.time_max == 1440"} 
																	open all day  
																{elseif="$pron_item.schedule.sunday.time_min == 0 && $pron_item.schedule.sunday.time_max == 0"}
																	closed
																{else}
																<span class="time_min">{$adminObj -> convertTime ($pron_item.schedule.sunday.time_min)}</span> - <span class="time_max">{$adminObj -> convertTime ($pron_item.schedule.sunday.time_max)}</span>
																{/else}
															{else}
																open all day 
															{/else}
														</span>
														Sun
													</li>
													<li class="monday">
														<span class="arrow_box">
															{if="isset ($pron_item.schedule.monday)"}
																{if="$pron_item.schedule.monday.time_min == 0 && $pron_item.schedule.monday.time_max == 1440"} 
																	open all day 
																{elseif="$pron_item.schedule.monday.time_min == 0 && $pron_item.schedule.monday.time_max == 0"}
																	closed
																{else}
																<span class="time_min">{$adminObj -> convertTime ($pron_item.schedule.monday.time_min)}</span> - <span class="time_max">{$adminObj -> convertTime ($pron_item.schedule.monday.time_max)}</span>
																{/else}
															{else}
																open all day 
															{/else}
														</span>
														Mon
													</li>
													<li class="tuesday">
														<span class="arrow_box">
															{if="isset ($pron_item.schedule.tuesday)"}
																{if="$pron_item.schedule.tuesday.time_min == 0 && $pron_item.schedule.tuesday.time_max == 1440"} 
																	open all day 
																{elseif="$pron_item.schedule.tuesday.time_min == 0 && $pron_item.schedule.tuesday.time_max == 0"}
																	closed
																{else}
																<span class="time_min">{$adminObj -> convertTime ($pron_item.schedule.tuesday.time_min)}</span> - <span class="time_max">{$adminObj -> convertTime ($pron_item.schedule.tuesday.time_max)}</span>
																{/else}
															{else}
																open all day 
															{/else} 
														</span>
														Tue
													</li>
													<li class="wednesday">
														<span class="arrow_box">
															{if="isset ($pron_item.schedule.wednesday)"}
																{if="$pron_item.schedule.wednesday.time_min == 0 && $pron_item.schedule.wednesday.time_max == 1440"} 
																	open all day 
																{elseif="$pron_item.schedule.wednesday.time_min == 0 && $pron_item.schedule.wednesday.time_max == 0"}
																	closed
																{else}
																<span class="time_min">{$adminObj -> convertTime ($pron_item.schedule.wednesday.time_min)}</span> - <span class="time_max">{$adminObj -> convertTime ($pron_item.schedule.wednesday.time_max)}</span>
																{/else}
															{else}
																open all day 
															{/else}
														</span>
														Wed
													</li>
													<li class="thursday">
														<span class="arrow_box">
															{if="isset ($pron_item.schedule.thursday)"}
																{if="$pron_item.schedule.thursday.time_min == 0 && $pron_item.schedule.thursday.time_max == 1440"} 
																	open all day 
																{elseif="$pron_item.schedule.thursday.time_min == 0 && $pron_item.schedule.thursday.time_max == 0"}
																	closed
																{else}
																<span class="time_min">{$adminObj -> convertTime ($pron_item.schedule.thursday.time_min)}</span> - <span class="time_max">{$adminObj -> convertTime ($pron_item.schedule.thursday.time_max)}</span>
																{/else}
															{else}
																open all day 
															{/else}
														</span>
														Thu
													</li>
													<li class="friday">
														<span class="arrow_box">
															{if="isset ($pron_item.schedule.friday)"}
																{if="$pron_item.schedule.friday.time_min == 0 && $pron_item.schedule.friday.time_max == 1440"} 
																	open all day 
																{elseif="$pron_item.schedule.friday.time_min == 0 && $pron_item.schedule.friday.time_max == 0"}
																	closed
																{else}
																<span class="time_min">{$adminObj -> convertTime ($pron_item.schedule.friday.time_min)}</span> - <span class="time_max">{$adminObj -> convertTime ($pron_item.schedule.friday.time_max)}</span>
																{/else}
															{else}
																open all day 
															{/else}
														</span>
														Fri
													</li>
													<li class="saturday">
														<span class="arrow_box">
															{if="isset ($pron_item.schedule.saturday)"}
																{if="$pron_item.schedule.saturday.time_min == 0 && $pron_item.schedule.saturday.time_max == 1440"} 
																	open all day 
																{elseif="$pron_item.schedule.saturday.time_min == 0 && $pron_item.schedule.saturday.time_max == 0"}
																	closed
																{else}
																<span class="time_min">{$adminObj -> convertTime ($pron_item.schedule.saturday.time_min)}</span> - <span class="time_max">{$adminObj -> convertTime ($pron_item.schedule.saturday.time_max)}</span>
																{/else}
															{else}
																open all day 
															{/else}
														</span>
														Sat
													</li>
												</ul>
											</div>
										</div>
										<div class="col-md-4">
											<a href="#" class="add_button_v_a prom_add_price" data-toggle="modal" data-target="#add_price" data-backdrop="static"><span class="glyphicon glyphicon-plus"></span> Add Price</a>
											<div class="price_block_p_i">
												<div class="price_block_header">
													<h3>Promotion Deal</h3>
												</div>
												<div class="price_block_body">
													{if="isset ($prices[$pron_item.id])"}
														{foreach="$prices[$pron_item.id] as $price_item"}
																<div class="row" data-id="{$price_item.id}">
																	<div class="col-sm-7 price_name">
																		{$price_item.name}	
																	</div>
																	<div class="col-sm-5 price_value">
																		$ {$price_item.new_price}
																		<span class="glyphicon glyphicon-remove-circle price_delete"></span>
																	</div>
																</div>
														{/foreach}
													{/if}
												</div>
											</div>
										</div>
									</div>
									
								</div>						
							</div>
						{/foreach}
					{/if}	
					</div>
					{if="$sport_id"}
						<a href="#" class="add_prom_block"><span class="glyphicon glyphicon-plus"></span> Add Promotion</a>
					{/if}
				</div>
				
			</div>
		</div>
</div>
<div class="clear"></div>
<!--__________________________MODAL_______________________________-->
<div class="modal fade" id="gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
	  <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  <h4 class="modal-title">Gallery</h4>
      </div>
	  <div class="modal-body">
		  <form enctype="multipart/form-data">
			  <div class="row">
				  <div class="col-md-6">
					  <input type="file" class="hidden gallery_i_f" multiple="" />
					  <button type="button" class="btn btn-default gallery_u_i">Upload Image</button>
					  <input type="file" class="hidden gallery_l_f" />
					  <button type="button" class="btn btn-default gallery_u_l">Upload Logo</button>
				  </div>
				  <div class="col-md-6">
					  
				  </div>
			  </div>
			  
		  </form>
		  <h4>Image list</h4>
		  <div class="gallery_img_list">
					{if="isset($info) && !empty($info.image)"}
					<div class="gal_img_item">
						<img class="img_logo" src="/uploads/vendors/{$id}/{$info.image}" alt="gallery"/>
						<span class="del_image_gallery glyphicon glyphicon-remove"></span>
					</div>
					{/if}
			  {foreach="$gallery as $g_item"}
					<div class="gal_img_item">
						<img  src="/uploads/vendors/{$id}/{$g_item.src}" alt="gallery"/>
						<span class="del_image_gallery glyphicon glyphicon-remove"></span>
					</div>
			  {/foreach}
		  </div>
      </div>
	  <div class="modal-footer">
		  <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
      </div>
	  
  </div>
</div>


<div class="modal fade" id="s_image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
	  <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  <h4 class="modal-title">Select promotion image</h4>
      </div>
	  <div class="modal-body">
		  <form>
			  <div class="row">
				  <div class="col-md-6">
					  <input type="file" class="hidden gallery_i_f_p" />
					  <button type="button" class="btn btn-default gallery_u_i_p">Upload Image</button>
				  </div>
				  <div class="col-md-6">
					
				  </div>
			  </div>
			  
		  </form>
		  <h4>Image list</h4>
		  <div class="gallery_img_list">
					{if="isset($info) && !empty($info.image)"}
					<!--<div class="gal_img_item">
						<img class="img-rounded img_logo select_prom_img" src="/uploads/vendors/{$id}/{$info.image}" alt="gallery"/>
					</div>
					-->
					{/if}
			  {foreach="$gallery as $g_item"}
					<div class="gal_img_item">
						<img class="img-rounded select_prom_img" src="/uploads/vendors/{$id}/{$g_item.src}" alt="gallery"/>
					</div>
			  {/foreach}
		  </div>
      </div>
	  <div class="modal-footer">
		  <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
      </div>
	  
  </div>
</div>


<div class="modal fade" id="enter_sport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
	  <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  <h4>Feature list</h4>
      </div>
	  <div class="modal-body">
		 <input type="text" name="sport_name" class="choose_sport_input" placeholder="choose a sport"/>
		 <div class="v_sport_list_add_s">
			 {$k = 0}
			 {foreach="$sports as $count => $s_item"}
				{if="$k == 0"} <ul> {/if}
					<li><a href="/admin/vendors/promotion/{$id}/{$s_item.id}" >{$s_item.name}</a></li>
				{$k = $k + 1 }
				{if="$k == 15 || $count == (count ($sports) -1) "} </ul>  {$k = 0}{/if}
			 {/foreach}
		 </div>
      </div>
	  
	  
  </div>
</div>

<div class="modal fade" id="full_description" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-dialog">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title">Edit Full Description</h4>
		</div>
		<div class="modal-body">
            <div class="text_help">
                <span class="glyphicon glyphicon-info-sign"></span>
                Describe your promotion in as much detail as possible.
            </div>
			<textarea class="text_full_desc"></textarea>
			<span class="success"></span>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary save_prom_f_desc"> <!--data-dismiss="modal" -->Save</button>
		</div>
		
	</div>
</div>


<div class="modal fade" id="add_price" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-dialog">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title">Edit Price</h4>
		</div>
		<div class="modal-body price-body">
            <div class="text_help">
                <span class="glyphicon glyphicon-info-sign"></span>
                Provide a very short description (25 charterers max) about what is being sold.
            </div>
			<form>
			</form>
			<span class="label label-danger hide">You must need promotion description or promotion name</span>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary prom_b_price"> <!--data-dismiss="modal"-->Save</button>
		</div>
	</div>
</div>



<div class="modal fade" id="add_address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-dialog">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title">Edit Address</h4>
		</div>
		<div class="modal-body">
            <div class="text_help">
                <span class="glyphicon glyphicon-info-sign"></span>
                Change Current Promotion addresses to “selected address” and place it where “using addresses" is now, Change “using addresses” to “previously selected addresses” and place it where “current promotion addresses” are
            </div>

		<input type="text" id="addres" class="form-control" style="float: left; width:100%"/>
            <h3 class="map-title">Using Addresses</h3>
            <div class="used_addres">
                <a href="#">Address name</a>
                <a href="#">Address name</a>
                <a href="#">Address name</a>
            </div>
		<h3  class="map-title">Current Promotion Addresses</h3>
			<ul class="marks">
			</ul>
			<div id="map_canvas" style="width:100%; height:300px;"></div>
		</div>
	</div>
</div>


<div class="modal fade" id="edit_prom_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-dialog">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title">Edit Promotion Info</h4>
		</div>
		<div class="modal-body">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Age range & Gender:
							</a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
                            <div class="text_help">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                Select the age group that your promotion is suitable for.
                            </div>

							<div class="age_add_block">Age <span class="age_min"></span> to <span class="age_max"></span></div>
							<div class="slider-range"></div>
                            <div class="text_help">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                Select the gender group that your promotion is suitable for.
                            </div>
							<div class="gend_title">Gender</div>
							<select class="prom_gender">
								<option value="0">Selected...</option>
								<option value="all">Co-Ed</option>
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
						<h4 class="panel-title">
							<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Categories:
							</a>
						</h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="panel-body">
							<ul class="category_list">
								<li><input class="cat coach" type="checkbox" value="coach"/> Coach</li>
								<li><input class="cat fitness" type="checkbox" value="fitness"/> Fitness</li>
								<li><input class="cat experience" type="checkbox" value="experience"/> Experience</li>
								<li><input class="cat league" type="checkbox" value="league"/> League</li>
								<li><input class="cat rent" type="checkbox" value="rent"/> Rent A Court</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingThree">
						<h4 class="panel-title">
							<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Schedule :
							</a>
						</h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="panel-body">
                            <div class="text_help">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                Select your activity’s schedule.<br/>
                                -       If the activity is available all day, do not move the slider for that day.<br/>
                                -       Revert the slider back to 0 for days that your activity is not available.
                            </div>


                            <ul class="schedule_list">
								<li class="sunday">
									<label>Sunday:&nbsp;</label>
									<span class="time_min"></span> - <span class="time_max"></span>
									<input class="days" type="checkbox" value="1"/>
									<a href="#" class="close-day">close</a><div class="slider-range-sunday"></div>
								</li>
								<li class="monday">
									<label>Monday:&nbsp;</label>
									<span class="time_min"></span> - <span class="time_max"></span>
									<input class="days" type="checkbox" value="1"/>
									<a href="#" class="close-day">close</a><div class="slider-range-monday"></div>
								</li>
								<li class="tuesday">
									<label>Tuesday:&nbsp;</label>
									<span class="time_min"></span> - <span class="time_max"></span>
									<input class="days" type="checkbox" value="1"/>
									<a href="#" class="close-day">close</a><div class="slider-range-tuesday"></div>
								</li>
								<li class="wednesday">
									<label>Wednesday:&nbsp;</label>
									<span class="time_min"></span> - <span class="time_max"></span>
									<input class="days" type="checkbox" value="1"/>
									<a href="#" class="close-day">close</a><div class="slider-range-wednesday"></div>
								</li>
								<li class="thursday">
									<label>Thursday:&nbsp;</label>
									<span class="time_min"></span> - <span class="time_max"></span>
									<input class="days" type="checkbox" value="1"/>
									<a href="#" class="close-day">close</a><div class="slider-range-thursday"></div>
								</li>
								<li class="friday">
									<label>Friday:&nbsp;</label>
									<span class="time_min"></span> - <span class="time_max"></span>
									<input class="days" type="checkbox" value="1"/>
									<a href="#" class="close-day">close</a><div class="slider-range-friday"></div>
								</li>
								<li class="saturday">
									<label>Saturday:&nbsp;</label>
									<span class="time_min"></span> - <span class="time_max"></span>
									<input class="days" type="checkbox" value="1"/>
									<a href="#" class="close-day">close</a><div class="slider-range-saturday"></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script src="/static/admin/js/map.js"></script>
 