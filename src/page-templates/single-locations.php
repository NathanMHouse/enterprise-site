<?php
/**
 * Single Locations Post Template
 *
 * The template for displaying single locations posts (src).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */
get_header();

include( locate_template( '/template-parts/module-banner.php', false, false ) );
include( locate_template( '/template-parts/module-breadcrumbs.php', false, false ) );
?>
<section class="locations-single padding-both">
	<div class="grid-container">
		<?php
		include( locate_template( '/template-parts/content-locations.php', false, false ) );
		?>
	</div><!-- .grid-container -->
</section><!-- .locations-single -->

<?php
include( locate_template( '/template-parts/module-tools-cta-row.php', false, false ) );
include( locate_template( '/template-parts/module-global-cta.php', false, false ) );
get_footer();
