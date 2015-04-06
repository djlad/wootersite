/**
 * Created by ddis on 02.04.2015.
 */
function progressStart(selector) {
    $(selector).css('position', 'relative');
    var el = $( selector );
    el.append('<div class="in-progress"></div>');
    $(selector + ' .in-progress')
        .width(el.outerWidth())
        .height(el.outerHeight());
}
/**
 * End Progress bar
 * @param selector
 */
function progressStop(selector, seconds) {
    setTimeout(function () {
        $(selector + ' .in-progress').fadeOut("fast", function() {
            $(this).remove();
        });
    }, seconds);
}