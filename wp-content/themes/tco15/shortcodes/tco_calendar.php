<?php
/*
 * Shortcodes
 */
$uniqueCounter = 1;


/*
 * tco_calendar
 */
function tco_calendar_function($atts, $content = null) {
	$cal_args = array (
		"post_type" => "calendar",
		"posts_per_page" => -1
	);
	$evntHtml = "";
	$cal_evnts = new WP_Query ( $cal_args );
	if ($cal_evnts->have_posts ()) {
		while ( $cal_evnts->have_posts () ) :
			$cal_evnts->the_post ();
			
			$pid = $cal_evnts->post->ID;
			$startDate = get_post_meta ( $pid, '_cmb_start_date', true );
			if ($startDate != null && $startDate != "") {
				$startDate = date('Ymd', strtotime($startDate));
			}
			
			$endDate = get_post_meta ( $pid, '_cmb_end_date', true );
			if ($endDate != null && $endDate != "") {
				$endDate =  date('Ymd', strtotime($endDate));
			}
			
			if ($endDate=='') {
				$endDate = $startDate;
			}
			
			if ($startDate!='' && $endDate!='') {
				if ($evntHtml != "") {
					$evntHtml .= ",";
				}
				if ($endDate == null || $endDate == "") {
					$endDate = $startDate;
				}
				$cats = wp_get_post_terms($pid,'category_cal');
				$catHtml = $cats [0]->cat_name;
				
				$catHtml = "";
				foreach ( $cats as $cat ) {
					$catHtml .= $catHtml == "" ? "" : ', ';
					$catHtml .= $cat->name;
				}
				
				$end_d_html = '';
				
				$link = get_post_meta( $pid, '_cmb_title_link', true );				
				if ( $link!='' ) {
					$title = '<a href="'.$link.'">'. get_the_title() .'</a>';
				} else {
					$title = get_the_title();	
				}
				
				$evntHtml .= '{
					title:"' . addslashes($title) . ' - ' . $catHtml .'",
					start: {
						date: "' . $startDate . '",
						time: ""
					},			
					end: {
						date: "' . $endDate . '",
						time: ""
					},
					location: "' . addslashes(get_the_content()) . '",
					color: "green"
	
				}';
			}
		endwhile;
	}
	return '
			<div class="tco-calendar"></div>
<script>
	var $calendar_events = [' . $evntHtml . '];
</script>';
}
add_shortcode ( "tco_calendar", "tco_calendar_function" );

