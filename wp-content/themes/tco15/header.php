
<link rel="shortcut icon" href="<?php bloginfo( 'stylesheet_directory' ); ?>/favicon.ico" />

<!-- meta -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />

<title><?php bloginfo('name'); ?><?php wp_title(' - ', true, 'left'); ?></title>

<!-- JS -->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/html5shiv.js"></script>
      <script src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/respond.min.js"></script>
    <![endif]-->

<script type="text/javascript">
	var eventID = '<?php echo get_option('evnt_id'); ?>';
	var g_module = '<?php echo get_option('module'); ?>';
	var themePath = '<?php bloginfo( 'stylesheet_directory' ); ?>/';

	var msg_already_registered = '<?php get_option('already_registered'); ?>';
	var msg_success = '<?php get_option('success');?>';
	var msg_already_agreed = '<?php get_option('already_agreed');?>';
</script>

<?php wp_head(); ?>	

