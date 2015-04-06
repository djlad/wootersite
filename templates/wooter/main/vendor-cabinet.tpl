<!DOCTYPE html>
<html>
<head lang="en">

    <meta charset="UTF-8">
    <title>Home page</title>

    <!-- JQuery include -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!--Drag&Drop-->
    <script src="/static/default/js/dropzone.js"></script>

    <!--Bootstrap include-->
    <link rel="stylesheet" href="/static/default/css/bootstrap.min.css"/>
    <script src="/static/default/js/bootstrap.min.js"></script>

    <!--Vendor CSS-->
    <link rel="stylesheet" href="/static/default/css/vendor.css"/>

    <!--Accordion-->
    <script src="/static/default/js/accordion.js"></script>

    <!--Main styles include-->
    <link rel="stylesheet" href="/static/default/css/style.css"/>

    <!--Popover CSS-->
    <link rel="stylesheet" href="/static/default/css/jquery.webui-popover.css"/>

    <!--Maps-->
    <script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>

    <!--Validate-->
    <script src="/static/default/js/forms/jquery.validate.js"></script>

    <!--Popover JS-->
    <script src="/static/default/js/jquery.webui-popover.js"></script>

    <!--FancyBox-->
    <link rel="stylesheet" href="/static/default/fancybox/jquery.fancybox.css?v=2.1.5"/>
    <link rel="stylesheet" href="/static/default/fancybox/jquery.fancybox-thumbs.css?v=1.0.7"/>
    <script type="text/javascript" src="/static/default/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript" src="/static/default/fancybox/jquery.fancybox-thumbs.js?v=2.1.5"></script>

    <!--ProgressBar-->
    <script src="/static/default/js/progressbar.js"></script>

    <!--autocomp-->
    <script src="/static/default/js/typeahead.jquery.js"></script>

    <!--Mask-->
    <script src="/static/default/js/jquery.mask.min.js"></script>

    <!--Vendor-JS-->
    <script src="/static/default/js/vendor-cabinet.js" type="text/javascript"></script>


</head>
<body>
<header class="inner_pages">
    <div class="container">

        <div class="col-sm-3">
            <a href="/">
                <img src="/static/default/img/logo.png" class="logo" title="Wooter club"/>
            </a>
        </div>
        <div class="col-sm-9">
            <ul class="nav navbar-nav navbar-right right-header-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img
                                src="/static/default/img/comany.png" alt="company name"/> Company name <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Log out</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="header-menu">
                <li><a href="#">Promotions <span class="count_alert">6</span></a></li>
                <li><a href="#">Wooters</a></li>
                <li><a href="#">Competitions <span class="count_alert">2</span></a></li>
            </ul>
        </div>

    </div>
</header>

