<?php
/**
 * hostim functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hostim
 */

/**
* Path Define
*/

define( 'HOSTIM_THEME_DIR', get_template_directory() );
define( 'HOSTIM_THEME_URI', get_template_directory_uri() );


//Image Size		
add_image_size( 'hostim_blog_848x440', 848, 440, true );
add_image_size( 'hostim_70x70', 70, 70, true );

// A Custom function for get an option
if ( ! function_exists( 'hostim_option' ) ) {
	function hostim_option( $option = '', $default = null ) {
		$options = get_option( 'hostim_cs_options' ); // Attention: Set your unique id of the framework

		return ( isset( $options[ $option ] ) ) ? $options[ $option ] : $default;
	}
}

/**
 * Implement the Custom Header feature.
 */
require HOSTIM_THEME_DIR . '/inc/custom-header.php';

/**
 * Demo Import Configuration
 */
require HOSTIM_THEME_DIR . '/inc/demos/demo_config.php';

/**
 * Load All Classes.
 */
require_once HOSTIM_THEME_DIR .'/inc/class/theme-autoload.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require HOSTIM_THEME_DIR . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require HOSTIM_THEME_DIR . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require HOSTIM_THEME_DIR . '/inc/jetpack.php';
}

/**
 * Filter the categories archive widget to add a span around post count
 */
function hostim_cat_count_span($links) {
	$links = str_replace('</a> ', ' <sup class="post-count">', $links);
	$links = str_replace(')', ')</sup></a>', $links);
	return $links;
}

add_filter('wp_list_categories', 'hostim_cat_count_span');

/**
 * Filter the archives widget to add a span around post count
 */
function hostim_archive_count_span($links) {
	$links = str_replace('</a>&nbsp;(', ' <span class="post-count">(', $links);
	$links = str_replace(')', ')</span></a>', $links);
	return $links;
}

add_filter('get_archives_link', 'hostim_archive_count_span');

add_filter( 'get_archives_link', 'hostim_archive_count_span' );

if (!function_exists('hostim_reorder_comment_fields')) {
    function hostim_reorder_comment_fields($fields ) {
        $new_fields = array();

        $myorder = array('author', 'email', 'url', 'comment');

        foreach( $myorder as $key ){
            $new_fields[ $key ] = isset($fields[ $key ]) ? $fields[ $key ] : '';
            unset( $fields[ $key ] );
        }

        if( $fields ) {
            foreach( $fields as $key => $val ) {
                $new_fields[ $key ] = $val;
            }
        }

        return $new_fields;
    }
}

add_filter('comment_form_fields', 'hostim_reorder_comment_fields');

// Codestar Framework Welcome page disable
add_filter( 'csf_welcome_page', '__return_false' );

// Hostim Kses Post ================
if ( ! function_exists( 'hostim_kses_post' ) ) {
    function hostim_kses_post( $content ) {
        $allowed_tag = array(
            'strong' => [],
            'p' => [],
            'span' => [
                'class' => [],
                'style' => []
            ],
            'br' => [],
            'a' => [
                'href' => [],
                'class' => [],
            ],
            'img' => [
                'src' => [],
                'srcset' => [],
                'width' => [],
                'height' => [],
                'class' => [],
                'alt' => [],
            ],
            'div' => [
                'class' => [],
                'style' => []
            ],
            'h1' => [
                'class' => [],
                'style' => []
            ],
            'h2' => [
                'class' => [],
                'style' => []
            ],
            'h3' => [
                'class' => [],
                'style' => []
            ],
            'h4' => [
                'class' => [],
                'style' => []
            ],
            'h5' => [
                'class' => [],
                'style' => []
            ],
            'h6' => [
                'class' => [],
                'style' => []
            ],
            'mark' => [
                'class' => [],
                'style' => []
            ],
        );
        return wp_kses( $content, $allowed_tag );
    }
}


// Allow svg --------------------------------
function allow_svg_upload_elementor()
{
    if (current_user_can('manage_options')) { // Adjust the capability as needed
        return true;
    }
    return false;
}
add_filter('elementor/editor/upload/permissions', 'allow_svg_upload_elementor');

