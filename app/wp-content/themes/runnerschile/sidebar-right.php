<?php
	global $sidebar;
	if( $sidebar == "right-sidebar" ){
	
		global $right_sidebar;
		echo "<div class='gdl-right-sidebar'>";
		echo "<div class='gdl-sidebar-wrapper gdl-border-y left'>";
		echo "<div class='sidebar-wrapper'>";
		dynamic_sidebar( $right_sidebar );
		echo "</div>";
		echo "</div>";
		echo "</div>";
	
	}else if( $sidebar == "left-sidebar" ){

		global $left_sidebar;
		echo "<div class='gdl-right-sidebar'>";
		echo "<div class='gdl-sidebar-wrapper gdl-border-y left'>";
		echo "<div class='sidebar-wrapper'>";
		dynamic_sidebar( $left_sidebar );
		echo "</div>";
		echo "</div>";
		echo "</div>";
	
	}else if( $sidebar == "both-sidebar" ){
		
		global $right_sidebar;
		echo "<div class='gdl-right-sidebar'>";
		echo "<div class='gdl-sidebar-wrapper gdl-border-y left'>";
		echo "<div class='sidebar-wrapper'>";
		dynamic_sidebar( $right_sidebar );
		echo "</div>";			
		echo "</div>";			
		echo "</div>";				
	
	}else if( $sidebar == "both-sidebar-reverse" ){
		
		global $left_sidebar;
		echo "<div class='gdl-right-sidebar'>";
		echo "<div class='gdl-sidebar-wrapper gdl-border-y left'>";
		echo "<div class='sidebar-wrapper'>";
		dynamic_sidebar( $left_sidebar );
		echo "</div>";			
		echo "</div>";			
		echo "</div>";				
	
	}

?>