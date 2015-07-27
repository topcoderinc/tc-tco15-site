<?php 
	get_header(); 

	// get all fields
	$field_group = get_page_by_title( 'Travel Form', 'OBJECT', 'acf' );
	$fields = get_post_custom_keys($field_group->ID);
	foreach ( $fields as $key => $fieldkey ) {
		if (stristr($fieldkey,'field_')) {
			$tmp = get_field_object($fieldkey, $groupID);
			$field[$tmp['name']] = $tmp;
		}
	}
	
	// send email
	if ( isset($_POST) && $_POST['handle']!='' ) {
		$message = '<p><strong>Name</strong><br />' . 
				'Handle: ' . $_POST['handle'] . "<br />" .
				'First name: ' . $_POST['first_name'] . "<br />" .
				'Middle name: ' . $_POST['middle_name'] . "<br />" .
				'Surname: ' . $_POST['surname'] . "</p>" .
				 
				'<p><strong>Address</strong><br />' .
				'Street: ' . $_POST['street'] . "<br />" . 
				'City: ' . $_POST['city'] . "<br />" . 
				'State/Province: ' . $_POST['state_province'] . "<br />" . 
				'Postal Code: ' . $_POST['postal_code'] . "<br />" . 
				'Country: ' . $_POST['country'] . "</p>" . 
				 
				'<p><strong>Contact Information</strong><br />' . 
				'Mobile Number: ' . $_POST['mobile_phone'] . "<br />" . 
				'Email Address: ' . $_POST['email_address'] . "</p>" . 
				 
				'<p><strong>Emergency Contact</strong><br />' .
				'Name: ' . $_POST['emergency_name'] . "<br />" . 
				'Phone or Email: ' . $_POST['emergency_contact'] . "<br />" . 
				'Relationship: ' . $_POST['relationship'] . "</p>" . 
				 
				'<p><strong>Personal Information</strong>' . "<br />" .
				'Gender: ' . $_POST['gender']. "<br />" . 
				'Date of Birth: ' . $_POST['date_of_birth'] . "<br />" . 
				'Passport Number: ' . $_POST['passport_number'] . "<br />" . 
				'Passport Expiration Date: ' . $_POST['passport_expiration_date'] . "<br />" . 
				'Country of Issue: ' . $_POST['country_of_issue'] . "<br />" . 
				'Food Allergies: ' . $_POST['allergies'] . "<br />" . 
				'Meal Consideration: ' . $_POST['meals'] . "<br />" . 
				'Special Assistance: ' . $_POST['special_assistance'] . "<br />" . 
				'Handle Phonetic Spelling: ' . $_POST['handle_phonetic'] . "<br />" . 
				'Name Phonetic Spelling: ' . $_POST['name_phonetic'] . "</p>" . 
				 
				'<p><strong>Travel Information</strong>' . "<br />" .
				'Event Location: ' . $_POST['event_you_are_attending'] . "<br />" . 
				'Departure City and Airport: ' . $_POST['departure'] . "<br />" . 
				'Preferred departure time from home: ' . $_POST['home_departure_time'] . "<br />" . 
				$field[$fieldname]['location_departure_time'] .': ' . $_POST['location_departure_time'] . "<br />" . 
				'Airplane seating preferrence: ' . $_POST['airline_sitting'] . "<br />" . 
				'Special Request: ' . nl2br($_POST['travel_notes']);
				
		$subject 		= 'TCO15 Travel Form of ' . $_POST['handle'];
		$email_receiver = array('jford@appirio.com');
		$headers[] 		= 'From: notification@topcoder.com <notification@topcoder.com>';
		$headers[] 		= 'Bcc: jamesmarquez@gmail.com';

		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		$sent = wp_mail( $email_receiver, $subject, $message, $headers );
		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
			
		if ( $sent ) {
			// - gmail to IFTTT
			unset($headers);
			$message = $_POST['handle'] . "|||" .
				$_POST['first_name'] . "|||" .
				$_POST['middle_name'] . "|||" .
				$_POST['surname'] . "|||" .
				$_POST['street'] . "|||" . 
				$_POST['city'] . "|||" . 
				$_POST['state_province'] . "|||" . 
				$_POST['postal_code'] . "|||" . 
				$_POST['country'] . "|||" . 
				$_POST['mobile_phone'] . "|||" . 
				$_POST['email_address'] . "|||" . 
				$_POST['emergency_name'] . "|||" . 
				$_POST['emergency_contact'] . "|||" . 
				$_POST['relationship'] . "|||" . 
				$_POST['gender']. "|||" . 
				$_POST['date_of_birth'] . "|||" . 
				$_POST['passport_number'] . "|||" . 
				$_POST['passport_expiration_date'] . "|||" . 
				$_POST['country_of_issue'] . "|||" . 
				$_POST['allergies'] . "|||" . 
				$_POST['meals'] . "|||" . 
				$_POST['special_assistance'] . "|||" . 
				$_POST['handle_phonetic'] . "|||" . 
				$_POST['name_phonetic'] . "|||" . 
				$_POST['departure'] . "|||" . 
				$_POST['home_departure_time'] . "|||" . 
				$_POST['location_departure_time'] . "|||" . 
				$_POST['airline_sitting'] . "|||" . 
				nl2br($_POST['travel_notes']) . "|||".
				$_POST['event_you_are_attending'];
			$subject 		= 'IFTTT TCO15 Travel Form';
			$email_receiver = array('jamesmarquez@gmail.com');
			$headers[] 		= 'From: notification@topcoder.com <notification@topcoder.com>';
	
			add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			$sent1 = wp_mail( $email_receiver, $subject, $message, $headers );
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
			// --- end
			
			
			// send to user
			unset($headers);
			$message 		= "<p>Thank you for submitting your travel form for the TCO15 onsite event.</p>
							   <p>Now that we have all your details, your form will be sent to Atlas Travel Agency to find you the perfect flight. Jessie will be sending you the found flight literary as soon as possible.  You will have to respond within 24 hours or we'll have to look for another flight. If in the event you do not get back to us <strong>within 24 hours</strong> and the cost of the flight goes up, you will be responsible for the additional fee.</p>
							   <p>If you forgot any details on your travel form or are flying with a guest and forgot to include them, please send Jessie an email as soon as possible.</p>
							   <p>Thank you!</p>
							   <p>Jessie Ford can be reached at: <a href=\"mailto:jford@appirio.com\">jford@appirio.com</a></p>";
			$subject 		= 'TCO15 Travel Form';
			$email_receiver = array($_POST['email_address']);
			$headers[] 		= 'From: notification@topcoder.com <notification@topcoder.com>';
	
			add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			$sent2 = wp_mail( $email_receiver, $subject, $message, $headers );
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
			
			
			$message = 'Your travel form has been sent to <a href="mailto:jford@appirio.com">jford@appirio.com</a>. If you have further question, kindly email her.';
			$message_alert = 'success';
		} else {
			$message = "Something went wrong, please try again.";
			$message_alert = 'danger';
		}
	}
	
