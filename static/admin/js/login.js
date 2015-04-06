$(document).ready(function(){

	if( $('#admin-login').length > 0 ) {
	
		$('#admin-login')
			.validate({'login':	{
								required: true
								},	
					   		'pswd':{
								required: true
							}

				}, callBackOnSuccess, callBackOnError);
	
	}

});

callBackOnSuccess = function () {

	var self = $(this);
	
	var buttonId = $(this).attr('data-submit-id');
	if (!buttonId) {
		buttonId = '';
	}
	
	ajaxForm(self, function(res) {
		
		if( res.status == 'ok' ) {
			
			window.location.href = '/admin';

		} else {
		
			$('.alert').slideUp('slow', function (){
				
				$(this).empty().append(res.msg).slideDown('slow', function () {

				});
				
			});
		
		}
	
	});

}

callBackOnError = function (errors) {
	
	var focused = 0;
	
	$('form').find('input, select, textarea').each(function () {
		
		var self = $(this);
		var id = self.attr('id');
		var errorDiv = self.parents('div.row');
		
		if( typeof(errors[id]) != 'undefined' ) {
			
			errorDiv.addClass('error');
			
			if( focused == 0) {
				
				self.focus();
				focused++;
				
			}
			
			if( errorDiv.find('.help-inline').length == 0 ) {

				errorDiv.find('.form-group').append('<span class="help-inline" style="display:none;">' + errors[id] + '</span>');
				errorDiv.find('.form-group').addClass('has-error');
				
				errorDiv.find('.help-inline').fadeIn(400);
				
			} else {
				
				errorDiv.find('.help-inline').html(errors[id]);
				errorDiv.find('.form-group').addClass('has-error');
			
			}

		} else {
		
			errorDiv.find('.form-group').removeClass('has-error');
			errorDiv.find('.form-group').find('span').remove();
			
		}
	
	});

}

function ajaxForm(form, successCallback, isDebug) {
		
	var url = form.attr('action');
	var method = form.attr('method');
	var disabled = form.find(':input:disabled').prop('disabled',false);
	var data = form.serialize();
		disabled.prop('disabled',true);

	if( isDebug ) {
	
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
		
			if( typeof successCallback == 'function' ) {
			
				successCallback(res);
			
			}
		
		},
		error: function (error, err) {
			
			if( isDebug ) {
			
				console.log(err);
			
			}
		
		}
	});
}
