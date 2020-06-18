<?php
/**
 * Content Locations Template
 *
 * Content template part for displaying location content (dist).
 *
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */
?>
<article
	id="locations-post-<?php the_ID(); ?>"
	<?php post_class(); ?>
>
	<div class="grid-x grid-margin-x">

		<section class="locations-post-content cell large-12">

			<?php
			$map = ( get_field( 'map' ) ) ?: array(
				'lat' => '',
				'lng' => '',
			);
			?>
			<div
				class="locations-post-content-map"
				data-zoom="12"
				data-lat="<?php echo esc_attr( $map['lat'] ); ?>"
				data-lng="<?php echo esc_attr( $map['lng'] ); ?>"
			>
			</div><!-- .locations-post-content-map -->

			<?php
			$details = ( get_field( 'details' ) ) ?: array();
			?>
			<ul
				class="locations-post-content-list-container accordion"
				data-accordion
				data-allow-all-closed="true"
				data-multi-expand="true"
			>
				<li
					class="accordion-item is-active"
					data-accordion-item
				>
					<a href="#"><h4 class="locations-post-content-list-title"><?php esc_html_e( 'Details', 'enterprise-site' ); ?></h4></a>

						<div
							class="locations-post-content-list locations-post-content-list-details accordion-content"
							accordion-content
							data-tab-content
						>
							<ul class="locations-post-content-list-content">
								<?php
								foreach ( $details as $detail ) {
									?>
										<li>
											<dl>
												<dt><?php echo esc_html( $detail['key'] ); ?></dt>	
												<dd><?php echo wp_kses_post( $detail['value'] ); ?></dd>
											</dl>
										</li>
									<?php
								}
								?>

							</ul><!-- .locations-post-content-list-content -->
						</div><!-- .locations-post-content-list-details -->
				</li><!-- .accordion-item -->
			</ul><!-- .locations-post-content-list-container -->

			<?php
			$additional_notes = ( get_field( 'additional_notes' ) ) ?: array();
			if (
				$additional_notes
				&& isset( $additional_notes )
				&& ! empty( $additional_notes )
			) {
				?>
				<ul
					class="locations-post-content-list-container accordion"
					data-accordion
					data-allow-all-closed="true"
					data-multi-expand="true"
				>
					<li
						class="accordion-item is-active"
						data-accordion-item
					>
						<a href="#"><h4 class="locations-post-content-list-title"><?php esc_html_e( 'Additional Notes', 'enterprise-site' ); ?></h4></a>
						<div
							accordion-content
							data-tab-content
							class="locations-post-content-list locations-post-content-list-notes accordion-content"
						>
							<ul class="locations-post-content-list-content">
								<?php
								foreach ( $additional_notes as $additional_note ) {
									?>
										<li>
											<dl>
												<dt><?php echo esc_html( $additional_note['key'] ); ?></dt>	
												<dd><?php echo wp_kses_post( $additional_note['value'] ); ?></dd>
											</dl>
										</li><!-- .locations-post-content-additional-notes-content -->
									<?php
								}
								?>
							</ul><!-- .locations-post-content-list-content -->
						</div><!-- .locations-post-content-list-notes -->
					</li><!-- .accordion-item -->
				</ul><!-- .locations-post-content-list-container -->
				<?php
			}
			?>

			<?php
			$contacts = ( get_field( 'contacts' ) ) ?: array();
			if (
				$contacts
				&& isset( $contacts )
				&& ! empty( $contacts )
			) {
				?>
				<ul
					class="locations-post-content-list-container accordion"
					data-accordion
					data-allow-all-closed="true"
					data-multi-expand="true"
				>
					<li
						class="accordion-item is-active"
						data-accordion-item
					>
						<a href="#"><h4 class="locations-post-content-list-title"><?php esc_html_e( 'Contacts', 'enterprise-site' ); ?></h4></a>
						<div
							accordion-content
							data-tab-content
							class="locations-post-content-list locations-post-content-list-contacts accordion-content"
						>
							<ul class="locations-post-content-list-content">
								<?php
								foreach ( $contacts as $contact ) {
									?>
										<li>
											<ul>
												<?php
												$first_name = ( $contact['first_name'] ) ?: '';
												$last_name  = ( $contact['last_name'] ) ?: '';
												$job_title  = ( $contact['job_title'] ) ?: '';
												$phone      = ( $contact['phone'] ) ?: '';
												$mobile     = ( $contact['mobile'] ) ?: '';
												$fax        = ( $contact['fax'] ) ?: '';
												$email      = ( $contact['email'] ) ?: '';
												?>

												<li><?php echo esc_html( "$first_name $last_name" ); ?></li>
												<li><?php echo esc_html( $job_title ); ?></li>
												<?php
												if ( $phone ) {
													?>
													<li>P: <a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></li>
													<?php
												}

												if ( $mobile ) {
													?>
													<li>M: <a href="tel:<?php echo esc_attr( $mobile ); ?>"><?php echo esc_html( $mobile ); ?></a></li>
													<?php
												}

												if ( $fax ) {
													?>
													<li>F: <a href="tel:<?php echo esc_attr( $fax ); ?>"><?php echo esc_html( $fax ); ?></a></li>
													<?php
												}

												if ( $email ) {
													?>
													<li>E: <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
													<?php
												}
												?>
											</ul>
										</li>
									<?php
								}
								?>
							</ul><!-- .locations-post-content-list-content -->
						</div><!-- .locations-post-content-list-contacts -->
					</li><!-- .accordion-item -->
				</ul><!-- .locations-post-content-list-container -->
				<?php
			}
			?>

			<div class="tools-post-social-share locations-post-social-share">
				<?php echo do_shortcode( '[addtoany buttons=facebook,twitter,linkedin,email]' ); ?>
			</div><!-- .locations-post-social-share -->

		</section><!-- .locations-post-content -->
	</div><!-- .grid-x -->
</article><!-- #locations-post-<?php the_ID(); ?> -->
