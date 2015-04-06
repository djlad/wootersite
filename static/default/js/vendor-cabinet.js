/**
 * Created by ddis on 01.04.2015.
 */
$(document).ready(function () {

    /**
     * Validation Start
     */

    $('#company-info').validate({
        'name' : {
            required: true
        },
        'description' : {
            required: true
        }
    }, function () { // on success
        alert(2);
    }, function () { // on error
        alert(1);
    });

    /**
     * Validate End
     *
     * Map Start
     * @type {google.maps.Map}
     * @var array input
     */
    var map = new google.maps.Map(
        document.getElementById("map"),
        {
            zoom: 8,
            maxZoom: 14,
            center:new google.maps.LatLng(40.7056258, -73.97968),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        }
    );

    var input = (document.getElementsByClassName('address-autocomplete'));
    var autocomplete = new google.maps.places.Autocomplete(input[0]);
    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substrRegex;

            matches = [];

            substrRegex = new RegExp(q, 'i');

            $.each(strs, function (i, str) {
                if (substrRegex.test(str.name)) {
                    matches.push({value: str.name, 'data-id': str.id});
                }
            });

            cb(matches);
        };
    };
    var bounds = new google.maps.LatLngBounds();

    autocomplete.bindTo('bounds', map);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var index = $('.address_list > li').length;
        var place = autocomplete.getPlace();
        var location = place.geometry.location;
        var name = $(".address-autocomplete").val();
        var input_attr = {
            'name' : 'address[]',
            'type' : 'hidden',
            'value': location,
            'class': 'location-input'
        };
        var a_attr = {
            'href' : '#',
            'class' : 'location-link'
        };
        var label_attr = {
            'class' : 'label-form'
        };
        var label = $('<label/>').attr(label_attr).html('address ' + index);
        var input = $('<input/>').attr(input_attr);
        var a = $('<a/>').attr(a_attr).html(name);
        var li = $('<li/>').html('').append(a).append(label);
        var marker = new google.maps.Marker({
            map: map
        });

        bounds.extend(location);
        marker.setPosition(location);
        map.fitBounds(bounds);

        $('.address_list > .add-address').before(li.prepend(input));

        /**
         * Скрываем input и очищаем его
         */

        $('.address-autocomplete').hide().val('');

    });

    $(document).on('click', '.location-link', function () {
        var location_str = $(this).parent().find('.location-input').val();
        var arr = location_str.replace(/[\(\)]/g,'').trim().split(',');
        var location = new google.maps.LatLng (arr[0], arr[1]);

        map.setCenter(location);
        map.setZoom(17);

        return false;
    });

    /**
     * Map End
     *
     * Click Add Address
     */
    $('.address_list > li:last').on('click', function () {
        $('.address-autocomplete').show();
        return false;
    });

    $(".fancybox-thumb").fancybox({
        prevEffect	: 'none',
        nextEffect	: 'none',
        helpers	: {
            title	: {
                type: 'outside'
            },
            thumbs	: {
                width	: 50,
                height	: 50
            }
        }
    });

    $('.popover_on').popover({
        html: true
    });

    $(document).on('click','.popover_on', function(){
       return false;
    });

    /**
     * Company Logo
     */

    $(".upload_img").dropzone({
        url: "/vendor-cabinet/ajax/logoImage",
        method: "POST",
        dataType: "JSON",
        parallelUploads: 1,
        uploadMultiple: false,
        addRemoveLinks: false,
        addedfile: function () {
            progressStart('.upload_img');
        },
        success: function (e, res) {
            var res = JSON.parse(res);
            if (res.status == "success") {
                $('.upload_img > img').attr('src', res.base64);
                var input = $('<input/>').attr({
                    'name': 'companyLogo',
                    'type': 'hidden',
                    'value': res.base64
                });
                $('.upload_img').append(input);
                progressStop('.upload_img', 500);
            }
        }
    });

    /**
     * Sports
     */

    $.ajax({
        url: '/ajax/getAllSport',
        type: "POST",
        dataType: "json",
        async: false,
        success: function (res) {
            if (res.status == 'success') {
                $('.input_add_actv').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        name: 'states',
                        displayKey: 'value',
                        source: substringMatcher(res.stages),
                        close: function (res) {
                            alert(1);
                        }
                    }
                ).on('typeahead:selected', function (obj, selected, name) {
                        var input = $('<input/>').attr({
                            'name' : "sports[]",
                            'type' : "hidden",
                            'value': selected['data-id']
                        });
                        var li = $('<li/>').append($('<a/>').attr({
                            'href':'#'
                        }).html(selected.value + '<span class="glyphicon glyphicon-remove"></span>')).append(input);

                        if ($('input[value='+selected['data-id']+']').length <=0 ){
                            $('.activities_list > ul > .activities-input').before(li);
                            $('.input_add_actv').typeahead('close').typeahead('val', '').hide();
                        }
                    });
            }
        },
        error: function () {
        }
    });

    $('.add_activities').on('click', function () {
        $('.input_add_actv').show();
        return false;
    });

    $('body').on('click', '.activities_list > ul > li > a > .glyphicon-remove', function () {
        var self = $(this).parents('li');
        self.slideUp('fast', function () {
            self.remove();
        });
    });

    /**
     * Mask
     */

    $('.phone_number').mask('(000) 000-00-00');
    // Open the popover


    $('[rel=popover]').webuiPopover({
        trigger:'click',
        placement: 'bottom',
        multi:true,
        padding:false,
        type:'html',
        cache:true
    });


});
