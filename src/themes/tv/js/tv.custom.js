/**
 * @Project TAN DUNG RASPBERRY TV
 * @Author PHAN TAN DUNG <phantandung92@gmail.com>
 * @Copyright (C) 2018 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sunday, August 5, 2018 9:53:00 AM GMT+07:00
 */

$(document).ready(function() {
	$('#tv-search').click(function(e) {
		e.preventDefault();
		$('body').addClass('open-search');
		$('#tv-search-input').select().focus();
	});

	$('#tv-search-clear').click(function(e) {
		e.preventDefault();
		$('#tv-search-input').val('');
		$('#tv-search-clear').parent().hide();
	});

	$('#tv-search-input').keyup(function() {
		if (trim($(this).val()) == '') {
			$('#tv-search-clear').parent().hide();
		} else {
			$('#tv-search-clear').parent().show();
		}
	});

	$('#tv-search-form').submit(function(e) {
		if (trim($('#tv-search-input').val()) == '') {
			$('#tv-search-input').focus();
			e.preventDefault();
		}
	});

	$('#tv-search-submit').click(function(e) {
		e.preventDefault();
		$('#tv-search-form').submit();
	});

	$(document).on('click', function(e) {
		if (!$(e.target).closest('#tv-search-form-wrapper').length && !$(e.target).parent().is('#tv-search')) {
			$('body').removeClass('open-search');
		}
	});
});
