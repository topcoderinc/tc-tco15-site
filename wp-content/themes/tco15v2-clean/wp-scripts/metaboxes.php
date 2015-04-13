<?php
/* side bars */
if(! function_exists('smk_get_all_sidebars') ) {
	function smk_get_all_sidebars(){
		global $wp_registered_sidebars;
		$all_sidebars = array();
		if ( $wp_registered_sidebars && ! is_wp_error( $wp_registered_sidebars ) ) {

			foreach ( $wp_registered_sidebars as $sidebar ) {
				$all_sidebars[ $sidebar['id'] ] = $sidebar['name'];
			}

		}
		return $all_sidebars;
	}
}
function get_sidebar_list(){
	$sb_array = array(); 
	array_push($sb_array,array(
		'name'=>'No Sidebar',
		'value'=>'0'
	)); 
	$the_sidebars = smk_get_all_sidebars();
	foreach($the_sidebars as $key => $value){
		$option = array(
			'name'=>$value,
			'value'=> $key
		);
		array_push($sb_array,$option);
	}
	return  $sb_array;
}

/* metaboxes */
function additional_page_attr_metaboxes($meta_boxes) {
	$prefix = '_cmb_'; // Prefix for all fields
	
	/* additional_attr metabox */
	$meta_boxes ['additional_attr_metabox'] = array (
			'id' => 'additional_attr_metabox',
			'title' => 'Additional Page Attributes',
			'pages' => array (
					'page', 
			), // post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array (
					array (
						'name' 	=> 'Sidebar',
						'desc' 	=> '',
						'id' 	=> $prefix . 'right_sb_select',
						'type' 	=> 'select',
						'options' => get_sidebar_list()
					),
					array (
						'name' 	=> 'Masthead',
						'desc' 	=> '',
						'id' 	=> $prefix . 'masthead',
						'type' 	=> 'wysiwyg'
					),
					array(
						'name' 	=> 'For Regional Events Pages',
						'type' 	=> 'title',
						'id' 	=> $prefix . 'regional-events-title'
					),
					array (
						'name' 	=> 'Date',
						'id' 	=> $prefix . 'reg-event-date',
						'type' 	=> 'text_date'
					),
					array (
						'name' 	=> 'Location',
						'id' 	=> $prefix . 'reg-event-location',
						'type' 	=> 'text'
					),
					array (
						'name' 	=> 'External Link',
						'id' 	=> $prefix . 'reg-event-external',
						'type' 	=> 'text'
					),
			) 
	);

	/* calendar metabox */
	$meta_boxes ['calendar_metabox'] = array (
			'id' => 'calendar_metabox',
			'title' => 'Timeline',
			'pages' => array (
					'calendar'
			), // post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array (
					array (
							'name' => 'Start Date ',
							'desc' => '(mm/dd/yyyy)',
							'id' => $prefix . 'start_date',
							'type' => 'text_date'
					),
					array (
							'name' => 'End Date',
							'desc' => '(mm/dd/yyyy)',
							'id' => $prefix . 'end_date',
							'type' => 'text_date'
					),
					array (
							'name' 	=> 'Third Column',
							'desc' 	=> '(optional)',
							'id' 	=> $prefix . 'extra_column_1',
							'type' 	=> 'text'
					),
					array (
							'name' 	=> 'Fourth Column',
							'desc' 	=> '(optional)',
							'id' 	=> $prefix . 'extra_column_2',
							'type' 	=> 'text'
					),
					array (
							'name' 	=> 'Fifth Column',
							'desc' 	=> '(optional)',
							'id' 	=> $prefix . 'extra_column_3',
							'type' 	=> 'text'
					),
					array (
							'name' 	=> 'Title Link',
							'desc' 	=> 'Link the Title with this URL (optional)',
							'id' 	=> $prefix . 'title_link',
							'type' 	=> 'text'
					)
			)
	);
	
	return $meta_boxes;
}
add_filter ( 'cmb_meta_boxes', 'additional_page_attr_metaboxes' );



