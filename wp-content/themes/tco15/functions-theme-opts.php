<?php

/**
 * Start of Theme Options Support
 */
function themeoptions_admin_menu() {
	add_theme_page ( "Theme Options", "Theme Options", 'edit_themes', basename ( __FILE__ ), 'themeoptions_page' );
}
add_action ( 'admin_menu', 'themeoptions_admin_menu' );
function themeoptions_page() {
	if ($_POST ['update_themeoptions'] == 'true') {
		themeoptions_update ();
	} // check options update
	  // here's the main function that will generate our options page
	?>

<div class="wrap">
	<div id="icon-themes" class="icon32">
		<br />
	</div>
	<h2>TCO14 Backend Theme Options</h2>

	<form method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" name="update_themeoptions" value="true" />
		<h3>General Theme Options</h3>
		<table width="100%">
			<tr>
				<?php $field = 'site_layout'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Site Layout:</label></td>
				<td><select id="<?php echo $field; ?>" name="<?php echo $field; ?>" value="">
						<option <?php if(get_option($field)=="Full"){ echo "selected=selected";} ?> value="Full">Full</option>
						<option <?php if(get_option($field)=="Centered"){ echo "selected=selected";} ?> value="Centered">Centered</option>
					</select></td>
			</tr>
			<tr>
				<?php $field = 'email_addr_to_receive_mail'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Email address to receive mail:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'twtr_keyword'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Twitter Keyword:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'evnt_id'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Event ID:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'module'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Module:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />


		<h3>Registration Settings</h3>
		<table width="100%">
			<tr>
				<?php $field = 'reg_setting_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'reg_setting_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />
		<h3>Algorithm Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'algo_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'algo_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />
		<h3>Marathon Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'marathon_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'marathon_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />
		<h3>First2Finish Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'mod_dash_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mod_dash_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mod_dash_p1'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 1:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mod_dash_p2'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 2:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mod_dash_p3'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 3:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mod_dash_p4'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 4:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />
		<h3>Copilot Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'copilot_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'copilot_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />
		<h3>Design Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'design_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'design_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'design_p1'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 1:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'design_p2'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 2:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'design_p3'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 3:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'design_p4'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 4:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />
		<h3>Development Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'dev_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'dev_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'dev_p1'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 1:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'dev_p2'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 2:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'dev_p3'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 3:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'dev_p4'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 4:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />
		<h3>Studio Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'studio_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'studio_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'studio_p1'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 1:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'studio_p2'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 2:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'studio_p3'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 3:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'studio_p4'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 4:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />
		<h3>UI Prototype Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'ui_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'ui_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'ui_p1'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 1:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'ui_p2'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 2:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'ui_p3'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 3:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'ui_p4'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 4:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />
		<h3>Wireframe Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'wireframe_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'wireframe_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'wireframe_p1'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 1:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'wireframe_p2'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 2:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'wireframe_p3'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 3:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'wireframe_p4'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 4:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		
		<br />
		<h3>Mashathon Leaderboard</h3>
		<table width="100%">
			<tr>
				<?php $field = 'mashathon_c'; ?>
				<td width="150"><label for="<?php echo $field; ?>">c:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mashathon_dsid'; ?>
				<td width="150"><label for="<?php echo $field; ?>">dsid:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mashathon_p1'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 1:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mashathon_p2'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 2:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mashathon_p3'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 3:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'mashathon_p4'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 4:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		
		<br />
		<h3>Event Period Dates</h3>
		<table width="100%">
			<tr>
				<?php $field = 'evnt_start_p1'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 1 Start Date:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'evnt_end_p1'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 1 End Date:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'evnt_start_p2'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 2 Start Date:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'evnt_end_p2'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 2 End Date:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'evnt_start_p3'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 3 Start Date:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'evnt_end_p3'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 3 End Date:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'evnt_start_p4'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 4 Start Date:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'evnt_end_p4'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Period 4 End Date:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		<br />

		<h3>Signup Messages</h3>
		<table width="100%">
			<tr>
				<?php $field = 'already_registered'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Already registered msg:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'success'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Success msg:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
			<tr>
				<?php $field = 'already_agreed'; ?>
				<td width="150"><label for="<?php echo $field; ?>">Already agreed msg:</label></td>
				<td><input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" size="100" value="<?php echo get_option($field); ?>" /></td>
			</tr>
		</table>
		
		<br/>
		<p>
			<input type="submit" name="submit" value="Update Options" class="button button-primary" />
		</p>
	</form>

</div>
<?php
}

