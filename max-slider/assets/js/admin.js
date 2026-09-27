/* Max Slider — mobile image picker on the slide edit screen. */
jQuery(function ($) {
	var frame;

	$('#sp_mobile_btn').on('click', function (e) {
		e.preventDefault();
		if (!frame) {
			frame = wp.media({
				title: (window.maxSliderAdmin && maxSliderAdmin.title) || '',
				multiple: false,
				library: { type: 'image' }
			});
			frame.on('select', function () {
				var a = frame.state().get('selection').first().toJSON();
				$('#sp_mobile_img').val(a.id);
				$('#sp_mobile_prev').empty().append(
					$('<img>', { src: a.url, alt: '' }).css({ maxWidth: '220px', borderRadius: '8px' })
				);
			});
		}
		frame.open();
	});

	$('#sp_mobile_del').on('click', function (e) {
		e.preventDefault();
		$('#sp_mobile_img').val('');
		$('#sp_mobile_prev').empty();
	});
});
