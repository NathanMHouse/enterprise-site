/**
 * Description:     Navigation Scripts
 * Author:          Nathan M. House
 * Author URI:      https://nathanmhouse.com
*/


/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
?.? Mobile Megamenu Functionality
?.? Tracking Form Functionality
?.? Drawer Functionality (Navigation, Search, and Tracking)
?.? Resize Style Reset


/*--------------------------------------------------------------
?.? Mobile Megamenu Functionality
--------------------------------------------------------------*/
jQuery(document).ready(function($) {
	'use strict';

	var megaMenus = $('.menu-item-is-mega-menu');
	var subMenus  = $('.menu-item-has-children');

	// Define revealMegaMenuOnMobile function
	function revealMegaMenuOnMobile(e) {

		var trigger = e.target;

		if (Foundation.MediaQuery.is('large')) {
			return;
		}

		$(trigger).children('.mega-menu-container').slideToggle(500).toggleClass('open');

		$(trigger).find('> a').toggleClass('active');
	}

	// Define revealSubMenuOnMobile function.
	function revealSubMenuOnMobile(e) {

		var trigger = e.target;

		if (Foundation.MediaQuery.is('large')) {
			return;
		}

		$(trigger).children('.sub-menu').slideToggle(200).toggleClass('open');

		$(trigger).find('> a').toggleClass('active');
	}

	$(megaMenus).on(
		'click',
		revealMegaMenuOnMobile
	);

	$(subMenus).on(
		'click',
		revealSubMenuOnMobile
	);

	$(window).resize(function() {

		$(megaMenus).unbind('click');
		$(subMenus).unbind('click');

		$(megaMenus).on(
			'click',
			revealMegaMenuOnMobile
		);

		$(subMenus).on(
			'click',
			revealSubMenuOnMobile
		);
	
	});
});


/*--------------------------------------------------------------
?.? Tracking Form Functionality
--------------------------------------------------------------*/
jQuery(document).ready(function($){
	'use strict';

	$('#track-form-select').on('change', function() {
		var inputValues = $(this).find(':selected').data('input-values');
		
		if ($(this).find(':selected').val()) {
			
			// Set action attribute for tracking form
			$('#track-form').attr('action', inputValues.url);

			// Set name and placeholder values for field(s)
			for (var input in inputValues.inputs) {
				var name        = inputValues.inputs[input].name;
				var placeholder = inputValues.inputs[input].placeholder;

				$('#track-form-' + input).attr('name', name);
				$('#track-form-' + input).attr('placeholder', placeholder);

				if (name) {
					$('#track-form-' + input).attr('disabled', false);
					$('#track-form-input-submit').attr('disabled', false);
				} else {
					$('#track-form-' + input).attr('disabled', true);
				}
			}
		} else {

			// Reset the input values
			$('#track-form-input-submit').attr('disabled', true);
			$('#track-form-input0, #track-form-input1').attr('name', '');
			$('#track-form-input0, #track-form-input1').attr('disabled', true);
			$('#track-form-input0').attr('placeholder', 'Please Select Your Platform');
			$('#track-form-input1').attr('placeholder', '');
		}
	});
});


