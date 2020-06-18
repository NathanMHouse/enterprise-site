<?php
/**
 * Content Custom Post Excerpt Template
 *
 * Content template part for displaying custom post excerpts (src).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */
?>
<article
	id="custom-posts-<?php the_ID(); ?>"
	<?php post_class( array( 'custom-posts-excerpt', 'excerpt', 'cell', 'medium-4' ) ); ?>
	data-equalizer-watch="post"
>
	<?php
	$image_type = ( is_object( $post ) )
		? get_post_meta( $post->ID, '_enterprise_site_featured_image_type', true )
		: get_post_meta( $post, '_enterprise_site_featured_image_type', true );
	$image_url  = ( get_the_post_thumbnail_url( $post, 'large' ) )
		?: false;

	// Set header
	switch ( $image_type ) {
		case 'background':
			if ( has_post_thumbnail() ) {
				$header_class = 'excerpt-header-w-image background';
			} else {
				$header_class = 'excerpt-header-wo-image';
			}
			break;
		case 'icon':
			if ( has_post_thumbnail() ) {
				$header_class = 'excerpt-header-w-image icon';
			} else {
				$header_class = 'excerpt-header-wo-image';
			}
			break;
		default:
			if ( has_post_thumbnail() ) {
				$header_class = 'excerpt-header-w-image background';
			} else {
				$header_class = 'excerpt-header-wo-image';
			}
	}
	?>
	<header
		class="custom-posts-excerpt-header excerpt-header <?php echo esc_attr( $header_class ); ?>"
		style="background-image: url(<?php echo ( $image_url ) ? esc_attr( $image_url ) : ''; ?>);" >
		<?php
		$taxonomy = get_object_taxonomies( get_post_type() )[0];

		if ( $taxonomy ) {
			echo wp_kses(
				enterprise_site_build_term_badge( $post, $taxonomy ),
				array(
					'a'    => array(
						'href'  => array(),
						'class' => array(),
					),
					'span' => array(
						'class' => array(),
					),
				)
			);
		}
		?>
	</header><!-- .custom-posts-excerpt-header -->

	<section class="custom-posts-excerpt-main excerpt-main">
		<header class="custom-posts-excerpt-main-header excerpt-main-header">
			<ul class="custom-posts-excerpt-main-header-meta excerpt-main-header-meta">

				<?php
				$date_toggle = ( 'date_false' === get_field( 'date_toggle' ) )
				? false
				: true;

				if ( $date_toggle ) {
					?>
					<li class="custom-posts-excerpt-main-header-meta-date excerpt-main-header-meta-date">
						<?php
						echo get_the_date( 'F j, Y' );
						?>
					</li><!-- .custom-posts-excerpt-main-header-meta-date -->
					<?php
				}
				?>

				<li class="custom-posts-excerpt-main-header-meta-author excerpt-main-header-meta-author">
					<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
				</li><!-- .custom-posts-excerpt-main-header-meta-author -->
			</ul><!-- .custom-posts-excerpt-main-header-meta -->
			<?php
			$cta            = ( get_field( 'cta' ) ) ?: array(
				'target' => '',
				'video'  => '',
				'url'    => '',
				'file'   => '',
			);
			$cta_attributes = enterprise_site_set_cta_attributes( $cta );

			the_title(
				sprintf(
					'<h3 data-equalizer-watch="title" class="custom-posts-excerpt-main-header-title excerpt-main-header-title"><a href="%1$s" rel="bookmark" class="%2$s" target="%3$s" data-fancybox-src="%4$s">',
					$cta_attributes['cta_href'],
					$cta_attributes['cta_class'],
					$cta_attributes['cta_target'],
					$cta_attributes['cta_vid_src']
				),
				'</a></h3>'
			);
			?>
		</header><!-- .custom-posts-excerpt-main-header -->
		<div
			class="custom-posts-excerpt-main-excerpt excerpt-main-excerpt"
			data-equalizer-watch="excerpt"
		>
			<?php
			if ( has_post_thumbnail() ) {
				enterprise_site_output_custom_excerpt( 200, false, $post );
			} else {
				enterprise_site_output_custom_excerpt( 400, false, $post );
			}
			?>
		</div><!-- .custom-posts-excerpt-main-excerpt -->
	</section><!-- .custom-posts-excerpt-main -->

	<footer class="custom-posts-excerpt-footer excerpt-footer">
		<a
			href="<?php echo esc_attr( $cta_attributes['cta_href'] ); ?>"
			class="custom-posts-excerpt-footer-link excerpt-footer-link <?php echo esc_attr( $cta_attributes['cta_class'] ); ?>"
			target="<?php echo esc_attr( $cta_attributes['cta_target'] ); ?>"
			data-fancybox-src="<?php echo esc_attr( $cta_attributes['cta_vid_src'] ); ?>"
		>
		<?php
		echo esc_html( $cta_attributes['cta_label'] );
		?>
		</a><!-- .custom-posts-excerpt-footer-link -->
	</footer><!-- .custom-posts-excerpt-footer -->
</article><!-- .custom-posts-excerpt -->
