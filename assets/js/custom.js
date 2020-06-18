console.log('custom-example.js running');
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
/**
 * Description:     Tools Scripts
 * Author:          Nathan M. House
 * Author URI:      https://nathanmhouse.com
*/


/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
1.0 Shared
	1.0 Map Initilization
2.0 Borders
	2.1 Details Accordion


/*--------------------------------------------------------------
1.0 Shared
--------------------------------------------------------------*/
/*--------------------------------------------------------------
1.0 Map Initilization
--------------------------------------------------------------*/
(function($) {
	function initMap($el) {
		var lat     = parseFloat( $el.data('lat') );
		var lng     = parseFloat( $el.data('lng') );
		var options = {
			styles: [
		    {
	        "featureType": "administrative",
	        "elementType": "labels.text.fill",
	        "stylers": [
	          {
	              "color": "#0a0a0a"
	          }
	        ]
		    },
		    {
	        "featureType": "administrative",
	        "elementType": "labels.text.stroke",
	        "stylers": [
	          {
	            "visibility": "off"
	          }
	        ]
		    },
		    {
	        "featureType": "landscape",
	        "elementType": "all",
	        "stylers": [
	          {
	            "color": "#f6f6f6"
	          }
	        ]
		    },
		    {
	        "featureType": "poi",
	        "elementType": "all",
	        "stylers": [
	          {
	            "visibility": "off"
	          }
	        ]
		    },
		    {
	        "featureType": "road",
	        "elementType": "all",
	        "stylers": [
	          {
	            "color": "#f6f6f6"
	          }
	        ]
		    },
		    {
	        "featureType": "road.highway",
	        "elementType": "all",
	        "stylers": [
	          {
	            "visibility": "simplified"
	          }
	        ]
		    },
		    {
	        "featureType": "road.arterial",
	        "elementType": "labels.icon",
	        "stylers": [
	          {
	            "visibility": "off"
	          }
	        ]
		    },
		    {
	        "featureType": "transit",
	        "elementType": "all",
	        "stylers": [
	          {
	            "visibility": "off"
	          }
	        ]
		    },
		    {
	        "featureType": "water",
	        "elementType": "all",
	        "stylers": [
	          {
	            "color": "#dcdcdc"
	          },
	          {
	            "visibility": "on"
	          }
	        ]
		    }
			]
		};

	  var mapArgs = {
	      zoom        : $el.data('zoom') || 16,
	      mapTypeId   : google.maps.MapTypeId.ROADMAP,
	      options     : options,
	      center      : {
	      	lat: lat,
	      	lng: lng
	      },
	      lat         : lat,
	      lng         : lng
	  };
	  var map = new google.maps.Map( $el[0], mapArgs );

	  var trafficLayer = new google.maps.TrafficLayer();
  	trafficLayer.setMap(map);

	  return map;
	}

	$(document).ready(function($){
	  $('.borders-post-content-map, .locations-post-content-map').each(function(){
	      var map = initMap($(this));
	  });
	});	
})(jQuery);


/*--------------------------------------------------------------
2.0 Borders
--------------------------------------------------------------*/
/*--------------------------------------------------------------
2.1 Details Accordion
--------------------------------------------------------------*/
jQuery(document).ready(function($){
	

	// Define setAccordionAttributes function.
	function setAccordionAttributes() {

		// Zero out any active inline styles.
		$('.accordion-content').css({
			'display' : ''
		});

		if (Foundation.MediaQuery.is('large')) {
			$('.accordion-item').addClass('is-active');
		} else {
			$('.accordion-item').removeClass('is-active');
		}
	}

	setAccordionAttributes();

	$(window).resize(function() {
		setAccordionAttributes();	
	});
});
/**
 * Description:     App (General) Scripts
 * Author:          Nathan M. House
 * Author URI:      https://nathanmhouse.com
*/


/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
1.0 Initizalize Foundation
2.0 Popup Videos
3.0 Define Pardot Form Handler Callback
4.0 Endless Posts Scrolling


