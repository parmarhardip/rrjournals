<?php
add_action( 'admin_menu', 'rudr_metabox_for_select2' );
add_action( 'save_post', 'rudr_save_metaboxdata', 10, 2 );
 
/*
 * Add a metabox
 * I hope you're familiar with add_meta_box() function, so, nothing new for you here
 */
function rudr_metabox_for_select2() {
	add_meta_box( 'rudr_select2', 'Special Issue Paper list', 'rudr_display_select2_metabox', 'rr_special_issue', 'normal', 'default' );
}
 
/*
 * Display the fields inside it
 */
function rudr_display_select2_metabox( $post_object ) {
 
	// do not forget about WP Nonces for security purposes
 
	// I decided to write all the metabox html into a variable and then echo it at the end
	$html = '';
 
	// always array because we have added [] to our <select> name attribute	
	$appended_posts = get_post_meta( $post_object->ID, 'rr_sp_select2_paper',true );	
 
	/*
	 * Select Posts with AJAX search
	 */	
	$args = array( 'post_type' => 'rr_sp_paper_list', 'posts_per_page' => -1, 'post_status' => 'publish'); 
	$paper_listings = get_posts( $args );
	$paper_posts = get_post_meta( $post_object->ID, 'rr_sp_select2_paper',true ); 
	
	$html .= '<p><label for="rr_sp_select2_paper">Paper List:</label><br /><select id="rr_sp_select2_paper" name="rr_sp_select2_paper[]" multiple="multiple" style="width:99%;max-width:25em;">';
 
	if( $paper_listings ) {
		foreach( $paper_listings as $paper_post ) {
			$title = get_the_title( $paper_post->ID );
			// if the post title is too long, truncate it and add "..." at the end
			$title = ( mb_strlen( $title ) > 50 ) ? mb_substr( $title, 0, 49 ) . '...' : $title;
			if( !empty( $paper_posts ) && in_array( $paper_post->ID, $paper_posts ) ) {
				$html .=  '<option value="' . esc_attr($paper_post->ID) . '" selected="selected">' . esc_html($title) . '</option>';			
			} else {
				$html .=  '<option value="' . esc_attr($paper_post->ID) . '">' . esc_html($title) . '</option>';
			}
		}
	}
	$html .= '</select></p>';
	if( !empty( $paper_posts ) ) {
		$number = 1;
		$html .='<div><label for="rr_sp_select2_paper_list">Paper Listing:</label>';
		$html .='<table>';
		foreach( $paper_posts as $paper_post_id ) {		
			$html .='<tr><td style="border: 1px solid;">'.esc_html($number).') '.esc_html(get_the_title( $paper_post_id )).'</td></tr>';
			$number++;
		}	
		$html .='</table></div>';
	}
	
	echo $html;
}
 
 
function rudr_save_metaboxdata( $post_id, $post ) {
 
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
 
	// if post type is different from our selected one, do nothing
	if ( $post->post_type == 'rr_special_issue' ) {	
		if( isset( $_POST['rr_sp_select2_paper'] ) )
			update_post_meta( $post_id, 'rr_sp_select2_paper', $_POST['rr_sp_select2_paper'] );
		else
			delete_post_meta( $post_id, 'rr_sp_select2_paper' );
	}
	return $post_id;
}

add_action( 'admin_enqueue_scripts', 'rudr_select2_enqueue' );
function rudr_select2_enqueue(){
 
	wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' );
	wp_enqueue_script( 'select2', get_theme_file_uri( '/assets/js/select2.min.js' ), array(), '1.0', true );
	//wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array('jquery') );
 
	// please create also an empty JS file in your theme directory and include it too
	wp_enqueue_script('rrcustom', get_stylesheet_directory_uri() . '/assets/js/rr_custom.js', array( 'jquery', 'select2' ) ); 
 
}
add_action( 'wp_ajax_rr_special_paper_list', 'rr_special_paper_list_ajax_callback' ); // wp_ajax_{action}
function rr_special_paper_list_ajax_callback(){
 
	// we will pass post IDs and titles to this array
	$return = array();
 
	// you can use WP_Query, query_posts() or get_posts() here - it doesn't matter
	$search_results = new WP_Query( array( 
		's'=> sanitize_text_field($_GET['q']), // the search query
		'post_status' => 'publish', // if you don't want drafts to be returned
		'ignore_sticky_posts' => 1,
		'posts_per_page' => -1, // how much to show at once
		'post_type'=> 'rr_sp_paper_list'
	) );
	if( $search_results->have_posts() ) :
		while( $search_results->have_posts() ) : $search_results->the_post();	
			// shorten the title a little
			$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
			$return[] = array( $search_results->post->ID, $title ); // array( Post ID, Post Title )
		endwhile;
	endif;
	echo json_encode( $return );
	die;
}
?>
