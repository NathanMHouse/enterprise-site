<?php
/**
 * Add ACF option pages (src)
 *
 * This file is only included in the admin interface
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

/**
 * Register options pages for ACF fields
 *
 * @since   1.0.0
 * @return  void
 */
function enterprise_site_add_options_pages() {

	// Only add options pages in the admin
	if ( ! is_admin() ) {
		return;
	}

	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	// Create the main menu entry (i.e. theme settings)
	$args = array(
		'page_title' => 'Theme Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug'  => 'enterprise_site_theme_settings',
		'capability' => 'manage_options',
	);
	acf_add_options_page( $args );

	$args = array(
		'page_title'  => 'General Settings',
		'menu_title'  => 'General Settings',
		'menu_slug'   => 'enterprise_site_general_settings',
		'capability'  => 'manage_options',
		'parent_slug' => 'enterprise_site_theme_settings',
	);
	acf_add_options_sub_page( $args );

	$args = array(
		'page_title'  => 'Header Settings',
		'menu_title'  => 'Header Settings',
		'menu_slug'   => 'enterprise_site_header_settings',
		'capability'  => 'manage_options',
		'parent_slug' => 'enterprise_site_theme_settings',

	);
	acf_add_options_sub_page( $args );

	$args = array(
		'page_title'  => 'Footer Settings',
		'menu_title'  => 'Footer Settings',
		'menu_slug'   => 'enterprise_site_footer_settings',
		'capability'  => 'manage_options',
		'parent_slug' => 'enterprise_site_theme_settings',
	);
	acf_add_options_sub_page( $args );

	$args = array(
		'page_title'  => 'Resources Settings',
		'menu_title'  => 'General Settings',
		'menu_slug'   => 'enterprise_site_resources_settings',
		'capability'  => 'manage_options',
		'parent_slug' => '/edit.php?post_type=resources',
	);
	acf_add_options_sub_page( $args );

	$args = array(
		'page_title'  => 'News Settings',
		'menu_title'  => 'Settings',
		'menu_slug'   => 'enterprise_site_news_settings',
		'capability'  => 'manage_options',
		'parent_slug' => '/edit.php?post_type=news',
	);
	acf_add_options_sub_page( $args );

	$args = array(
		'page_title'  => 'Glossary Settings',
		'menu_title'  => 'Settings',
		'menu_slug'   => 'enterprise_site_glossary_settings',
		'capability'  => 'manage_options',
		'parent_slug' => '/edit.php?post_type=terms',
	);
	acf_add_options_sub_page( $args );

	$args = array(
		'page_title'  => 'External Resources Settings',
		'menu_title'  => 'Settings',
		'menu_slug'   => 'enterprise_site_external_resources_settings',
		'capability'  => 'manage_options',
		'parent_slug' => '/edit.php?post_type=external_resources',
	);
	acf_add_options_sub_page( $args );

	$args = array(
		'page_title'  => 'Borders Settings',
		'menu_title'  => 'Settings',
		'menu_slug'   => 'enterprise_site_borders_settings',
		'capability'  => 'manage_options',
		'parent_slug' => '/edit.php?post_type=borders',
	);
	acf_add_options_sub_page( $args );

	$args = array(
		'page_title'  => 'Locations Settings',
		'menu_title'  => 'Settings',
		'menu_slug'   => 'enterprise_site_locations_settings',
		'capability'  => 'manage_options',
		'parent_slug' => '/edit.php?post_type=locations',
	);
	acf_add_options_sub_page( $args );
}
add_action( 'init', 'enterprise_site_add_options_pages' );
