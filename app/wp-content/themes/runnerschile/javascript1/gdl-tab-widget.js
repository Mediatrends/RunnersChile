jQuery(document).ready(function(){
	jQuery('.gdl-tab-widget-wrapper').each(function(){
		jQuery(this).find('.gdl-tab-widget-header-item a').click(function(){
			jQuery(this).addClass('active');
			jQuery(this).parent().siblings().children('a').removeClass('active');		
		
			var tab_id = jQuery(this).attr('data-id');
			var widget_content = jQuery(this).parents('.gdl-tab-widget-header-wrapper').siblings('.gdl-tab-widget-content-wrapper');
			widget_content.children('div[data-id="' + tab_id + '"]').each(function(){
				jQuery(this).siblings().removeClass('active').css('display','none');
				jQuery(this).fadeIn().addClass('active');
			});
		});			
	});
});	