?>

<main>
	
	<div class="container">
		    
		<div class="article">
			
			<h2 class="post-title"><?php the_title(); ?></h2>
			
			<?php if ( isset($message) ) : ?>
			<div class="alert alert-<?php echo $message_alert; ?>" role="alert"><?php echo $message; ?></div>
			<?php endif; ?>
			
			<form id="frmTravel" class="form-horizontal" role="form" method="post">

				<table class="table">
					<thead>
						<tr>
							<th>Name: (this will be the name your airplane ticket is booked)</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php $fieldname = 'handle'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'first_name'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'middle_name'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'surname'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
							</td>
						</tr>
					</tbody>
				</table>
				
				
				
				<table class="table">
					<thead>
						<tr>
							<th>Address:</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php $fieldname = 'street'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'city'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'state_province'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'postal_code'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'country'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
														
				<table class="table">
					<thead>
						<tr>
							<th>Contact Information:</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php $fieldname = 'mobile_number'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'email_address'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="table">
					<thead>
						<tr>
							<th>Emergency Contact:</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php $fieldname = 'emergency_name'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'emergency_contact'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'relationship'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="table">
					<thead>
						<tr>
							<th>Personal Information:</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php $fieldname = 'gender'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<label class="radio-inline">																	
											<input type="radio" id="travel_gender_male" name="gender" value="Male"<?php if ($field[$fieldname]['value']=='' || $field[$fieldname]['value']=='Male') : ?> checked="checked"<?php endif; ?>>
											Male
										</label>
										<label class="radio-inline">
											<input type="radio" id="travel_gender_female" name="gender" value="Female"<?php if ($field[$fieldname]['value']=='Female') : ?> checked="checked"<?php endif; ?>>
											Female
										</label>
									</div>
								</div>
								
								<?php $fieldname = 'date_of_birth'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'passport_number'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'passport_expiration_date'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'country_of_issue'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'allergies'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'meals'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'special_assistance'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'handle_phonetic'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								
								<?php $fieldname = 'name_phonetic'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="table">
					<thead>
						<tr>
							<th>Travel Information:</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php $fieldname = 'event_you_are_attending'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<label class="radio-inline">																	
											<input type="radio" id="travel_indianapolis" name="<?php echo $fieldname; ?>" value="Indianapolis"<?php if ($field[$fieldname]['value']=='' || $field[$fieldname]['value']=='Indianapolis') : ?> checked="checked"<?php endif; ?>>
											Indianapolis
										</label>
										<label class="radio-inline">
											<input type="radio" id="travel_gender_female" name="<?php echo $fieldname; ?>" value="Indonesia"<?php if ($field[$fieldname]['value']=='Indonesia') : ?> checked="checked"<?php endif; ?>>
											Indonesia
										</label>
									</div>
								</div>
								
								<?php $fieldname = 'departure'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'home_departure_time'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'location_departure_time'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'airline_sitting'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" value="<?php echo $field[$fieldname]['value']; ?>" required="required">
									</div>
								</div>
								
								<?php $fieldname = 'travel_notes'; ?>
								<div class="form-group">
									<label for="travel_<?php echo $fieldname; ?>" class="col-sm-4 control-label"><?php echo $field[$fieldname]['label']; ?></label>
									<div class="col-sm-8">
										<textarea id="travel_<?php echo $fieldname; ?>" name="<?php echo $fieldname; ?>" required="required" class="form-control" rows="9"><?php echo $field[$fieldname]['value']; ?></textarea>
									</div>
								</div>														
							</td>
						</tr>
					</tbody>
				</table>
				
				<hr>
				<div class="text-right"><button type="submit" class="btn btn-primary">Submit Travel Form</button></div>
				
				<input type="hidden" name="action" value="travel-form">
				
			</form>
		</div>
            
	</div><!-- .container -->
</main>

<?php get_footer(); ?>