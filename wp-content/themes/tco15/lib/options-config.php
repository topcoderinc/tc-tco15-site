<?php

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }


        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
        }

        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }


        function change_arguments($args) {
            return $args;
        }

        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'      => 'General Settings',
                'desc'       => 'General website settings and configurations',
                'icon'       => 'el-icon-cog',
                'fields'   	 => array(
					array(
                        'id'        => 'email_addr_to_receive_mail',
                        'type'      => 'text',
                        'title'     => 'Admin Email',
						'desc'		=> 'Comma delimated email address to receive general mail notification'
                    ),
					array(
                        'id'        => 'twtr_keyword',
                        'type'      => 'text',
                        'title'     => 'Twitter Keyword',
						'desc'		=> 'Hash tag twitter search'
                    ),
				)
            );
			
			
			$this->sections[] = array(
                'title'      => 'Leaderboards',
                'desc'       => 'Product Review Information',
                'icon'       => 'el-icon-th-list',
                'fields'   	 => array(
					array(
                        'id'        => 'evnt_id',
                        'type'      => 'text',
                        'title'     => 'Event ID',
                    ),
					array(
                        'id'        => 'module',
                        'type'      => 'text',
                        'title'     => 'API Module',
						'default'	=> 'BasicData'
                    ),		
								
					// algorithm
					array(
						'id' 		=> 'algo_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'algo_c',
                        'type'      => 'text',
                        'title'     => 'Algorithm - C',
                    ),
					array(
                        'id'        => 'algo_dsid',
                        'type'      => 'text',
                        'title'     => 'Algorithm - DSID',
                    ),
					
					// copilot
					array(
						'id' 		=> 'copilot_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'copilot_c',
                        'type'      => 'text',
                        'title'     => 'Copilot - C',
                    ),
					array(
                        'id'        => 'copilot_dsid',
                        'type'      => 'text',
                        'title'     => 'Copilot - DSID',
                    ),					
					
					// development
					array(
						'id' 		=> 'development_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'dev_c',
                        'type'      => 'text',
                        'title'     => 'Development - C',
                    ),
					array(
                        'id'        => 'dev_c_user',
                        'type'      => 'text',
                        'title'     => 'Development - C - User',
                    ),
					array(
                        'id'        => 'dev_dsid',
                        'type'      => 'text',
                        'title'     => 'Development - DSID',
                    ),
					array(
                        'id'        => 'dev_p1',
                        'type'      => 'text',
                        'title'     => 'Development - Period 1',
                    ),
					array(
                        'id'        => 'dev_p2',
                        'type'      => 'text',
                        'title'     => 'Development - Period 2',
                    ),
					array(
                        'id'        => 'dev_p3',
                        'type'      => 'text',
                        'title'     => 'Development - Period 3',
                    ),
					array(
                        'id'        => 'dev_p4',
                        'type'      => 'text',
                        'title'     => 'Development - Period 4',
                    ),					
					
					// information architectue
					array(
						'id' 		=> 'ia_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'ia_c',
                        'type'      => 'text',
                        'title'     => 'IA - C',
                    ),
					array(
                        'id'        => 'ia_dsid',
                        'type'      => 'text',
                        'title'     => 'IA - DSID',
                    ),
					array(
                        'id'        => 'ia_p1',
                        'type'      => 'text',
                        'title'     => 'IA - Period 1',
                    ),
					array(
                        'id'        => 'ia_p2',
                        'type'      => 'text',
                        'title'     => 'IA - Period 2',
                    ),
					array(
                        'id'        => 'ia_p3',
                        'type'      => 'text',
                        'title'     => 'IA - Period 3',
                    ),
					array(
                        'id'        => 'ia_p4',
                        'type'      => 'text',
                        'title'     => 'IA - Period 4',
                    ),
					
					// marathon
					array(
						'id' 		=> 'marathon_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'marathon_c',
                        'type'      => 'text',
                        'title'     => 'Marathon - C',
                    ),
					array(
                        'id'        => 'marathon_dsid',
                        'type'      => 'text',
                        'title'     => 'Marathon - DSID',
                    ),

					// ui design
					array(
						'id' 		=> 'studio_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'studio_c',
                        'type'      => 'text',
                        'title'     => 'UI Design - C',
                    ),
					array(
                        'id'        => 'studio_dsid',
                        'type'      => 'text',
                        'title'     => 'UI Design - DSID',
                    ),
					array(
                        'id'        => 'studio_p1',
                        'type'      => 'text',
                        'title'     => 'UI Design - Period 1',
                    ),
					array(
                        'id'        => 'studio_p2',
                        'type'      => 'text',
                        'title'     => 'UI Design - Period 2',
                    ),
					array(
                        'id'        => 'studio_p3',
                        'type'      => 'text',
                        'title'     => 'UI Design - Period 3',
                    ),
					array(
                        'id'        => 'studio_p4',
                        'type'      => 'text',
                        'title'     => 'UI Design - Period 4',
                    ),
					
					// prototype
					array(
						'id' 		=> 'prototype_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'prototype_c',
                        'type'      => 'text',
                        'title'     => 'Prototype - C',
                    ),
					array(
                        'id'        => 'prototype_dsid',
                        'type'      => 'text',
                        'title'     => 'Prototype - DSID',
                    ),
					array(
                        'id'        => 'prototype_p1',
                        'type'      => 'text',
                        'title'     => 'Prototype - Period 1',
                    ),
					array(
                        'id'        => 'prototype_p2',
                        'type'      => 'text',
                        'title'     => 'Prototype - Period 2',
                    ),
					array(
                        'id'        => 'prototype_p3',
                        'type'      => 'text',
                        'title'     => 'Prototype - Period 3',
                    ),
					array(
                        'id'        => 'prototype_p4',
                        'type'      => 'text',
                        'title'     => 'Prototype - Period 4',
                    ),

                ),
            );
			
			
			$this->sections[] = array(
                'title'      => 'Period Dates',
                'desc'       => '',
                'icon'       => 'el-icon-calendar',
                'fields'   	 => array(
					array(
                        'id'        => 'evnt_start_p1',
                        'type'      => 'date',
                        'title'     => 'Period 1 Start Date',
                    ),					
					array(
                        'id'        => 'evnt_end_p1',
                        'type'      => 'date',
                        'title'     => 'Period 1 End Date',
                    ),					
					array(
						'id' 		=> 'period_1_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'evnt_start_p2',
                        'type'      => 'date',
                        'title'     => 'Period 2 Start Date',
                    ),					
					array(
                        'id'        => 'evnt_end_p2',
                        'type'      => 'date',
                        'title'     => 'Period 2 End Date',
                    ),					
					array(
						'id' 		=> 'period_2_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'evnt_start_p3',
                        'type'      => 'date',
                        'title'     => 'Period 3 Start Date',
                    ),					
					array(
                        'id'        => 'evnt_end_p3',
                        'type'      => 'date',
                        'title'     => 'Period 3 End Date',
                    ),					
					array(
						'id' 		=> 'period_3_divider',
						'type' 		=> 'divide',
					),
					array(
                        'id'        => 'evnt_start_p4',
                        'type'      => 'date',
                        'title'     => 'Period 4 Start Date',
                    ),					
					array(
                        'id'        => 'evnt_end_p4',
                        'type'      => 'date',
                        'title'     => 'Period 4 End Date',
                    ),					
                ),
            );
        }

        public function setHelpTabs() {
			
            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'Help',
                'title'     => 'Theme Information 1',
                'content'   => '<p>coming soon...</p>'
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = '<p>Ask James.</p>';
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'site_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Site Options', 'redux-framework-demo'),
                'page_title'        => __('Site Options', 'redux-framework-demo'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => false,                    // Enable basic customizer support

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => false,                   // Shows the Import/Export panel when not used as a field.
				'hide_reset' 		=> true,
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => '',
                'title' => '',
                'icon'  => 'el-icon-user'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p></p>', 'redux-framework-demo');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
