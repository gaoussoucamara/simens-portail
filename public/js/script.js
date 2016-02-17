$(document).ready(function() {
	/* HEADER BAR */
	var timer;
	$('#header-bar').mouseenter(function() {
		if (timer) {
			clearTimeout(timer);
			timer = null
		}
		timer = setTimeout(function() {
			$('#header-bar-content').slideDown('fast');
			$('#header-bar-handle').slideUp('fast');
		}, 100);
	}).mouseleave(function(e) {
		clearTimeout(timer);
		timer = null
		
		var pageY = e.pageY || e.clientY;
		if (pageY > 0) {
			$('#header-bar-content').stop().slideUp('fast');
			$('#header-bar-handle').slideDown('fast');
		};
	});

	/* MAIN MENU */
	$('#main-menu > li:has(ul.sub-menu)').addClass('parent');
	$('ul.sub-menu > li:has(ul.sub-menu) > a').addClass('parent');

	$('#menu-toggle').click(function() {
		$('#main-menu').slideToggle(300);
		return false;
	});

	$(window).resize(function() {
		if ($(window).width() > 700) {
			$('#main-menu').removeAttr('style');
		}
	});

	/* LIGHTBOX */
	$('.lightbox').fancybox({
		'padding'			: 0,
		'overlayShow'	 	: true,
		'overlayColor'   	: '#000',
		'overlayOpacity' 	: '0.8',
		'transitionIn'	 	: 'elastic',
		'transitionOut'	 	: 'elastic',
		'speedIn'			: '100',
		'speedOut'			: '100'
	});

	/* ACCORDION */
	$('div.accordion > div.content').hide();
	$('div.accordion').each(function() {
		var first = $('> a.switch.opened:first', this);
		$('> a.switch.opened', this).removeClass('opened');
		first.addClass('opened').next().show();
	});
	
	$('div.accordion > a.switch').click(function() {
		$(this).parent().find('.switch').removeClass('opened').next().slideUp('fast');
		if ($(this).next().is(':hidden')) {
			$(this).toggleClass('opened').next().slideDown('fast');
		}
		return false;
	});

	/* TOGGLE */
	$('div.toggle > div.content').hide();
	$('div.toggle > a.switch.opened').next().show();

	$('div.toggle > a.switch').click(function() {
		$(this).toggleClass('opened').next().slideToggle('fast');
		return false;
	});

	/* TABS */
	$('ul.tabs-nav > li:first-child').addClass('active');
	$('div.tab-content').hide();
	$('div.tab-content:first-child').show();
	
	$('ul.tabs-nav a').click(function() {
		var nav = $(this).parent().parent('ul.tabs-nav');
		if (!$(this).parent().hasClass('active')) {
			$('> li', nav).removeClass('active');
			$(this).parent().addClass('active');

			var target = $(this).attr('href');
			var container = $('div.tabs-container').has(target);
			$('> .tab-content', container).hide();
			$(target, container).fadeIn(); 
		}
		return false;
	});
	
	/* NOTIFICATION */
	$('.notification').click(function() {
		$(this).fadeOut();
		return false;
	});

	/* TOOLTIP */
	$('.tooltip').hover(function() {
		var title = $(this).attr('title');
		$(this).data('tooltip', title).removeAttr('title');
		$('<span class="tooltip-content"><span class="tooltip-triangle"></span></span>').text(title).appendTo('body').fadeIn('fast');
	}, function() {
		$(this).attr('title', $(this).data('tooltip'));
		$('.tooltip-content').remove();
	}).mousemove(function(e) {
		var mousex = e.pageX + 20;
		var mousey = e.pageY + 10;
		$('.tooltip-content').css({ top: mousey, left: mousex });
	});
});