$(function(){

	$('.submit').click(function()
	{
		$('.errormessage').hide().empty();
		$('#validation').show();

		var submit_id =  $(this).prop('id');
		$('#'+submit_id).hide();

		var requiredelement_ids = [];
		var email_ids = [];
		var form_value_array = [];
		var radio_value = [];
		var checkbox_value = [];

		$('.af-formvalue').each(function()
		{
			var label = $(this).closest('.element').find('.labelelementvalue').html();

			if($(this).hasClass('af-inputtext') || $(this).hasClass('af-textarea')) {
				var key = $(this).prop('id');
				var value = $(this).val();
				form_value_array.push({'elementid': key, 'elementvalue': value, 'label': label});
			}

			if($(this).is(':radio')) {
				var key = $(this).prop('name');
				var value = $(this).val();
				if($(this).is(':checked')) {
					form_value_array.push({'elementid': key, 'elementvalue': value, 'label': label});
					radio_value[key] = value;
				}
				if($(this).is($(this).closest('.element').find('input[name='+key+']:last')) && !radio_value[key]) {
					form_value_array.push({'elementid': key, 'elementvalue': '', 'label': label});
				}
			}

			if($(this).is(':checkbox')) {
				var key = $(this).prop('name');
				var value = $(this).val();
				if($(this).is(':checked')) {
					form_value_array.push({'elementid': key, 'elementvalue': value, 'label': label});
					checkbox_value[key] = value;
				}
				if($(this).is($(this).closest('.element').find('input[name='+key+']:last')) && !checkbox_value[key]) {
					form_value_array.push({'elementid': key, 'elementvalue': '', 'label': label});
				}
			}

			if($(this).hasClass('af-select')) {
				var key = $(this).prop('id');
				var value = $(this).val();
				form_value_array.push({'elementid': key, 'elementvalue': value, 'label': label});
			}

			if($(this).hasClass('af-time')) {
				var key = 'element-' + $(this).closest('.element').prop('id');
				var ampm = $(this).closest('.element').find('.time-ampm').val() || '';
				var value = $(this).closest('.element').find('.time-hour').val() + ':' + $(this).closest('.element').find('.time-minute').val() + ' ' + ampm;
				form_value_array.push({'elementid': key, 'elementvalue': value, 'label': label});
			}
		});

		$('input[type=checkbox][name="requiredelement[]"]').each(function(){
			requiredelement_ids.push('element-'+$(this).val());
		}); 

		$('input[type=checkbox][name="emailrequiredelement[]"]').each(function(){
			email_ids.push('element-'+$(this).val());
		}); 

		var captcha_img;
		var captcha_input;

		if($('.captcha_img').length)
		{
			captcha_img = 1;
			captcha_input = $('#captcha_input').val();
		}  	

		$.post('contactform/inc/form-validation.php',
		{ 
			'requiredelement': requiredelement_ids,
			'emailrequiredelement': email_ids,
			'captcha_img': captcha_img,
			'captcha_input': captcha_input,
			'form_value_array': form_value_array
		},
		function(data){
			$('#validation').hide();

			let response;
			try {
				response = typeof data === 'string' ? JSON.parse(data) : data;
			} catch (e) {
				console.error("Fehler beim Parsen der Serverantwort:", data);
				alert("Ein unerwarteter Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.");
				$('#' + submit_id).show();
				return;
			}

			if(response['status'] === 'ok') {
				let validation_message = '<div class="validationmessage">' + response['message'] + '</div>';
				$('.element').each(function() {
					if (!$(this).find('.title').html()) {
						$(this).slideUp('fast');
					}
				});
				$('#contactform-content').append(validation_message);
			} else {
				$('#' + submit_id).show();
				for (var i = 0; i < response['message'].length; i++) {
					$('#errormessage-' + response['message'][i]['elementid']).append(response['message'][i]['errormessage']);
					$('#errormessage-' + response['message'][i]['elementid']).fadeIn();
				}
			}
		}); 
	}); 
});