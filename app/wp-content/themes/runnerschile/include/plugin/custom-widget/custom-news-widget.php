<?php
/**
 * Plugin Name: Goodlayers News Widget
 * Plugin URI: http://goodlayers.com/
 * Description: Goodlayers News Widget that grab the latest post, popular post and latest comment.
 * Version: 1.0
 * Author: Goodlayers
 * Author URI: http://www.goodlayers.com
 *
 */

add_action( 'widgets_init', 'goodlayers_news_widget_init' );
function goodlayers_news_widget_init(){
	register_widget('Goodlayers_news_widget');      
}


class Goodlayers_news_widget extends WP_Widget {  

	// Initialize the widget
    function Goodlayers_news_widget() {
        parent::WP_Widget('goodlayers-news-widget', __('Tab Widget (Goodlayers)','gdl_back_office'), 
			array('description' => __('A widget that show lastest posts, popular post and latest comments', 'gdl_back_office')));  
    }  
	
	// Output of the widget
	function widget($args, $instance) {  
		global $gdl_widget_date_format;;
	
		extract( $args );
		
		$num_fetch = $instance['num_fetch'];
		$category = $instance['category'];
		if($category == "All"){ $category = ''; }

		echo $before_widget;
			
		$query_arrays = array(
			array('id'=>'gdl-widget-latest-post', 'title'=> __('RECIENTES','gdl_front_end'), 'type'=>'post',
				'condition'=>'showposts=' . $num_fetch . '&category_name=' . $category),
			array('id'=>'gdl-widget-popular-post', 'title'=> __('POPULARES','gdl_front_end'), 'type'=>'post',
				'condition'=>'showposts=' . $num_fetch . '&category_name=' . $category . '&orderby=comment_count'),	
			array('id'=>'gdl-widget-latest-comment', 'title'=> __('COMENTARIOS','gdl_front_end'), 'type'=>'comment' )
		);
		
		echo '<div class="gdl-tab-widget-wrapper">';
		
		// Tab header
		$current_tab = ' active ';
		echo '<div class="gdl-tab-widget-header-wrapper">';		
		foreach( $query_arrays as $query_array ){
			echo '<h4 class="gdl-tab-widget-header-item">';
			echo '<a class="' . $current_tab . '" data-id="' . $query_array['id'] . '">';
			echo $query_array['title'];
			echo '</a>';
			echo '</h4>';
			
			$current_tab = '';
		}
		echo '<div class="clear"></div>';
		echo '</div>'; // gdl-tab-widget-header-wrapper
		
		
		// Tab content
		$current_tab = ' active ';
		echo '<div class="gdl-tab-widget-content-wrapper">';
		foreach( $query_arrays as $query_array ){
		
			echo '<div class="gdl-tab-widget-content-item ' . $current_tab . '" data-id="' . $query_array['id'] . '">';
			if( $query_array['type'] == 'post'){
				$custom_posts = get_posts($query_array['condition']); 
				echo '<div class="gdl-recent-post-widget">';
				foreach( $custom_posts as $custom_post ){
					?>
					<div class="recent-post-widget">
						<?php
							$thumbnail_id = get_post_thumbnail_id( $custom_post->ID );				
							$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '75x55' );
							if( $thumbnail_id ){
								echo '<div class="recent-post-widget-thumbnail">';
								echo '<a href="' . get_permalink( $custom_post->ID ) . '">';
								$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
								if( !empty($thumbnail) ){
									echo '<img src="' . $thumbnail[0] . '" alt="'. $alt_text .'"/>';
								}	
								echo '</a>';
								echo '</div>';
							}
						?>
						
						<div class="recent-post-widget-context">
							<h4 class="recent-post-widget-title">
								<a href="<?php echo get_permalink( $custom_post->ID ); ?>"> 
									<?php _e( $custom_post->post_title, 'gdl_front_end'); ?> 
								</a>
							</h4>
							<div class="recent-post-widget-info">
								<div class="recent-post-widget-date">
									<?php 
										echo '<a href="' . get_day_link( get_the_time('Y', $custom_post->ID), get_the_time('m', $custom_post->ID), get_the_time('d', $custom_post->ID)) . '" >';
										echo __('Posted On' , 'gdl_front_end') . ' ';
										echo get_the_time($gdl_widget_date_format, $custom_post->ID); 
										echo '</a>';
									?>
								</div>		
							</div>
						</div>
						<div class="clear"></div>
					</div>						
					<?php 
				}			
				echo '</div>';
			}else{
			
				$posts_in_cat = get_post_title_id($category);
				$recent_comments = get_comments( array('post_id__in'=>$posts_in_cat, 'number'=>$num_fetch, 'status'=>'approve') );
				
				echo '<div class="gdl-recent-comment-widget">';
				foreach( $recent_comments as $recent_comment ){
					$comment_permalink = get_permalink( $recent_comment->comment_post_ID ) . '#comment-' . $recent_comment->comment_ID
					?>
					<div class="recent-comment-widget" >
						<div class="recent-comment-widget-thumbnail">
							<a href="<?php echo $comment_permalink; ?>">
								<?php echo get_avatar( $recent_comment->user_id, 55 ); ?>
							</a>
						</div>
						<div class="recent-comment-widget-context">
							<h4 class="recent-comment-widget-title">
								<a href="<?php echo $comment_permalink; ?>"> 
									<?php echo gdl_get_excerpt(45, '...', __($recent_comment->comment_content, 'gdl_front_end')); ?> 
								</a>
							</h4>
							<div class="recent-comment-widget-info">
								<div class="recent-comment-widget-date">
									<?php echo __('Posted On' , 'gdl_front_end'); ?>
									<?php echo get_comment_date($gdl_widget_date_format, $recent_comment->comment_ID); ?>
								</div>		
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<?php
				}
				echo '</div>';
			}
			echo '</div>';
			
			$current_tab = '';
		}
		echo '</div>'; // gdl-tab-widget-content-wrapper
		
