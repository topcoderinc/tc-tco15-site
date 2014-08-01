<header class="main-nav navbar navbar-static-top" role="navigation">
	<div class="container">
	
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>			
			</button>
			<?php /*<a class="navbar-brand" href="<?php echo home_url(); ?>"><span class="sr-only"><?php bloginfo('name'); ?></span></a>*/ ?>
			<a class="navbar-brand" href="http://studio.topcoder.com/?module=ViewContestDetails&ct=30044678" target="_blank"><span class="sr-only"><?php bloginfo('name'); ?></span></a>			
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="drop-down collapse navbar-collapse" id="main-menu">
			<ul class="nav navbar-nav">
			<?php get_template_part ( 'menu' ); ?>
			</ul>
			
			<?php /*
			<ul class="nav navbar-nav navbar-right">
				<li>			
					<button type="button" class="tco-register registerBtn">Register Now</button>
					<div id="you-are-registered" class="label label-info">REGISTERED <span class="glyphicon glyphicon-ok"></span></div>
				</li>			
			</ul>
			*/ ?>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</header>
<!-- /header -->