/*--------------------------------------------------------------
?.? Drawer Functionality (Navigation, Search, and Tracking)
--------------------------------------------------------------*/
jQuery(document).ready(function($) {
	'use strict';

	// Define initializeSecondaryNavDrawer function.
	function initializeSecondaryNavDrawer(e) {

		// Prevent synthentic 'clicks' (form submission via keyboard from
		// triggering event).
		if (e.detail >= 1) {
			e.preventDefault();

			// Remove 'active' class on overlay (disable).
			$('.site-content-overlay').removeClass('active');

			// Remove 'open' class on drawers.
			$('.drawer').removeClass('open');

			// Remove 'active' class on drawer buttons.
			$('.drawer-button').removeClass('active');

			// If open, close and hide any active map locations.
			$('.tool-locations-map-location.active').outerHeight(0);		
			$('.tool-locations-map-location').removeClass('active');

			setTimeout(function() {
				$('.site-header-secondary').removeClass('visible');
			}, 350);

			if (Foundation.MediaQuery.is('small only')) {

				// Phone
				// Slide up any/all drawers.
				$('.drawer').slideUp(200);

			} else if (Foundation.MediaQuery.is('medium only')) {

				// Tablet
				// Slide out any/all drawers.
				$('.drawer').animate({
					marginLeft: $(window).width() / 2
				});
			} else {

				// Desktop
				// Slide up other drawers (not including primary).
				$('.drawer').not($('.site-header-primary')).slideUp(200);
			}
		}
	}

	// Define initializeSecondaryNavDrawerButtons function.
	function initializeSecondaryNavDrawerButtons(e) {
		e.preventDefault();

		// If drawer button is active, hide overlay, else show overlay.
		if (
			$(this).hasClass('active')
		) {
			$('.site-content-overlay').removeClass('active');

			// A timeout is required in order to accommodate the transition of the overlay. 
			setTimeout(function() {
				$('.site-header-secondary').removeClass('visible');
			}, 350);
		} else {
			$('.site-content-overlay').addClass('active');
			$('.site-header-secondary').addClass('visible');	
		}

		// Toggle 'active' class on clicked drawer button.
		$(this).toggleClass('active');

		// Remove 'active' class on all other drawer buttons.
		$('.drawer-button').not($(this)).removeClass('active');

		// Toggle 'open' class on active drawer.
		$($(this).attr('data-drawer')).toggleClass('open');

		// Remove 'open' class on all other drawers.
		$('.drawer').not($(this).attr('data-drawer')).removeClass('open');

		if (Foundation.MediaQuery.is('small only')) {

			// Phone
			// Slide up other drawers (not include primary).
			$('.drawer').not($(this).attr('data-drawer')).slideUp(200);

			// Slide up/down active drawer.
			$($(this).attr('data-drawer')).slideToggle(200);

		} else if (Foundation.MediaQuery.is('medium only')) {

			// Tablet
			// Slide in any other drawers.
			$('.drawer').not($(this).attr('data-drawer')).animate({
				marginLeft: $(window).width() / 2
			});

			// Slide out active drawer.
			$($(this).attr('data-drawer')).animate({
				marginLeft: 0
			});

		} else {
			
			// Desktop
			// Slide up other drawers (not including primary).
			$('.drawer').not($(this).attr('data-drawer')).not($('.site-header-primary')).slideUp(200);

			// Slide up/down active drawer.
			$($(this).attr('data-drawer')).slideToggle(200);
		} 
	}

	// Define overlay and drawer close button functionality.
	$('.site-content-overlay, .drawer-close').on(
		'click', 
		initializeSecondaryNavDrawer
	);

	// Define drawer button functionality.
	$('#navigation, #search, #track').on(
		'click',
		initializeSecondaryNavDrawerButtons
	);

	$(window).resize(function() {

		$('.site-content-overlay, .drawer-close').unbind('click');
		$('#navigation, #search, #track').unbind('click');

		$('.site-content-overlay, .drawer-close').on(
			'click', 
			initializeSecondaryNavDrawer
		);

		// Define drawer button functionality.
		$('#navigation, #search, #track').on(
			'click',
			initializeSecondaryNavDrawerButtons
		);
	
	});
});


/*--------------------------------------------------------------
?.? Resize Style Reset
--------------------------------------------------------------*/
jQuery(document).ready(function($){

	// Define resetNavStyles function
	function resetNavStyles(width) {

		if (width == $(window).width()) {
			return;
		}

		// Secondary nav.
		$('.drawer').css({
			'display' : '',
			'margin-left' : ''
		});

		$('.drawer').removeClass('open');

		$('.site-header-secondary').removeClass('visible');

		$('.site-content-overlay').removeClass('active');

		$('.drawer-button').removeClass('active');

		// Primary nav
		$('.mega-menu-container, .sub-menu').css({
			'display' : ''
		});

		$('.mega-menu-container, .sub-menu').removeClass('open');
	}

	var width = $(window).width();

	$(window).resize(function() {
		resetNavStyles(width);
	});
});