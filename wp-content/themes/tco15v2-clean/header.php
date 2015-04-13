<?php 
	
	// get theme options
	global $site_options;
    
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php bloginfo('name'); ?> <?php is_home() ? '' : ' | ' . wp_title(''); ?></title>

        <!-- stylesheets -->
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<?php wp_head(); ?>	
		
	</head>

	<body <?php body_class($class); ?>>
		
		<header>
			<nav class="navbar navbar-default">
			
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-nav">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" id="logo" class="navbar-brand"><img src="<?php echo $site_options['tco_logo']['url']; ?>" alt="<?php bloginfo('name'); ?> Logo" class="img-responsive" /></a>
					</div>
					
					<div class="collapse navbar-collapse" id="main-navigation">
						<?php
							$nav = array(
									'container' 	=> false,
									'items_wrap' 	=> '<ul id="%1$s" class="%2$s nav navbar-nav navbar-right">%3$s</ul>',
									'menu'     		=> 'Main Menu');							  
							wp_nav_menu($nav);									
						?>
					</div>
				</div>
				
				
				<div class="collapse navbar-collapse" id="tournament-nav">
					<div class="container">
					<?php
						$nav = array(
								'container' 	=> false,
								'items_wrap' 	=> '<ul id="%1$s" class="%2$s nav navbar-nav navbar-right">%3$s</ul>',
								'menu'     		=> 'Tournament',
								'walker' 		=> new wp_bootstrap_navwalker());							  
						wp_nav_menu($nav);									
					?>
					</div>
				</div>
				
				<div class="collapse navbar-collapse" id="mobile-nav">
					<?php
						$nav = array(
								'container' 	=> false,
								'items_wrap' 	=> '<ul id="%1$s" class="%2$s nav navbar-nav navbar-right">%3$s</ul>',
								'menu'     		=> 'Mobile',
								'walker' 		=> new mobile_walker_nav_menu());							  
						wp_nav_menu($nav);									
					?>
				</div>
        				
			</nav>
			
			<?php get_template_part ( 'latestnews' ); ?>
			
		</header>
        
        
