<?php
/**
 * Custom Posts Archive
 *
 * The template for displaying the custom post type archive pages (src).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */

get_header();

include( locate_template( '/template-parts/module-banner.php', false, false ) );
include( locate_template( '/template-parts/module-breadcrumbs.php', false, false ) );
include( locate_template( '/template-parts/module-archive-filter.php', false, false ) );

$post_type = ( get_post_type() )
	?: 'none';
?>

<section class="custom-posts-archive custom-posts-archive-<?php echo esc_attr( $post_type ); ?> archives padding-both">
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
					class="custom-posts-archive-row custom-posts-archive-row-<?php echo esc_attr( $row_count ); ?> archive-row grid-container"
					data-equalizer="title"
					data-equalizer-on="medium"
					data-equalize-by-row="true">
					<div
						class="grid-x grid-margin-x"
						data-equalizer="excerpt"
						data-equalizer-on="medium"
						data-equalize-by-row="true"
					>
						<?php
			}
							the_post();
							get_template_part( 'template-parts/content', 'custom-posts-excerpt' );

							$post_count++;
			if ( 0 === $post_count % 3 ) {
				?>
					</div><!-- .grid-x -->
				</div><!-- .custom-posts-archive-row -->	
				<?php
			}
		}
		?>

		<?php
	} else {
		?>
		<div class="custom-posts-archive-row-none custom-posts-archive-row archive-row grid-container">
			<div class="grid-x grid-margin-x">
				<?php
				get_template_part( 'template-parts/content', 'none' );
				?>
			</div><!-- .grid-x -->
		</div><!-- .custom-posts-archive-row-none -->
		<?php
	}
	?>
</section><!-- .custom-posts-archive-<?php echo esc_html( get_post_type() ); ?> -->

<div class="site-content-loader grid-container hide">
	<div class="grid-x">
		<div class="small-12">
			<div class="site-content-loader-icon"></div>
		</div><!-- .site-content-loader -->
	</div><!-- .grid-x -->
</div><!-- .medium-12 -->

<noscript>
	<nav class="custom-posts-archive-pagination archive-pagination grid-container">
		<div class="grid-x grid-margin-x">
			<?php
			posts_nav_link(
				' — '
			);
			?>
		</div><!-- .grid-x -->
	</nav><!-- .custom-posts-archive-pagination -->
</noscript>

<?php
include( locate_template( '/template-parts/module-global-cta.php', false, false ) );
get_footer();
