jQuery(document).ready(function () {
	// Prevents the carousel-slides decreasing in height to avoid pagejumps
	$('.carousel').each(function () {
		if ($(this).hasClass('image-carousel')) {
			$(this).find('.item.active img').load(function () {
				$(this).parent().parent().height($(this).height());
			});
		} else {
			var thisHeight = 0;
			var elementHeight = 0;
			$(this).find('.item').each(function () {
				thisHeight = $(this).height();
				if (thisHeight > elementHeight) {
					elementHeight = thisHeight;
				}
			});
			$(this).find('.carousel-inner').height(elementHeight);
		}
	});
});
