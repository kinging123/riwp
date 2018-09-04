<?php
$query = isset( $riwp_query ) ? $riwp_query : $wp_query;
?>

<div class="container-fluid" id="riwp_container">
	<?php
	if ( $riwp_display_filters ) {
		include 'memorial-filter-controls.php';
	}
	?>
	<div class="row" id="riwp_memorials_container">
	<?php
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
		?>
		<p><?php esc_html_e( 'Sorry, no memorials were found.', 'riwp' ); ?></p>
	<?php endif; ?>
	</div>
</div>