/*--------------------------------------------------------------
1.0 Initizalize Foundation
--------------------------------------------------------------*/
jQuery(document).ready(function($){
	$(document).foundation();
});


/*--------------------------------------------------------------
2.0 Popup Videos
--------------------------------------------------------------*/
jQuery(document).ready(function($){
	'use strict';
	$(document).on('click', '.content-row-media-video, .video-cta', function(e) {
		e.preventDefault();

		var videoSource = $(this).attr('data-fancybox-src');

		$.fancybox.open({
			src: videoSource,
			opts: {
				iframe: {
					tpl: '<iframe id="fancybox-frame-{rnd}" name="fancybox-frame-{rnd}" class="fancybox-iframe" allowfullscreen allow="autoplay; fullscreen" src=""></iframe>'				
				}
			}
		});
	});
});


/*--------------------------------------------------------------
3.0 Define Pardot Form Handler Callback
--------------------------------------------------------------*/
function pardotCallback(response) {
	var message;
	if (response.status === 'success') {
		message  = '<div class="cell medium-6 medium-offset-3">';
		message += '<h3 class="content-row-form-message">';
		message += jQuery('#content-row-form.active').data('success-message');
		message += '</h3>';
		message += '</div>'; 
	} else if (response.status === 'error') {
		message  = '<div class="cell medium-6 medium-offset-3">';
		message += '<h3 class="content-row-form-message">';
		message += jQuery('#content-row-form.active').data('error-message');
		message += '</h3>';
		message += '</div>';
	}

	jQuery('#content-row-form.active').replaceWith(message);
}


/*--------------------------------------------------------------
4.0 Endless Posts Scrolling
--------------------------------------------------------------*/
jQuery(document).ready(function($){
	'use strict';

	if ( $('.archives' ).length ) {
		var canBeLoaded  = true;
		var bottomOffset = ( $(document).height() * .75);

		$(window).scroll(function() {
			var data = {
				'action'       : 'load_more_posts',
				'ajax_nonce'   : postParams.ajaxNonce,
				'query'        : postParams.posts,
				'current_page' : postParams.currentPage,
				'row_count'    : postParams.rowCount,
				'post_count'   : postParams.postCount,
				'cta_count'    : postParams.ctaCount,
				'page'         : postParams.page,
				'is_search'    : postParams.isSearch,
			};

			if (
				$(document).scrollTop() > ($(document).height() - bottomOffset)
				&& canBeLoaded
				&& postParams.currentPage < postParams.maxPage
			) {
				$.ajax({
					url: postParams.ajaxURL,
					data: data,
					type: 'POST',
					beforeSend: function(xhr) {

						/* Subsequent loads are disabled until the content has been
						 * loaded on the page.
						 */
						canBeLoaded = false;

						$('.site-content-loader').removeClass('hide');
					},
					success: function(data) {

						$('.site-content-loader').addClass('hide');

						if (data) {
							var el = $(data);
							$('.archives').find('.archive-row').last().after(el);

							// Reflow new posts
							el.foundation();

							// Increment our parameters
							postParams.currentPage++;
							postParams.rowCount  = $('.archive-row').length;
							postParams.postCount = $('.excerpt').length;
							postParams.ctaCount  = $('.module-cta-row').length;

							canBeLoaded = (postParams.maxPage == postParams.currentPage) ? false : true;
						}
					}
				});
			}
		});
	}
});
/**
 * Description:     iFrame Resizer Scripts
 * Author:          Nathan M. House
 * Author URI:      https://nathanmhouse.com
*/


/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
1.0 Initialize iFrame Resizer



/*--------------------------------------------------------------
1.0 Initialize iFrame Resizer
--------------------------------------------------------------*/
jQuery(document).ready( function($){
	$('.pardot-form-container iframe').load( function(e) {
		$(e.target).iFrameResize();
	});
});