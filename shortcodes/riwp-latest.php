<?php
$riwp_sort_by = 'latest';
$riwp_posts_per_page = 12;
$riwp_display_filters = false;
include RIWP_PATH . 'loop/memorials.php';

if ( ! isset( $riwp_query ) || ! isset( $riwp_posts_per_page ) || $riwp_query->post_count >= $riwp_posts_per_page ) {
?>
<div class="riwp-load-more">
	<button id="riwp-load-more-btn"><?php _e( 'Load More...', 'riwp' ); ?></button>
</div>
<?php
}
