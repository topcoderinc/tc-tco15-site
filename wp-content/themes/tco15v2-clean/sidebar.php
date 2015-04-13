<div id="sidebar-right">

	<?php					
		
		global $post;
		$sb = get_post_meta ( $post->ID, '_cmb_right_sb_select', true );
		
		if ( $sb=='' ) {	
			$sb = 'smk_sidebar_4jcf';
		}
		
		if (function_exists ( "smk_sidebar" )) {
			smk_sidebar ( $sb );
		}
	?>

</div>