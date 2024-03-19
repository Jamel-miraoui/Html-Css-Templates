<?php
// Disable regenerating images while importing media
add_filter( 'ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
add_filter( 'ocdi/disable_pt_branding', '__return_true' );

// Change some options for the jQuery modal window
function hostim_ocdi_confirmation_dialog_options ( $options ) {
    return array_merge( $options, array(
        'width'       => 400,
        'dialogClass' => 'wp-dialog',
        'resizable'   => false,
        'height'      => 'auto',
        'modal'       => true,
    ) );
}
add_filter( 'ocdi/confirmation_dialog_options', 'hostim_ocdi_confirmation_dialog_options', 10, 1 );

function hostim_ocdi_intro_text_( $default_text ) {
    $default_text .= '<div class="ocdi_custom-intro-text notice notice-info inline">';
    $default_text .= sprintf (
        '%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
        esc_html__( 'Install and activate all ', 'hostim' ),
        get_admin_url(null, 'themes.php?page=tgmpa-install-plugins' ),
        esc_html__( 'required plugins', 'hostim' ),
        esc_html__( 'before you click on the "Import" button.', 'hostim' )
    );
    $default_text .= sprintf (
        ' %1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
        esc_html__( 'You will find all the pages in ', 'hostim' ),
        get_admin_url(null, 'edit.php?post_type=page' ),
        esc_html__( 'Pages.', 'hostim' ),
        esc_html__( 'Other pages will be imported along with the main Homepage.', 'hostim' )
    );
    $default_text .= '<br>';
    $default_text .= sprintf (
        '%1$s <a href="%2$s" target="_blank">%3$s</a>',
        esc_html__( 'If you fail to import the demo data, follow the alternative way', 'hostim' ),
        'https://is.gd/R6jpHq',
        esc_html__( 'here.', 'hostim' )
    );
    $default_text .= '</div>';

    return $default_text;
}
add_filter( 'ocdi/plugin_intro_text', 'hostim_ocdi_intro_text_' );



// OneClick Demo Importer
add_filter( 'ocdi/import_files', 'hostim_import_files' );
function hostim_import_files() {
    return array (

	    array(
		    'import_file_name'             => esc_html__( 'Web Hosting', 'hostim' ),
		    'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
		    'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
		    'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/web_hosting.png',
		    'preview_url'                  => 'https://hostim.themetags.com/',
		    'local_import_json'            => array(
			    array(
				    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
				    'option_name' => 'hostim_cs_options',
			    ),
		    ),
	    ),

        array(
            'import_file_name'             => esc_html__( 'Hosting Services', 'hostim' ),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/hosting_services.png',
            'preview_url'                  => 'https://https://hostim.themetags.com/hosting-services/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),

        array(
            'import_file_name'             => esc_html__('Hosting Solutions', 'hostim' ),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/hosting_solutions.png',
            'preview_url'                  => 'https://hostim.themetags.com/hosting-solutions/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__( 'Game Hosting', 'hostim' ),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/game_hosting.png',
            'preview_url'                  => 'https://hostim.themetags.com/game-hosting/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__( 'Application Hosting', 'hostim' ),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/application_hosting.png',
            'preview_url'                  => 'https://hostim.themetags.com/application-hosting/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__( 'Black Friday', 'hostim' ),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/black_friday.png',
            'preview_url'                  => 'https://hostim.themetags.com/black-friday/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),

        array(
            'import_file_name'             => esc_html__( 'Hosting Provider', 'hostim' ),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/web_hosting_provider.png',
            'preview_url'                  => 'https://hostim.themetags.com/hosting-provider/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),

        array(
            'import_file_name'             => esc_html__( 'Dedicated Server', 'hostim' ),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/dedicated_server.png',
            'preview_url'                  => 'https://hostim.themetags.com/dedicated-server/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),

        array(
            'import_file_name'             => esc_html__( 'Web Hosting 02', 'hostim' ),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/web_hosting_2.png',
            'preview_url'                  => 'https://hostim.themetags.com/web-hosting/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),

	    array(
		    'import_file_name'             => esc_html__( 'Hostim RTL', 'hostim' ),
		    'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content-rtl.xml',
		    'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/all/widgets.wie',
		    'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'inc/demos/img/hostim_rtl.png',
		    'preview_url'                  => 'https://hostim-rtl.themetags.com/',
		    'local_import_json'            => array(
			    array(
				    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/all/options.json',
				    'option_name' => 'hostim_cs_options',
			    ),
		    ),
	    ),
        array(
            'import_file_name'             => esc_html__('Hosting Agency', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/hosting_agency.png',
            'preview_url'                  => 'https://hostim.themetags.com/hosting-agency/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__('Promotional Home', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/promotional_home.png',
            'preview_url'                  => 'https://hostim.themetags.com/promotional-home/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__('Hosting Home 2', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/hosting-home-2.jpg',
            'preview_url'                  => 'https://hostim.themetags.com/hosting-home-2/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        
        array(
            'import_file_name'             => esc_html__('VPS Hosting', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/vps-hosting.png',
            'preview_url'                  => 'https://hostim.themetags.com/vps-hosting/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        
        array(
            'import_file_name'             => esc_html__('Cloud Servers', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/cloud-server.png',
            'preview_url'                  => 'https://hostim.themetags.com/cloud-servers/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        
        array(
            'import_file_name'             => esc_html__('Web Hosting 3', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/web-hosting-3.png',
            'preview_url'                  => 'https://hostim.themetags.com/web-hosting-3/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        
        array(
            'import_file_name'             => esc_html__('Cloud Hosting', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/cloud-hosting.png',
            'preview_url'                  => 'https://hostim.themetags.com/cloud-hosting/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),

        array(
            'import_file_name'             => esc_html__('Hosting Service 02', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/hosting-service-02.png',
            'preview_url'                  => 'https://hostim.themetags.com/hosting-service-02/',   
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),

        array(
            'import_file_name'             => esc_html__('Hosting Business', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/hosting-business.png',
            'preview_url'                  => 'https://hostim.themetags.com/hosting-business/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__('Isometric', 'hostim'),
            'import_file_url'              => 'https://hostim.themetags.com/files/demo-data/content.xml',
            'local_import_widget_file'     => trailingslashit(get_template_directory()) . 'inc/demos/all/widgets.wie',
            'import_preview_image_url'     => trailingslashit(get_template_directory_uri()) . 'inc/demos/img/isometric.png',
            'preview_url'                  => 'https://hostim.themetags.com/isometric/',
            'local_import_json'            => array(
                array(
                    'file_path'   => trailingslashit(get_template_directory()) . 'inc/demos/all/options.json',
                    'option_name' => 'hostim_cs_options',
                ),
            ),
        ),

    );
}


/**
 * Adding local_import_json and import_json param supports.
 */
if (!function_exists('prefix_after_content_import_execution')) {
    function prefix_after_content_import_execution($selected_import_files, $import_files, $selected_index)
    {

        $downloader = new OCDI\Downloader();

        if (!empty($import_files[$selected_index]['import_json'])) {

            foreach ($import_files[$selected_index]['import_json'] as $index => $import) {
                $file_path = $downloader->download_file($import['file_url'], 'demo-import-file-' . $index . '-' . date('Y-m-d__H-i-s') . '.json');
                $file_raw  = OCDI\Helpers::data_from_file($file_path);
                update_option($import['option_name'], json_decode($file_raw, true));
            }
        } else if (!empty($import_files[$selected_index]['local_import_json'])) {

            foreach ($import_files[$selected_index]['local_import_json'] as $index => $import) {
                $file_path = $import['file_path'];
                $file_raw  = OCDI\Helpers::data_from_file($file_path);
                update_option($import['option_name'], json_decode($file_raw, true));
            }
        }
    }
    add_action('ocdi/after_content_import_execution', 'prefix_after_content_import_execution', 3, 99);
}


function hostim_after_import_setup($selected_import) {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Primary Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array (
            'primary' => $main_menu->term_id,
        )
    );

    // Disable Elementor's Default Colors and Default Fonts
    update_option( 'elementor_disable_color_schemes', 'yes' );
    update_option( 'elementor_disable_typography_schemes', 'yes' );
    update_option( 'elementor_global_image_lightbox', '' );

	// Assign front page and posts page (blog page).
	if ( 'Hosting Services' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Hosting Services' );
	}

	if ( 'Web Hosting' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Home' );
	}

	if ( 'Hosting Solutions' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Hosting Solutions' );
	}

	if ( 'Game Hosting' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Game Hosting' );
	}

	if ( 'Application Hosting' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Application Hosting' );
	}

	if ( 'Black Friday' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Black Friday' );
	}

	if ( 'Hostim RTL' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Home' );
	}

	if ( 'Hosting Provider' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Home - Hosting Provider' );
	}
    
	if ( 'Dedicated Server' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Home - Dedicated Server' );
	}

	if ( 'Web Hosting 02' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title( 'Home - Web Hosting' );
	}
	
    if ('Hosting Agency' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('Hosting Agency' );
	}
    
    if ('Promotional Home' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('Promotional Home' );
	}
    
    if ('Hosting Home 2' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('Hosting Home 2' );
	}
    
    if ('VPS Hosting' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('VPS Hosting' );
	}
    
    if ('Cloud Servers' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('Cloud Servers' );
	}
    
    if ('Web Hosting 3' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('Web Hosting' );
	}
    
    if ('Cloud Hosting' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('Cloud Hosting' );
	}

    if ('Hosting Service 02' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('Hosting Service 02' );
	}

    if ('Hosting Business' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('Hosting Business' );
	}
    
    if ('isometric' == $selected_import['import_file_name'] ) {
		$front_page_id = hostim_get_page_title('Isometric' );
	}


    $blog_page_id  = hostim_get_page_title( 'Blog' );

    // Set the home page and blog page
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id );
    update_option( 'page_for_posts', $blog_page_id );

}

add_action( 'ocdi/after_import', 'hostim_after_import_setup' );
