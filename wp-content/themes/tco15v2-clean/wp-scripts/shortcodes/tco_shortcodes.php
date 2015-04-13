<?php

/*
 * tco_shortcodes
 */
 
 /*
 * tco_collapsable
 */

function tco_collapsable_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
	"title" => ""
			), $atts ) );
	return '<section class="collapsable">' .'<h2><i></i>'.$title.' </h2><div class="details">'. apply_filters('the_content',$content) . '</div></section>';	
}
add_shortcode ( "tco_collapsable", "tco_collapsable_function" );

 /*
 * tco_button
 */

function tco_button_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
	"style" => "btn-primary",
	"target" => "_self",
	"size" => ""
			), $atts ) );
			
	return '<button type="button" class="btn '.$style.' '.$size.'" target="_target">'.$content.'</button>';	
}
add_shortcode( "tco_button", "tco_button_function" );


 /*
 * tco_registrants
 */

function tco_registrants_function($atts, $content = null) {
	$html="";
	$html = '<div class="leadboard">
        		<h2>Registrants</h2>
                <script type="text/javascript">
					var reg_c = "'. get_option('reg_setting_c').'";
					var reg_dsid = "'.get_option('reg_setting_dsid').'";
				</script>
                <div class="dataTable view" id="Registrants">
						<div class="pagination hidden-xs">
							<div class="left">
								<span>View</span>
								<input type="text" class="text viewAmount" value="30"/>
								<span>at a time starting with</span>
								<input type="text" class="text startIndex" value="0"/>
								<a href="javascript:;" class="blueBtn1 goBtn"><span class="buttonMask"><span class="text">GO</span></span></a>
							</div>
							<div class="right">
								<a href="javascript:;" class="prev"><i></i></a>
								<a href="javascript:;" class="next"><i></i></a>
							</div>
						</div>  <!-- end of .pagination -->
						<div class="tableMask">
							<div class="tableMaskBot">
								<table cellpadding="0" cellspacing="0">
									<colgroup>
										<col width="199" />
										<col width="390" />
									</colgroup>
									<thead>
										 <tr class="topTh">
											<th class="recordCount">Total: 0</th>
											<th>
												<div class="handle">
													<div>
														<input type="text" class="search" placeholder="Search Handle">
													</div>
												</div>
											</th>
										</tr>
										<tr class="botTh">
										<th colspan="2">Handle</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div> <!-- end of .tableMask -->
						<p class="showing hidden-xs">Showing <span class="from">0</span> to <span class="to">0</span> of <span class="total">0</span> Handle</p>
						<div class="pagination hidden-xs">
								<div class="left">
									<span>View</span>
									<input type="text" class="text viewAmount" value="30"/>
									<span>at a time starting with</span>
									<input type="text" class="text startIndex" value="0"/>
									<a href="javascript:;" class="blueBtn1 goBtn"><span class="buttonMask"><span class="text">GO</span></span></a>
								</div>
								<div class="right">
									<a href="javascript:;" class="prev"><i></i></a>
									<a href="javascript:;" class="next"><i></i></a>
								</div>
						</div>  <!-- end of .pagination -->
					<div class="pagination pagination-xs visible-xs">  
                                <a href="javascript:;" class="prev pull-left"><i></i></a>
                                <a href="javascript:;" class="next pull-right"><i></i></a>
								<p class="showingStatus"></p>
                            
                        </div>  <!-- end of .pagination -->
                    </div><!-- end of .dataTable -->
            </div>';

	return $html;	
}
add_shortcode ( "tco_registrants", "tco_registrants_function" );


