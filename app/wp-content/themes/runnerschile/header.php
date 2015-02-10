<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php bloginfo('name'); ?>  <?php wp_title(); ?></title>

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- CSS
  ================================================== -->
	<?php global $gdl_is_responsive; ?>
	<?php if( $gdl_is_responsive ){ ?>
		<meta name="viewport" content="width=device-width, user-scalable=no">
	<?php } ?>
	
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/ie7-style.css" /> 
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/font-awesome/font-awesome-ie7.min.css" /> 
	<![endif]-->	
	
	<?php
	
		// include favicon in the header
		if(get_option( THEME_SHORT_NAME.'_enable_favicon','disable') == "enable"){
			$gdl_favicon = get_option(THEME_SHORT_NAME.'_favicon_image');
			if( $gdl_favicon ){
				$gdl_favicon = wp_get_attachment_image_src($gdl_favicon, 'full');
				echo '<link rel="shortcut icon" href="' . $gdl_favicon[0] . '" type="image/x-icon" />';
			}
		} 
		
		// add facebook thumbnail to this page
		$thumbnail_id = get_post_thumbnail_id();
		if( !empty($thumbnail_id) ){
			$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '150x150' );
			echo '<meta property="og:image" content="' . $thumbnail[0] . '"/>';		
		}
		
		// start calling header script
		wp_head();		

	?>
</head>
<body <?php echo body_class(); ?>>
<?php
	// print custom background
	$background_style = get_option(THEME_SHORT_NAME.'_background_style', 'Pattern');
	if($background_style == 'Custom Image'){
		$background_id = get_option(THEME_SHORT_NAME.'_background_custom');
		$alt_text = get_post_meta($background_id , '_wp_attachment_image_alt', true);
		
		if(!empty($background_id)){
			$background_image = wp_get_attachment_image_src( $background_id, 'full' );
			echo '<div class="gdl-custom-full-background">';
			echo '<img src="' . $background_image[0] . '" alt="' . $alt_text . '" />';
			echo '</div>';
		}
	}
