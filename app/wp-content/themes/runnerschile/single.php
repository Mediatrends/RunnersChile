<?php get_header(); ?>
	<?php
		// Check and get Sidebar Class
		$sidebar = get_post_meta($post->ID,'post-option-sidebar-template',true);
		if( empty($sidebar) ){
			global $default_post_sidebar;
			$sidebar = $default_post_sidebar; 
		}		
		$sidebar_reverse = ($sidebar == 'both-sidebar-reverse' || 
			$sidebar == 'left-sidebar' )? 'reverse-sidebar': 'normal-sidebar';		
		$sidebar_array = gdl_get_sidebar_size( $sidebar );

		// Translator words
		if( $gdl_admin_translator == 'enable' ){
			$translator_related_posts = get_option(THEME_SHORT_NAME.'_translator_related_posts', 'Related Posts');
			$translator_about_author = get_option(THEME_SHORT_NAME.'_translator_about_author', 'About the Author');
		}else{
			$translator_related_posts = __('Related Posts','gdl_front_end');
			$translator_about_author = __('About the Author','gdl_front_end');
		}
	?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="page-wrapper <?php echo $sidebar_reverse; ?> single-blog <?php echo $sidebar_array['sidebar_class']; ?>">
		<?php
			global $left_sidebar, $right_sidebar, $default_post_left_sidebar, $default_post_right_sidebar;
			$left_sidebar = get_post_meta( $post->ID , "post-option-choose-left-sidebar", true);
			$right_sidebar = get_post_meta( $post->ID , "post-option-choose-right-sidebar", true);
			if( empty( $left_sidebar )){ $left_sidebar = $default_post_left_sidebar; } 
			if( empty( $right_sidebar )){ $right_sidebar = $default_post_right_sidebar; } 
			
			global $blog_single_size, $sidebar_type;
			$item_size = $blog_single_size[$sidebar_type];
	
			// starting the content
			echo '<div class="row gdl-page-row-wrapper">';
			echo '<div class="gdl-page-left mb0 ' . $sidebar_array['page_left_class'] . '">';
			
			echo '<div class="row">';
			echo '<div class="gdl-page-item mb0 pb55 ' . $sidebar_array['page_item_class'] . '">';
			if ( have_posts() ){
				while (have_posts()){
					the_post();
					
					echo '<div class="blog-content-wrapper">';
					echo '<div class="gdl-blog-full" >';
					
					// blog thumbnail
					print_single_blog_thumbnail( get_the_ID(), $item_size );
					
					// blog title
					echo '<h1 class="blog-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';

					// blog information
					echo '<div class="blog-info-wrapper gdl-item-border">';
					echo '<div class="blog-date">';
					echo '<span class="head">' . __('Posted On' , 'gdl_front_end') . '</span> ';
					echo '<a href="' . get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d')) . '" >';
					echo get_the_time($gdl_date_format);
					echo '</a>';
					echo '</div>';			

					echo '<div class="blog-author">';
					echo '<span class="head">' . __('By :' , 'gdl_front_end') . '</span> ';
					echo the_author_posts_link();
					echo '</div>';						
					
					echo '<div class="blog-comment">';
					comments_popup_link( __('Comment: 0','gdl_front_end'),
						__('Comment: 1','gdl_front_end'),
						__('Comments: %','gdl_front_end'), '',
						__('Comment: Off','gdl_front_end') );
					echo '</div>';						
					
					$tags_opening = '<div class="blog-tag">';
					$tags_opening = $tags_opening . '<span class="head">' . __('Tag: ' , 'gdl_front_end') . '</span> ';
					$tags_ending = '</div>';
					the_tags( $tags_opening, ', ', $tags_ending );
					
					echo '<div class="clear"></div>';
					echo '</div>'; // blog information
					
					// blog content
					echo '<div class="blog-content">';
					the_content();
					wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'gdl_front_end' ) . '</span>', 'after' => '</div>' ) );
					echo '<div class="clear"></div>';
					echo '</div>';
								
					echo '</div>'; // gdl-blog-full
					
					// About Author
					if(get_post_meta($post->ID, 'post-option-author-info-enabled', true) != "No"){
						echo "<div class='about-author-wrapper'>";
						echo "<div class='about-author-avartar'>" . get_avatar( get_the_author_meta('ID'), 90 ) . "</div>";
						echo "<div class='about-author-info'>";
						echo "<h5 class='about-author-title'>" . $translator_about_author . "</h5>";
						echo get_the_author_meta('description');
						echo "</div>";
						echo "<div class='clear'></div>";
						echo "</div>";
					}
					
					// Include Social Shares
					if(get_post_meta($post->ID, 'post-option-social-enabled', true) != "No"){
						include_social_shares();
						echo "<div class='clear'></div>";
					}
					
					// adjacent post
					echo '<div class="adjacent-post">';
					previous_post_link(
						'<div class="previous-post-link"><i class="icon-double-angle-left"></i><div class="adjacent-post-content">' . 
						'<div class="previous-post-head">' . __('Previous Story', 'gdl_front_end') . '</div>' .
						'<h3 class="previous-post-title">%link</h3>' . 
						'</div></div>', '%title', true);
					next_post_link(
						'<div class="next-post-link"><i class="icon-double-angle-right"></i><div class="adjacent-post-content">' . 
						'<div class="next-post-head">' . __('Next Story', 'gdl_front_end') . '</div>' .
						'<h3 class="next-post-title">%link</h3>' . 
						'</div></div>', '%title', true);	
					echo '<div class="clear"></div>';
					echo '</div>';
					
					// print related post
					if( get_option(THEME_SHORT_NAME.'_gdl_related_post' ,'Yes') == 'Yes' ){	
						global $blog_div_size_num_class;

						$blog_size = get_option( THEME_SHORT_NAME.'_gdl_related_post_size' , '1/4') . ' Blog Grid';
						$num_fetch = get_option( THEME_SHORT_NAME.'_gdl_related_post_num_fetch' , 4);
						
						$item_class = $blog_div_size_num_class[$blog_size]['class'];
						$item_size = $blog_div_size_num_class[$blog_size][$sidebar_type];	
						
						$blog_tags = get_the_terms(get_the_ID(), 'post_tag');
						$blog_terms = array();
						if( !empty($blog_tags) ){
							foreach( $blog_tags as $blog_tag ){
								$blog_terms[] = $blog_tag->slug;
							}
							
							$current_post = array(get_the_ID());
							$tax_query = array( array('taxonomy'=>'post_tag', 'field'=>'slug', 'terms'=>$blog_terms) );
							query_posts(array('tax_query'=>$tax_query, 'posts_per_page'=>$num_fetch, 
									'post__not_in'=>$current_post));	
									
							if( have_posts() ){ 
								echo '<div class="gdl-related-post">';
								echo '<h3 class="related-post-title gdl-item-border" >' . $translator_related_posts . '</h3>'; 					
								print_blog_grid( $item_class, $item_size, 0, 'No', $blog_size);
								echo '<div class="clear"></div>';
								echo '</div>'; // gdl-related-post		
							}
						}

						wp_reset_query();
					}
				
					echo '<div class="comment-wrapper">';
					comments_template(); 
					echo '</div>';
					
					echo '</div>'; // blog content wrapper
				}
			}
			echo "</div>"; // end of gdl-page-item
			
			get_sidebar('left');	
			echo '<div class="clear"></div>';			
			echo "</div>"; // row
			echo "</div>"; // gdl-page-left

			get_sidebar('right');
			echo '<div class="clear"></div>';
			echo "</div>"; // row
		?>
		<div class="clear"></div>
	</div> <!-- page wrapper -->
	</div> <!-- post class -->

<?php get_footer(); ?>