<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Hostim Theme Autoload
*
*
* @class        Hostim_Theme_Autoload
* @version      1.0
* @category     Class
* @author       ThemeTags
*/

if (!class_exists('Hostim_Theme_Autoload')) {
    class Hostim_Theme_Autoload{

        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;
        }

        public function __construct () {

        	#Theme Helper
            $this->theme_helper();

            #Theme Enqueue Script
            $this->enqueue_script();

            #Theme Support
            $this->theme_support();

            #Theme option
            if( class_exists( 'CSF' ) ){
                $this->theme_option();
            }

            #Customize theme
            $this->walker_comment();

            #TGM init
            $this->tgm_register();

            #Mega Menu
            $this->menu();

        }

		public function enqueue_script(){
            require_once HOSTIM_THEME_DIR . '/inc/class/enqueue-script.php';
        }

        public function theme_helper(){
            require_once HOSTIM_THEME_DIR . '/inc/class/theme-helper.php';
        }

        public function theme_support(){
            require_once HOSTIM_THEME_DIR . '/inc/class/theme-support.php';
        }

        public function theme_option() {
            require_once HOSTIM_THEME_DIR . '/inc/framework/admin-option.php';
            require_once HOSTIM_THEME_DIR . '/inc/framework/meta-option.php';
            require_once HOSTIM_THEME_DIR . '/inc/framework/menu.php';
            require_once HOSTIM_THEME_DIR . '/inc/framework/service.php';
            require_once HOSTIM_THEME_DIR . '/inc/framework/taxonomy-options.php';
        }

        public function walker_comment(){
            require_once HOSTIM_THEME_DIR . '/inc/class/walker-comment.php';
        }

        public function tgm_register(){
             require_once HOSTIM_THEME_DIR . '/inc/tgm/init.php';
        }

        public function menu(){
            require_once HOSTIM_THEME_DIR . '/inc/class/menus.php';
        }

    }
    new Hostim_Theme_Autoload();
}
