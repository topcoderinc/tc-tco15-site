<?php
	$masthead = get_post_meta ( get_the_ID(), '_cmb_masthead', true );
	if ($masthead!='') :
?>
<div class="masthead">
	<div class="container">
		<div class="content">
			<?php echo apply_filters('the_content', $masthead); ?>
		</div>
	</div>
</div>
<?php endif; ?>
	