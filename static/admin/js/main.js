$(document).ready(function () {

    var KEYCODE_ENTER = 13;
    var KEYCODE_ESC = 27;

    $('.text_full_desc').wysihtml5({
        "image": false //Button to insert an image. Default true,
    });

    $('.gen-url').bind('click', function () {

        $($(this).attr("data-target")).val(ru2en.translit($($(this).attr("data-src")).val()));

    });

    if ($('#admin-pswd-edit').length > 0) {

        $('#admin-pswd-edit')
            .validate({
                'pswd': {
                    required: true
                },
                're_pswd': {
                    required: true,
                    callback: 'matchPswd'
                }

            }, callBackOnSuccess, callBackOnError);

    }

    if ($('#user-add').length > 0) {

        $('#user-add')
            .validate({
                'email': {
                    required: true,
                    regexp: 'email',
                    callback: "checkEmail"
                },
                'pswd': {
                    required: true
                },
                're_pswd': {
                    required: true,
                    callback: 'matchPswd'
                },
                'first_name': {
                    required: true
                },
                'last_name': {
                    required: true
                }

            }, callBackOnSuccess, callBackOnError);

    }

    if ($('#vendor-add').length > 0) {

        $('#vendor-add')
            .validate({
                'email': {
                    required: true,
                    regexp: 'email',
                    callback: "checkVendorEmail"
                },
                'pswd': {
                    required: true
                },
                're_pswd': {
                    required: true,
                    callback: 'matchPswd'
                },
                'first_name': {
                    required: true
                },
                'last_name': {
                    required: true
                }

            }, callBackOnSuccess, callBackOnError);

    }

    if ($('#vendor-edit').length > 0) {

        $('#vendor-edit')
            .validate({
                'email': {
                    required: true,
                    regexp: 'email',
                    callback: "checkVendorEmailDublicate"
                },
                're_pswd': {
                    callback: 'matchPswd'
                }

            }, callBackOnSuccess, callBackOnError);

    }

    if ($('#sport-add').length > 0) {

        $('#sport-add')
            .validate({
                'name': {
                    required: true
                },
                'url': {
                    required: true,
                    regexp: 'url',
                    callback: "checkSportsUrl"
                }

            }, callBackOnSuccess, callBackOnError);

    }

    if ($('#sport-edit').length > 0) {

        $('#sport-edit')
            .validate({
                'name': {
                    required: true
                },
                'url': {
                    required: true,
                    regexp: 'url',
                    callback: "checkSportsUrlDub"
                }

            }, callBackOnSuccess, callBackOnError);

    }

    if ($('#vendor-add-section').length > 0) {

        $('#vendor-add-section')
            .validate({
                'name': {
                    required: true
                },
                'url': {
                    required: true,
                    regexp: 'url',
                    callback: "checkSectionUrl"
                }

            }, callBackOnSuccess, callBackOnError);

    }

    if ($('#vendor-add-sport').length > 0) {

        $('#vendor-add-sport')
            .validate({
                'vendor_id': {
                    required: true
                },
                'sport_id': {
                    required: true
                }
            }, callBackOnSuccess, callBackOnError);

    }

    if ($('#vendor-edit-sport').length > 0) {

        $('#vendor-edit-sport')
            .validate({
                'vendor_id': {
                    required: true
                },
                'sport_id': {
                    required: true
                }
            }, callBackOnSuccess, callBackOnError);

    }


    if ($('#you-doing-add').length > 0) {

        $('#you-doing-add')
            .validate({
                'title': {
                    required: true
                },
                'description': {
                    required: true
                }
            }, callBackOnSuccess, callBackOnError);

    }

    $('input').click(function () {

        $(this).parent().removeClass('has-error');

    });

    $('input').keypress(function () {

        $(this).parent().removeClass('has-error');

    });

    $('#direct-edit-msg').delegate('.close', 'click', function () {
        $(this).parent().hide()
    });

    $(".delete").click(function () {

        var self = $(this);

        confirmAction(self.parents('table').attr('data-msg'), function () {

            var target = self.parents('table').attr('data-target');
            var id = self.parents('tr').attr('data-id');
            $.ajax({
                url: target,
                type: "POST",
                data: {
                    act: 'delete',
                    id: id
                },
                dataType: "json",
                success: function (data) {

                    if (data.status == 'ok') {

                        self.parents('tr').find('td').slideUp('fast', function () {

                            $(this).remove();

                        });

                    } else {

                        showAlert("Unable to delete a record");

                    }

                },
                error: function () {

                    showAlert("Unable to delete a record");

                }
            });

        });


        return false;

    });

    $('.add_promotion').click(function () {

        var arr = $('.prom_ids > .row');
        var index = !($(arr[(arr.length - 1)]).attr('data-id')) ? 1 : parseInt($(arr[(arr.length - 1)]).attr('data-id')) + 1;

        var name = '<div class="form-group control-label"><label class="col-sm-2 control-label">Name</label><div class="col-sm-3 controls"><input type="text" name="promotion[' + index + '][name]" class="form-control"></div></div>';
        var slider = '<div class="form-group control-label"><label class="col-sm-2 control-label">Age Group</label><div class="col-sm-3 controls"><p><label for="amount">Age range:&nbsp;</label><input type="text" class="amount" readonly style="border:0; color:#f6931f; font-weight:bold;"><input type="hidden" class="age_min" name="promotion[' + index + '][age_min]" readonly><input type="hidden" class="age_max" name="promotion[' + index + '][age_max]" readonly ></p><div class="slider-range"></div></div></div>';
        var skill = '<div class="form-group control-label"><label class="col-sm-2 control-label">Skill Level</label><div class="col-sm-3 controls"><div class="radio"><input name="promotion[' + index + '][skill]" value="1" type="checkbox">&nbsp;Yes&nbsp;</label></div></div></div>';
        var time = '<div class="form-group control-label"><label class="col-sm-2 control-label">Schedule</label><div class="col-sm-3 controls"><div><p><label for="amount">monday :</label><input type="text" class="time-date" readonly="" style="border:0; color:#f6931f; font-weight:bold;"><input type="hidden" class="time_min" name="promotion[' + index + '][schedule][monday][time_min]" readonly=""><input type="hidden" class="time_max" name="promotion[' + index + '][schedule][monday][time_max]" readonly=""></p><div class="slider-time"></div></div><div><p><label for="amount">tuesday :</label><input type="text" class="time-date" readonly="" style="border:0; color:#f6931f; font-weight:bold;"><input type="hidden" class="time_min" name="promotion[' + index + '][schedule][tuesday][time_min]" readonly=""><input type="hidden" class="time_max" name="promotion[' + index + '][schedule][tuesday][time_max]" readonly=""></p><div class="slider-time"></div></div><div><p><label for="amount">wednesday :</label><input type="text" class="time-date" readonly="" style="border:0; color:#f6931f; font-weight:bold;"><input type="hidden" class="time_min" name="promotion[' + index + '][schedule][wednesday][time_min]" readonly=""><input type="hidden" class="time_max" name="promotion[' + index + '][schedule][wednesday][time_max]" readonly=""></p><div class="slider-time"></div></div><div><p><label for="amount">thursday :</label><input type="text" class="time-date" readonly="" style="border:0; color:#f6931f; font-weight:bold;"><input type="hidden" class="time_min" name="promotion[' + index + '][schedule][thursday][time_min]" readonly=""><input type="hidden" class="time_max" name="promotion[' + index + '][schedule][thursday][time_max]" readonly=""></p><div class="slider-time"></div></div><div><p><label for="amount">friday :</label><input type="text" class="time-date" readonly="" style="border:0; color:#f6931f; font-weight:bold;"><input type="hidden" class="time_min" name="promotion[' + index + '][schedule][friday][time_min]" readonly=""><input type="hidden" class="time_max" name="promotion[' + index + '][schedule][friday][time_max]" readonly=""></p><div class="slider-time"></div></div><div><p><label for="amount">saturday :</label><input type="text" class="time-date" readonly="" style="border:0; color:#f6931f; font-weight:bold;"><input type="hidden" class="time_min" name="promotion[' + index + '][schedule][saturday][time_min]" readonly=""><input type="hidden" class="time_max" name="promotion[' + index + '][schedule][saturday][time_max]" readonly=""></p><div class="slider-time"></div></div><div><p><label for="amount">sunday :</label><input type="text" class="time-date" readonly="" style="border:0; color:#f6931f; font-weight:bold;"><input type="hidden" class="time_min" name="promotion[' + index + '][schedule][sunday][time_min]" readonly=""><input type="hidden" class="time_max" name="promotion[' + index + '][schedule][sunday][time_max]" readonly=""></p><div class="slider-time"></div></div></div></div>		';
        var button = '<button type="button" class="btn btn-primary add_price"> <i class="fa fa-plus"></i> Add Price </button>';
        var price = '<div class="form-panel price-panel"></div>';
        var gender = '<div class="form-group control-label"><label class="col-sm-2 control-label">Gender</label><div class="col-sm-3 controls"><select name="promotion[' + index + '][gender]" class="form-control"><option value = "all">All</option><option value = "male">Male</option><option value = "female">Female</option></select></div></div>';
        var category = '<div class="form-group control-label"><label class="col-sm-2 control-label">Sub Category</label><input type="checkbox" name="promotion[' + index + '][sub_1]" value="rent">&nbsp;Rent Any Court&nbsp;</label><input type="checkbox" name="promotion[' + index + '][sub_2]" value="experience">&nbsp;Experience&nbsp;</label><input type="checkbox" name="promotion[' + index + '][sub_3]" value="coach">&nbsp;Coach&nbsp;</label><input type="checkbox" name="promotion[' + index + '][sub_4]" value="league">&nbsp;League&nbsp;</label><input type="checkbox" name="promotion[' + index + '][sub_5]" value="personal" >&nbsp;Personal Fitness&nbsp;</label></div>';
        var s_desc = '<div class="form-group control-label"><label class="col-sm-2 control-label">Short Description</label><div class="col-sm-10 controls"><textarea class="form-control" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="promotion[' + index + '][s_desc]"></textarea></div></div>';
        var f_desc = '<div class="form-group control-label"><label class="col-sm-2 control-label">Full Description</label><div class="col-sm-10 controls"><textarea class="form-control" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="promotion[' + index + '][f_desc]"></textarea></div></div>';
        var append = '<div class="row mt" data-id="' + index + '"><div class="col-lg-12"><div class="form-panel"><h4><i class="fa fa-angle-right"></i> Promotion ' + index + '</h4><a href="#" class="delete_prom">delete</a>' + name + slider + skill + gender + category + time + s_desc + f_desc + button + price + '</div></div></div>';
        $('.prom_ids').append(append);

        $(".slider-range").slider({
            range: true,
            min: 0,
            max: 100,
            slide: function (event, ui) {


                if (ui.values[0] == ui.values[1])
                    return false;

                $(this).parent().find('.amount').val(ui.values[0] + " - " + ui.values[1]);
                $(this).parent().find('.age_min').val(ui.values[0]);
                $(this).parent().find('.age_max').val(ui.values[1]);

            }
        });

        $(".slider-time").slider({
            range: true,
            min: 0,
            max: 1440,
            step: 30,
            slide: function (event, ui) {

                var val1 = ui.values[0];
                var val2 = ui.values[1];

                var h_min = Math.floor(val1 / 60);
                var h_max = Math.floor(val2 / 60);

                var m_min = val1 - (h_min * 60);
                var m_max = val2 - (h_max * 60);

                if (val1 == val2)
                    return false;

                $(this).parent().find('.time-date').val(getTime(h_min, m_min) + " - " + getTime(h_max, m_max));

                $(this).parent().find('.time_min').val(val1);
                $(this).parent().find('.time_max').val(val2);

            }
        });

    });

    $(document).on('click', '.add_price', function () {

        var index = $(this).parent().parent().parent().attr('data-id');

        var arr = $(this).parent().parent().parent().children().find('.price');

        var price_index = !($(arr[(arr.length - 1)]).attr('data-id')) ? 1 : parseInt($(arr[(arr.length - 1)]).attr('data-id')) + 1;

        var name = '<div class="form-group control-label"><label class="col-sm-2 control-label">Name</label><div class="col-sm-3 controls"><input type="text" name="promotion[' + index + '][price][' + price_index + '][name]" class="form-control"></div></div>';
        var old_price = '<div class="form-group control-label"><label class="col-sm-2 control-label">Old Price</label><div class="col-sm-2 controls"><input type="text" name="promotion[' + index + '][price][' + price_index + '][old_price]" class="form-control"></div></div>';
        var new_price = '<div class="form-group control-label"><label class="col-sm-2 control-label">New Price</label><div class="col-sm-2 controls"><input type="text" name="promotion[' + index + '][price][' + price_index + '][new_price]" class="form-control"></div></div>';

        var append = '<div class="price" data-id="' + price_index + '"><h4><i class="fa fa-angle-right"></i> Price ' + price_index + '</h4><a href="#" class="delete_price">delete</a>' + name + old_price + new_price + '</div>';

        $(this).parent().find('.price-panel').append(append);

    });

    $(document).on('click', '.delete_price', function () {

        $(this).parent().remove();

        return false;

    });

    $('.delete_pay').click(function () {

        var id = $('.info_panel').attr('data-id');

        confirmAction("Delete Purchase ?", function () {

            $.ajax({
                url: '/admin/ajax/purchase/delete/' + id,
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (data) {

                    if (data.status == 'ok') {

                        window.location.href = '/admin';

                    } else {

                        showAlert("Unable to delete a record");

                    }

                },
                error: function () {

                    showAlert("Unable to delete a record");

                }
            });

        });

    });

    $('.confirm_pay').click(function () {

        var id = $('.info_panel').attr('data-id');

        confirmAction("Confirm Purchase ?", function () {

            $.ajax({
                url: '/admin/ajax/purchase/confirm/' + id,
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (data) {

                    if (data.status == 'ok') {

                        window.location.href = '/admin';

                    } else {

                        showAlert("Unable to confirm a record");

                    }

                },
                error: function () {

                    showAlert("Unable to confirm a record");

                }
            });

        });

    });

    /*$(document).on('click', '.add_price_button', function(){

     var append_block = '<div class="item_price"><div class="price_delete_button"></div><div class="col-sm-3 padding_clear"><div class="i-edit-price-d"><div class="edit_text price_inputs"></div><div class="price_attr"><b>old</b>$</div><span class="edit_price" data-url="/admin/vendors/ajax/promPrice" data-name="old_price" title="Click to edit..."></span></div></div><div class="col-sm-3 padding_clear"><div class="i-edit-price-d"><div class="edit_text price_inputs"></div><div class="price_attr"><b>new</b>$</div><span class="edit_price" data-url="/admin/vendors/ajax/promPrice" data-name="new_price" title="Click to edit..."></span></div></div><div class="col-sm-3 padding_clear"><div class="i-edit-discount" title="Click to edit..."><div class="edit_text price_inputs">0</div><div class="price_attr"><b>discount</b>$</div><span class="edit_price" data-url="/admin/vendors/ajax/promPrice" data-name="discount" title="Click to edit..."></span></div></div> <div class="clearfix"></div> <div class="price_description_wrap"><div class="t-edit-price-d"><div class="price_description edit_text"></div><span class="edit_textarea_prom edit_textarea" data-url="/admin/vendors/ajax/promPrice" data-name="name" title="Click to edit..."></span></div></div></div>';

     $(this).next().find(".price_slider_inner").prepend(append_block);

     $(".prom_price_slider").jcarousel('reload', {});

     $(this).next().jcarousel('scroll', '0');


     $('.i-edit-price-d').editable('',
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

     if (typeof res.id != 'undefined'){

     $(t).parents().find('.item_price').attr('data-id', res.id);

     }

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
     $(n).html(val*(data/100));

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

     $('.t-edit-price-d').editable('',
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

     if (typeof res.id != 'undefined'){

     $(t).parents().find('.item_price').attr('data-id', res.id);

     }

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

     });*/

    $(document).on('click', '.price_delete_button', function () {

        var price_id = $(this).parents('.item_price').attr('data-id');
        var self = $(this);

        self.parents('.prom_price_slider').jcarousel('reload', {});


        if (typeof price_id != 'undefined') {
            confirmAction("Are you sure you wish to delete this offer?", function () {
                $.ajax({
                    async: false,
                    url: '/admin/vendors/ajax/deletePrice',
                    method: 'POST',
                    dataType: 'json',
                    data: {id: price_id},
                    success: function (res) {

                        if (res.status == 'success') {

                            self.parent().remove();
                            $(".price_slider_inner").change();


                        }

                    }
                });
            });

        } else {

            self.parent().remove();
            $(".price_slider_inner").change();

        }

        return false;

    });

    $(".fancybox-thumb").fancybox({
        prevEffect: 'none',
        nextEffect: 'none',
        helpers: {
            title: {
                type: 'outside'
            },
            thumbs: {
                width: 50,
                height: 50
            }
        }
    });

    $('[class ^= "fancybox-thum-"]').fancybox({
        prevEffect: 'none',
        nextEffect: 'none',
        helpers: {
            title: {
                type: 'outside'
            },
            thumbs: {
                width: 50,
                height: 50
            }
        }
    });

    $(document).on('click', '.delete_prom', function () {

        var self = $(this);
        prom_id = self.parents('.prom_id').attr('data-id');
        prom_row = self.parents('.prom_id');

        confirmAction("Are you sure you wish to delete this promotion?", function () {

            $.ajax({
                type: "POST",
                url: '/admin/vendors/ajax/deletePromotion/' + prom_id,
                dataType: "json",
                success: function (res) {

                    if (res.status == 'success') {

                        prom_row.slideUp('fast', function () {

                            prom_row.remove();

                        });

                    }

                },

                error: function (res) {

                    alert(1);

                }
            });


        });
        return false;
    });

    $(document).on('click', '.delete_sport', function () {

        var self = $(this).parent();

        var this_sport_id = $(self).attr('data-id');

        confirmAction("Are you sure you wish to delete this activity?", function () {

            $.ajax({
                type: "POST",
                url: '/admin/vendors/ajax/deleteSport/' + id + '/' + this_sport_id,
                dataType: "json",
                success: function (res) {

                    if (res.status == 'success') {

                        self.slideUp('fast', function () {

                            self.remove();
                            if (this_sport_id == sport_id)
                                location.href = '/admin/vendors/company/' + id;

                        });

                    }

                },

                error: function (res) {


                }
            });


        });
        return false;

    });

    //Change color

    $(document).on('change', '.prom_colors', function () {

        prom_id = $(this).attr('prom-id');
        var self = $(this);

        $.ajax({
            type: "POST",
            url: "/admin/vendors/ajax/changeColor",
            data: {id: prom_id, color: self.val()},
            dataType: "json",
            success: function (res) {

                if (res.status == 'success') {

                    switch (self.val()) {

                        case 'red' :
                            row.attr('class', 'btn btn-danger');
                            break
                        case 'yellow' :
                            row.attr('class', 'btn btn-warning');
                            break
                        case 'green' :
                            row.attr('class', 'btn btn-success');
                            break

                    }

                } else {

                    alert('fail');

                }

            },

            error: function (res) {

                alert('error');

            }


        });

    });


    $('[data-toggle="popover"]').popover({
        html: true
    });

    $('[data-toggle="popover"]').on('show.bs.popover', function () {

        row = $(this);

        $('[data-toggle="popover"]').not(this).popover('hide');

    });

    //KEYCODE_ESC = 27

    $(document).keyup(function (e) {
        if (e.keyCode == KEYCODE_ESC) {
            $('[data-toggle="popover"]').popover('hide');
        }

    });

    $(document).on('focusout', '.prom_age_min', function () {

        var prom_id = $(this).parents('.prom_id').attr('data-id');
        var val = $(this).val();

        $.ajax({ //Save Ages
            type: "POST",
            url: '/admin/vendors/ajax/editPromAges/' + prom_id,
            dataType: "json",
            data: {name: 'age_min', value: val},

            success: function (res) {
            }

        });


    });

    $(document).on('focusout', '.prom_age_max', function () {

        var prom_id = $(this).parents('.prom_id').attr('data-id');
        var val = $(this).val();

        $.ajax({ //Save Ages
            type: "POST",
            url: '/admin/vendors/ajax/editPromAges/' + prom_id,
            dataType: "json",
            data: {name: 'age_max', value: val},

            success: function (res) {
            }

        });

    });

    $(document).on('click', '.add_price_form > button', function () {

        $(this).submit();

    });

    $(document).on('submit', '.add_price_form', function () {

        var self = $(this);
        var worldNotReal = true;
        var data = $(self).serialize();
        var prom_id = $(this).parents('.prom_id').attr('data-id');
        var prom_row = $(this).parents('.prom_id');

        $(this).find('input, textarea').each(function () {

            if (!$(this).hasClass('discount_perc')) {

                if ($(this).val().length <= 0 || parseInt($(this).val()) == 0) {

                    $(this).addClass('has-error');

                    worldNotReal = false;

                }

            }

        });

        if (!worldNotReal) {
            return true;
        }

        $.ajax({
            type: "POST",
            url: '/admin/vendors/ajax/addPrice/' + prom_id,
            dataType: "json",
            data: data,
            async: false,

            success: function (res) {

                if (res.status == 'success') {

                    $('[data-toggle="popover"]').popover('hide');

                    var data = res.data;

                    var text = '<div data-id="' + data.price_id + '" class="item_price"><span class="price_delete_button"></span><div class="col-sm-12 price_line"><span class="new_price_i">Final price: $' + data.final_price + '</span><span class="discount_i">' + (data.discount_perc != 0 ? "Discount: " + data.discount_perc + "%" : "") + '</span></div><div class="clearfix"></div><div class="price_description_wrap"><div class="t-edit-price" title="Click to edit..."><div class="price_description">' + data.description_price + '</div></div></div><a href="#" data-toggle="modal" data-target="#edit_price" class="edit_price">Edit price</a></div>';


                    var slider = $(prom_row).find('.prom_price_slider');
                    var inner = $(prom_row).find('.price_slider_inner');


                    $('.prom_price_slider' + prom_id).jcarousel('reload', {});

                    $('.prom_price_slider' + prom_id).jcarousel('scroll', '0');

                    $(inner).prepend(text);

                }

            }

        });

        return false;

    });


    $(document).on('click', '.edit_price', function () {

        var self = $(this);
        price_row = self.parent();
        price_id = price_row.attr('data-id');
        var modal = $('.edit_price_form');

        $.ajax({
            type: "POST",
            url: '/admin/vendors/ajax/getPrice/' + price_id,
            dataType: "json",
            async: false,
            success: function (res) {

                if (res && res != 'false') {

                    modal.find('.standart_price').val(res.old_price);
                    modal.find('.final_price').val(res.new_price);
                    modal.find('.discount_perc').val(res.discount);
                    modal.find('.description_price').val(res.name);

                }

            }
        });

    });

    $(document).on('click', '.edit_price_form > button', function () {

        $(this).submit();

    });

    $(document).on('submit', '.edit_price_form', function () {

        var self = $(this);
        var data = $(self).serialize();
        var worldNotReal = true;

        $(this).find('input, textarea').each(function () {

            if (!$(this).hasClass('discount_perc')) {

                if ($(this).val().length <= 0 || parseInt($(this).val()) == 0) {

                    $(this).addClass('has-error');

                    worldNotReal = false;

                }
            }

        });

        if (!worldNotReal) {
            return true;
        }

        $.ajax({
            type: "POST",
            url: '/admin/vendors/ajax/editPrice/' + price_id,
            dataType: "json",
            data: data,
            async: false,

            success: function (res) {

                if (res.status == 'success') {

                    var data = res.data;

                    $('#edit_price').modal('hide');

                    price_row.find('.new_price_i').html(data.new_price);
                    price_row.find('.old_price_i').html(data.old_price);
                    price_row.find('.discount_i').html(data.discount);
                    price_row.find('.price_description').html(data.name);

                }

            }

        });

        return false;

    });

    //ADD PRICE

    $('[data-toggle="popover"]').on('shown.bs.popover', function () {

        $('.add_price_form input[type=text]').keyup(function () {

            discout = $('.discount_perc');
            final = $('.final_price');
            standart = $('.standart_price');
            self = $(this);

            if (discout.val() == "0" || discout.val() == "") {
                final.val(standart.val());
            }
            else {
                price = standart.val() - (standart.val() / 100 * discout.val());
                final.val(price);
            }
            if (parseInt(discout.val()) > 100) {
                return false;
            }
            if (standart.val().length && (discout.val().length || final.val().length)) {

                if ($(this).attr('class') == "discount_perc") {
                    price = standart.val() - (standart.val() / 100 * discout.val());
                    final.val(price);
                }

            }


        });

    });

    $('#edit_price').on('shown.bs.modal', function (e) {
        $('.edit_price_form input[type=text]').keyup(function () {

            discout = $('.discount_perc');
            final = $('.final_price');
            standart = $('.standart_price');
            self = $(this);

            if (discout.val() == "0" || discout.val() == "") {
                final.val(standart.val());
            }
            else {
                price = standart.val() - (standart.val() / 100 * discout.val());
                final.val(price);
            }
            if (parseInt(discout.val()) > 100) {
                return false;
            }
            if (standart.val().length && (discout.val().length || final.val().length)) {

                if ($(this).attr('class') == "discount_perc") {
                    price = standart.val() - (standart.val() / 100 * discout.val());
                    final.val(price);
                }
                if ($(this).attr('class') == "final_price") {
                    price = standart.val() - (final.val() / 100 * standart.val());
                    discout.val(price);
                }
            }


        });
    })

});

