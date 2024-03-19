<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package hostim
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function hostim_body_classes( $classes ) {
	$hostim_info = wp_get_theme();
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'main-sidebar' ) ) {
		$classes[] = 'no-sidebar';
	}

	if( $hostim_info ){
		$classes[] = 'hostim-'. $hostim_info->get('Version');
	}

	return $classes;
}
add_filter( 'body_class', 'hostim_body_classes' );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function hostimo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'hostimo_pingback_header' );


if ( ! function_exists( 'hostim_get_title_tag' ) ) {
	/**
	 * Returns array of title tags
	 *
	 * @param bool $first_empty
	 * @param array $additional_elements
	 *
	 * @return array
	 */
	function hostim_get_title_tag( $first_empty = false, $additional_elements = array() ) {
		$title_tag = array();

		if ( $first_empty ) {
			$title_tag[''] = esc_html__( 'Default', 'hostim' );
		}

		$title_tag['h1'] = 'h1';
		$title_tag['h2'] = 'h2';
		$title_tag['h3'] = 'h3';
		$title_tag['h4'] = 'h4';
		$title_tag['h5'] = 'h5';
		$title_tag['h6'] = 'h6';

		if ( ! empty( $additional_elements ) ) {
			$title_tag = array_merge( $title_tag, $additional_elements );
		}

		return $title_tag;
	}
}

/**
 * Preloder Callback
 */

function hostim_preloader_markup() {

    $preloader = hostim_option('preloader_switch');
    $preloader_text = hostim_option('preloader_text');
	$preloader_text = !empty( $preloader_text ) ? $preloader_text : get_bloginfo('name');
	$preloader_letter = str_split( $preloader_text );

    if ( $preloader == true ) {?>

		<div class="loader-wrap">
			<div class="preloader">
				<div id="handle-preloader" class="handle-preloader">
					<div class="animation-preloader">
						<div class="spinner"></div>
						<div class="txt-loading">
							<?php 
							if( is_array( $preloader_letter ) ){
								foreach( $preloader_letter as $text ){
									echo '<span data-text-preloader="'. esc_attr( $text ) .'" class="letters-loading">'. esc_html( $text ) .'</span>';
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

        <?php
		
	}
}

add_action( 'hostim_after_body', 'hostim_preloader_markup', 1 );

/** Page Title to id */
function hostim_get_page_title( $page_title_name ){
    $args = array(
        'post_type' => 'page',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $page_title = get_posts($args);
    if( !empty( $page_title ) ){
        $title_name_id = '';
        foreach( $page_title as $title ){
            if( $page_title_name == $title->post_title ){
                $title_name_id = $title->ID;
            }
        }
        return $title_name_id;   
    }
}

function exclude_pages_from_search($query)
{
	if ($query->is_search) {
		$pages = get_posts(array(
			'post_type' => 'page', // Specify post type as 'page'
			'post_status' => 'publish', // Retrieve only published pages
			'fields' => 'ids', // Retrieve only the IDs
			'posts_per_page' => -1, // Retrieve all pages
		));
		$page_ids = array();
		foreach ($pages as $page_id) {
			$page_ids[] = $page_id;
		}


		$query->set('post_type', 'post'); // Exclude posts from search results
		$query->set('post__not_in', $page_ids); // Replace 1, 2, 3 with the IDs of the pages you want to exclude
	}
	return $query;
}
add_filter('pre_get_posts', 'exclude_pages_from_search');

