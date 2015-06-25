<?php

	// if form submitted
	if ( isset($_POST['action']) && $_POST['action']=='member-info' ) {
		$error = '';
		
		// check if there is a handle
		$handle = trim($_POST['member_handle']);
			
		if ( is_array($_POST['track']) && count($_POST['track'])>0 ) {
			
			// get the member's page ID
			$memberID = 0;
			$args = array (
					'post_type' 	 => 'membersform',
					'posts_per_page' => 1,
					'name' 		 => $handle
			);
			$member = new WP_Query ( $args );
			
			if ($member->have_posts ()) {
				while ( $member->have_posts () ) :
					$member->the_post();
					$memberID = get_the_ID();
				endwhile;
			}
			
			wp_reset_query();
			
			if ( $memberID==0 ) { // create the member page
				$user = get_user_by( 'slug', 'quesks' );
				
				$member_post = array(
					'post_title' 	=> $handle,
					'post_content' 	=> '',
					'post_status' 	=> 'publish',
					'post_author' 	=> $user->ID,
					'post_type' 	=> 'membersform'
				);
				$memberID = wp_insert_post($member_post);
			}

			
			//  uploaded and insert as custom field
			if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$upload_overrides 	= array( 'test_form' => false );
			
			// high res photo
			if ( isset($_FILES['photo']) ) {
				$uploadedPreview			= $_FILES['photo'];
				$ext 						= pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
				$uploadedPreview['name'] 	= $handle . "." . $ext;
				
				$movePreviewFile	= wp_handle_upload( $uploadedPreview, $upload_overrides );
				
				if ( ! isset($movePreviewFile['error']) ) {
					$filePreview	= $movePreviewFile['file'];
					$wp_filetype 	= wp_check_filetype(basename($filePreview), null);
					$wp_upload_dir 	= wp_upload_dir();				
					$attachPreview 	= array(
						'guid' 				=> $wp_upload_dir['url'] . '/' . basename($filePreview), 
						'post_mime_type' 	=> $wp_filetype['type'],
						'post_title'		=> preg_replace('/\.[^.]+$/', '', basename($filePreview)),
						'post_content'		=> '',
						'post_status' 		=> 'inherit'
					);
					$attachPreviewID = wp_insert_attachment( $attachPreview, $filePreview, $memberID );
					
					$attachPreviewData = wp_generate_attachment_metadata( $attachPreviewID, $filePreview );
					wp_update_attachment_metadata( $attachPreviewID, $attachPreviewData );	
			
					delete_post_meta($memberID, 'member_image');
					update_post_meta($memberID, 'member_image', $attachPreviewID);
				}
			}
			
			// visa or passport
			if ( isset($_FILES['identification_card']) ) {
				$uploadedPreview			= $_FILES['identification_card'];
				$ext 						= pathinfo($_FILES['identification_card']['name'], PATHINFO_EXTENSION);
				$uploadedPreview['name'] 	= $handle . "-visa-passport-id." . $ext;
				
				$movePreviewFile	= wp_handle_upload( $uploadedPreview, $upload_overrides );
				
				if ( ! isset($movePreviewFile['error']) ) {
					$filePreview	= $movePreviewFile['file'];
					$wp_filetype 	= wp_check_filetype(basename($filePreview), null);
					$wp_upload_dir 	= wp_upload_dir();				
					$attachPreview 	= array(
						'guid' 				=> $wp_upload_dir['url'] . '/' . basename($filePreview), 
						'post_mime_type' 	=> $wp_filetype['type'],
						'post_title'		=> preg_replace('/\.[^.]+$/', '', basename($filePreview)),
						'post_content'		=> '',
						'post_status' 		=> 'inherit'
					);
					$attachPreviewID = wp_insert_attachment( $attachPreview, $filePreview, $memberID );
					
					$attachPreviewData = wp_generate_attachment_metadata( $attachPreviewID, $filePreview );
					wp_update_attachment_metadata( $attachPreviewID, $attachPreviewData );	
					
					delete_post_meta($memberID, 'travel_document_image');
					update_post_meta($memberID, 'travel_document_image', $attachPreviewID);
					
				}
			}		
			
			// save custom fields
			update_post_meta($memberID, 'name', $_POST['member_name']);			
			update_post_meta($memberID, 'email', $_POST['member_email']);
			update_post_meta($memberID, 'country', $_POST['country']);
			
			// delete existing track then add new one
			delete_post_meta($memberID, 'track');
			$strTrack = 'a:'.count($_POST['track']) .':{';
			foreach( $_POST['track'] as $key=>$value ) {
				$strTrack .= 'i:'.$key.';s:'.strlen($value).':"'.$value.'";';
			}
			$strTrack .= '}';
			add_post_meta($memberID, 'track', $strTrack);
			
			update_post_meta($memberID, 'confirmed_attendance', isset($_POST['confirm_attendance']) ? true : false);
			update_post_meta($memberID, 'confirmed_travel_documents', isset($_POST['confirm_documents']) ? true : false);
			update_post_meta($memberID, 'legal_age', isset($_POST['legal_age']) ? true : false);
			
			
			// send email
			/*
			$subject 		= 'TCO15 Member Form Confirmation';				
			$email_page 	= get_page_by_path( 'member-form/email-confirmation-template' );				
			$message 		= apply_filters('the_content', $email_page->post_content);
			$email_receiver = $_POST['member_email'];
			$headers 		= 'From: Jessie Ford <'.get_option('email_addr_to_receive_mail').'>' . "\r\n";
	
			add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			$sent = wp_mail( $email_receiver, $subject, $message, $headers );
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
			*/
			
			$message = 'Your information has been successfully sent!';
			
		} else {
			$error = 'Please select your track';	
		}
		
	}
	
	get_header();
