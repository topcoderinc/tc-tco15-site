<!DOCTYPE html>
<html lang="en">
<head>
<?php get_header ();?>
<?php

$title_lower = get_the_title ();
$title_lower = str_replace ( ' ', '-', $title_lower );
$title_lower = str_replace ( '.', '-', $title_lower );
?>
</head>
<body id="p<?php echo $title_lower ?>">
	<?php
		get_template_part ( 'navigation' );
	?>
	<div class="main-content <?php echo $title_lower ?>">			
		<?php if (have_posts())  : the_post(); ?>
		<article class="article">
			<div class="post-content">			
			<?php echo the_content();?>
			</div>
			<div class="clearfix"></div>
		</article>
		<?php  endif;?>
	</div>	
	<!-- /.main-content -->
	<?php get_footer(); ?>
	<!-- /.footer -->
		
</body>
</html>





