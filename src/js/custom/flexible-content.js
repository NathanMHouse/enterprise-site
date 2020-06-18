/**
 * Description:     Flexible Content Scripts
 * Author:          Nathan M. House
 * Author URI:      https://nathanmhouse.com
*/


/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
1.0 Tabbed Rows
2.0 Content Row Form Submission
3.0 Featured Posts Row


/*--------------------------------------------------------------
1.0 Tabbed Rows
--------------------------------------------------------------*/
jQuery(document).ready(function($){

	// Define matchHeightOnMobile function.
	// Initialize Slick at proper height on mobile.
	function matchSlickHeightOnMobile(e, slick) {

		if (Foundation.MediaQuery.is('small only')) {

			var height = $(slick.$slides[0]).find('.content-row-tab-tab').height();

			$(this).css({
				'height': height
			});
		} else {

			$(this).css({
				'height': 'initial'
			});
		}
	}

	// Define matchSlickHeight function.
	// Initialize Slick at proper height.
	function matchSlickHeight(e, slick) {

		width = $(window).width();
			
		var maxHeight = 0;

		$(slick.$slides).each(function() {

			if ($(this).height() > maxHeight) {
				maxHeight = $(this).height();
			}
		});
		$('.slick-slide', this).height(maxHeight);
	}

	// Define animateSlickHeightOnMobile function.
	// Animate Slick container height on mobile.
	function animateSlickHeightOnMobile(event, slick, currentSlide, nextSlide) {

		if (Foundation.MediaQuery.is('small only')) {
	
			// Get the height of the next slide
			var height = $(slick.$slides[nextSlide]).find('.content-row-tab-tab').height();

			// Adjust the height of the containing div
			$(this).animate({
				'height': height
			});
		} else {

			$(this).unbind('beforeChange');
		}
	}

	// Define returnSlickSettings function.
	// Returns Slick settings.
	function returnSlickSettings(tabRow) {

		return {
			appendDots: $(tabRow).siblings('.content-row-tab-controls'),
			arrows: false,
			customPaging: function(slider, i) {
				return '<button class="content-row-tab-controls-dots-dot">' + $(slider.$slides[i]).find('.content-row-tab-tab').attr('title') + '<i class="fa fa-sort-asc"></i></button>';
			},
			dots: true,
			dotsClass: 'content-row-tab-controls-dots',
			infinite: false,
			slidestoScroll: 1,
			slidesToShow: 1,
			swipeToSlide: false,
			vertical: true,
			verticalSwiping: false
		}
	}

	$('.content-row-tab-tabs').on(
		'init',
		matchSlickHeightOnMobile
	);

	$('.content-row-tab-tabs').on(
		'init',
		matchSlickHeight
	);

	// Initialize Slick w/ settings.
	$('.content-row-tab-tabs').each(function() {
		$(this).slick(
			returnSlickSettings($(this))
		);
	});
	
	$('.content-row-tab-tabs').on(
		'beforeChange',
		animateSlickHeightOnMobile
	);

	var width = $(window).width();

	$(window).resize(function() {

		if (width == $(window).width()) {
			return;
		}

		$('.content-row-tab-tabs').slick('unslick');

		// Initialize Slick at proper height.
		$('.content-row-tab-tabs').on(
			'init',
			matchSlickHeight
		);

		// Initialize Slick at proper height on mobile.
		$('.content-row-tab-tabs').on(
			'init',
			matchSlickHeightOnMobile
		);

		$('.content-row-tab-tabs').slick(
			returnSlickSettings()
		);

		// On slide change adjust slick height
		$('.content-row-tab-tabs').on(
			'beforeChange',
			animateSlickHeightOnMobile
		);
	});
});


/*--------------------------------------------------------------
2.0 Content Row Form Submission
--------------------------------------------------------------*/
jQuery(document).ready(function($) {
	'use strict';
	$('body').on('submit', '.content-row-form', function(e) {
		e.preventDefault();

		$(e.target).addClass('active');

		$.ajax({
			url: $(this).attr('action'),
			method: 'POST',
			data: $(this).serialize(),
			dataType: 'jsonp'
		});
	});
});


/*--------------------------------------------------------------
3.0 Featured Posts Row
--------------------------------------------------------------*/
jQuery(document).ready(function($){

	var settings = {
		arrows: false,
		dots: true,
		dotsClass: 'content-row-featured-posts-dots',
		infinite: false,
		mobileFirst: true,
		responsive: [
			{
				breakpoint: 1024,
				settings: 'unslick'
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 639,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
			}
		]
	};
	
	var slider = $('.content-row-featured-posts').slick(settings);

	$(window).on(
		'resize',
		function() {
			
			if (
				Foundation.MediaQuery.is('medium down')
				&& !slider.hasClass('slick-initialized')
			) {

				slider = $('.content-row-featured-posts').slick(settings);
			}
		}
	);
});