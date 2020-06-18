/**
 * Description:     Modules Scripts
 * Author:          Nathan M. House
 * Author URI:      https://nathanmhouse.com
*/


/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
1.0 Front Page Banner
2.0 Front Page Banner Tracking Widget
3.0 Scroll-to-top Widget


/*--------------------------------------------------------------
1.0 Front Page Banner
--------------------------------------------------------------*/
jQuery(document).ready(function($){
	$('.module-front-page-banner').slick({
		appendDots: '.module-front-page-banner-controls .grid-container .grid-x',
		arrows: false,
		dots: true,
		draggable: false,
		customPaging: function(slider, i) {
			return'<button class="module-front-page-banner-controls-button">'
			+ '<h3 class="module-front-page-banner-controls-button-number">'
			+ (i + 1)
			+ '</h3>'
			+ '<h3 class="module-front-page-banner-controls-button-title">'
			+ $(slider.$slides[i]).data('control-title')
			+ '</h3>'
			+ '<p>'
			+ $(slider.$slides[i]).data('control-description')
			+ '</p>'
			+ '</button>';
		},
		fade: true,
		infinite: false,
		rows: 0,
		slidestoScroll: 1,
		slidesToShow: 1,
		speed: 500,
		swipeToSlide: false,
		useTransform: false
	});	
});

jQuery(document).ready(function($){

	// Define setVideoSource function.
	function setVideoSource() {
		var video = $('.module-front-page-banner-video');

		if (video.length <= 0) {
			return;
		}

		if (Foundation.MediaQuery.is('medium')) {

			$('source', video).each(
				function() {

					$(this).attr('src', $(this).data('src'));
				}
			);
		} else {
			$('source', video).each(
				function() {

					$(this).removeAttr('src');
				}
			);
		}
	}
	
	setVideoSource();

	$(window).resize(function() {
		setVideoSource();
	});	
});


/*--------------------------------------------------------------
2.0 Front Page Banner Tracking Widget
--------------------------------------------------------------*/
jQuery(document).ready(function($){
	'use strict';

	$('#module-front-page-banner-tracking-widget-form-select').on( 'change', function() {
		var inputValues = $(this).find(':selected').data('input-values');
		
		if ($(this).find(':selected').val()) {

			// Set action attribute for tracking form
			$('#module-front-page-banner-tracking-widget-form').attr('action', inputValues.url);

			// Set name and placeholder values for field(s)
			for (var input in inputValues.inputs) {
				var name        = inputValues.inputs[input].name;
				var placeholder = inputValues.inputs[input].placeholder;

				$('#module-front-page-banner-tracking-widget-form-' + input).attr('name', name);
				$('#module-front-page-banner-tracking-widget-form-' + input).attr('placeholder', placeholder);

				if (name) {
					$('#module-front-page-banner-tracking-widget-form-input-submit').attr('disabled', false);
					$('#module-front-page-banner-tracking-widget-form-' + input).attr('disabled', false);
					$('#module-front-page-banner-tracking-widget-form-' + input).parent().css({
						'display': 'flex'
					});
				} else {
					$('#module-front-page-banner-tracking-widget-form-' + input).attr('disabled', true);
					$('#module-front-page-banner-tracking-widget-form-' + input).parent().css({
						'display': 'none'
					});
				}
			}
		} else {

			// Reset the input values
			$('#module-front-page-banner-tracking-widget-form-input-submit').attr('disabled', true);
			$('#module-front-page-banner-tracking-widget-form-input0, #module-front-page-banner-tracking-widget-form-input1').attr('name', '');
			$('#module-front-page-banner-tracking-widget-form-input0, #module-front-page-banner-tracking-widget-form-input1').attr('disabled', true);
			$('#module-front-page-banner-tracking-widget-form-input0').attr('placeholder', 'N/A');
			$('#module-front-page-banner-tracking-widget-form-input1').attr('placeholder', '');
			$('#module-front-page-banner-tracking-widget-form-input1').parent().css({
				'display': 'none'
			});
		}
	});
});


/*--------------------------------------------------------------
3.0 Scroll-to-top Widget
--------------------------------------------------------------*/
jQuery(document).ready(function($){

	$(window).resize(function() {
		$('#scroll-top').css({
			'display': 'none'
		});
	});
	
	$(window).scroll(function() {
		(Foundation.MediaQuery.is('medium') && $(this).scrollTop() > 400)
			? $("#scroll-top").fadeIn()
			: $("#scroll-top").fadeOut();
	});

	$("#scroll-top").click(function() {
		return $("html, body").animate({
      scrollTop: 0
		});
  });
});