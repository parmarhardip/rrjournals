<?php
/**
 * Meta Box Callback Functions - CFS Replacement
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Editorial Information Meta Box Callback
 */
function rr_editorial_meta_box_callback( $post ) {
	// Check if this meta box should display for this post/page
	if ( ! rr_should_show_editorial_metabox( $post ) ) {
		echo '<p>' . __( 'Editorial information is not applicable for this content type.', 'twentyseventeen' ) . '</p>';
		return;
	}

	// Add nonce for security
	wp_nonce_field( 'rr_save_meta_data', 'rr_meta_nonce' );

	// Get existing data
	$editor_in_chief = rr_get_meta_array( $post->ID, 'editor_in_chief' );
	$editorial_board_members = rr_get_meta_array( $post->ID, 'editorial_board_members' );

	?>
	<div class="rr-meta-box-container">
		<!-- Editor in Chief Section -->
		<div class="rr-field-group">
			<h4><?php _e( 'Editor in Chief', 'twentyseventeen' ); ?></h4>
			<div id="editor-in-chief-fields" class="rr-repeater-fields" data-field-name="editor_in_chief">
				<?php
				if ( ! empty( $editor_in_chief ) ) {
					foreach ( $editor_in_chief as $index => $eic ) {
						?>
						<div class="rr-repeater-row" data-index="<?php echo esc_attr($index); ?>">
							<input type="text" name="editor_in_chief[<?php echo esc_attr($index); ?>][eic_name]"
								   value="<?php echo esc_attr( $eic['eic_name'] ?? '' ); ?>"
								   placeholder="<?php _e( 'Name', 'twentyseventeen' ); ?>" />
							<button type="button" class="button rr-remove-row"><?php _e( 'Remove', 'twentyseventeen' ); ?></button>
						</div>
						<?php
					}
				}
				?>
			</div>
			<button type="button" class="button rr-add-row" data-target="editor-in-chief-fields"
					data-template="eic-template"><?php _e( 'Add Editor in Chief', 'twentyseventeen' ); ?></button>
		</div>

		<!-- Editorial Board Members Section -->
		<div class="rr-field-group">
			<h4><?php _e( 'Editorial Board Members', 'twentyseventeen' ); ?></h4>
			<div id="editorial-board-members-fields" class="rr-repeater-fields" data-field-name="editorial_board_members">
				<?php
				if ( ! empty( $editorial_board_members ) ) {
					foreach ( $editorial_board_members as $index => $ebm ) {
						rr_render_board_member_row( $index, $ebm );
					}
				}
				?>
			</div>
			<button type="button" class="button rr-add-row" data-target="editorial-board-members-fields"
					data-template="ebm-template"><?php _e( 'Add Board Member', 'twentyseventeen' ); ?></button>
		</div>

	</div>

	<!-- Templates for JavaScript -->
	<script type="text/html" id="eic-template">
		<div class="rr-repeater-row" data-index="{{INDEX}}">
			<input type="text" name="editor_in_chief[{{INDEX}}][eic_name]"
				   value="" placeholder="<?php _e( 'Name', 'twentyseventeen' ); ?>" />
			<button type="button" class="button rr-remove-row"><?php _e( 'Remove', 'twentyseventeen' ); ?></button>
		</div>
	</script>

	<?php
}

/**
 * Journal Reviewers Information Meta Box Callback
 */
