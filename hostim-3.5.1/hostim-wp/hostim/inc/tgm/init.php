<?php
/**
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Hostim
 * @version    2.6.1 for parent theme corid for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */

require get_parent_theme_file_path( '/inc/tgm/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'hostim_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 */
function hostim_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Hostim Core Plugin
		array(
			'name'     => esc_attr__( 'Hostim Core', 'hostim' ),
			'slug'     => 'hostim-core',
			'source'   => ('https://hostim.themetags.com/plugins/hostim-core_3.5.1.zip' ),
			'required' => true,
			'version'  => '3.5.1',
		),

		// Codestar Framework
		array(
			'name'     => esc_attr__( 'Codestar Framework', 'hostim' ),
			'slug'     => 'codestar-framework',
			'source'   => ( 'https://hostim.themetags.com/plugins/codestar-framework.zip' ),
			'required' => true,
		),

		// Elementor
		array(
			'name'     => esc_attr__( 'Elementor', 'hostim' ),
			'slug'     => 'elementor',
			'required' => true,
		),

		// Contact Form 7
		array(
			'name'     => esc_attr__( 'Contact Form 7', 'hostim' ),
			'slug'     => 'contact-form-7',
			'required' => true,
		),

		// One Click Demo Import
		array(
			'name'     => esc_attr__( 'One Click Demo Import', 'hostim' ),
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),

	);

	/*
	 * Config for TGMPA
	 */
	$config = array(
		'id'           => 'hostim',
		'default_path' => '',
		'menu'         => 'hostim-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
