<?php
$query = isset( $riwp_query ) ? $riwp_query : $wp_query;

if ( $query->post_count < $_GET['posts_per_page'] ) {
	header( 'Last: true' );
}

if ( $query->have_posts() ) :
	while ( $query->have_posts() ) :
		$query->the_post();
		?>
		<div class="memorial-candle-wrap col-md-2 col-sm-2">
			<?php include 'single-memorial.php'; ?>
		</div>
	<?php
	endwhile;
	wp_reset_postdata();
else :
	wp_send_json_error( 'empty', 400 );
endif; ?>
