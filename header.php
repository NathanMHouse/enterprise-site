<?php
/**
 * Header Template
 *
 * The header file (dist).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 *
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- [if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<?php

	// Require necessary custom walker class.
	require get_template_directory() . '/inc/class-enterprise-site-walker-mega-menu.php';

	// Define the primary header menu.
	$header_menu_locations['header_primary'] = wp_nav_menu(
		array(
			'theme_location' => 'header_primary',
			'container'      => null,
			'echo'           => false,
			'depth'          => 2,
			'items_wrap'     => '<ul class="site-header-primary-navigation-items cell large-7">%3$s</ul>',
			'fallback_cb'    => false,
			'walker'         => new Enterprise_Site_Walker_Mega_Menu(),
		)
	);
	?>

	<header class="site-header-secondary">
		<div class="grid-container">

			<ul class="site-header-secondary-items grid-x align-right">
				<?php
				$menu = wp_get_nav_menu_object( 'header-secondary-menu' );

				$company_logo = ( function_exists( 'get_field' ) && get_field( 'company_logo', $menu ) )
					? get_field( 'company_logo', $menu )
					: array(
						'url' => 'https://placeholder.pics/svg/200x80',
						'alt' => 'Header logo.',
					);

				if ( $company_logo ) {
					?>
					<li class="site-header-secondary-item site-header-secondary-item-branding">
						<a href="/">
							<img
								src="<?php echo esc_attr( $company_logo['url'] ); ?>"
								alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
							>
						</a>
					</li><!-- .site-header-secondary-item-branding -->
					<?php
				} else {
					?>
					<li>
						<h1><a href="/"><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></a></h1>
					</li>
				<?php } ?>

				<?php
				$track_cta = ( get_field( 'track_cta', $menu ) ) ?: '';
				?>
				<li class="site-header-secondary-item site-header-secondary-item-track">
					<button
						class="drawer-button"
						id="track"
						data-drawer="#track-form"><?php echo esc_html( $track_cta['title'] ); ?></button>
				</li><!-- .site-header-secondary-item-track -->

				<?php
				$search_cta = ( get_field( 'search_cta', $menu ) ) ?: '';
				?>
				<li class="site-header-secondary-item site-header-secondary-item-search">
					<button
						class="drawer-button"
						id="search"
						data-drawer="#search-form"><?php echo esc_html( $search_cta['title'] ); ?></button>
				</li><!-- .site-header-secondary-item -->

				<li class="site-header-secondary-item site-header-secondary-item-navigation">
					<button
						class="drawer-button"
						id="navigation"
						data-drawer="#primary-navigation"
					>
						<?php esc_html_e( 'Menu', 'enterprise-site' ); ?>
					</button>
				</li><!-- .site-header-secondary-item -->
			</ul><!-- .site-header-secondary-items -->
		</div><!-- .grid-container -->

		<form
			action=""
			method="post"
			class="header-form drawer"
			id="track-form"
		>

			<div class="drawer-close">
				<h4><?php esc_html_e( 'Tracking', 'enterprise-site' ); ?></h4>
				<button class="drawer-close-button">
					<?php esc_html_e( 'Close', 'enterprise-site' ); ?>
				</button><!-- .drawer-close-button -->
			</div><!-- .drawer-close -->

			<div class="grid-container">
				<div class="grid-x grid-margin-x">
					<div class="cell large-10">

						<p class="form-field form-field-33">
							<select id="track-form-select">
								<option value=""><?php esc_html_e( 'Select Your Platform', 'enterprise-site' ); ?></option>
								<?php

								foreach ( $track_cta['platforms'] as $platform ) {
									$name  = ( $platform['name'] ) ?: '';
									$value = ( $platform['name'] )
										? strtolower( preg_replace( '/ /', '_', $platform['name'] ) )
										: '';

									$input0 = ( isset( $platform['inputs']['name_0'] ) )
										? array(
											'name'        => ( $platform['inputs']['name_0'] ) ?: '',
											'placeholder' => ( $platform['inputs']['placeholder_0'] ),
										)
										: false;

									$input1 = ( isset( $platform['inputs']['name_1'] ) )
										? array(
											'name'        => ( $platform['inputs']['name_1'] ) ?: '',
											'placeholder' => ( $platform['inputs']['placeholder_1'] ),
										)
										: false;

									$data_input_values = array(
										'url'    => $platform['post_url'],
										'inputs' => array(),
									);

									// Set data input values for input 0
									if ( $input0 ) {
										$data_input_values['inputs']['input0'] = $input0;
									}

									// Set data input values for input 1 (if needed)
									if ( $input1 ) {
										$data_input_values['inputs']['input1'] = $input1;
									}

									$data_input_values_json = wp_json_encode( $data_input_values );
									?>
									<option 
										value="<?php echo esc_attr( $value ); ?>"
										data-input-values="<?php echo esc_attr( $data_input_values_json ); ?>">
										<?php echo esc_html( $name ); ?>
									</option>
									<?php
								}
								?>
							</select>
						</p><!-- .form-field -->

						<p class="form-field form-field-33">
							<input
								type="text"
								name=""
								id="track-form-input0"
								placeholder="<?php echo esc_attr( 'Please Select Your Platform', 'enterprise-site' ); ?>"
								disabled
							>
						</p><!-- .form-field -->

						<p class="form-field form-field-33">
							<input
								type="text"
								name=""
								id="track-form-input1"
								placeholder=""
								disabled
							>
						</p><!-- .form-field -->
					</div><!-- .cell -->

					<div class="cell large-2">
						<button
							class="btn btn-secondary"
							id="track-form-input-submit"
							disabled><?php echo esc_html( $track_cta['button']['label'] ); ?></button>
					</div><!-- .cell -->
				</div><!-- .grid-x -->
			</div><!-- .grid-container -->
			<div class="header-border-bottom"></div>
		</form><!-- #track-form -->

		<form
			action="<?php echo esc_attr( get_bloginfo( 'url' ) ); ?>"
			method="get"
			class="header-form drawer"
			id="search-form"
		>

			<div class="drawer-close">
				<h4><?php esc_html_e( 'Search', 'enterprise-site' ); ?></h4>
				<button
					class="drawer-close-button"
				>
					<?php esc_html_e( 'Close', 'enterprise-site' ); ?>
				</button><!-- .drawer-close-button -->
			</div><!-- .drawer-close -->

			<div class="grid-container">
				<div class="grid-x grid-margin-x">
					<div class="cell large-10 small-12">
						<p class="form-field form-field-100">
							<input
								type="search"
								name="s"
								id="s"
								value="<?php echo esc_attr( get_search_query() ); ?>"
								placeholder="<?php echo esc_attr( $search_cta['input']['placeholder'] ); ?>"
							>
						</p><!-- .form-field -->
					</div><!-- .cell -->

					<div class="cell large-2">
						<button class="btn btn-secondary"><?php echo esc_html( $search_cta['button']['label'] ); ?></button>
					</div><!-- .cell -->
				</div><!-- .grid-x -->
			</div><!-- .grid-container -->
			<div class="header-border-bottom"></div>
		</form><!-- #site-header-tracking-search-form -->
	</header><!-- .site-header-secondary -->

	<header
		class="site-header-primary drawer"
		id="primary-navigation">
		<div class="grid-container">
			<div class="grid-x grid-margin-x align-middle">

				<div class="drawer-close">
					<h4><?php esc_html_e( 'Navigation', 'enterprise-site' ); ?></h4>
					<button
						class="drawer-close-button"
					>
						<?php esc_html_e( 'Close', 'enterprise-site' ); ?>
					</button><!-- .drawer-close-button -->
				</div><!-- .drawer-close -->

				<div class="site-header-primary-branding cell large-2">
					<?php
					$menu = wp_get_nav_menu_object( 'header-primary-menu' );

					$company_logo = ( function_exists( 'get_field' ) && get_field( 'company_logo', $menu ) )
						? get_field( 'company_logo', $menu )
						: array(
							'url' => 'https://placeholder.pics/svg/200x80',
							'alt' => 'Header logo.',
						);
					if ( $company_logo ) {
						?>
						<a href="/">
							<img
								src="<?php echo esc_attr( $company_logo['url'] ); ?>"
								alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
							>
						</a>
						<?php
					} else {
						?>
						<h1><a href="/"><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></a></h1>
					<?php } ?>
				</div><!-- .site-header-primary-branding -->

				<nav class="site-header-primary-navigation cell large-10">
					<div class="grid-x grid-margin-x align-middle">

						<?php
						echo wp_kses(
							$header_menu_locations['header_primary'],
							array(
								'div' => array(
									'class' => array(),
								),
								'ul'  => array(
									'class' => array(),
								),
								'h4'  => array(
									'class' => array(),
								),
								'p'   => array(
									'class' => array(),
								),
								'li'  => array(
									'class' => array(),
								),
								'a'   => array(
									'href' => array(),
								),
							)
						);
						?>

						<ul class="site-header-primary-navigation-ctas cell large-5">
							<?php
							$navigation_client_cta      = ( get_field( 'client_cta', $menu ) ) ?: '';
							$navigation_client_cta_link = ( $navigation_client_cta['link'] ) ?: array(
								'title'  => __( 'Contact Us', 'enterprise-site' ),
								'url'    => '#',
								'target' => '_self',
							);
							if ( $navigation_client_cta && $navigation_client_cta_link ) {
								?>
								<li class="site-header-primary-navigation-client-cta">
									<a
										href="<?php echo esc_attr( $navigation_client_cta_link['url'] ); ?>"
										class="btn btn-text"
										target="<?php echo esc_attr( $navigation_client_cta_link['target'] ); ?>"><?php echo esc_html( $navigation_client_cta_link['title'] ); ?></a>
									<div class="mega-menu-navigation-border"></div>
									<div class="mega-menu-container">
										<div class="grid-container">
											<ul class="mega-menu grid-x grid-margin-x">
												<?php
												if ( $navigation_client_cta['client_cta_menu_groups'] ) {
													switch ( count( $navigation_client_cta['client_cta_menu_groups'] ) ) {
														case 4:
															$mega_menu_group_class = 'medium-3';
															break;
														case 3:
															$mega_menu_group_class = 'medium-4';
															break;
														case 2:
														default:
															$mega_menu_group_class = 'medium-6';
															break;
													}
													foreach ( $navigation_client_cta['client_cta_menu_groups'] as $navigation_client_cta_menu_group ) {
														?>
														<li class="mega-menu-group cell <?php echo esc_attr( $mega_menu_group_class ); ?>">
															<h4 class="mega-menu-group-title">
																<?php
																echo wp_kses(
																	$navigation_client_cta_menu_group['title'],
																	array(
																		'br' => array(),
																	)
																);
																?>
															</h4><!-- .mega-menu-group-title -->
															<p class="mega-menu-group-description">
																<?php
																echo wp_kses(
																	$navigation_client_cta_menu_group['description'],
																	array(
																		'br' => array(),
																	)
																);
																?>
															</p><!-- .mega-menu-group-description -->
															<ul class="mega-menu-group-items grid-x grid-margin-x">
																<?php
																foreach ( $navigation_client_cta_menu_group['links'] as $navigation_client_cta_menu_group_link ) {
																	?>
																	<li class="mega-menu-group-item cell <?php echo esc_attr( $mega_menu_group_class ); ?>">
																		<a
																			href="<?php echo esc_attr( $navigation_client_cta_menu_group_link['link']['url'] ); ?>"
																			target="<?php echo esc_attr( $navigation_client_cta_menu_group_link['link']['target'] ); ?>">
																			<?php
																			echo wp_kses(
																				$navigation_client_cta_menu_group_link['link']['title'],
																				array(
																					'br' => array(),
																				)
																			);
																			?>
																		</a>
																	</li><!-- .mega-menu-group-item -->
																	<?php
																}
																?>
															</ul><!-- .mega-menu-group-items -->
														</li><!-- .mega-menu-group -->
														<?php
													}
												}
												?>
											</ul><!-- .mega-menu grid-x grid-margin-x -->
										</div><!-- .grid-container -->
									</div><!-- .mega-menu-container -->
								</li><!-- .site-header-primary-navigation-client-cta -->
								<?php
							}

							$navigation_sales_cta      = ( get_field( 'sales_cta', $menu ) ) ?: '';
							$navigation_sales_cta_link = ( $navigation_sales_cta['link'] ) ?: array(
								'title'  => __( 'Contact Us', 'enterprise-site' ),
								'url'    => '#',
								'target' => '_self',
							);
							if ( $navigation_sales_cta && $navigation_sales_cta_link ) {
								?>
								<li class="site-header-primary-navigation-sales-cta">
									<a
										href="<?php echo esc_attr( $navigation_sales_cta_link['url'] ); ?>"
										class="btn btn-primary"
										target="<?php echo esc_attr( $navigation_sales_cta_link['target'] ); ?>"><?php echo esc_html( $navigation_sales_cta_link['title'] ); ?></a>
									<div class="mega-menu-navigation-border"></div>
									<div class="mega-menu-container">
										<div class="grid-container">
											<ul class="mega-menu grid-x grid-margin-x">
												<?php
												if ( $navigation_sales_cta['sales_cta_menu_groups'] ) {
													switch ( count( $navigation_sales_cta['sales_cta_menu_groups'] ) ) {
														case 4:
															$mega_menu_group_class = 'medium-3';
															break;
														case 3:
															$mega_menu_group_class = 'medium-4';
															break;
														case 2:
														default:
															$mega_menu_group_class = 'medium-6';
															break;
													}
													foreach ( $navigation_sales_cta['sales_cta_menu_groups'] as $navigation_sales_cta_menu_group ) {
														?>
														<li class="mega-menu-group cell <?php echo esc_attr( $mega_menu_group_class ); ?>">
															<h4 class="mega-menu-group-title">
																<?php
																echo wp_kses(
																	$navigation_sales_cta_menu_group['title'],
																	array(
																		'br' => array(),
																	)
																);
																?>
															</h4><!-- .mega-menu-group-title -->
															<p class="mega-menu-group-description">
																<?php
																echo wp_kses(
																	$navigation_sales_cta_menu_group['description'],
																	array(
																		'br' => array(),
																	)
																);
																?>
															</p><!-- .mega-menu-group-description -->
															<p>
																<?php
																echo wp_kses(
																	enterprise_site_create_cta(
																		$navigation_sales_cta_menu_group['link']['title'],
																		$navigation_sales_cta_menu_group['link']['url'],
																		'primary',
																		$navigation_sales_cta_menu_group['link']['target']
																	),
																	array(
																		'a' => array(
																			'class'  => array(),
																			'href'   => array(),
																			'target' => array(),
																		),
																	)
																);
																?>
															</p>
														</li><!-- .mega-menu-group -->
														<?php
													}
												}
												?>
											</ul><!-- .mega-menu grid-x grid-margin-x -->
										</div><!-- .grid-container -->
									</div><!-- .mega-menu-container -->
								</li><!-- .site-header-primary-navigation-sales-cta -->
								<?php
							}
							?>
						</ul><!-- .site-header-primary-navigation-ctas -->
					</div><!-- .grid-x -->
				</nav><!-- .site-header-primary-navigation -->
			</div><!-- .grid-x -->
		</div><!-- .grid-container -->
		<div class="header-border-bottom"></div>
	</header><!-- .site-header-primary -->
	<main class="site-content">
		<div class="site-content-overlay"></div>
