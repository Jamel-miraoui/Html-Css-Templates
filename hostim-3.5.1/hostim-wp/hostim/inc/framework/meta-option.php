<?php

// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {

	//
	// Set a unique slug-like ID
	$prefix = 'tt_page_options';

	//
	// Create a metabox
	CSF::createMetabox( $prefix, array(
		'title'     => esc_html__( 'Page Option', 'hostim' ),
		'context'   => 'normal',
		'post_type' => array( 'page', 'services' ),
		'theme'     => 'dark',

	) );

	// Header Menu
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Header', 'hostim' ),
		'icon'   => 'fa fa-home',
		'fields' => array(
			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Header Style', 'hostim' ),
			),


			// Top Bar Menu
			array(
				'id'       => 'is_custom_header',
				'type'     => 'switcher',
				'title'    => __( 'Custom Header', 'hostim' ),
				'text_on'  => __( 'Yes', 'hostim' ),
				'text_off' => __( 'No', 'hostim' ),
				'default'  => false
			),
			
			array(
				'id'      => 'header_width',
				'type'    => 'number',
				'title'   => esc_html__('Header Container Width', 'hostim'),
				'desc'      => esc_html__('Empty value will show default header width.', 'hostim'),
				'unit'        => 'px',
				'default'     => '',
				'dependency' => array('is_custom_header', '==', true),
			),
			array(
				'id'       => 'is_top_header',
				'type'     => 'switcher',
				'title'    => __( 'Top Header', 'hostim' ),
				'text_on'  => __( 'Yes', 'hostim' ),
				'text_off' => __( 'No', 'hostim' ),
				'default'  => true,
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'id'        => 'topbar_font_typo',
				'type'      => 'typography',
				'title'     => esc_html__( 'Topbar Font Typography', 'hostim' ),
				'desc'      => esc_html__( 'You can change topbar font Typography.', 'hostim' ),
				'output'    => '.topbar .topbar-left p, .topbar .topbar-right a',
				'dependency'=> array(
					['is_top_header', '==', true],
					['is_custom_header', '==', true]
				),
				'color' => false
			),

			array(
				'id'        => 'topbar_font_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Topbar Font Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change topbar font color.', 'hostim' ),
				'output'    => array('.topbar .topbar-left p, .topbar .topbar-right a'),
				'dependency'=> array(
					['is_top_header', '==', true],
					['is_custom_header', '==', true]
				),
			),

			array(
				'id'        => 'topbar_separator_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Topbar Separator Color', 'hostim' ),
				'output'    => array(
					'background'   => '.topbar .topbar-right a+a::before',
				),
				'dependency'=> array(
					['is_top_header', '==', true],
					['is_custom_header', '==', true]
				),
			),

			array(
				'id'        => 'topbar_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Topbar Background Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change topbar background color.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'output'    => array(
					'background'   => '.header-section.header_box, .header-section .topbar',
				),
				'dependency'=> array(
					['is_top_header', '==', true],
					['is_custom_header', '==', true]
				),
			),


			array(
				'id'        => 'topbar_sticky_font_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Topbar Sticky Font Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change topbar font color.', 'hostim' ),
				'output'    => array('.sticky-header .topbar .topbar-left p, .sticky-header .topbar .topbar-right a'),
				'dependency'=> array(
					['is_top_header', '==', true],
					['is_custom_header', '==', true]
				),
			),

			array(
				'id'        => 'topbar_sticky_separator_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Topbar Sticky Separator Color', 'hostim' ),
				'output'    => array(
					'background'   => '.sticky-header .topbar .topbar-right a+a::before',
				),
				'dependency'=> array(
					['is_top_header', '==', true],
					['is_custom_header', '==', true]
				),
			),

			array(
				'id'        => 'topbar_sticky_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Topbar Sticky Background Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change topbar background color.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'output'    => array(
					'background'   => '.header-section.sticky-header .topbar',
				),
				'dependency'=> array(
					['is_top_header', '==', true],
					['is_custom_header', '==', true]
				),
			), //End Tob Bar


			array(
				'id'      => 'header_type',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Header Type', 'hostim' ),
				'options' => array(
					'box'  		=> esc_html__( 'Box', 'hostim' ),
					'fullwidth' => esc_html__( 'Full Width', 'hostim' ),
				),
				'default' => 'box',
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'id'      => 'header_height',
				'type'    => 'number',
				'title'   => esc_html__( 'Header Height', 'hostim' ),
				'desc'      => esc_html__( 'Empty value will show default header height.', 'hostim' ),
				'unit'        => 'px',
				'output'      => '.header-section:not(.header_box) .header-nav',
				'output_mode' => 'height',
				'default'     => '',
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'id'        => 'header_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Header Background Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change header background color.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'output'    => array(
					'background'      => '
						html:not([data-bs-theme=dark]) .header-section .nav-menu.bg-white-color, 
						html:not([data-bs-theme=dark]) .header-section.header-gradient.header_fullwidth
					',
					
				),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),
			
			array(
				'id'        => 'sticky_header_bg_color',
				'type'      => 'color',
				'title'     => esc_html__( 'Sticky Header Background Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change sticky header background color.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'output'    => array(
					'background'      => '
						html:not([data-bs-theme=dark]) .sticky-header.header-section.header-gradient,
						html:not([data-bs-theme=dark]) .sticky-header.header-section .nav-menu.bg-white-color
					',
				),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Logo', 'hostim' ),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),
			array(
				'id'       => 'page_logo',
				'type'     => 'switcher',
				'title'    => __( 'Page Logo', 'hostim' ),
				'text_on'  => __( 'Yes', 'hostim' ),
				'text_off' => __( 'No', 'hostim' ),
				'default'  => true,
				'dependency'=> array( 'is_custom_header', '==', true ),
			),
			array(
				'id'         => 'meta_main_logo',
				'type'       => 'media',
				'title'      => esc_html__( 'Logo Upload', 'hostim' ),
				'add_title'  => esc_html__( 'Upload', 'hostim' ),
				'desc'       => esc_html__( 'Upload logo for Header', 'hostim' ),
				'dependency' => array( 
					['page_logo', '==', true],
					['is_custom_header', '==', true]
				),
			),

			array(
				'id'         => 'retina_logo',
				'type'       => 'media',
				'title'      => esc_html__( 'Retina Logo Upload @2x', 'hostim' ),
				'add_title'  => esc_html__( 'Upload', 'hostim' ),
				'desc'       => esc_html__( 'Upload your Retina Logo. This should be your Logo in double size (If your logo is 100 x 20px, it should be 200 x 40px)', 'hostim' ),
				'dependency' => array( 
					['page_logo', '==', true],
					['is_custom_header', '==', true]
				),
			),

			array(
				'id'         => 'meta_sticky_logo',
				'type'       => 'media',
				'title'      => esc_html__( 'Sticky Logo', 'hostim' ),
				'desc'       => esc_html__( 'Upload logo for Header Sticky and Inner Page.', 'hostim' ),
				'add_title'  => esc_html__( 'Upload', 'hostim' ),
				'dependency' => array( 
					['page_logo', '==', true],
					['is_custom_header', '==', true]
				),
			),

			array(
				'id'         => 'retina_logo_sticky',
				'type'       => 'media',
				'title'      => esc_html__( 'Sticky Retina Logo @2x', 'hostim' ),
				'desc'       => esc_html__( 'Upload Retina logo for Header Sticky.', 'hostim' ),
				'add_title'  => esc_html__( 'Upload', 'hostim' ),
				'dependency' => array( 
					['page_logo', '==', true],
					['is_custom_header', '==', true]
				),
			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Header Menu Style', 'hostim' ),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'id'      => 'menu_alignment',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Menu Alignment', 'hostim' ),
				'options' => array(
					'me-auto'	=> esc_html__( 'Left', 'hostim' ),
					'm-auto'	=> esc_html__( 'Center', 'hostim' ),
					'ms-auto'	=> esc_html__( 'Right', 'hostim' ),
				),
				'default' => 'ms-auto',
				'dependency'=> array( 'is_custom_header', '==', true ),
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
					'fill'	=> '.header-right div svg path'
				),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),
			array(
				'id'        => 'menu_color_hover',
				'type'      => 'color',
				'title'     => esc_html__( 'Menu Text Hover Color', 'hostim' ),
				'desc'      => esc_html__( 'You can change menu text hover color.', 'hostim' ),
				'add_title' => esc_html__( 'Upload', 'hostim' ),
				'output'    => array(
					'color'      => '
						.nav-wrapper nav > ul > li:hover > a,
						.nav-wrapper ul li:hover>a,
						.nav-wrapper ul li.has-submenu:hover::after,
						.header-right div.ofcanvus-btns a:hover
					',
					'fill' 		=> '.header-right div svg:hover path'
					
				),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),
			array(
				'id'     => 'menu_color_dropdown',
				'type'   => 'color',
				'title'  => esc_html__( 'Menu Dropdown Text Color', 'hostim' ),
				'desc'   => esc_html__( 'You can change menu text color.', 'hostim' ),
				'output' => '.nav-wrapper ul li.has-submenu .submenu-wrapper li a',
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'id'     => 'menu_color_hover_dropdown',
				'type'   => 'color',
				'title'  => esc_html__( 'Menu Dropdown Text Hover Color', 'hostim' ),
				'desc'   => esc_html__( 'You can change menu text hover color.', 'hostim' ),
				'output' => array(
					'color' => '.nav-wrapper ul li.has-submenu .submenu-wrapper li a:hover',
				),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Header Sticky Menu Style', 'hostim' ),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'id'               => 'sticky_menu_color',
				'type'             => 'color',
				'title'            => esc_html__( 'Menu Text Color', 'hostim' ),
				'desc'             => esc_html__( 'You can change menu text color.', 'hostim' ),
				'output_important' => true,
				'output' => [
					'color' => '
						html:not([data-bs-theme=dark]) .header-section.sticky-header .nav-wrapper ul li a,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .nav-wrapper ul li.has-submenu::after,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .header-right div.ofcanvus-btns a,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .header-right div.next a::before
					',
					'fill'	=> '.header-section.sticky-header .header-right div svg path'

				],
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'id'               => 'sticky_menu_color_hover',
				'type'             => 'color',
				'output_important' => true,
				'title'            => esc_html__( 'Menu Text Hover Color', 'hostim' ),
				'desc'             => esc_html__( 'You can change menu text hover color.', 'hostim' ),
				'add_title'        => esc_html__( 'Upload', 'hostim' ),
				'output'           => array(
					'color' => '
						html:not([data-bs-theme=dark]) .header-section.sticky-header .nav-wrapper ul li a:hover,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .nav-wrapper ul li.has-submenu:hover::after,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .header-right div.ofcanvus-btns a:hover,
						html:not([data-bs-theme=dark]) .header-section.sticky-header .header-right div.next a:hover::before
					',
					'fill'	=> '.header-section.sticky-header .header-right div svg:hover path'

				),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),

			array(
				'type'    => 'subheading',
				'content' => esc_html__( 'Call To Action', 'hostim' ),
				'dependency'=> array( 'is_custom_header', '==', true ),
			),
			// array(
			// 	'id'       => 'is_cta_enabled',
			// 	'type'     => 'switcher',
			// 	'title'    => __( 'Call To Action', 'hostim' ),
			// 	'text_on'  => __( 'Yes', 'hostim' ),
			// 	'text_off' => __( 'No', 'hostim' ),
			// 	'default'  => false,
			// 	'dependency'=> array( 'is_custom_header', '==', true ),
			// ),
			array(
				'id'         => 'is_cta_enabled',
				'type'       => 'button_set',
				'title'      => __( 'Call To Action', 'hostim' ),
				'options'    => array(
					'1' => 'Default',
					'enabled'  => 'Enabled',
					'disabled' => 'Disabled',
				),
				'default'    => '1',
				'dependency' => array('is_custom_header', '==', true),
			),
			array(
				'id'          => 'select_btn_style',
				'type'        => 'select',
				'title'       => __('Select Button Style', 'hostim' ),
				'options'	  => [
					'btn-primary'	=> __('Primary', 'hostim'),
					'btn-secondary' => __('Secondary', 'hostim'),
					'btn-success' 	=> __('Success', 'hostim'),
					'btn-danger' 	=> __('Danger', 'hostim'),
					'btn-warning' 	=> __('Warning', 'hostim'),
					'btn-info' 		=> __('Info', 'hostim'),
					'btn-light' 	=> __('Light', 'hostim'),
					'btn-dark' 		=> __('Dark', 'hostim'),
					'primary-btn'	=> __('Theme Primary', 'hostim'),
					'gm-header-btn' => __('Buttom Gaming', 'hostim'),
				],
				'default' 	 => 'primary-btn',
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'id'       => 'cta_btn',
				'type'     => 'link',
				'title'    => 'Call To Action Button',
				'default'  => array(
					'url'    => '#',
					'text'   => __('Get Started', 'hostim'),
					'target' => '_blank'
				),
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'type'    => 'subheading',
				'content' => esc_html__( '- Button Normal Style', 'hostim' ),
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'id'     => 'cta_btn_color',
				'type'   => 'color',
				'title'  => esc_html__( 'Button Color', 'hostim' ),
				'output' => array(
					'color' => '.header-right .template-btn'
				),
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'id'     => 'cta_btn_bg',
				'type'   => 'background',
				'title'  => esc_html__( 'Button Background Color', 'hostim' ),
				'background_gradient'  => true,
				'background_image'     => false,
				'background_position'  => false,
				'background_size'      => false,
				'background_repeat'    => false,
				'background_attachment'=> false,
				'output'			   => '.header-right .template-btn',
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'id'     => 'cta_btn_border',
				'type'   => 'border',
				'title'  => esc_html__( 'Border', 'hostim' ),
				'output' => '.header-right .template-btn',
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'id'          => 'cta_btn_padding',
				'type'        => 'spacing',
				'title'       => __( 'Padding', 'hostim' ),
				'output'      => '.header-right .template-btn',
				'output_mode' => 'padding',
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'type'    => 'subheading',
				'content' => esc_html__( '- Button Hover Style', 'hostim' ),
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'id'     => 'cta_btn_color_hover',
				'type'   => 'color',
				'title'  => esc_html__( 'Button Color', 'hostim' ),
				'output' => array(
					'color' => '.header-right .template-btn:hover, .sticky-header .header-right .template-btn'
				),
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'id'     => 'cta_btn_bg_hover',
				'type'   => 'background',
				'title'  => esc_html__( 'Button Background Color', 'hostim' ),
				'background_gradient'  => true,
				'background_image'     => false,
				'background_position'  => false,
				'background_size'      => false,
				'background_repeat'    => false,
				'background_attachment'=> false,
				'output' => ['.header-right .template-btn:hover', '.primary-btn::before', '.sticky-header .header-right .template-btn'],
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			array(
				'id'     => 'cta_btn_border_hover',
				'type'   => 'border',
				'title'  => esc_html__( 'Border', 'hostim' ),
				'output' => '.header-right .template-btn:hover, .sticky-header .header-right .template-btn',
				'dependency' => array( 
					['is_cta_enabled', '==', 'enabled'],
					['is_custom_header', '==', true]
				),
			),
			

		)
		
	) );

	// Page Header
	CSF::createSection( $prefix, array(
		'title'  => 'Page Header',
		'icon'   => 'fa fa-picture-o',
		'fields' => array(

			array(
				'id'      => 'meta_page_header',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Page Header Option', 'hostim' ),
				'options' => array(
					'default'  => esc_html__( 'Default', 'hostim' ),
					'enabled'  => esc_html__( 'Enabled', 'hostim' ),
					'disabled' => esc_html__( 'Disabled', 'hostim' ),
				),
				'default' => 'default'
			),

			array(
				'id'               => 'header_image',
				'type'             => 'background',
				'title'            => esc_html__( 'Header Image', 'hostim' ),
				'desc'             => esc_html__( 'Default: Featured image, if fail will get image from global settings.', 'hostim' ),
				'dependency'       => array( 'meta_page_header', '==', 'enabled' ),
				'output'           => '.breadcrumb-area.bg-primary-gradient',
				'output_important' => true,
			),

			array(
				'id'         => 'custom_title',
				'type'       => 'text',
				'title'      => esc_html__( 'Custom Title', 'hostim' ),
				'desc'       => esc_html__( 'Set custom title for the page header. Default: The post title.', 'hostim' ),
				'dependency' => array( 'meta_page_header', '==', 'enabled' ),
			),

			array(
				'id'         => 'meta_page_header_description',
				'type'       => 'textarea',
				'title'      => esc_html__( 'Page Description', 'hostim' ),
				'desc'       => esc_html__( 'Set custom title for the page header. Default: The post title.', 'hostim' ),
				'dependency' => array( 'meta_page_header', '==', 'enabled' ),
			),

			array(
				'id'         => 'custom_title_typography',
				'type'       => 'typography',
				'title'      => esc_html__( 'Title Typography', 'hostim' ),
				'output'     => '.breadcrumb-area .breadcrumb-content h2',
				'dependency' => array('meta_page_header', '==', 'enabled' ),
			),
			array(
				'id'         => 'custom_title_color',
				'type'       => 'color',
				'title'      => esc_html__( 'Title Color', 'hostim' ),
				'output'     => '.breadcrumb-area .breadcrumb-content h2',
				'dependency' => array( 'meta_page_header', '==', 'enabled' ),
			),

			array(
				'id'         => 'breadcrumbs',
				'type'       => 'switcher',
				'title'      => esc_html__( 'Header Breadcrumbs', 'hostim' ),
				'desc'       => esc_html__( 'Display breadcrumbs on the page header', 'hostim' ),
				'dependency' => array( 'meta_page_header', '==', 'enabled' ),
				'default'    => true,
			),

		),
	) );

	// Footer Menu
	CSF::createSection( $prefix, array(
		'title'  => esc_html__( 'Footer', 'hostim' ),
		'icon'   => 'fa fa-home',
		'fields' => array(

			array(
				'id'       => 'meta_footer_type',
				'type'     => 'switcher',
				'title'    => __( 'Footer Style', 'hostim' ),
				'text_on'  => __( 'Yes', 'hostim' ),
				'text_off' => __( 'No', 'hostim' ),
				'default'  => false
			),

			array(
				'id'          => 'meta_footer_style',
				'type'        => 'select',
				'title'       => __('Select Footer Style', 'hostim' ),
				'options'     => Hostim_Theme_Helper::get_footers_types(),
				'dependency' => array( 'meta_footer_type', '==', 'true' ),
			),

			array(
				'id'         => 'meta_footer_color',
				'type'       => 'button_set',
				'title'      => __( 'Switch Footer Dark or Light', 'hostim' ),
				'options'    => array(
					'footer_dark'  => __( 'Dark', 'hostim' ),
					'footer_light' => __( 'Light', 'hostim' ),
				),
				'default'    => 'footer_dark',
				'dependency' => array( 'meta_footer_type', '==', 'true' ),
			),

			array(
				'id'          => 'meta_footer_padding_top',
				'type'        => 'spacing',
				'title'       => __( 'Padding Top', 'hostim' ),
				'output'      => '.site-footer .footer-wrapper',
				'output_mode' => 'padding', //
				'left'        => false,
				'right'       => false,
				'dependency'  => array( 'meta_footer_type', '==', 'true' ),
			),
		)
	) );
}