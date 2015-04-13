<div id="sidebar-right">

	<?php					
		
		global $wp_query;
		$page_id = $wp_query->post->ID;

		$sb = get_post_meta ( $page_id, '_cmb_right_sb_select', true );
		
		if ( $sb=='' ) {	
			$sb = 'smk_sidebar_4jcf';
		}
		
		if (function_exists ( "smk_sidebar" )) {
			smk_sidebar ( $sb );
		}
	?>

</div>