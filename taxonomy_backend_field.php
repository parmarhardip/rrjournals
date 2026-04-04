<?php
/**
 * Security: Prevent direct access
 */
defined( 'ABSPATH' ) || exit;

function rr_cp_category_save_form_fields($term_id) {
    $cp_cate_custom_date_name 		 = 'custom-date-field';
    $cp_cate_institute_detail_name 	 = 'institute-detail-field';
    $cp_cate_institute_down_url_name = 'institute-download-url-field';
    $cp_cate_institute_url_name 	 = 'institute-url-field';
    if ( isset( $_POST ) ) {
        $cp_cate_custom_date_value 			= isset( $_POST[$cp_cate_custom_date_name] ) ? stripslashes_deep($_POST[$cp_cate_custom_date_name])  : '';        $cp_cate_institute_detail_value 	= isset( $_POST[$cp_cate_institute_detail_name] ) ? stripslashes_deep($_POST[$cp_cate_institute_detail_name] ): '';        $cp_cate_institute_down_url_value 	= isset( $_POST[$cp_cate_institute_down_url_name] ) ? stripslashes_deep($_POST[$cp_cate_institute_down_url_name]) : '';        $cp_cate_institute_url_value 		= isset( $_POST[$cp_cate_institute_url_name] ) ? stripslashes_deep($_POST[$cp_cate_institute_url_name]) : '';        // This is an associative array with keys and values:
        $term_metas = get_option("rr_cp_cate_{$term_id}_metas");
        if (!is_array($term_metas)) {
            $term_metas = Array();
        }
        // Save the meta value
        $term_metas[$cp_cate_custom_date_name]  		= $cp_cate_custom_date_value;
        $term_metas[$cp_cate_institute_detail_name] 	= $cp_cate_institute_detail_value;
        $term_metas[$cp_cate_institute_down_url_name] 	= $cp_cate_institute_down_url_value;
        $term_metas[$cp_cate_institute_url_name] 		= $cp_cate_institute_url_value;
        update_option( "rr_cp_cate_{$term_id}_metas", $term_metas );
    }
}
add_action('edited_rr_cp_cat', 'rr_cp_category_save_form_fields', 10, 2);
add_action('created_rr_cp_cat', 'rr_cp_category_save_form_fields', 10, 2);
function rr_cp_category_add_form_fields($term_obj) {
    // Read in the order from the options db
    $term_id = $term_obj->term_id;
    $term_metas = get_option("rr_cp_cate_{$term_id}_metas");
	
	$custom_date_field 		  = isset($term_metas['custom-date-field']) ? stripslashes_deep($term_metas['custom-date-field']) : '';	$institute_detail_field   = isset($term_metas['institute-detail-field']) ? stripslashes_deep($term_metas['institute-detail-field']) : '';	$institute_down_url_field = isset($term_metas['institute-download-url-field']) ? stripslashes_deep($term_metas['institute-download-url-field']) : '';	$institute_url_field 	  = isset($term_metas['institute-url-field']) ? stripslashes_deep($term_metas['institute-url-field']) : '';    
    
	?>
	<div class="form-field">
		<label for="custom-date-field"><?php _e('Custom Date text', 'rrjournals'); ?></label>
		<input type="text" id="custom-date-field" name="custom-date-field" value="<?php echo esc_attr( $custom_date_field ); ?>"/>
		<p><?php echo esc_html('Enter the custom date in free textbox.'); ?></p>
	</div>
	<div class="form-field">
		<label for="institute-detail-field"><?php _e('Institute Information', 'rrjournals'); ?></label>
		<input type="text" id="institute-detail-field" name="institute-detail-field" value="<?php echo esc_attr( $institute_detail_field ); ?>"/>
		<p><?php echo esc_html('Enter the Institute Information in free textbox.'); ?></p>
	</div>
	<div class="form-field">
		<label for="institute-download-url-field"><?php _e('Institute Download OR URL Title', 'rrjournals'); ?></label>
		<input type="text" id="institute-download-url-field" name="institute-download-url-field" value="<?php echo esc_attr( $institute_down_url_field ); ?>"/>
		<p><?php echo esc_html('Enter the Institute URL in free textbox.'); ?></p>
	</div>
	<div class="form-field">
		<label for="institute-url-field"><?php _e('Institute URL', 'rrjournals'); ?></label>
		<input type="text" id="institute-url-field" name="institute-url-field" value="<?php echo esc_attr( $institute_url_field ); ?>"/>
		<p><?php echo esc_html('Enter the Institute URL in free textbox.'); ?></p>
	</div>
	<?php 
}
add_action('rr_cp_cat_add_form_fields','rr_cp_category_add_form_fields');
function rr_cp_category_edit_form_fields($term_obj) {
    // Read in the order from the options db
    $term_id = $term_obj->term_id;
    $term_metas = get_option("rr_cp_cate_{$term_id}_metas");
	
	$custom_date_field 		  = isset($term_metas['custom-date-field']) ? stripslashes_deep( $term_metas['custom-date-field']) : '';	$institute_detail_field   = isset($term_metas['institute-detail-field']) ? stripslashes_deep($term_metas['institute-detail-field']) : '';	$institute_down_url_field = isset($term_metas['institute-download-url-field']) ? stripslashes_deep($term_metas['institute-download-url-field']) : '';	$institute_url_field 	  = isset($term_metas['institute-url-field']) ? stripslashes_deep($term_metas['institute-url-field']) : '';    
    
	?>
	<tr class="form-field">
		<th valign="top" scope="row">
			<label for="custom-date-field"><?php _e('Custom Date text', 'rrjournals'); ?></label>
		</th>
		<td>
			<input type="text" id="custom-date-field" name="custom-date-field" value="<?php echo esc_attr( $custom_date_field ); ?>"/>
		</td>
	</tr>
	<tr class="form-field">
		<th valign="top" scope="row">
			<label for="institute-detail-field"><?php _e('Institute Information', 'rrjournals'); ?></label>
		</th>
		<td>
			<input type="text" id="institute-detail-field" name="institute-detail-field" value="<?php echo esc_attr( $institute_detail_field ); ?>"/>
		</td>
	</tr>
	<tr class="form-field">
		<th valign="top" scope="row">
			<label for="institute-download-url-field"><?php _e('Institute Download OR URL Title', 'rrjournals'); ?></label>
		</th>
		<td>
			<input type="text" id="institute-download-url-field" name="institute-download-url-field" value="<?php echo esc_attr( $institute_down_url_field ); ?>"/>
		</td>
	</tr>
	<tr class="form-field">
		<th valign="top" scope="row">
			<label for="institute-url-field"><?php _e('Institute URL', 'rrjournals'); ?></label>
		</th>
		<td>
			<input type="text" id="institute-url-field" name="institute-url-field" value="<?php echo esc_attr( $institute_url_field ); ?>"/>
		</td>
	</tr>
	<?php 
}
add_action('rr_cp_cat_edit_form_fields','rr_cp_category_edit_form_fields');