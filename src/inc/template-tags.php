<?php
/**
 * Custom Template Tags (src)
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
1.0 Build Srcset Image
2.0 Build CTA Link
3.0 Create Custom ACF Excerpt
4.0 Build Term Link
5.0 Set CTA Attributes
6.0 Return Related Posts


/*--------------------------------------------------------------
1.0 Build Srcset Image
--------------------------------------------------------------*/
/**
 * Builds HTML output for img w/ support for srcset.
 *
 * @param $image_id    int    WordPress image ID.
 * @param $image_size  str    Base image size to retrieve.
 * @param $sizes       str    Expected size w/i browser. Can be a series,
 *                            defined by media conditions and separated by ','.
 * @param $classes     arr    Array of classes to apply to image.
 */
function enterprise_site_build_responsive_image( $image_id, $image_size = 'full', $sizes = '100vw', $classes ) {

	// Set/get image properties according arguments
	$image_src    = wp_get_attachment_image_url( $image_id, $image_size );
	$image_srcset = wp_get_attachment_image_srcset( $image_id, 'full' );
	$image_alt    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

	// Build the output
	$output  = '<img ';
	$output .= 'src="';
	$output .= $image_src;
	$output .= '" ';
	$output .= 'srcset="';
	$output .= $image_srcset;
	$output .= '" ';
	$output .= 'sizes="';
	$output .= $sizes;
	$output .= '" ';
	$output .= 'alt="';
	$output .= $image_alt;
	$output .= '" ';
	if ( $classes
		&& is_array( $classes ) ) {
		$output .= 'class="';
		$output .= implode( ' ', $classes );
		$output .= '" ';
	}
	$output .= '>';

	// Return the output
	return wp_kses(
		$output,
		array(
			'img' => array(
				'src'    => array(),
				'srcset' => array(),
				'sizes'  => array(),
				'alt'    => array(),
				'class'  => array(),
			),
		)
	);
}


/*--------------------------------------------------------------
2.0 Build CTA Link
--------------------------------------------------------------*/
/**
 * Build the HTML for a CTA link.
 *
 * @since   1.0.0
 * @param   string  $label             Link text to display.
 * @param   string  $url               Link URL.
 * @param   string  $style             primary, secondary, tertiary, or pseudo.
 * @param   string  $target            Target behaviour of link.
 * @param   string  $content           Modal content.
 *
 * @return  string  $output            HTML for the CTA.
 */
function enterprise_site_create_cta( $label, $url, $style, $target ) {

	// Check to make sure we have all our arguments
	if ( ! $label
		|| ! $url
		|| ! $style ) {

		return '';
	}

	$class  = 'btn ';
	$class .= "btn-$style";

	$output  = '<a ';
	$output .= 'href="';
	$output .= esc_url( $url );
	$output .= '" class="';
	$output .= esc_attr( $class );
	$output .= '" ';
	$output .= 'target="';
	$output .= esc_attr( $target );
	$output .= '">';
	$output .= wp_kses(
		$label,
		array(
			'br' => array(),
		)
	);
	$output .= '</a>';

	return $output;
}


/*--------------------------------------------------------------
?.? Create Custom ACF Excerpt
--------------------------------------------------------------*/
/**
 * Create custom excerpt that parses ACF
 *
 * @param interger    $length     Excerpt length.
 * @param object      $post_id    Post ID.
 *
 * @return string     $excerpt    Custom post excerpt.
**/
function enterprise_site_output_custom_excerpt( $length, $excerpt = false, $post_id = false ) {

	// Check if a post object has been passed (and set up post data if it has)
	if ( $post_id ) {

		// Set up the post data
		setup_postdata( $post_id );
	}

	// Get the excerpt
	$excerpt = ( ! $excerpt && $post_id )
		? wpautop( wp_strip_all_tags( get_the_content( $post_id ) ) )
		: $excerpt;

	// If no excerpt exists, look in ACF content
	if ( ! $excerpt ) {

		if ( have_rows( 'flexible_content' ) ) :

			// Loop and build excerpt only until excerpt reaches assigned length
			while ( have_rows( 'flexible_content' ) && strlen( $excerpt ) <= $length ) :

				the_row();

				// Strip html and concatenate string
				$excerpt .= wpautop( wp_strip_all_tags( get_sub_field( 'content' ), '<p>' ) );

			endwhile;

		endif;
	}

	// Format the returned excerpt
	$excerpt        = preg_replace( '/\.{3} <a.+<\/a>/', '', $excerpt );
	$excerpt        = substr( $excerpt, 0, $length );
	$trim_index_pos = strrpos( $excerpt, ' ' );
	$excerpt        = substr( $excerpt, 0, $trim_index_pos );
	$excerpt       .= ' ...';

	// Echo the excerpt
	echo wp_kses_post( $excerpt );
}


/*--------------------------------------------------------------
4.0 Build Term Link
--------------------------------------------------------------*/
/**
 * Builds HTML output for term link.
 *
 * @param int       $post        Post Object.
 * @param string    $taxonomy    Applicable from which to fetch term.
 */