/* metaboxes */
function member_metaboxes($meta_boxes) {
	
	$meta_boxes ['visa_metabox'] = array (
		'id' 		=> 'visa_metabox',
		'title' 	=> 'Visa Request Letter:',
		'pages' 	=> array ('member'), // post type
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'show_names' => true, // Show field names on the left
		'fields' 	=> array (
			array (
				'name' 	=> 'Request Date',
				'desc' 	=> '',
				'id' 	=> '_visa_request_date',
				'type' 	=> 'text_date'
			),
			array (
				'name' 	=> 'Request Status',
				'desc' 	=> '',
				'id' 	=> '_visa_status',
				'type' 	=> 'select',
				'options'=> array(
					array('name' => '', 'value' => '' ),
					array('name' => 'Pending', 'value' => 'Pending' ),
					array('name' => 'Sent',  'value' => 'Sent' ),
					array('name' => 'Denied',  'value' => 'Denied' )
				)
			),
			array (
				'name' 	=> 'Status Date',
				'desc' 	=> '',
				'id' 	=> '_visa_status_date',
				'type' 	=> 'text_date'
			),
			array (
				'name' 	=> 'Name in the Passport',
				'desc' 	=> '',
				'id' 	=> '_passport_name',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Address 1',
				'desc' 	=> 'address indicated in passport',
				'id' 	=> '_passport_address1',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Address 2',
				'desc' 	=> 'extra address field',
				'id' 	=> '_passport_address2',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Address 3',
				'desc' 	=> 'extra address field',
				'id' 	=> '_passport_address3',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'City',
				'desc' 	=> 'city indicated in passport',
				'id' 	=> '_passport_city',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'State',
				'desc' 	=> 'state indicated in passport',
				'id' 	=> '_passport_state',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Postal',
				'desc' 	=> 'postal indicated in passport',
				'id' 	=> '_passport_postal',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Province',
				'desc' 	=> 'province indicated in passport',
				'id' 	=> '_passport_province',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Country',
				'desc' 	=> 'country indicated in passport',
				'id' 	=> '_passport_country',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Shipping Address 1',
				'desc' 	=> '',
				'id' 	=> '_shipping_address1',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Shipping Address 2',
				'desc' 	=> '',
				'id' 	=> '_shipping_address2',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Shipping Address 3',
				'desc' 	=> '',
				'id' 	=> '_shipping_address3',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Shipping City',
				'desc' 	=> '',
				'id' 	=> '_shipping_city',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Shipping State',
				'desc' 	=> '',
				'id' 	=> '_shipping_state',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Shipping Postal',
				'desc' 	=> 'postal indicated in passport',
				'id' 	=> '_shipping_postal',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Shipping Province',
				'desc' 	=> 'province indicated in passport',
				'id' 	=> '_shipping_province',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Shipping Country',
				'desc' 	=> 'country indicated in passport',
				'id' 	=> '_shipping_country',
				'type' 	=> 'text'
			)
		)
	);
		
	$prefix = '_member_'; // Prefix for all fields	
	/* member metabox */
	$meta_boxes ['member_metabox'] = array (
		'id' 		=> 'member_metabox',
		'title' 	=> 'Member\'s Info',
		'pages' 	=> array ('member'), // post type
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'show_names' => true, // Show field names on the left
		'fields' 	=> array (
			array (
				'name' 	=> 'Name',
				'desc' 	=> 'name of the member',
				'id' 	=> $prefix . 'name',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Email',
				'desc' 	=> '',
				'id' 	=> $prefix . 'email',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Country',
				'desc' 	=> 'member\'s country',
				'id' 	=> $prefix . 'country',
				'type' 	=> 'text'
			),					
			array (
				'name' 	=> 'Track',
				'desc' 	=> '',
				'id' 	=> $prefix . 'track',
				'type' 	=> 'multicheck',
				'options' => array(
					'Algorithm' => 'Algorithm',
					'Design' => 'Design',
					'Development' => 'Development',
					'F2F' => 'F2F',
					'Marathon' => 'Marathon',
					'Mashathon' => 'Mashathon',
					'Studio' => 'Studio',
					'Trip Winner' => 'Trip Winner'
				)
			),
			array(
				'name' 	=> 'Confirmed attendance to the 2014 [topcoder] Open.',
				'desc' 	=> '',
				'id' 	=> $prefix . 'confirm_attendance',
				'type' 	=> 'checkbox'
			),
			array(
				'name' 	=> 'Confirmed to be able to arrive on November 16 and stay through the awards ceremony.',
				'desc' 	=> '',
				'id' 	=> $prefix . 'confirm_arrival',
				'type' 	=> 'checkbox'
			),
			array(
				'name' 	=> 'Confirmed to have the proper travel documents in order to travel to the United States.',
				'desc' 	=> '',
				'id' 	=> $prefix . 'confirm_documents',
				'type' 	=> 'checkbox'
			),
			array (
				'name' 	=> 'Visa/Passport',
				'desc' 	=> '',
				'id' 	=> $prefix . 'identification_card',
				'type' 	=> 'file'
			),
			array (
				'name' 	=> 'Photo',
				'desc' 	=> 'Upload an image or enter an URL.',
				'id' 	=> $prefix . 'photo',
				'type' 	=> 'file'
			),
			array(
				'name'    => 'over 21 years of age at the 2014 [topcoder] Open',
				'id'      => $prefix . 'legal_age',
				'type'    => 'radio_inline',
				'options' => array(
					array('name' => 'Yes', 'value' => 'Yes' ),
					array('name' => 'No',  'value' => 'No' ),
				),
			),
			array (
				'name' 	=> 'Brief Description',
				'desc' 	=> 'Write a brief paragraph describing yourself to someone you\'ve never met.',
				'id' 	=> $prefix . 'description',
				'type' 	=> 'textarea'
			),
			array (
				'name' 	=> '[topcoder] History and Accomplishment',
				'desc' 	=> 'Write a brief paragraph telling us about your [topcoder] history and accomplishments.',
				'id' 	=> $prefix . 'history',
				'type' 	=> 'textarea'
			)
		)
	);
	
	
	$prefix = '_travel_'; // Prefix for all fields
	
	/* member travel form metabox */
	$meta_boxes ['travel_name_metabox'] = array (
		'id' 		=> 'travel_name_metabox',
		'title' 	=> 'Name: (this will be the name your airplane ticket is booked)',
		'pages' 	=> array ('member'), // post type
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'show_names' => true, // Show field names on the left
		'fields' 	=> array (
			array (
				'name' 	=> 'First name',
				'desc' 	=> '',
				'id' 	=> $prefix . 'first_name',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Middle name',
				'desc' 	=> '',
				'id' 	=> $prefix . 'middle_name',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Surname',
				'desc' 	=> '',
				'id' 	=> $prefix . 'surname',
				'type' 	=> 'text'
			)
		)
	);
	
	$meta_boxes ['travel_address_metabox'] = array (
		'id' 		=> 'travel_address_metabox',
		'title' 	=> 'Address:',
		'pages' 	=> array ('member'), // post type
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'show_names' => true, // Show field names on the left
		'fields' 	=> array (
			array (
				'name' 	=> 'Street',
				'desc' 	=> '',
				'id' 	=> $prefix . 'street',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'City',
				'desc' 	=> '',
				'id' 	=> $prefix . 'city',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'State',
				'desc' 	=> '',
				'id' 	=> $prefix . 'state',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Postal Code',
				'desc' 	=> '',
				'id' 	=> $prefix . 'postal',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Country',
				'desc' 	=> '',
				'id' 	=> $prefix . 'country',
				'type' 	=> 'text'
			)
		)
	);
	
	$meta_boxes ['travel_contact_metabox'] = array (
		'id' 		=> 'travel_contact_metabox',
		'title' 	=> 'Contact Information:',
		'pages' 	=> array ('member'), // post type
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'show_names' => true, // Show field names on the left
		'fields' 	=> array (
			array (
				'name' 	=> 'Mobile Number',
				'desc' 	=> '',
				'id' 	=> $prefix . 'mobile_phone',
				'type' 	=> 'text'
			),
		)
	);
	
	$meta_boxes ['travel_emergency_metabox'] = array (
		'id' 		=> 'travel_emergency_metabox',
		'title' 	=> 'Emergency Contact:',
		'pages' 	=> array ('member'), // post type
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'show_names' => true, // Show field names on the left
		'fields' 	=> array (
			array (
				'name' 	=> 'Name',
				'desc' 	=> '',
				'id' 	=> $prefix . 'emergency_name',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Phone or Email',
				'desc' 	=> '',
				'id' 	=> $prefix . 'phone_or_email',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Relationship',
				'desc' 	=> '',
				'id' 	=> $prefix . 'relationship',
				'type' 	=> 'text'
			),
		)
	);
	
	$meta_boxes ['travel_personal_metabox'] = array (
		'id' 		=> 'travel_personal_metabox',
		'title' 	=> 'Personal Information:',
		'pages' 	=> array ('member'), // post type
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'show_names' => true, // Show field names on the left
		'fields' 	=> array (
			array (
				'name' 	=> 'Gender',
				'desc' 	=> '',
				'id' 	=> $prefix . 'gender',
				'type'    => 'radio_inline',
				'options' => array(
					array('name' => 'Male', 'value' => 'Male' ),
					array('name' => 'Female',  'value' => 'Female' ),
				),
			),
			array (
				'name' 	=> 'Date of Birth',
				'desc' 	=> '',
				'id' 	=> $prefix . 'dob',
				'type' 	=> 'text_date'
			),
			array (
				'name' 	=> 'Passport Number',
				'desc' 	=> '',
				'id' 	=> $prefix . 'passport',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Passport Expiration',
				'desc' 	=> '',
				'id' 	=> $prefix . 'passport_expiration',
				'type' 	=> 'text_date'
			),
			array (
				'name' 	=> 'Country of Issue',
				'desc' 	=> '',
				'id' 	=> $prefix . 'passport_country',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Food Allergies',
				'desc' 	=> '',
				'id' 	=> $prefix . 'food_allergies',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Special Consideration in Meals',
				'desc' 	=> '',
				'id' 	=> $prefix . 'meal_consideration',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Special Assistance',
				'desc' 	=> '',
				'id' 	=> $prefix . 'special_assistance',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Handle Phonetic Spelling',
				'desc' 	=> '',
				'id' 	=> $prefix . 'handle_phonetic_spelling',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Fullname Phonetic Spelling',
				'desc' 	=> '',
				'id' 	=> $prefix . 'name_phonetic_spelling',
				'type' 	=> 'text'
			),
		)
	);
	
	$meta_boxes ['travel_info_metabox'] = array (
		'id' 		=> 'travel_info_metabox',
		'title' 	=> 'Travel Information:',
		'pages' 	=> array ('member'), // post type
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'show_names' => true, // Show field names on the left
		'fields' 	=> array (
			array (
				'name' 	=> 'Departure City and Airport',
				'desc' 	=> '',
				'id' 	=> $prefix . 'departure_airport',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Preferred departure time from your home',
				'desc' 	=> '',
				'id' 	=> $prefix . 'departure_home',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Preferred departure time from San Francisco, California on November 20, 2014',
				'desc' 	=> '',
				'id' 	=> $prefix . 'departure_location',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Would you prefer a window or aisle',
				'desc' 	=> '',
				'id' 	=> $prefix . 'airplane_seating',
				'type' 	=> 'text'
			),
			array (
				'name' 	=> 'Special Request',
				'desc' 	=> '',
				'id' 	=> $prefix . 'special_request',
				'type' 	=> 'textarea'
			)
		)
	);
	
	return $meta_boxes;
}
add_filter ( 'cmb_meta_boxes', 'member_metaboxes' );