// Set default options
if (is_admin () && isset ( $_GET ['activated'] ) && $pagenow == 'themes.php') {
	
	// Singup msg Options
	update_option ( 'already_registered', 'You have already registered for the TCO14.' );
	update_option ( 'success', 'Thanks for registration!' );
	update_option ( 'already_agreed',  'You have already joined for the TCO14.' );
	
	// Other Options
	update_option ( 'email_addr_to_receive_mail', 'jamesmarquez@gmail.com' );
	update_option ( 'twtr_keyword', '%23tco14' );
	update_option ( 'evnt_id', '3437' );
	update_option ( 'module',  'BasicData' );
	
	// Registration Settings
	update_option ( 'reg_setting_c', 'tco_registrants');
	update_option ( 'reg_setting_dsid', '30' );
	
	// Algorithm Leaderboard
	update_option ( 'algo_c', 'TCO12_alg_adv_overview' );
	update_option ( 'algo_dsid', '27' );
	
	// Marathon Leaderboard
	update_option ( 'marathon_c', 'TCO13_mm_adv_overview' );
	update_option ( 'marathon_dsid', '27' );
	
	// Mod Dash Leaderboard
	update_option ( 'mod_dash_c', 'dd_mod_dash_tco_leaderboard' );
	update_option ( 'mod_dash_dsid','34');
	update_option ( 'mod_dash_p1', '');
	update_option ( 'mod_dash_p2', '');
	update_option ( 'mod_dash_p3', '');
	update_option ( 'mod_dash_p4', '');
	
	// Copilot Leaderboard
	update_option ( 'copilot_c', 'tco_copilot_leaderboard_2012' );
	update_option ( 'copilot_dsid', '30' );
	
	// Design Leaderboard
	update_option ( 'design_c', 'tco_software_leaderboard' );
	update_option ( 'design_dsid', '30' );
	update_option ( 'design_p1', '532');
	update_option ( 'design_p2', '533');
	update_option ( 'design_p3', '534');
	update_option ( 'design_p4', '535');
	
	// Development Leaderboard
	update_option ( 'dev_c', 'tco_software_leaderboard' );
	update_option ( 'dev_dsid', '30' );
	update_option ( 'dev_p1', '504' );
	update_option ( 'dev_p2', '505' );
	update_option ( 'dev_p3', '506' );
	update_option ( 'dev_p4', '507' );
	
	// Studio Leaderboard
	update_option ( 'studio_c', 'tco_studio_leaderboard' );
	update_option ( 'studio_dsid', '30' );
	update_option ( 'studio_p1', '540');
	update_option ( 'studio_p2', '541');
	update_option ( 'studio_p3', '542');
	update_option ( 'studio_p4', '543' );
	
	// UI Prototype Leaderboard
	update_option ( 'ui_c', 'tco_software_leaderboard' );
	update_option ( 'ui_dsid', '30' );
	update_option ( 'ui_p1', '548' );
	update_option ( 'ui_p2', '549' );
	update_option ( 'ui_p3', '550' );
	update_option ( 'ui_p4', '551' );
	
	// Wireframe Leaderboard
	update_option ( 'wireframe_c', 'tco_studio_leaderboard' );
	update_option ( 'wireframe_dsid', '30' );
	update_option ( 'wireframe_p1', '520' );
	update_option ( 'wireframe_p2', '521' );
	update_option ( 'wireframe_p3', '522' );
	update_option ( 'wireframe_p4', '523' );

	// Mashathon Leaderboard
	update_option ( 'mashathon_c', 'tco_studio_leaderboard' );
	update_option ( 'mashathon_dsid', '30' );
	update_option ( 'mashathon_p1', '');
	update_option ( 'mashathon_p2', '');
	update_option ( 'mashathon_p3', '');
	update_option ( 'mashathon_p4', '' );
	
	// Event Period Leaderboard
	update_option ( 'evnt_start_p1', '2012-07-01' );
	update_option ( 'evnt_start_p2', '2012-10-01' );
	update_option ( 'evnt_start_p3', '2013-01-01' );
	update_option ( 'evnt_start_p4', '2013-03-01' );
	
	update_option ( 'evnt_end_p1', '2012-10-01' );
	update_option ( 'evnt_end_p2', '2012-01-01' );
	update_option ( 'evnt_end_p3', '2013-03-01' );
	update_option ( 'evnt_end_p4', '2013-07-01' );
	
	}

