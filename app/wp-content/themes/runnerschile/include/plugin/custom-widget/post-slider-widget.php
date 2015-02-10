<?php
/**
 * Plugin Name: Goodlayers Recent Post Slider
 * Plugin URI: http://goodlayers.com/
 * Description: A widget that show recent posts( Specified by category ) in slider.
 * Version: 1.0
 * Author: Goodlayers
 * Author URI: http://www.goodlayers.com
 *
 */

add_action( 'widgets_init', 'recent_post_slider_widget' );
function recent_post_slider_widget() {
	register_widget( 'Recent_Post_Slider' );
}

class Recent_Post_Slider extends WP_Widget {

	// Initialize the widget
	function Recent_Post_Slider() {
		parent::WP_Widget('recent-post-slider-widget', __('Recent Post Slider Widget (Goodlayers)','gdl_back_office'), 
			array('description' => __('A widget that show lastest posts in slider', 'gdl_back_office')));  
	}

	// Output of the widget
	function widget( $args, $instance ) {
		global $gdl_widget_date_format;
		
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$post_cat = $instance['post_cat'];
		$show_num = $instance['show_num'];
		
		if($post_cat == "All"){ $post_cat = ''; }
		
		// Opening of widget
		echo $before_widget;
		
		// Open of title tag
		if ( $title ){ 
			echo $before_title . $title . $after_title; 
		}
			
		// Widget Content
		wp_reset_query();
		$current_post = array(get_the_ID());		
		$custom_posts = get_posts( array('showposts'=>$show_num, 'category_name'=>$post_cat, 
			'post__not_in'=>$current_post) );
		
		if( !empty($custom_posts) ){ 
			echo "<div class='gdl-recent-post-slider-widget-wrapper'>";
			echo "<div class='gdl-recent-post-slider-widget'>";
			foreach($custom_posts as $custom_post) { 
				?>
				<div class="recent-post-slider-widget">
					<?php
						$thumbnail_id = get_post_thumbnail_id( $custom_post->ID );				
						$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '400x270' );
						if( $thumbnail_id ){
							echo '<div class="recent-post-slider-thumbnail">';
							echo '<a href="' . get_permalink( $custom_post->ID ) . '">';
							$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
							if( !empty($thumbnail) ){
								echo '<img src="' . $thumbnail[0] . '" alt="'. $alt_text .'"/>';
							}	
							echo '</a>';
							echo '</div>';
						}
					?>
					
					<div class="recent-post-slider-caption">
						<h4 class="recent-post-slider-title">
							<a href="<?php echo get_permalink( $custom_post->ID ); ?>"> 
								<?php _e( $custom_post->post_title, 'gdl_front_end'); ?> 
							</a>
						</h4>
					</div>
					<div class="clear"></div>
				</div>						
				<?php 
				
			}
			echo '</div>'; // gdl-recent-post-slider-widget
			echo '<div class="recent-post-slider-nav" >';
			echo '<a class="prev"></a>';
			echo '<a class="next"></a>';
			echo '</div>'; // recent-post-slider-nav
			echo '</div>'; // gdl-recent-post-slider-widget-wrapper
		}
		
		// Closing of widget
		echo $after_widget;		
		
		wp_deregister_script('jquery-cycle');
		wp_register_script('jquery-cycle', GOODLAYERS_PATH.'/javascript/jquery.cycle.js', false, '1.0', true);
		wp_enqueue_script('jquery-cycle');		
	}

	// Widget Form
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$post_cat = esc_attr( $instance[ 'post_cat' ] );
			$show_num = esc_attr( $instance[ 'show_num' ] );
		} else {
			$title = '';
			$post_cat = '';
			$show_num = '3';
		}
		?>

		<!-- Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>		

		<!-- Post Category -->
		<p>
			<label for="<?php echo $this->get_field_id( 'post_cat' ); ?>"><?php _e('Category :', 'gdl_back_office'); ?></label>		
			<select class="widefat" name="<?php echo $this->get_field_name( 'post_cat' ); ?>" id="<?php echo $this->get_field_id( 'post_cat' ); ?>">
				<?php 
					$category_lists = get_category_list( 'category' ); 
					foreach( $category_lists as $category_list ){
						$selected = ( $post_cat == $category_list )? 'selected': '';
						echo '<option ' . $selected . '>' . $category_list . '</option>';
					}
				?>			
			</select> 
		</p>
			
		<!-- Show Num --> 
		<p>
			<label for="<?php echo $this->get_field_id( 'show_num' ); ?>"><?php _e('Show Count :', 'gdl_back_office'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" type="text" value="<?php echo $show_num; ?>" />
		</p>

	<?php
	}
	
	// Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_cat'] = strip_tags( $new_instance['post_cat'] );
		$instance['show_num'] = strip_tags( $new_instance['show_num'] );

		return $instance;
	}	
}

?>