jQuery(function($){

	/**
	 * グローバルナビゲーション モバイル
	 */
	$('#js-menu-button').click(function() {
		if ($('#js-header').width() <= 1200) {
			$(this).toggleClass('is-active');
			$('#js-global-nav').slideToggle(500);
		}
		return false;
	});
	$('#js-global-nav .menu-item-has-children > a span').click(function() {
		if ($('#js-header').width() <= 1200) {
			$(this).toggleClass('is-active');
			$(this).closest('.menu-item-has-children').toggleClass('is-active').find('> .sub-menu').slideToggle(300);
		}
		return false;
	});

	/**
	 * ヘッダー検索
	 */
	$('#js-header #js-search-button').click(function() {
		if ($('#js-header').width() > 1200) {
			$(this).closest('#js-header').toggleClass('is-header-search-active');
		}
		return false;
	});

	/**
	 * メガメニュー
	 */
	var hide_megamenu_timer = {};
	var hide_megamenu_interval = function(menu_id) {
		if (hide_megamenu_timer[menu_id]) {
			clearInterval(hide_megamenu_timer[menu_id]);
			hide_megamenu_timer[menu_id] = null;
		}
		hide_megamenu_timer[menu_id] = setInterval(function() {
			if (!$('#menu-item-' + menu_id).is(':hover') && !$('#p-megamenu--' + menu_id).is(':hover')) {
				clearInterval(hide_megamenu_timer[menu_id]);
				hide_megamenu_timer[menu_id] = null;
				$('#menu-item-' + menu_id + ', #p-megamenu--' + menu_id).removeClass('is-active');
			}
		}, 20);
	};
	$('#js-global-nav .menu-megamenu').hover(
		function(){
			var menu_id = $(this).attr('id').replace('menu-item-', '');
			if (hide_megamenu_timer[menu_id]) {
				clearInterval(hide_megamenu_timer[menu_id]);
				hide_megamenu_timer[menu_id] = null;
			}
			if ($('#js-header').width() > 1200) {
				$(this).addClass('is-active');
				$('#p-megamenu--' + menu_id).addClass('is-active');
			}
		},
		function(){
			var menu_id = $(this).attr('id').replace('menu-item-', '');
			hide_megamenu_interval(menu_id);
		}
	);
	$('#js-header').on('mouseout', '.p-megamenu', function(){
		var menu_id = $(this).attr('id').replace('p-megamenu--', '');
		hide_megamenu_interval(menu_id);
	});

	/**
	 * メガメニューB (type3)
	 */
	$('.p-megamenu--type3 > ul > li > a').hover(
		function(){
			var $li = $(this).closest('li');
			$li.addClass('is-active');
			$li.siblings('.is-active').removeClass('is-active');
		},
		function(){}
	);

	/**
	 * ページトップ
	 */
	var pagetop = $('#js-pagetop');
	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
			pagetop.fadeIn(1000);
		} else {
			pagetop.fadeOut(300);
		}
	});

	/**
	 * トップページタブ
	 */
	$('#js-index-tab .p-index-tab__item .p-index-tab__link').click(function() {
		if ($(this).closest('.p-index-tab__item').hasClass('is-active')) return false;
		var target = $(this).attr('href');
		$(this).closest('.p-index-tab__item').addClass('is-active').siblings('.is-active').removeClass('is-active');
		$('.p-index-tab-content:visible').stop().removeClass('is-active').fadeOut(300);
		$(target).delay(300).fadeIn(1000, function(){
			$(this).addClass('is-active');
			if ($('#js-footer-cta').length) {
				$(window).trigger('resize');
			}
		});
		return false;
	});

	/**
	 * トップページタブ ページャー
	 */
	$(document).on('click', '.p-index-tab-content .p-pager[data-tab][data-ajax-url] a[data-page]', function() {
		var $content = $(this).closest('.p-index-tab-content');
		var $pager = $(this).closest('.p-pager');

		if ($content.hasClass('is-ajaxing')) return false;
		$content.addClass('is-ajaxing');

		$.post(
			$pager.attr('data-ajax-url'),
			{
				action: 'index_tab_pagenate',
				tab: $pager.attr('data-tab'),
				page: $(this).attr('data-page')
			},
			function (html) {
				$content.removeClass('is-ajaxing');
				if (html) {
					$content.fadeOut(300, function(){
						$(window).scrollTop($('#js-index-tab').offset().top - 80);
						$content.html(html).fadeIn(1000);
						if ($('#js-footer-cta').length) {
							$(window).trigger('resize');
						}
					});
				}
			}
		);

		return false;
	});

	/**
	 * 記事一覧でのカテゴリークリック
	 */
	$('article a span[data-url]').hover(
		function(){
			var $a = $(this).closest('a');
			$a.attr('data-href', $a.attr('href'));
			if ($(this).attr('data-url')) {
				$a.attr('href', $(this).attr('data-url'));
			}
		},
		function(){
			var $a = $(this).closest('a');
			$a.attr('href', $a.attr('data-href'));
		}
	);

	/**
	 * コメント
	 */
	if ($('#js-comment__tab').length) {
		var commentTab = $('#js-comment__tab');
		commentTab.find('a').click(function() {
			if (!$(this).parent().hasClass('is-active')) {
				$($('.is-active a', commentTab).attr('href')).animate({opacity: 'hide'}, 0);
				$('.is-active', commentTab).removeClass('is-active');
				$(this).parent().addClass('is-active');
				$($(this).attr('href')).animate({opacity: 'show'}, 1000);
			}
			return false;
		});
	}

	/**
	 * カテゴリー ウィジェット
	 */
	$('.p-widget-categories li ul.children').each(function() {
		$(this).closest('li').addClass('has-children');
		$(this).hide().before('<span class="toggle-children"></span>');
	});
	$('.p-widget-categories .toggle-children').click(function() {
		$(this).closest('li').toggleClass('is-active').find('> ul.children').slideToggle();
	});

	/**
   * アーカイブウィジェット
   */
	if ($('.p-dropdown').length) {
		$('.p-dropdown__title').click(function() {
			$(this).toggleClass('is-active');
			$('+ .p-dropdown__list:not(:animated)', this).slideToggle();
		});
	}

	/**
	 * フッターウィジェット
	 */
	if ($('#js-footer-widget').length) {
		var footer_widget_resize_timer;
		var footer_widget_layout = function(){
			$('#js-footer-widget .p-widget').filter('.p-footer-widget__left, .p-footer-widget__right, .p-footer-widget__border-left, .p-footer-widget__border-bottom, .widget_nav_menu-neighbor').removeClass('p-footer-widget__left p-footer-widget__right p-footer-widget__border-left p-footer-widget__border-bottom widget_nav_menu-neighbor');
			if ($('body').width() >= 768) {
				var em_last, top, em_length = $('#js-footer-widget .p-widget').length;
				$('#js-footer-widget .p-widget').each(function(i){
					var pos = $(this).position();
					if (pos.top !== top) {
						top = pos.top;
						$(this).addClass('p-footer-widget__border-bottom');
						if (pos.left < 2) {
							$(this).addClass('p-footer-widget__left');
						}
						if (em_last) {
							$(em_last).addClass('p-footer-widget__right');
						}
					// メニューの連続
					} else if (em_last && $(em_last).hasClass('widget_nav_menu') && $(this).hasClass('widget_nav_menu')) {
						$(this).addClass('widget_nav_menu-neighbor');
					} else {
						$(this).addClass('p-footer-widget__border-left');
					}
					if (i + 1 == em_length) {
						$(this).addClass('p-footer-widget__right');
					}
					em_last = this;
				});
			}
		};
		$(window).on('load', footer_widget_layout);
		$(window).on('resize', function(){
			clearTimeout(footer_widget_resize_timer);
			footer_widget_resize_timer = setTimeout(footer_widget_layout, 100);
		});
	}
	
	  //calendar widget
	  $('.wp-calendar-table td').each(function () {
		if ( $(this).children().length == 0 ) {
		  $(this).addClass('no_link');
		  $(this).wrapInner('<span></span>');
		} else {
		  $(this).addClass('has_link');
		}
	  });
	
	// テキストウィジェットとHTMLウィジェットにエディターのクラスを追加する
	$('.widget_text .textwidget').addClass('p-entry__body');
	
	// アーカイブとカテゴリーのセレクトボックスにselect_wrapのクラスを追加する
	  $('.widget_archive select').wrap('<div class="select_wrap"></div>');
	  $('.widget_categories form').wrap('<div class="select_wrap"></div>');
	  

	/**
	 * リサイズ時parallax.jsの画像ずれ対策
	 */
	if (typeof $.fn.parallax == 'function') {
		var resize__parallax_timer;
		$(window).on('resize', function(){
			clearTimeout(resize__parallax_timer);
			resize__parallax_timer = setTimeout(function(){
				$(window).trigger('resize.px.parallax');
			}, 300);
		});
	};

});

