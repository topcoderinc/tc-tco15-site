<?php 

	get_header(); 

	// get all regional events sub pages
	$args = array (
		'parent'		=> $post->ID,
		'post_type'		=> 'page',
		'post_status' 	=> 'publish',
		'sort_order'    => 'ASC'
	);
	
	$pages = get_pages($args);

?>

<main>

	<div id="regional-events-page" class="container">
	
		<div id="event-summary">
			<div class="dates text-center">
				<ul class="controls">
					<li><a href="javascript:;" class="tab active">1</a></li>
					<li><a href="javascript:;" class="tab">2</a></li>
					<li><a href="javascript:;" class="tab">3</a></li>
					<li><a href="javascript:;" class="tab">4</a></li>
					<li><a href="javascript:;" class="tab">5</a></li>
					<li><a href="javascript:;" class="tab">6</a></li>
				</ul>
				
				<?php for ($i=0; $i<6; $i++) : ?>
				<div id="event-tab-<?php echo $i+1; ?>" class="tab-display<?php echo $i>0 ? ' hide' : ''; ?>">
					<?php if ( isset($pages[$i]) ) : 
						$raw_date 	= get_post_meta( $pages[$i]->ID, '_cmb_reg-event-date', true );
						$date 		= $raw_date!='' ? strtotime( $raw_date ) : '';
						
						if($date!='') :
					?>
						<span class="day"><?php echo date('d', $date); ?></span>
						<span class="month"><?php echo date('M', $date); ?></span>
						<?php else : ?>
						<span class="day">--</span>
						<span class="month">TBD</span>
						<?php endif; ?>
					<?php else : ?>
					<span class="day">--</span>
					<span class="month">TBD</span>
					<?php endif; ?>
				</div>
				<?php endfor; ?>
				
			</div>
			<div class="info">
			
				<?php for ($i=0; $i<6; $i++) : 
					$bg = '';
					if ( has_post_thumbnail( $pages[$i]->ID ) ) {
						$bg = wp_get_attachment_image_src(get_post_thumbnail_id( $pages[$i]->ID ), 'full');
					}
				?>
				<div id="event-details-<?php echo $i+1; ?>" class="details <?php echo ($i>0) ? 'hide' : 'active'; ?>" <?php if ($bg!='') : ?>data-bg="<?php echo $bg[0]; ?>"<?php endif; ?>>
					<?php  if ( isset($pages[$i]) ) : 
						$raw_date 	= get_post_meta( $pages[$i]->ID, '_cmb_reg-event-date', true );
						$date 		= $raw_date!='' ? strtotime( $raw_date ) : '';
					?>
					<h3><?php echo $pages[$i]->post_title; ?></h3>
					<div class="detail-body">
						<div class="row">
							<div class="col-xs-4 when">When :</div>
							<div class="col-xs-8 when-ans"><?php echo $date!='' ? date('d F, Y', $date) : 'TBD'; ?></div>
							<div class="clearfix visible-xs"></div>
							<div class="col-xs-4 where">Where :</div>
							<div class="col-xs-8 where-ans"><?php echo get_post_meta( $pages[$i]->ID, '_cmb_reg-event-location', true ); ?></div>
						</div>
					</div>
					<?php else : ?>
					<h3>Events coming soon...</h3>
					<?php endif; ?>
				</div>
				<?php endfor; ?>
			</div>
		</div><!-- /#event-summary -->
		
		
		<div id="event-pages">
		
			<!-- Title and Tabs -->
			<div class="titles-tabs">
				<div class="row">
					<div class="col-sm-4"><h2 class="tab-title">OVERVIEW</h2></div>
					<div class="col-sm-8">
						<ul>
							<?php foreach( $pages as $k=>$page ) : ?>
							<li class="hide subpagenav subpagenav-<?php echo $k+1; ?>"><a href="javascript:;" data-page="<?php echo $page->ID; ?>" class="<?php if ($k==0) : ?>active<?php endif; ?>">OVERVIEW</a></li>
							<?php
								// get subpages
								$subpage_args = array (
									'parent'		=> $page->ID,
									'post_type'		=> 'page',
									'post_status' 	=> 'publish',
									'sort_order'    => 'ASC',
									'sort_column'   => 'menu_order',
								);
								
								$subpages[$page->ID] = get_pages($subpage_args);
								
								if ($subpages[$page->ID]) {
									foreach( $subpages[$page->ID] as $kk=>$subpage ) :
										$external = get_post_meta( $subpage->ID, '_cmb_reg-event-external', true );
							?>
								<li class="hide subpagenav subpagenav-<?php echo $k+1; ?>"><a href="<?php echo $external ? $external : 'javascript:;'; ?>" <?php if ($external!='') : ?>target="_blank" class="external"<?php endif; ?> data-page="<?php echo $subpage->ID; ?>"><?php echo strtoupper($subpage->post_title); ?></a></li>
							<?php	
									endforeach;
								}
							?>
							<?php endforeach; ?>
						</ul>
						
					</div>
				</div>
			</div>
			
			<!-- Pages -->
			<div class="pages">
				<?php foreach( $pages as $k=>$page ) : ?>
				<div id="subpage-<?php echo $page->ID; ?>" class="subpage <?php echo $k>0 ? 'hide' : ''; ?>">
					<?php echo apply_filters('the_content', $page->post_content); ?>
				</div>
				<?php foreach( $subpages[$page->ID] as $kk=>$subpage ) : ?>
				<div id="subpage-<?php echo $subpage->ID; ?>" class="subpage hide">
					<?php echo apply_filters('the_content', $subpage->post_content); ?>
				</div>
				<?php endforeach; ?>
				<?php endforeach; ?>
			</div>
		
		</div><!-- /#event-pages -->
		
	</div><!-- .container -->
</main>

<?php get_footer(); ?>