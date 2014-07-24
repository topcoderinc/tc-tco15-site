<?php
/*
 * Template Name: Full - Center
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php get_header ();?>
<?php
	$title_lower = get_the_title ();
	$title_lower = str_replace ( ' ', '-', $title_lower );
	$title_lower = str_replace ( '.', '-', $title_lower );
	$image 	= wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
	$lead_text = get_post_meta ( $post->ID, '_cmb_lead_text', true );	
?>
</head>
<body id="p<?php echo $title_lower ?>">

	<?php get_template_part ( 'navigation' ); ?>
	
	<?php if ( $image ) : ?>
	<div class="coverPhoto" style="background: url(<?php echo $image[0]; ?>) 50% 0 no-repeat;">
		<div class="container">
			<?php echo apply_filters('the_content', $lead_text); ?>
		</div>
	</div>
	<?php endif; ?>

	<div class="container">

		<div class="main-content <?php echo $title_lower; ?><?php echo $image ? ' hasCoverPhoto' : ''; ?>">			
			<?php if (have_posts())  : the_post(); ?>
			<article class="article">
				<div class="post-content">							
					<?php echo the_content();?>
				</div>
			</article>
			<?php  endif;?>
		</div>	
		<!-- /.main-content -->
		
	</div>

	<?php get_footer(); ?>
	<!-- /.footer -->
		
</body>
</html>





