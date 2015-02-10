<?php
	global $sidebar;
	if( $sidebar == "both-sidebar" ){
	
		global $left_sidebar;
		echo "<div class='three columns mb0 gdl-left-sidebar'>";
		echo "<div class='gdl-sidebar-wrapper gdl-border-y right'>";
		echo "<div class='sidebar-wrapper'>";
		dynamic_sidebar( $left_sidebar );	
		echo "</div>";	
		echo "</div>";	
		echo "</div>";					
	
	}else if( $sidebar == "both-sidebar-reverse" ){
	
		global $right_sidebar;
		echo "<div class='three columns mb0 gdl-left-sidebar'>";
		echo "<div class='gdl-sidebar-wrapper gdl-border-y right'>";
		echo "<div class='sidebar-wrapper'>";
		dynamic_sidebar( $right_sidebar );	
		echo "</div>";	
		echo "</div>";	
		echo "</div>";					
	
	}	

?>