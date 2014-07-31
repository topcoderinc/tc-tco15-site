<?php
define ( 'WP_DEBUG_DISPLAY', true );

include_once 'functions-theme-opts.php';
include_once 'functions-custom-post-types.php';
include_once 'functions-metaboxes.php';

include_once 'widget.php';

include_once 'shortcodes/tco_calendar.php';
include_once 'shortcodes/tco_carousel.php';
include_once 'shortcodes/tco_leaderboard.php';
include_once 'shortcodes/tco_schedule.php';
include_once 'shortcodes/tco_search.php';
include_once 'shortcodes/tco_sponsors.php';
include_once 'shortcodes/tco_tweets.php';
include_once 'shortcodes/tco_registrants.php';
include_once 'shortcodes/tco_button.php';
include_once 'shortcodes/tco_collapsible.php';
include_once 'shortcodes/tco_recent_blog_posts.php';
include_once 'shortcodes/tco_snippet_posts.php';
include_once 'shortcodes/tco_user_details.php';
include_once 'shortcodes/tco_period_leaders.php';
include_once 'shortcodes/tco_forum_posts.php';
include_once 'shortcodes/tco_event_list.php';
include_once 'shortcodes/tco_youtube.php';


/* logo */

define ( 'HEADER_TEXTCOLOR', '' );
define ( 'HEADER_IMAGE', '%s/i/logo.png' ); // %s is the template dir uri
define ( 'HEADER_IMAGE_WIDTH', 113 );
define ( 'HEADER_IMAGE_HEIGHT', 58 );

define ( 'NO_HEADER_TEXT', true );
// gets included in the site header
function header_style() {
	?><style type="text/css">
#header {
    background: url(<?php 
	header_image ();
	?>);
}
</style><?php
}
// gets included in the admin header
function admin_header_style() {
	?><style type="text/css">
#headimg {
    width: 5px;
    height: <?php echo HEADER_IMAGE_HEIGHT; ?> px;
    background: no-repeat;
}
</style><?php
}

global $wp_version;
if (version_compare ( $wp_version, '3.4', '>=' )) :
	add_theme_support ( 'custom-header' );
 else :
	add_custom_image_header ( 'header_style', 'admin_header_style' );
endif;

if (! class_exists ( 'TwitterOAuth' )) {
	require_once ("lib/twitteroauth/twitteroauth.php"); // Path to twitteroauth library
}

// add featured image
add_theme_support ( 'post-thumbnails' );
if (function_exists ( 'add_theme_support' )) {
	add_theme_support ( 'post-thumbnails' );
	set_post_thumbnail_size ( 55, 55 ); // default Post Thumbnail dimensions
}
if (function_exists ( 'add_image_size' )) {
	add_image_size ( 'blog-thumb', 158, 154, true );
	add_image_size ( 'blog-thumb-mobile', 300, 165 );
}

// add post format support
add_theme_support ( 'post-formats', array (
		'image',
		'video' 
) );

// enables tags on pages
function tags_support_all() {
	register_taxonomy_for_object_type ( 'post_tag', 'page' );
	register_taxonomy_for_object_type ( 'category', 'posts' );
}

function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER ["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER ["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"] . $_SERVER ["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER ["SERVER_NAME"] . $_SERVER ["REQUEST_URI"];
	}
	return $pageURL;
}
function get_page_link_by_slug($page_slug) {
	$page = get_page_by_path ( $page_slug );
	if ($page) :
		return get_permalink ( $page->ID );
	 else :
		return "#";
	endif;
}
function wpb_set_post_views($postID) {
	$count_key = 'wpb_post_views_count';
	$count = get_post_meta ( $postID, $count_key, true );
	if ($count == '') {
		$count = 0;
		delete_post_meta ( $postID, $count_key );
		add_post_meta ( $postID, $count_key, '0' );
	} else {
		$count ++;
		update_post_meta ( $postID, $count_key, $count );
	}
}
function wpb_track_post_views($post_id) {
	if (! is_single ())
		return;
	if (empty ( $post_id )) {
		global $post;
		$post_id = $post->ID;
	}
	wpb_set_post_views ( $post_id );
}
add_action ( 'wp_head', 'wpb_track_post_views' );

