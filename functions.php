<?php
/**
 * Functions File
 *
 * Functions and definitions (dist).
 *
 * @package Enterprise-Site
 *
 */

/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
?.? Theme Setup
	?.? Set Up Theme
	?.? Register Widget Area
	?.? Conditionally Include Functions
	?.? Dequeue Guttenberg Styles
	?.? Register and Enqueue Scripts and Styles
	?.? Register and Enqueue Admin Scripts
	?.? Register Enqueue React Scripts
	?.? Update Custom Post Type (Resources/News) Query
	?.? Set Up Params for AJAX Post Load
	?.? Handle AJAX Post Queries
	?.? Filter Custom Post Type Archive Templates
	?.? Filter Custom Post Type Single Templates
	?.? Filter Borders Single Templates
	?.? Filter Locations Single Templates
	?.? Hide Custom Post Type Type Taxonomies Metaboxes
	?.? Update Custom Post Type Rewrite Rules
	?.? Set Custom (YOAST) Breadcrumb Paths
	?.? Update Custom Post Type Archive Title
	?.? Set Parot Plugin Post Types
	?.? Set Up Borders Weather Data Endpoint
	?.? Set Up Borders Weather Data Endpoint Return
	?.? Add User Google API Key


/*--------------------------------------------------------------
?.? Theme Setup
--------------------------------------------------------------*/
/**
 * ?.? Set Up Theme
 *
 * Sets up theme defaults and registers support for various WordPress features.
 */
