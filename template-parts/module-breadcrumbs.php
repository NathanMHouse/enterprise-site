<?php
/**
 * Breadcrumbs Module
 *
 * Module template for displaying the breadcrumbs (powered by YOAST) (dist).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

if ( function_exists( 'yoast_breadcrumb' ) ) {
	?>
	<section class="module-breadcrumbs">
		<div class="grid-container">
			<?php
			yoast_breadcrumb();
			?>
		</div><!-- .grid-container -->
	</section><!-- .module-breadcrumbs -->
	<?php
}