/* sidebars */
if (! function_exists ( 'smk_get_all_sidebars' )) {
	function smk_get_all_sidebars() {
		global $wp_registered_sidebars;
		$all_sidebars = array ();
		if ($wp_registered_sidebars && ! is_wp_error ( $wp_registered_sidebars )) {
			
			foreach ( $wp_registered_sidebars as $sidebar ) {
				$all_sidebars [$sidebar ['id']] = $sidebar ['name'];
			}
		}
		return $all_sidebars;
	}
}


//register_sidebar();
/*
 * commonly used functions -----------------------------------
 */
// Add theme CSS files
function load_theme_styles() {
	global $wp_styles;
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css', false, false, 'all');
	wp_enqueue_style('kalendar', get_template_directory_uri() . '/css/kalendar.css', false, false, 'all');
	wp_enqueue_style('opensans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800', false, false, 'all');
	wp_enqueue_style('styles', get_template_directory_uri() . '/css/styles.css', false, false, 'all');
	//wp_enqueue_style('styles-tablet', get_template_directory_uri() . '/css/styles-tablet.css', false, false, 'all');
	//wp_enqueue_style('styles-medium', get_template_directory_uri() . '/css/styles-medium.css', false, false, 'all');
	//wp_enqueue_style('styles-desk', get_template_directory_uri() . '/css/styles-desk.css', false, false, 'all');
}

// Add theme JS files
function load_theme_scripts() {
	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.js', array(''), false, true);
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true);
	wp_enqueue_script('touchswipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array('jquery'), false, true);
	wp_enqueue_script('swipe', get_template_directory_uri() . '/js/swipe.js', array('jquery'), false, true);
	wp_enqueue_script('bxslider', get_template_directory_uri() . '/js/jquery.bxSlider.js', array('jquery'), false, true);
	wp_enqueue_script('froogaloop', get_template_directory_uri() . '/js/froogaloop.min.js', array('jquery'), false, true);
	wp_enqueue_script('kalendar', get_template_directory_uri() . '/js/kalendar.js', array('jquery'), false, true);
	wp_enqueue_script('buttons', get_template_directory_uri() . '/js/buttons.js', array('jquery'), false, true);	
	wp_enqueue_script('datatable', get_template_directory_uri() . '/js/jquery.dataTables.min.js', array('jquery'), false, true);	
	wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), false, true);
}
if(!is_admin()) {
	if (function_exists('load_theme_styles')) {
		add_action('wp_enqueue_scripts', 'load_theme_styles');
	}
	if (function_exists('load_theme_scripts')) {
		add_action('wp_enqueue_scripts', 'load_theme_scripts');
	}
}


/* excerpt */
function new_excerpt_more($more) {
	return '...<p class="text-right">' . '<a href="' . get_permalink ( get_the_ID () ) . '" class="more">Read More</a></p>';
}
add_filter ( 'excerpt_more', 'new_excerpt_more' );
function custom_excerpt_length($length) {
	return 27;
}

function custom_content($new_length = 55) {
	$output = get_the_content ();
	$output = apply_filters ( 'wptexturize', $output );
	$output = substr ( $output, 0, $new_length ) . '...';
	return $output;
}

/* singnup function from given theme */
function get_cookie() {
	global $_COOKIE;
	$hid = explode ( "|", $_COOKIE ['main_tcsso_1'] );
	$handleName = $_COOKIE ['handleName'];
	// print_r($hid);
	$hname = explode ( "|", $_COOKIE ['direct_sso_user_id_1'] );
	$meta = new stdclass ();
	$meta->handle_id = $hid [0];
	$meta->handle_name = $handleName;
	return $meta;
}

// add menu support
add_theme_support ( 'menus' );


function get_user_browser() {
	$u_agent = $_SERVER ['HTTP_USER_AGENT'];
	$ub = '';
	if (preg_match ( '/MSIE/i', $u_agent )) {
		$ub = "ie";
	} elseif (preg_match ( '/Firefox/i', $u_agent )) {
		$ub = "firefox";
	} elseif (preg_match ( '/Safari/i', $u_agent )) {
		$ub = "safari";
	} elseif (preg_match ( '/Chrome/i', $u_agent )) {
		$ub = "chrome";
	} elseif (preg_match ( '/Flock/i', $u_agent )) {
		$ub = "flock";
	} elseif (preg_match ( '/Opera/i', $u_agent )) {
		$ub = "opera";
	}
	
	return $ub;
}

