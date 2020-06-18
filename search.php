<?php
/**
 * Search Template
 *
 * The template for displaying search results (dist).
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
<section class="search-archive archives padding-both">
	<?php

	if ( have_posts() ) {
		$post_count = 0;
		$row_count  = 0;

		while ( have_posts() ) {
			if (
				0 === $post_count % 3
				|| 0 === $post_count
			) {
				$row_count++;
				?>
				<div
					class="search-archive-row search-archive-row-<?php echo esc_attr( $row_count ); ?> archive-row grid-container"
					data-equalizer="title"
					data-equalizer-on="medium"
					data-equalize-by-row="true"
				>
					<div
						class="grid-x grid-margin-x"
						data-equalizer="excerpt"
						data-equalizer-on="medium"
						data-equalize-by-row="true"
					>
						<?php
			}
						the_post();
						get_template_part( 'template-parts/content', 'search' );

						$post_count++;

			if ( 0 === $post_count % 3 ) {
				?>
					</div><!-- .grid-x -->
				</div><!-- .search-archive-row -->
				<?php
			}
		}
	} else {
		?>
		<div class="search-archive-row-none search-archive-row archive-row grid-container">
			<div class="grid-x grid-margin-x">
				<?php
				get_template_part( 'template-parts/content', 'none' );
				?>
			</div><!-- .grid-x -->
		</div><!-- .search-archive-row-none -->
		<?php
	}
	?>
</section><!-- .search-archive -->

<noscript>
<nav class="search-archive-pagination archive-pagination grid-container">
	<div class="grid-x grid-margin-x">
		<?php
		posts_nav_link(
			' — '
		);
		?>
	</div><!-- .grid-x -->
</nav><!-- .search-archive-pagination -->
</noscript>

<div class="site-content-loader hide">
	<div class="site-content-loader-icon">
	</div>
</div>

<?php
include( locate_template( '/template-parts/module-global-cta.php', false, false ) );
get_footer();
