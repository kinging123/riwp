<div class="row riwp-filter-memorials">
	<div class="col-sm-6">
		<form action="" method="get" class="riwp-search-memorials">
			<input type="search" name="riwp_search_memorials" id="riwp_search_memorials"
				placeholder="<?php esc_html_e( 'Search for memorials by name...', 'riwp' ); ?>"
				<?php
				if ( isset( $riwp_search_by ) ) {
					echo ' value="' . htmlspecialchars( $riwp_search_by ) . '"';}
				?>
				>
			<input type="submit" value="<?php esc_html_e( 'Search', 'riwp' ); ?>">
		</form>
	</div>
	<div class="col-sm-6 text-right">
		<form action="" method="get" class="riwp-sort-memorials">
			<label for="riwp_sort_memorials"><?php esc_html_e( 'Sort by:', 'riwp' ); ?></label>
			<select name="riwp_sort_memorials" id="riwp_sort_memorials">
				<option value="soon" 
				<?php
				if ( 'soon' === $riwp_sort_by ) {
					echo 'selected';}
				?>
				><?php esc_html_e( 'Soon-to-be Yahrzeit', 'riwp' ); ?></option>
				<option value="recent" 
				<?php
				if ( 'recent' === $riwp_sort_by ) {
					echo 'selected';}
				?>
				><?php esc_html_e( 'Recently Passed', 'riwp' ); ?></option>
				<option value="name" 
				<?php
				if ( 'name' === $riwp_sort_by ) {
					echo 'selected';}
				?>
				><?php esc_html_e( 'By Name (Alphabetically)', 'riwp' ); ?></option>
			</select>
			<input type="submit" value="<?php esc_html_e( 'Sort', 'riwp' ); ?>">
		</form>
	</div>
</div>
