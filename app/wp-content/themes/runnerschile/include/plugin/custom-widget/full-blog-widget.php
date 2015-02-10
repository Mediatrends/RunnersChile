<?php
/**
 * Plugin Name: Goodlayers Full Post
 * Plugin URI: http://goodlayers.com/
 * Description: A widget that show posts with excerpt( Specified by category ).
 * Version: 1.0
 * Author: Goodlayers
 * Author URI: http://www.goodlayers.com
 *
 */

add_action( 'widgets_init', 'full_post_widget' );
function full_post_widget() {
	register_widget( 'Full_Post' );
}

class Full_Post extends WP_Widget {

	// Initialize the widget
	function Full_Post() {
		parent::WP_Widget('full-post-widget', __('Full Post Widget (Goodlayers)','gdl_back_office'), 
			array('description' => __('A widget that show lastest posts with excerpt', 'gdl_back_office')));  
	}

	// Output of the widget
	function widget( $args, $instance ) {
		global $gdl_widget_date_format, $blog_full_widget_size;
		
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$post_cat = $instance['post_cat'];
		$show_num = $instance['show_num'];
		$num_excerpt = $instance['num_excerpt'];
		
		if($post_cat == "All"){ $post_cat = ''; }
		
		// Opening of widget
		echo $before_widget;
		
		// Open of title tag
		if ( $title ){ 
			echo $before_title . $title . $after_title; 
		}
			
		// Widget Content
		$current_post = array(get_the_ID());		
		query_posts( array('showposts'=>$show_num, 'category_name'=>$post_cat, 
			'post__not_in'=>$current_post) );
		
		if( have_posts() ){ 
			echo "<div class='gdl-full-post-widget'>";
			while( have_posts() ){ the_post(); 
				?>
				<div class="full-post-widget">
					<?php
						$thumbnail_id = get_post_thumbnail_id( get_the_ID() );				
						$thumbnail = wp_get_attachment_image_src( $thumbnail_id , $blog_full_widget_size );
						if( $thumbnail_id ){
							echo '<div class="full-post-widget-thumbnail">';
							echo '<a href="' . get_permalink() . '">';
							$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
							if( !empty($thumbnail) ){
								echo '<img src="' . $thumbnail[0] . '" alt="'. $alt_text .'"/>';
							}	
							echo '</a>';

							echo '<div class="blog-comment"><i class="icon-comments"></i>';
							comments_popup_link( __('0','gdl_front_end'),
								__('1','gdl_front_end'),
								__('%','gdl_front_end'), '',
								__('Off','gdl_front_end') );
							echo '</div>';								
							echo '</div>';
						}
					?>
					
					<div class="full-post-widget-context">
						<h4 class="full-post-widget-title">
							<a href="<?php echo get_permalink(); ?>"> 
								<?php echo get_the_title(); ?> 
							</a>
						</h4>
						<div class="full-post-widget-excerpt">
							<?php echo gdl_get_excerpt($num_excerpt); ?>
						</div>
						<div class="full-post-widget-info">
							<div class="full-post-widget-date">
								<?php
									echo __('Posted On' , 'gdl_front_end') . ' ';
									echo get_the_time($gdl_widget_date_format);								
								?>
							</div>						
						</div>
					</div>
					<div class="clear"></div>
				</div>						
				<?php 
				
			}
			echo "</div>";
		}
		
		// Closing of widget
		echo $after_widget;	

		wp_reset_query();		
	}

	// Widget Form
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$post_cat = esc_attr( $instance[ 'post_cat' ] );
			$show_num = esc_attr( $instance[ 'show_num' ] );
			$num_excerpt = esc_attr( $instance[ 'num_excerpt' ] );
		} else {
			$title = '';
			$post_cat = '';
			$show_num = '3';
			$num_excerpt = 150;
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
			$category_list = get_category_list( 'category' ); 
			foreach($category_list as $category){ 
			?>
				<option value="<?php echo $category; ?>" <?php if ( $post_cat == $category ) echo ' selected="selected"'; ?>><?php echo $category; ?></option>				
			<?php } ?>	
			</select> 
		</p>
			
		<!-- Show Num --> 
		<p>
			<label for="<?php echo $this->get_field_id( 'show_num' ); ?>"><?php _e('Show Count :', 'gdl_back_office'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" type="text" value="<?php echo $show_num; ?>" />
		</p>
		
		<!-- Num Excerpt --> 
		<p>
			<label for="<?php echo $this->get_field_id( 'num_excerpt' ); ?>"><?php _e('Num Excerpt :', 'gdl_back_office'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'num_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'num_excerpt' ); ?>" type="text" value="<?php echo $num_excerpt; ?>" />
		</p>		

	<?php
	}
	
	// Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_cat'] = strip_tags( $new_instance['post_cat'] );
		$instance['show_num'] = strip_tags( $new_instance['show_num'] );
		$instance['num_excerpt'] = strip_tags( $new_instance['num_excerpt'] );

		return $instance;
	}	
}

?>