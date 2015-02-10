jQuery(document).ready(function(){
	
	// Search Default text
	jQuery('.search-text input').live("blur", function(){
		var default_value = jQuery(this).attr("data-default");
		if (jQuery(this).val() == ""){
			jQuery(this).val(default_value);
		}	
	}).live("focus", function(){
		var default_value = jQuery(this).attr("data-default");
		if (jQuery(this).val() == default_value){
			jQuery(this).val("");
		}
	});	
	
	// Top search
	jQuery(".top-search-wrapper").find("#searchsubmit").click(function(){
		if( parseInt(jQuery(this).siblings("#search-text").width()) == 1 ){
			jQuery(this).siblings("#search-text").children("input[type='text']").val('');
			jQuery(this).siblings("#search-text").children().css('display', 'block');
			jQuery(this).siblings("#search-text").animate({ width: 174, 'margin-left': 15 });
			jQuery(this).siblings("#search-text").children("input[type='text']").focus();
			return false;
		}
		if( jQuery(this).siblings("#search-text").children("input[type='text']").val() == '' ){
			return false;
		}
	});
	jQuery("#searchform").click(function(){
	   if (event.stopPropagation){
		   event.stopPropagation();
	   }
	   else if(window.event){
		  window.event.cancelBubble=true;
	   }
		//event.stopPropagation();
	});
	jQuery("html").click(function(){
		jQuery(this).find(".top-search-wrapper").find("#search-text").animate({ width: 1, 'margin-left': 0 }, function(){
			jQuery(this).children().css('display', 'none');
		});
	});	

	// Social Hover
	jQuery("#gdl-social-icon .social-icon").hover(function(){
		jQuery(this).animate({ opacity: 0.55 }, 150);
	}, function(){
		jQuery(this).animate({ opacity: 1 }, 150);
	});
	
	// Accordion
	var gdl_accordion = jQuery('ul.gdl-accordion');
	gdl_accordion.find('li').not('.active').each(function(){
		jQuery(this).children('.accordion-content').css('display', 'none');
	});
	gdl_accordion.find('li').click(function(){
		if( !jQuery(this).hasClass('active') ){
			jQuery(this).addClass('active').children('.accordion-content').slideDown();
			jQuery(this).siblings('li').removeClass('active').children('.accordion-content').slideUp();
		}
	});
	
	// Toggle Box
	var gdl_toggle_box = jQuery('ul.gdl-toggle-box');
	gdl_toggle_box.find('li').not('.active').each(function(){
		jQuery(this).children('.toggle-box-content').css('display', 'none');
	});
	gdl_toggle_box.find('li').click(function(){
		if( jQuery(this).hasClass('active') ){
			jQuery(this).removeClass('active').children('.toggle-box-content').slideUp();
		}else{
			jQuery(this).addClass('active').children('.toggle-box-content').slideDown();
		}
	});	
	
	// Tab
	var gdl_tab = jQuery('div.gdl-tab');
	gdl_tab.find('.gdl-tab-title li a').click(function(e){
		if( jQuery(this).hasClass('active') ) return;
		
		var data_tab = jQuery(this).attr('data-tab');
		var tab_title = jQuery(this).parents('ul.gdl-tab-title');
		var tab_content = tab_title.siblings('ul.gdl-tab-content');
		
		// tab title
		tab_title.find('a.active').removeClass('active');
		jQuery(this).addClass('active');
		
		// tab content
		tab_content.children('li.active').removeClass('active').css('display', 'none');
		tab_content.children('li[data-tab="' + data_tab + '"]').fadeIn().addClass('active');
		
		e.preventDefault();
	});
	
	// Scroll Top
	jQuery('div.scroll-top').click(function() {
		jQuery('html, body').animate({ scrollTop:0 }, { duration: 600, easing: "easeOutExpo"});
		return false;
	});
	
	// Blog Hover
	jQuery(".blog-media-wrapper.gdl-image img, .port-media-wrapper.gdl-image img, .gdl-gallery-image img").hover(function(){
		jQuery(this).animate({ opacity: 0.55 }, 150);
	}, function(){
		jQuery(this).animate({ opacity: 1 }, 150);
	});
	
	// Port Hover
	jQuery(".portfolio-item").each(function(){
		var port_hover = 0; var port_unhover = 0;
		jQuery(this).hover(function(){
			port_hover++;
		
			var thumbnail_hover = jQuery(this).find('a.hover-wrapper');
			var thumbnail_overlay_hover = thumbnail_hover.children('.portfolio-thumbnail-image-hover');
			var thumbnail_overlay_hover_icon = thumbnail_hover.children('.hover-icon');
			var tmp_height = thumbnail_hover.height();
			
			var content_hover = jQuery(this).children('.portfolio-context');
			var content_bar = content_hover.children('.port-bottom-border');
			var cnt_height = content_hover.outerHeight();

			content_bar.animate({ height: cnt_height }, { 
				duration: (cnt_height - 2) * 0.5, 
				complete: function(){
					if( port_hover - 1 == port_unhover ){
						thumbnail_overlay_hover.animate({ height: tmp_height }, tmp_height * 0.5);
						thumbnail_overlay_hover_icon.fadeIn(200);
					}
				}
			});
			content_hover.animate({ 'padding-left': 20, 'padding-right': 20 }, 150);
		}, function(){
			port_unhover++;
		
			var thumbnail_hover = jQuery(this).find('a.hover-wrapper');
			var thumbnail_overlay_hover = thumbnail_hover.children('.portfolio-thumbnail-image-hover');
			var thumbnail_overlay_hover_icon = thumbnail_hover.children('.hover-icon');
			var tmp_height = thumbnail_hover.height();
		
			var content_hover = jQuery(this).children('.portfolio-context');
			var content_bar = content_hover.children('.port-bottom-border');
			var cnt_height = content_hover.outerHeight();
			
			if( thumbnail_hover.length == 0 ){
				content_bar.animate({ height: 2 }, (cnt_height - 2) * 0.5 );	
				content_hover.animate({ 'padding-left': 0, 'padding-right': 40 }, 150);		
			}else{
				thumbnail_overlay_hover.animate({ height: 0 }, {
					duration: tmp_height * 0.5, 
					complete: function(){
						content_bar.animate({ height: 2 }, (cnt_height - 2) * 0.5 );	
						content_hover.animate({ 'padding-left': 0, 'padding-right': 40 }, 150);
					}
				});
				thumbnail_overlay_hover_icon.fadeOut(200);
			}
		});
	});

	// JW Player Responsive
	responsive_jwplayer();
	function responsive_jwplayer(){
		jQuery('[id^="jwplayer"][id$="wrapper"]').each(function(){
			var data_ratio = jQuery(this).attr('data-ratio');
			if( !data_ratio || data_ratio.length == 0 ){
				data_ratio = jQuery(this).height() / jQuery(this).width();
				jQuery(this).css('max-width', '100%');
				jQuery(this).attr('data-ratio', data_ratio);
			}
			jQuery(this).height(jQuery(this).width() * data_ratio);
		});
	}
	jQuery(window).resize(function(){
		responsive_jwplayer();
	});

});
jQuery(window).load(function(){

	// Menu Navigation
	jQuery('#top-superfish-wrapper ul.top-menu').supersubs({
		minWidth: 14.5, maxWidth: 25, extraWidth: 1
	}).superfish({
		delay: 400, speed: 'fast', animation: {opacity:'show',height:'show'}
	});	
	
	jQuery('#main-superfish-wrapper ul.sf-menu').supersubs({
		minWidth: 14.5, maxWidth: 17, extraWidth: 1
	}).superfish({
		delay: 400, speed: 'fast', animation: {opacity:'show',height:'show'}
	});
	
	// Personnal Item Height
	function set_personnal_height(){
		jQuery(".personnal-item-holder .row").each(function(){
			var max_height = 0;
			jQuery(this).find('.personnal-item').height('auto');
			jQuery(this).find('.personnal-item-wrapper').each(function(){
				if( max_height < jQuery(this).height()){
					max_height = jQuery(this).height();
				}
			});
			jQuery(this).find('.personnal-item').height(max_height);
		});		
	}
	set_personnal_height();
	
	// Price Table Height
	function set_price_table_height(){
		jQuery(".price-table-wrapper .row").each(function(){
			var max_height = 0;
			jQuery(this).find('.best-price').removeClass('best-active');
			jQuery(this).find('.price-item').height('auto');
			jQuery(this).find('.price-item-wrapper').each(function(){
				if( max_height < jQuery(this).height()){
					max_height = jQuery(this).height();
				}
			});
			jQuery(this).find('.price-item').height(max_height);
			jQuery(this).find('.best-price').addClass('best-active');
		});		
	}	
	set_price_table_height();
	
	// Set Portfolio Max Height
	function set_portfolio_height(){
		jQuery('div.portfolio-item-holder').each(function(){
			var context_height = 0; 
			jQuery(this).find('.portfolio-context').css({'height': 'auto'});
			jQuery(this).find('.portfolio-context').each(function(){
				if( context_height < jQuery(this).height()){
					context_height = jQuery(this).height();
				}				
			});
			jQuery(this).find('.portfolio-context').css({'height': context_height});		
		
			var max_height = 0; 
			jQuery(this).children('.portfolio-item').height('auto');
			jQuery(this).children('.portfolio-item').each(function(){
				if( max_height < jQuery(this).height()){
					max_height = jQuery(this).height();
				}				
			});
			jQuery(this).children('.portfolio-item').height(max_height);
		});
	}
	setTimeout(function(){ set_portfolio_height(); }, 100);
	
	// When window resize, set all function again
	jQuery(window).resize(function(){
		set_personnal_height();
		set_price_table_height();
		set_portfolio_height()	
	});	

});

