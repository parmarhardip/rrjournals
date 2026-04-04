<?php

// Register Custom Post Type
function hr_dev_register_post_types() {

	$labels = array(
		'name'                  => _x( 'Books', 'Post Type General Name', 'rrjournals' ),
		'singular_name'         => _x( 'Book', 'Post Type Singular Name', 'rrjournals' ),
		);
	$args = array(
		'label'                 => __( 'Books', 'rrjournals' ),
		'description'           => __( 'Books Description', 'rrjournals' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'revisions','custom-fields' ),		
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
        'capability_type'       => 'page',
        'menu_icon'         => 'dashicons-book',
	);
    register_post_type( 'books-download', $args );
   
   
}
add_action( 'init', 'hr_dev_register_post_types' );