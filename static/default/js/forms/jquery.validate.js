;(function( $ )	{
"use strict";

	$.fn.validate = function(options, success, error) {
	
		$(this).submit(function () {
			
			var errorsCount = 0;
			var errors = {};
			
			$.each(options, function(key, value) {
				
				var isMultiply = false;
				
				$.each(value, function(name, index) {

					var values;

					var input = $('#' + key);
					
					var val = input.val();
					
					var message = input.attr('data-msg-' + name) != 'undefined' ? input.attr('data-msg-' + name) : '';

					switch(name) {
						case 'multiply':
						
							isMultiply = true;
						
							break;
							
						case 'required':
						
							if( !$.fn.checkRequired(val) ) {

								errors[key] = message;
								errorsCount++;
								
								return false;
								
							}
							
							break;
						
						case 'regexp':
						
							if( !$.fn.checkRegexp(val, index) ) {
							
								errors[key] = message;
								errorsCount++;
								
								return false;
							}

							break;
							
						case 'len':
						
							var minLength = index[0];
							var maxLength = index[1];
							
							if( !$.fn.checkLength(minLength, maxLength, val) ) {
							
								errors[key] = message;
								errorsCount++;
								
								return false;
	
							}
							
							break;
						
						case 'callback':
						
							var names = key.split(',');
												
							if( isMultiply ) {
			
								var vals = '';
								
								var name;
								
								var i = 0;

								while( i < names.length ) {
									
									name = '#' + $.trim(names[i]).toString();

									vals += '"' + $(name).val() + '",';
									
									i++;
								}
								
								values = rtrim(vals, ',');

							} else {
							
								values = '"' + val + '"';
							
							}
			
							var result = eval(index + '(' + values + ')');
						
							if( !result ) {
								
								var i = 0;
								
								while( i < names.length ) {

									var array_name = $.trim(names[i]);
								
									errors[array_name] = message;

									i++;
								}

								errorsCount++;
								
								return false;	
								
							}
							
							
							break;
							
						case 'compare':
						
							if ( !$.fn.checkCompare(val, index) ) {
							
								errors[key] = message;
								errorsCount++;
								
								return false;
								
							}
						
							break;
					
					}
			
				});
			
			});
			
			if( errorsCount == 0 ) {

				if (typeof success == 'function') {
			
					success.call(this);
				
				}		
			
			} else {

				if (typeof error == 'function') {
				
					error.call(this, errors);
					
				}
			
			}
			
			return false;
			
		});
	};
	
	$.fn.checkRequired = function(value) {

		return value == '' ? false : true;
	
	};
	
	$.fn.checkLength = function(minLength, maxLength, val) {
		
		return val.length >= minLength && val.length <= maxLength ? true : false;
	
	};

	$.fn.checkCompare = function(val, index) {
		
		return $('#' + index).val() == val ? true : false;
	
	};
	
	$.fn.checkRegexp = function(value, regexp) {
			
		switch(regexp) {
		
			case 'email':

				return value.match(/^[a-z0-9][\w.-]*@[a-z0-9][a-z0-9.-]*\.[a-z]{2,}$/i) ? true : false;
				
				break;
				
			case 'int':
			
				return typeof(value) == 'int' ? true : false;

				break;
			
			case 'float':
			
				return value.match(/^\d+(?:\.\d+)?$/i) ? true : false;

				break;
				
			case 'login':

				return value.match(/^[a-z\s_]+[\w-]*$/i) ? true : false;
			
				break;
				
			case 'name':
			
				return value.match(/^[A-ZА-Яa-zа-яіІїЇÜüÄäÖöЁё]+[`"\' -]?[A-ZА-Яa-zа-яіІїЇÜüÄäÖöьЬъЪßйЙЁё]+$/i) ? true : false;
				
				break;
				
			case 'latin':

				return value.match(/^[a-z]+$/i) ? true : false;
			
				break;
				
			case 'url':
				
				if (value.length === 0) {
				
					return true;
				
				} else {
				
					return value.match(/^[a-z0-9.\-_\?\=\+\&\/]+$/i) ? true : false;
				
				}
				
				break;
				
			case 'link':
				
				if (value.length === 0) {
				
					return true;
				
				} else {
				
					return value.match(/^(https?:\/\/)?([\w\.-]+)\.([a-z]{2,6}\.?)(\/[\w\.-]*)*/) ? true : false;
				
				}
				
				break;	
			
			case 'date':
				
				if (value.length === 0) {
				
					return true;
				
				} else {
				
					return value.match(/^(0[1-9]|[12][0-9]|3[01])[. /.](0[1-9]|1[012])[. /.](19|20)\d\d/) ? true : false;
				
				}
				
				break;
			
			default:

				return value.match(regexp) ? true : false;
			
				break;
			
		}		

	};


	
})( jQuery );


function rtrim(str, charlist) {
	charlist = !charlist ? ' \s\xA0' : charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
	var re = new RegExp('[' + charlist + ']+$', 'g');
	return str.replace(re, '');
}
