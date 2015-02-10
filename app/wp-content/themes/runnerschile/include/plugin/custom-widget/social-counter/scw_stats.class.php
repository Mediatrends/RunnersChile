<?php
function get_url_contents($url){
	$crl = curl_init();
	$timeout = 5;
	curl_setopt ($crl, CURLOPT_URL,$url);
	curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
	$ret = curl_exec($crl);
	curl_close($crl);
	return $ret;
}	

class SubscriberStats{

	public	$twitter, $rss, $facebook;
	public	$services = array();

	public function __construct($arr){

		$this->services = $arr;
		
		if(trim($arr['twitterName'])) {
			$connection = getConnectionWithAccessToken($arr['consumer_key'], $arr['consumer_secret'], $arr['access_token'], $arr['access_token_secret']);
			$tweets = $connection->get('https://api.twitter.com/1.1/users/show.json?screen_name='.$arr['twitterName']) or die('Couldn\'t retrieve tweets! Wrong username?');

			if(!empty($tweets->errors)){
				if($tweets->errors[0]->message == 'Invalid or expired token'){
					echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!' . $after_widget;
				}else{
					echo '<strong>'.$tweets->errors[0]->message.'</strong>' . $after_widget;
				}
				return;
			}			
			
			$new_twitter = $tweets->followers_count;		
			
			if( empty($new_twitter) || $new_twitter == 0 || $new_twitter == '0' ){ 
				$this->twitter = $arr['twitter'];
			}else{ 
				$this->twitter = $new_twitter; 
			}			
        }
		
		if(trim($arr['facebookFanPageURL'])) {
            $fb_id = basename($arr['facebookFanPageURL']);
			$query = 'http://graph.facebook.com/'.urlencode($fb_id);
			$result = json_decode(get_url_contents($query));
			$new_facebook = $result->likes;
			
			if( empty($new_facebook) || $new_facebook == 0 || $new_facebook == '0' ){ 
				$this->facebook = $arr['facebook'];
			}else{ 
				$this->facebook = $new_facebook; 
			}			
            
        }
		
	}

	public function generate(){
		$gdl_icon_type = get_option(THEME_SHORT_NAME.'_icon_type','dark');	
        ?>
        <div class="social-counter-widget-wrapper">
            <?php if($this->services['twitterName']) { ?>
            <a class="social-counter-widget facebook" href="http://twitter.com/<?php echo $this->services['twitterName']?>" target="_blank">
            	<span class="icon"><img class="gdl-no-preload" src="<?php echo GOODLAYERS_PATH . '/images/icon/' . $gdl_icon_type . '/social-widget-twitter.png'; ?>" alt="" /></span>
				<span class="count"><?php echo number_format($this->twitter); ?></span>
                <span class="title"><?php _e('Followers', 'gdl_front_end'); ?></span>   
            </a>
            <?php } ?>
			
            <?php if($this->services['facebookFanPageURL']) { ?>
            <a class="social-counter-widget twitter" href="<?php echo $this->services['facebookFanPageURL']?>" target="_blank" >
            	<span class="icon"><img class="gdl-no-preload" src="<?php echo GOODLAYERS_PATH . '/images/icon/' . $gdl_icon_type . '/social-widget-facebook.png'; ?>" alt="" /></span>
				<span class="count"><?php echo number_format($this->facebook); ?></span>
                <span class="title"><?php _e('Fans', 'gdl_front_end'); ?></span>
            </a>
            <?php } ?>		
		
            <?php if($this->services['feedBurnerURL']) { ?>
        	<a class="social-counter-widget rss" href="<?php echo $this->services['feedBurnerURL']; ?>" target="_blank">
            	<span class="icon"><img class="gdl-no-preload" src="<?php echo GOODLAYERS_PATH . '/images/icon/' . $gdl_icon_type . '/social-widget-rss.png'; ?>" alt="" /></span>
				<span class="count"><?php _e('RSS', 'gdl_front_end'); ?></span>
                <span class="title"><?php _e('Subscribers', 'gdl_front_end'); ?></span>
            </a>
            <?php } ?>
			
			<div class="clear"></div>
        </div>
		
       <?php	   
	}
	
}
?>