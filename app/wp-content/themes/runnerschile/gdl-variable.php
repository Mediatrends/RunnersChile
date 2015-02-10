<?php
	/*	
	*	Goodlayers Variable File
	*	----------------------------------------------
	*/
	
	/////////////////// BLOG ///////////////////////
	// Blog Thumbnail Size  
	$blog_div_size_num_class = array(
		"1/4 Blog Grid" => array( "no-sidebar"=>"400x250", "one-sidebar"=>"400x230", "both-sidebar"=>"400x230", "class"=>"gdl-blog-grid" ),
		"1/3 Blog Grid" => array( "no-sidebar"=>"400x200", "one-sidebar"=>"400x230", "both-sidebar"=>"400x300", "class"=>"gdl-blog-grid" ),
		"1/2 Blog Grid" => array( "no-sidebar"=>"580x250", "one-sidebar"=>"400x220", "both-sidebar"=>"400x220", "class"=>"gdl-blog-grid" ),
		"1/1 Blog Grid" => array( "no-sidebar"=>"1140x370", "one-sidebar"=>"820x300", "both-sidebar"=>"595x240", "class"=>"gdl-blog-grid" ),			
		"1/1 Blog List" => array( "no-sidebar"=>"75x52", "one-sidebar"=>"75x52", "both-sidebar"=>"75x52", "class"=>"gdl-blog-list" ),
		"1/1 Blog Grid List" => array( "no-sidebar"=>"1140x370", "one-sidebar"=>"820x300", "both-sidebar"=>"595x340", "class"=>"gdl-blog-grid-list" ),			
		"1/1 Medium Thumbnail" => array( "no-sidebar"=>"500x300", "one-sidebar"=>"440x270", "both-sidebar"=>"400x260", "class"=>"gdl-blog-medium" ),
		"1/1 Full Thumbnail" => array( "no-sidebar"=>"1140x370", "one-sidebar"=>"820x300", "both-sidebar"=>"595x240", "class"=>"gdl-blog-full" ),
	);
	
	// Single Blog Thumbnail Size ( Inner Thumbnail Size)
	$blog_single_size = array( "no-sidebar"=>"1140x370", "one-sidebar"=>"820x300", "both-sidebar"=>"595x240" );
	
	/////////////////// PORTFOLIO ///////////////////////
	// Port Thumbnail Size  
	$port_div_size_num_class = array(
		"1/4" => array("no-sidebar"=>"400x400", "one-sidebar"=>"400x700", "both-sidebar"=>"400x400"), 
		"1/3" => array("no-sidebar"=>"400x250", "one-sidebar"=>"400x300", "both-sidebar"=>"400x300"), 
		"1/2" => array("no-sidebar"=>"580x250", "one-sidebar"=>"400x250", "both-sidebar"=>"400x250"),
		"1/1" => array("no-sidebar"=>"1140x370", "one-sidebar"=>"620x245", "both-sidebar"=>"460x180"));
		
	// Single Port Thumbnail Size ( Inner Thumbnail Size)
	$port_single_size = array( "no-sidebar"=>"full", "one-sidebar"=>"full", "both-sidebar"=>"full" );		
		
	/////////////////// GALLERY ///////////////////////
	$gallery_div_size_num_class = array(
		'1/4' => array( 'no-sidebar'=>'400x400', 'one-sidebar'=>'400x400', 'both-sidebar'=>'400x400' ),
		'1/3' => array( 'no-sidebar'=>'400x400', 'one-sidebar'=>'400x400', 'both-sidebar'=>'400x400' ),
		'1/2' => array( 'no-sidebar'=>'560x300', 'one-sidebar'=>'400x400', 'both-sidebar'=>'400x400' ),
	); 	
	
	/////////////////// PERSONNAL ///////////////////////
	$personnal_div_size_num_class = array(
		'1/4' => array( 'no-sidebar'=>'400x380', 'one-sidebar'=>'400x380', 'both-sidebar'=>'400x380' ),
		'1/3' => array( 'no-sidebar'=>'400x380', 'one-sidebar'=>'400x380', 'both-sidebar'=>'400x380' ),
		'1/2' => array( 'no-sidebar'=>'560x300', 'one-sidebar'=>'400x380', 'both-sidebar'=>'400x380' ),
	); 	
	
	/////////////////// PERSONNAL WIDGET ///////////////////////
	$personnal_widget_size = '300x200';
	
	/////////////////// BLOG/PORT WIDGET ///////////////////////
	$blog_full_widget_size = '400x230';
	$blog_port_widget_size = '75x52';
?>