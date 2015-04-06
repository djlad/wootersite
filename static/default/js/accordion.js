/**
 * Created by Svjatoslav on 31.03.2015.
 */


$( document ).ready(function() {

    $(document).on("click",".a_toggle",function(){

        parent = $(this).parents('.accordion');
        block = parent.find('.a_block');
        block.slideToggle(1000);

        if(block.is(':visible')){

            $(this).find('span').toggleClass('up');

        }

        return false;

    });

});