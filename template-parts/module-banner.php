<?php
/**
 * Banner Module
 *
 * Module template for displaying the page banner (background image, title,
 * and description) (dist).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

if (
	is_singular(
		array(
			'borders',
			'locations',
		)
	)
) {

	// Single for tools (border or location only).
	$image_type       = 'background';
	$title            = ( get_the_title() ) ?: '';
	$background_image = ( get_post_thumbnail_id() )
		? get_post_thumbnail_id()
		: get_field( 'banner_background_image_' . preg_replace( '/-/', '_', get_post_type() ), 'options' );
	$description      = false;
	$banner_class     = ( $background_image && 'background' === $image_type )
		? 'module-row-banner module-row-banner-w-background-image module-row-banner-single module-banner-single-' . get_post_type()
		: 'module-row-banner module-row-banner-wo-background-image module-row-banner-single module-banner-single-' . get_post_type();

} elseif ( is_page_template( 'page-templates/template-tools.php' ) ) {

	// Archive for tools.
	$image_type       = 'background';
	$title            = ( get_the_title() ) ?: '';
	$background_image = ( get_field( 'banner_background_image_' . preg_replace( '/-/', '_', get_post_field( 'post_name' ) ), 'options' ) )
		?: false;
	$description      = ( get_field( 'banner_description_' . preg_replace( '/-/', '_', get_post_field( 'post_name' ) ), 'options' ) )
		?: '';
	$banner_class     = ( $background_image )
		? 'module-row-banner module-row-banner-w-background-image module-row-banner-tool'
		: 'module-row-banner module-row-banner-wo-background-image module-row-banner-tool';
} elseif (
	is_post_type_archive()
	|| is_tax()
) {

	// Archive page (general or taxonomy).
	$post_type        = ( get_post_type() ) ?: $wp_query->query['post_type'];
	$image_type       = 'background';
	$title            = ( get_the_archive_title() ) ?: '';
	$background_image = ( get_field( 'banner_background_image_' . $post_type, 'options' ) ) ?: false;
	$description      = ( get_field( 'banner_description_' . $post_type, 'options' ) ) ?: '';
	$banner_class     = ( $background_image )
		? 'module-row-banner module-row-banner-w-background-image module-row-banner-archive'
		: 'module-row-banner module-row-banner-wo-background-image module-row-banner-archive';
} elseif ( is_single() ) {

	// Single page (general).
	$image_type = ( is_object( $post ) )
		? get_post_meta( $post->ID, '_enterprise_site_featured_image_type', true )
		: get_post_meta( $post, '_enterprise_site_featured_image_type', true );
	$title      = ( get_the_title() ) ?: '';

	// Single page fall back to archive banner if no featured image present.
	$background_image = ( get_post_thumbnail_id() )
		? get_post_thumbnail_id()
		: get_field( 'banner_background_image_' . preg_replace( '/-/', '_', get_post_type() ), 'options' );
	$description      = false;
	$banner_class     = ( $background_image && 'background' === $image_type )
		? 'module-row-banner module-row-banner-w-background-image module-row-banner-single '
		: 'module-row-banner module-row-banner-wo-background-image module-row-banner-single';
} elseif ( is_search() ) {

	// Search.
	$image_type = 'background';
	$title      = sprintf(
		/* translators: %s: search phrase */
		__( 'Search Results for &#8220;%s&#8221;' ),
		get_search_query()
	);
	$background_image = ( get_field( 'banner_background_image_search', 'options' ) ) ?: false;
	$description      = false;
	$banner_class     = ( $background_image )
		? 'module-row-banner module-row-banner-w-background-image module-row-banner-search'
		: 'module-row-banner module-row-banner-wo-background-image module-row-banner-search';
} elseif ( is_404() ) {

	// 404.
	$image_type       = 'background';
	$title            = __( '404 Error', 'enterprise-site' );
	$background_image = ( get_field( 'banner_background_image_404', 'options' ) ) ?: false;
	$description      = ( get_field( 'banner_description_404', 'options' ) ) ?: false;
	$banner_class     = ( $background_image )
		? 'module-row-banner module-row-banner-w-background-image module-row-banner-404'
		: 'module-row-banner module-row-banner-wo-background-image module-row-banner-404';

} else {

	// Other.
	$image_type       = 'background';
	$title            = ( get_the_title() ) ?: '';
	$background_image = ( get_field( 'background_image' ) ) ?: false;
	$description      = ( get_field( 'description' ) ) ?: '';
	$banner_class     = ( $background_image )
		? 'module-row-banner module-row-banner-w-background-image'
		: 'module-row-banner module-row-banner-wo-background-image';
	$banner_style     = '';
}
?>
<header
	class="<?php echo esc_attr( $banner_class ); ?>"
	style="
	<?php
	if ( $background_image ) {
		?>
		background:
			linear-gradient(
				rgba(0,0,0,0.5),
				rgba(0,0,0,0.5)
			), 
			url(
				<?php
					echo ( $background_image && 'background' === $image_type )
						? esc_attr( wp_get_attachment_image_src( $background_image, 'full' )[0] )
						: '';
				?>
	) no-repeat 50% / cover
		<?php
	}
	?>
">
	<div class="grid-container">
		<div class="grid-x grid-margin-x">

			<?php
			if ( $title ) {
				?>
				<div class="cell medium-6 medium-offset-3">
					<h1 class="module-row-banner-title"><?php echo esc_html( $title ); ?></h1><!-- .module-row-banner-title -->
				</div><!-- .cell -->
				<?php
			}

			if ( $description ) {
				?>
				<div class="cell medium-8 medium-offset-2">
					<h3 class="module-row-banner-description">
						<?php
						echo wp_kses(
							$description,
							array(
								'br' => array(
									'class' => array(),
								),
							)
						);
						?>
					</h3><!-- .module-row-banner-description -->
				</div><!-- .cell -->
				<?php
			}
			?>
		</div><!-- .grid-x -->
	</div><!-- .grid-container -->
</header><!-- .module-row-banner -->
