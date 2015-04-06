/**
 * Created by ddis on 30.03.2015.
 */
$(document).ready(function () {

    var states = [];

    $('.send').click(function () {
        var sport = $('.tt-input').attr('data-id');
        var code = parseInt($('.zip_code_input').val());
        if (!isNaN(code)) {
            location.href = '/feature/code/'+code+(sport.length>0 ? '/sport/'+sport : '');
        } else {
            alert('enter code');
        }
    });

    $('.search_cat_list > li > a').click(function () {

        var type = $(this).parent().find('.search_i_title').html();
        var code = parseInt($('.zip_code_input').val());
        if (!isNaN(code)) {
            location.href = '/feature/code/'+code+(type.length>0 ? '/category/'+type : '');
        } else {
            alert('enter code');
        }
        return false;
    });

    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substrRegex;

            matches = [];

            substrRegex = new RegExp(q, 'i');

            $.each(strs, function (i, str) {
                if (substrRegex.test(str.name)) {
                    matches.push({value: str.name, 'data-id':str.id});
                }
            });

            cb(matches);
        };
    };

    $.ajax({
        url: '/ajax/getAllSport',
        type: "POST",
        dataType: "json",
        async: false,
        success: function (res) {
            if (res.status == 'success') {
                $('.activities_input').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        name: 'states',
                        displayKey: 'value',
                        source: substringMatcher(res.stages)
                    }
                );
            }
        },
        error: function () {
        }
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                console.log('pos', pos);
                var point = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
                new google.maps.Geocoder().geocode({'latLng': point}, function (res, status) {
                    if (status == google.maps.GeocoderStatus.OK && typeof res[0] !== 'undefined') {
                        var zip = res[0].formatted_address.match(/,\s\w{2}\s(\d{5})/);

                        if (zip) {
                            $(".zip_code_m").val(zip[1]);
                        } else console.log('Failed to parse');
                    } else {
                        console.log('Failed to reverse');
                    }
                });
            }, function (err) {
                fail(err.message);
            }
        );
    } else {
        console.log("location now supported");
    }
    function fail(err) {
        console.log('err', err);
    }


    //Close popover when click out

    $(document).mouseup(function (e) {
        var container = $(".popover");
        if (container.has(e.target).length === 0){
            $('.popover_on').tooltip('hide');
        }
    });

});