callBackOnSuccess = function () {

    var self = $(this);

    ajaxForm(self, function (res) {

        if (res.status == 'ok') {

            var redirect = self.attr('data-redirect');

            if (redirect) {
                if (res.id != undefined && res.code != undefined)
                    window.location.href = redirect + res.id + '/' + res.code;
                else {
                    if (res.id != undefined)
                        window.location.href = redirect + res.id;
                    else
                        window.location.href = redirect;
                }
            }

            self.find('input[type="password"]').each(function () {

                $(this).val('');
            });

        }

    });


}

callBackOnError = function (errors) {

    var focused = 0;

    $('form').find('input, select, textarea').each(function () {

        var self = $(this);
        var id = self.attr('id');
        var errorDiv = self.parents('div.form-group');

        if (typeof(errors[id]) != 'undefined') {

            errorDiv.addClass('error');

            if (focused == 0) {

                self.focus();
                focused++;

            }

            if (errorDiv.find('.help-inline').length == 0) {

                errorDiv.find('.controls').append('<span class="help-inline" style="display:none;">' + errors[id] + '</span>');
                errorDiv.find('.controls').addClass('has-error');

                errorDiv.find('.help-inline').fadeIn(400);

            } else {

                errorDiv.find('.help-inline').html(errors[id]);
                errorDiv.find('.controls').addClass('has-error');

            }

        } else {

            errorDiv.find('.controls').removeClass('has-error');
            errorDiv.find('.controls').find('.help-inline').remove();

        }

    });

}

