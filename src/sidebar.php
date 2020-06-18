<?php
/**
 * Sidebar Template
 *
 * The template for the main widget area (src).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */

/* Sidebars are activated and inialized w/i functions file.
 * Add/remove as appropriate.
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
