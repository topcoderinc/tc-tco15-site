<?php if ( count($post->ancestors)>0 ) : ?>
<div id="breadcrumbs">
	<div class="container">
	<?php 
		$arr = array_reverse($post->ancestors);
		foreach( $arr as $pageID ) :
			$page = get_post($pageID);
		
	?>
	<a href="<?php echo get_permalink($pageID); ?>"><?php echo $page->post_title; ?></a>
	<?php endforeach; ?>
	<?php echo $post->post_title; ?>
	</div>
</div>
<?php endif; ?>