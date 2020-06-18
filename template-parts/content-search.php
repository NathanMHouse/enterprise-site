<?php
/**
 * Content Search Template
 *
 * Content template part for displaying results in search pages (dist).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

?>
<article
	id="post-<?php the_ID(); ?>"
	<?php post_class( array( 'search-excerpt', 'excerpt', 'cell', 'medium-4' ) ); ?>
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
		class="search-excerpt-header excerpt-header <?php echo esc_attr( $header_class ); ?>"
		style="background-image: url(<?php echo ( $image_url ) ? esc_attr( $image_url ) : ''; ?>);" >
		<?php
		$taxonomy = ( get_object_taxonomies( get_post_type() ) )
			? get_object_taxonomies( get_post_type() )[0]
			: false;

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
	</header><!-- .search-excerpt-header -->

	<section class="search-excerpt-main excerpt-main">
		<header class="search-excerpt-main-header excerpt-main-header">
			<ul class="search-excerpt-main-header-meta excerpt-main-header-meta">
				<li class="search-excerpt-main-header-meta-date excerpt-main-header-meta-date">
					<?php echo get_the_date( 'F j, Y' ); ?>
				</li><!-- .search-excerpt-main-header-meta-date -->
				<li class="search-excerpt-main-header-meta-author excerpt-main-header-meta-author">
					<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
				</li><!-- .search-posts-excerpt-main-header-meta-author -->
			</ul><!-- .search-posts-excerpt-main-header-meta -->
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
					'<h3 data-equalizer-watch="title" class="search-excerpt-main-header-title excerpt-main-header-title"><a href="%1$s" rel="bookmark" class="%2$s" target="%3$s" data-fancybox-src="%4$s">',
					$cta_attributes['cta_href'],
					$cta_attributes['cta_class'],
					$cta_attributes['cta_target'],
					$cta_attributes['cta_vid_src']
				),
				'</a></h3>'
			);
			?>
		</header><!-- .search-excerpt-main-header -->
		<div
			class="search-excerpt-main-excerpt excerpt-main-excerpt"
			data-equalizer-watch="excerpt"
		>
			<?php
			if ( has_post_thumbnail() ) {
				enterprise_site_output_custom_excerpt( 200, false, $post );
			} else {
				enterprise_site_output_custom_excerpt( 400, false, $post );
			}
			?>
		</div><!-- .search-excerpt-main-excerpt -->
	</section><!-- .search-excerpt-main -->

	<footer class="search-excerpt-footer excerpt-footer">
		<a
			href="<?php echo esc_attr( $cta_attributes['cta_href'] ); ?>"
			class="search-excerpt-footer-link excerpt-footer-link <?php echo esc_attr( $cta_attributes['cta_class'] ); ?>"
			target="<?php echo esc_attr( $cta_attributes['cta_target'] ); ?>"
			data-fancybox-src="<?php echo esc_attr( $cta_attributes['cta_vid_src'] ); ?>"
		>
		<?php
		echo esc_html( $cta_attributes['cta_label'] );
		?>
		</a><!-- .search-excerpt-footer-link -->
	</footer><!-- .search-excerpt-footer -->
</article><!-- .search-excerpt -->