?>
<main>
	
	<div class="container">
		    
		<div class="article">
			
			<h2 class="post-title"><?php the_title(); ?></h2>
					
			<?php 
				if ( have_posts () ) {
					while ( have_posts () ) {
						the_post();
						the_content(); 
					}
				}
			?>
			<p>&nbsp;</p>
			<hr />
		
		
			<?php if ( isset($message) && $message!='' ) : ?>
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Success:</strong><br />
				<?php echo $message; ?>
			</div>
			<?php endif; ?>
			
			
			<?php if ( isset($error) && $error!='' ) : ?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Error:</strong><br />
				<?php echo $error; ?>
			</div>
			<?php endif; ?>
			
			
		
			<form id="form_member" class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">												
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Handle</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="member_handle" id="member_handle" value="" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="member_name" id="member_name" value="" required>
					</div>
				</div>								
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Email</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="member_email" id="member_email" value="" required>
					</div>
				</div>								
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Country</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="country" id="member_country" value="" required>
					</div>
				</div>								
				
				<hr />

				<div class="form-group">
					<label class="col-sm-4 control-label">
						Track<br />
						<em>If you are competing in more than one track, please note both here.</em>
					</label>
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-6">
								<div class="checkbox">
									<label>
										<input type="checkbox" value="Algorithm" class="track" name="track[]">
										Algorithm
									</label>
								</div>								
								<div class="checkbox">
									<label>
										<input type="checkbox" value="Development" class="track" name="track[]">
										Development
									</label>
								</div>								
								<div class="checkbox">
									<label>
										<input type="checkbox" value="Information Architecture" class="track" name="track[]">
										Information Architecture
									</label>
								</div>								
								<div class="checkbox">
									<label>
										<input type="checkbox" value="Marathon" class="track" name="track[]">
										Marathon
									</label>
								</div>								
							</div>
							<div class="col-sm-6">
								<div class="checkbox">
									<label>
										<input type="checkbox" value="UI Design" class="track" name="track[]">
										UI Design
									</label>
								</div>								
								<div class="checkbox">
									<label>
										<input type="checkbox" value="Prototype" class="track" name="track[]">
										Prototype
									</label>
								</div>					
								<div class="checkbox">
									<label>
										<input type="checkbox" value="Trip Winner" class="track" name="track[]">
										Trip Winner
									</label>
								</div>								
							</div>
						</div>									
					</div>
				</div>	
				
				<hr />			

				<div class="form-group">
					<label class="col-sm-4 control-label">Please confirm the following</label>
					<div class="col-sm-8">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="confirm_attendance" id="confirm_attendance" required> 
								I can confirm my attendance to the 2015 Topcoder Open.
							</label>
						</div>
					</div>
				</div>							
											
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="confirm_documents" id="confirm_documents" required> 
								I confirm that I have the proper travel documents in order to travel (passport and/or visa).
							</label>
						</div>
					</div>
				</div>							
				
				<hr />
											
				<div class="form-group">
					<label class="col-sm-4 control-label">
						Please upload your visa and/or passport if required to travel to the USA. 
					</label>
					<div class="col-sm-8">
						<input type="file" name="identification_card" id="member_identification_card" accept="image/*" required />
						<p class="help-block">
							Your flight will not be booked until we have this one file. 
							If  you are located in the USA, please upload a copy of your driver's license or passport									
						</p>
						<div id="member_identification_card_placeholder"></div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label">High resolution photo for event material</label>
					<div class="col-sm-8">
						<input type="file" name="photo" id="member_photo" accept="image/*" required />
						<div id="member_photo_placeholder"></div>
					</div>
				</div>
				
				<hr />

				<div class="form-group">
					<label class="col-sm-4 control-label">Will you be over 21 years of age at the 2015 Topcoder Open?</label>
					<div class="col-sm-8">
						<label class="radio-inline">
							<input type="radio" name="legal_age" value="Yes" checked> 
							Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="legal_age" value="No">
							No
						</label>									
					</div>
				</div>					
				
				<hr />
				
				<p>
					If you have any questions please feel free to 
					<a href="mailto:jford@appirio.com">email Jessie D'Amato Ford</a>. 
					You can also view <a href="http://tco15.topcoder.com/finalist-faqs/" target="_blank">FAQs here</a>.
				</p>
				
				<p class="text-center"><button type="submit" class="btn btn-primary">Save Info</button></p>	
				
				<input type="hidden" name="action" value="member-info" />
			</form>
			
			<hr />
			<p><a href="http://goo.gl/forms/uAej4Wn1jH" target="_blank"><em><strong>Please fill out this questionnaire so we can feature you on the TCO website.</strong></em></a></p>
			
		</div>
					
	</div><!-- .container -->
</main>				
	
<?php get_footer(); ?>