/**
 * wrap content to $len length content, and add '...' to end of wrapped conent
 */
function wrap_content_strip_html($content, $len, $strip_html = false, $sp = '\n\r', $ending = '...') {
	if ($strip_html) {
		$content = strip_tags ( $content );
		$content = strip_shortcodes ( $content );
	}
	$c_title_wrapped = wordwrap ( $content, $len, $sp );
	$w_title = explode ( $sp, $c_title_wrapped );
	if (strlen ( $content ) <= $len) {
		$ending = '';
	}
	return $w_title [0] . $ending;
}

/* get page id by slug */
function get_ID_by_slug($page_slug) {
	$page = get_page_by_path ( $page_slug );
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

/* function convert category slug to category id */
function getCategoryId($slug) {
	$idObj = get_category_by_slug ( $slug );
	$id = $idObj->term_id;
	return $id;
}

/* set email format to html */
function set_html_content_type() {
	return 'text/html';
}


// header menu walker
class nav_menu_walker extends Walker_Nav_Menu {
	
	// add classes to ul sub-menus
	function start_lvl(&$output, $depth) {
		// depth dependent classes
		$indent = ($depth > 0 ? str_repeat ( "\t", $depth ) : ''); // code indent
		$display_depth = ($depth + 1); // because it counts the first submenu as 0
		$classes = array (
			'dropdown open' 
		);
		$class_names = implode ( ' ', $classes );
		
		// build html
		$output .= "\n" . $indent . '<div class="dropdown-wrap"><ul class="container ' . $class_names . '">' . "\n";
	}
	
	// add main/sub classes to li's and links
	function start_el(&$output, $item, $depth, $args) {
		
		global $wp_query;
		$indent = ($depth > 0 ? str_repeat ( "\t", $depth ) : ''); // code indent
		                                                            
		// passed classes
		$classes = empty ( $item->classes ) ? array () : ( array ) $item->classes;
		$class_names = esc_attr ( implode ( ' ', apply_filters ( 'nav_menu_css_class', array_filter ( $classes ), $item ) ) );
		
		$name_lower = apply_filters ( 'the_title', $item->title, $item->ID );
		if(  in_array('current_page_ancestor',$item->classes) || in_array('current-menu-ancestor',$item->classes) || in_array('current-menu-item', $item->classes) || in_array('current-menu-parent', $item->classes) || in_array('current-page-ancestor', $item->classes) ){
			$name_lower = ' active ';
		}else {
			$name_lower = '';
		}

		if( (is_single() || is_category() || is_archive()) && ($item->title == "Tournament" || $item->title == "TCO14 Pages" || $item->title == "Blog") ) { 
			$name_lower = ' active current-menu-ancestor';
		}
		
		// build html
		$output .= $indent . '<li class="'.$name_lower. ' ' . $class_names .'">';
		
		$name_lower = apply_filters ( 'the_title', $item->title, $item->ID );
		$name_lower = str_replace(' ','-',$name_lower);
		$name_lower = str_replace('.','-',$name_lower);
		$name_lower = strtolower($name_lower);

		if( ((is_single() || is_category() || is_archive()) && ($item->title == "Tournament" || $item->title == "TCO14 Pages" || $item->title == "Blog")) || in_array('current_page_ancestor',$item->classes) || in_array('current-menu-ancestor',$item->classes) || in_array('current-menu-item', $item->classes) || in_array('current-menu-parent', $item->classes) || in_array('current-page-ancestor', $item->classes) ){
			$name_lower .= ' active ';
		}	
		
		
		// link attributes
		$attributes = ! empty ( $item->attr_title ) ? ' title="' . esc_attr ( $item->attr_title ) . '"' : '';
		$attributes .= ! empty ( $item->target ) ? ' target="' . esc_attr ( $item->target ) . '"' : '';
		$attributes .= ! empty ( $item->xfn ) ? ' rel="' . esc_attr ( $item->xfn ) . '"' : '';
		$attributes .= ! empty ( $item->url ) ? ' href="' . esc_attr ( $item->url ) . '"' : '';
		$attributes .= ' class="' . (! empty ( $name_lower ) ? esc_attr ( $name_lower ) : '') . '"';
		
			
		$item_output = sprintf ( '%1$s<a%2$s><i></i>%3$s%4$s%5$s</a>%6$s', $args->before, $attributes, $args->link_before, apply_filters ( 'the_title', $item->title, $item->ID ), $args->link_after, $args->after );
		
		
		
		// build html
		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
	}
	


	function end_lvl( &$output, $depth, $args ) {
		$output .= '</ul></div>';
	}
}


// footer menu walker
class footer_menu_walker extends Walker_Nav_Menu {
	
	// add classes to ul sub-menus
	function start_lvl(&$output, $depth) {
		// depth dependent classes
		$indent = ($depth > 0 ? str_repeat ( "\t", $depth ) : ''); // code indent
		$display_depth = ($depth + 1); // because it counts the first submenu as 0
		$classes = array (
				'child' 
		);
		$class_names = implode ( ' ', $classes );
		
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}
	
	// add main/sub classes to li's and links
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ($depth > 0 ? str_repeat ( "\t", $depth ) : ''); // code indent
		                                                            
		// passed classes
		$classes = empty ( $item->classes ) ? array () : ( array ) $item->classes;
		$class_names = esc_attr ( implode ( ' ', apply_filters ( 'nav_menu_css_class', array_filter ( $classes ), $item ) ) );
		
		// build html
		$deptClass = "";
		if ($depth == 0) {
			$deptClass = "rootNode";
		}
		$output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $deptClass . '">';
		
		// link attributes
		$attributes = ! empty ( $item->attr_title ) ? ' title="' . esc_attr ( $item->attr_title ) . '"' : '';
		$attributes .= ! empty ( $item->target ) ? ' target="' . esc_attr ( $item->target ) . '"' : '';
		$attributes .= ! empty ( $item->xfn ) ? ' rel="' . esc_attr ( $item->xfn ) . '"' : '';
		$attributes .= ! empty ( $item->url ) ? ' href="' . esc_attr ( $item->url ) . '"' : '';
		$attributes .= ' class="' . (! empty ( $item->post_name ) ? esc_attr ( $item->post_name ) : '') . '"';
		
		$item_output = sprintf ( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s', $args->before, $attributes, $args->link_before, apply_filters ( 'the_title', $item->title, $item->ID ), $args->link_after, $args->after );
		
		// build html
		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}


/* comments */
function mytheme_comment($comment, $args, $depth) {
	$GLOBALS ['comment'] = $comment;
	extract ( $args, EXTR_SKIP );
	if ('div' == $args ['style']) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
	?>
<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
<?php if ( 'div' != $args['style'] ) : ?>
<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, 90 ); ?>

	</div>
	<div class="commentText">
		<span class="arrow"></span>
		<div class="userRow">
			<a href="<?php get_comment_author_url();?>">
				<?php echo get_comment_author_link();?>
			</a>
			<span class="commentTime"> <?php printf( __('%1$s '), get_comment_date('F j, Y'))?>
			</span>
			<?php
	if ($comment->comment_parent) {
		$parent_comment = get_comment ( $comment->comment_parent );
		echo 'to <a href="' . get_comment_author_url () . '" >' . $parent_comment->comment_author . '</a>';
	}
	?>
		</div>
		<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?> </em>
		<?php endif; ?>
		<div class="commentData">
			<?php comment_text(); ?>
		</div>
		<!-- /.commentBody -->
		<div class="actionRow">
			<?php if(get_edit_comment_link(__('Edit'),'  ','' ) !=  "" ):?>
			<span class="comment-meta commentmetadata"> <?php edit_comment_link(__('Edit'),'  ','' );?>
			</span>
			<?php endif;?>
			<span class="reply"> <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'])))?>
			</span>
		</div>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
</div>



	<?php endif;
}
?>