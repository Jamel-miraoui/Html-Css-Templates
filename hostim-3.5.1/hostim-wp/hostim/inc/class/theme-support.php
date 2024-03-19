<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Hostim Theme Support
 *
 *
 * @class        Hostim_Theme_Support
 * @version      1.0
 * @category     Class
 * @author       ThemeTags
 */

if ( ! class_exists( 'Hostim_Theme_Support' ) ) {
	class Hostim_Theme_Support {

		private static $instance = null;

		public static function get_instance() {
			if ( null == self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			//Register Nav Menu
			add_action( 'init', array( $this, 'hostim_register_nav_menus' ) );
			//Add translation file
			add_action( 'init', array( $this, 'hostim_enqueue_translation_files' ) );
			//Add widget support
			add_action( 'widgets_init', array( $this, 'hostim_sidebar_register' ) );

			add_action( 'after_setup_theme', array( $this, 'hostim_setup' ) );
			add_action( 'after_setup_theme', array( $this, 'hostim_content_width' ) );
			add_action( 'after_switch_theme', [ $this, 'hostim_add_cpt_support' ] );

			add_theme_support( 'align-wide' );
			add_theme_support( 'wp-block-styles' );
			add_theme_support( "responsive-embeds" );
			add_theme_support( 'editor-styles' );
			add_editor_style( 'style-editor.css' );
			
		}


		function hostim_setup() {

			if ( function_exists( 'add_theme_support' ) ) {
				add_theme_support( 'post-thumbnails' );
				set_post_thumbnail_size( 770, 465, array( 'center', 'center' ) ); // Hard crop center center

				add_theme_support( 'automatic-feed-links' );
				add_theme_support( 'revisions' );
				add_theme_support( 'title-tag' );
				add_theme_support( 'post-formats', array( 'gallery', 'video', 'quote', 'audio', 'link' ) );
				add_theme_support( 'html5', array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption'
				) );
				add_theme_support( 'woocommerce' );
				
				/* Remove Widget Block Editor */
				remove_theme_support( 'widgets-block-editor' );

				// Set up the WordPress core custom background feature.
				add_theme_support( 'custom-background', apply_filters( 'hostim_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				) ) );

				/**
				 * Add support for core custom logo.
				 *
				 * @link https://codex.wordpress.org/Theme_Logo
				 */
				add_theme_support( 'custom-logo', array(
					'height'      => 50,
					'width'       => 200,
					'flex-width'  => true,
					'flex-height' => true,
				) );

		
			}
		}


		public function hostim_register_nav_menus() {
			register_nav_menus(
				array(
					'primary' => esc_html__( 'Primary Menu', 'hostim' ),
				)
			);
		}

		public function hostim_enqueue_translation_files() {
			load_theme_textdomain( 'hostim', get_template_directory() . '/languages/' );
		}

		public function hostim_sidebar_register() {

			// Default wrapper for widget and title
			$wrapper_before = '<div id="%1$s" class="widget sidebar-widget %2$s">';
			$wrapper_after  = '</div>';
			$title_before   = '<h4 class="widget-title">';
			$title_after    = '</h4>';

			register_sidebar( array(
				'name'          => esc_html( 'Sidebar Main', 'hostim' ),
				'id'            => "sidebar_main-sidebar",
				'description'   => esc_html__( 'Add widget here to appear it in sidebar.', 'hostim' ),
				'before_widget' => $wrapper_before,
				'after_widget'  => $wrapper_after,
				'before_title'  => $title_before,
				'after_title'   => $title_after,
			) );

		}

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global int $content_width
		 */
		function hostim_content_width() {
			// This variable is intended to be overruled from themes.
			// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
			$GLOBALS['content_width'] = apply_filters( 'hostim_content_width', 1170 );
		}

		/**
		 * Enable default Elementor Editor for custom post type.
		 */
		public function hostim_add_cpt_support() {
			//if exists, assign to $cpt_support var.
			$cpt_support = get_option( 'elementor_cpt_support' );

			//check if option DOESN'T exist in db.
			if ( ! $cpt_support ) {
				// Create array of our default supported post types.
				$cpt_support = [
					'page',
					'post',
					'portfolio',
				];
				update_option( 'elementor_cpt_support', $cpt_support );

			} else {

				if ( ! in_array( 'portfolio', $cpt_support ) ) {
					$cpt_support[] = 'portfolio';
				}

				update_option( 'elementor_cpt_support', $cpt_support );
			}
		}

	}

	new Hostim_Theme_Support();
}