/**
 * ヘッダースライダー初期化
 */
function init_index_slider(slide_time, responsive) {
	var $ = jQuery;
	if (!slide_time) slide_time = 7000;

	var slick_args = {
		infinite: true,
		dots: false,
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
		nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
		centerMode: true,
		centerPadding: '21.7241%',
		slidesToShow: 1,
		slidesToScroll: 1,
		adaptiveHeight: true,
		autoplay: true,
		speed: 1000,
		autoplaySpeed: slide_time
	};

	if (responsive) {
		slick_args.responsive = [
			{
				breakpoint: 992,
				settings: {
					dots: true,
					centerMode: false
				}
			}
		];
	}

	$('#js-index-slider').slick(slick_args);

	if (responsive) {
		// モバイルでスライダー矢印位置を画像中央に、ドットを画像底面に合わせる
		var set_header_slider_arrow_timer;
		var set_header_slider_arrow = function(){
			if ($('body').width() >= 992) {
				$('#js-index-slider .slick-arrow, #js-index-slider .slick-dots').removeAttr('style');
			} else {
				var h = $('#js-index-slider .slick-active img').height();
				$('#js-index-slider .slick-arrow').css('top', h / 2);
				$('#js-index-slider .slick-dots').css({
					top: h - $('#js-index-slider .slick-dots').outerHeight(true) - 12,
					bottom: 'auto'
				});
			}
		};
		set_header_slider_arrow();
		$(window).on('resize orientationchange', function(){
			clearTimeout(set_header_slider_arrow_timer);
			set_header_slider_arrow_timer = setTimeout(set_header_slider_arrow, 100);
		});
	}

	// adaptiveHeight時parallax.jsの画像ずれ対策
	if (typeof $.fn.parallax == 'function') {
		$('#js-index-slider').on('afterChange', function(event, slick, currentSlide){
			$(window).trigger('resize.px.parallax');
		});
	}

}

