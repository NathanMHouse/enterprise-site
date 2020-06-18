<?php
/**
 * Content Page Template
 *
 * Content template part for displaying page content (dist).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */
?>
<div class="grid-container">
	<article
		id="post-<?php the_ID(); ?>"
		<?php post_class( array( 'grid-x', 'padding-both' ) ); ?>
	>
		<div class="cell medium-12">
			<?php
			the_content();
			?>
		</div><!-- .cell -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .grid-container -->
