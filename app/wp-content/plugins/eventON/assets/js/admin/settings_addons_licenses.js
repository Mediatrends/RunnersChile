/*
*	Eventon Settings tab - addons and licenses
*	Version: 0.3
*	Last Updated: 2014-6-18
*/

jQuery(document).ready(function($){

	init();

	// load addon details
		function init(){

			var obj = $('#evo_addons_list');

			var ajaxdataa = { };
			ajaxdataa['action']= 'evo_addons';
			ajaxdataa['eventon_addons_opt']= obj.data('addons');
			ajaxdataa['evo_licenses']= obj.data('licenses');
			ajaxdataa['adminurl']= obj.data('adminurl');
			ajaxdataa['active_plugins']= obj.data('active_plugins');
			var ajax_url = obj.data('url');

			$.ajax({
				beforeSend: function(){
					
				},
				type: 'POST',
				url:ajax_url,
				data: ajaxdataa,
				dataType:'json',
				success:function(data){					
					obj.html(data.content);
				}
			});
		}

	// licenses verification and saving
		$('.eventon_popup').on('click','.eventon_submit_license',function(){
			
			$('.eventon_popup').find('.message').removeClass('bad good');
			
			var parent_pop_form = $(this).parent().parent();
			var license_key = parent_pop_form.find('.eventon_license_key_val').val();
			
			if(license_key==''){
				show_pop_bad_msg('License key can not be blank! Please try again.');
			}else{
				
				var slug = parent_pop_form.find('.eventon_slug').val();
				
				var data_arg = {
					action:'eventon_verify_lic',
					key:license_key,
					slug:slug
				};					
				
			// run ajax to verify license	
				$.ajax({
					beforeSend: function(){
						show_pop_loading();
					},
					type: 'POST',
					url:the_ajax_script.ajaxurl,
					data: data_arg,
					dataType:'json',
					success:function(data){
						//console.log(data);
						if(data.status=='json'){

							show_pop_bad_msg('wp_remote_post() method did not work to verify licenses, trying a backup method now..');

							// try to get json license information
							$.getJSON(data.new_content, function(dataJ){

								// if verified
								//if(dataJ.verify-purchase)
								//if(!$.isEmptyObject(dataJ['verify-purchase'])){
							});
							var data_arg_2 = {
								action:'eventon_verify_lic_2',
								key:license_key,
								slug:slug
							};

							// save verified license information
							$.ajax({
								beforeSend: function(){
									show_pop_loading();
								},
								type: 'POST',
								url:the_ajax_script.ajaxurl,
								data: data_arg_2,
								dataType:'json',
								success:function(data2){
									evo_update_activated_license(data2.new_content);
								}
							});

							
						}else if(data.status=='success'){
						// ACTIVATED
							evo_update_activated_license(data.new_content);
						}else{
						// OTHER
							//if(data.error_code=='')
							show_pop_bad_msg(data.error_msg);
						}					
						
					},complete:function(){
						hide_pop_loading();
					}
				});
			}
		});

	// when the license is activated, update pages content for new info
		function evo_update_activated_license(content){
			var box = $('#evo_license_main');
			box.find('.status').html(content);
			
			show_pop_good_msg('<span class="EVOcheckmark"></span> Woo hoo! Purchase key verified and saved. Thank you for activating EventON!');
			$('.eventon_popup').delay(3000).queue(function(n){
				$(this).animate({'margin-top':'70px','opacity':0}).fadeOut();
				$('#evo_popup_bg').fadeOut();
				n();
			});

			box.find('.action').hide();
			box.find('.activation_text').html('Yay! your eventon copy is activated now.');
		}
	// deactivate eventon license
		$('.evo_addons_page').on('click', '#evoDeactLic', function(){
			
			var data_arg = {
				action:'eventon_deactivate_lic',
			};	
			$.ajax({
				beforeSend: function(){
					$('.evo_addons_page').find('.addon.main').css({'opacity':'0.2'});
				},
				type: 'POST',
				url:the_ajax_script.ajaxurl,
				data: data_arg,
				dataType:'json',
				success:function(data){
					//console.log(data);
					if(data.status=='success'){

						location.reload();
						
					}else{
						alert(data.error_msg);
					}					
					
				},complete:function(){
					$('.evo_addons_page').find('.addon.main').css({'opacity':'1'});
				}
			});
		});
	
	// ADDON license activatation
		$('.eventon_popup').on('click','.eventonADD_submit_license',function(){
			
			$('.eventon_popup').find('.message').removeClass('bad good');
			
			var parent_pop_form = $(this).parent().parent();
			var license_key = parent_pop_form.find('.eventon_license_key_val').val();
			var email = parent_pop_form.find('.eventon_email_val').val();
			
			if(license_key=='' || email==''){
				show_pop_bad_msg('All the fields must be filled, please try again!');
			}else{
				
				var slug = parent_pop_form.find('.eventon_slug').val();
				var id = parent_pop_form.find('.eventon_id').val();
				
				
				var data_arg = {
					action:'eventon_addon_lic_activate',
					key:license_key,
					slug:slug,
					product_id:id,
					email:email
				};					
				
				$.ajax({
					beforeSend: function(){
						show_pop_loading();
					},
					type: 'POST',
					url:the_ajax_script.ajaxurl,
					data: data_arg,
					dataType:'json',
					success:function(data){
						//console.log(data.response);
						if(data.status=='success'){

							var box_o = parent_pop_form.find('.eventon_license_div').val();
							var box = $('#'+box_o);

							//console.log(box_o);

							box.find('.status').html(data.new_content);
							
							show_pop_good_msg('Woo hoo! License key verified and saved.');
							$('.eventon_popup').delay(3000).queue(function(n){
								$(this).animate({'margin-top':'70px','opacity':0}).fadeOut();
								$('#evo_popup_bg').fadeOut();
								n();
							});

							box.find('.action').hide();
							box.find('.activation_text').html('Yay! '+slug+' is activated now.');
							box.addClass('justactivate'); // colorize the newly activated box
							
						}else{
							show_pop_bad_msg(data.error_msg);
						}					
						
					},complete:function(){
						hide_pop_loading();
					}
				});
			}
		});
	
	// popup lightbox functions
		function show_pop_bad_msg(msg){
			$('.eventon_popup').find('.message').removeClass('bad good').addClass('bad').html(msg).fadeIn();
		}
		function show_pop_good_msg(msg){
			$('.eventon_popup').find('.message').removeClass('bad good').addClass('good').html(msg).fadeIn();
		}
		
		function show_pop_loading(){
			$('.eventon_popup_text').css({'opacity':0.3});
			$('#eventon_loading').fadeIn();
		}
		function hide_pop_loading(){
			$('.eventon_popup_text').css({'opacity':1});
			$('#eventon_loading').fadeOut(20);
		}
});