/**
 *
 * Enterprise Site Gulpfile
 *
 * @since 1.0.0
 *
 * @authors Les Bent, Nathan M. House
 *
 */

/**
 * Table of Contents
 *
 * ?.? Load Gulp Modules and Configuration File
 * ?.? Set Custom Plumber Function
 * ?.? Task: 'gulp'
 * ?.? Task: 'files'
 * ?.? Task: 'watch'
 * ?.? Task: 'clean'
 * ?.? Task: 'clean:dev'
 * ?.? Task: 'clean:cache'
 * ?.? Task: 'styles'
 * ?.? Task: 'custom:js'
 * ?.? Task: 'vendor:js'
 * ?.? Task: 'admin:js'
 * ?.? Task: 'react:js'
 * ?.? Task: 'images'
 * ?.? Task: 'fonts'
 * ?.? Task: 'test'
 * ?.? Task: 'lint:js'
 *
 */


/**
 * ?.? Load Gulp Modules and Configuration File
 *
 */

// Configuration File
var config	 = require('./gulp-config'),

// Gulp
gulp			   = require('gulp'),

// Utility-related Plugins
plumber			 = require('gulp-plumber'),
notify			 = require('gulp-notify'),
del          = require('del'),
runSequence	 = require('run-sequence'),
cache			   = require('gulp-cache'),
concat			 = require('gulp-concat'),
rename			 = require('gulp-rename'),
replace			 = require('gulp-replace'),

// CSS-related Plugins
sass			   = require('gulp-sass'),
autoprefixer = require('gulp-autoprefixer'),
sourcemaps	 = require('gulp-sourcemaps'),
cssnano			 = require('gulp-cssnano'),

// JS-related Plugins
eslint       = require('gulp-eslint'),
uglify			 = require('gulp-uglify'),

// Image-related Plugins
imagemin		 = require('gulp-imagemin');


/**
 * ?.? Set Custom Plumber Function
 *
 * Returns custom notification message and ensures gulp tasks do not 
 * prematurely exit when an error is throw.
 */
function customPlumber(errTitle) {
	return plumber({
		errorHandler: notify.onError({
			title: errTitle || "Error running Gulp",
			message: "Error: <%= error.message %>"
		})
	});
}


/**
 * ?.? Task: 'gulp'
 *
 * Default gulp task. Runs various sub-tasks instrumental in project
 * build. Includes server spin up and ongoing watch trigger.
 *
 */
gulp.task('default', function(callback) {
	runSequence(
		'clean',
		'fonts-setup',
		['lint:js'],
		['styles', 'custom:js', 'vendor:js', 'admin:js', 'react:js'],
		['images', 'fonts', 'files'],
		['watch'],
		callback
	);
});


/**
 * ?.? Task: 'files'
 *
 * Moves project files not associated w/ a subtask (e.g. PHP files, readme.txt etc.)
 * to root directory.
 *
 */
gulp.task('files', function() {

	// Delete current dist files
	del.sync([
		'../*.php',
		'../template-parts',
		'../page-templates',
		'../inc'
	], {force: true});

	// Replace dist files
	gulp.src([
		'./*.php',
		'template-parts/**/*',
		'page-templates/**/*.php',
		'inc/**/*',
		'screenshot.png'
	], {'base': './'})
	.pipe(replace('(src)', '(dist)'))
	.pipe(replace('enterprise-site', config.project.textdomain))
	.pipe(replace('Enterprise-Site', config.project.name))
	.pipe(replace('br_bp_', config.project.namespace))
	.pipe(gulp.dest('../'));
});


/**
 * ?.? Task: 'watch'
 *
 * Watches various directories and reruns connected tasks on file alteration.
 *
 */
gulp.task('watch', function() {
  gulp.watch('scss/**/*.scss', ['styles']);
	gulp.watch(['js/custom/*.js'], ['custom:js', 'lint:js']);
	gulp.watch(['js/vendor/*.js'], ['vendor:js', 'lint:js']);
	gulp.watch(['js/admin/*.js'], ['admin:js', 'lint:js']);
	gulp.watch(['js/react/tools/build/static/js/*.js'], ['react:js', 'lint:js']);
	gulp.watch(['*.html', '*.php', 'template-parts/**/*', 'page-templates/**/*.php', 'inc/**/*'], ['files']);
	gulp.watch(['img/raw/**/*'], ['images']);
	gulp.watch(['fonts/**/*'], ['fonts']);
 });


/**
 * ?.? Task: 'clean'
 *
 * Runs connected cleaning subtasks (i.e. 'clean:dev' and 'clean:cache').
 *
 */
gulp.task('clean', function() {
	runSequence([
		'clean:dev',
		'clean:cache'
	]);
});


/**
 * ?.? Task: 'clean:dev'
 *
 * Cleans generated files.
 *
 */
gulp.task('clean:dev', function() {
	return del.sync([
		'../[^index]*.php',
		'../template-parts',
		'../page-templates',
		'../inc',
		'../style.min.css',
		'../assets'
	], {force: true});
 });



/**
 * ?.? Task: 'clean:cache'
 *
 *
 * Clears and removes gulp cache associated w/ project (i.e. ensuring any tasks
 * that check for cached files run anew).
 */
gulp.task('clean:cache', function (done) {
	return cache.clearAll(done);
});


/**
 * ?.? Task: 'styles'
 *
 * Compiles sass files into auto-prefied, concatonated, minified CSS w/ source map.
 *
 */
