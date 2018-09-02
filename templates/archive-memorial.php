<?php
$query = isset( $riwp_query ) ? $riwp_query : $wp_query;
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<form action="" method="get">
				<input type="search" name="riwp_search_memorials" id="riwp_search_memorials"
					placeholder="<?php esc_html_e( 'Search for memorials by name...', 'riwp' ); ?>"
					<?php
					if ( isset( $_GET['riwp_search_memorials'] ) ) {
						echo ' value="' . htmlspecialchars( $_GET['riwp_search_memorials'] ) . '"';}
					?>
					>
				<input type="submit" value="<?php esc_html_e( 'Search', 'riwp' ); ?>">
			</form>
		</div>
		<div class="col-sm-4 col-sm-offset-4">
			<form action="" method="get">
				<select name="riwp_sort_memorials" id="riwp_sort_memorials">
					<option value="soon" 
					<?php
					if ( 'soon' === $_GET['riwp_sort_memorials'] ) {
						echo 'selected';}
					?>
					><?php esc_html_e( 'Soon-to-be Yahrzeit', 'riwp' ); ?></option>
					<option value="recent" 
					<?php
					if ( 'recent' === $_GET['riwp_sort_memorials'] ) {
						echo 'selected';}
					?>
					><?php esc_html_e( 'Recently Passed', 'riwp' ); ?></option>
					<option value="name" 
					<?php
					if ( 'name' === $_GET['riwp_sort_memorials'] ) {
						echo 'selected';}
					?>
					><?php esc_html_e( 'By Name (Alphabetically)', 'riwp' ); ?></option>
				</select>
				<input type="submit" value="<?php esc_html_e( 'Sort', 'riwp' ); ?>">
			</form>
		</div>
	</div>
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
