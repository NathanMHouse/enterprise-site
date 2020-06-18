jQuery(document).ready(function($) {
  'use strict';

  // Define overlay and drawer close button functionality.
  $('.site-content-overlay, .drawer-close').on('click', function(e) {

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
      

      var width = $(window).width();

      if (
        width <= 639
      ) {

        // Phone
        // Slide up any/all drawers.
        $('.drawer').slideUp(200);

      } else if (
        width >= 640
        && width <= 1023
      ) {

        // Tablet
        // Slide out any/all drawers.
        $('.drawer').animate({
          marginLeft: width / 2
        });
      } else {

        // Desktop
        // Slide up other drawers (not including primary).
        $('.drawer').not($('.site-header-primary')).slideUp(200);
      }
    }
  });
});