function enterprise_site_build_term_badge( $post, $taxonomy ) {
	$post_id = ( $post ) ?: get_the_ID();

	if ( ! $post_id || ! $taxonomy ) {
		return;
	}

	$terms = get_the_terms( $post_id, $taxonomy );

	if ( ! $terms ) {
		return;
	}

	$term = array_shift( $terms );

	$output  = '<a ';
	$output .= 'href="';
	$output .= get_term_link( $term->slug, $taxonomy );
	$output .= '" ';
	$output .= 'class="taxonomy-link">';
	$output .= '<span ';
	$output .= 'class="taxonomy-link-icon taxonomy-link-icon-';
	$output .= $term->slug;
	$output .= '">';
	$output .= '</span>';
	$output .= '<span ';
	$output .= 'class="taxonomy-link-title">';
	$output .= $term->name;
	$output .= '</span>';
	$output .= '</a>';

	return wp_kses(
		$output,
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


/*--------------------------------------------------------------
5.0 Set CTA Attributes
--------------------------------------------------------------*/
/**
 * Set associated CTA attributes depending upon associated CTA behaviour.
 *
 * @param   array    $cta              CTA group parameters.
 *
 * @return  array    $cta_attributes   Defined CTA attributes.
 */
function enterprise_site_set_cta_attributes( $cta ) {

	// Set up initial CTA attributes array
	$cta_attributes = array(
		'cta_target'  => '',
		'cta_href'    => '',
		'cta_class'   => '',
		'cta_vid_src' => '',
		'cta_label'   => '',
	);

	// Set CTA attributes according to defined behaviour type
	switch ( $cta['target'] ) {

		case 'outer_page':
			$cta_attributes['cta_target']  = '_blank';
			$cta_attributes['cta_href']    = ( $cta['url'] ) ?: '';
			$cta_attributes['cta_class']   = 'outer-page-cta';
			$cta_attributes['cta_vid_src'] = '';
			$cta_attributes['cta_label']   = __( 'Read More', 'enterprise-site' );
			break;
		case 'video':
			$start    = ( strripos( $cta['video'], '/' ) )
				? strripos( $cta['video'], '/' ) + 1
				: 0;
			$video_id = substr( $cta['video'], $start );

			// Set video source attribute according to service
			if ( strpos( $cta['video'], 'vimeo' ) ) {
				$cta_vid_src = '//vimeo.com/' . $video_id;
			} elseif (
				strpos( $cta['video'], 'youtube' )
				|| strpos( $cta['video'], 'youtu.be' )
			) {
				$cta_vid_src = '//youtube.com/watch?v=' . $video_id;
			} else {
				$cta_vid_src = '';
			}

			$cta_attributes['cta_target']  = '_self';
			$cta_attributes['cta_href']    = '';
			$cta_attributes['cta_class']   = 'video-cta';
			$cta_attributes['cta_vid_src'] = $cta_vid_src;
			$cta_attributes['cta_label']   = __( 'Watch Video', 'enterprise-site' );
			break;
		case 'download':
			$cta_attributes['cta_target']  = '_self';
			$cta_attributes['cta_href']    = ( $cta['file'] ) ?: '';
			$cta_attributes['cta_class']   = 'download-cta';
			$cta_attributes['cta_vid_src'] = '';
			$cta_attributes['cta_label']   = __( 'Download', 'enterprise-site' );
			break;
		case 'inner_page':
		default:
			$cta_attributes['cta_target']  = '_self';
			$cta_attributes['cta_href']    = ( get_the_permalink() ) ?: '';
			$cta_attributes['cta_class']   = 'inner-page-cta';
			$cta_attributes['cta_vid_src'] = '';
			$cta_attributes['cta_label']   = __( 'Read More', 'enterprise-site' );
			break;
	}

	return $cta_attributes;
}


/*--------------------------------------------------------------
6.0 Return Related Posts
--------------------------------------------------------------*/
/**
 * ...
 *
 * @param   array    $current_post_id    Current post ID.
 * @param   array    $taxonomies         Array of post taxonomies.
 *
 * @return  array    $related_posts   Array of post IDs related to
 *                                    original post.
 */
function enterprise_site_return_related_posts( $current_post_id, $taxonomies = array() ) {

	/* Check to see if we've saved a version of the related posts.
	 * If not, generate them.
	 */
	$related_posts = get_transient( $current_post_id . '_related_posts' );

	if ( false === $related_posts ) {

		$related_posts = array();

		// Set up our query args.
		$args = array(
			'orderby'                => 'rand',
			'no_found_rows'          => true,
			'posts_per_page'         => 4,
			'post_status'            => array( 'publish' ),
			'post_type'              => get_post_type(),
			'tax_query'              => array(
				'relation' => 'OR',
			),
			'update_post_meta_cache' => false,
		);

		/* Build the associated tax query according to the associated
		 * taxonmy and terms.
		 */
		foreach ( $taxonomies as $taxonomy ) {

			$terms = wp_get_post_terms(
				$current_post_id,
				$taxonomy,
				array(
					'fields' => 'slugs',
				)
			);

			if ( $terms ) {
				$args['tax_query'][] = array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $terms,
				);
			}
		}

		$related_posts_query = new WP_Query( $args );
		$count               = 0;

		// Grab 3 related posts (excluded current post).
		if ( $related_posts_query->have_posts() ) {
			while ( $related_posts_query->have_posts() && $count < 3 ) {

				$related_posts_query->the_post();
				$related_post_id = get_the_ID();
				if ( $related_post_id === $current_post_id ) {
					continue;
				} else {
					$related_posts[] = $related_post_id;
					$count++;
				}
			}
		}

		if ( $related_posts ) {

			// Save our related posts (5 minutes/post-specific).
			set_transient(
				$current_post_id . '_related_posts',
				$related_posts,
				5 * MINUTE_IN_SECONDS
			);
		}
	}

	return $related_posts;
}
