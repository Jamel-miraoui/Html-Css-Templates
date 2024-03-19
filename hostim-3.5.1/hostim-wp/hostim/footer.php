<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hostim
 */

	$meta               = get_post_meta( get_the_ID(), 'tt_page_options', true );
	$meta_footer_option = isset( $meta['meta_footer_type'] ) ? $meta['meta_footer_type'] : '';

	$f_style = hostim_option('footer_style');
	$footer_style = '';

	$meta_footer = isset($meta['meta_footer_style']) ? $meta['meta_footer_style'] : '';

	if ( $meta_footer_option == true || $meta_footer_option == 1 ) {
		$footer_style .= $meta_footer;
	} else {
		$footer_style .= $f_style;
	}

	$d1 = DateTime::createFromFormat('m/d/Y',  '');
	$d1 = new DateTime;

	$d1->getTimestamp();


	if ( $footer_style && ( get_post( $footer_style ) ) && in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
		</div><!-- main content wrapper end-->
		<?php $elementor_instance = Elementor\Plugin::instance(); ?>
		<footer id="hostim-footer" class="hostim-footer <?php echo esc_attr( get_post( $footer_style )->post_name ); ?>">
			<?php echo Hostim_Theme_Helper::hostim_render_footer( $footer_style ); ?>
		</footer>
		<?php 
	} else {
		if ( ! is_404() ) {
			get_template_part( 'template-parts/footer/site-info' );
		}
		echo '</div>'; //main content wrapper end
	}



	wp_footer(); ?>

    </body>
</html>

