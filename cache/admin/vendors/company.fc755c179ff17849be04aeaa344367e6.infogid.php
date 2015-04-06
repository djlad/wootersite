<?php if(!class_exists('Template')){exit;}?><script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script src="/static/default/js/slider.js"></script>
<script src="/static/admin/js/map.js"></script>

<div class="admin_vendor_add" data-id="<? echo $id;?>" <?php if( isset($sport_id) ){ ?>data-sport-id="<? echo $sport_id;?>"<?php } ?>>
<!-- Tab panes -->
<div class="tab-content">
<div class="tab-pane active a_v_a_inner_block">
<div class="container-fluid">
<div class="row">
<div class="col-xs-6 col-md-5 col-lg-5">
                                <div class="image_list logo_block col-sm-4">
                                    <button type="button" class="gallery_u_l<?php if( $edit_info && $edit_info["logo"] ){ ?> bnt_active<?php } ?>"><?php if( isset($info["image"]) && ($info["image"]) ){ ?>Change logo<?php }else{ ?>Add logo<?php } ?></button>
                                    <input type="file" class="hidden gallery_l_f" />
                                    <?php if( isset($info["image"]) && ($info["image"]) ){ ?>
                                    <a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/vendors/<? echo $id;?>/<? echo $info["image"];?>" title="">
                                        <img class="gallery_img_item img_logo" src="/uploads/vendors/<? echo $id;?>/p_<? echo $info["image"];?>" alt="" />
                                    </a>
                                    <?php }else{ ?>
                                    <a class="fancybox-thumb" rel="fancybox-thumb" href="/static/default/img/your-logo-here.jpg" title="">
                                        <img class="gallery_img_item img_logo" src="/static/default/img/your-logo-here.jpg" alt="" />
                                    </a>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-8 padding_clear">
                                    <div class="co_name">
                                        <div class="i-edit">
                                            <h2 class="edit_text"><?php if( isset($info) && !empty ($info["name"]) ){ ?><? echo $info["name"];?><?php }else{ ?>Edit Bussines name<?php } ?></h2>
                                            <span class="edit_label<?php if( $edit_info && $edit_info["name"] ){ ?> ok_label<?php } ?>" data-name="name"></span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="co_link">
                                        <div class="i-edit">
                                            <div class="edit_text"><?php if( isset($info) && $info["link"] ){ ?><? echo $info["link"];?><?php }else{ ?>Company Link<?php } ?></div>
                                            <span class="edit_label<?php if( $edit_info && $edit_info["link"] ){ ?> ok_label<?php } ?>" data-name="link"></span>
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
                                                <?php foreach( $gallery as $g_item ){ ?>
                                                    <a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/vendors/<? echo $id;?>/<? echo $g_item["src"];?>" title="">
                                                        <img class="gallery_img_item" src="/uploads/vendors/<? echo $id;?>/p_<? echo $g_item["src"];?>" alt="" />
                                                    </a>
                                                <?php } ?>
<?php foreach( $prom_gallery as $prom_g_item ){ ?>
<a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/vendors/<? echo $id;?>/<? echo $prom_g_item["src"];?>" title="">
                                                        <img class="gallery_img_item" src="/uploads/vendors/<? echo $id;?>/p_<? echo $prom_g_item["src"];?>" alt="" />
                                                    </a>
<?php } ?>
                                                </span>

                                            </div>
                                            <a class="right_img_arrow"></a>
                                        </div>
</div>

</div>
                                
<div class="co_phone">
<div class="i-edit">
<div class="edit_text"><?php if( isset($info) && $info["phone_number"] ){ ?><? echo $info["phone_number"];?><?php }else{ ?>Company phone<?php } ?></div>
<span class="edit_label<?php if( $edit_info && $edit_info["phone_number"] ){ ?> ok_label<?php } ?>" data-name="phone_number"></span>
</div>
<div class="clear"></div>
</div>
<div class="co_email">
<div class="i-edit">
<div class="edit_text"><?php if( isset($info) && $info["c_email"] ){ ?><? echo $info["c_email"];?><?php }elseif( isset($info) && $info["email"] ){ ?><? echo $info["email"];?><?php }else{ ?>Company email<?php } ?></div>
<span class="edit_label<?php if( $edit_info && $edit_info["c_email"] ){ ?> ok_label<?php } ?>" data-name="c_email"></span>
</div>
<div class="clear"></div>
</div>
                                <div class="clearfix"></div>
<h3 class="company_desc_title">About Company</h3>
<div class="desrcibe_block">
<div class="t-edit">
<div class="edit_text"><?php if( isset($info) && $info["about"] ){ ?><? echo $info["about"];?><?php }else{ ?>Describe your company's mission, history or achivments. This is your "pitch" to make your business stand out from the rest.<?php } ?></div>
<span class="edit_textarea<?php if( $edit_info && $edit_info["about"] ){ ?> ok_label<?php } ?>" data-name="about"></span>
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
<?php if( is_array($vendorSport) && count ($vendorSport) > 0 ){ ?>

<?php foreach( $vendorSport as $v_sport_item ){ ?>

<a href="/admin/vendors/company/<? echo $id;?>/<? echo $v_sport_item["id"];?>"  data-id = "<? echo $v_sport_item["id"];?>"class="vendor_feature_list_link <?php if( $sport_id == $v_sport_item["id"] ){ ?>active<?php } ?>"><? echo $v_sport_item["name"];?><span class='delete_sport glyphicon glyphicon-remove-circle'></span></a>
<?php if( $sport_id == $v_sport_item["id"] ){ ?>
<? $hasSport = true;?>
<?php } ?>
<?php } ?>

<?php } ?>

<?php if( !$hasSport && $sport_id ){ ?>
<a href="/vendor-cabinet/<? echo $sportInfo["id"];?>" class="vendor_feature_list_link active"><? echo $sportInfo["name"];?></a>
<?php } ?>

<a href="#" data-toggle="modal" data-target="#enter_sport" class="vendor_add_feauture_button"><span class="plus_white"></span> New Activity</a>
</div>
</div>

</div>

</div>
</div>
</div>
    <div id="big_promotion_list">
    <?php if( $promInfo ){ ?>
        <?php foreach( $promInfo as $pron_item ){ ?>
            <div class="row big_promotion promotion_<? echo $pron_item["id"];?> prom_id" data-id="<? echo $pron_item["id"];?>">
<div class="prom_container">
<? $p_edit = $prom_edit[$pron_item['id']];;?>
<div class="col-sm-4 promotion_slider">
<div class="prom_slider_block">
                        <img src='<?php if( $pron_item["gallery"] ){ ?>/uploads/vendors/<? echo $id;?>/p_<? echo $pron_item["gallery"]["0"]["src"];?><?php }else{ ?>/static/admin/img/upload_img.png<?php } ?>' class="prev_prom_img <?php if( !$pron_item["gallery"] ){ ?>def_img<?php } ?>"/>
                        <div class="list_scat_prom">
                            <?php foreach( $pron_item["category"] as $cat_item ){ ?>
                                <span><? echo $cat_item["value"];?></span>
                            <?php } ?>
                        </div>
                        <a href="#" class="prom_img<?php if( $p_edit && $p_edit['gallery'] ){ ?> bnt_active<?php } ?>" data-toggle="modal" data-target="#prom_gallery" data-backdrop="static">Add Images</a>
                    </div>
                    <div class="promotion_image_list">
                        <?php foreach( $pron_item['gallery'] as $g_p_item ){ ?>
                            <a class="fancybox-thum-<? echo $g_p_item['p_id'];?>" rel="fancybox-thumb-<? echo $g_p_item['p_id'];?>" href="/uploads/vendors/<? echo $id;?>/<? echo $g_p_item["src"];?>" title="">
                                <img src="/uploads/vendors/<? echo $id;?>/p_<? echo $g_p_item["src"];?>"/>
                            </a>
                        <?php } ?>

                    </div>
                </div>

                <div class="col-sm-8">
<div class="big_promotion_wrap">

<div class="big_promotion_header">
<div class="big_promotion_name">
<div class = "i-edit-dinamic">
<h2 class="edit_text"><?php if( $pron_item["name"] ){ ?><? echo trim($pron_item["name"]);?><?php }else{ ?>Promotion Name<?php } ?></h2>
<span class="edit_label<?php if( $p_edit && $p_edit['name'] ){ ?> ok_label<?php } ?>" data-url="/admin/vendors/ajax/editPromoInfo/" data-name="name"></span>
</div>
</div>
<div class="gender_block">
                                <span>For</span>
                                <select class="prom_gender<?php if( $p_edit && $p_edit['gender'] ){ ?> select_active<?php } ?>">
                                    <option value="0">Gender...</option>
                                    <option value="all" <?php if( $pron_item["gender"] == 'all' ){ ?>selected=""<?php } ?>>Co-Ed</option>
                                    <option value="male" <?php if( $pron_item["gender"] == 'male' ){ ?>selected=""<?php } ?>>Male</option>
                                    <option value="female" <?php if( $pron_item["gender"] == 'female' ){ ?>selected=""<?php } ?>>Female</option>
                                </select>
                            </div>
<div class="edit_age_block">
                                    <span>Ages</span>
                                    <div class="min_age_edit">
                                        <div class = "i-edit-dinamic">
                                            <input class="prom_age_min" value="<? echo $pron_item["age_min"];?>"/>
                                        </div>
                                    </div>
                                    <span>to</span>
                                    <div class="max_age_edit">
                                        <div class = "i-edit-dinamic">
                                            <input class="prom_age_max" value="<? echo $pron_item["age_max"];?>"/>
                                        </div>
                                    </div>
</div>
                           
</div>

<div class="clear"></div>
<div class="big_promotion_content">


<div class="promotion_describe">
<div class="t-edit-dinamic">
<div class="edit_text active_edit"><?php if( $pron_item["s_desc"] ){ ?><? echo trim($pron_item["s_desc"]);?><?php }else{ ?>Describe your promotion.
Input as much information as you can to answer any of the customer’s questions.<?php } ?>
</div>
<span class="edit_textarea_prom edit_textarea<?php if( $p_edit && $p_edit['s_desc'] ){ ?> ok_label<?php } ?>" data-name="s_desc" data-url="/admin/vendors/ajax/editPromoInfo/"></span>
</div>
</div>
<div class="row prom_button_block">
<div class="col-md-12">
                                    <nav class="skew-menu">
                                        <ul>
                                            <li><a href="#" class="add_button_v_a full_desc<?php if( $p_edit && $p_edit['f_desc'] ){ ?> link_active<?php } ?>" data-toggle="modal" data-target="#full_description" data-backdrop="static"><?php if( $p_edit && $p_edit['f_desc'] ){ ?> Edit Full Description<?php }else{ ?>Add Full Description<?php } ?> <span class="plus_icon"></span></a></li>
                                            <li><a href="#" class="add_button_v_a prom_map<?php if( $p_edit && $p_edit['address'] ){ ?> link_active<?php } ?>" data-toggle="modal" data-target="#add_address" data-backdrop="static"><?php if( $p_edit && $p_edit['address'] ){ ?>Edit Address<?php }else{ ?>Select Address<?php } ?> <span class="plus_icon"></span></a></li>
                                            <li><a href="#" class="add_button_v_a edit_prom_info<?php if( $p_edit && $p_edit['schedule'] ){ ?> link_active<?php } ?>" data-toggle="modal" data-target="#edit_prom_info" data-backdrop="static"><?php if( $p_edit && $p_edit['schedule'] ){ ?>Edit Schedule <?php }else{ ?>Select Schedule <?php } ?><span class="plus_icon"></span></a></li>
                                            <li><a href="#" class="add_category_p<?php if( $p_edit && $p_edit['category'] ){ ?> link_active<?php } ?>" data-toggle="modal" data-target="#sub_category_modal"><?php if( $p_edit && $p_edit['category'] ){ ?>add category<?php }else{ ?>edit category<?php } ?> <span class="plus_icon"></span></a></li>
                                        </ul>
                                    </nav>
</div>
</div>
                            <a href="#" onclick="return false"  class="add_price_button" data-toggle="popover" title="Add promo price" data-content='<button type="button" class="close"><span aria-hidden="true">×</span></button><form action="" method="POST" class="add_price_form"><div class="form_item"><label>Standard Price</label><span class="dollar_label">$</span><input type="text" class="standart_price" name="standart_price" placeholder="0"></div><div class="form_item"><label>Discount (Optional)</label><span class="discount_label">%</span><input type="text" class="discount_perc" placeholder="0" name="discount_perc" maxlength="3"></div><hr/><div class="form_item"><label class="final_label"> Final Price $ <input type="text" placeholder="0" class="final_price" name="final_price" readonly></label></div><hr/><div class="form_item"><textarea name="description_price" placeholder="Describe what is being sold." class="description_price"></textarea></div><button name="send" type="button">Publish Price</button></form>'>
                                <span>Add Promo price</span> <span class="plus_icon"></span>
                            </a>

                            <div class="slider_p">
<a class="left_arror_p left_arror_p<? echo $pron_item["id"];?>">1</a>
<div class="prom_price_slider prom_price_slider<? echo $pron_item["id"];?>">
<div class="price_slider_inner">
<?php if( isset ($prices[$pron_item["id"]]) ){ ?>
<?php foreach( $prices[$pron_item["id"]] as $price_item ){ ?>
<? $e_price = isset ($edit_price[$price_item["id"]]) ? $edit_price[$price_item["id"]] : false;;?>
<div class="item_price" data-id="<? echo $price_item["id"];?>">
                                                <span class="price_delete_button"></span>
                                                
                                                <div class="col-sm-12 price_line">
                                                    <span class="new_price_i">Final price: $<? echo $price_item["new_price"];?></span>
                                                    <span class="discount_i"><?php if( $price_item["discount"] != '0' ){ ?>Discount: <? echo $price_item["discount"];?>%<?php } ?></span>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="price_description_wrap">
                                                    <div class="t-edit-price">
                                                        <div class="price_description">
                                                            <? echo $price_item["name"];?>
                                                        </div>
                                                    </div>
                                                </div>
<a href="#" data-toggle="modal" data-target="#edit_price" class="edit_price">Edit price</a>
                                            </div>
<?php } ?>
<?php } ?>
</div>
</div>

<a class="right_arror_p right_arror_p<? echo $pron_item["id"];?>">1</a>
</div>
</div>
</div>

                <div class="right_schedule">
                    <a href="#" class="delete_prom"></a>
                    <div class="schedule_block">
                        <ul>
                            <li class="sunday">
<span class="arrow_box">
<?php if( isset ($pron_item["schedule"]["sunday"]) ){ ?>
<?php if( $pron_item["schedule"]["sunday"]["time_min"] == 0 && $pron_item["schedule"]["sunday"]["time_max"] == 1440 ){ ?>
open all day
<?php }elseif( $pron_item["schedule"]["sunday"]["time_min"] == 0 && $pron_item["schedule"]["sunday"]["time_max"] == 0 ){ ?>
closed
<?php }else{ ?>
<span class="time_min"><? echo $adminObj -> convertTime ($pron_item["schedule"]["sunday"]["time_min"]);?></span> - <span class="time_max"><? echo $adminObj -> convertTime ($pron_item["schedule"]["sunday"]["time_max"]);?></span>
<?php } ?>
<?php }else{ ?>
open all day
<?php } ?>
</span>
                                Sun
                            </li>
                            <li class="monday">
<span class="arrow_box">
<?php if( isset ($pron_item["schedule"]["monday"]) ){ ?>
<?php if( $pron_item["schedule"]["monday"]["time_min"] == 0 && $pron_item["schedule"]["monday"]["time_max"] == 1440 ){ ?>
open all day
<?php }elseif( $pron_item["schedule"]["monday"]["time_min"] == 0 && $pron_item["schedule"]["monday"]["time_max"] == 0 ){ ?>
closed
<?php }else{ ?>
<span class="time_min"><? echo $adminObj -> convertTime ($pron_item["schedule"]["monday"]["time_min"]);?></span> - <span class="time_max"><? echo $adminObj -> convertTime ($pron_item["schedule"]["monday"]["time_max"]);?></span>
<?php } ?>
<?php }else{ ?>
open all day
<?php } ?>
</span>
                                Mon
                            </li>
                            <li class="tuesday">
<span class="arrow_box">
<?php if( isset ($pron_item["schedule"]["tuesday"]) ){ ?>
<?php if( $pron_item["schedule"]["tuesday"]["time_min"] == 0 && $pron_item["schedule"]["tuesday"]["time_max"] == 1440 ){ ?>
open all day
<?php }elseif( $pron_item["schedule"]["tuesday"]["time_min"] == 0 && $pron_item["schedule"]["tuesday"]["time_max"] == 0 ){ ?>
closed
<?php }else{ ?>
<span class="time_min"><? echo $adminObj -> convertTime ($pron_item["schedule"]["tuesday"]["time_min"]);?></span> - <span class="time_max"><? echo $adminObj -> convertTime ($pron_item["schedule"]["tuesday"]["time_max"]);?></span>
<?php } ?>
<?php }else{ ?>
open all day
<?php } ?>
</span>
                                Tue
                            </li>
                            <li class="wednesday">
<span class="arrow_box">
<?php if( isset ($pron_item["schedule"]["wednesday"]) ){ ?>
<?php if( $pron_item["schedule"]["wednesday"]["time_min"] == 0 && $pron_item["schedule"]["wednesday"]["time_max"] == 1440 ){ ?>
open all day
<?php }elseif( $pron_item["schedule"]["wednesday"]["time_min"] == 0 && $pron_item["schedule"]["wednesday"]["time_max"] == 0 ){ ?>
closed
<?php }else{ ?>
<span class="time_min"><? echo $adminObj -> convertTime ($pron_item["schedule"]["wednesday"]["time_min"]);?></span> - <span class="time_max"><? echo $adminObj -> convertTime ($pron_item["schedule"]["wednesday"]["time_max"]);?></span>
<?php } ?>
<?php }else{ ?>
open all day
<?php } ?>
</span>
                                Wed
                            </li>
                            <li class="thursday">
<span class="arrow_box">
<?php if( isset ($pron_item["schedule"]["thursday"]) ){ ?>
<?php if( $pron_item["schedule"]["thursday"]["time_min"] == 0 && $pron_item["schedule"]["thursday"]["time_max"] == 1440 ){ ?>
open all day
<?php }elseif( $pron_item["schedule"]["thursday"]["time_min"] == 0 && $pron_item["schedule"]["thursday"]["time_max"] == 0 ){ ?>
closed
<?php }else{ ?>
<span class="time_min"><? echo $adminObj -> convertTime ($pron_item["schedule"]["thursday"]["time_min"]);?></span> - <span class="time_max"><? echo $adminObj -> convertTime ($pron_item["schedule"]["thursday"]["time_max"]);?></span>
<?php } ?>
<?php }else{ ?>
open all day
<?php } ?>
</span>
                                Thu
                            </li>
                            <li class="friday">
<span class="arrow_box">
<?php if( isset ($pron_item["schedule"]["friday"]) ){ ?>
<?php if( $pron_item["schedule"]["friday"]["time_min"] == 0 && $pron_item["schedule"]["friday"]["time_max"] == 1440 ){ ?>
open all day
<?php }elseif( $pron_item["schedule"]["friday"]["time_min"] == 0 && $pron_item["schedule"]["friday"]["time_max"] == 0 ){ ?>
closed
<?php }else{ ?>
<span class="time_min"><? echo $adminObj -> convertTime ($pron_item["schedule"]["friday"]["time_min"]);?></span> - <span class="time_max"><? echo $adminObj -> convertTime ($pron_item["schedule"]["friday"]["time_max"]);?></span>
<?php } ?>
<?php }else{ ?>
open all day
<?php } ?>
</span>
                                Fri
                            </li>
                            <li class="saturday">
<span class="arrow_box">
<?php if( isset ($pron_item["schedule"]["saturday"]) ){ ?>
<?php if( $pron_item["schedule"]["saturday"]["time_min"] == 0 && $pron_item["schedule"]["saturday"]["time_max"] == 1440 ){ ?>
open all day
<?php }elseif( $pron_item["schedule"]["saturday"]["time_min"] == 0 && $pron_item["schedule"]["saturday"]["time_max"] == 0 ){ ?>
closed
<?php }else{ ?>
<span class="time_min"><? echo $adminObj -> convertTime ($pron_item["schedule"]["saturday"]["time_min"]);?></span> - <span class="time_max"><? echo $adminObj -> convertTime ($pron_item["schedule"]["saturday"]["time_max"]);?></span>
<?php } ?>
<?php }else{ ?>
open all day
<?php } ?>
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
        <?php } ?>

    <?php } ?>
    </div>

    <?php if( $sport_id ){ ?>
        <a href="#" class="add_prom_block"><span class="glyphicon glyphicon-plus"></span> Add Promotion</a>
    <?php } ?>
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
                        <?php if( isset($info) && !empty($info["image"]) && false ){ ?>
                            <div class="gal_img_item">
                                <img class="img_logo" src="/uploads/vendors/<? echo $id;?>/<? echo $info["image"];?>" alt="gallery"/>
                                <span class="del_image_gallery"></span>
                            </div>
                        <?php } ?>
                        <?php foreach( $gallery as $g_item ){ ?>
                            <div class="gal_img_item">
                                <img  src="/uploads/vendors/<? echo $id;?>/p_<? echo $g_item["src"];?>" alt="gallery"/>
                                <span class="del_image_gallery"></span>
                            </div>
                        <?php } ?>
                        <?php foreach( $prom_gallery as $prom_g_item ){ ?>
                            <div class="gal_img_item">
                                <img  src="/uploads/vendors/<? echo $id;?>/p_<? echo $prom_g_item["src"];?>" alt="gallery"/>
                                <span class="del_image_gallery"></span>
                            </div>
                        <?php } ?>
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
                        <? $k = 0;?>
                        <?php foreach( $sports as $count=>$s_item ){ ?>
                            <?php if( $k == 0 ){ ?> <ul> <?php } ?>
                            <li><a href="/admin/vendors/company/<? echo $id;?>/<? echo $s_item["id"];?>" ><? echo $s_item["name"];?></a></li>
                            <? $k = $k + 1 ;?>
                            <?php if( $k == 15 || $count == (count ($sports) -1)  ){ ?> </ul>  <? $k = 0;?><?php } ?>
                        <?php } ?>
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

