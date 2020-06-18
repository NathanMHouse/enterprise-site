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