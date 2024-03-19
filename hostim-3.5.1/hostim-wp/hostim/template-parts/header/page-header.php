<?php
/**
 * Template for displaying page header
 */

$page_header       = hostim_option( 'page_header', true );
$page_header_img   = hostim_option( 'page_header_image' );
$page_header_title = hostim_option( 'page_header_default_title' );
$page_header_crumb = hostim_option( 'page_breadcrumbs', true );
$support_signle_title = hostim_option( 'support_single_title', true );

$banner_disp       = true;
$banner_image      = '';
$banner_title      = get_the_title();
$banner_crumb      = false;
$banner_des_enable = true;
$banner_description = '';

if ( isset( $page_header ) ) {
	$banner_disp = $page_header;
}

if ( $page_header_crumb == true ) {
	$banner_crumb = true;
}

if ( is_404() || is_singular('product') || is_singular('download') ) {
	$banner_disp = false;
	$banner_crumb = false;
}


if ( ! empty( $page_header_title ) ) {
	$banner_title = $page_header_title;
}


if ( is_singular() ) {

	if ( is_singular( 'post' ) ) {

		if ( ! empty ( $page_signle_title ) ) {
			$banner_title = $page_signle_title;
		} else {
			$banner_title = esc_html__( 'Blog Details', 'hostim' );
		}

	} elseif ( is_singular( 'hostim_support' )) {
		if ( ! empty ( $support_signle_title ) ) {
			$banner_title = $support_signle_title;
		} else {
			$banner_title = esc_html__( 'Support Details', 'hostim' );
		}
	} else {

		global $post;

		$meta = get_post_meta( $post->ID, 'tt_page_options', true );

		if ( is_array( $meta ) ) {

			if ( ! empty( $meta['custom_title'] ) ) {
				$banner_title = $meta['custom_title'];
			} elseif ( get_post_type( get_the_ID() ) == 'post' ) {
				$banner_title = esc_html__( 'Blog', 'hostim' );

			} elseif ( is_page() ) {
				$banner_title = get_the_title( $post->ID );
			} else {
				$post_type    = get_post_type_object( get_post_type() );
				$banner_title = $post_type->labels->singular_name;
			}

			if ( $meta['meta_page_header'] == 'disabled' ) {
				$banner_disp = false;
			} elseif ( $meta['meta_page_header'] == 'enabled' ) {
				$banner_disp = true;
			}

			if ( ! empty( $meta['header_image'] ) ) {
				$banner_image = wp_get_attachment_url( $meta['header_image'] );
			}

			if ( $meta['breadcrumbs'] == false ) {
				$banner_crumb = false;
			}

			if ( ! empty( $meta['meta_page_header_description'] )) {
				$banner_description = $meta['meta_page_header_description'];
			}

		}
	}

} elseif ( is_search() ) {
	if ( have_posts() ) {
		$banner_title = sprintf( esc_html__( 'Search Results for: %s', 'hostim' ), '<span>' . get_search_query() . '</span>' );
	} else {
		$banner_title = sprintf( esc_html__( 'Search Results for: %s', 'hostim' ), '<span>' . get_search_query() . '</span>' );
	}

} elseif ( is_archive() ) {
	$banner_title = get_the_archive_title();

} elseif ( is_home() && ! is_front_page() ) {
	$postId       = get_option( 'page_for_posts' );
	$banner_title = esc_html__( 'Blog', 'hostim' );

	if ( ! empty( $postId ) ) {
		$meta = get_post_meta( $postId, 'tt_page_options', true );
		if ( ! empty( $meta['custom_title'] ) ) {
			$banner_title = $meta['custom_title'];
		} else {
			$banner_title = get_the_title( $postId );
		}
		if (!empty($meta['meta_page_header_description'])) {
			$banner_description = $meta['meta_page_header_description'];
		}
		$banner_crumb = $meta['breadcrumbs'] == '1' ? true : false;
		
	}
} elseif ( is_page() ) {
	$banner_title = get_the_title();
} elseif ( is_404() ) {
	$banner_title = esc_html__( '404', 'hostim' );
} else {
	$banner_title = esc_html__( 'Blog', 'hostim' );
}

if ( $banner_disp == false ) {
	return;
}

?>
<section class="breadcrumb-area bg-primary-gradient">
    <div class="container">
        <div class="breadcrumb-content text-center">
            
			<h2 class="mb-3"><?php echo wp_kses_post( $banner_title ); ?></h2>

			<?php if( ! empty( $banner_description ) ) : ?>
				<p class="page-header-description">
					<?php echo esc_html($banner_description); ?>
				</p>
			<?php endif;
			
			// Category Description
			if( !empty( get_the_archive_description() ) ){
				$cat_desc = str_replace('{', '<h1>', get_the_archive_description() );
				$cat_desc = str_replace('}', '</h1>', $cat_desc );
				echo '<div class="category_desc">'. wpautop( $cat_desc ) .'</div>';
			}

			if ( $banner_crumb == true ) { ?>
				<nav>
					<?php echo Hostim_Theme_Helper::hostim_breadcrumb(); ?>
				</nav>
			<?php } ?>

        </div>
    </div>
</section>
