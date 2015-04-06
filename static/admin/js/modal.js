var KEYCODE_ENTER = 13;
var KEYCODE_ESC = 27;

function openModal(className) {
	
	if( $('.modal-backdrop').length == 0 ) {
	
		$('body').append('<div class="modal-backdrop"></div>');
	
	}
	
	$('body').css('overflowY', 'hidden');
	
	var shim = $('.modal-backdrop');
	var modal = $('.' + className);
	var marginLeft = 'auto';
	
	modal.css('marginLeft', '-' + marginLeft + 'px');
	
	shim.show(0, function () {
	
		modal.show(300);
		
	});
	
	$('.modal').trigger('open').attr('opened', true);

}

function closeModal() {
	
	$('body').css('overflowY', 'auto');
	$('.modal').fadeOut().attr('opened', false);
	$('.modal-backdrop').fadeOut('fast');
	
	$('.modal').trigger('close');
	$('.load').hide();
	
	
}

$(function () {

	$('body').on('click', '.modal .close, .modal-backdrop, .modal .close-btn, .modal .modal-close', function () {
	
		closeModal();

		return false;
	
	});
	
	$('body').on('click', '.modal .confirm-btn', function () {
		
		$('.modal').trigger('confirm');
	
	});

});


$(document).keyup(function(e) {
	
	if( $('.modal').length > 0 ) {
		
		if( $('.modal').attr('opened') ) {
			
			if( $('.modal').hasClass('alert-window') ) {
			
				if(e.keyCode == KEYCODE_ENTER ) {

					closeModal();
				
				}
			
			}
			
			if( e.keyCode == KEYCODE_ESC ) {
				
				closeModal();
				
			}			
		
		}

	}
	
});

function confirmAction(text, success, cancel) {

	if( $('.confirm-action').length == 0 ) {
        $('body').append('<div class="modal confirm-action" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body">' + text + '</div><div class="modal-footer"><button class="btn btn-info confirm-btn" data-dismiss="modal" aria-hidden="true">Yes</button>   <button class="btn btn-danger close-btn">Cancel</button></div></div></div></div>');
		//$('body').append('<div class="modal confirm-action" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 id="myModalLabel">' + text + '</h4></div><div class="modal-footer"><button class="btn btn-info confirm-btn" data-dismiss="modal" aria-hidden="true">Yes</button>   <button class="btn btn-danger close-btn">Cancel</button></div></div>');
        //$('body').append('<div class="modal confirm-action" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 id="myModalLabel">' + text + '</h4></div><div class="modal-footer"><button class="btn btn-info confirm-btn" data-dismiss="modal" aria-hidden="true">Yes</button>   <button class="btn btn-danger close-btn">Cancel</button></div></div>');
	}
	
	openModal('confirm-action');
	
	$('.modal').one('confirm', function () {
	
		if( typeof success == 'function' ) {
		
			success();
			
		}
		
		closeModal('confirm-action');

	});
	
	$('.modal').one('close', function () {

		if( typeof cancel == 'function' ) {
		
			cancel();
		
		}		
	
	});

}

function showAlert(text, ok) {
	
	if( $('.alert-window').length == 0 ) {
	
		$('body').append('<div class="modal alert-window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 id="myModalLabel">' + text + '</h4></div><div class="modal-footer"><button class="btn btn-info  confirm-btn" data-dismiss="modal" aria-hidden="true">OK</button></div></div>');
	
	}
	
	openModal('alert-window');
	
	$('.modal').one('confirm', function () {
	
		closeModal('alert-window');
		
		if( typeof ok == 'function' ) {
		
			ok();
			
		}
	
	});

}


function showUploadFileWindow(){

	
	openModal('uploadphotomodal');
	
	$('.modal').one('confirm', function () {
	
		closeModal('alert-window');
		
		if( typeof ok == 'function' ) {
		
			ok();
			
		}
	
	});

}


function showLightBox(img_url){
	//alert(img_url);
	
	//alert(5);
	
	if(String(img_url).length > 2){
		if( $('.alert-lightbox').length == 0) {
		
		$('body').append('<div class="alert-lightbox hide"></div>');
		//alert(5);
		}
		
	/*openModal('alert-lightbox');
	
	$('.modal').one('confirm', function () {
	
		closeModal('alert-window');
		
		if( typeof ok == 'function' ) {
		
			ok();
			
		}
	
	});*/
	}
}