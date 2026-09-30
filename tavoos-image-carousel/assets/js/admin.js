/* Tavoos Image Carousel — mobile image picker on the slide edit screen. */
jQuery(function ($) {
	var frame;

	$('#tavoos_ms_mobile_btn').on('click', function (e) {
		e.preventDefault();
		if (!frame) {
			frame = wp.media({
				title: (window.tavoosImageCarouselAdmin && tavoosImageCarouselAdmin.title) || '',
				multiple: false,
				library: { type: 'image' }
			});
			frame.on('select', function () {
				var a = frame.state().get('selection').first().toJSON();
				$('#tavoos_ms_mobile_img').val(a.id);
				$('#tavoos_ms_mobile_prev').empty().append(
					$('<img>', { src: a.url, alt: '' }).css({ maxWidth: '220px', borderRadius: '8px' })
				);
			});
		}
		frame.open();
	});

	$('#tavoos_ms_mobile_del').on('click', function (e) {
		e.preventDefault();
		$('#tavoos_ms_mobile_img').val('');
		$('#tavoos_ms_mobile_prev').empty();
	});
});
