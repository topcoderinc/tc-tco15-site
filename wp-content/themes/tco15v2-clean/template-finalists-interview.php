<?php 
/*
Template Name: Finalists Page
*/
get_header(); 

$masthead		= 'masthead-nophoto';
$cover_photo 	= get_field('cover_photo');
if ( $cover_photo ) {
	if ( $cover_photo['width']>992 ) {
		$masthead	= 'masthead-full';
	} else {
		$masthead	= 'masthead-small';
	}
}

$track		 	= get_field('track');
$q[]		 	= get_field_object('topcoder_meaning');
$q[]			= get_field_object('greatest_accomplishment');
$q[]		 	= get_field_object('hobbies');
$q[]		 	= get_field_object('best_tip');
$q[]		 	= get_field_object('topcoder_story');

$bgPosition 	= get_field('cover_photo_position');

?>

<main>
	
	<?php if ( $masthead=='masthead-full' ) : ?>
	<div class="<?php echo $masthead; ?>" style="background: url(<?php echo $cover_photo['url']; ?>) <?php echo $bgPosition; ?>">
		<div class="container">
			<div class="track-handle">
				<span><?php echo $track; ?> Finalists</span>
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="container">
		    
		<div class="article">
			
			<?php if ( $masthead!='masthead-full'  ) : ?>
			<div class="masthead-finalists">
				<div class="row">
					<div class="col-sm-6">
						<div class="track-handle">
							<span><?php echo $track; ?> Finalists</span>
							<h1><?php the_title(); ?></h1>
						</div>
					</div>
					<div class="col-sm-6">
						<?php if ($masthead=='masthead-small') : ?>
						<img src="<?php echo $cover_photo['url']; ?>" class="img-responsive img-full" />
						<?php endif; ?>
					</div>
				</div>
			</div>
			<hr />
			<?php endif; ?>
			
		
			<div class="interview">
				<h2 class="alt-section-title">INTERVIEW</h2>
				<?php foreach($q as $k=>$v) : ?>
				<div class="item">
					<h3>Question: <strong><?php echo $v['label']; ?></strong></h3>
					<?php echo apply_filters('the_content', $v['value']); ?>
				</div>
				<hr />
				<?php endforeach; ?>
			</div>
			
		</div>
            
	</div><!-- .container -->
</main>

<?php get_footer(); ?>