function ajaxForm(form, successCallback, isDebug) {

    var url = form.attr('action');
    var method = form.attr('method');
    var disabled = form.find(':input:disabled').prop('disabled', false);
    var data = form.serialize();
    disabled.prop('disabled', true);

    if (isDebug) {

        type = 'text';

    } else {

        type = 'json';

    }

    $.ajax({
        url: url,
        method: method,
        dataType: type,
        data: data,
        async: false,
        success: function (res) {

            if (typeof successCallback == 'function') {

                successCallback(res);

            }

        },
        error: function (error, err) {

            if (isDebug) {

                console.log(err);

            }

        }
    });
}

function matchPswd() {

    var pswd = $('#pswd').val();
    var re_pswd = $('#re_pswd').val();

    if (pswd === re_pswd) {
        return true;
    } else {
        return false;
    }

}

function checkEmail() {

    var result;
    var email = $('#email').val();

    $.ajax({
        url: '/admin/users/ajax/checkEmail',
        method: 'POST',
        dataType: 'json',
        async: false,
        data: {email: email},
        success: function (res) {

            result = (res.exists ? false : true);

        }

    });

    return result;

}

function checkVendorEmail() {

    var result;
    var email = $('#email').val();

    $.ajax({
        url: '/admin/vendors/ajax/checkEmail',
        method: 'POST',
        dataType: 'json',
        async: false,
        data: {email: email},
        success: function (res) {

            result = (res.exists ? false : true);

        }

    });

    return result;

}

