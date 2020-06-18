<?php
/**
 * Content Borders Template
 *
 * Content template part for displaying border content (src).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */
?>
<article
	id="borders-post-<?php the_ID(); ?>"
	<?php post_class(); ?>
	data-equalizer
	data-equalize-on="medium" 
>
	<div class="grid-x grid-margin-x">
		<aside
			class="borders-post-aside cell large-3 large-order-1 small-order-2"
			data-equalizer-watch
		>
			<?php
			$description = ( get_field( 'description' ) ) ?: '';

			if ( $description ) {
				?>
				<div class="borders-post-description">
					<h4><?php echo esc_html_e( 'About', 'enterprise-site' ); ?></h4>
					<p><?php echo esc_html( $description ); ?></p>
				</div><!-- .borders-post-description -->
				<?php
			}
			?>

			<?php
			$origin  = ( get_field( 'origin' ) ) ?: array(
				'port'            => '',
				'city'            => '',
				'address_i'       => '',
				'address_ii'      => '',
				'postal_zip_code' => '',
				'email'           => '',
				'fax'             => '',
				'address_i'       => '',
				'address_ii'      => '',
				'postal_zip_code' => '',
				'branch_location' => '',
			);
			$highway = ( get_field( 'highway' ) ) ?: '';
			?>
			<ul
				class="borders-post-meta accordion"
				data-accordion
				data-allow-all-closed="true"
				data-multi-expand="true"
			>
				<li
					class="accordion-item is-active"
					data-accordion-item
				>
					<a
						href="#"
						class="borders-post-meta-title"
					><h4><?php esc_html_e( 'Origin Info', 'enterprise-site' ); ?></h4></a>

					<dl
						class="borders-post-meta-content accordion-content"
						accordion-content
						data-tab-content
					>

						<dt><?php esc_html_e( 'Port', 'enterprise-site' ); ?></dt>
						<dd><?php echo esc_html( $origin['port'] ?: 'N/A' ); ?></dd>

						<dt><?php esc_html_e( 'City', 'enterprise-site' ); ?></dt>
						<dd><?php echo esc_html( $origin['city'] ?: 'N/A' ); ?></dd>

						<dt><?php esc_html_e( 'Highway', 'enterprise-site' ); ?></dt>
						<dd><?php echo esc_html( $highway ?: 'N/A' ); ?></dd>

						<dt><?php esc_html_e( 'Branch Address', 'enterprise-site' ); ?></dt>
						<dd>
							<address>
								<?php
								if ( $origin['address_i'] ) {
									?>
									<p>
										<?php
										echo esc_html( $origin['address_i'] );
										?>
									</p>
									<?php
								}
								if ( $origin['address_ii'] ) {
									?>
									<p>
										<?php
										echo esc_html( $origin['address_ii'] );
										?>
									</p>
									<?php
								}
								if ( $origin['postal_zip_code'] ) {
									?>
									<p>
										<?php
										echo esc_html( $origin['postal_zip_code'] );
										?>
									</p>
									<?php
								}
								?>
							</address>
						</dd>

						<dt><?php esc_html_e( 'Branch Email', 'enterprise-site' ); ?></dt>
							<dd>
								<?php
								if ( $origin['email'] ) {
									?>
									<a href="mailto:<?php echo esc_attr( $origin['email'] ); ?>"><?php echo esc_html( $origin['email'] ); ?></a>
									<?php
								} else {
									?>
									N/A
									<?php
								}
								?>
							</dd>

							<dt><?php esc_html_e( 'Branch Phone', 'enterprise-site' ); ?></dt>
							<dd>
								<?php
								if ( $origin['phone'] ) {
									?>
									<a href="tel:<?php echo esc_attr( $origin['phone'] ); ?>"><?php echo esc_html( $origin['phone'] ); ?></a>
									<?php
								} else {
									?>
									N/A
									<?php
								}
								?>
							</dd>

							<dt><?php esc_html_e( 'Branch Fax', 'enterprise-site' ); ?></dt>
							<dd>
								<?php
								if ( $origin['fax'] ) {
									?>
									<a href="tel:<?php echo esc_attr( $origin['fax'] ); ?>"><?php echo esc_html( $origin['fax'] ); ?></a>
									<?php
								} else {
									?>
									N/A
									<?php
								}
								?>
							</dd>

							<?php
							$url = ( $origin['branch_location'] )
								? get_permalink( $origin['branch_location'] )
								: false;

							if ( $url ) {
								?>
									<dt><?php esc_html_e( 'Branch Details', 'enterprise-site' ); ?></dt>
									<dd>
										<a
											href=""
											class="borders-location-link"
										><?php echo esc_html_e( 'View Details', 'enterprise-site' ); ?></a>
									</dd>
								<?php
							}
							?>
					</dl><!-- .borders-post-meta-origin-content -->
				</li><!-- .accordion-item -->
			</ul><!-- .borders-post-meta -->

			<?php
			$destination = ( get_field( 'destination' ) ) ?: array(
				'port'            => '',
				'city'            => '',
				'address_i'       => '',
				'address_ii'      => '',
				'postal_zip_code' => '',
				'email'           => '',
				'fax'             => '',
				'address_i'       => '',
				'address_ii'      => '',
				'postal_zip_code' => '',
				'branch_location' => '',
			);
			?>
			<ul
				class="borders-post-meta accordion"
				data-accordion
				data-allow-all-closed="true"
				data-multi-expand="true"
			>
				<li
					class="accordion-item is-active"
					data-accordion-item
				>
					<a
						href="#"
						class="borders-post-meta-title"
					><h4><?php esc_html_e( 'Destination Info', 'enterprise-site' ); ?></h4></a>

					<dl
						class="borders-post-meta-content accordion-content"
						accordion-content
						data-tab-content
					>

						<dt><?php esc_html_e( 'Port', 'enterprise-site' ); ?></dt>
						<dd><?php echo esc_html( $destination['port'] ?: 'N/A' ); ?></dd>

						<dt><?php esc_html_e( 'City', 'enterprise-site' ); ?></dt>
						<dd><?php echo esc_html( $destination['city'] ?: 'N/A' ); ?></dd>

						<dt><?php esc_html_e( 'Highway', 'enterprise-site' ); ?></dt>
						<dd><?php echo esc_html( $highway ?: 'N/A' ); ?></dd>

						<dt><?php esc_html_e( 'Branch Address', 'enterprise-site' ); ?></dt>
						<dd>
							<address>
								<?php
								if ( $destination['address_i'] ) {
									?>
									<p>
										<?php
										echo esc_html( $destination['address_i'] );
										?>
									</p>
									<?php
								}
								if ( $destination['address_ii'] ) {
									?>
									<p>
										<?php
										echo esc_html( $destination['address_ii'] );
										?>
									</p>
									<?php
								}
								if ( $destination['postal_zip_code'] ) {
									?>
									<p>
										<?php
										echo esc_html( $destination['postal_zip_code'] );
										?>
									</p>
									<?php
								}
								?>
							</address>
						</dd>

						<dt><?php esc_html_e( 'Branch Email', 'enterprise-site' ); ?></dt>
							<dd>
								<?php
								if ( $destination['email'] ) {
									?>
									<a href="mailto:<?php echo esc_attr( $destination['email'] ); ?>"><?php echo esc_html( $destination['email'] ); ?></a>
									<?php
								} else {
									?>
									N/A
									<?php
								}
								?>
							</dd>

							<dt><?php esc_html_e( 'Branch Phone', 'enterprise-site' ); ?></dt>
							<dd>
								<?php
								if ( $destination['phone'] ) {
									?>
									<a href="tel:<?php echo esc_attr( $destination['phone'] ); ?>"><?php echo esc_html( $destination['phone'] ); ?></a>
									<?php
								} else {
									?>
									N/A
									<?php
								}
								?>
							</dd>

							<dt><?php esc_html_e( 'Branch Fax', 'enterprise-site' ); ?></dt>
							<dd>
								<?php
								if ( $destination['fax'] ) {
									?>
									<a href="tel:<?php echo esc_attr( $destination['fax'] ); ?>"><?php echo esc_html( $destination['fax'] ); ?></a>
									<?php
								} else {
									?>
									N/A
									<?php
								}
								?>
							</dd>

							<?php
							$url = ( $destination['branch_location'] )
								? get_permalink( $destination['branch_location'] )
								: false;

							if ( $url ) {
								?>
									<dt><?php esc_html_e( 'Branch Details', 'enterprise-site' ); ?></dt>
									<dd>
										<a
											href=""
											class="borders-location-link"
										><?php echo esc_html_e( 'View Details', 'enterprise-site' ); ?></a>
									</dd>
								<?php
							}
							?>
					</dl><!-- .borders-post-meta-content -->
				</li><!-- .accordion-item -->
			</ul><!-- .borders-post-meta -->

			<div class="tools-post-social-share borders-post-social-share">
				<?php echo do_shortcode( '[addtoany buttons=facebook,twitter,linkedin,email]' ); ?>
			</div><!-- .borders-post-social-share -->
		</aside><!-- .borders-post-aside -->

		<section
			class="borders-post-content cell large-8 large-offset-1 large-order-2 small-order-1"
			data-equalizer-watch
		>

			<?php
			$map = ( get_field( 'map' ) ) ?: array(
				'lat' => '',
				'lng' => '',
			);
			?>
			<div
				class="borders-post-content-map"
				data-zoom="12"
				data-lat="<?php echo esc_attr( $map['lat'] ); ?>"
				data-lng="<?php echo esc_attr( $map['lng'] ); ?>"
			>
			</div><!-- .borders-post-content-map -->
		</section><!-- .borders-post-content -->
	</div><!-- .grid-x -->
</article><!-- #borders-post-<?php the_ID(); ?> -->