<div class="content vendor_page">
<div class="accordion">
    <form action="/vendor-cabinet/ajax/company" class="company_info_form" method="post" id="company-info">
        <div class="vendor_top_line">
            <div class="container">
                <div class="company_logo col-sm-3">
                    <div class="upload_img">
                        <img src="/static/default/img/comany.png" alt="company name"/>
                    </div>
                </div>
                <div class="company_name_e col-md-9">
                    <input type="text" class="company_name" value="" placeholder="Company name" name="name" id="name"/>
                    <a href="#" class="big_button_e fr"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                    <a href="#" class="hide_information fr a_toggle"><span class="caret"></span> Hide additional
                        information</a>
                </div>
            </div>
        </div>
        <div class="edit_company_info a_block a_show">
            <div class="container">
                <div class="col-sm-2">

                </div>
                <div class="col-sm-8">
                    <textarea name="full_description" class="full_description input-texarea"
                              placeholder="Describe your company"></textarea>

                    <div class="clearfix"></div>

                    <div class="company_types">
                        <a href="#" class="c_types_list popover_on" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <input type='checkbox' name='coach' id='coach' class='css-checkbox' />
                                <label for='coach' class='css-label'>Coach</label>
                                <input type='checkbox' name='fitness' id='fitness' class='css-checkbox'/>
                                <label for='fitness' class='css-label'>Fitness</label>
                                <input type='checkbox' name='experience' id='experience' class='css-checkbox'/>
                                <label for='experience' class='css-label'>Experience</label>
                                <input type='checkbox' name='league' id='league' class='css-checkbox'/>
                                <label for='league' class='css-label'>League</label>
                                <input type='checkbox' name='rent_court' id='rent_court' class='css-checkbox'/>
                                <label for='rent_court' class='css-label'>Rent Court</label>
                            </div>"
                           data-container="#company-info">
                            Choose types of company<span class="arrow down"></span>
                        </a>
                    </div>

                    <div class="clearfix"></div>
                    <div class="activities_list">
                        <ul>
                            <li class="activities-input">
                                <input type="text" class="input_add_actv" name="add_activities" value=""
                                       placeholder="Type" style="display: none">
                            </li>
                            <li class="add_activities">
                                <a href="#">
                                    <span class="glyphicon glyphicon-plus"></span>Add
                                </a>
                            </li>
                        </ul>
                        <label class="label-form">Activities</label>
                    </div>

                    <div class="input-group fl">
                        <input type="text" name="phone" class="phone_number input-text" value=""
                               placeholder="(123) 123-123-25"/>
                        <label class="label-form">phone</label>
                    </div>
                    <div class="input-group fl">
                        <input type="email" name="email" class="email input-text" value=""
                               placeholder="your_email@mail.com"/>
                        <label class="label-form">email</label>
                    </div>
                    <div class="clearfix"></div>

                    <div class="map" id="map" style="width: 100%; height: 350px;"></div>
                    <ul class="address_list">
                        <li class="add-address">
                            <a href="#"><span class="glyphicon glyphicon-plus"></span> Add an address</a>
                        </li>
                    </ul>
                    <input type="text" class="address-autocomplete" style="display: none">

                    <div class="clearfix"></div>
                    <hr>

                    <button type="submit" class="send savechanges"><span class="glyphicon glyphicon-ok"></span> Save
                        Changes
                    </button>

                </div>
                <div class="col-sm-2">

                </div>
            </div>
        </div>
    </form>
</div>

