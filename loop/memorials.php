<?php
global $wp_query;


if ( ! isset( $riwp_sort_by ) ) {
	$riwp_sort_by = isset( $_GET['riwp_sort_memorials'] ) ? $_GET['riwp_sort_memorials'] : 'soon';
}

if ( ! isset( $riwp_search_by ) ) {
	$riwp_search_by = $_GET['riwp_search_memorials'];
}

if ( ! isset( $riwp_posts_per_page ) ) {
	$riwp_posts_per_page = isset( $_GET['riwp_riwp_posts_per_page'] ) ? $_GET['riwp_riwp_posts_per_page'] : RIWP_POSTS_PER_PAGE;
}

if ( ! isset( $riwp_pagination_page ) ) {
	$riwp_pagination_page = isset( $_GET['riwp_pagination_page'] ) ? $_GET['riwp_pagination_page'] : 1;
}

if ( ! isset( $riwp_display_filters ) ) {
	$riwp_display_filters = isset( $_GET['riwp_display_filters'] ) ? $_GET['riwp_display_filters'] : true;
}


if ( isset( $riwp_search_by ) && $riwp_search_by ) {
	$riwp_query = new WP_Query(
		array(
			'post_type' => 'memorial',
			'posts_per_page' => $riwp_posts_per_page,
			'paged' => $riwp_pagination_page,
			'order' => 'DESC',
			'orderby' => 'post_date',
			's' => $riwp_search_by,
		)
	);
} elseif ( 'soon' === $riwp_sort_by ) {
	$total_count = wp_count_posts( 'memorial' )->publish;
	$all_posts = array();

	global $riwp_anniv_list;
	$today = date( 'd-m-Y' );
	$anniv_today = riwp_get_anniv_day( $today );
	$anniv_pos = array_search( $anniv_today, $riwp_anniv_list );
	while ( count( $all_posts ) < ($riwp_posts_per_page * $riwp_pagination_page) && count( $all_posts ) < $total_count ) {
		if ( $anniv_pos >= count( $riwp_anniv_list ) ) {
			$anniv_pos = 0;
		}
		$temp_query = new WP_Query(
			array(
				'post_type' => 'memorial',
				'nopaging' => true,
				'meta_query' => array(
					array(
						'key' => 'riwp_hebrew_anniv',
						'value' => $riwp_anniv_list[ $anniv_pos ],
					),
				),
			)
		);
		$all_posts = array_merge( $all_posts, $temp_query->posts );
		$anniv_pos++;
		if ( $riwp_anniv_list[ $anniv_pos ] === $anniv_today ) {
			break;
		}
	}

	$riwp_query = new WP_Query();
	$riwp_query->posts = array_slice( $all_posts, (($riwp_pagination_page - 1) * $riwp_posts_per_page), $riwp_posts_per_page );
	$riwp_query->post_count = count( $riwp_query->posts );
} elseif ( 'recent' === $riwp_sort_by ) {
	$riwp_query = new WP_Query(
		array(
			'post_type' => 'memorial',
			'posts_per_page' => $riwp_posts_per_page,
			'paged' => $riwp_pagination_page,
			'order' => 'DESC',
			'orderby' => 'post_date',
		)
	);
} elseif ( 'name' === $riwp_sort_by ) {
	$riwp_query = new WP_Query(
		array(
			'post_type' => 'memorial',
			'posts_per_page' => $riwp_posts_per_page,
			'paged' => $riwp_pagination_page,
			'order' => 'ASC',
			'orderby' => 'title',
		)
	);
} else {
	$riwp_query = new WP_Query(
		array(
			'post_type' => 'memorial',
			'posts_per_page' => $riwp_posts_per_page,
			'paged' => $riwp_pagination_page,
		)
	);
}

if ( isset( $riwp_loop_type ) ) {
	include RIWP_PATH . "templates/archive-memorial-{$riwp_loop_type}.php";
} else {
	include RIWP_PATH . 'templates/archive-memorial.php';
}
