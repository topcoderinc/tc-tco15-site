<?php


function themeoptions_page()
{
	$config = array(
		array(
			'label' 	=> 'Email address to receive mail',
			'parameter'	=> 'r_email',
			'defaultValue'	=> 'aalbenben@163.com'
		),
		array(
			'label' 	=> 'Twitter Keyword (It is used in TCO tweet page.)',
			'parameter'	=> 'feed_tco',
			'defaultValue'	=> '%23tco13'
		),
		array(
			'label' 	=> 'Event ID',
			'parameter'	=> 'event_id',
			'defaultValue'	=> '3436'
		),
		array(
			'label' 	=> 'module',
			'parameter' => 'module',
			'defaultValue'	=> 'BasicData'
		),
		array(
			'label'		=> 'Registrants Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'reg_c',
					'defaultValue'	=> 'tco_registrants'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'reg_dsid',
					'defaultValue'	=> '30'
				)
			)
		),
		array(
			'label'		=> 'Algorithm Leaderboard Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'alg_c',
					'defaultValue'	=> 'TCO12_alg_adv_overview'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'alg_dsid',
					'defaultValue'	=> '27'
				)
			)
		),
		array(
			'label'		=> 'Design Leaderboard Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'design_c',
					'defaultValue'	=> 'tco_software_leaderboard'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'design_dsid',
					'defaultValue'	=> '30'
				),
				array(
					'label' 	=> 'Period 1',
					'parameter' => 'design_p1',
					'defaultValue'	=> '500'
				),
				array(
					'label' 	=> 'Period 2',
					'parameter' => 'design_p2',
					'defaultValue'	=> '501'
				),
				array(
					'label' 	=> 'Period 3',
					'parameter' => 'design_p3',
					'defaultValue'	=> '502'
				),
				array(
					'label' 	=> 'Period 4',
					'parameter' => 'design_p4',
					'defaultValue'	=> '503'
				)
			)
		),
		array(
			'label'		=> 'Development Leaderboard Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'dev_c',
					'defaultValue'	=> 'tco_software_leaderboard'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'dev_dsid',
					'defaultValue'	=> '30'
				),
				array(
					'label' 	=> 'Period 1',
					'parameter' => 'dev_p1',
					'defaultValue'	=> '504'
				),
				array(
					'label' 	=> 'Period 2',
					'parameter' => 'dev_p2',
					'defaultValue'	=> '505'
				),
				array(
					'label' 	=> 'Period 3',
					'parameter' => 'dev_p3',
					'defaultValue'	=> '506'
				),
				array(
					'label' 	=> 'Period 4',
					'parameter' => 'dev_p4',
					'defaultValue'	=> '507'
				)
			)
		),
		array(
			'label'		=> 'Studio Leaderboard Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'studio_c',
					'defaultValue'	=> 'tco_studio_leaderboard'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'studio_dsid',
					'defaultValue'	=> '30'
				),
				array(
					'label' 	=> 'Period 1',
					'parameter' => 'studio_p1',
					'defaultValue'	=> '508'
				),
				array(
					'label' 	=> 'Period 2',
					'parameter' => 'studio_p2',
					'defaultValue'	=> '509'
				),
				array(
					'label' 	=> 'Period 3',
					'parameter' => 'studio_p3',
					'defaultValue'	=> '510'
				),
				array(
					'label' 	=> 'Period 4',
					'parameter' => 'studio_p4',
					'defaultValue'	=> '511'
				)
			)
		),
		array(
			'label'		=> 'UI Prototyope Leaderboard Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'ui_c',
					'defaultValue'	=> 'tco_software_leaderboard'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'ui_dsid',
					'defaultValue'	=> '30'
				),
				array(
					'label' 	=> 'Period 1',
					'parameter' => 'ui_p1',
					'defaultValue'	=> '516'
				),
				array(
					'label' 	=> 'Period 2',
					'parameter' => 'ui_p2',
					'defaultValue'	=> '517'
				),
				array(
					'label' 	=> 'Period 3',
					'parameter' => 'ui_p3',
					'defaultValue'	=> '518'
				),
				array(
					'label' 	=> 'Period 4',
					'parameter' => 'ui_p4',
					'defaultValue'	=> '519'
				)
			)
		),
		array(
			'label'		=> 'Wireframe Leaderboard Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'wf_c',
					'defaultValue'	=> 'tco_studio_leaderboard'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'wf_dsid',
					'defaultValue'	=> '30'
				),
				array(
					'label' 	=> 'Period 1',
					'parameter' => 'wf_p1',
					'defaultValue'	=> '520'
				),
				array(
					'label' 	=> 'Period 2',
					'parameter' => 'wf_p2',
					'defaultValue'	=> '521'
				),
				array(
					'label' 	=> 'Period 3',
					'parameter' => 'wf_p3',
					'defaultValue'	=> '522'
				),
				array(
					'label' 	=> 'Period 4',
					'parameter' => 'wf_p4',
					'defaultValue'	=> '523'
				)
			)
		),
		array(
			'label'		=> 'Marathon Leaderboard Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'mar_c',
					'defaultValue'	=> 'TCO12_mm_adv_overview'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'mar_dsid',
					'defaultValue'	=> '27'
				)
			)
		),
		array(
			'label'		=> 'Copilot Leaderboard Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'co_c',
					'defaultValue'	=> 'tco_copilot_leaderboard_2012'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'co_dsid',
					'defaultValue'	=> '30'
				),
				array(
					'label' 	=> 'Period 1 Starting Date',
					'parameter' => 'co_s_p1',
					'defaultValue'	=> '2012-07-01'
				),
				array(
					'label' 	=> 'Period 1 Ending Date',
					'parameter' => 'co_e_p1',
					'defaultValue'	=> '2012-09-30'
				),
				array(
					'label' 	=> 'Period 2 Starting Date',
					'parameter' => 'co_s_p2',
					'defaultValue'	=> '2012-10-01'
				),
				array(
					'label' 	=> 'Period 2 Ending Date',
					'parameter' => 'co_e_p2',
					'defaultValue'	=> '2012-12-31'
				),
				array(
					'label' 	=> 'Period 3 Starting Date',
					'parameter' => 'co_s_p3',
					'defaultValue'	=> '2013-01-01'
				),
				array(
					'label' 	=> 'Period 3 Ending Date',
					'parameter' => 'co_e_p3',
					'defaultValue'	=> '2013-03-31'
				),
				array(
					'label' 	=> 'Period 4 Starting Date',
					'parameter' => 'co_s_p4',
					'defaultValue'	=> '2013-04-01'
				),
				array(
					'label' 	=> 'Period 4 Ending Date',
					'parameter' => 'co_e_p4',
					'defaultValue'	=> '2012-06-30'
				)
			)
		),
		array(
			'label'		=> 'Mod Dash Leaderboard Configure',
			'items'		=> array(
				array(
					'label' 	=> 'c',
					'parameter' => 'mo_c',
					'defaultValue'	=> 'dd_mod_dash_tco_leaderboard'
				),
				array(
					'label' 	=> 'dsid',
					'parameter' => 'mo_dsid',
					'defaultValue'	=> '34'
				),
				array(
					'label' 	=> 'Period 1 Starting Date',
					'parameter' => 'mo_s_p1',
					'defaultValue'	=> '2012-07-01'
				),
				array(
					'label' 	=> 'Period 1 Ending Date',
					'parameter' => 'mo_e_p1',
					'defaultValue'	=> '2012-09-30'
				),
				array(
					'label' 	=> 'Period 2 Starting Date',
					'parameter' => 'mo_s_p2',
					'defaultValue'	=> '2012-10-01'
				),
				array(
					'label' 	=> 'Period 2 Ending Date',
					'parameter' => 'mo_e_p2',
					'defaultValue'	=> '2012-12-31'
				),
				array(
					'label' 	=> 'Period 3 Starting Date',
					'parameter' => 'mo_s_p3',
					'defaultValue'	=> '2013-01-01'
				),
				array(
					'label' 	=> 'Period 3 Ending Date',
					'parameter' => 'mo_e_p3',
					'defaultValue'	=> '2013-03-31'
				),
				array(
					'label' 	=> 'Period 4 Starting Date',
					'parameter' => 'mo_s_p4',
					'defaultValue'	=> '2013-04-01'
				),
				array(
					'label' 	=> 'Period 4 Ending Date',
					'parameter' => 'mo_e_p4',
					'defaultValue'	=> '2012-06-30'
				)
			)
		)
							
	);
    if ( $_POST['update_themeoptions'] == 'true' ) { 
		themeoptions_update($config); 
	}  //check options update
    
    
   
    ?>
    <div class="wrap">
        <div id="icon-themes" class="icon32"><br /></div>
        <style>
			.wrap h1 {
				line-height: 55px;
			}
		</style>
        <h1>Theme Options</h1>
        <form method="POST" action="">         
            
	<?php
	renderConfigure($config);
	?>
           	                          
            <p><input type="submit" name="submit" value="Update Options" class="button button-primary" /></p>
            <input type="hidden" name="update_themeoptions" value="true" />
        </form>

    </div>
    <?php
}

