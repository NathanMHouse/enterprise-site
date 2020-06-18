/**
 *
 * Gulp Config File
 *
 */

 
// Set our project and task variables
var config = {

	// project variables
	project: {
		name: 'Enterprise-Site',
		textdomain: 'enterprise-site',
		namespace: 'enterprise_site_'
	},

	// styles task
	styles: {

		// src order
		src: [
			'scss/style.scss'
			// Other .scss files...
		]
	},

	// customJs task
	customJs: {

		// src order
		src: [
			'js/custom/custom-example.js',
			'js/custom/navigation.js',
			'js/custom/flexible-content.js',
			'js/custom/modules.js',
			'js/custom/tools.js',
			'js/custom/app.js',
			'js/custom/iframe-resizer.js',
			// Other custom.js files...
		]
	},

	// vendorJs task
	vendorJs: {

		// src order
		src: [
			'js/vendor/vendor-example.js',
			'js/vendor/foundation.js',
			'js/vendor/fancybox.js',
			'js/vendor/slick.js',
      'js/vendor/iframeResizer.js',
			// Other vendor.js files
		]
	},

	// adminJs task
	adminJs: {

		// src order
		src: [
			'js/admin/admin-example.js'
			// Other admin.js files
		]
	},

	// reactJs task
	reactJs: {

		// src order
		src: [
			'js/react/tools/build/static/js/*.js'
		]
	},

	// lint tasks
	lint: {
		js: false,
		scss: false
	}
};

// Export our config options
module.exports = config;
