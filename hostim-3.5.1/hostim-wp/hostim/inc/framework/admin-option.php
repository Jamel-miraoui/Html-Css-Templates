<?php
// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {

	// Set a unique slug-like ID
	$prefix = 'hostim_cs_options';

	// Create options
	CSF::createOptions( $prefix, array(
		'menu_title'      => esc_html__( 'Theme Option', 'hostim' ),
		'menu_slug'       => 'hostim-framework',
		'framework_title' => esc_html__( 'Theme Settings', 'hostim' ),
		'theme'           => 'light',
		'sticky_header'   => 'true',
	) );

	// General Setting
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'General', 'hostim' ),
		'icon'   => 'fa fa-building-o',
		'fields' => array(
			array(
				'id'    => 'preloader_switch',
				'type'  => 'switcher',
				'title' => esc_html__( 'Enable Preloader', 'hostim' ),
			),
			array(
				'id'      => 'preloader_text',
				'type'    => 'text',
				'title'   => esc_html__( 'Pre-loader Text', 'hostim' ),
				'default' => 'Hostim',
				'dependency' => array( 'preloader_switch', '==', 'true' ),
			),
			array(
				'id'         => 'preloader_color',
				'title'      => esc_html__( 'Preloader Text Color', 'hostim' ),
				'type'       => 'color',
				'output'	 => '.handle-preloader .animation-preloader .txt-loading .letters-loading',
				'dependency' => array( 'preloader_switch', '==', 'true' ),
			),
			array(
				'id'                              => 'preload_bar_bg',
				'type'                            => 'background',
				'title'                           => 'Preload Bar Background',
				'background_gradient'             => true,
				'background_blend_mode'           => false,
				'background_image'				  => false,
				'background_size'				  => false,
				'background_attachment'			  => false,
				'background_position'			  => false,
				'background_repeat'				  => false,
				'output'						  => '.handle-preloader .animation-preloader .spinner',
				'dependency' => array( 'preloader_switch', '==', 'true' ),
			),
			
			array(
				'id'      => 'is_sticky_header',
				'type'    => 'switcher',
				'title'   => esc_html__('Sticky Header On/Off', 'hostim'),
				'default' => false,
			),

			array(
				'id'      => 'back_to_top',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Display Back To Top Button', 'hostim' ),
				'default' => true
			),

			array(
				'id'       => 'custom-css',
				'type'     => 'code_editor',
				'title'    => 'CSS Editor',
				'settings' => array(
					'theme' => 'mbo',
					'mode'  => 'css',
				),
				'default'  => '.element{ color: #ffbc00; }',
			)
		)
	) );


	/**
	 * Header Setting
	 */
	CSF::createSection( $prefix, array(
		'id' => 'hostim_header',
		'title'  => __( 'Header', 'hostim' ),
		'icon'  => 'fa fa-home',
	) );

	// Header
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Header', 'hostim' ),
		'parent' => 'hostim_header',
		'icon'   => 'fa fa-home',
		'fields' => array(

			array(
				'type'    => 'heading',
				'content' => esc_html__( 'Header Settings', 'hostim' ),
			),
			array(
				'id'      => 'global_header_type',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Header Type', 'hostim' ),
				'options' => array(
					'box'  		=> esc_html__( 'Box', 'hostim' ),
					'fullwidth' => esc_html__( 'Full Width', 'hostim' ),
				),
				'default' => 'box'
			),

			array(
				'id'      => 'global_header_height',
				'type'    => 'number',
				'title'   => esc_html__( 'Header Height', 'hostim' ),
				'desc'      => esc_html__( 'Empty value will show default header height.', 'hostim' ),
				'unit'        => 'px',
				'output'      => '.header-section:not(.header_box) .header-nav',
				'output_mode' => 'height',
				'default'     => '',
			),

			array(
				'id'        => 'global_header_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Header Background Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change header background color.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'output'    => array(
					'background'      => '
						html:not([data-bs-theme=dark]) .header-section .nav-menu.bg-white-color, 
						html:not([data-bs-theme=dark]) .header-section.header-gradient.header_fullwidth
					',

				)
			),

			array(
				'id'        => 'global_sticky_header_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Sticky Header Background Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change sticky header background color.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'output'    => array(
					'background'      => '
						html:not([data-bs-theme=dark]) .sticky-header.header-section.header-gradient,
						html:not([data-bs-theme=dark]) .sticky-header.header-section .nav-menu.bg-white-color
					',
				)
			),


			array(
				'type'    => 'heading',
				'content' => esc_html__( 'Logo Settings', 'hostim' ),
			),

			array(
				'id'        => 'main_logo',
				'type'      => 'media',
				'title'     => esc_html__( 'Logo Upload', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'desc'      => esc_html__( 'Upload logo for Header', 'hostim' ),
				'default'	=> [
					'url'	=> HOSTIM_THEME_URI .'/assets/images/logo/logo.svg'
				]
			),

			array(
				'id'        => 'retina_logo',
				'type'      => 'media',
				'title'     => esc_html__( 'Retina Logo Upload @2x', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'desc'      => esc_html__( 'Upload your Retina Logo. This should be your Logo in double size (If your logo is 100 x 20px, it should be 200 x 40px)', 'hostim' ),


			),

			array(
				'id'        => 'sticky_logo',
				'type'      => 'media',
				'title'     => esc_html__( 'Sticky Logo', 'hostim' ),
				'desc'      => esc_html__( 'Upload logo for Header Sticky and Inner Page.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
			),

			array(
				'id'        => 'retina_logo_sticky',
				'type'      => 'media',
				'title'     => esc_html__( 'Sticky Retina Logo @2x', 'hostim' ),
				'desc'      => esc_html__( 'Upload Retina logo for Header Sticky.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
			),

			array(
				'id'        => 'dark_mode_logo',
				'type'      => 'media',
				'title'     => esc_html__('Dark Mode Logo Upload', 'hostim'),
				'add_title' => esc_html__('Upload', 'hostim'),
				'desc'      => esc_html__('Upload logo for Dark Mode', 'hostim'),
				'default'	=> [
					'url'	=> HOSTIM_THEME_URI . '/assets/images/logo/logo-white.svg'
				],
				'dependency' => array('is_dark_mode', '==', '1', 'all'),
			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Mobile Logo', 'hostim' ),
			),

			array(
				'id'        => 'mobile_logo',
				'type'      => 'media',
				'title'     => esc_html__( 'Mobile Logo', 'hostim' ),
				'desc'      => esc_html__( 'Upload logo for mobile menu.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
			),

			array(
				'id'        => 'mobile_retina_logo',
				'type'      => 'media',
				'title'     => esc_html__( 'Mobile Retina Logo @2x', 'hostim' ),
				'desc'      => esc_html__( 'Upload Retina logo for mobile menu.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
			),


			array(
				'type'    => 'heading',
				'content' => esc_html__( 'Header Menu Style', 'hostim' ),
			),
			array(
				'id'      => 'global_menu_alignment',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Menu Alignment', 'hostim' ),
				'options' => array(
					'me-auto'	=> esc_html__( 'Left', 'hostim' ),
					'm-auto'	=> esc_html__( 'Center', 'hostim' ),
					'ms-auto'	=> esc_html__( 'Right', 'hostim' ),
				),
				'default' => 'ms-auto'
			),
			array(
				'id'     => 'menu_color',
				'type'   => 'color',
				'title'  => esc_html__( 'Menu Text Color', 'hostim' ),
				'desc'   => esc_html__( 'You can change menu text color.', 'hostim' ),
				'output' => array(
					'color' => '
						.nav-wrapper nav > ul > li > a,
						.nav-wrapper ul li.has-submenu::after,
						.header-right div.ofcanvus-btns a,
						.header-right div.next a::before
					',
					'fill'	=> '.header-right div svg path',
					'background-color' => '.header-right div.next a::before'
				)
			),

			array(
				'id'     => 'menu_color_hover',
				'type'   => 'color',
				'title'  => esc_html__( 'Menu Text Hover Color', 'hostim' ),
				'desc'   => esc_html__( 'You can change menu text hover color.', 'hostim' ),
				'output' => array(
					'color'      => '
						.nav-wrapper nav > ul > li:hover > a,
						.nav-wrapper ul li:hover>a,
						.nav-wrapper ul li.has-submenu:hover::after,
						.header-right div.ofcanvus-btns a:hover,
						.nav-wrapper ul.navbar-nav .current-menu-item a
					',
					'fill' 		=> '.header-right div svg:hover path'
				)
			),
			array(
				'id'     => 'menu_color_dropdown',
				'type'   => 'color',
				'title'  => esc_html__( 'Menu Dropdown Text Color', 'hostim' ),
				'desc'   => esc_html__( 'You can change menu text color.', 'hostim' ),
				'output' => '.nav-wrapper ul li.has-submenu .submenu-wrapper li a'
			),

			array(
				'id'               => 'menu_color_hover_dropdown',
				'type'             => 'color',
				'title'            => esc_html__( 'Menu Dropdown Text Hover Color', 'hostim' ),
				'desc'             => esc_html__( 'You can change menu text hover color.', 'hostim' ),
				'output'           => array(
					'color' => '.nav-wrapper ul li.has-submenu .submenu-wrapper li a:hover',
				),
				'output_important' => true
			),
			array(
				'id'         => 'dropdown_icon_type',
				'type'       => 'button_set',
				'title'      => __('Dropdown Icon Type', 'hostim'),
				'options'    => array(
					'icon'  => __('Icon', 'hostim'),
					'image' => __('Image', 'hostim')
				),
				'default'    => 'icon'
			),
			array(
				'id'      => 'menu_dropdown_icon',
				'type'    => 'icon',
				'title'   => __('Dropdown Icon', 'hostim'),
				'default' => 'fa fa-angle-down',
				'dependency' => array('dropdown_icon_type', '==', 'icon')
			),
			array(
				'id'      => 'menu_dropdown_img',
				'type'    => 'media',
				'title'   => __('Dropdown Image', 'hostim'),
				'preview' => true,
				'dependency' => array('dropdown_icon_type', '==', 'image')
			),
			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Header Sticky Menu Style', 'hostim' ),
			),

			array(
				'id'     => 'sticky_menu_color',
				'type'   => 'color',
				'title'  => esc_html__( 'Menu Text Color', 'hostim' ),
				'desc'   => esc_html__( 'You can change menu text color.', 'hostim' ),
				'output' => [
					'color' => '
						html:not([data-bs-theme=dark]) .header-section.sticky-header .nav-wrapper ul li a,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .nav-wrapper ul li.has-submenu::after,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .header-right div.ofcanvus-btns a,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .header-right div.next a::before
					',
					'fill'	=> '.header-section.sticky-header .header-right div svg path',
					'background-color' => '.header-section.sticky-header .header-right div.next a::before'

				]
			),

			array(
				'id'        => 'sticky_menu_color_hover',
				'type'      => 'color',
				'title'     => esc_html__( 'Menu Text Hover Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change menu text hover color.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'output' => [
					'color' => '
						html:not([data-bs-theme=dark]) .header-section.sticky-header .nav-wrapper ul li a:hover,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .nav-wrapper ul li.has-submenu:hover::after,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .header-right div.ofcanvus-btns a:hover,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .header-right div.next a:hover::before
					',
					'fill'	=> '.header-section.sticky-header .header-right div svg:hover path'

				]
			),
		)
	) );

	//Top Header Setting
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Header Top', 'hostim' ),
		'parent' => 'hostim_header',
		'icon'   => 'fa fa-arrow-up',
		'fields' => array(
			array(
				'id'      => 'top_header',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Top Header On/Off', 'hostim' ),
				'default' => true,
			),

			array(
				'id'    => 'top_left_text',
				'type'  => 'wp_editor',
				'subtitle' => __( 'Use mark tag for marked text', 'hostim' ),
				'title' => esc_html__( 'Top Left Text', 'hostim' ),
				'dependency' => array( 'top_header', '==', true )
			),

			array(
				'id'          => 'select_nav',
				'type'        => 'select',
				'title'       => 'Select Nav Menu',
				'options'     => Hostim_Theme_Helper::hostim_get_nav_menus(),
				'default'     => '',
				'dependency' => array( 'top_header', '==', true )
			),

			array(
				'id'      => 'top_header_mobile',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Top Header Mobile View : On/Off', 'hostim' ),
				'default' => false,
				'dependency' => array( 'top_header', '==', true )
			),


			//========= Subheading - Top Menu Color
			array(
				'type'    => 'subheading',
				'title'   => esc_html__( 'Top Menu Color', 'hostim' ),
				'dependency' => array( 'top_header', '==', true )
			),

			array(
				'id'        => 'topbar_font_typo',
				'type'      => 'typography',
				'title'     => esc_html__( 'Typography', 'hostim' ),
				'desc'      => esc_html__( 'You can change topbar font Typography.', 'hostim' ),
				'output'    => '.topbar .topbar-left p, .topbar .topbar-right a',
				'color'     => false,
				'dependency' => array( 'top_header', '==', true ),
			),

			array(
				'id'        => 'topbar_font_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Font Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change topbar font color.', 'hostim' ),
				'output'    => array('.topbar .topbar-left p, .topbar .topbar-right a'),
				'dependency' => array( 'top_header', '==', true ),
			),

			array(
				'id'        => 'topbar_separator_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Separator Color', 'hostim' ),
				'output'    => array(
					'background'   => '.topbar .topbar-right a+a::before',
				),
				'dependency' => array( 'top_header', '==', true ),
			),

			array(
				'id'        => 'topbar_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Background Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change topbar background color.', 'hostim' ),
				'output'    => array(
					'background'   => '.header-section.header_box:not(.sticky-header), .header-section .topbar',
				),
				'dependency' => array( 'top_header', '==', true ),
			),


			array(
				'id'        => 'topbar_sticky_font_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Sticky Font Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change topbar font color.', 'hostim' ),
				'output'    => array('.sticky-header .topbar .topbar-left p, .sticky-header .topbar .topbar-right a'),
				'dependency' => array( 'top_header', '==', true ),
			),

			array(
				'id'        => 'topbar_sticky_separator_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Sticky Separator Color', 'hostim' ),
				'output'    => array(
					'background'   => '.sticky-header .topbar .topbar-right a+a::before',
				),
				'dependency' => array( 'top_header', '==', true ),
			),

			array(
				'id'        => 'topbar_sticky_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Sticky Background Color', 'hostim' ),
				'output'    => array(
					'background'   => '.header-section.sticky-header .topbar',
				),
				'dependency' => array( 'top_header', '==', true ),
			), //End Tob Bar

		)
	) );

	// Recommended Service Panel
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Recommended Service Panel', 'hostim' ),
		'parent' => 'hostim_header',
		'icon'   => 'fa fa-server',
		'fields' => array(
			array(
				'id'      => 'is_panel_on',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Recommended Service Panel Show/Hide', 'hostim' ),
				'default' => false,
			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Recommended Service', 'hostim' ),
				'dependency' => array( 'is_panel_on', '==', 'true' )
			),
			array(
				'id'    => 're_service_title',
				'type'  => 'text',
				'title' => __('Recommended Services', 'hostim' ),
				'default' => __('Recommended Services', 'hostim' ),
				'dependency' => array( 'is_panel_on', '==', 'true' )
			),
			array(
				'id'    => 'service_to_show',
				'type'  => 'number',
				'title' => __('How many services would be shown', 'hostim' ),
				'default'=> 4,
				'dependency' => array( 'is_panel_on', '==', 'true' )
			),
			array(
				'id'          => 'service_order',
				'type'        => 'select',
				'title'       => 'Order',
				'options'     => array(
					'ASC'  => esc_html__( 'Ascending', 'hostim' ),
					'DESC' => esc_html__( 'Descending', 'hostim' ),
				),
				'default'     => 'DESC',
				'dependency' => array( 'is_panel_on', '==', 'true' )

			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Supported Scripts', 'hostim' ),
				'dependency' => array( 'is_panel_on', '==', 'true' )
			),
			array(
				'id'    => 'supported_script_title',
				'type'  => 'text',
				'title' => __('Supported Scripts', 'hostim' ),
				'default' => __('Supported Scripts', 'hostim' ),
				'dependency' => array( 'is_panel_on', '==', 'true' )
			),
			array(
				'id'     => 'supported_scripts',
				'type'   => 'repeater',
				'title'  => 'Supported Scripts',
				'dependency' => array( 'is_panel_on', '==', 'true' ),
				'fields' => array(

					array(
						'id'    => 'script_title',
						'type'  => 'text',
						'title' => 'Script Title'
					),
					array(
						'id'    => 'script_url',
						'type'  => 'text',
						'title' => 'Script URL'
					),
					array(
						'id'    => 'script_icon',
						'type'  => 'icon',
						'title' => 'Icon',
					),

				),
			),

		)
	) );

	// Header Elements Switcher
	CSF::createSection($prefix, array(
		'title'  => esc_html__('Header Elements Switch', 'hostim'),
		'parent' => 'hostim_header',
		'icon'   => 'fa fa-toggle-on',
		'fields' => array(

			array(
				'id'      => 'header_search',
				'type'    => 'switcher',
				'title'   => esc_html__('Search On/Off', 'hostim'),
				'default' => false,
			),

			array(
				'id'      => 'is_cta_btn',
				'type'    => 'switcher',
				'title'   => esc_html__('Call To Action Button On/Off', 'hostim'),
				'default' => false,
			),
			array(
				'id'      => 'button_label',
				'type'    => 'text',
				'title'   => esc_html__('Button Label', 'hostim'),
				'default' => __('Get Started', 'hostim'),
				'dependency' => array('is_cta_btn', '==', '1'),
			),
			array(
				'id'      => 'button_link',
				'type'    => 'text',
				'title'   => esc_html__('Button Link', 'hostim'),
				'default' => '#',
				'dependency' => array('is_cta_btn', '==', '1'),
			),

			array(
				'id'      => 'is_dark_mode',
				'type'    => 'switcher',
				'title'   => esc_html__('Dark Light Icon On/Off', 'hostim'),
				'default' => false,
			),
			array(
				'id'     => 'hostim_dark_bg',
				'type'   => 'color',
				'title'  => esc_html__('Dark Background Color', 'hostim'),
				'output'      => ':root',
				'output_mode' => '--hostim_dark_bg',
				'dependency' => array('is_dark_mode', '==', '1'),
			),
			array(
				'id'     => 'hostim_dark_gray_bg',
				'type'   => 'color',
				'title'  => esc_html__('Dark Gray Background Color', 'hostim'),
				'output'      => ':root',
				'output_mode' => '--hostim_dark_gray_bg',
				'dependency' => array('is_dark_mode', '==', '1'),
			),

		)
	));



	//Footer Setting
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Footer', 'hostim' ),
		'icon'   => 'fa fa-arrow-down',
		'fields' => array(

			array(
				'id'          => 'footer_style',
				'type'        => 'select',
				'title'       => __('Select Footer Style', 'hostim' ),
				'options'     => Hostim_Theme_Helper::get_footers_types(),
			),

			array(
				'id'    => 'copyright_text',
				'type'  => 'textarea',
				'title' => esc_html__( 'Copyright Text', 'hostim' ),
			),
			array(
				'id'     => 'footer_text_color',
				'type'   => 'color',
				'title'  => esc_html__( 'Footer Text Color', 'hostim' ),
				'output' => 'footer#site_footer .copyright p',
			),
			array(
				'id'          => 'footer_padding_top',
				'type'        => 'spacing',
				'title'       => __( 'Padding Top/Bottom', 'hostim' ),
				'output'      => 'footer#site_footer',
				'output_mode' => 'padding', //
				'left'        => false,
				'right'       => false,
				'default'     => array(
					'unit' => 'px',
				),
			),
			array(
				'id'          => 'footer_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Footer Background Color', 'hostim' ),
				'output'      => 'footer#site_footer',
				'output_mode' => 'background',
			),
		)
	) );

	//Page Header
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Page Header', 'hostim' ),
		'icon'   => 'fa fa-picture-o',
		'fields' => array(

			array(
				'type'    => 'subheading',
				'content' => esc_html__( ' Page Header Settings', 'hostim' ),
			),
			array(
				'id'      => 'page_header',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Page Header Enable', 'hostim' ),
				'default' => true,
			),
			array(
				'id'      => 'page_breadcrumbs',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Page Header Breadcrumb Show/Hide', 'hostim' ),
				'default' => true,
			),

			array(
				'id'      => 'banner_height',
				'type'    => 'slider',
				'title'   => __( 'Banner Height', 'hostim' ),
				'min'     => 250,
				'max'     => 600,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 325,
				'output'  => [
					'min-height' => '.breadcrumb-area',
				]
			),

			array(
				'id'     => 'custom_title_typography',
				'type'   => 'typography',
				'title'  => esc_html__( 'Title Typography', 'hostim' ),
				'output' => array(
					'color' => '.breadcrumb-content h2',
				),
			),
			array(
				'id'                    => 'page_header_image',
				'type'                  => 'background',
				'title'                 => esc_html__( 'Header Background', 'hostim' ),
				'desc'                  => esc_html__( 'Default: Featured image, if fail will get image from global settings.', 'hostim' ),
				'output'                => '.breadcrumb-area',
				'background_gradient'   => true,
				'background_origin'     => true,
				'background_clip'       => true,
				'background_blend_mode' => true,
				'default'               => array(
					'background-gradient-direction' => 'to right',
					'background-size'               => 'cover',
					'background-position'           => 'center center',
					'background-repeat'             => 'no-repeat',
				),
			),
		)
	) );

	/**
	 * Blog Setting
	 */
	CSF::createSection( $prefix, array(
		'id' => 'hostim_blog',
		'title'  => __( 'Blog', 'hostim' ),
		'icon'  => 'fa fa-file-text-o',
	) );


	//Blog Archive Setting
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Blog Archive', 'hostim' ),
		'parent'   => 'hostim_blog',
		'icon'   => 'fa fa-file-text-o',
		'fields' => array(

			array(
				'id'         => 'blog_style',
				'type'       => 'image_select',
				'title'      => esc_html__( 'Style', 'hostim' ),
				'desc'       => esc_html__( 'Display number of post per row', 'hostim' ),
				'radio'      => true,
				'options'    => array(
					'list' => HOSTIM_THEME_URI . '/assets/images/layout/list.png',
					'grid' => HOSTIM_THEME_URI . '/assets/images/layout/grid.png',
				),
				'default'    => 'list',
			),

			array(
				'id'         => 'blog_column',
				'type'       => 'image_select',
				'title'      => esc_html__( 'Columns', 'hostim' ),
				'desc'       => esc_html__( 'Display number of post per row', 'hostim' ),
				'radio'      => true,
				'options'    => array(
					'6' => HOSTIM_THEME_URI . '/assets/images/layout/2cols.png',
					'4' => HOSTIM_THEME_URI . '/assets/images/layout/3cols.png',
				),
				'default'    => '6',
//				'dependency' => array( 'blog_style', '==', 'grid' ),
			),

			array(
				'id'      => 'blog_sidebar_layout',
				'type'    => 'image_select',
				'title'   => esc_html__( 'Layout', 'hostim' ),
				'radio'   => true,
				'options' => array(
					'left'       => HOSTIM_THEME_URI . '/assets/images/layout/left-sidebar.png',
					'no-sidebar' => HOSTIM_THEME_URI . '/assets/images/layout/no-sidebar.png',
					'right'      => HOSTIM_THEME_URI . '/assets/images/layout/right-sidebar.png',
				),
				'default' => 'right',
			),

			array(
				'id'       => 'blog_sidebar_def_width',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Blog Archive Sidebar Width', 'hostim' ),
				'options'  => array(
					'9' => '25%',
					'8' => '33%',
				),
				'default'  => '8',
				'required' => array( 'blog_sidebar_layout', '!=', 'none' ),
			),

			array(
				'id'       => 'blog_sidebar_gap',
				'type'     => 'select',
				'title'    => esc_html__( 'Blog Archive Sidebar Side Gap', 'hostim' ),
				'options'  => array(
					'def' => 'Default',
					'0'   => '0',
					'15'  => '15',
					'20'  => '20',
					'25'  => '25',
					'30'  => '30',
					'35'  => '35',
					'40'  => '40',
					'45'  => '45',
					'50'  => '50',
				),
				'default'  => '15',
				'required' => array( 'blog_sidebar_layout', '!=', 'none' ),
			),

			array(
				'id'      => 'word_count',
				'type'       => 'text',
				'title'      => esc_html__( 'Post Content Word Count', 'hostim' ),
				'default'    => 20,
				'dependency' => array( 'blog_style', '==', 'list' ),
			),

			array(
				'id'      => 'word_count_grid',
				'type'       => 'text',
				'title'      => esc_html__( 'Post Content Word Count', 'hostim' ),
				'default'    => 7,
				'dependency' => array( 'blog_style', '==', 'grid' ),
			),

			array(
				'id'      => 'blog_list_meta_author',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Hide post-meta author?', 'hostim' ),
				'default' => true,
			),
			array(
				'id'      => 'blog_list_meta_comments',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Hide post-meta comments?', 'hostim' ),
				'default' => true,
			),
			array(
				'id'      => 'blog_list_meta_categories',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Hide post-meta categories?', 'hostim' ),
				'default' => true,
			),
			array(
				'id'      => 'blog_list_meta_date',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Hide post-meta date?', 'hostim' ),
				'default' => false,
			),

			// Subheading - Call to Action Button
			array(
				'type'    => 'subheading',
				'content' => 'Call to Action Button',
			),
			array(
				'id'      => 'is_cta_btn_blog',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Button', 'hostim' ),
				'default' => false
			),

		)
	) );


	//Blog Single Setting
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Blog Single', 'hostim' ),
		'parent'   => 'hostim_blog',
		'icon'   => 'fa fa-file-text-o',
		'fields' => array(
			array(
				'id'      => 'is_feature_image',
				'type'    => 'switcher',
				'title'   => esc_html__('Feature Image On/Off', 'hostim'),
				'default' => true
			),
			array(
				'id'      => 'blog_details_meta_author',
				'type'    => 'switcher',
				'title'   => esc_html__('Hide post-meta author?', 'hostim'),
				'default' => true,
			),
			array(
				'id'      => 'blog_details_meta_comments',
				'type'    => 'switcher',
				'title'   => esc_html__('Hide post-meta comments?', 'hostim'),
				'default' => true,
			),
			array(
				'id'      => 'blog_details_meta_date',
				'type'    => 'switcher',
				'title'   => esc_html__('Hide post-meta date?', 'hostim'),
				'default' => false,
			),
			array(
				'id'      => 'single_post_nav',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Hide Post Navigation?', 'hostim' ),
				'default' => false,
			),
			array(
				'id'      => 'author_info',
				'type'    => 'switcher',
				'title'   => esc_html__('Display Author Bio Box', 'hostim'),
				'default' => false
			),
			array(
				'id'      => 'post_share_icon',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Show post share icon', 'hostim' ),
				'default' => false,
			),

		)
	) );


	/**
	 * Services Settings
	 */
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Services', 'hostim' ),
		'icon'   => 'fas fa-briefcase',
		'fields' => array(

			array(
				'id'    => 'services_slug',
				'type'  => 'text',
				'title' => esc_html__( 'Custom Slug', 'hostim' ),
			),



		)
	) );

	//Social Link
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Contact Info', 'hostim' ),
		'icon'   => 'fa fa-address-card-o',
		'desc'   => esc_html__( 'This social profiles will display in your whole site.', 'hostim' ),
		'fields' => array(
			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Contact Info', 'hostim' ),
			),
			array(
				'id'      => 'is_contact_info',
				'type'    => 'switcher',
				'title'   => 'Contact Info',
				'label'   => 'Do you want activate it ?',
				'default' => false
			),

			array(
				'type'    => 'text',
				'title'   => esc_html__( 'Contact Title', 'hostim' ),
				'id'      => 'contact_title',
				'default' => esc_html__( 'Contact Info', 'hostim' ),
				'dependency' => array( 'is_contact_info', '==', 'true' )
			),
			array(
				'type'    => 'text',
				'title'   => esc_html__( 'Contact Address', 'hostim' ),
				'id'      => 'contact_address',
				'default' => esc_html__( 'Chicago 12, Melborne City, USA', 'hostim' ),
				'dependency' => array( 'is_contact_info', '==', 'true' )
			),
			array(
				'type'    => 'text',
				'title'   => esc_html__( 'Phone Number', 'hostim' ),
				'id'      => 'contact_phone',
				'default' => esc_html__( '+88 01682648101', 'hostim' ),
				'dependency' => array( 'is_contact_info', '==', 'true' )
			),

			array(
				'type'    => 'text',
				'title'   => esc_html__( 'Email', 'hostim' ),
				'id'      => 'contact_email',
				'default' => esc_html__( 'info@themetags.com', 'hostim' ),
				'dependency' => array( 'is_contact_info', '==', 'true' )
			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Social links', 'hostim' ),
				'dependency' => array( 'is_contact_info', '==', 'true' )
			),
			array(
				'id'           => 'social_links',
				'type'         => 'group',
				'title'        => esc_html__( 'Social links', 'hostim' ),
				'desc'         => esc_html__( 'This social profiles will display in your whole site.', 'hostim' ),
				'button_title' => esc_html__( 'Add New', 'hostim' ),
				'dependency'   => array( 'is_contact_info', '==', 'true' ),
				'fields'       => array(

					array(
						'id'    => 'name',
						'type'  => 'text',
						'title' => esc_html__( 'Name', 'hostim' ),
					),
					array(
						'id'    => 'url',
						'type'  => 'text',
						'title' => esc_html__( 'Url', 'hostim' )
					),
					array(
						'id'    => 'icon',
						'type'  => 'icon',
						'title' => esc_html__( 'Icon', 'hostim' )
					)

				),

				'default' => array(
					array(
						'name' => esc_html__( 'Facebook', 'hostim' ),
						'url'  => esc_url( 'http://facebook.com' ),
						'icon' => 'fab fa-facebook-f'
					),

					array(
						'name' => esc_html__( 'Twitter', 'hostim' ),
						'url'  => esc_url( 'http://twitter.com' ),
						'icon' => 'fab fa-twitter'
					),

					array(
						'name' => esc_html__( 'Dribbble', 'hostim' ),
						'url'  => esc_url( 'http://dribbble.com' ),
						'icon' => 'fab fa-dribbble'
					)

				),
				array(
					'type'    => 'notice',
					'class'   => 'info',
					'content' => esc_html__( 'This social profiles will display in your whole site.', 'hostim' ),
				),

			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Contact Info Style', 'hostim' ),
				'dependency'   => array( 'is_contact_info', '==', 'true' ),
			),

			array(
				'id'      => 'contact_heading_typo',
				'type'    => 'typography',
				'title'   => esc_html__( 'Contact Heading Typography', 'hostim' ),
				'output'  => '.contact-info h4',
				'default' => array(
					'unit' => 'px',
					'type' => 'google',
				),
				'dependency'   => array( 'is_contact_info', '==', 'true' ),
			),

			array(
				'id'      => 'address_typo',
				'type'    => 'typography',
				'title'   => esc_html__( 'Address Typography', 'hostim' ),
				'output'  => '.contact-info p',
				'default' => array(
					'unit' => 'px',
					'type' => 'google',
				),
				'dependency'   => array( 'is_contact_info', '==', 'true' ),
			),

			array(
				'id'     => 'social_icon_color',
				'type'   => 'color',
				'title'  => esc_html__( 'Social Icons Color', 'hostim' ),
				'output' => '.mobile-menu .contact-social a i',
				'dependency'   => array( 'is_contact_info', '==', 'true' ),
			),
		)
	) );

	// Woocommerce
	if( class_exists( 'WooCommerce' ) ){
		CSF::createSection( $prefix, array(
			'id' => 'woocommerce_section',
			'title'  => __( 'Woocommerce', 'hostim' ),
			'icon'  => 'fa fa-shopping-cart',
			'fields' => array(

				// A text field
				array(
					'id'      => 'shop_sidebar_layout',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Layout', 'hostim' ),
					'radio'   => true,
					'options' => array(
						'left'       => HOSTIM_THEME_URI . '/assets/images/layout/left-sidebar.png',
						'no-sidebar' => HOSTIM_THEME_URI . '/assets/images/layout/no-sidebar.png',
						'right'      => HOSTIM_THEME_URI . '/assets/images/layout/right-sidebar.png',
					),
					'default' => 'right',
				),

				array(
					'id'       => 'product_style',
					'type'     => 'button_set',
					'title'    => __('Product Style', 'hostim'),
					'multiple' => false,
					'options'  => array(
						'style_one'   => __('One', 'hostim'),
						'style_two'   => __('Two', 'hostim'),
					),
					'default'  => 'style_one'
				),

				array(
					'id'       => 'shop_column',
					'type'     => 'button_set',
					'title'    => 'Column',
					'multiple' => false,
					'options'  => array(
						'6'   => 'Two',
						'4'   => 'Three',
						'3' => 'Four',
					),
					'default'  => '4'
				),

				array(
					'id'       => 'shop_sidebar_def_width',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Blog Archive Sidebar Width', 'hostim' ),
					'options'  => array(
						'9' => '25%',
						'8' => '33%',
					),
					'default'  => '8',
					'required' => array( 'shop_sidebar_layout', '!=', 'none' ),
				),

				array(
					'id'       => 'shop_sidebar_gap',
					'type'     => 'select',
					'title'    => esc_html__( 'Blog Archive Sidebar Side Gap', 'hostim' ),
					'options'  => array(
						'def' => 'Default',
						'0'   => '0',
						'15'  => '15',
						'20'  => '20',
						'25'  => '25',
						'30'  => '30',
						'35'  => '35',
						'40'  => '40',
						'45'  => '45',
						'50'  => '50',
						'75'  => '75',
						'85'  => '85',
						'100' => '100',
					),
					'default'  => '30',
					'required' => array( 'shop_sidebar_layout', '!=', 'none' ),
				),

				array(
					'id'      => 'shop_products_per_page',
					'type'    => 'number',
					'title'   => __('product Per Page', 'hostim'),
					'default' => 12,
				),

				//			array(
				//				'id'      => 'shop_related_column',
				//				'type'    => 'number',
				//				'title'   => __('Related product Column', 'hostim'),
				//				'default' => 3,
				//			),

				array(
					'id'      => 'shop_related_per_page',
					'type'    => 'number',
					'title'   => __('Related product Per Page', 'hostim'),
					'default' => 3,
				),



				array(
					'id'      => 'single_related_post',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Related Post Show/Hide', 'hostim' ),
					'default' => false
				),

				array(
					'type'       => 'text',
					'title'      => esc_html__( 'Related Post Tittle', 'hostim' ),
					'id'         => 'related_title',
					'default'    => __( 'Related Post', 'hostim' ),
					'dependency' => array( 'single_related_post', '==', true ),
				),

				array(
					'type'       => 'text',
					'title'      => esc_html__( 'Related Post Tittle', 'hostim' ),
					'id'         => 'related_description',
					'default'    => __( 'Related Post', 'hostim' ),
					'dependency' => array( 'single_related_post', '==', true ),
				),
			)
		) );
	}

	//Error Page
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( '404 Page', 'hostim' ),
		'icon'   => 'fa fa-exclamation-triangle',
		'fields' => array(

			array(
				'id'        => 'error_image',
				'type'      => 'media',
				'title'     => esc_html__( 'Image', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
			),

			array(
				'type'    => 'text',
				'title'   => esc_html__( 'Error Text', 'hostim' ),
				'id'      => 'error_text',
				'default' => esc_html__( '404', 'hostim' ),
			),

			array(
				'type'    => 'text',
				'title'   => esc_html__( 'Error Title', 'hostim' ),
				'id'      => 'error_title',
				'default' => esc_html__( 'Page not Found', 'hostim' ),
			),

			array(
				'type'    => 'textarea',
				'title'   => esc_html__( 'Description', 'hostim' ),
				'id'      => 'error_description',
				'default' => esc_html__( 'There many variations of passages available but the majority have suffered alteration in that that injected humour.', 'hostim' ),
			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( ' Style', 'hostim' ),
			),

			array(
				'id'                    => 'error_bg_image',
				'type'                  => 'background',
				'title'                 => esc_html__( 'Header Background', 'hostim' ),
				'desc'                  => esc_html__( 'Default: Featured image, if fail will get image from global settings.', 'hostim' ),
				'output'                => 'section.error_page',
				'background_gradient'   => true,
				'background_origin'     => true,
				'background_clip'       => true,
				'background_blend_mode' => true,
				'default'               => array(
					'background-gradient-direction' => 'to right',
					'background-size'               => 'cover',
					'background-position'           => 'center center',
					'background-repeat'             => 'no-repeat',
				),
			),

			array(
				'id'     => 'error-text',
				'type'   => 'color',
				'title'  => esc_html__( 'Error Text Color', 'hostim' ),
				'output' => '.error_page .error-page-content .error-text',
			),

			array(
				'id'     => 'error-heading',
				'type'   => 'color',
				'title'  => esc_html__( 'Heading Color', 'hostim' ),
				'output' => '.error_page .error-page-content .error-title',
			),

			array(
				'id'     => 'error-content',
				'type'   => 'color',
				'title'  => esc_html__( 'Content Color', 'hostim' ),
				'output' => '.error_page .error-page-content p',
			),

		)
	) );

	//Typography
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Typography', 'hostim' ),
		'icon'   => 'fa fa-font',
		'fields' => array(
			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Body Font Settings', 'hostim' ),
			),

			array(
				'id'      => 'body-font',
				'type'    => 'typography',
				'title'   => esc_html__( 'Body', 'hostim' ),
				'output'  => 'body',
				'default' => array(
					'unit' => 'px',
					'type' => 'google',
				),
			),
			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Heading Font Settings', 'hostim' ),
			),
			array(
				'id'      => 'heading-h1',
				'type'    => 'typography',
				'title'   => esc_html__( 'Heading H1', 'hostim' ),
				'output'  => 'h1',
				'default' => array(
					'unit'      => 'px',
					'type'      => 'google',
				),
			),
			array(
				'id'      => 'heading-h2',
				'type'    => 'typography',
				'title'   => esc_html__( 'Heading H2', 'hostim' ),
				'output'  => 'h2',
				'default' => array(
					'unit'      => 'px',
					'type'      => 'google',
				),
			),
			array(
				'id'      => 'heading-h3',
				'type'    => 'typography',
				'title'   => esc_html__( 'Heading H3', 'hostim' ),
				'output'  => 'h3',
				'default' => array(
					'unit'      => 'px',
					'type'      => 'google',
				),
			),
			array(
				'id'      => 'heading-h4',
				'type'    => 'typography',
				'title'   => esc_html__( 'Heading H4', 'hostim' ),
				'output'  => 'h4',
				'default' => array(
					'unit'      => 'px',
					'type'      => 'google',
				),
			),
			array(
				'id'      => 'heading-h5',
				'type'    => 'typography',
				'title'   => esc_html__( 'Heading H5', 'hostim' ),
				'output'  => 'h5',
				'default' => array(
					'unit'      => 'px',
					'type'      => 'google',
				),
			),

			array(
				'id'      => 'heading-h6',
				'type'    => 'typography',
				'title'   => esc_html__( 'Heading H6', 'hostim' ),
				'output'  => 'h6',
				'default' => array(
					'unit'      => 'px',
					'type'      => 'google',
				),
			),

		)
	) );

	//Color Scheme
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Color Scheme', 'hostim' ),
		'icon'   => 'fa fa-star',
		'icon'   => 'fa fa-paint-brush',
		'fields' => array(

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'General Color', 'hostim' ),
			),

			array(
				'id'     => 'body-color',
				'type'   => 'color',
				'title'  => esc_html__( 'Body Color', 'hostim' ),
				'output' => 'body'
			),

			array(
				'id'     => 'main_heading-color',
				'type'   => 'color',
				'title'  => esc_html__( 'Heading Color', 'hostim' ),
				'output' => 'h1,h2,h3,h4,h5,h6, .blog-content .entry-title a',
			),

			array(
				'id'     => 'main_primary_color',
				'type'   => 'color',
				'title'  => esc_html__( 'Primary Color', 'hostim' ),
				'desc'   => esc_html__( 'Main Color Scheme', 'hostim' ),
				'output' => array(
					'color'            => '.topbar .topbar-right a:hover, .nav-wrapper ul li:hover::after, .nav-wrapper ul li:hover>a,
						.lang-switcher ul li a:hover, .header-two .nav-wrapper ul li.has-submenu .submenu-wrapper li .menu-list-wrapper .icon-wrapper,
						.header-two .nav-wrapper ul li.has-submenu .submenu-wrapper .megamenu-item .menu-list-wrapper .icon-wrapper,
						.footer-widget .footer-nav li a:hover, .footer-widget .footer-nav li a:hover::before, .footer-copyright .copyright-links a:hover,
						.h5-footer-address li i,.outline-primary,.cd-secondary-btn, .handle-preloader .animation-preloader .txt-loading .letters-loading,
						.promo-item .promo-top span,.pricing-column .pricing-label,.pricing-column .feature-list li i,.service-card:hover .card-content a,
						.blog-card .blog-content-wrapper h3:hover,.blog-card .blog-content-wrapper h4:hover,.blog-card .blog-content h3:hover,
						.blog-card .blog-content h4:hover,.hm2-explore-btn,.hm2-feature-card .icon-wrapper,.hm2-server-tab-control li button i,
						.hm2-app-item .app-content h3:hover,.hm2-app-item .app-content a:hover,.clients-explore .app-info h6,.hm2-blog-card .hm2-blog-card-content h3:hover,
						.categories-widget ul li a:hover,.categories-widget ul li a:hover::after,.recent-post-widget ul.rs-news-list li .rs-news-content h6:hover,
						.archive-widget .archive-list li a:hover,.bd-content-wrapper .bd-rl-post-wrapper h6:hover,.sh-feature-list ul li i,.wp-pricing-meta-item .wp-icon-wrapper,
						.wp-feature-item .icon-wrapper,.vps_pp_feature_item h6 span,.vps-pricing-table table tbody tr td i,.vps-tab-info p a,.ds-pricing-item .ds-pricing-list li span,
						.hosting-info-title mark,.home4-about-accordion .accordion-item .accordion-header a::before,.h4-blog-card .h4-blog-content h3:hover,
						.h5-service-box h4:hover,.h5-service-box a.explore:hover,.h5-service-box:hover a.explore,.h5-blog-card .h5-blog-article-content h4:hover,
						.h5-blog-card .h5-blog-article-content .share-btn:hover,.h5-blog-card .h5-blog-article-content .explore-btn:hover,.bf-pricing-btn-meta,
						.bd-blog-meta span:hover h6,.bd-blog-meta span:hover a,.bd-blog-meta span:hover,.hm2-blog-card-content .bog-author span:hover h6,
						.hm2-blog-card-content .bog-author span:hover a,.hm2-blog-card-content .bog-author span:hover,.sidebar-widget ul li a:hover,
						.widget_categories ul li a:hover,.widget_categories ul li a:hover::after,.sidebar-widget ol.wp-block-latest-comments .wp-block-latest-comments__comment a:hover,
						.hostim_blog_content>ul li a:hover,.breadcrumb-area nav ol li a:hover',

					'background' => '.nav-wrapper ul li.has-submenu .submenu-wrapper li .menu-list-wrapper .icon-wrapper,
						.nav-wrapper ul li.has-submenu .submenu-wrapper .megamenu-item .menu-list-wrapper .icon-wrapper, .header-search-form,
						.header-style-4 .sh-header-cart button .number,.hm2-sb-form .radio-btns input:checked~label span::before,
						.cd-secondary-btn:hover,.blog-card .feature-thumb .category-btn,.hm2-feature-card a:hover,.hm2-service-tab ul li button::after,
						.hm2-server-tab-control li button::before,.slider-pagination span.swiper-pagination-bullet-active::before,.vps-pricing-table table tbody tr td a:hover,
						.vps_scripts_slider_wrapper .vps-scripts-slider .swiper-control-btn:hover,.signup-form-wrapper form input[type=submit],.ds-faq-controls li button.active,
						.h5-service-box .icon-wrapper::before,.h5-pricing-controls li a.active,.h5-pricing-filter-controls li a::before,.h5-feedback .h5-feedback-slider .swiper-controls',

					'background-color'	   => '.outline-btn:hover,.secondary-btn:hover, .outline-primary:hover,.hm2-feature-card:hover .icon-wrapper,.hm2-feature-card:hover a,
						.map-location .ct-location li,.h5-feedback .h5-feedback-slider .swiper-next:hover,.pricing-plan-slider .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active::before,
						.em-pricing-slider .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active::before',

					'border-color'	   => '.outline-btn:hover,.outline-primary,.hm2-feature-card a:hover,.hm2-feature-card:hover a,.slider-pagination span.swiper-pagination-bullet-active,
						.vps-pricing-table table tbody tr td a, .pricing-plan-slider .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active,
						.em-pricing-slider .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active',
				),
			),

			array(
				'id'     => 'theme_gradient_color',
				'type'   => 'background',
				'title'  => esc_html__( 'Theme Gradient Color', 'hostim' ),
				'background_gradient'  => true,
				'background_image'     => false,
				'background_position'  => false,
				'background_size'      => false,
				'background_repeat'    => false,
				'background_attachment'=> false,
				'output'			   => [
					'background' => '
						.template-pagination ul.page-numbers li .page-numbers::after,.wp-block-quote.has-text-align-right:after,
						.sidebar-widget form button, .sidebar-widget form button::before, .sidebar-widget .wp-block-group__inner-container h1::before,.sidebar-widget .wp-block-group__inner-container h2::before,
						.sidebar-widget .wp-block-group__inner-container h3::before,.sidebar-widget .wp-block-group__inner-container h4::before,.sidebar-widget .wp-block-group__inner-container h5::before,
						.sidebar-widget .wp-block-group__inner-container h6::before, .footer-widget .ft-subtitle::after, .footer-widget .widget-title::before,.footer-widget .social-nav li a,
						.footer-widget .social-nav li a::before, .hm2-footer-copyright .footer-social a::before, .primary-btn,.scrolltop-btn,.hm2-title mark,.template-pagination ul li a:after,
						.handle-preloader .animation-preloader .spinner, .tab-switch-btn .toggle-switch-btn::before,.money-back-area .money-back_ft-list li i,.hm2-explore-btn::before,
						.hm2-service-tab ul li button.active i,.hm2-pricing-tab>ul li button.active,.hm2-pricing-single .pricing-badge span,.hm2-pricing-bottom ul li i,.hm2-server-content .server-info .explore-btn,
						.hm2-feedback-item .quote-icon,.hm2-blog-card .hm2-blog-card-content .tag-btn::before,.sidebar-widget .widget-title::before,.bd-content-wrapper blockquote::before,
						.bd-content-wrapper blockquote .bd-quote-author::before,.hm-ct-info-wrapper .icon-wrapper,.sh-benefits-wrapper .icon-wrapper i,.sh-benefits-wrapper .icon-wrapper::before,
						.cp-accordion .accordion-single::after, .dm-pp-domain-item::before,.dm-support-info a i,.vps-pricing-table table thead tr th,.vps-video-box::before, .vps-feature-btns li a::before,
						.ds-faq-controls li button::before,.home4-about-accordion .accordion-item .accordion-header a:not(.collapsed)::before,.h5-tab-controls li a::after,.friday-hosting-offer .primary-btn,
						.em-pricing-single-item .em-pricing-btn
					',
				]
			),

			array(
				'id'     => 'theme_gradient_hover',
				'type'   => 'background',
				'title'  => esc_html__( 'Theme Gradient Hover Color', 'hostim' ),
				'background_gradient'  => true,
				'background_image'     => false,
				'background_position'  => false,
				'background_size'      => false,
				'background_repeat'    => false,
				'background_attachment'=> false,
				'output'			   => [
					'background' => '
						.primary-btn::before, .footer-widget .social-nav li a::before,.wp-hero .wp-hero-dot-illustration,.hero-4 .hero4-circle,.em-pricing-single-item .em-pricing-btn::before,
						.hm2-blog-card .hm2-blog-card-content .tag-btn,.sidebar-widget form button::before
					',
				]
			),

			array(
				'id'     => 'link-color',
				'type'   => 'link_color',
				'title'  => 'Link Color',
				'color'  => true,
				'hover'  => true,
				'focus'  => true,
				'output' => '.post .author a, .product .author a, 
				.post .blog-content .read-more, .post .blog-content .post-meta li a:hover,
				.product .blog-content .read-more'
			),


		)
	) );

	//Backup
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Backup', 'hostim' ),
		'icon'   => 'fa fa-download',
		'fields' => array(
			array(
				'type' => 'backup',
			),
		)
	) );
}
