<?php
/*
 * Shortcodes
 */
$uniqueCounter = 1;

/*
 * tco_search
 */
function tco_search_function($atts, $content = null) {
	return '<form class="navbar-form navbar-left" action="/index.html?s="role="search">
	  <div class="form-group">
	    <input type="text" class="form-control" placeholder="Search">
	  </div>
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>';
}
add_shortcode ( "tco_search", "tco_search_function" );