/**
 * Start of Theme Options
 */
function themeoptions_admin_menu() {
    add_theme_page("Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'themeoptions_page');
}

/**
 * Render each configuration. 
 */
function renderConfigure($configs) {
	foreach ($configs as $config) {
		$label = $config['label'];
		$field = $config['parameter'];
		if ($field) {
			$default = $config['defaultValue'];
			add_option($field, $default);
?>
			<p>
                <label for="<?php echo $field; ?>"><strong><?php echo $label; ?> :</strong></label><br />
                <input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" size="150" value="<?php echo get_option($field); ?>"/>   
            </p> 
<?php
		} else {
			$items = $config['items'];
			if ($items) {
?>
			<h2><?php echo $label; ?></h2>
<?php		
				renderConfigure($items);
			} else {
?>
			<p><?php echo $label; ?></p>
<?php
			}
		}
	}
}

// Update options function
function themeoptions_update($configs) {
	
	foreach ($configs as $config) {
		$label = $config['label'];
		$field = $config['parameter'];
		if ($field) {
			$default = $config['defaultValue'];
			update_option($field, $_POST[$field]);
		} else {
			$items = $config['items'];
			if ($items) {
				themeoptions_update($items);
			}
		}
	}
}
add_action('admin_menu', 'themeoptions_admin_menu');

?>