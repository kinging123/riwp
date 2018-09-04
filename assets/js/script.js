jQuery(function($) {
	// Scroll to section if there are queries
	var allQueryVars = [
		'riwp_search_memorials',
		'riwp_riwp_posts_per_page',
		'riwp_pagination_page',
		'riwp_display_filters',
		'riwp_sort_memorials'
	];
	if (allQueryVars.filter(function (queryVar) { return window.location.href.indexOf(queryVar) > -1}).length > 0) {
		// Basically, if the URL has one of the parameters
		location.hash = '#riwp_container';
	}
	
	// Load More Button
	$loadMoreBtn = $('#riwp-load-more-btn');
	$loadMoreBtn.click(function(e) {
		var amount = RIWP.posts_per_page;
		loadMoreMemorials(amount);
	});

	var currentPage = 1;
	function loadMoreMemorials(amount) {
		$loadMoreBtn.prop('disabled', true)
		$.get(RIWP.ajax_url, {
			action: 'riwp_load_more_memorials',
			posts_per_page: amount,
			search_by: $('#riwp_search_memorials').val(),
			sort_by: $('#riwp_sort_memorials option:selected').val(),
			paged: currentPage+1
		}).always(function(response) {
			$loadMoreBtn.prop('disabled', false)
		}).success(function(response, code, headers) {
			$('#riwp_memorials_container').append(response);
			if (headers.getResponseHeader('last')) {
				$loadMoreBtn.hide();
			}
			currentPage++;
		}).error(function(error) {
			if (error.responseJSON && error.responseJSON.data == 'empty') {
				$loadMoreBtn.hide();
			} else {
				console.error(error);
				alert(RIWP.error_msg + ' ' + error.responseText);
			}
		});
	}
});