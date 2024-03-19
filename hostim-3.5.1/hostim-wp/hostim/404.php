<?php
/**
 * The template for displaying 404 pages (Not Found).
 * @package hostim
 * by ThemeTags
 */
get_header();

$image         = hostim_option( 'error_image' );
$error_text    = hostim_option( 'error_text' );
$error_title   = hostim_option( 'error_title' );
$error_content = hostim_option( 'error_description' );
?>

<section class="error_page d-flex align-items-center">
	<div class="container">
		<div class="error_page_wrapper">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="error-page-content">
						<div class="error-info text-center">
							<?php if ( ! empty( $error_title )) : ?>
								<h1 class="error-text"><?php echo esc_html($error_text); ?></h1>
							<?php else :
								echo '<h1 class="error-text">' . esc_html__('404', 'hostim') . '</h1>';
							endif; ?>

							<?php if ( ! empty( $error_title )) : ?>
								<h2 class="error-title"><?php echo esc_html($error_title); ?></h2>
							<?php else :
								echo '<h2 class="error-title">' . esc_html__('Page not Found', 'hostim') . '</h2>';
							endif; ?>

							<?php if ( ! empty( $error_content )) : ?>
								<p class="lead"><?php echo esc_html($error_content); ?></p>
							<?php else :
								echo '<p class="lead">' . esc_html__('There many variations of passages available but the majority have suffered alteration in that that injected humour.', 'hostim') . '</p>';
							endif; ?>

							<a href="<?php echo esc_url(home_url('/')); ?>" class="template-btn outline-btn"><?php echo esc_html__('Back to Home', 'hostim') ?></a>
						</div>
					</div>
				</div>
				<!-- /.col-lg-6 -->

				
			</div>
			<!-- /.row -->
		</div>
	</div>
</section>

<?php

get_footer();

