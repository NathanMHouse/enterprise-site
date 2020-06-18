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