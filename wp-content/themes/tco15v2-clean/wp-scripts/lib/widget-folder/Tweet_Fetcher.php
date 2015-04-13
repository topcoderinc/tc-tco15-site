<?php

/**
 * a widget to show Sponsor single item in sidebar
 * 
 */
class Tweet_Fetcher extends WP_Widget {
    /**
     * set up widget
     * 
     */
    function Tweet_Fetcher() {
        /* Widget settings. */
        $widget_ops = array( 
            'classname' => 'Tweet_Fetcher', 
            'description' => __('manage tweet carousel list', 'tweet_fetcher') );

        /* Widget control settings. */
        $control_ops = array( 
            'width' => 162, 
            'height' => 300, 
            'id_base' => 'tweet_fetcher' 
        );

        /* Create the widget. */
        $this->WP_Widget( 
            'tweet_fetcher', 
            __('Tweet_Fetcher Widget', 'tweet_fetcher'), 
            $widget_ops, 
            $control_ops 
        );
        
    }     

    /**
     * How to display the widget on the screen.
     */
    function widget( $args, $instance ) {
        extract( $args );

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $post_title = strip_tags($instance['post_title']);
        $key = strip_tags($instance['key']);
        
            
        /* Before widget (defined by themes). */
		
    	$values = get_post_custom($post->ID);
        echo $before_widget;
?>
<h2><?php echo $post_title; ?></h2>
<script type="text/javascript">
var gTwitterUrl = '<?php echo str_replace("'", "\\'", $key); ?>';
</script>
<div class="tweets">
	<h3><?php echo $title; ?></h3>
    <div class="carousel">
    	<div class="bx-wrapper">
        	<div class="bx-window">
            	<ul>
					<?php	
					
						function twitterify($ret) {
							$ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
							$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
							$ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $ret);
							$ret = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $ret);
							return $ret;
						}
					
						require_once("wp-content/themes/tco13/lib/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
						 
						$search = $key;
						$notweets = 10;
						$consumerkey = "JJCRZlSBK8ebevdEEUCw";
						$consumersecret = "9Nc7T3jSBa9BMHmVvN1tMhxeTlWn2flg1IrQySHA";
						$accesstoken = "17635954-nUkNRsUU2Mbt37wu1T16JbvruVLcKXk9p60nH8MG3";
						$accesstokensecret = "kEhs4FMGjgcNaOjvF9QeYYdJU3ZFR4MW5VI1RJ2AE";
						  
						function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
							$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
						  	return $connection;
						}
						
						$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
						  
						$params['q'] = $search;
						$params['count'] = $notweets;
						$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json", $params);
						
						if ( $tweets ) {
							foreach( $tweets->statuses as $k=>$v ) {
								echo '<li>
										<img src="' . $v->user->profile_image_url . '" alt="" />
										<p>
											<a href="http://twitter.com/' . $v->user->screen_name . '">@' . $v->user->screen_name . '</a>
											<span>' . twitterify($v->text) . '</span>
										<p>
									  </li>';
									
							}							
						}
						
					?>
                </ul>
            </div>
            <a href="#" class="bx-prev">prev</a>
            <a href="#" class="bx-next">next</a>
        </div>
    </div>
</div>
<?php
        /* After widget (defined by themes). */
        echo $after_widget;
    }

        
    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['post_title'] = strip_tags( $new_instance['post_title'] );
        $instance['key'] = strip_tags( $new_instance['key'] );

        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array( 
            'title' => __('Tweets', 'hybrid'),
			'post_title' =>  __('What people have been saying...', 'hybrid'),
			'key'	=>  __('%23tco13', 'hybrid')
        );
        $instance = wp_parse_args( (array) $instance, $defaults );?>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Tweet Title:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'post_title' ); ?>"><?php _e('Tweet Tips:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'post_title' ); ?>" name="<?php echo $this->get_field_name( 'post_title' ); ?>" value="<?php echo $instance['post_title']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'key' ); ?>"><?php _e('Tweet Keywords:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'key' ); ?>" name="<?php echo $this->get_field_name( 'key' ); ?>" value="<?php echo $instance['key']; ?>" style="width:100%;" />
        </p>
                  
    <?php
    }    
}
?>