function rr_reviewers_meta_box_callback( $post ) {
	// Check if this meta box should display for this post/page
	if ( ! rr_should_show_reviewers_metabox( $post ) ) {
		echo '<p>' . __( 'Journal reviewers information is not applicable for this content type.', 'twentyseventeen' ) . '</p>';
		return;
	}

	// Add nonce for security
	wp_nonce_field( 'rr_save_meta_data', 'rr_meta_nonce' );

	// Get existing data
	$journal_reviewers_members = rr_get_meta_array( $post->ID, 'journal_reviewers_members' );

	?>
	<div class="rr-meta-box-container">
		<!-- Journal Reviewers Section -->
		<div class="rr-field-group">
			<h4><?php _e( 'Journal Reviewers', 'twentyseventeen' ); ?></h4>
			<div id="journal-reviewers-fields" class="rr-repeater-fields" data-field-name="journal_reviewers_members">
				<?php
				if ( ! empty( $journal_reviewers_members ) ) {
					foreach ( $journal_reviewers_members as $index => $reviewer ) {
						?>
						<div class="rr-repeater-row" data-index="<?php echo esc_attr($index); ?>">
							<div class="rr-field-row">
								<label><?php _e( 'Name:', 'twentyseventeen' ); ?></label>
								<input type="text" name="journal_reviewers_members[<?php echo esc_attr($index); ?>][rr_jr_name]"
									   value="<?php echo esc_attr( $reviewer['rr_jr_name'] ?? '' ); ?>"
									   placeholder="<?php _e( 'Reviewer Name', 'twentyseventeen' ); ?>" />
							</div>
							<div class="rr-field-row">
								<label><?php _e( 'Designation:', 'twentyseventeen' ); ?></label>
								<input type="text" name="journal_reviewers_members[<?php echo esc_attr($index); ?>][rr_jr_designation]"
									   value="<?php echo esc_attr( $reviewer['rr_jr_designation'] ?? '' ); ?>"
									   placeholder="<?php _e( 'Designation', 'twentyseventeen' ); ?>" />
							</div>
							<div class="rr-field-row">
								<label><?php _e( 'Area of Interest:', 'twentyseventeen' ); ?></label>
								<input type="text" name="journal_reviewers_members[<?php echo esc_attr($index); ?>][rr_jr_area_of_interest]"
									   value="<?php echo esc_attr( $reviewer['rr_jr_area_of_interest'] ?? '' ); ?>"
									   placeholder="<?php _e( 'Area of Interest', 'twentyseventeen' ); ?>" />
							</div>
							<button type="button" class="button rr-remove-row"><?php _e( 'Remove', 'twentyseventeen' ); ?></button>
						</div>
						<?php
					}
				}
				?>
			</div>
			<button type="button" class="button rr-add-row" data-target="journal-reviewers-fields"
					data-template="reviewer-template"><?php _e( 'Add Reviewer', 'twentyseventeen' ); ?></button>
		</div>
	</div>

	<!-- Reviewer Template for JavaScript -->
	<script type="text/html" id="reviewer-template">
		<div class="rr-repeater-row" data-index="{{INDEX}}">
			<div class="rr-field-row">
				<label><?php _e( 'Name:', 'twentyseventeen' ); ?></label>
				<input type="text" name="journal_reviewers_members[{{INDEX}}][rr_jr_name]"
					   value="" placeholder="<?php _e( 'Reviewer Name', 'twentyseventeen' ); ?>" />
			</div>
			<div class="rr-field-row">
				<label><?php _e( 'Designation:', 'twentyseventeen' ); ?></label>
				<input type="text" name="journal_reviewers_members[{{INDEX}}][rr_jr_designation]"
					   value="" placeholder="<?php _e( 'Designation', 'twentyseventeen' ); ?>" />
			</div>
			<div class="rr-field-row">
				<label><?php _e( 'Area of Interest:', 'twentyseventeen' ); ?></label>
				<input type="text" name="journal_reviewers_members[{{INDEX}}][rr_jr_area_of_interest]"
					   value="" placeholder="<?php _e( 'Area of Interest', 'twentyseventeen' ); ?>" />
			</div>
			<button type="button" class="button rr-remove-row"><?php _e( 'Remove', 'twentyseventeen' ); ?></button>
		</div>
	</script>
	<?php
}

/**
 * Render complex board member row with nested web profiles
 */