<div class="promotion_list">
    <div class="prom_list_header">
        <div class="container">
            <h3 class="fl">Promotions</h3>
            <span class="prom_counts">You have 6 promotions</span>
            <a href="#" class="add_promotion fr"><span class="glyphicon glyphicon-plus"></span> Add new
                promotion</a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="prom_item first-child">
        <div class="container">
            <div class="prom_image fl">
                <img src="/static/default/img/prom_img.jpg" alt="prom-item-name"/>
            </div>
            <div class="prom_name fl">
                <a href="#">Promotion Name</a>
            </div>
            <div class="offers_c fl">
                <span class="offers_cnt">2 offers</span>
            </div>
            <div class="sales_c fl">
                <span class="count_cnt">82 sales</span>
            </div>
            <div class="e_links fl">
                <a class="edit_link"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                <a class="delete_link"><span class="glyphicon glyphicon-pencil"></span> Delete</a>
            </div>
        </div>
    </div>

    <div class="prom_item current" id="prom_id">
        <div class="container">

            <div class="col-sm-5 padding-clear">
                <div class="prom_gallery">
                    <div class="main_prom_image">
                        <a href="/static/default/img/b_prom_img.jpg" class="fancybox-thumb" rel="fancybox-thumb">
                            <img src="/static/default/img/b_prom_img.jpg" alt="prom_title"/>
                        </a>
                    </div>
                    <div class="prom_gallery_list">
                        <ul>
                            <li>
                                <a href="/static/default/img/b_prom_img.jpg" class="fancybox-thumb"
                                   rel="fancybox-thumb">
                                    <img src="/static/default/img/b_prom_img.jpg"/>
                                </a>
                            </li>
                            <li>
                                <a href="/static/default/img/b_prom_img.jpg" class="fancybox-thumb"
                                   rel="fancybox-thumb">
                                    <img src="/static/default/img/b_prom_img.jpg"/>
                                </a>
                            </li>
                            <li>
                                <a href="/static/default/img/b_prom_img.jpg" class="fancybox-thumb"
                                   rel="fancybox-thumb">
                                    <img src="/static/default/img/b_prom_img.jpg"/>
                                </a>
                            </li>
                            <li class="four_th">
                                <a href="/static/default/img/b_prom_img.jpg" class="fancybox-thumb"
                                   rel="fancybox-thumb">
                                    <img src="/static/default/img/b_prom_img.jpg"/>
                                </a>
                            </li>
                            <li>
                                <a href="/static/default/img/b_prom_img.jpg" class="fancybox-thumb"
                                   rel="fancybox-thumb">
                                    <img src="/static/default/img/b_prom_img.jpg"/>
                                </a>
                            </li>
                            <li>
                                <a href="/static/default/img/b_prom_img.jpg" class="fancybox-thumb"
                                   rel="fancybox-thumb">
                                    <img src="/static/default/img/b_prom_img.jpg"/>
                                </a>
                            </li>
                            <li class="download_img">
                                <a href="#download">
                                    <img src="/static/default/img/select_file_s.png"/>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-7 right_prom_side">
                <div class="row_block">
                    <input class="input-text" value="" name="prom_name" placeholder="Promotion name"/>
                </div>
                <div class="row_block">
                    <textarea name="full_description" class="full_description input-texarea" placeholder="Describe your company"></textarea>
                </div>
                <div class="row_block">
                    <div class="activities_list">
                        <ul>
                            <li class="activities-input">
                                <input type="text" class="input_add_actv" name="add_activities" value=""  placeholder="Type" style="display: none">
                            </li>
                            <li class="add_activities">
                                <a href="#">
                                    <span class="glyphicon glyphicon-plus"></span>Add
                                </a>
                            </li>
                        </ul>
                        <label class="label-form">Activities</label>
                    </div>
                </div>
                <hr/>
                <div class="row_block">
                    <div class="col-sm-4">
                        <a href="#" class="p_types_list popover_on" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <input type='checkbox' name='coach' id='coach' class='css-checkbox' />
                                <label for='coach' class='css-label'>Coach</label>
                                <input type='checkbox' name='fitness' id='fitness' class='css-checkbox'/>
                                <label for='fitness' class='css-label'>Fitness</label>
                                <input type='checkbox' name='experience' id='experience' class='css-checkbox'/>
                                <label for='experience' class='css-label'>Experience</label>
                                <input type='checkbox' name='league' id='league' class='css-checkbox'/>
                                <label for='league' class='css-label'>League</label>
                                <input type='checkbox' name='rent_court' id='rent_court' class='css-checkbox'/>
                                <label for='rent_court' class='css-label'>Rent Court</label>
                            </div>"
                           data-container="#prom_id">
                            Choose types<span class="arrow down"></span>
                        </a>
                        <label class="label-form">Types</label>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" class="p_gender_list popover_on" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <input type='checkbox' name='man' id='man' class='css-checkbox' />
                                <label for='man' class='css-label'>Man</label>
                                <input type='checkbox' name='woman' id='woman' class='css-checkbox'/>
                                <label for='woman' class='css-label'>Woman</label>
                                <input type='checkbox' name='unisex' id='unisex' class='css-checkbox'/>
                                <label for='unisex' class='css-label'>Unisex</label>
                            </div>"
                           data-container="#prom_id">
                            Choose gender<span class="arrow down"></span>
                        </a>
                        <label class="label-form">Gender</label>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" class="p_ages_list popover_on" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <div class='left_side_po'>
                                <input type='text' placeholder='0' name='from_age'>
                                <label class='label-form'>from</label>
                                </div>
                                <div class='right_side_po'>
                                <input type='text' placeholder='99' name='to_age'>
                                <label class='label-form'>to</label>
                                </div>
                            </div>"
                           data-container="#prom_id">
                            Choose ages<span class="arrow down"></span>
                        </a>
                        <label class="label-form">Ages</label>
                    </div>
                </div>
                <div class="row_block">
                    <div class="col-sm-12">
                        <ul class="price_list">
                            <li>
                                <input type="text" value="$0" class="price_item" name="price_1"/>
                                <input type="text" value="Price name" class="price_name" name="price_name_2"/>
                                <label class="label-form">Price 1</label>
                            </li>
                            <li>
                                <input type="text" value="$0" class="price_item" name="price_1"/>
                                <input type="text" value="Price name" class="price_name" name="price_name_2"/>
                                <label class="label-form">Price 2</label>
                            </li>
                            <li class="add_price">
                                <button type="button" class="add_price_button"><span class="glyphicon glyphicon-plus"></span>Add new offer</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row_block">
                    <div class="col-sm-12">
                        <a href="#" class="p_ages_list popover_on" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <input type='checkbox' name='address1' id='address1' class='css-checkbox' />
                                <label for='address1' class='css-label'>Address 1</label>
                                <input type='checkbox' name='address2' id='address2' class='css-checkbox'/>
                                <label for='address2' class='css-label'>Address 2</label>
                            </div>"
                           data-container="#prom_id">
                            Choose address<span class="arrow down"></span>
                        </a>
                        <label class="label-form">Address</label>
                    </div>
                </div>
                <div class="row_block schedule">
                    <div class="col-sm-4">
                        <a href="#" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <div class='left_side_po'>
                                <input type='text' placeholder='0' name='from_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>from</label>
                                </div>
                                <div class='right_side_po'>
                                <input type='text' placeholder='99' name='to_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>to</label>
                                </div>
                            </div>"
                           data-container="#prom_id">
                            6:30am – 1:30pm
                        </a>
                        <label class="label-form">mon</label>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <div class='left_side_po'>
                                <input type='text' placeholder='0' name='from_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>from</label>
                                </div>
                                <div class='right_side_po'>
                                <input type='text' placeholder='99' name='to_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>to</label>
                                </div>
                            </div>"
                           data-container="#prom_id">
                            6:30am – 1:30pm
                        </a>
                        <label class="label-form">tue</label>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <div class='left_side_po'>
                                <input type='text' placeholder='0' name='from_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>from</label>
                                </div>
                                <div class='right_side_po'>
                                <input type='text' placeholder='99' name='to_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>to</label>
                                </div>
                            </div>"
                           data-container="#prom_id">
                            6:30am – 1:30pm
                        </a>
                        <label class="label-form">wed</label>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <div class='left_side_po'>
                                <input type='text' placeholder='0' name='from_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>from</label>
                                </div>
                                <div class='right_side_po'>
                                <input type='text' placeholder='99' name='to_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>to</label>
                                </div>
                            </div>"
                           data-container="#prom_id">
                            6:30am – 1:30pm
                        </a>
                        <label class="label-form">thu</label>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <div class='left_side_po'>
                                <input type='text' placeholder='0' name='from_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>from</label>
                                </div>
                                <div class='right_side_po'>
                                <input type='text' placeholder='99' name='to_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>to</label>
                                </div>
                            </div>"
                           data-container="#prom_id">
                            6:30am – 1:30pm
                        </a>
                        <label class="label-form">fri</label>
                    </div>
                    <div class="col-sm-4"> </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-4">
                        <a href="#" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <div class='left_side_po'>
                                <input type='text' placeholder='0' name='from_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>from</label>
                                </div>
                                <div class='right_side_po'>
                                <input type='text' placeholder='99' name='to_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>to</label>
                                </div>
                            </div>"
                           data-container="#prom_id">
                            6:30am – 1:30pm
                        </a>
                        <label class="label-form">sat</label>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" rel="popover"
                           data-content="
                           <div class='custom_form'>
                                <div class='left_side_po'>
                                <input type='text' placeholder='0' name='from_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>from</label>
                                </div>
                                <div class='right_side_po'>
                                <input type='text' placeholder='99' name='to_age'>
                                <div class='time_half'>
                                    <a href='#'>am</a>
                                    <a href='#'>pm</a>
                                </div>
                                <label class='label-form'>to</label>
                                </div>
                            </div>"
                           data-container="#prom_id">
                            6:30am – 1:30pm
                        </a>
                        <label class="label-form">sun</label>
                    </div>
                    <div class="col-sm-4"></div>
                </div>

            </div>
            <div class="clearfix"></div>
            <hr/>
            <button type="submit" class="send savechanges"><span class="glyphicon glyphicon-ok"></span> Save
                Changes
            </button>
        </div>
    </div>

    <div class="prom_item">
        <div class="container">
            <div class="prom_image fl">
                <img src="/static/default/img/prom_img.jpg" alt="prom-item-name"/>
            </div>
            <div class="prom_name fl">
                <a href="#">Promotion Name</a>
            </div>
            <div class="offers_c fl">
                <span class="offers_cnt">2 offers</span>
            </div>
            <div class="sales_c fl">
                <span class="count_cnt">82 sales</span>
            </div>
            <div class="e_links fl">
                <a class="edit_link"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                <a class="delete_link"><span class="glyphicon glyphicon-pencil"></span> Delete</a>
            </div>
        </div>
    </div>
    <div class="prom_item">
        <div class="container">
            <div class="prom_image fl">
                <img src="/static/default/img/prom_img.jpg" alt="prom-item-name"/>
            </div>
            <div class="prom_name fl">
                <a href="#">Promotion Name</a>
            </div>
            <div class="offers_c fl">
                <span class="offers_cnt">2 offers</span>
            </div>
            <div class="sales_c fl">
                <span class="count_cnt">82 sales</span>
            </div>
            <div class="e_links fl">
                <a class="edit_link"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                <a class="delete_link"><span class="glyphicon glyphicon-pencil"></span> Delete</a>
            </div>
        </div>
    </div>
    <div class="prom_item">
        <div class="container">
            <div class="prom_image fl">
                <img src="/static/default/img/prom_img.jpg" alt="prom-item-name"/>
            </div>
            <div class="prom_name fl">
                <a href="#">Promotion Name</a>
            </div>
            <div class="offers_c fl">
                <span class="offers_cnt">2 offers</span>
            </div>
            <div class="sales_c fl">
                <span class="count_cnt">82 sales</span>
            </div>
            <div class="e_links fl">
                <a class="edit_link"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                <a class="delete_link"><span class="glyphicon glyphicon-pencil"></span> Delete</a>
            </div>
        </div>
    </div>
</div>

</div>

<footer>
    <div class="container">

        <div class="col-sm-5">
            <a href="/" alt="wooter">
                <img src="/static/default/img/footer_logo.png"/>
            </a>

            <p>
                Hugiat nulla nunc ut tellus. Nullam convallis sed massa vitae maximus sedquis eros posuere, porta justo
                in, aliquam . Nullam pellentesque fringilla augue, et sollicitudin lectus pellentesque.
            </p>
        </div>
        <div class="col-sm-4 f_menu">
            <ul class="footer_menu">
                <li><a href="#">Company</a></li>
                <li><a href="#">About Wooter</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Press</a></li>
            </ul>
            <ul class="footer_menu">
                <li><a href="#">For Vendors</a></li>
                <li><a href="#">Register</a></li>
                <li><a href="#">How it workd</a></li>
                <li><a href="#">Pricing</a></li>
            </ul>
        </div>
        <div class="col-sm-3">
            <h3>Follow US</h3>
            <a href="#" class="social_icon facebook"></a>
            <a href="#" class="social_icon twitter"></a>
            <a href="#" class="social_icon linkin"></a>

            <p>©2015 Copyrighted by Wooter LLC</p>
        </div>

    </div>
</footer>

</body>
</html>