/* staff metaboxes */
function staff_metaboxes($meta_boxes) {
	$prefix = '_staff_'; // Prefix for all fields
	
	$meta_boxes ['staff_metabox'] = array (
			'id' 		=> 'staff_metabox',
			'title' 	=> 'Staff Info',
			'pages' 	=> array ('staff'), // post type
			'context' 	=> 'normal',
			'priority' 	=> 'high',
			'show_names' => true, // Show field names on the left
			'fields' 	=> array (
					array (
							'name' 	=> 'Name',
							'desc' 	=> 'name of the member',
							'id' 	=> $prefix . 'name',
							'type' 	=> 'text'
					),
					array (
							'name' 	=> 'Email',
							'desc' 	=> '',
							'id' 	=> $prefix . 'email',
							'type' 	=> 'text'
					),
					array (
							'name' 	=> 'Photo',
							'desc' 	=> 'Upload an image or enter an URL.',
							'id' 	=> $prefix . 'photo',
							'type' 	=> 'file'
					),
					array (
							'name' 	=> 'Hidden talent',
							'desc' 	=> '',
							'id' 	=> $prefix . 'talent',
							'type' 	=> 'textarea'
					)
			)
	);
	
	return $meta_boxes;
}
add_filter ( 'cmb_meta_boxes', 'staff_metaboxes' );


// Initialize the metabox class
add_action ( 'init', 'be_initialize_cmb_meta_boxes', 9999 );
function be_initialize_cmb_meta_boxes() {
	if (! class_exists ( 'cmb_Meta_Box' )) {
		require_once ('metabox/init.php');
	}
}