<?php
/**
 * Single Custom Post Template
 *
 * The template for displaying single custom posts (src).
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
<section class="custom-posts-single padding-both">
	<div class="grid-container">
		<?php
		include( locate_template( '/template-parts/content-custom-posts.php', false, false ) );
		?>
	</div><!-- .grid-container -->
</section><!-- .custom-posts-single -->

<?php
include( locate_template( '/template-parts/module-related-content.php', false, false ) );
include( locate_template( '/template-parts/module-global-cta.php', false, false ) );
get_footer();
