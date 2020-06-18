<?php
/**
 * Footer Template
 *
 * The template for displaying the footer (src).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */

/* The footer menus setup.
 * Define an array of menu location slugs for footer.
 */
$footer_menu_locations = array(
	'footer_top_branding',
	'footer_top_left',
	'footer_top_middle',
	'footer_top_right',
	'footer_bottom_contact_details',
	'footer_bottom_left',
	'footer_bottom_middle',
	'footer_bottom_social',
	// Add additional menus as needed.
);

// Get all the menus in order to look up the title.
$all_menus = wp_get_nav_menus();

// Get all menu locations.
$all_locations = get_nav_menu_locations();

// Store the footer menus.
$footer_menus = array();

// Loop through array of defined footer menu locations.
foreach ( $footer_menu_locations as $location ) {

	// Get the menu.
	$footer_menus[ $location ]['menu'] = wp_nav_menu(
		array(
			'theme_location' => $location,
			'container'      => null,
			'echo'           => false,
			'depth'          => 1,
			'items_wrap'     => '%3$s',
			'fallback_cb'    => false,
		)
	);
}
?>
	</main><!-- .site-content -->
	<footer class="site-footer">
		<div class="grid-container">

			<section class="site-footer-top grid-x grid-margin-x">

				<div class="site-footer-top-branding cell medium-3">
					<?php
					$menu         = wp_get_nav_menu_object( 'footer-branding-menu' );
					$company_logo = ( function_exists( 'get_field' ) && get_field( 'company_logo', $menu ) )
						? get_field( 'company_logo', $menu )
						: array(
							'url' => 'https://placeholder.pics/svg/100x100',
							'alt' => 'Footer Company logo.',
						);

					if ( $company_logo ) {
						?>
						<img
							src="<?php echo esc_attr( $company_logo['url'] ); ?>" 
							alt="<?php echo esc_attr( $company_logo['alt'] ); ?>"
							class="site-footer-company-logo"
						>
						<?php

						// Fall back to site name when no logo present.
					} else {
						?>
						<h2 class="site-footer-logo-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h2>
						<?php
					}

					$seo_copy = ( function_exists( 'get_field' ) && get_field( 'seo_copy', $menu ) )
						? get_field( 'seo_copy', $menu )
						: '';

					if ( $seo_copy ) {
						?>
						<p class="site-footer-seo-copy"><?php echo esc_html( $seo_copy ); ?></p>
						<?php
					}

					$award_logo = ( function_exists( 'get_field' ) && get_field( 'award_logo', $menu ) )
						? get_field( 'award_logo', $menu )
						: array(
							'url' => 'https://placeholder.pics/svg/50x50',
							'alt' => 'Footer Award logo.',
						);

					if ( $award_logo ) {
						?>
						<img
							src="<?php echo esc_attr( $award_logo['url'] ); ?>" 
							alt="<?php echo esc_attr( $award_logo['alt'] ); ?>"
							class="site-footer-award-logo"
						>
						<?php
					}
					?>
				</div><!-- .site-footer-top-branding -->

				<?php
				if ( $footer_menus['footer_top_left']['menu'] ) {
					$menu  = wp_get_nav_menu_object( 'footer-services-menu' );
					$title = ( function_exists( 'get_field' ) && get_field( 'title', $menu ) )
						? get_field( 'title', $menu )
						: '';
					?>
					<ul class="site-footer-top-left site-footer-list-menu cell medium-3">
						<li>
							<h5 class="site-footer-list-menu-title"><a href="<?php echo esc_attr( $title['url'] ); ?>"><?php echo esc_html( $title['title'] ); ?></a></h5>
						</li>
						<?php
						echo wp_kses(
							$footer_menus['footer_top_left']['menu'],
							array(
								'ul' => array(
									'class' => array(),
								),
								'li' => array(
									'id'    => array(),
									'class' => array(),
								),
								'a'  => array(
									'href' => array(),
								),
							)
						);
						?>
					</ul><!-- .site-footer-top-left -->
					<?php
				}

				if ( $footer_menus['footer_top_middle']['menu'] ) {
					$menu  = wp_get_nav_menu_object( 'footer-needs-pains-menu' );
					$title = ( function_exists( 'get_field' ) && get_field( 'title', $menu ) )
						? get_field( 'title', $menu )
						: '';
					?>
					<ul class="site-footer-top-middle site-footer-list-menu cell medium-3">
						<li>
							<h5 class="site-footer-list-menu-title"><a href="<?php echo esc_attr( $title['url'] ); ?>"><?php echo esc_html( $title['title'] ); ?></a></h5>
						</li>
						<?php
						echo wp_kses(
							$footer_menus['footer_top_middle']['menu'],
							array(
								'ul' => array(
									'class' => array(),
								),
								'li' => array(
									'id'    => array(),
									'class' => array(),
								),
								'a'  => array(
									'href' => array(),
								),
							)
						);
						?>
					</ul><!-- .site-footer-top-middle -->
					<?php
				}

				if ( $footer_menus['footer_top_right']['menu'] ) {
					$menu  = wp_get_nav_menu_object( 'footer-resources-menu' );
					$title = ( function_exists( 'get_field' ) && get_field( 'title', $menu ) )
						? get_field( 'title', $menu )
						: '';
					?>
					<ul class="site-footer-top-right site-footer-list-menu cell medium-3">
						<li>
							<h5 class="site-footer-list-menu-title"><a href="<?php echo esc_attr( $title['url'] ); ?>"><?php echo esc_html( $title['title'] ); ?></a></h5>
						</li>
						<?php
						echo wp_kses(
							$footer_menus['footer_top_right']['menu'],
							array(
								'ul' => array(
									'class' => array(),
								),
								'li' => array(
									'id'    => array(),
									'class' => array(),
								),
								'a'  => array(
									'href' => array(),
								),
							)
						);
						?>
					</ul><!-- .site-footer-top-right -->
					<?php
				}
				?>
			</section><!-- .site-footer-top -->

			<section class="site-footer-bottom grid-x grid-margin-x">
				<?php
				$menu            = wp_get_nav_menu_object( 'footer-contact-details-menu' );
				$contact_details = ( get_field( 'contact_details', $menu ) ) ?: '';

				if ( $contact_details['address'] ) {
					?>
					<div class="site-footer-bottom-contact-details cell medium-3">
						<h5 class="site-footer-list-menu-title"><?php echo esc_html( $contact_details['title'] ); ?></h5>
						<p>
							<?php
							echo wp_kses(
								$contact_details['address'],
								array(
									'br' => array(
										'class' => array(),
									),
								)
							);
							?>
						</p>
					</div><!-- .site-footer-bottom-contact-details -->
					<?php
				}

				if ( $footer_menus['footer_bottom_left']['menu'] ) {
					$menu  = wp_get_nav_menu_object( 'footer-about-us-menu' );
					$title = ( function_exists( 'get_field' ) && get_field( 'title', $menu ) )
						? get_field( 'title', $menu )
						: '';
					?>
					<ul class="site-footer-bottom-left site-footer-list-menu cell medium-3">
						<li>
							<h5 class="site-footer-list-menu-title"><a href="<?php echo esc_attr( $title['url'] ); ?>"><?php echo esc_html( $title['title'] ); ?></a></h5>
						</li>
						<?php
						echo wp_kses(
							$footer_menus['footer_bottom_left']['menu'],
							array(
								'ul' => array(
									'class' => array(),
								),
								'li' => array(
									'id'    => array(),
									'class' => array(),
								),
								'a'  => array(
									'href' => array(),
								),
							)
						);
						?>
					</ul><!-- .site-footer-bottom-address -->
					<?php
				}

				if ( $footer_menus['footer_bottom_middle']['menu'] ) {
					$menu  = wp_get_nav_menu_object( 'footer-login-menu' );
					$title = ( function_exists( 'get_field' ) && get_field( 'title', $menu ) )
						? get_field( 'title', $menu )
						: '';
					?>
					<ul class="site-footer-bottom-middle site-footer-list-menu cell medium-3">
						<li>
							<h5 class="site-footer-list-menu-title"><a href="<?php echo esc_attr( $title['url'] ); ?>"><?php echo esc_html( $title['title'] ); ?></a></h5>
						</li>
						<?php
						echo wp_kses(
							$footer_menus['footer_bottom_middle']['menu'],
							array(
								'ul' => array(
									'class' => array(),
								),
								'li' => array(
									'id'    => array(),
									'class' => array(),
								),
								'a'  => array(
									'href' => array(),
								),
							)
						);
						?>
					</ul><!-- .site-footer-bottom-address -->
					<?php
				}

				$menu = wp_get_nav_menu_object( 'footer-social-menu' );

				/* The footer menus setup (social).
				 * Set vars.
				 */
				$social_media = ( function_exists( 'get_field' ) )
					? get_field( 'social_media', $menu )
					: array(
						'facebook' => array(
							'url'        => 'https://facebook.com',
							'icon_class' => 'facebook',
						),
						'twitter'  => array(
							'url'        => 'https://twitter.com',
							'icon_class' => 'twitter',
						),
						'linkedin' => array(
							'url'        => 'https://linkedin.com',
							'icon_class' => 'linkedin',
						),
						'youtube'  => array(
							'url'        => 'https://youtube.com',
							'icon_class' => 'youtube',
						),
					);

				// Define a list of supported social media services.
				$social_media_services = array(
					'facebook',
					'twitter',
					'linkedin',
					'youtube',
					// Add aditional social services as needed.
				);

				// Create empty var to contain our social menu output.
				$social_menu = '';

				// Check if a URL has been provided for the service.
				foreach ( $social_media_services as $service ) {

					// Get the URL.
					$link = ( $social_media[ $service ] )
						? 'https://' . $social_media[ $service ]['url'] . '.com'
						: '';

					if ( $link ) {

						// Build the menu item.
						$social_menu .= '<li><a href="' . $link . '"><i class="fab fa-2x fa-';
						$social_menu .= $social_media[ $service ]['icon_class'];
						$social_menu .= '"></i></a></li> ';
					}
				}

				if ( $social_menu ) {
					$title = ( function_exists( 'get_field' ) && get_field( 'title', $menu ) )
						? get_field( 'title', $menu )
						: '';
					?>
				<ul class="site-footer-bottom-social site-footer-list-menu cell medium-3">
					<li><h5 class="site-footer-list-menu-title"><?php echo esc_html( $title ); ?></h5></li>
					<?php
					echo wp_kses(
						$social_menu,
						array(
							'li' => array(),
							'a'  => array(
								'href' => array(),
							),
							'i'  => array(
								'class' => array(),
							),
						)
					);
					?>
				</ul><!-- .site-footer-bottom-social -->
					<?php
				}
				?>
			</section><!-- .site-footer-bottom -->

			<?php
			$menu = wp_get_nav_menu_object( 'footer-legal-menu' );
			$link = ( function_exists( 'get_field' ) && get_field( 'link', $menu ) )
						? get_field( 'link', $menu )
						: '';

			if ( $link['title'] ) {
				?>
				<section class="site-footer-legal grid-x grid-margin-x">
					<p class="cell medium-12"><a href="<?php echo esc_attr( $link['url'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a> | &copy; 2010-<?php echo esc_html( date( 'Y' ) ); ?> Enterprise-Site</p>
				</section><!-- .site-footer-legal -->
				<?php
			}

			get_template_part( 'template-parts/module', 'scroll-top' );
			?>
		</div><!-- .grid-container -->
	</footer><!-- .site-footer -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
