<?php
/**
 * Plugin Name: 1/2 Goodlayers Banner Widget
 * Plugin URI: http://goodlayers.com/
 * Description: Half size banner widget
 * Version: 1.0
 * Author: Goodlayers
 * Author URI: http://www.goodlayers.com
 *
 */

add_action( 'widgets_init', 'goodlayers_1_2_banner_init' );
function goodlayers_1_2_banner_init(){
	register_widget('Goodlayers_1_2_Banner_widget');      
}

class Goodlayers_1_2_Banner_widget extends WP_Widget{ 

	// Initialize the widget
    function Goodlayers_1_2_Banner_widget() {
        parent::WP_Widget('goodlayers-1-2-banner-widget', __('1/2 Banner Widget (Goodlayers)','gdl_back_office'), 
			array('description' => __('Half size banner widget (116 px)', 'gdl_back_office')));  
    }  
	
	// Output of the widget
	function widget($args, $instance) {  
		global $wpdb;
	
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$image = apply_filters( 'widget_title', $instance['image'] );
		$link = apply_filters( 'widget_title', $instance['link'] );
		$image2 = apply_filters( 'widget_title', $instance['image2'] );
		$link2 = apply_filters( 'widget_title', $instance['link2'] );
		$bottom_margin = apply_filters( 'widget_title', $instance['bottom_margin'] );

		if( empty($title) ){
			echo '<div class="banner-widget1-2-outer-wrapper without-title">';
		}else{
			echo '<div class="banner-widget1-2-outer-wrapper">';
		}
		echo $before_widget;

		// Open of title tag
		if($title){ 
			echo $before_title . $title . $after_title; 
		}		
		
		echo '<div class="clear"></div>';
		echo '<div class="banner-widget1-2-wrapper mb' . $bottom_margin . '">';
		
		echo '<div class="banner-widget1-2" >';
		echo '<div class="left" >';
		echo '<a href="' . $link . '" target="_blank">';
		echo '<img src="' . $image . '" alt="banner" />';
		echo '</a>';
		echo '</div>';
		echo '</div>';
		
		echo '<div class="banner-widget1-2" >';
		echo '<div class="right" >';
		echo '<a href="' . $link2 . '" target="_blank">';
		echo '<img src="' . $image2 . '" alt="banner"/>';
		echo '</a>';	
		echo '</div>';
		echo '</div>';
		
		echo '<div class="clear"></div>';
		echo '</div>'; // 1-2 Banner Widget Wrapper
		
		echo $after_widget;		
		echo '</div>';
    }  	
	
	// Widget Form
	function form($instance) {  
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$image = esc_attr( $instance[ 'image' ] );
			$link = esc_attr( $instance[ 'link' ] );
			$image2 = esc_attr( $instance[ 'image2' ] );
			$link2 = esc_attr( $instance[ 'link2' ] );
			$bottom_margin = esc_attr( $instance[ 'bottom_margin' ] );
		} else {
			$title = '';
			$image = '';
			$link = '';
			$image2 = '';
			$link2 = '';
			$bottom_margin = 40;
		}
		?>
		
		<!-- Title --> 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<!-- Image --> 
		<p>
			<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e( 'Banner Image URL :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo $image; ?>" />
		</p>		
		
		<!-- Link --> 
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e( 'Banner Link :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
		</p>		
		
		<!-- Image2 --> 
		<p>
			<label for="<?php echo $this->get_field_id('image2'); ?>"><?php _e( 'Banner Image URL 2 :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('image2'); ?>" name="<?php echo $this->get_field_name('image2'); ?>" type="text" value="<?php echo $image2; ?>" />
		</p>		
		
		<!-- Link2 --> 
		<p>
			<label for="<?php echo $this->get_field_id('link2'); ?>"><?php _e( 'Banner Link 2 :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('link2'); ?>" name="<?php echo $this->get_field_name('link2'); ?>" type="text" value="<?php echo $link2; ?>" />
		</p>		
		
		<!-- Bottom Margin --> 
		<p>
			<label for="<?php echo $this->get_field_id('bottom_margin'); ?>"><?php _e( 'Bottom Margin :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('bottom_margin'); ?>" name="<?php echo $this->get_field_name('bottom_margin'); ?>" type="text" value="<?php echo $bottom_margin; ?>" />
		</p>		
		
		<?php
    }  
	
	// Update the widget
	function update($new_instance, $old_instance){  
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['image'] = strip_tags($new_instance['image']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['image2'] = strip_tags($new_instance['image2']);
		$instance['link2'] = strip_tags($new_instance['link2']);
		$instance['bottom_margin'] = strip_tags($new_instance['bottom_margin']);
		
		return $instance;
    }
	
}  

?>