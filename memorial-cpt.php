<?php


// Memorial Custom Post Type
function riwp_register_memorial() {

	$labels = array(
		'name'                  => _x( 'Memorials', 'Post Type General Name', 'riwp' ),
		'singular_name'         => _x( 'Memorial', 'Post Type Singular Name', 'riwp' ),
		'menu_name'             => __( 'Memorials', 'riwp' ),
		'name_admin_bar'        => __( 'Memorial', 'riwp' ),
		'archives'              => __( 'Memorial Archives', 'riwp' ),
		'attributes'            => __( 'Memorial Attributes', 'riwp' ),
		'parent_item_colon'     => __( 'Parent Memorial:', 'riwp' ),
		'all_items'             => __( 'All Memorials', 'riwp' ),
		'add_new_item'          => __( 'Add New Memorial', 'riwp' ),
		'add_new'               => __( 'Add New', 'riwp' ),
		'new_item'              => __( 'New Memorial', 'riwp' ),
		'edit_item'             => __( 'Edit Memorial', 'riwp' ),
		'update_item'           => __( 'Update Memorial', 'riwp' ),
		'view_item'             => __( 'View Memorial', 'riwp' ),
		'view_items'            => __( 'View Memorials', 'riwp' ),
		'search_items'          => __( 'Search Memorial', 'riwp' ),
		'not_found'             => __( 'Not found', 'riwp' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'riwp' ),
		'featured_image'        => __( 'Person\'s Photo', 'riwp' ),
		'set_featured_image'    => __( 'Set photo', 'riwp' ),
		'remove_featured_image' => __( 'Remove photo', 'riwp' ),
		'use_featured_image'    => __( 'Use as photo', 'riwp' ),
		'insert_into_item'      => __( 'Insert into item', 'riwp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'riwp' ),
		'items_list'            => __( 'Memorials list', 'riwp' ),
		'items_list_navigation' => __( 'Memorials list navigation', 'riwp' ),
		'filter_items_list'     => __( 'Filter items list', 'riwp' ),
	);
	$args = array(
		'label'                 => __( 'Memorial', 'riwp' ),
		'description'           => __( 'Memorials', 'riwp' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-awards',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'memorial', $args );

}
add_action( 'init', 'riwp_register_memorial', 0 );


function riwp_style_memorial_titles( $title ) {
	global $id, $post;
	if ( $id && $post && 'memorial' === $post->post_type ) {
		$words = explode( ' ', $title );
		return join( ' ', array_slice( $words, 0, 2 ) ) . ' ' . __( 'R.I.P.', 'riwp' );
	}
	return $title;
}
add_filter( 'the_title', 'riwp_style_memorial_titles' );


function riwp_style_memorial_dates( $date ) {
	global $id, $post;
	if ( $id && $post && 'memorial' === $post->post_type ) {
		$date = get_the_date( 'd-m-Y', $id );
		$hebrew_date = riwp_date_to_jewish( $date, CAL_JEWISH_ADD_GERESHAYIM );
		return $hebrew_date;
	}
	return $date;
}
add_filter( 'the_date', 'riwp_style_memorial_dates' );

// function riwp_style_memorial_excerpt( $excerpt ) {
// 	global $id, $post;
// 	if ( $id && $post && 'memorial' === $post->post_type ) {
		
// 	}
// 	return $excerpt;
// }
// add_filter( 'the_excerpt', 'riwp_style_memorial_excerpts' );

function riwp_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'riwp_excerpt_length', 999 );


function check_values( $post_id, $post_after, $post_before ) {
	if ( 'memorial' === $post_after->post_type && 'publish' === $post_after->post_status ) {
		$date = get_the_date( 'd-m-Y', $post_id );
		$anniv_day = riwp_get_anniv_day( $date );
		update_post_meta( $post_id, 'riwp_hebrew_anniv', $anniv_day );
	}
}

add_action( 'post_updated', 'check_values', 10, 3 );


add_filter( 'manage_memorial_posts_columns', 'memorial_add_anniv_column' );
add_filter( 'manage_memorial_posts_custom_column', 'memorial_manage_anniv_column', 10, 2 );

function memorial_add_anniv_column( $columns ) {
	$columns['anniv'] = __( 'Hebrew Yahrzeit', 'riwp' );
	return $columns;
}

function memorial_manage_anniv_column( $column_name, $post_id ) {
	if ( 'anniv' === $column_name ) {
		echo get_post_meta( $post_id, 'riwp_hebrew_anniv', true );
		return true;
	}
	return $column_name;
}


