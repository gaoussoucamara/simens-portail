$(document).ready(function() {
	var container = $('ul.grid');
	
	$('ul.filter > li:first').addClass('active');
	
	container.imagesLoaded(function() {
		container.isotope({ filter: '*' });
	});
	
	$('ul.filter a').click(function() {
		var selector = ($(this).attr('data-filter') == "*") ? "*" : 'li[data-cat*=' + $(this).attr('data-filter') + ']';
		container.isotope({ filter: selector });
		$('ul.filter > li.active').removeClass('active');
		$(this).parent().addClass('active');
		return false;
	});
	
	$(window).smartresize(function() {
		var width = $(window).width();
		var cols = 4;
		if ((width > 0) && (width < 400)) { cols = 1; }
		else if ((width >= 400) && (width < 600)) { cols = 2; }
		else if ((width >= 600) && (width < 800)) { cols = 3; }
		
		container.isotope({
			resizable: false,
			masonry: { columnWidth: container.width() / cols }
		});
	}).smartresize();

	/* MORE */
	$('a.button.more').click(function() {
		$.get('items.html', function(data) {
			var items = $(data);
			items.imagesLoaded(function () {
				container.isotope('insert', items);
				$('.lightbox', items).fancybox({
					'padding'			: 0,
					'overlayShow'	 	: true,
					'overlayColor'   	: '#000',
					'overlayOpacity' 	: '0.8',
					'transitionIn'	 	: 'elastic',
					'transitionOut'	 	: 'elastic',
					'speedIn'			: '100',
					'speedOut'			: '100'
				});
			});
		});
		return false;
	});
});