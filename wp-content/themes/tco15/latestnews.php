<?php
	global $site_options;
	if ( $site_options['latest_news_on'] ) :
?>
<div id="latest-news-popup">

	<div class="content-body">
		<h2>Latest News</h2>
		
		<?php if ($site_options['latest_news_image']['url']!='') : ?>
		<p class="text-center"><img src="<?php echo $site_options['latest_news_image']['url']; ?>" alt="" class="img-responsive" /></p>
		<?php endif; ?>
		
		<div class="teaser">
			<?php echo apply_filters('the_content', $site_options['latest_news_teaser']); ?>
		</div>
	</div>
	
	<?php if ( $site_options['latest_news_link']!='' ) : ?>
	<a href="<?php echo $site_options['latest_news_link']; ?>" class="learn-more">Learn More</a>
	<?php endif; ?>
	
	<a href="javascript:;" class="news-close"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></a>
	
</div>
<?php endif; ?>