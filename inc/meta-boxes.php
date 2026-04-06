<?php
/**
 * Custom Meta Boxes - CFS Replacement
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
 * Register custom meta boxes with conditional loading.
 */
function rr_register_meta_boxes() {
	// Editorial Board Meta Box - for board-member pages only
	$editorial_post_types = array( 'page' );
	foreach ( $editorial_post_types as $post_type ) {
		add_meta_box(
			'rr_editorial_meta_box',
			__( 'Editorial Information', 'twentyseventeen' ),
			'rr_editorial_meta_box_callback',
			$post_type,
			'normal',
			'high'
		);
	}

	// Journal Reviewers Meta Box - for journal-reviewers pages only
	$reviewer_post_types = array( 'page' );
	foreach ( $reviewer_post_types as $post_type ) {
		add_meta_box(
			'rr_reviewers_meta_box',
			__( 'Journal Reviewers Information', 'twentyseventeen' ),
			'rr_reviewers_meta_box_callback',
			$post_type,
			'normal',
			'high'
		);
	}

	// Academic Paper Meta Box - matches CFS "Issue content page" rules: rr_issue, rr_sp_paper_list, rr_cp_post
	// Additional types added for extended functionality: post, rr_special_issue, rr_submited_paper
	$academic_post_types = array( 'rr_issue', 'rr_sp_paper_list', 'rr_cp_post', 'post', 'rr_special_issue', 'rr_submited_paper' );
	foreach ( $academic_post_types as $post_type ) {
		add_meta_box(
			'rr_academic_paper_meta_box',
			__( 'Academic Paper Information', 'twentyseventeen' ),
			'rr_academic_paper_meta_box_callback',
			$post_type,
			'normal',
			'high'
		);
	}

	// Book Information Meta Box - for HR development content
	$book_post_types = array( 'books-download','hr_em', 'page' );
	foreach ( $book_post_types as $post_type ) {
		add_meta_box(
			'rr_book_meta_box',
			__( 'Book Information', 'twentyseventeen' ),
			'rr_book_meta_box_callback',
			$post_type,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'rr_register_meta_boxes' );

/**
 * JSON Storage Helper Functions for Complex Repeater Data
 */

/**
 * Save complex array data as JSON in post meta
 */
function rr_save_meta_array( $post_id, $meta_key, $data ) {
	if ( empty( $data ) ) {
		delete_post_meta( $post_id, $meta_key );
		return;
	}
	update_post_meta( $post_id, $meta_key, json_encode( $data, JSON_UNESCAPED_UNICODE ) );
}

/**
 * Retrieve complex array data from JSON post meta
 */
function rr_get_meta_array( $post_id, $meta_key ) {
	$json = get_post_meta( $post_id, $meta_key, true );
	if ( empty( $json ) ) {
		return array();
	}
	$decoded = json_decode( $json, true );
	return is_array( $decoded ) ? $decoded : array();
}

/**
 * Get single field from meta array (replaces CFS()->get() calls)
 */
function rr_get_field( $field_name, $post_id = null ) {
	if ( null === $post_id ) {
		global $post;
		$post_id = $post ? $post->ID : 0;
	}

	if ( ! $post_id ) {
		return null;
	}

	// Try getting as simple meta first
	$value = get_post_meta( $post_id, $field_name, true );

	// If empty, try getting as array data
	if ( empty( $value ) ) {
		$array_data = rr_get_meta_array( $post_id, $field_name );
		return ! empty( $array_data ) ? $array_data : null;
	}

	// Try to decode as JSON if it looks like JSON
	if ( is_string( $value ) && ( '{' === substr( $value, 0, 1 ) || '[' === substr( $value, 0, 1 ) ) ) {
		$decoded = json_decode( $value, true );
		return is_array( $decoded ) ? $decoded : $value;
	}

	// Handle file fields - convert attachment ID to URL
	if ( rr_is_file_field( $field_name ) && is_numeric( $value ) ) {
		$file_url = wp_get_attachment_url( $value );
		return $file_url ? $file_url : $value;
	}

	return $value;
}

/**
 * Check if a field is a file field that should return URLs instead of IDs
 */
function rr_is_file_field( $field_name ) {
	$file_fields = array(
		'ice_pdf_upload',
		'hrbd_cover_page_image',
		'hrbd_download',
	);

	return in_array( $field_name, $file_fields, true );
}

/**
 * Get raw field value (returns attachment ID for file fields)
 * Use this when you need the actual stored value (e.g., for file size calculations)
 */
function rr_get_field_raw( $field_name, $post_id = null ) {
	if ( null === $post_id ) {
		global $post;
		$post_id = $post ? $post->ID : 0;
	}

	if ( ! $post_id ) {
		return null;
	}

	// Get raw meta value without any processing
	$value = get_post_meta( $post_id, $field_name, true );

	// If empty, try getting as array data
	if ( empty( $value ) ) {
		$array_data = rr_get_meta_array( $post_id, $field_name );
		return ! empty( $array_data ) ? $array_data : null;
	}

	// Try to decode JSON if it looks like JSON
	if ( is_string( $value ) && ( '{' === substr( $value, 0, 1 ) || '[' === substr( $value, 0, 1 ) ) ) {
		$decoded = json_decode( $value, true );
		return is_array( $decoded ) ? $decoded : $value;
	}

	return $value;
}

/**
 * Save Meta Box Data
 */
function rr_save_meta_box_data( $post_id ) {
	// Check if nonce is valid
	if ( ! isset( $_POST['rr_meta_nonce'] ) || ! wp_verify_nonce( $_POST['rr_meta_nonce'], 'rr_save_meta_data' ) ) {
		return;
	}

	// Check if user has permission to edit this post
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Skip for autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Save Editorial Board Members (complex nested data)
	if ( isset( $_POST['editorial_board_members'] ) ) {
		$board_members = array();
		foreach ( $_POST['editorial_board_members'] as $member ) {
			if ( ! empty( $member['ebm_name'] ) ) {
				$clean_member = array(
					'ebm_name' => sanitize_text_field( $member['ebm_name'] ),
					'ebm_email' => sanitize_email( $member['ebm_email'] ),
					'ebm_education_degree' => sanitize_text_field( $member['ebm_education_degree'] ),
					'ebm_affiliation_institute' => sanitize_text_field( $member['ebm_affiliation_institute'] ),
					'ebm_role' => sanitize_text_field( $member['ebm_role'] ),
					'ebm_web_profiles' => array()
				);

				// Process web profiles
				if ( isset( $member['ebm_web_profiles'] ) ) {
					foreach ( $member['ebm_web_profiles'] as $profile ) {
						$clean_profile = array();
						foreach ( $profile as $type => $data ) {
							$clean_profile[ $type ] = array(
								'url' => esc_url_raw( $data['url'] ),
								'text' => sanitize_text_field( $data['text'] ),
								'target' => sanitize_text_field( $data['target'] )
							);
						}
						$clean_member['ebm_web_profiles'][] = $clean_profile;
					}
				}

				$board_members[] = $clean_member;
			}
		}
		rr_save_meta_array( $post_id, 'editorial_board_members', $board_members );
	}

	// Save Authors Data (complex nested structure)
	if ( isset( $_POST['icp_authors_names'] ) && is_array( $_POST['icp_authors_names'] ) ) {
		$authors = array();
		foreach ( $_POST['icp_authors_names'] as $author ) {
			if ( ! empty( $author['icp_author_name'] ) ) {
				$clean_author = array(
					'icp_author_name' => sanitize_text_field( $author['icp_author_name'] ),
					'icp_author_email' => sanitize_email( $author['icp_author_email'] ?? '' ),
					'ice_author_about' => sanitize_textarea_field( $author['ice_author_about'] ?? '' )
				);
				$authors[] = $clean_author;
			}
		}
		rr_save_meta_array( $post_id, 'icp_authors_names', $authors );
	}

	// Save Academic Paper Data (simple arrays)
	$academic_arrays = array(
		'icp_abstract', 'icp_keywords', 'icp_references',
		'icp_citation_mla', 'icp_citation_apa', 'icp_citation_chicago',
		'icp_citation_harvard', 'icp_citation_vancouver'
	);

	foreach ( $academic_arrays as $field_array ) {
		if ( isset( $_POST[ $field_array ] ) ) {
			$clean_data = array_map( 'sanitize_text_field', $_POST[ $field_array ] );
			$clean_data = array_filter( $clean_data ); // Remove empty values
			rr_save_meta_array( $post_id, $field_array, $clean_data );
		}
	}

	// Save simple text fields
	$simple_fields = array(
		// Academic paper fields
		'icp_atricle_number', 'icp_year_and_month', 'icp_page_number', 'ice_published_online',
		'icp_doi', 'icp_abstract_content', 'ice_keywords', 'ice_pdf_upload', 'ice_google_drive_pdf_link',
		'ice_paper_category', 'ice_subject',
		// Citation format fields
		'ice_mla', 'ice_apa', 'ice_chicago', 'ice_harvard', 'ice_vancouver',
		// Book fields
		'hrbd_title_of_the_book', 'hrbd_authors_name', 'hrbd_isbn_number',
		'hrbd_cover_page_image', 'hrbd_download', 'hrbd_buy_now', 'hrbd_choose_button',
		// Legacy fields (if any)
		'icp_title_of_research_paper', 'icp_doi_number', 'icp_paper_url', 'icp_paper_pdf'
	);

	foreach ( $simple_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
}
add_action( 'save_post', 'rr_save_meta_box_data' );

/**
 * Enqueue Admin Scripts and Styles for Meta Boxes
 */
function rr_admin_meta_box_scripts( $hook ) {
	// Only load on post edit screens
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}

	// Enqueue WordPress media library
	wp_enqueue_media();

	// Enqueue our custom admin script
	wp_enqueue_script(
		'rr-admin-meta-boxes',
		get_template_directory_uri() . '/assets/js/admin-meta-boxes.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);

	// Enqueue our custom admin styles
	wp_enqueue_style(
		'rr-admin-meta-boxes',
		get_template_directory_uri() . '/assets/css/admin-meta-boxes.css',
		array(),
		'1.0.0'
	);
}
add_action( 'admin_enqueue_scripts', 'rr_admin_meta_box_scripts' );

/**
 * AJAX Handler for Board Member Template
 */
function rr_get_board_member_template() {
	// Check nonce for security
	if ( ! wp_verify_nonce( $_POST['nonce'], 'rr_save_meta_data' ) ) {
		wp_die( 'Security check failed' );
	}

	$index = intval( $_POST['index'] );

	// Generate the template HTML
	ob_start();
	rr_render_single_board_member_template( $index );
	$template_html = ob_get_clean();

	// Return success response
	wp_send_json_success( $template_html );
}
add_action( 'wp_ajax_rr_get_board_member_template', 'rr_get_board_member_template' );

/**
 * Board Member Template for JavaScript
 */
function rr_render_board_member_template() {
	?>
	<script type="text/html" id="ebm-template">
		<div class="rr-repeater-row rr-complex-row" data-index="{{INDEX}}">
			<div class="rr-row-header">
				<h5><?php _e( 'Board Member', 'twentyseventeen' ); ?> #{{MEMBER_NUMBER}}</h5>
				<button type="button" class="button rr-remove-row"><?php _e( 'Remove', 'twentyseventeen' ); ?></button>
			</div>

			<div class="rr-row-content">
				<div class="rr-field-row">
					<label><?php _e( 'Name:', 'twentyseventeen' ); ?></label>
					<input type="text" name="editorial_board_members[{{INDEX}}][ebm_name]" value="" />
				</div>

				<div class="rr-field-row">
					<label><?php _e( 'Email:', 'twentyseventeen' ); ?></label>
					<input type="email" name="editorial_board_members[{{INDEX}}][ebm_email]" value="" />
				</div>

				<div class="rr-field-row">
					<label><?php _e( 'Education/Degree:', 'twentyseventeen' ); ?></label>
					<input type="text" name="editorial_board_members[{{INDEX}}][ebm_education_degree]" value="" />
				</div>

				<div class="rr-field-row">
					<label><?php _e( 'Affiliation/Institute:', 'twentyseventeen' ); ?></label>
					<input type="text" name="editorial_board_members[{{INDEX}}][ebm_affiliation_institute]" value="" />
				</div>

				<div class="rr-field-row">
					<label><?php _e( 'Role:', 'twentyseventeen' ); ?></label>
					<input type="text" name="editorial_board_members[{{INDEX}}][ebm_role]" value="" />
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
						?>
						<div class="rr-profile-row">
							<label><?php echo $profile_label; ?>:</label>
							<input type="url"
								   name="editorial_board_members[{{INDEX}}][ebm_web_profiles][0][<?php echo $profile_key; ?>][url]"
								   value="" placeholder="<?php _e( 'URL', 'twentyseventeen' ); ?>" />
							<input type="text"
								   name="editorial_board_members[{{INDEX}}][ebm_web_profiles][0][<?php echo $profile_key; ?>][text]"
								   value="" placeholder="<?php _e( 'Link Text', 'twentyseventeen' ); ?>" />
							<select name="editorial_board_members[{{INDEX}}][ebm_web_profiles][0][<?php echo $profile_key; ?>][target]">
								<option value="_blank"><?php _e( 'New Window', 'twentyseventeen' ); ?></option>
								<option value="none"><?php _e( 'Same Window', 'twentyseventeen' ); ?></option>
							</select>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</script>
	<?php
}
add_action( 'admin_footer', 'rr_render_board_member_template' );

/**
 * Conditional Meta Box Display Functions
 */

/**
 * Check if editorial meta box should display (board-member pages only).
 */
function rr_should_show_editorial_metabox( $post ) {
	// Show only for editorial board pages (matches CFS rules)
	if ( 'page' === $post->post_type ) {
		$page_template = get_page_template_slug( $post->ID );

		// CFS rule: page + page-board-member.php template
		if ( 'page-board-member.php' === $page_template ) {
			return true;
		}

		// Fallback: Check by page slug
		$page_slug = $post->post_name;
		$editorial_slugs = array( 'board-member', 'editorial-board', 'jebm' );

		return in_array( $page_slug, $editorial_slugs, true );
	}

	return false;
}

/**
 * Check if reviewers meta box should display (journal-reviewers pages only).
 */
function rr_should_show_reviewers_metabox( $post ) {
	// Show only for journal reviewers pages (matches CFS rules)
	if ( 'page' === $post->post_type ) {
		$page_template = get_page_template_slug( $post->ID );

		// CFS rule: page + page-journal-reviewers.php template
		if ( 'page-journal-reviewers.php' === $page_template ) {
			return true;
		}

		// Fallback: Check by page slug
		$page_slug = $post->post_name;
		$reviewer_slugs = array( 'journal-reviewers', 'reviewers' );

		return in_array( $page_slug, $reviewer_slugs, true );
	}

	return false;
}

/**
 * Check if academic paper meta box should display.
 */
function rr_should_show_academic_metabox( $post ) {
	// Show for academic content post types (matches CFS rules + extensions)
	$academic_types = array( 'rr_issue', 'rr_sp_paper_list', 'rr_cp_post', 'post', 'rr_special_issue', 'rr_submited_paper' );
	return in_array( $post->post_type, $academic_types, true );
}

/**
 * Check if book meta box should display.
 */
function rr_should_show_book_metabox( $post ) {
	// Show for HR development posts
	if ( 'books-download' === $post->post_type ) {
		return true;
	}

	// Show for specific pages related to books/downloads
	if ( 'page' === $post->post_type ) {
		$page_template = get_page_template_slug( $post->ID );
		$book_templates = array( 'page-book-download.php' );

		$page_slug = $post->post_name;
		$book_slugs = array( 'hr-development', 'book-download', 'books', 'downloads' );

		return in_array( $page_template, $book_templates, true ) ||
			   in_array( $page_slug, $book_slugs, true );
	}

	return false;
}