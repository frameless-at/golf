$(function(){
		
		
	$('.submit').click(function()
	{
		$('.errormessage').hide().empty();
		
		$('#validation').show();
		
		var submit_id =  $(this).prop('id');
		$('#'+submit_id).hide();
		
		var requiredelement_ids = Array();
		var email_ids = Array();
		var form_value_array = Array();
		var radio_value = Array();
		var checkbox_value = Array();
		
		
		$('.af-formvalue').each(function()
		{
			var label = $(this).closest('.element').find('.labelelementvalue').html();
			
			// catch input text values
			if($(this).hasClass('af-inputtext'))
			{
				var key = $(this).prop('id');
				var value = $('#'+$(this).prop('id')).val();
				form_value_array.push({'elementid': key, 'elementvalue': value, 'label':label});
			}
										 
			// catch textarea values
			if($(this).hasClass('af-textarea'))
			{
				var key = $(this).prop('id');
				var value = $('#'+$(this).prop('id')).val();
				form_value_array.push({'elementid': key, 'elementvalue': value, 'label':label});
			}
			
			// catch radiobutton values
			if($(this).is(':radio'))
			{
				var key = $(this).prop('name');
				var value = $(this).val();
				
				var check_index_radio_form_value = form_value_array.length+1;
				
				if($(this).is(':checked')){
					form_value_array.push({'elementid': key, 'elementvalue': value, 'label':label});
					radio_value[key] = value;
				}
				
				if( $(this).is( $(this).closest('.element').find('input[name='+key+']:last')) )
				{
					if(!radio_value[key]){
						form_value_array.push({'elementid': key, 'elementvalue': '', 'label':label});
					}
				}
			}
	
			// catch checkbox values
			if($(this).is(':checkbox'))
			{
				var key = $(this).prop('name');
				var value = $(this).val();
					
				if($(this).is(':checked')){
					form_value_array.push({'elementid': key, 'elementvalue': value, 'label':label});
					checkbox_value[key] = value;
				}
				
				if( $(this).is( $(this).closest('.element').find('input[name='+key+']:last')) )
				{
					if(!checkbox_value[key]){
						form_value_array.push({'elementid': key, 'elementvalue': '', 'label':label});
					}
				}
			}
			
			// catch select values
			if($(this).hasClass('af-select'))
			{
				var key = $(this).prop('id');
				var value = $(this).val();
				form_value_array.push({'elementid': key, 'elementvalue': value, 'label':label});
				
			}
			
			// catch time values
			if($(this).hasClass('af-time'))
			{
				var key = 'element-'+$(this).closest('.element').prop('id');
				var ampm = $(this).closest('.element').find('.time-ampm').val();
				if(ampm == undefined) ampm = ''; // no quote on undefined
				var value = $(this).closest('.element').find('.time-hour').val()+':'+$(this).closest('.element').find('.time-minute').val()+' '+ampm;
				
				form_value_array.push({'elementid': key, 'elementvalue': value, 'label':label});
			}
			
		});
		
		/*
		var i;
		var debug_form_values = '';
		for (i = 0; i < form_value_array.length; ++i){
			debug_form_values += form_value_array[i]['elementid']+ ' | '+form_value_array[i]['label']+ ' => '+form_value_array[i]['elementvalue']+"\n";
		}
		alert(debug_form_values);
		*/
		
		
		// catch required elements ids for non empty validation
		$('input[type=checkbox][name="requiredelement[]"]').each(function(){
			requiredelement_ids.push('element-'+$(this).val());
		}); 
		
		
		// catch required email elements ids for email validation
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
			 		'requiredelement' : requiredelement_ids
				  , 'emailrequiredelement':email_ids
				  , 'captcha_img':captcha_img
				  , 'captcha_input':captcha_input
				  , 'form_value_array':form_value_array
				},
				function(data){
					//
					$('#validation').hide();
					
				  	// 	alert('DATA :'+data);
					response = jQuery.parseJSON(data);

					if(response['status'] == 'ok')
					{
						validation_message = '<div class="validationmessage">'+response['message']+'</div>';
						
						$('.element').each(function()
						{
								if(!$(this).find('.title').html()){
										$(this).slideUp('fast');
								}
						});
						
						$('#contactform-content').append(validation_message);
						
					} else
					{	
						$('#'+submit_id).show();

						for(var i=0; i<response['message'].length; i++)
						{
							$('#errormessage-'+response['message'][i]['elementid']).append(response['message'][i]['errormessage']);
							$('#errormessage-'+response['message'][i]['elementid']).fadeIn();
						}
					}
				} /* end function data */
					
			); /* end $.post */
		
	}); /* end click submit */
	
});

