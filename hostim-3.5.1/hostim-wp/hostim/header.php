<?php
/**
 * header.php
 *
 * The header for the theme.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> data-bs-theme="light">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php

if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} ?>


 <!--body overlay -->
    <div class="body-overlay"></div>

    <!--scrolltop button -->
	<?php 
	if( hostim_option('back_to_top') == true ){ ?>
    	<button class="scrolltop-btn"><i class="fa-solid fa-angle-up"></i></button>
		<?php 
	}
	
	do_action( 'hostim_after_body' ); ?>

    <!--main content wrapper start-->
    <div class="main-wrapper">

		<?php
		//Site Header
		if( !is_404() ){
			get_template_part( 'template-parts/header/header' );
		
			get_template_part( 'template-parts/offcanvas' );

			if ( !is_singular( 'post' ) ) {
				get_template_part( 'template-parts/header/page-header' );
			}
		}
		?>