gulp.task('styles', function() {

	// Get project scss files
	return gulp.src(config.styles.src)

		// Set custom error
		.pipe(customPlumber('Error running styles task'))

		// Initiate soucemaps
		.pipe(sourcemaps.init())
		.pipe(sass({
			includePaths: ['node_modules/foundation-sites/scss', 'node_modules/@fortawesome/fontawesome-free/scss'],
			outputStyle: 'compressed'
		}))

		// Add autoprefixing
		.pipe(autoprefixer())

		// Concatenate into single unminified
		.pipe(concat('style.css'))
		.pipe(sourcemaps.write())

		// Update w/ project specific names
		.pipe(replace('enterprise-site', config.project.textdomain))
		.pipe(replace('Enterprise-Site', config.project.name))

		// Move to root
		.pipe(gulp.dest('../'))

		// Rename
		.pipe(rename({
			suffix: '.min'
		}))

		// Minify
		.pipe(cssnano())
		.pipe(sourcemaps.write())

		// Move minified to root
		.pipe(gulp.dest('../'));
}); 


/**
 * ?.? Task: 'custom:js'
 *
 * Outputs concatenated, minified JS for custom scripts to assets folder at root.
 * Note: source order specified within config file determines the order in which 
 * the JS is concatenated into a single file. Files that provide dependent functions
 * must take precedent.
 *
 */
gulp.task('custom:js', function() {

	// Source (in particular order) specified within config file
	return gulp.src(config.customJs.src)

		// All custom JS concatenated into single file
		.pipe(concat('custom.js'))
		.pipe(gulp.dest('../assets/js'))

		// Renamed
		.pipe(rename({
			suffix: '.min'
		}))

		// Minified
		.pipe(uglify())
		.pipe(gulp.dest('../assets/js'));
});


/**
 * ?.? Task: 'vendor:js'
 *
 * Outputs concatenated, minified JS for vendor scripts to assets folder at root.
 *
 */
 gulp.task('vendor:js', function() {

	// Source (in particular order) specified within config file
	return gulp.src(config.vendorJs.src)

		// All vendor JS concatenated into single file
		.pipe(concat('vendor.js'))
		.pipe(gulp.dest('../assets/js'))

		// Renamed
		.pipe(rename({
			suffix: '.min'
		}))

		// Minified
		.pipe(uglify())
		.pipe(gulp.dest('../assets/js'));
 });

 /**
 * ?.? Task: 'admin:js'
 *
 * Outputs concatenated, minified JS for admin scripts to assets folder at root.
 *
 */
 gulp.task('admin:js', function() {

	// Source (in particular order) specified within config file
	return gulp.src(config.adminJs.src)

		// All admin JS concatenated into single file
		.pipe(concat('admin.js'))
		.pipe(gulp.dest('../assets/js'))

		// Renamed
		.pipe(rename({
			suffix: '.min'
		}))

		// Minified
		.pipe(uglify())
		.pipe(gulp.dest('../assets/js'));
 });


/**
 * ?.? Task: 'react:js'
 *
 * Outputs concatenated, minified JS for React scripts to assets folder at root.
 *
 */
 gulp.task('react:js', function() {

	// Source (in particular order) specified within config file
	return gulp.src(config.reactJs.src)

		// All React JS concatenated into single file
		.pipe(concat('react.js'))
		.pipe(gulp.dest('../assets/js'))

		// Renamed
		.pipe(rename({
			suffix: '.min'
		}))

		// Minified
		.pipe(uglify())
		.pipe(gulp.dest('../assets/js'));
 });


/**
 * ?.? Task: 'images'
 *
 * Outputs optimized, renamed images to assets folder at root.
 *
 */
gulp.task('images', function() {

	// Delete current dist files
	del.sync([
		'../assets/img',
	], {force: true});

	// Replace current dist files
	return gulp.src(['img/raw/**/*.+(png|jpg|jpeg|gif|svg)'])

		// Image optimization cached to prevent unnecessary running of task
		// Cache can be reset by running 'clean:cache'
		.pipe(cache(imagemin([
			imagemin.gifsicle({interlaced: true}),
			imagemin.jpegtran({progressive: true}),
			imagemin.optipng(),
			imagemin.svgo({multipass: true})
		]), {

			// Cache name
			name: 'enterprise site'
		}))
		.pipe(gulp.dest('../assets/img'));
});


/**
 * ?.? Task: 'fonts'
 *
 * Moves font files to assets folder at root.
 *
 */
gulp.task('fonts-setup', function() {
	return gulp.src(
		[
			'node_modules/@fortawesome/fontawesome-free/webfonts/**/*.+(eot|svg|ttf|woff|woff2)'

			// Add other fonts as needed via npm (or manually directly w/i fonts folder)
		])
		.pipe(gulp.dest('./fonts/'))
});


/**
 * ?.? Task: 'fonts'
 *
 * Moves font files to assets folder at root.
 *
 */
gulp.task('fonts', function() {

	// Delete current dist files
	del.sync([
		'../assets/fonts',
	], {force: true});

	// Replace current dist files
	return gulp.src('fonts/**/*')
		.pipe(gulp.dest('../assets/fonts'))
});


/**
 * ?.? Task: 'test'
 *
 * Runs linting tasks.
 *
 */
gulp.task('test', function() {
	runSequence(
		['lint:js']
	);
});


/**
* ?.? Task: 'lint:js'
*
* Lints vendor and custom JS files.
*
*/
gulp.task('lint:js', function() {

	// If lint:js task enabled...
	if (config.lint.js) {
		return gulp.src(['js/custom/**/*.js', 'js/vendor/**/*.js', 'js/admin/**/*.js'])

		// Custom error message to prevent gulp breaking on error
		.pipe(customPlumber('Error running lint:js task'))

		.pipe(eslint())
		.pipe(eslint.format())

	} else {
		// Else log message
		console.log('lint:js task disabled - adjust config file to enable');
	}
});