		echo '<div class="clear"></div>';
		echo '</div>'; // gdl-widget-tab
					
		echo $after_widget;	

		wp_deregister_script('gdl-tab-widget');
		wp_register_script('gdl-tab-widget', GOODLAYERS_PATH.'/javascript/gdl-tab-widget.js', false, '1.0', true);
		wp_enqueue_script('gdl-tab-widget');				
    }  	
	
	// Widget Form
	function form($instance) {  
		if ( $instance ) {
			$num_fetch = esc_attr( $instance[ 'num_fetch' ] );
			$category = esc_attr( $instance[ 'category' ] );
		} else {
			$num_fetch = '3';
			$category = '';
		}
		
		?>
		
		<!-- Num Fetch --> 
		<p>
			<label for="<?php echo $this->get_field_id('num_fetch'); ?>"><?php _e( 'Num Fetch :', 'gdl_back_office' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('num_fetch'); ?>" name="<?php echo $this->get_field_name('num_fetch'); ?>" type="text" value="<?php echo $num_fetch; ?>" />
		</p>			
		
		<!-- Post Category --> 
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e( 'Category :', 'gdl_back_office' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" >
				<?php 
					 $category_lists = get_category_list('category');
					foreach( $category_lists as $category_list ){
						$selected = ( $category == $category_list )? 'selected': '';
						echo '<option ' . $selected . '>' . $category_list . '</option>';
					}
				?>
			</select>
		</p>		
		<?php 
    }  
	
	// Update the widget
	function update($new_instance, $old_instance) {  
		$instance = $old_instance;
		$instance['num_fetch'] = strip_tags($new_instance['num_fetch']);
		$instance['category'] = strip_tags($new_instance['category']);
		
		return $instance;
    }  
	
}  

?>