if ( ! function_exists( 'enterprise_site_setup' ) ) {

	function enterprise_site_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Enable YOAST breadcrumbs
		add_theme_support( 'yoast-seo-breadcrumbs' );

		/* Switch default core markup for search form, comment forms, and
		 * comments to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Register menu locations.
		register_nav_menus(
			array(
				'header_primary'                => __( 'Header Primary', 'enterprise-site' ),
				'header_secondary'              => __( 'Header Secondary', 'enterprise-site' ),
				'footer_top_branding'           => __( 'Footer Top Branding', 'enterprise-site' ),
				'footer_top_left'               => __( 'Footer Top Left', 'enterprise-site' ),
				'footer_top_middle'             => __( 'Footer Top Middle', 'enterprise-site' ),
				'footer_top_right'              => __( 'Footer Top Right', 'enterprise-site' ),
				'footer_bottom_contact_details' => __( 'Footer Bottom Contact Details', 'enterprise-site' ),
				'footer_bottom_left'            => __( 'Footer Bottom Left', 'enterprise-site' ),
				'footer_bottom_middle'          => __( 'Footer Bottom Middle', 'enterprise-site' ),
				'footer_bottom_social'          => __( 'Footer Bottom Social', 'enterprise-site' ),
				'footer_bottom_legal'           => __( 'Footer Bottom Legal', 'enterprise-site' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'enterprise_site_setup' );


/**
 * ?.? Register Widget Area
 *
 * Register default sidebar widget area (i.e. sidebar-1).
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function enterprise_site_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar 1', 'enterprise-site' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'enterprise-site' ),
			'before_widget' => '<section>',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'enterprise_site_widgets_init' );


/**
 * ?.? Conditionally Include Functions
 *
 * Include relevant functions depending upon certain conditionals.
 *
 */
function enterprise_site_conditionally_include_functions() {
	$dir = get_template_directory();

	// Include admin functions.
	if ( is_admin() ) {

		// Options pages.
		include $dir . '/inc/options-pages.php';
	}

	// Include regular functions.
	include $dir . '/inc/template-tags.php';
}
enterprise_site_conditionally_include_functions();


/**
 * ?.? Dequeue Guttenberg Styles
 *
 * Removes unneeded Guttenberg styles.
 *
 */
function enterprise_site_dequeue_styles() {
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_print_styles', 'enterprise_site_dequeue_styles' );


/**
 * ?.? Register and Enqueue Scripts and Styles
 *
 * Loads default styles and scripts.
 *
 */
function enterprise_site_enqueue_scripts() {

	// Register and enqueue default styles.
	wp_register_style( 'enterprise_site_styles', get_template_directory_uri() . '/style.min.css', array(), false, 'all' );
	wp_enqueue_style( 'enterprise_site_styles' );

	// Register and enqueue vendor scripts.
	wp_register_script( 'enterprise_site_vendor_scripts', get_template_directory_uri() . '/assets/js/vendor.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'enterprise_site_vendor_scripts' );

	// Register and enqueue Google Maps scripts.
	$google_maps_api_key = ( get_field( 'api_key_google_maps_borders', 'option' ) ) ?: false;
	if (
		$google_maps_api_key
		&& is_singular(
			array(
				'borders',
				'locations',
			)
		)
	) {
		wp_register_script( 'enterprise_site_google_maps_scripts', "https://maps.googleapis.com/maps/api/js?key=$google_maps_api_key", array( 'jquery' ), false, true );
		wp_enqueue_script( 'enterprise_site_google_maps_scripts' );
	}

	// Register and enqueue custom scripts.
	wp_register_script( 'enterprise_site_custom_scripts', get_template_directory_uri() . '/assets/js/custom.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'enterprise_site_custom_scripts' );
}
add_action( 'wp_enqueue_scripts', 'enterprise_site_enqueue_scripts' );


/**
 * ?.? Register and Enqueue Admin Scripts
 *
 * Loads admin scripts.
 *
 */
function enterprise_site_enqueue_admin_scripts() {

	// Enqueue admin scripts.
	wp_register_script( 'enterprise_site_admin_scripts', get_template_directory_uri() . '/assets/js/admin.min.js', array(), false, true );
	wp_enqueue_script( 'enterprise_site_admin_scripts' );
}
add_action( 'admin_enqueue_scripts', 'enterprise_site_enqueue_admin_scripts' );

/**
 * ?.? Register and Enqueue React Scripts
 *
 * Loads the necessary React scripts (library, vendor, and custom) for use in
 * site SPAs (e.g. tools).
 *
 */
function enterprise_site_enqueue_react_scripts() {

	if ( ! is_page_template( 'page-templates/template-tools.php' ) ) {
		return;
	}

	wp_register_script( 'enterprise_site_react_scripts', get_template_directory_uri() . '/assets/js/react.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'enterprise_site_react_scripts' );
}
add_action( 'wp_enqueue_scripts', 'enterprise_site_enqueue_react_scripts' );


/**
 * ?.? Update Custom Post Type (News and Resources) Query
 *
 * Update post type query using pre_get_posts action.
 *
 * @param obj $query The WordPress query object.
 *
 * @return obj $query The modified WordPress query object.
 */
function enterprise_site_update_custom_post_type_query( $query ) {

	if ( is_admin() ) {
		return $query;
	}

	if (
		isset( $query->query['post_type'] )
		&& ( 'resources' === $query->query['post_type'] || 'news' === $query->query['post_type'] )
	) {
		$query->set( 'posts_per_page', 6 );

		// Remove pre_get_posts filter to prevent endless loop.
		remove_action( 'pre_get_posts', __FUNCTION__ );
	}

	if (
		isset( $_POST['form_field_search'], $_POST['posts_filter_nonce'] ) // input var okay.
		&& wp_verify_nonce( sanitize_key( $_POST['posts_filter_nonce'] ), 'filter_posts' ) // input var okay
	) {
		$search_query = sanitize_text_field( wp_unslash( $_POST['form_field_search'] ) ); // input var okay
		$query->set( 's', $search_query );
	} elseif ( isset( $_GET['industries'] ) ) {
		$search_query = sanitize_text_field( wp_unslash( $_GET['form_field_search'] ) ); // input var okay
		$query->set( 's', $search_query );
	} else {
		$search_query = '';
	}

}
add_action( 'pre_get_posts', 'enterprise_site_update_custom_post_type_query' );


/**
 * ?.? Set Up Params for AJAX Post Load
 *
 * Sets up required post params used in the loading of archive content via AJAX.
 *
 */
function enterprise_site_set_up_ajax_params() {
	global $wp_query;

	$page          = ( get_post_type() ) ?: false;
	$cta_frequency = ( $page && get_field( 'cta_frequency_' . $page, 'options' ) )
		? get_field( 'cta_frequency_' . $page, 'options' )
		: 6;

	wp_localize_script(
		'enterprise_site_custom_scripts',
		'postParams',
		array(
			'ajaxURL'                => site_url() . '/wp-admin/admin-ajax.php',
			'ajaxNonce'              => wp_create_nonce( 'load-more-posts-nonce' ),
			'ctaCount'               => 0,
			'ctaFrequency'           => $cta_frequency,
			'currentPage'            => ( get_query_var( 'paged' ) ) ?: 1,
			'page'                   => $page,
			'posts'                  => wp_json_encode( $wp_query->query_vars ),
			'postCount'              => get_query_var( 'posts_per_page' ),
			'postPerPage'            => get_query_var( 'posts_per_page' ),
			'maxPage'                => $wp_query->max_num_pages,
			'rowCount'               => get_query_var( 'posts_per_page' ) / 3,
			'isSearch'               => ( is_search() ) ?: 0,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'enterprise_site_set_up_ajax_params' );


/**
 * ?.? Handle AJAX Post Queries
 *
 * Handles post queries made via AJAX.
 *
 */
function enterprise_site_load_more_posts_ajax_handler() {

	check_ajax_referer( 'load-more-posts-nonce', 'ajax_nonce' );

	$args                = ( isset( $_POST['query'] ) ) // input var okay
		? json_decode( sanitize_text_field( wp_unslash( $_POST['query'] ) ), true ) // input var okay
		: '';
	$args['paged']       = ( isset( $_POST['current_page'] ) ) // input var okay
		? sanitize_text_field( wp_unslash( $_POST['current_page'] ) ) + 1 // input var okay
		: '';
	$args['post_status'] = 'publish';

	$row_count  = ( isset( $_POST['row_count'] ) ) // input var okay
		? sanitize_text_field( wp_unslash( $_POST['row_count'] ) ) // input var okay
		: '';
	$post_count = ( isset( $_POST['post_count'] ) ) // input var okay
		? sanitize_text_field( wp_unslash( $_POST['post_count'] ) ) // input var okay
		: '';
	$cta_count  = ( isset( $_POST['cta_count'] ) ) // input var okay
		? sanitize_text_field( wp_unslash( $_POST['cta_count'] ) ) // input var okay
		: '';

	$page = ( isset( $_POST['page'] ) ) // input var okay
		? sanitize_text_field( wp_unslash( $_POST['page'] ) ) // input var okay
		: '';

	$ctas          = array();
	$cta_frequency = ( get_field( 'cta_frequency_' . $page, 'options' ) ) ?: '';

	$is_search = ( isset( $_POST['is_search'] ) ) // input var okay
		? sanitize_text_field( wp_unslash( $_POST['is_search'] ) ) // input var okay
		: false;

	if (
		! $is_search
		&& have_rows( 'ctas_' . $page, 'options' )
	) {
		while ( have_rows( 'ctas_' . $page, 'options' ) ) {
			the_row();
			$ctas[] = array(
				'background_color' => ( get_sub_field( 'background_color' ) ) ?: 'background-grey',
				'background_image' => ( get_sub_field( 'background_image' ) ) ?: array(
					'sizes' => array(
						'large' => '',
					),
				),
				'padding'          => ( get_sub_field( 'padding' ) ) ?: 'padding-both',
				'title'            => ( get_sub_field( 'title' ) ) ?: '',
				'description'      => ( get_sub_field( 'description' ) ) ?: '',
				'type'             => ( get_sub_field( 'type' ) ) ?: 'cta',
				'cta_i'            => ( get_sub_field( 'cta_i' ) ) ?: array(
					'label'  => __( 'Read more', 'enterprise-site' ),
					'url'    => '',
					'style'  => 'text',
					'target' => '_self',
				),
				'cta_ii'           => ( get_sub_field( 'cta_ii' ) ) ?: array(
					'label'  => __( 'Read more', 'enterprise-site' ),
					'url'    => '',
					'style'  => 'text',
					'target' => '_self',
				),
				'form'             => ( get_sub_field( 'form' ) ) ?: array(
					'post_url'        => '',
					'Placeholder'     => '',
					'name'            => '',
					'button_label'    => __( 'Read more', 'enterprise-site' ),
					'success_message' => '',
					'error_message'   => '',
				),
			);
		}
	}

	/** Search functionality is augmented via Relevanssi plugin.
	 * AJAX posts load in search results should use it as well.
	 */
	if (
		$is_search
		&& function_exists( 'relevanssi_do_query' )
	) {
		$query = new WP_Query();
		$query->parse_query( $args );
		relevanssi_do_query( $query );
	} else {
		$query = new WP_Query( $args );
	}

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			if ( 0 === $post_count % 3 ) {
				$row_count++;

				$container_class = ( $is_search )
					? "search-archive-row search-archive-row-$row_count"
					: "custom-posts-archive-row custom-posts-archive-row-$row_count";

				// Exclude CTAs from search results.
				if (
					! $is_search
					&& ! empty( $ctas )
					&& isset( $ctas[ $cta_count ] )
					&& 0 === $post_count % $cta_frequency
				) {
					?>
					<?php
					include( locate_template( '/template-parts/module-cta-row.php', false, false ) );
					$cta_count++;
				}
				?>
				<div
					class="<?php echo esc_attr( $container_class ); ?> archive-row grid-container"
					data-equalizer="title"
					data-equalizer-on="medium"
					data-equalize-by-row="true"
				>
					<div
						class="grid-x grid-margin-x"
						data-equalizer="excerpt"
						data-equalizer-on="medium"
						data-equalize-by-row="true"
						style="position: relative;"
					>
					<?php
			}
							$post_count++;
							$query->the_post();

							$file = ( $is_search )
								? 'search'
								: 'custom-posts-excerpt';

							get_template_part( 'template-parts/content', $file );
			if ( 0 === $post_count % 3 ) {
				?>
					</div><!-- .grid-x -->
				</div><!-- <?php echo esc_html( $container_class ); ?> -->
				<?php
			}
		}
	}
	die;
}
add_action( 'wp_ajax_load_more_posts', 'enterprise_site_load_more_posts_ajax_handler' );
add_action( 'wp_ajax_nopriv_load_more_posts', 'enterprise_site_load_more_posts_ajax_handler' );


/**
 * ?.? Filter Custom Post Type Archive Templates
 *
 * Sets custom path for custom post types (i.e. resources/news) archive.
 *
 * @param   string  $archive_template   Template file for archive
 *
 * @return  string  $archive_template   Filtered template file for archive
**/
function enterprise_site_set_custom_post_archive_template( $archive_template ) {
	global $post;

	if (
		! is_post_type_archive(
			array(
				'resources',
				'news',
			)
		)
		&& ! is_tax(
			array(

				// Resource taxonomies
				'resource_types',
				'needs',
				'industries',
				'regions',

				// News taxonomies
				'news_types',
			)
		)
	) {
		return $archive_template;
	}

	$archive_template = dirname( __FILE__ ) . '/page-templates/archive-custom-posts.php';

	return $archive_template;
}
add_filter( 'archive_template', 'enterprise_site_set_custom_post_archive_template' );


/**
 * ?.? Filter Custom Post Type Single Templates
 *
 * Sets custom path for custom post types (i.e. resources/news) single.
 *
 * @param   string  $single_template   Template file for single
 *
 * @return  string  $single_template   Filtered template file for single
**/
function enterprise_site_set_custom_post_single_template( $single_template ) {
	global $post;

	if (
		! is_singular(
			array(
				'resources',
				'news',
			)
		)
	) {
		return $single_template;
	}

	$single_template = dirname( __FILE__ ) . '/page-templates/single-custom-posts.php';

	return $single_template;
}
add_filter( 'single_template', 'enterprise_site_set_custom_post_single_template' );


/**
 * ?.? Filter Borders Single Templates
 *
 * Sets custom path for borders single.
 *
 * @param   string  $single_template   Template file for single
 *
 * @return  string  $single_template   Filtered template file for single
**/
function enterprise_site_set_borders_single_template( $single_template ) {
	global $post;

	if (
		! is_singular(
			array(
				'borders',
			)
		)
	) {
		return $single_template;
	}

	$single_template = dirname( __FILE__ ) . '/page-templates/single-borders.php';

	return $single_template;
}
add_filter( 'single_template', 'enterprise_site_set_borders_single_template' );


/**
 * ?.? Filter Locations Single Templates
 *
 * Sets custom path for locations single.
 *
 * @param   string  $single_template   Template file for single
 *
 * @return  string  $single_template   Filtered template file for single
**/
function enterprise_site_set_locations_single_template( $single_template ) {
	global $post;

	if (
		! is_singular(
			array(
				'locations',
			)
		)
	) {
		return $single_template;
	}

	$single_template = dirname( __FILE__ ) . '/page-templates/single-locations.php';

	return $single_template;
}
add_filter( 'single_template', 'enterprise_site_set_locations_single_template' );


/**
 * ?.? Hide Custom Post Type Type Taxonomies Metaboxes
 *
 * Hides the generated taxonomy metaboxes for custom post types.
 * These values are controlled via ACF.
 *
**/
function enterprise_site_remove_custom_taxonomy_metabox() {
	remove_meta_box( 'resource_types' . 'div', 'resources', 'side' );
	remove_meta_box( 'news_types' . 'div', 'news', 'side' );
	remove_meta_box( 'origins' . 'div', 'borders', 'side' );
	remove_meta_box( 'destinations' . 'div', 'borders', 'side' );
}
add_action( 'admin_menu', 'enterprise_site_remove_custom_taxonomy_metabox' );


/**
 * ?.? Update Custom Post Type Rewrite Rules
 *
 * Updates default rewrite rules to include custom post type taxonomy specific
 * archive pages.
 *
 * @param obj    $wp_rewrite           WordPress rewrite object
 * @param array  $wp_rewrite->rules    Modified rewrite rules
 *
**/
function enterprise_site_taxonomy_rewrite( $wp_rewrite ) {
	$feed_rules = array(

		// Resource rules
		'resources/resource-types/([a-zA-Z_-]+)' => 'resources?resource_types=$matches[1]',
		'resources/needs/([a-zA-Z_-]+)'          => 'resources?needs=$matches[1]',
		'resources/regions/([a-zA-Z_-]+)'        => 'resources?regions=$matches[1]',
		'resources/industries/([a-zA-Z_-]+)'     => 'resources?industries=$matches[1]',

		// News rules
		'news/news-types/([a-zA-Z_-]+)'          => 'news?news_types=$matches[1]',
	);

	$wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;
	return $wp_rewrite->rules;
}
add_filter( 'generate_rewrite_rules', 'enterprise_site_taxonomy_rewrite' );


/**
 * ?.? Set Custom (YOAST) Breadcrumb Paths
 *
 * Updates the default YOAST breadcrumb path to include custom
 * page links (e.g. borders tool etc.).
 *
 * @param  array  $links  Array containing breadcrumb links (label and link).
 *
 * @return array  $links  Updated array containing breadcrumb links.
 *
**/
function enterprise_site_set_custom_breadcrumb_paths( $links ) {
	global $post;

	if ( is_singular( 'borders' ) ) {
		$breadcrumb[] = array(
			'url'  => '/borders/',
			'text' => 'Borders',
		);

		array_splice( $links, 1, -2, $breadcrumb );
	}

	if ( is_singular( 'locations' ) ) {
		$breadcrumb[] = array(
			'url'  => '/locations/',
			'text' => 'Locations',
		);

		array_splice( $links, 1, -2, $breadcrumb );
	}

	return $links;
}
add_filter( 'wpseo_breadcrumb_links', 'enterprise_site_set_custom_breadcrumb_paths' );


/**
 * ?.? Set Parot Plugin Post Types
 *
 * Sets the post types which should use the pardot plugin functionality.
 *
 * @param  str  $post_types  Associated post types (defaults to 'post').
 *
**/
function enterprise_site_set_br_pardot_post_types( $post_types ) {
	return 'resources';
}
add_filter( 'br_pardot_post_types', 'enterprise_site_set_br_pardot_post_types' );


/**
 * ?.? Update Custom Post Type Archive Title
 *
 * Updates custo post type archive tyle (inc. taxonomy archives) to use plural
 * label.
 *
 * @param string    $title    Archive title
 * @param string    $title    Modified archive title
 *
**/
function enterprise_site_filter_archive_title( $title ) {
	global $wp_query;
	$post_type = ( get_post_type() ) ?: $wp_query->query['post_type'];

	if (
		( 'resources' === $post_type || 'news' === $post_type )
		&& is_archive()
	) {
		$title = get_post_type_object( $post_type )->label;
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'enterprise_site_filter_archive_title' );

/**
 * ?.? Set Up Borders Weather Data Endpoint
 *
 * Maps borders weather data endpoint.
 *
**/
function enterprise_site_register_borders_weather_rest_route() {
	register_rest_route(
		'borders/v1',
		'/weather',
		array(
			'methods'  => 'GET',
			'callback' => 'enterprise_site_border_weather_endpoint',
		)
	);
}
add_action( 'rest_api_init', 'enterprise_site_register_borders_weather_rest_route' );


/**
 * ?.? Set Up Borders Weather Data Endpoint Return
 *
 * Sets ups the return associated w/ the borders weather data
 * when accessed through its rest route.
 *
 * @param  obj $wp_rest_server    Server object.
 *
 * @return obj $weather_data      JSON object containing border weather data.
 *
**/
function enterprise_site_border_weather_endpoint( $wp_rest_server ) {

	if ( empty( $wp_rest_server['city'] ) ) {
		return false; // Bail early if no city present
	}

	$api_key = ( get_field( 'api_key_weather_borders', 'options' ) ) ?: false;

	if ( ! $api_key ) {
		return false; // Bail early when no api key present
	}

	$request = wp_remote_get(
		"http://api.openweathermap.org/data/2.5/weather?q={$wp_rest_server['city']}&APPID={$api_key}&units=metric"
	);

	if ( is_wp_error( $request ) ) {
		return false; // Bail early on error
	}

	$weather_data = json_decode( wp_remote_retrieve_body( $request ) );

	if ( 200 !== $weather_data->cod ) {
		return false; // Bail early if on status code error
	}

	if ( ! empty( $weather_data ) ) {

		$weather_data = array(
			'expiry_time' => ( new DateTime() )->modify( '3 hours' )->format( 'U' ),
			'description' => ucwords( $weather_data->weather[0]->description ),
			'temp'        => round( $weather_data->main->temp ),
		);
	}

	return $weather_data;
}


/**
 * ?.? Add User Google API Key
 *
 * Adds user Google API key to ACF settings for use w/i theme.
 *
**/
function enterprise_site_set_google_api_key() {
	$api_key = ( get_field( 'api_key_google_maps_borders', 'options' ) ) ?: false;

	if ( ! $api_key ) {
		return;
	}

	acf_update_setting( 'google_api_key', $api_key );
}
add_action( 'acf/init', 'enterprise_site_set_google_api_key' );
