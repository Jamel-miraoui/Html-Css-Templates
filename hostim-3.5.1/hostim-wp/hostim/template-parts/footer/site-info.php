<?php
/**
 * Displays footer site info
 *
 * @package Hostim
 * @subpackage hostim
 * @since 1.0
 * @version 1.0
 */

?>
<footer id="site_footer" class="site-footer">
	<div class="site-info">
		<div class="container">
			<div class="site-info-wrapper text-center">
				<div class="copyright">
					<p>
						<?php
						$copy_text = hostim_option( 'copyright_text' );
						if ( ! empty( $copy_text ) ) {
							echo wp_kses_post( $copy_text );
						} else {
							echo sprintf( esc_html__( '&copy; %1$s %2$s - All Rights Reserved Made by %3$s', 'hostim' ), date( 'Y' ), get_bloginfo( 'name' ), '<a href="' . esc_url( 'https://www.themetags.com/' ) . '">' . esc_attr( 'ThemeTags' ) . '</a>' );
						}
						?>
					</p>
				</div>

				
			</div>
			<!-- /.site-info-wrapper -->
		</div>
		<!-- /.container -->
	</div>
</footer>