function checkVendorEmailDublicate(email) {

    var result;

    var id = $('#id').val();

    $.ajax({
        url: '/admin/vendors/ajax/checkEmailDublicate',
        method: 'POST',
        dataType: 'json',
        async: false,
        data: {email: email, id: id},
        success: function (res) {

            result = (res.exists ? false : true);

        }

    });

    return result;

}

function checkSportsUrl() {

    var result;
    var url = $('#url').val();

    $.ajax({
        url: '/admin/sports/ajax/checkUrl',
        method: 'POST',
        dataType: 'json',
        async: false,
        data: {url: url},
        success: function (res) {

            result = (res.exists ? false : true);

        }

    });

    return result;

}

function checkSectionUrl() {

    var result;
    var url = $('#url').val();
    var id = $('#vendor-add-section').attr('data-id');

    $.ajax({
        url: '/admin/vendors/ajax/checkSectionUrl',
        method: 'POST',
        dataType: 'json',
        async: false,
        data: {url: url, id: id},
        success: function (res) {

            result = (res.exists ? false : true);

        }

    });

    return result;

}

function checkSportsUrlDub() {

    var result;
    var url = $('#url').val();
    var id = $('#sport-edit').attr('data-id');

    $.ajax({
        url: '/admin/sports/ajax/checkUrlDub',
        method: 'POST',
        dataType: 'json',
        async: false,
        data: {url: url, id: id},
        success: function (res) {

            result = (res.exists ? false : true);

        }

    });

    return result;

}

