<?php
/**
 * Template part for displaying page content in header.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sasworld
 */
$meta = get_post_meta( get_the_ID(), 'tt_page_options', true );
$is_cta_enabled = isset( $meta['is_cta_enabled'] ) ? $meta['is_cta_enabled'] : '';
?>
	<!--mobile menu start-->
	<div class="mobile-menu position-fixed bg-white deep-shadow">
		<button class="close-menu position-absolute"><i class="fa-solid fa-xmark"></i></button>
		<?php
		$mobile_logo = hostim_option( 'mobile_logo' );
		$ml_ratina   = hostim_option( 'mobile_retina_logo' );
		$sticky           = hostim_option( 'sticky_logo' );
		$retina_sticky    = hostim_option( 'retina_logo_sticky' );


		if( !empty( $mobile_logo['url'] ) ){
			echo '<a href="'. esc_url( home_url('/') ) .'" class="logo-wrapper"><img src="'. esc_url( $mobile_logo['url'] ).'" alt="'. esc_attr( get_bloginfo( 'name' ) ) .'" class="logo"></a>';
		}
		elseif( !empty( $sticky['url'] ) ){
			echo '<a href="'. esc_url( home_url('/') ) .'" class="logo-wrapper"><img src="'. esc_url( $sticky['url'] ).'" alt="'. esc_attr( get_bloginfo( 'name' ) ) .'" class="logo"></a>';
		}
		else{
			echo '<a href="'. esc_url( home_url('/') ) .'" class="logo-wrapper"><h1>'. esc_html( get_bloginfo( 'name' ) ) .'</h1></a>';
		}
		?>

		<nav class="mobile-menu-wrapper mt-40">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array (
					'theme_location' => 'primary',
					'container' => null,
					'menu_class' => 'navbar-nav menu mx-auto',
					'walker' => new Hostim_Main_Nav_Walker(),
					'depth' => 3
				));
			} ?>
		</nav>
		<?php
		$is_contact_info = hostim_option( 'is_contact_info', false );
		if( $is_contact_info == true ){ ?>
			<div class="contact-info mt-60">
				<?php
				$contact_title	= hostim_option( 'contact_title' );
				$contact_address= hostim_option( 'contact_address' );
				$contact_number = hostim_option( 'contact_phone' );
				$contact_email	= hostim_option( 'contact_email' );
				$social_links 	= hostim_option( 'social_links' );

                //Call to Action
				$is_cta_btn 	= hostim_option( 'is_cta_btn' );
				$cta_btn_label 	= hostim_option( 'button_label' );
				$cta_btn_url 	= hostim_option( 'button_link' );

				if( !empty( $contact_title ) ){
					echo '<h4 class="mb-20">'. esc_html( $contact_title ) .'</h4>';
				}
				if( !empty( $contact_address ) ){
					echo '<p>'. esc_html( $contact_address ) .'</p>';
				}
				if( !empty( $contact_number ) ){
					echo '<p>'. esc_html( $contact_number ) .'</p>';
				}
				if( !empty( $contact_email ) ){
					echo '<p>'. esc_html( $contact_email ) .'</p>';
				}

				// Social links
				if( is_array( $social_links ) ){
					echo '<div class="contact-social">';
					foreach( $social_links as $item ){
						echo '<a href="'. esc_url( $item['url'] ) .'"><i class="'. esc_attr( $item['icon'] ) .'"></i></a>';
					}
					echo '</div>';
				}

				// Call to action button
				if( $is_cta_enabled != 'disabled' && $is_cta_enabled == 'enabled' ){
					echo '<a href="'. esc_url( $meta['cta_btn']['url'] ) .'" class="template-btn primary-btn mt-4">'. esc_html( $meta['cta_btn']['text'] ) .'</a>';
				} elseif( !empty($cta_btn_label) ) {                    
					echo '<a href="'. esc_url( $cta_btn_url ) .'" class="template-btn primary-btn mt-4">'. esc_html( $cta_btn_label ) .'</a>';
				}
				?>
			</div>
			<?php
		} ?>
	</div>
	<!--mobile menu end-->

	<!--offcanvus area start-->
	<div class="ofcanvus-menu">
		<button class="close-canvus"><i class="fa-solid fa-xmark"></i></button>
		<div class="megamenu">
			<?php
			$re_services_title = hostim_option( 're_service_title' );
			$re_services_number = hostim_option( 'service_to_show', 4 );
			$supported_script_title = hostim_option( 'supported_script_title' );
			$supported_scripts = hostim_option( 'supported_scripts' );

			if( ! empty( $re_services_title ) ){
				echo '<h6 class="mb-20">'. esc_html( $re_services_title ) .'</h6>';
			}
			?>

			<div class="row g-3">
				<?php
				$args       = array(
					'post_type'      => 'services',
					'posts_per_page' => $re_services_number,
				);
				$hostim_service = new \WP_Query( $args );


				if ( $hostim_service->have_posts() ) {
					while ( $hostim_service->have_posts() ) {
						$hostim_service->the_post();
						$meta = get_post_meta( get_the_ID(), 'hostim_service_options', true );
						?>
						<div class="col-lg-6">
							<a href="<?php the_permalink() ?>" class="mg-item">
								<div class="mg-item-wrapper d-flex align-items-center">
									<span class="icon-wrapper">
										<?php
										if ( !empty( $meta['service_feature_img']['id'] ) ){
                                            echo wp_get_attachment_image($meta['service_feature_img']['id'], 'hostim_40x40', '', [
                                                'class' => 'img-fluid rounded-circle img-transparent',
                                                'data-bs-toggle' => 'tooltip',
                                                'data-bs-placement' => 'top',
                                                'title' => esc_attr(get_the_title())
                                            ]);
										}
										?>
									</span>
									<div class="mg-item-content-right ms-2">
										<h6 class="mb-0"><?php the_title(); ?></h6>
										<?php
										if( !empty( $meta['service_short_desc'] ) ){
											echo '<span>'. hostim_kses_post( wp_trim_words( $meta['service_short_desc'], 3, '' ) ) .'</span>';
										} ?>
									</div>
								</div>
							</a>
						</div>
						<?php
					}
					wp_reset_postdata();
				} ?>

			</div>
			<?php
			if( ! empty( $supported_script_title ) ){
				echo '<h6 class="mb-20 mt-50">'. esc_html( $supported_script_title ) .'</h6>';
			}
			?>
			<div class="row g-3">
				<?php
				if( is_array( $supported_scripts ) ){
					foreach( $supported_scripts as $script ){
						$script_url = !empty( $script['script_url'] ) ? $script['script_url'] : '';	?>
						<div class="col-lg-3">
							<?php
							if( !empty( $script_url ) ){
								echo '<a href="'. esc_url( $script_url ) .'">';
							}
							else{
								echo '<div class="wrapper_start">';
							}
							?>
								<div class="script-icon">
									<?php
									if( !empty( $script['script_icon'] ) ){
										echo '<span class="script-icon-wrapper"><i class="'. esc_attr( $script['script_icon'] ) .'"></i></span>';
									}

									if( !empty( $script['script_title'] ) ){
										echo '<h6>'. esc_html( $script['script_title'] ) .'</h6>';
									}
									?>

								</div>
							<?php
							if( !empty( $script_url ) ){
								echo '</a>';
							}
							else{
								echo '</div>';
							}
							?>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>

	</div>
