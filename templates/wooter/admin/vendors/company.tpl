<script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script src="/static/default/js/slider.js"></script>
<script src="/static/admin/js/map.js"></script>
	
	<div class="admin_vendor_add" data-id="{$id}" {if="isset($sport_id)"}data-sport-id="{$sport_id}"{/if}>
			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active a_v_a_inner_block">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-6 col-md-5 col-lg-5">
                                <div class="image_list logo_block col-sm-4">
                                    <button type="button" class="gallery_u_l{if="$edit_info && $edit_info.logo"} bnt_active{/if}">{if="isset($info.image) && ($info.image)"}Change logo{else}Add logo{/else}</button>
                                    <input type="file" class="hidden gallery_l_f" />
                                    {if="isset($info.image) && ($info.image)"}
                                    <a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/vendors/{$id}/{$info.image}" title="">
                                        <img class="gallery_img_item img_logo" src="/uploads/vendors/{$id}/p_{$info.image}" alt="" />
                                    </a>
                                    {else}
                                    <a class="fancybox-thumb" rel="fancybox-thumb" href="/static/default/img/your-logo-here.jpg" title="">
                                        <img class="gallery_img_item img_logo" src="/static/default/img/your-logo-here.jpg" alt="" />
                                    </a>
                                    {/else}
                                </div>
                                <div class="col-sm-8 padding_clear">
                                    <div class="co_name">
                                        <div class="i-edit">
                                            <h2 class="edit_text">{if="isset($info) && !empty ($info.name)"}{$info.name}{else}Edit Bussines name{/else}</h2>
                                            <span class="edit_label{if="$edit_info && $edit_info.name"} ok_label{/if}" data-name="name"></span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="co_link">
                                        <div class="i-edit">
                                            <div class="edit_text">{if="isset($info) && $info.link"}{$info.link}{else}Company Link{/else}</div>
                                            <span class="edit_label{if="$edit_info && $edit_info.link"} ok_label{/if}" data-name="link"></span>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>

								<div class="clear"></div>
								<div class="a_v_a_gallery_block">
									<div class="image_list">
                                        <div class="slider_image_s">
                                            <a class="left_img_arrow"></a>
                                            <div class="slider_list">

                                                <span id="gallery_list">
                                                {foreach="$gallery as $g_item"}
                                                    <a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/vendors/{$id}/{$g_item.src}" title="">
                                                        <img class="gallery_img_item" src="/uploads/vendors/{$id}/p_{$g_item.src}" alt="" />
                                                    </a>
                                                {/foreach}
												{foreach="$prom_gallery as $prom_g_item"}
													<a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/vendors/{$id}/{$prom_g_item.src}" title="">
                                                        <img class="gallery_img_item" src="/uploads/vendors/{$id}/p_{$prom_g_item.src}" alt="" />
                                                    </a>
												{/foreach}
                                                </span>

                                            </div>
                                            <a class="right_img_arrow"></a>
                                        </div>
									</div>

								</div>
                                
								<div class="co_phone">
									<div class="i-edit">
										<div class="edit_text">{if="isset($info) && $info.phone_number"}{$info.phone_number}{else}Company phone{/else}</div>
										<span class="edit_label{if="$edit_info && $edit_info.phone_number"} ok_label{/if}" data-name="phone_number"></span>
									</div>
									<div class="clear"></div>
								</div>
								<div class="co_email">
									<div class="i-edit">
										<div class="edit_text">{if="isset($info) && $info.c_email"}{$info.c_email}{elseif="isset($info) && $info.email"}{$info.email}{else}Company email{/else}</div>
										<span class="edit_label{if="$edit_info && $edit_info.c_email"} ok_label{/if}" data-name="c_email"></span>
									</div>
									<div class="clear"></div>
								</div>
                                <div class="clearfix"></div>
								<h3 class="company_desc_title">About Company</h3>
								<div class="desrcibe_block">
									<div class="t-edit">
										<div class="edit_text">{if="isset($info) && $info.about"}{$info.about}{else}Describe your company's mission, history or achivments. This is your "pitch" to make your business stand out from the rest.{/else}</div>
										<span class="edit_textarea{if="$edit_info && $edit_info.about"} ok_label{/if}" data-name="about"></span>
									</div>
								</div>
							</div>
							<div class="col-xs-6 col-md-7 col-lg-7">
								<div class="map_canvas" id="map_canvas" style="width:100%; height:590px; frameborder:0; border:0;">

								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 sport_list_block">
								<!-- Button trigger modal -->
								{if="is_array($vendorSport) && count ($vendorSport) > 0"}

									{foreach="$vendorSport as $v_sport_item"}

										<a href="/admin/vendors/company/{$id}/{$v_sport_item.id}"  data-id = "{$v_sport_item.id}"class="vendor_feature_list_link {if="$sport_id == $v_sport_item.id"}active{/if}">{$v_sport_item.name}<span class='delete_sport glyphicon glyphicon-remove-circle'></span></a>
										{if="$sport_id == $v_sport_item.id"}
											{$hasSport = true}
										{/if}
									{/foreach}

								{/if}

								{if="!$hasSport && $sport_id"}
									<a href="/vendor-cabinet/{$sportInfo.id}" class="vendor_feature_list_link active">{$sportInfo.name}</a>
								{/if}

								<a href="#" data-toggle="modal" data-target="#enter_sport" class="vendor_add_feauture_button"><span class="plus_white"></span> New Activity</a>
							</div>
						</div>

					</div>

				</div>
			</div>
	</div>
    <div id="big_promotion_list">
    {if="$promInfo"}
        {foreach="$promInfo as $pron_item"}
            <div class="row big_promotion promotion_{$pron_item.id} prom_id" data-id="{$pron_item.id}">
				<div class="prom_container">
					{$p_edit = $prom_edit[$pron_item['id']];}
					<div class="col-sm-4 promotion_slider">
						<div class="prom_slider_block">
                        <img src='{if="$pron_item.gallery"}/uploads/vendors/{$id}/p_{$pron_item.gallery["0"]["src"]}{else}/static/admin/img/upload_img.png{/else}' class="prev_prom_img {if="!$pron_item.gallery"}def_img{/if}"/>
                        <div class="list_scat_prom">
                            {foreach="$pron_item.category as $cat_item"}
                                <span>{$cat_item.value}</span>
                            {/foreach}
                        </div>
                        <a href="#" class="prom_img{if="$p_edit && $p_edit['gallery']"} bnt_active{/if}" data-toggle="modal" data-target="#prom_gallery" data-backdrop="static">Add Images</a>
                    </div>
                    <div class="promotion_image_list">
                        {foreach="$pron_item['gallery'] as $g_p_item"}
                            <a class="fancybox-thum-{$g_p_item['p_id']}" rel="fancybox-thumb-{$g_p_item['p_id']}" href="/uploads/vendors/{$id}/{$g_p_item.src}" title="">
                                <img src="/uploads/vendors/{$id}/p_{$g_p_item.src}"/>
                            </a>
                        {/foreach}

                    </div>
                </div>

                <div class="col-sm-8">
					<div class="big_promotion_wrap">

						<div class="big_promotion_header">
							<div class="big_promotion_name">
								<div class = "i-edit-dinamic">
									<h2 class="edit_text">{if="$pron_item.name"}{trim($pron_item.name)}{else}Promotion Name{/else}</h2>
									<span class="edit_label{if="$p_edit && $p_edit['name']"} ok_label{/if}" data-url="/admin/vendors/ajax/editPromoInfo/" data-name="name"></span>
								</div>
							</div>
							<div class="gender_block">
                                <span>For</span>
                                <select class="prom_gender{if="$p_edit && $p_edit['gender']"} select_active{/if}">
                                    <option value="0">Gender...</option>
                                    <option value="all" {if="$pron_item.gender == 'all'"}selected=""{/if}>Co-Ed</option>
                                    <option value="male" {if="$pron_item.gender == 'male'"}selected=""{/if}>Male</option>
                                    <option value="female" {if="$pron_item.gender == 'female'"}selected=""{/if}>Female</option>
                                </select>
                            </div>
							<div class="edit_age_block">
                                    <span>Ages</span>
                                    <div class="min_age_edit">
                                        <div class = "i-edit-dinamic">
                                            <input class="prom_age_min" value="{$pron_item.age_min}"/>
                                        </div>
                                    </div>
                                    <span>to</span>
                                    <div class="max_age_edit">
                                        <div class = "i-edit-dinamic">
                                            <input class="prom_age_max" value="{$pron_item.age_max}"/>
                                        </div>
                                    </div>
							</div>
                           
						</div>

						<div class="clear"></div>
						<div class="big_promotion_content">


							<div class="promotion_describe">
								<div class="t-edit-dinamic">
									<div class="edit_text active_edit">{if="$pron_item.s_desc"}{trim($pron_item.s_desc)}{else}Describe your promotion.
										Input as much information as you can to answer any of the customer’s questions.{/else}
									</div>
									<span class="edit_textarea_prom edit_textarea{if="$p_edit && $p_edit['s_desc']"} ok_label{/if}" data-name="s_desc" data-url="/admin/vendors/ajax/editPromoInfo/"></span>
								</div>
							</div>
							<div class="row prom_button_block">
								<div class="col-md-12">
                                    <nav class="skew-menu">
                                        <ul>
                                            <li><a href="#" class="add_button_v_a full_desc{if="$p_edit && $p_edit['f_desc']"} link_active{/if}" data-toggle="modal" data-target="#full_description" data-backdrop="static">{if="$p_edit && $p_edit['f_desc']"} Edit Full Description{else}Add Full Description{/if} <span class="plus_icon"></span></a></li>
                                            <li><a href="#" class="add_button_v_a prom_map{if="$p_edit && $p_edit['address']"} link_active{/if}" data-toggle="modal" data-target="#add_address" data-backdrop="static">{if="$p_edit && $p_edit['address']"}Edit Address{else}Select Address{/if} <span class="plus_icon"></span></a></li>
                                            <li><a href="#" class="add_button_v_a edit_prom_info{if="$p_edit && $p_edit['schedule']"} link_active{/if}" data-toggle="modal" data-target="#edit_prom_info" data-backdrop="static">{if="$p_edit && $p_edit['schedule']"}Edit Schedule {else}Select Schedule {/if}<span class="plus_icon"></span></a></li>
                                            <li><a href="#" class="add_category_p{if="$p_edit && $p_edit['category']"} link_active{/if}" data-toggle="modal" data-target="#sub_category_modal">{if="$p_edit && $p_edit['category']"}add category{else}edit category{/if} <span class="plus_icon"></span></a></li>
                                        </ul>
                                    </nav>
								</div>
							</div>
                            <a href="#" onclick="return false"  class="add_price_button" data-toggle="popover" title="Add promo price" data-content='<button type="button" class="close"><span aria-hidden="true">×</span></button><form action="" method="POST" class="add_price_form"><div class="form_item"><label>Standard Price</label><span class="dollar_label">$</span><input type="text" class="standart_price" name="standart_price" placeholder="0"></div><div class="form_item"><label>Discount (Optional)</label><span class="discount_label">%</span><input type="text" class="discount_perc" placeholder="0" name="discount_perc" maxlength="3"></div><hr/><div class="form_item"><label class="final_label"> Final Price $ <input type="text" placeholder="0" class="final_price" name="final_price" readonly></label></div><hr/><div class="form_item"><textarea name="description_price" placeholder="Describe what is being sold." class="description_price"></textarea></div><button name="send" type="button">Publish Price</button></form>'>
                                <span>Add Promo price</span> <span class="plus_icon"></span>
                            </a>

                            <div class="slider_p">
								<a class="left_arror_p left_arror_p{$pron_item.id}">1</a>
								<div class="prom_price_slider prom_price_slider{$pron_item.id}">
									<div class="price_slider_inner">
										{if="isset ($prices[$pron_item.id])"}
											{foreach="$prices[$pron_item.id] as $price_item"}
												{$e_price = isset ($edit_price[$price_item.id]) ? $edit_price[$price_item.id] : false;}
												<div class="item_price" data-id="{$price_item.id}">
                                                <span class="price_delete_button"></span>
                                                
                                                <div class="col-sm-12 price_line">
                                                    <span class="new_price_i">Final price: ${$price_item.new_price}</span>
                                                    <span class="discount_i">{if="$price_item.discount != '0'"}Discount: {$price_item.discount}%{/if}</span>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="price_description_wrap">
                                                    <div class="t-edit-price">
                                                        <div class="price_description">
                                                            {$price_item.name}
                                                        </div>
                                                    </div>
                                                </div>
												<a href="#" data-toggle="modal" data-target="#edit_price" class="edit_price">Edit price</a>
                                            </div>
											{/foreach}
										{/if}
									</div>
								</div>

								<a class="right_arror_p right_arror_p{$pron_item.id}">1</a>
							</div>
						</div>
					</div>

                <div class="right_schedule">
                    <a href="#" class="delete_prom"></a>
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

                </div>
            </div>
            </div>
            <script>
                $(function() {
                    $('.prom_price_slider<?=$pron_item['id']?>').jcarousel({});
                    $('.left_arror_p<?=$pron_item['id']?>')
                    .jcarouselControl({
                        target: '-=1'
                    });

                    $('.right_arror_p<?=$pron_item['id']?>')
                    .jcarouselControl({
                        target: '+=1'
                    });
                });
            </script>
        {/foreach}

    {/if}
    </div>

    {if="$sport_id"}
        <a href="#" class="add_prom_block"><span class="glyphicon glyphicon-plus"></span> Add Promotion</a>
    {/if}
	<div class="clear"></div>


    <div class="modal" id="edit_price" tabindex="-1" role="dialog" aria-labelledby="edit_price" aria-hidden="true">
        <div class="modal-dialog" style="width: 350px;margin-top: 12%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Edit Price</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="edit_price_form">
                        <div class="form_item">
							<label>Standard Price</label>
							<span class="dollar_label">$</span><input type="text" class="standart_price" name="standart_price">
						</div>
						<div class="form_item">
							<label>Discount (Optional)</label>
							<span class="discount_label">%</span><input type="text" class="discount_perc" name="discount_perc" maxlength="3">
						</div>
						<hr/>
						<div class="form_item">
							<label class="final_label">Final Price $<input type="text" class="final_price" name="final_price" readonly></label>
						</div>
						<hr/>
						<div class="form_item">
							<textarea name="description_price" placeholder="Describe what is being sold." class="description_price"></textarea>
						</div>
                    
                        <button name="send" type="button">Publish Price</button>
						
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--I'm done for NOW popup-->
    <!-- Modal -->
    <div class="modal" id="im_done" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Profile Saved but Not Live</h4>
                </div>
                <div class="modal-body">


                </div>
                <div class="modal-footer">
                    <button type="button" style="display : none" class="btn btn-primary promotion_save" data-dismiss="modal">Publish</button>
                </div>
            </div>
        </div>
    </div>







    <!-- SUB category modal -->
    <div class="modal fade" id="sub_category_modal" tabindex="-1" role="dialog" aria-labelledby="sub_category_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Sub category</h4>
                </div>
                <div class="modal-body">
                    <ul class="category_list">
                        <li><input class="cat coach" type="checkbox" value="coach"/> Coach</li>
                        <li><input class="cat fitness" type="checkbox" value="fitness"/> Fitness</li>
                        <li><input class="cat experience" type="checkbox" value="experience"/> Experience</li>
                        <li><input class="cat league" type="checkbox" value="league"/> League</li>
                        <li><input class="cat rent" type="checkbox" value="rent"/> Rent A Court</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>







    <!--modal for promotion gallery-->
    <!-- Modal -->
    <div class="modal fade" id="prom_gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Gallery</h4>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" class="hidden add_prom_img" multiple="" />
                                <button type="button" class="btn btn-default prom_add_images">Upload Image</button>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>

                    </form>
                    <h4>Image list</h4>
                    <div class="prom_gallery_img_list">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>





    <!--modal for company gallery-->
    <!-- Modal -->
    <div class="modal fade" id="gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Gallery</h4>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" class="hidden gallery_i_f" multiple="" />
                                <button type="button" class="btn btn-default gallery_u_i">Upload Image</button>
                                <?php if (false) : ?>
                                <button type="button" class="btn btn-default gallery_u_l">Upload Logo</button>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>

                    </form>
                    <h4>Image list</h4>
                    <div class="gallery_img_list">
                        {if="isset($info) && !empty($info.image) && false"}
                            <div class="gal_img_item">
                                <img class="img_logo" src="/uploads/vendors/{$id}/{$info.image}" alt="gallery"/>
                                <span class="del_image_gallery"></span>
                            </div>
                        {/if}
                        {foreach="$gallery as $g_item"}
                            <div class="gal_img_item">
                                <img  src="/uploads/vendors/{$id}/p_{$g_item.src}" alt="gallery"/>
                                <span class="del_image_gallery"></span>
                            </div>
                        {/foreach}
                        {foreach="$prom_gallery as $prom_g_item"}
                            <div class="gal_img_item">
                                <img  src="/uploads/vendors/{$id}/p_{$prom_g_item.src}" alt="gallery"/>
                                <span class="del_image_gallery"></span>
                            </div>
                        {/foreach}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>



    <!--modal for enter sport-->
    <!-- Modal -->
    <div class="modal fade" id="enter_sport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Feature list</h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="sport_name" class="choose_sport_input" placeholder="choose a sport"/>
                    <div class="v_sport_list_add_s">
                        {$k = 0}
                        {foreach="$sports as $count => $s_item"}
                            {if="$k == 0"} <ul> {/if}
                            <li><a href="/admin/vendors/company/{$id}/{$s_item.id}" >{$s_item.name}</a></li>
                            {$k = $k + 1 }
                            {if="$k == 15 || $count == (count ($sports) -1) "} </ul>  {$k = 0}{/if}
                        {/foreach}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>




    <!--modal for enter sport-->
    <!-- Modal -->
    <div class="modal fade" id="full_description" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Full Description</h4>
                </div>
                <div class="modal-body">
                    <div class="text_help">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        Describe your promotion in as much detail as possible.
                    </div>
                    <textarea class="text_full_desc" placeholder="Describe your promotion.Input as much information as you can to answer any of the customer's questions."></textarea>
                    <span class="success"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save_prom_f_desc"> Save</button>
                </div>
            </div>
        </div>
    </div>




    <!--modal for adress-->
    <!-- Modal -->
    <div class="modal fade" id="add_address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Address</h4>
                </div>
                <div class="modal-body">
                    <div class="text_help">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        Please, enter your promotion address
                    </div>

                    <input type="text" id="addres" class="form-control" style="float: left; width:100%"/>

                    <h3  class="map-title">Selected Address</h3>
                    <ul class="marks">
                    </ul>

                    <h3 class="map-title">Previously Selected Addresses</h3>
                    <div class="used_addres">
                        <a href="#">Address name</a>
                        <a href="#">Address name</a>
                        <a href="#">Address name</a>
                    </div>

                    <div id="map_canvas_s" style="width:100%; height:300px;"></div>
                </div>

            </div>
        </div>
    </div>





    <!--modal for adress-->
    <!-- Modal -->
    <div class="modal fade" id="edit_prom_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Address</h4>
                </div>
                <div class="modal-body">
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