var ru2en = {
    ru_str: 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя &\\/.,();' +
    'ÄäÖöÜüßËëÏïÜüŸÿÂâÊêÎîÔôÛûÀàÈèÙùÉéÓóĄąĆćĘęŁłŃńŚśŹźÑñ',
    en_str: ['A', 'B', 'V', 'G', 'D', 'E', 'JO', 'ZH', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'CH', 'SH', 'SHH', '', 'I', '', 'E', 'JU', 'JA', 'a', 'b', 'v', 'g', 'd', 'e', 'jo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shh', '', 'i', '', 'e', 'ju', 'ja', '-', 'and', '-', '-', '', '', '-', '-', '-', 'A', 'a', 'O', 'o', 'U', 'u', 's', 'E', 'e', 'I', 'i', 'U', 'u', 'Y', 'y', 'A', 'a', 'E', 'e', 'I', 'i', 'O', 'o', 'U', 'u', 'A', 'a', 'E', 'e', 'U', 'u', 'E', 'e', 'O', 'o', 'A', 'a', 'C', 'c', 'E', 'e', 'L', 'l', 'N', 'n', 'S', 's', 'Z', 'z', 'N', 'n'],
    translit: function (org_str) {

        var tmp_str = "";
        for (var i = 0, l = org_str.length; i < l; i++) {
            var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
            if (n >= 0) {
                tmp_str += this.en_str[n];
            } else {
                tmp_str += s;
            }
        }

        tmp_str = tmp_str.replace(/^[-]+/, '');
        tmp_str = tmp_str.replace(/[-]+$/, '');
        tmp_str = tmp_str.replace(/[-]{2,}/g, '-');

        return tmp_str.toLowerCase();
    }
}

function getTime(val) {

    var hours = Math.floor(val / 60);
    var minutes = val - (hours * 60);

    var time = '';
    var h = hours;
    if (hours < 12 || hours == 24) {

        time = "AM"
        h = hours == 0 ? 12 : hours;
        h = hours == 24 ? 12 : hours;

    } else {

        time = "PM"

        h = hours > 12 ? hours - 12 : hours;

    }

    var m = minutes < 10 ? "0" + minutes : minutes;

    return h + ":" + m + " " + time;

}