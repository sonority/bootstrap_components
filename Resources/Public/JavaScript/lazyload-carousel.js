// Lazyload carousel-images
jQuery(document).ready(function () {
	var cHeight = 0;
	var activeItem = $('.carousel-lazyload .item.active').find('img');
	var src = activeItem.data('src');
	if (typeof src !== 'undefined' && src !== '') {
		activeItem.attr('src', src);
		activeItem.data('src', '');
	}
	$('.carousel-lazyload').on('slide.bs.carousel', function (e) {
		var $nextImage = null;
		$activeItem = $('.item.active', this);
		if (e.direction === 'left') {
			$nextImage = $activeItem.next('.item').find('img');
		} else {
			if ($activeItem.index() === 0) {
				$nextImage = $('img:last', $activeItem.parent());
			} else {
				$nextImage = $activeItem.prev('.item').find('img');
			}
		}
		// Prevents the slide decrease in height
		if (cHeight === 0) {
			cHeight = $activeItem.height();
			$activeItem.height(cHeight);
		}
		$activeItem.next('.item').height(cHeight);
		// Prevents loading the image if it is already loaded
		var src = $nextImage.data('src');
		if (typeof src !== 'undefined' && src !== '') {
			$nextImage.attr('src', src);
			$nextImage.data('src', '');
		}
	});

	// Prevents the slide decrease in height
	var elementHeight = 0;
	$('.carousel-2 .item').each(function () {
		$activeItem = $('.item.active', this);
		var thisHeight = $(this).height();
		if (thisHeight > elementHeight) {
			elementHeight = thisHeight;
		}
	});
	$('.carousel-2 .item').each(function () {
		$(this).height(elementHeight);
	});
});