/**
 * フッタースライダー初期化
 */
function init_footer_slider(slide_time, responsive) {
	var $ = jQuery;
	if (!slide_time) slide_time = 7000;

	var slick_args = {
		infinite: true,
		dots: false,
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev">&#xe90f;</button>',
		nextArrow: '<button type="button" class="slick-next">&#xe910;</button>',
		slidesToShow: 3,
		slidesToScroll: 3,
		adaptiveHeight: true,
		autoplay: true,
		speed: 1000,
		autoplaySpeed: slide_time
	};

	if (responsive) {
		slick_args.responsive = [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 481,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		];
	}

	$('#js-footer-slider').slick(slick_args);

	if (responsive) {
		// モバイルでのフッタースライダー位置変更
		var footer_slider_position = function(){
			if ($('body').width() >= 768) {
				if ($('.l-primary #js-footer-blog').length) {
					$('.l-primary #js-footer-blog').prependTo('.l-footer');
					$('#js-footer-slider').slick('setPosition');
				}
			} else {
				if ($('.l-footer #js-footer-blog').length) {
					$('.l-footer #js-footer-blog').appendTo('.l-primary');
					$('#js-footer-slider').slick('setPosition');
				}
			}
		};
		footer_slider_position();
		$(window).on('resize orientationchange', footer_slider_position);

		// モバイルでスライダー矢印位置を画像中央に合わせる
		var set_footer_slider_arrow_timer;
		var set_footer_slider_arrow = function(){
			if ($('body').width() >= 768) {
				$('#js-footer-slider .slick-arrow').removeAttr('style');
			} else {
				$('#js-footer-slider .slick-arrow').css('top', $('#js-footer-slider .slick-active img').height() / 2);
			}
		};
		set_footer_slider_arrow();
		$(window).on('resize orientationchange', function(){
			clearTimeout(set_footer_slider_arrow_timer);
			set_footer_slider_arrow_timer = setTimeout(set_footer_slider_arrow, 100);
		});
	}
}