function rr_render_board_member_row( $index, $ebm ) {
	?>
	<div class="rr-repeater-row rr-complex-row" data-index="<?php echo esc_attr($index); ?>">
		<div class="rr-row-header">
			<h5><?php _e( 'Board Member', 'twentyseventeen' ); ?> #<?php echo esc_html($index + 1); ?></h5>
			<button type="button" class="button rr-remove-row"><?php _e( 'Remove', 'twentyseventeen' ); ?></button>
		</div>

		<div class="rr-row-content">
			<div class="rr-field-row">
				<label><?php _e( 'Name:', 'twentyseventeen' ); ?></label>
				<input type="text" name="editorial_board_members[<?php echo esc_attr($index); ?>][ebm_name]"
					   value="<?php echo esc_attr( $ebm['ebm_name'] ?? '' ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Email:', 'twentyseventeen' ); ?></label>
				<input type="email" name="editorial_board_members[<?php echo esc_attr($index); ?>][ebm_email]"
					   value="<?php echo esc_attr( $ebm['ebm_email'] ?? '' ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Education/Degree:', 'twentyseventeen' ); ?></label>
				<input type="text" name="editorial_board_members[<?php echo esc_attr($index); ?>][ebm_education_degree]"
					   value="<?php echo esc_attr( $ebm['ebm_education_degree'] ?? '' ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Affiliation/Institute:', 'twentyseventeen' ); ?></label>
				<input type="text" name="editorial_board_members[<?php echo esc_attr($index); ?>][ebm_affiliation_institute]"
					   value="<?php echo esc_attr( $ebm['ebm_affiliation_institute'] ?? '' ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Role:', 'twentyseventeen' ); ?></label>
				<input type="text" name="editorial_board_members[<?php echo esc_attr($index); ?>][ebm_role]"
					   value="<?php echo esc_attr( $ebm['ebm_role'] ?? '' ); ?>" />
			</div>

			<!-- Web Profiles Section -->
			<div class="rr-web-profiles">
				<h6><?php _e( 'Web Profiles', 'twentyseventeen' ); ?></h6>
				<?php
				$profiles = array(
					'ebm_wp_institute_profile' => __( 'Institute Profile', 'twentyseventeen' ),
					'ebm_wp_personal_web_blog' => __( 'Personal Web/Blog', 'twentyseventeen' ),
					'ebm_wp_google_scholar' => __( 'Google Scholar', 'twentyseventeen' ),
					'ebm_wp_research_gate' => __( 'Research Gate', 'twentyseventeen' ),
					'ebm_wp_ssrn_id' => __( 'SSRN ID', 'twentyseventeen' ),
					'ebm_wp_orchid_id' => __( 'ORCID ID', 'twentyseventeen' ),
				);

				foreach ( $profiles as $profile_key => $profile_label ) {
					$profile_data = $ebm['ebm_web_profiles'][0][$profile_key] ?? array();
					?>
					<div class="rr-profile-row">
						<label><?php echo esc_html($profile_label); ?>:</label>
						<input type="url"
							   name="editorial_board_members[<?php echo esc_attr($index); ?>][ebm_web_profiles][0][<?php echo esc_attr($profile_key); ?>][url]"
							   value="<?php echo esc_attr( $profile_data['url'] ?? '' ); ?>"
							   placeholder="<?php _e( 'URL', 'twentyseventeen' ); ?>" />
						<input type="text"
							   name="editorial_board_members[<?php echo $index; ?>][ebm_web_profiles][0][<?php echo $profile_key; ?>][text]"
							   value="<?php echo esc_attr( $profile_data['text'] ?? '' ); ?>"
							   placeholder="<?php _e( 'Link Text', 'twentyseventeen' ); ?>" />
						<select name="editorial_board_members[<?php echo $index; ?>][ebm_web_profiles][0][<?php echo $profile_key; ?>][target]">
							<option value="_blank" <?php selected( $profile_data['target'] ?? '_blank', '_blank' ); ?>><?php _e( 'New Window', 'twentyseventeen' ); ?></option>
							<option value="none" <?php selected( $profile_data['target'] ?? '', 'none' ); ?>><?php _e( 'Same Window', 'twentyseventeen' ); ?></option>
						</select>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Academic Paper Information Meta Box Callback
 */
function rr_academic_paper_meta_box_callback( $post ) {
	// Check if this meta box should display for this post
	if ( ! rr_should_show_academic_metabox( $post ) ) {
		echo '<p>' . __( 'Academic paper information is not applicable for this content type.', 'twentyseventeen' ) . '</p>';
		return;
	}

	// Add nonce for security
	wp_nonce_field( 'rr_save_meta_data', 'rr_meta_nonce' );

	// Get existing data
	$academic_fields = array(
		'icp_atricle_number' => get_post_meta( $post->ID, 'icp_atricle_number', true ),
		'icp_year_and_month' => get_post_meta( $post->ID, 'icp_year_and_month', true ),
		'icp_page_number' => get_post_meta( $post->ID, 'icp_page_number', true ),
		'ice_published_online' => get_post_meta( $post->ID, 'ice_published_online', true ),
		'icp_doi' => get_post_meta( $post->ID, 'icp_doi', true ),
		'icp_abstract_content' => get_post_meta( $post->ID, 'icp_abstract_content', true ),
		'ice_keywords' => get_post_meta( $post->ID, 'ice_keywords', true ),
		'ice_paper_category' => get_post_meta( $post->ID, 'ice_paper_category', true ),
		'ice_subject' => get_post_meta( $post->ID, 'ice_subject', true ),
		'ice_pdf_upload' => get_post_meta( $post->ID, 'ice_pdf_upload', true ),
		'ice_google_drive_pdf_link' => get_post_meta( $post->ID, 'ice_google_drive_pdf_link', true ),
	);

	$icp_authors_names = rr_get_meta_array( $post->ID, 'icp_authors_names' );

	// Citation format fields
	$citation_fields = array(
		'ice_mla' => get_post_meta( $post->ID, 'ice_mla', true ),
		'ice_apa' => get_post_meta( $post->ID, 'ice_apa', true ),
		'ice_chicago' => get_post_meta( $post->ID, 'ice_chicago', true ),
		'ice_harvard' => get_post_meta( $post->ID, 'ice_harvard', true ),
		'ice_vancouver' => get_post_meta( $post->ID, 'ice_vancouver', true ),
	);
	?>
	<div class="rr-meta-box-container">
		<!-- Basic Paper Information -->
		<div class="rr-field-group">
			<h4><?php _e( 'Paper Information', 'twentyseventeen' ); ?></h4>

			<div class="rr-field-row">
				<label><?php _e( 'Article Number:', 'twentyseventeen' ); ?></label>
				<input type="text" name="icp_atricle_number" value="<?php echo esc_attr( $academic_fields['icp_atricle_number'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Year and Month:', 'twentyseventeen' ); ?></label>
				<input type="text" name="icp_year_and_month" value="<?php echo esc_attr( $academic_fields['icp_year_and_month'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Page Number:', 'twentyseventeen' ); ?></label>
				<input type="text" name="icp_page_number" value="<?php echo esc_attr( $academic_fields['icp_page_number'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Published Online:', 'twentyseventeen' ); ?></label>
				<input type="text" name="ice_published_online" value="<?php echo esc_attr( $academic_fields['ice_published_online'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'DOI:', 'twentyseventeen' ); ?></label>
				<input type="url" name="icp_doi" value="<?php echo esc_attr( $academic_fields['icp_doi'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Paper Category:', 'twentyseventeen' ); ?></label>
				<input type="text" name="ice_paper_category" value="<?php echo esc_attr( $academic_fields['ice_paper_category'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Subject:', 'twentyseventeen' ); ?></label>
				<input type="text" name="ice_subject" value="<?php echo esc_attr( $academic_fields['ice_subject'] ); ?>" />
			</div>
		</div>

		<!-- Authors Section -->
		<div class="rr-field-group">
			<h4><?php _e( 'Authors', 'twentyseventeen' ); ?></h4>
			<div id="authors-fields" class="rr-repeater-fields" data-field-name="icp_authors_names">
				<?php
				if ( ! empty( $icp_authors_names ) ) {
					foreach ( $icp_authors_names as $index => $author ) {
						?>
						<div class="rr-repeater-row" data-index="<?php echo esc_attr($index); ?>">
							<div class="rr-field-row">
								<label><?php _e( 'Author Name:', 'twentyseventeen' ); ?></label>
								<input type="text" name="icp_authors_names[<?php echo $index; ?>][icp_author_name]"
									   value="<?php echo esc_attr( $author['icp_author_name'] ?? '' ); ?>" />
							</div>
							<div class="rr-field-row">
								<label><?php _e( 'Author Email:', 'twentyseventeen' ); ?></label>
								<input type="email" name="icp_authors_names[<?php echo $index; ?>][icp_author_email]"
									   value="<?php echo esc_attr( $author['icp_author_email'] ?? '' ); ?>" />
							</div>
							<div class="rr-field-row">
								<label><?php _e( 'About Author:', 'twentyseventeen' ); ?></label>
								<textarea name="icp_authors_names[<?php echo $index; ?>][ice_author_about]"><?php echo esc_textarea( $author['ice_author_about'] ?? '' ); ?></textarea>
							</div>
							<button type="button" class="button rr-remove-row"><?php _e( 'Remove Author', 'twentyseventeen' ); ?></button>
						</div>
						<?php
					}
				}
				?>
			</div>
			<button type="button" class="button rr-add-row" data-target="authors-fields"
					data-template="author-template"><?php _e( 'Add Author', 'twentyseventeen' ); ?></button>
		</div>

		<!-- Content Section -->
		<div class="rr-field-group">
			<h4><?php _e( 'Content', 'twentyseventeen' ); ?></h4>

			<div class="rr-field-row rr-wysiwyg">
				<label><?php _e( 'Abstract:', 'twentyseventeen' ); ?></label>
				<?php
				wp_editor(
					$academic_fields['icp_abstract_content'],
					'icp_abstract_content',
					array(
						'textarea_name' => 'icp_abstract_content',
						'media_buttons' => false,
						'textarea_rows' => 10,
						'teeny' => true,
						'quicktags' => true,
						'tinymce' => array(
							'toolbar1' => 'bold,italic,underline,bullist,numlist,link,unlink',
							'toolbar2' => '',
							'toolbar3' => '',
						),
					)
				);
				?>
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Keywords:', 'twentyseventeen' ); ?></label>
				<textarea name="ice_keywords" rows="3"><?php echo esc_textarea( $academic_fields['ice_keywords'] ); ?></textarea>
			</div>
		</div>

		<!-- File Upload Section -->
		<div class="rr-field-group">
			<h4><?php _e( 'Files', 'twentyseventeen' ); ?></h4>

			<div class="rr-field-row">
				<label><?php _e( 'PDF Upload:', 'twentyseventeen' ); ?></label>
				<div class="rr-file-upload">
					<input type="hidden" name="ice_pdf_upload" id="ice_pdf_upload" value="<?php echo esc_attr( $academic_fields['ice_pdf_upload'] ); ?>" />
					<input type="button" class="button rr-upload-file" data-target="ice_pdf_upload" value="<?php _e( 'Choose PDF', 'twentyseventeen' ); ?>" />
					<span class="rr-file-preview">
						<?php if ( $academic_fields['ice_pdf_upload'] ) : ?>
							<?php echo esc_html( basename( $academic_fields['ice_pdf_upload'] ) ); ?>
							<button type="button" class="button rr-remove-file" data-target="ice_pdf_upload"><?php _e( 'Remove', 'twentyseventeen' ); ?></button>
						<?php endif; ?>
					</span>
				</div>
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Google Drive PDF Link:', 'twentyseventeen' ); ?></label>
				<input type="url" name="ice_google_drive_pdf_link" value="<?php echo esc_attr( $academic_fields['ice_google_drive_pdf_link'] ); ?>" />
			</div>
		</div>

		<!-- Citation Formats -->
		<div class="rr-field-group">
			<h4><?php _e( 'Citation Formats', 'twentyseventeen' ); ?></h4>

			<?php foreach ( $citation_fields as $format_key => $format_value ) :
				$format_label = str_replace( array( 'ice_', '_' ), array( '', ' ' ), $format_key );
				$format_label = strtoupper( $format_label );
			?>
				<div class="rr-field-row rr-wysiwyg">
					<label><?php echo esc_html( $format_label ); ?>:</label>
					<?php
					wp_editor(
						$format_value,
						$format_key,
						array(
							'textarea_name' => $format_key,
							'media_buttons' => false,
							'textarea_rows' => 3,
							'teeny' => true,
							'quicktags' => true,
							'tinymce' => array(
								'toolbar1' => 'bold,italic,underline,link,unlink',
								'toolbar2' => '',
								'toolbar3' => '',
							),
						)
					);
					?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<!-- Author Template for JavaScript -->
	<script type="text/html" id="author-template">
		<div class="rr-repeater-row" data-index="{{INDEX}}">
			<div class="rr-field-row">
				<label><?php _e( 'Author Name:', 'twentyseventeen' ); ?></label>
				<input type="text" name="icp_authors_names[{{INDEX}}][icp_author_name]" value="" />
			</div>
			<div class="rr-field-row">
				<label><?php _e( 'Author Email:', 'twentyseventeen' ); ?></label>
				<input type="email" name="icp_authors_names[{{INDEX}}][icp_author_email]" value="" />
			</div>
			<div class="rr-field-row">
				<label><?php _e( 'About Author:', 'twentyseventeen' ); ?></label>
				<textarea name="icp_authors_names[{{INDEX}}][ice_author_about]"></textarea>
			</div>
			<button type="button" class="button rr-remove-row"><?php _e( 'Remove Author', 'twentyseventeen' ); ?></button>
		</div>
	</script>
	<?php
}

/**
 * Book Information Meta Box Callback
 */
function rr_book_meta_box_callback( $post ) {
	// Check if this meta box should display for this post
	if ( ! rr_should_show_book_metabox( $post ) ) {
		echo '<p>' . __( 'Book information is not applicable for this content type.', 'twentyseventeen' ) . '</p>';
		return;
	}

	// Add nonce for security
	wp_nonce_field( 'rr_save_meta_data', 'rr_meta_nonce' );

	// Get existing data
	$book_fields = array(
		'hrbd_title_of_the_book' => get_post_meta( $post->ID, 'hrbd_title_of_the_book', true ),
		'hrbd_authors_name' => get_post_meta( $post->ID, 'hrbd_authors_name', true ),
		'hrbd_isbn_number' => get_post_meta( $post->ID, 'hrbd_isbn_number', true ),
		'hrbd_cover_page_image' => get_post_meta( $post->ID, 'hrbd_cover_page_image', true ),
		'hrbd_download' => get_post_meta( $post->ID, 'hrbd_download', true ),
		'hrbd_buy_now' => get_post_meta( $post->ID, 'hrbd_buy_now', true ),
		'hrbd_choose_button' => get_post_meta( $post->ID, 'hrbd_choose_button', true ),
	);
	?>
	<div class="rr-meta-box-container">
		<div class="rr-field-group">
			<h4><?php _e( 'Book Details', 'twentyseventeen' ); ?></h4>

			<div class="rr-field-row">
				<label><?php _e( 'Title of the Book:', 'twentyseventeen' ); ?></label>
				<input type="text" name="hrbd_title_of_the_book" value="<?php echo esc_attr( $book_fields['hrbd_title_of_the_book'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Authors Name:', 'twentyseventeen' ); ?></label>
				<input type="text" name="hrbd_authors_name" value="<?php echo esc_attr( $book_fields['hrbd_authors_name'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'ISBN Number:', 'twentyseventeen' ); ?></label>
				<input type="text" name="hrbd_isbn_number" value="<?php echo esc_attr( $book_fields['hrbd_isbn_number'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Cover Page Image:', 'twentyseventeen' ); ?></label>
				<div class="rr-file-upload">
					<input type="hidden" name="hrbd_cover_page_image" id="hrbd_cover_page_image" value="<?php echo esc_attr( $book_fields['hrbd_cover_page_image'] ); ?>" />
					<input type="button" class="button rr-upload-file" data-target="hrbd_cover_page_image" value="<?php _e( 'Choose Image', 'twentyseventeen' ); ?>" />
					<span class="rr-file-preview">
						<?php if ( $book_fields['hrbd_cover_page_image'] ) : ?>
							<?php echo esc_html( basename( $book_fields['hrbd_cover_page_image'] ) ); ?>
							<button type="button" class="button rr-remove-file" data-target="hrbd_cover_page_image"><?php _e( 'Remove', 'twentyseventeen' ); ?></button>
						<?php endif; ?>
					</span>
				</div>
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Download File:', 'twentyseventeen' ); ?></label>
				<div class="rr-file-upload">
					<input type="hidden" name="hrbd_download" id="hrbd_download" value="<?php echo esc_attr( $book_fields['hrbd_download'] ); ?>" />
					<input type="button" class="button rr-upload-file" data-target="hrbd_download" value="<?php _e( 'Choose File', 'twentyseventeen' ); ?>" />
					<span class="rr-file-preview">
						<?php if ( $book_fields['hrbd_download'] ) : ?>
							<?php echo esc_html( basename( $book_fields['hrbd_download'] ) ); ?>
							<button type="button" class="button rr-remove-file" data-target="hrbd_download"><?php _e( 'Remove', 'twentyseventeen' ); ?></button>
						<?php endif; ?>
					</span>
				</div>
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Buy Now URL:', 'twentyseventeen' ); ?></label>
				<input type="url" name="hrbd_buy_now" value="<?php echo esc_attr( $book_fields['hrbd_buy_now'] ); ?>" />
			</div>

			<div class="rr-field-row">
				<label><?php _e( 'Choose Button:', 'twentyseventeen' ); ?></label>
				<select name="hrbd_choose_button">
					<option value=""><?php _e( 'Select Option', 'twentyseventeen' ); ?></option>
					<option value="Download" <?php selected( $book_fields['hrbd_choose_button'], 'Download' ); ?>><?php _e( 'Download', 'twentyseventeen' ); ?></option>
					<option value="Buy Now" <?php selected( $book_fields['hrbd_choose_button'], 'Buy Now' ); ?>><?php _e( 'Buy Now', 'twentyseventeen' ); ?></option>
				</select>
			</div>
		</div>
	</div>
	<?php
}