// Update options function
function themeoptions_update() {
	// logo
	update_option ( 'site_logo', $_POST ['site_logo'] );
	
	// Singup msg Options
	update_option ( 'already_registered', $_POST ['already_registered'] );
	update_option ( 'success', $_POST ['success'] );
	update_option ( 'already_agreed',  $_POST ['already_agreed'] );
	
	// Other Options
	update_option ( 'site_layout', $_POST ['site_layout'] );
	update_option ( 'email_addr_to_receive_mail', $_POST ['email_addr_to_receive_mail'] );
	update_option ( 'twtr_keyword', $_POST ['twtr_keyword'] );
	update_option ( 'evnt_id', $_POST ['evnt_id'] );
	update_option ( 'module', $_POST ['module'] );
	
	// Registration Settings
	update_option ( 'reg_setting_c', $_POST ['reg_setting_c'] );
	update_option ( 'reg_setting_dsid', $_POST ['reg_setting_dsid'] );
	
	// Algorithm Leaderboard
	update_option ( 'algo_c', $_POST ['algo_c'] );
	update_option ( 'algo_dsid', $_POST ['algo_dsid'] );
	
	// Marathon Leaderboard
	update_option ( 'marathon_c', $_POST [marathon_c] );
	update_option ( 'marathon_dsid', $_POST ['marathon_dsid'] );
	
	// Mod Dash Leaderboard
	update_option ( 'mod_dash_c', $_POST ['mod_dash_c'] );
	update_option ( 'mod_dash_dsid', $_POST ['mod_dash_dsid'] );
	update_option ( 'mod_dash_p1', $_POST ['mod_dash_p1']);
	update_option ( 'mod_dash_p2', $_POST ['mod_dash_p2']);
	update_option ( 'mod_dash_p3', $_POST ['mod_dash_p3']);
	update_option ( 'mod_dash_p4', $_POST ['mod_dash_p4']);
	
	// Copilot Leaderboard
	update_option ( 'copilot_c', $_POST ['copilot_c'] );
	update_option ( 'copilot_dsid', $_POST ['copilot_dsid'] );
	
	// Design Leaderboard
	update_option ( 'design_c', $_POST ['design_c'] );
	update_option ( 'design_dsid', $_POST ['design_dsid'] );
	update_option ( 'design_p1', $_POST ['design_p1'] );
	update_option ( 'design_p2', $_POST ['design_p2'] );
	update_option ( 'design_p3', $_POST ['design_p3'] );
	update_option ( 'design_p4', $_POST ['design_p4'] );
	
	// Development Leaderboard
	update_option ( 'dev_c', $_POST ['dev_c'] );
	update_option ( 'dev_dsid', $_POST ['dev_dsid'] );
	update_option ( 'dev_p1', $_POST ['dev_p1'] );
	update_option ( 'dev_p2', $_POST ['dev_p2'] );
	update_option ( 'dev_p3', $_POST ['dev_p3'] );
	update_option ( 'dev_p4', $_POST ['dev_p4'] );
	
	// Studio Leaderboard
	update_option ( 'studio_c', $_POST ['studio_c'] );
	update_option ( 'studio_dsid', $_POST ['studio_dsid'] );
	update_option ( 'studio_p1', $_POST ['studio_p1'] );
	update_option ( 'studio_p2', $_POST ['studio_p2'] );
	update_option ( 'studio_p3', $_POST ['studio_p3'] );
	update_option ( 'studio_p4', $_POST ['studio_p4'] );
	
	// UI Prototype Leaderboard
	update_option ( 'ui_c', $_POST ['ui_c'] );
	update_option ( 'ui_dsid', $_POST ['ui_dsid'] );
	update_option ( 'ui_p1', $_POST ['ui_p1'] );
	update_option ( 'ui_p2', $_POST ['ui_p2'] );
	update_option ( 'ui_p3', $_POST ['ui_p3'] );
	update_option ( 'ui_p4', $_POST ['ui_p4'] );
	
	// Wireframe Leaderboard
	update_option ( 'wireframe_c', $_POST ['wireframe_c'] );
	update_option ( 'wireframe_dsid', $_POST ['wireframe_dsid'] );
	update_option ( 'wireframe_p1', $_POST ['wireframe_p1'] );
	update_option ( 'wireframe_p2', $_POST ['wireframe_p2'] );
	update_option ( 'wireframe_p3', $_POST ['wireframe_p3'] );
	update_option ( 'wireframe_p4', $_POST ['wireframe_p4'] );

	// Mashathon Leaderboard
	update_option ( 'mashathon_c', $_POST ['mashathon_c'] );
	update_option ( 'mashathon_dsid', $_POST ['mashathon_dsid'] );
	update_option ( 'mashathon_p1', $_POST ['mashathon_p1'] );
	update_option ( 'mashathon_p2', $_POST ['mashathon_p2'] );
	update_option ( 'mashathon_p3', $_POST ['mashathon_p3'] );
	update_option ( 'mashathon_p4', $_POST ['mashathon_p4'] );
	
	// Event Period Leaderboard
	update_option ( 'evnt_start_p1', $_POST ['evnt_start_p1'] );
	update_option ( 'evnt_start_p2', $_POST ['evnt_start_p2'] );
	update_option ( 'evnt_start_p3', $_POST ['evnt_start_p3'] );
	update_option ( 'evnt_start_p4', $_POST ['evnt_start_p4'] );
	update_option ( 'evnt_start_p5', $_POST ['evnt_start_p5'] );
	update_option ( 'evnt_start_p6', $_POST ['evnt_start_p6'] );
	
	// Event Period Leaderboard
	update_option ( 'evnt_end_p1', $_POST ['evnt_end_p1'] );
	update_option ( 'evnt_end_p2', $_POST ['evnt_end_p2'] );
	update_option ( 'evnt_end_p3', $_POST ['evnt_end_p3'] );
	update_option ( 'evnt_end_p4', $_POST ['evnt_end_p4'] );
	
	// Twitter OAuth 
	update_option ( 'twConsumerKey', $_POST ['twConsumerKey'] );
	update_option ( 'twConsumerSecret', $_POST ['twConsumerSecret'] );
	update_option ( 'twAccessToken', $_POST ['twAccessToken'] );
	update_option ( 'twAccessTokenSecret', $_POST ['twAccessTokenSecret'] );
}
// END OF THEME OPTIONS SUPPORT


