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