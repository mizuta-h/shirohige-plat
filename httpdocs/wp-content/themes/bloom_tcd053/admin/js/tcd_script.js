jQuery(function($){

	// アコーディオンの開閉
	$('.theme_option_field').on('click', '.theme_option_subbox_headline', function(){
		$(this).closest('.sub_box').toggleClass('active');
		return false;
	});

	// theme option tab
	$('#tcd_theme_option').cookieTab({
		tabMenuElm: '#theme_tab',
		tabPanelElm: '#tab-panel'
	});

	// ロゴに画像を使うかテキストを使うか選択
	$('#logo_type_select :radio').change(function(){
		if (this.checked) {
			if (this.value == 'yes') {
				$('.logo_text_area').hide();
				$('.logo_image_area').show();
			} else {
				$('.logo_text_area').show();
				$('.logo_image_area').hide();
			}
		}
	});

	// theme option header content
	$('#header_content_button_type1').click(function() {
		$('#header_content_post_slider, #header_content_slider_time').show();
		$('#header_content_image_slider, #header_content_video, #header_content_youtube, #header_content_video_catch').hide();
	});
	$('#header_content_button_type2').click(function() {
		$('#header_content_image_slider, #header_content_slider_time').show();
		$('#header_content_post_slider, #header_content_video, #header_content_youtube, #header_content_video_catch').hide();
	});
	$('#header_content_button_type3').click(function() {
		$('#header_content_video, #header_content_video_catch').show();
		$('#header_content_post_slider, #header_content_image_slider, #header_content_slider_time, #header_content_youtube').hide();
	});
	$('#header_content_button_type4').click(function() {
		$('#header_content_youtube, #header_content_video_catch').show();
		$('#header_content_post_slider, #header_content_image_slider, #header_content_slider_time, #header_content_video').hide();
	});

	// ヘッダーコンテンツ　動画のボタン
	$('.show_video_catch_button input:checkbox').click(function(event) {
		if (this.checked) {
			$(this).closest('.show_video_catch_button').next().show();
		} else {
			$(this).closest('.show_video_catch_button').next().hide();
		}
	});

	// タブコンテンツ フリースペースチェックボックス
	$('.js-index_tab_freespace').change(function() {
		if (this.checked) {
			$(this).closest('.sub_box_content').find('.wp-editor-wrap').show();
		} else {
			$(this).closest('.sub_box_content').find('.wp-editor-wrap').hide();
		}
	}).trigger('change');

	$('.show_video_catch_button input:checkbox').click(function(event) {
		if ($(this).is(':checked')) {
			$(this).closest('.show_video_catch_button').next().show();
		} else {
			$(this).closest('.show_video_catch_button').next().hide();
		}
	});

	// Googleマップ
	$('#gmap_marker_type_button_type2').click(function () {
		$('#gmap_marker_type2_area').show();
	});
	$('#gmap_marker_type_button_type1').click(function () {
		$('#gmap_marker_type2_area').hide();
	});
	$('#gmap_custom_marker_type_button_type1').click(function () {
		$('#gmap_custom_marker_type1_area').show();
		$('#gmap_custom_marker_type2_area').hide();
	});
	$('#gmap_custom_marker_type_button_type2').click(function () {
		$('#gmap_custom_marker_type1_area').hide();
		$('#gmap_custom_marker_type2_area').show();
	});

	// WordPress Color Picker
	$('.c-color-picker').wpColorPicker();

	// load color 2
	$('#js-load_icon').change(function() {
		if ('type2' === this.value) {
			$('.js-load_color2').show();
		} else {
			$('.js-load_color2').hide();
		}
	}).trigger('change');

	// Footer CTA
	$('.footer-cta-type').click(function() {
		var $parent = $(this).closest('.theme_option_field');
		$parent.find('.footer-cta-content').hide();
		$parent.find('.footer-cta-' + $(this).val() + '-content').show();
	});

	// メガメニューBの場合のみネイティブ広告表示設定
	$('.js-megamenu').change(function() {
		if ('type3' === $(this).val()) {
			$(this).siblings('label').show();
		} else {
			$(this).siblings('label').hide();
		}
	}).trigger('change');
});
