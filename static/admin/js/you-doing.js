/**
 * Created by ddis on 31.03.2015.
 */
$(document).ready(function () {
    $('.image-click').click(function () {
        $('#file').click();
    });

    $('#file').fileupload({
        url: '/admin/you-doing/ajax/addImage',
        dataType: 'json',
        done: function (e, res) {
            if (res.result.status == 'success') {
                $('.image-click').html('Edit Image');
                var img = $('<img>');
                img.attr('src',res.result.base64).css({width:'250px'});
                $('#file').parent().find('img').remove();
                $('#file').parent().prepend(img);
                $('input[name=image_base64]').val(res.result.base64);
            }
        }

    });
});
