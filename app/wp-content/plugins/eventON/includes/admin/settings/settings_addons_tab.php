<?php

/*
*	Eventon Settings tab - addons and licenses
*	Version: 0.5
*	Last Updated:  2014 Dec
*/
?>
<div id="evcal_4" class="postbox evcal_admin_meta">	
	<?php

		// UPDATE eventon addons list
			$eventon->evo_updater->ADD_update_addons();

		// Remove License for addons
			if(!empty($_REQUEST['action']) && $_REQUEST['action']=='rl' && !empty($_REQUEST['slug'])){
				$slug = $_REQUEST['slug'];
				$eventon->evo_updater->remove_license($slug); 
			}
	?>

	<div class='evo_addons_page addons'>
		<div class="debugAct" style="padding:10px">
			<p style="font-size:20px;">Activation does not work? </p>
			<p>NOTE: EventON and its addons should work <b>100%</b> despite activation.</p>
			<?php // DEBUG report for license activation -->			
				echo evo_debug_report();
			?>
		</div>
		<?php

			$admin_url = admin_url();
			$show_license_msg = true;

			// get all evo product licenses
			$evo_licenses = $eventon->evo_updater->get_licenses();
			$evo_data = $evo_licenses['eventon'];
			
			//print_r($evo_licenses);

			// ACTIVATED
				if($eventon->evo_updater->is_activated('eventon', $evo_licenses)):
					$_has_update = (!empty($evo_data['has_new_update']) && $evo_data['has_new_update'])? true:false;
					$new_update_details_btn = ($_has_update)?
						"<p class='links'><b>".__('New Update availale','eventon')."</b><br/><a href='".$admin_url."update-core.php'>Update Now</a> | <a class='thickbox' href='".BACKEND_URL."plugin-install.php?tab=plugin-information&plugin=eventon&section=changelog&TB_iframe=true&width=600&height=400'>Version Details</a></p>":null;

						$new_update_details_btn = "<br/><br/><a href='http://www.myeventon.com/documentation/' target='_blank'>Documentation</a><br/><a href='http://www.myeventon.com/news/' target='_blank'>News & Updates</a>";

					?>
						<div class="addon main activated <?php echo ($_has_update)? 'hasupdate':null;?>">
							<h2>EventON</h2>
							<p class='version'><?php echo $evo_data['current_version'];?></p>
							<p>License Status: <strong><?php _e('Activated','eventon');?></strong> | <a id='evoDeactLic' style='cursor:pointer'><?php _e('Deactivate','eventon');?></a></p>
							<p>Purchase Key: <strong><?php echo $eventon->evo_updater->get_hidden_key();?></strong></p>
							<p><i><?php _e('Info: You have successfully activated this license on this site. You will need a seperate license to activate eventON for another site.','eventon');?></i><?php $eventon->throw_guide('EventON license you have purchased from Codecanyon, either regular or extended will allow you to install eventON in ONE site only. In order to install eventON in another site you will need a seperate license.');?></p>
							<p class='links'><?php echo $new_update_details_btn;?></p>
						</div>
					<?php 

			// NOT ACTIVATED
			else:
				?>
				<div id='evo_license_main' class="addon main">
					<h2>EventON</h2>
					<p class='version'><?php echo $evo_data['current_version'];?><span>/<?php echo $evo_data['remote_version'];?></span></p>
					<p class='status'>License Status: <strong>Not Activated</strong></p>
					<p class='action'><a class='eventon_popup_trig evo_admin_btn btn_prime' dynamic_c='1' content_id='eventon_pop_content_001' poptitle='Activate EventON License'>Activate Now</a></p>
					<p class='activation_text'><i>Activate your copy of EventON to get <strong>automatic updates</strong> directly and experience <strong>all the features</strong> of eventon. <a href='http://www.myeventon.com/documentation/how-to-find-eventon-license-key/' target='_blank'>How to find activation key</a><?php $eventon->throw_guide('EventON license you have purchased from Codecanyon, either regular or extended will allow you to install eventON in ONE site only. In order to install eventON in another site you will need a seperate license.');?></i></p>

						<div id='eventon_pop_content_001' class='evo_hide_this'>
							<p>Enter your codecanyon Purchase Key:<br/>
							<input class='eventon_license_key_val' type='text' style='width:100%'/>
							<input class='eventon_slug' type='hidden' value='eventon' />
							<input class='eventon_license_div' type='hidden' value='evo_license_main' /><br/><i>More information on <a href='http://www.myeventon.com/documentation/how-to-find-eventon-license-key/' target='_blank'>How to find eventON purchase key</a></i></p>
							<p style='text-align:center'><a class='eventon_submit_license evo_admin_btn btn_prime'>Activate Now</a></p>
						</div>
				</div>
			<?php

			endif;
		?>

		<?php // ADDONS 

			$evo_installed_addons ='';
			$count =1;
			$eventon_addons_opt = get_option('eventon_addons');

			//print_r($eventon_addons_opt);
			
			global $wp_version; 

				//print_r($evo_licenses);
				$_activePlugins =get_option( 'active_plugins' );


				$eventon_addons_opt = base64_encode(serialize($eventon_addons_opt));
				$evo_licenses = base64_encode(serialize($evo_licenses));
				$admin_url = get_admin_url();
				$_activePlugins = (!empty($_activePlugins))? base64_encode(serialize( $_activePlugins)): null;

			?>
				
				<div id='evo_addons_list' data-addons='<?php echo $eventon_addons_opt;?>' data-licenses='<?php echo $evo_licenses;?>' data-url='<?php echo AJDE_EVCAL_URL.'/includes/admin/settings/addon_details.php';?>' data-adminurl='<?php echo $admin_url;?>' data-active_plugins='<?php echo $_activePlugins;?>'>

				</div>
			<?php

				// notice
				echo "<div class='clear'></div><p><i><b>NOTE:</b> if you are not able to activate eventon or its addons please try again later as the activation server may be overloaded. </i></p>";


			
		?>
		
		<div class="clear"></div>
	</div>


	
	
	
	<?php
		// Throw the output popup box html into this page
		echo $eventon->output_eventon_pop_window(array('content'=>'Loading...', 'type'=>'padded'));
	?>
</div>