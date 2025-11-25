jQuery(function($) {

	var show_sidemenu = function(){
		if ($('body').hasClass('l-sidemenu-active')) return false;
		$('body').toggleClass('l-sidemenu-active');

		var t = $(window).scrollTop();
		if (t <= 300) {
			$('#site_wrap').css({
				position: 'fixed'
			});
		} else {
			$('#site_wrap').css({
				position: 'fixed',
				top: t * -1
			});
		}
	};

	var hide_sidemenu = function(){
		if (!$('body').hasClass('l-sidemenu-active')) return false;
		$('body').removeClass('l-sidemenu-active');

		var t = parseInt($('#site_wrap').css('top')) * -1;
		$('#site_wrap').removeAttr('style');
		$(window).scrollTop(t);
	};

	$('#js-sidemenu-button').click(function() {
		show_sidemenu();
		return false;
	});

	$('#js-sidemenu-close-button').click(function() {
		hide_sidemenu();
		return false;
	});

	$(window).on('resize orientationchange', function() {
		if ($('body').hasClass('l-sidemenu-active') && $(window).width() <= 1200) {
			hide_sidemenu();
		}
	});

});