?>
<div class="body-outer-wrapper">
	<div class="body-wrapper">
		<div class="header-outer-wrapper">
			<!-- top navigation -->
			<?php if( get_option(THEME_SHORT_NAME.'_enable_top_bar' ,true) == 'enable'){ ?>
				<div class="top-navigation-wrapper boxed-style">
					<div class="top-navigation-container container">
						<?php
							
							if( has_nav_menu('top_menu') ){
								echo '<div class="top-navigation-left">';
								echo '<div class="top-superfish-wrapper" id="top-superfish-wrapper" >';
								wp_nav_menu( array('container' => '', 'menu_class'=> 'top-menu',  'theme_location' => 'top_menu' ) );
								echo '<div class="clear"></div>';
								echo '</div>';			
								
								if( $gdl_is_responsive ){
									echo '<div class="top-responsive-wrapper" >';								
									dropdown_menu( array('dropdown_title' => '-- Top Menu --', 'indent_string' => '- ', 'indent_after' => '', 'theme_location'=>'top_menu') );
									echo '</div>';
								}
								echo '</div>';
							}			

							echo '<div class="top-navigation-right">';

							if( get_option(THEME_SHORT_NAME.'_enable_top_search', 'enable') == 'enable' ){
								echo '<div class="top-search-wrapper">'; 
								?>
								<div class="gdl-search-form">
									<form method="get" id="searchform" action="<?php  echo home_url(); ?>/">
										<input type="submit" id="searchsubmit" value="" />
										<div class="search-text" id="search-text">
											<input type="text" value="" name="s" id="s" autocomplete="off" data-default="<?php echo $search_val; ?>" />
										</div>
										<div class="clear"></div>
									</form>
								</div>
								<?php
								echo '</div>';
							}
							
							// Get Social Icons
							$gdl_social_icon = array(
								'deviantart'=> array('name'=>THEME_SHORT_NAME.'_deviantart', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/deviantart.png'),
								'digg'=> array('name'=>THEME_SHORT_NAME.'_digg', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/digg.png'),
								'facebook' => array('name'=>THEME_SHORT_NAME.'_facebook', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/facebook.png'),
								'flickr' => array('name'=>THEME_SHORT_NAME.'_flickr', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/flickr.png'),
								'lastfm'=> array('name'=>THEME_SHORT_NAME.'_lastfm', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/lastfm.png'),
								'linkedin' => array('name'=>THEME_SHORT_NAME.'_linkedin', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/linkedin.png'),
								'picasa'=> array('name'=>THEME_SHORT_NAME.'_picasa', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/picasa.png'),
								'rss'=> array('name'=>THEME_SHORT_NAME.'_rss', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/rss.png'),
								'stumble-upon'=> array('name'=>THEME_SHORT_NAME.'_stumble_upon', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/stumble-upon.png'),
								'tumblr'=> array('name'=>THEME_SHORT_NAME.'_tumblr', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/tumblr.png'),
								'twitter' => array('name'=>THEME_SHORT_NAME.'_twitter', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/twitter.png'),
								'vimeo' => array('name'=>THEME_SHORT_NAME.'_vimeo', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/vimeo.png'),
								'youtube' => array('name'=>THEME_SHORT_NAME.'_youtube', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/youtube.png'),
								'google_plus' => array('name'=>THEME_SHORT_NAME.'_google_plus', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/google-plus.png'),
								'email' => array('name'=>THEME_SHORT_NAME.'_email', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/email.png'),
								'pinterest' => array('name'=>THEME_SHORT_NAME.'_pinterest', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/pinterest.png')
							);				
							
							echo '<div id="gdl-social-icon" class="social-wrapper gdl-retina">';
							echo '<div class="social-icon-wrapper">';
							foreach( $gdl_social_icon as $social_name => $social_icon ){
								$social_link = get_option($social_icon['name']);
								
								if( !empty($social_link) ){
									echo '<div class="social-icon"><a target="_blank" href="' . $social_link . '">' ;
									echo '<img src="' . $social_icon['url'] . '" alt="' . $social_name . '" width="18" height="18" />';
									echo '</a></div>';
								}
							}
							echo '</div>'; // social icon wrapper
							echo '</div>'; // social wrapper	
							
							$top_right_text = get_option(THEME_SHORT_NAME.'_top_navigation_right');
							if( !empty($top_right_text) ){
								echo '<div class="top-navigation-right-text">';
								echo do_shortcode( __( $top_right_text , 'gdl_front_end') );
								echo '</div>';
							}
							
							echo '</div>'; // top navigation right
						?>
						<div class="clear"></div>
					</div>
				</div> <!-- top navigation wrapper -->
			<?php } ?>
			
			<div class="header-wrapper boxed-style">
				<div class="header-container container">
					<!-- Get Logo -->
					<div class="logo-wrapper">
						<?php
							$logo_id = get_option(THEME_SHORT_NAME.'_logo');
							if( empty($logo_id) ){	
								$alt_text = 'default-logo';	
								$logo_attachment = GOODLAYERS_PATH . '/images/default-logo.png';
							}else{
								$alt_text = get_post_meta($logo_id , '_wp_attachment_image_alt', true);	
								$logo_attachment = wp_get_attachment_image_src($logo_id, 'full');
								$logo_attachment = $logo_attachment[0];
							}

							if( is_front_page() ){
								echo '<h1><a href="'; 
								echo home_url();
								echo '"><img src="' . $logo_attachment . '" alt="' . $alt_text . '"/></a></h1>';	
							}else{
								echo '<a href="'; 
								echo home_url();
								echo '"><img src="' . $logo_attachment . '" alt="' . $alt_text . '"/></a>';				
							}
						?>
					</div>
					
					<!-- Right Banner Area -->
					<div class="header-right-banner-wrapper">
					<?php 
						$banner_id = get_option(THEME_SHORT_NAME.'_header_banner_image');
						$banner_link = get_option(THEME_SHORT_NAME.'_header_banner_image_link');
						if( !empty($banner_id) ){
							$banner_image = wp_get_attachment_image_src($banner_id, 'full');
							$alt_text = get_post_meta($banner_id , '_wp_attachment_image_alt', true);	

							echo '<div class="header-banner-image" >';
							echo '<a href="' . $banner_link . '" target="_blank" >';
							echo '<img src="' . $banner_image[0] . '" alt="' . $alt_text . '"/>';
							echo '</a>';
							echo '</div>';
						}
						
						$banner_script = get_option(THEME_SHORT_NAME.'_header_banner_script');
						if( !empty($banner_script) ){
							echo '<div class="header-banner-image" >' . do_shortcode($banner_script) . '</div>';						
						}
						
					?>
					</div>
					<div class="clear"></div>		
				</div> <!-- header container -->
			</div> <!-- header wrapper -->
			
			<!-- Navigation -->
			<div class="gdl-navigation-wrapper boxed-style">
				<?php 
					// responsive menu
					if( $gdl_is_responsive && has_nav_menu('main_menu') ){
						dropdown_menu( array('dropdown_title' => __('-- Main Menu --', 'gdl_front_end'), 'indent_string' => '- ', 'indent_after' => '','container' => 'div', 'container_class' => 'responsive-menu-wrapper', 'theme_location'=>'main_menu') );	
						echo '<div class="clear"></div>';
					}
					
					// main menu
					echo '<div class="main-navigation-wrapper">';
					if( has_nav_menu('main_menu') ){
						echo '<div class="main-superfish-wrapper" id="main-superfish-wrapper" >';
						wp_nav_menu( array('container' => '', 'menu_class'=> 'sf-menu',  'theme_location' => 'main_menu' ) );
						echo '<div class="clear"></div>';
						echo '</div>';
					}
					
					if( get_option(THEME_SHORT_NAME.'_enable_random_post', 'enable') == 'enable' ){
						$random_post = get_posts(array('orderby'=>'rand', 'posts_per_page'=>'1' ));
						
						if( !empty( $random_post ) ){
							echo '<div class="random-post" >';
							echo '<a href="' . get_permalink($random_post[0]->ID) . '" >';
							echo '<i class="icon-random" ></i>';
							echo '</a>';
							echo '</div>';
						}
					}
					
					echo '<div class="clear"></div>';
					echo '</div>'; // navigation-wrapper 
					
					// Post ticker
					global $gdl_top_sliding;
					if( $gdl_top_sliding ){
						global $gdl_admin_translator;
						if( $gdl_admin_translator == 'enable' ){
							$translator_breaking_news = get_option(THEME_SHORT_NAME.'_translator_breaking_news', 'BREAKING NEWS');
						}else{
							$translator_breaking_news = __('BREAKING NEWS', 'gdl_front_end');		
						}						
					
						$num_fetch = get_option(THEME_SHORT_NAME.'_top_sliding_num_fetch', 5);
						$category = get_option(THEME_SHORT_NAME.'_top_sliding_category', 'All');
						if( $category == 'All' ) $category = '';
						
						query_posts(array('category_name'=>$category, 'posts_per_page'=>$num_fetch));
						if( have_posts() ){
							echo '<div class="header-top-marquee" >';
							echo '<div class="marquee-head">' . $translator_breaking_news . '</div>';
							echo '<div class="marquee-wrapper">';
							echo '<div class="marquee" id="marquee">';
							while( have_posts() ){ the_post();
								echo '<div><a href="' . get_permalink() . '" >' . get_the_title() . '</a></div>';
							}
							echo '</div>'; // marquee
							echo '<div class="clear"></div>';
							echo '</div>'; // marquee-wrapper
							
							echo '</div>'; // header-top-marquee
						}
						
						wp_reset_query();
					}
				?>
				<div class="clear"></div>
			</div>	<!-- navigation-wrapper -->		
			
		</div> <!-- header outer wrapper -->
		<?php

			if( is_page() ){
				// Top Slider Part
				global $gdl_top_slider_xml, $gdl_top_slider_type;
				
				if( empty($gdl_top_slider_type) || $gdl_top_slider_type == 'Title' || $gdl_top_slider_type == 'No Slider' ){
					$page_caption = get_post_meta($post->ID, 'page-option-caption', true);
					print_page_header(get_the_title(), $page_caption);					
				}else if ( $gdl_top_slider_type == "Post Slider" ){
					$category = get_post_meta($post->ID, 'page-option-post-slider-category', true);
					$num_fetch = get_post_meta($post->ID, 'page-option-post-slider-num-fetch', true);
					$width = get_post_meta($post->ID, 'page-option-post-slider-width', true);
					$height = get_post_meta($post->ID, 'page-option-post-slider-height', true);
					
					echo '<div class="gdl-top-slider boxed-style">';
					echo '<div class="gdl-top-slider-wrapper">';	
					print_top_post_slider_item( $category, $num_fetch, $width, $height );
					echo '<div class="clear"></div>';
					echo '<div class="page-title-top-shadow"></div>';
					echo '</div>';
					echo '</div>';					
				}else if ( $gdl_top_slider_type != "None"){
					echo '<div class="gdl-top-slider boxed-style">';
					echo '<div class="gdl-top-slider-wrapper">';			
					$slider_xml = "<Slider>" . create_xml_tag('size', 'full-width');
					$slider_xml = $slider_xml . create_xml_tag('slider-type', $gdl_top_slider_type);
					$slider_xml = $slider_xml . $gdl_top_slider_xml;
					$slider_xml = $slider_xml . "</Slider>";
					$slider_xml_dom = new DOMDocument();
					$slider_xml_dom->loadXML($slider_xml);
					print_slider_item($slider_xml_dom->documentElement);
					echo '<div class="clear"></div>';
					echo '<div class="page-title-top-shadow"></div>';
					echo '</div>';
					echo '</div>';
				}	
			}else if( is_single() ){
				$current_page_style = get_option(THEME_SHORT_NAME.'_use_portfolio_as', 'portfolio style');
				if( $post->post_type == 'portfolio' && $current_page_style == 'portfolio style' ){
					$single_title = get_the_title();
					$single_caption = get_post_meta( $post->ID, "post-option-blog-header-caption", true);
					print_page_header($single_title, $single_caption);					
				}	
			}else if( is_404() ){
				global $gdl_admin_translator;
				if( $gdl_admin_translator == 'enable' ){
					$translator_404_title = get_option(THEME_SHORT_NAME.'_404_title', 'Page Not Found');
				}else{
					$translator_404_title = __('Page Not Found','gdl_front_end');		
				}			
				print_page_header($translator_404_title);
			}else if( is_search() ){
				global $gdl_admin_translator;
				if( $gdl_admin_translator == 'enable' ){
					$title = get_option(THEME_SHORT_NAME.'_search_header_title', 'Search Results');
				}else{
					$title = __('Search Results', 'gdl_front_end');
				}		
				
				$caption = get_search_query();
				print_page_header($title, $caption);
			}else if( is_archive() ){
				
				if( is_category() || is_tax('portfolio-category') || is_tax('product_cat') ){
					$title = __('Category','gdl_front_end');
					$caption = single_cat_title('', false);
				}else if( is_tag() || is_tax('portfolio-tag') || is_tax('product_tag') ){
					$title = __('Tag','gdl_front_end');
					$caption = single_cat_title('', false);
				}else if( is_day() ){
					$title = __('Day','gdl_front_end');
					$caption = get_the_date('F j, Y');
				}else if( is_month() ){
					$title = __('Month','gdl_front_end');
					$caption = get_the_date('F Y');
				}else if( is_year() ){
					$title = __('Year','gdl_front_end');
					$caption = get_the_date('Y');
				}else if( is_author() ){
					$title = __('By','gdl_front_end');
					
					$author_id = get_query_var('author');
					$author = get_user_by('id', $author_id);
					$caption = $author->display_name;					
				}else{
					$title = __('Shop','gdl_front_end');
				}
						
				print_page_header($title, $caption);				
			} 
		?>
		<div class="content-outer-wrapper">
			<div class="content-wrapper container main ">