<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @class        Hostim_Enqueue_Script
 * @version      1.0
 * @category     Class
 * @author       ThemeTags
 */
class Hostim_Enqueue_Script {

    public $settings;
    protected static $instance = null;
    private $gtdu;
    private $use_minify;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Return the Google font stylesheet URL if available.
     *
     * The use of Libre Franklin by default is localized. For languages that use
     * characters not supported by the font, the font can be disabled.
     *
     * @return string Font stylesheet or empty string if disabled.
     * @since hostim 1.2
     *
     */
    public function hostim_get_font_url() {
        $fonts_url = '';
        /* Translators: If there are characters in your language that are not
        * supported by Libre Franklin, translate this to 'off'. Do not translate
        * into your own language.
        */
        $urbanist = _x('on', 'Urbanist font: on or off', 'hostim');
        $Mulish = _x('on', 'Mulish font: on or off', 'hostim');

        if ('off' !== $urbanist || 'off' !== $Mulish) {
            $font_families = array();

            if ('off' !== $urbanist) {
                $font_families[] = 'Urbanist:500,600,700';
            }

            if ('off' !== $Mulish) {
                $font_families[] = 'Mulish:400,500,600,700';
            }     

            $query_args = array(
                'family' => urlencode(implode('|', $font_families)),
                'subset' => urlencode('latin,latin-ext'),
            );
            $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
        }
        return esc_url_raw($fonts_url);
    }


    public function register_script() {
        $this->gtdu = get_template_directory_uri();
        $this->use_minify = hostim_option('use_minify') ? '.min' : '';
        
        // Register action
        add_action('wp_enqueue_scripts', array($this, 'css_reg'));
        add_action('wp_enqueue_scripts', array($this, 'js_reg'));
        add_action('admin_enqueue_scripts', array($this, 'admin_css_reg'));
    }

    /* Register CSS */
    public function css_reg() {

        if ( !is_rtl() ) {
            wp_enqueue_style('bootstrap', $this->gtdu . '/assets/css/bootstrap.min.css');
        }
        else{
            wp_enqueue_style('bootstrap', $this->gtdu . '/assets/css/bootstrap.rtl.css');
        }
        wp_enqueue_style('swiper', $this->gtdu . '/assets/css/swiper.min.css');
        wp_enqueue_style('fontawesome', $this->gtdu . '/assets/css/all.min.css');
        wp_enqueue_style('magnific-popup', $this->gtdu . '/assets/css/magnific-popup.css');
        wp_enqueue_style('animate-css', $this->gtdu . '/assets/css/animate.css');
        wp_enqueue_style('hostim-style', $this->gtdu . '/assets/css/app.css');

        wp_enqueue_style('hostim-root', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

        $dark_mode = hostim_option('is_dark_mode', false );
        if( $dark_mode ){
            wp_enqueue_style('hostim-dark-mode', $this->gtdu . '/assets/css/dark-mode.css');
        }

	    if ( is_rtl() ) {
		    wp_enqueue_style('hostim-rtl-style',get_parent_theme_file_uri('/assets/css/app-rtl.css'), array(), wp_get_theme()->get( 'Version' ), 'all');
	    }

        $font_url = $this->hostim_get_font_url();
        if (!empty($font_url))
            wp_enqueue_style('hostim-fonts', esc_url_raw($font_url), array(), null);


        // Preloader CSS
        $preloader_opt = hostim_option('preloader');
        $preloader_color_opt = hostim_option('preloader_color');

        if (!empty($preloader_opt)) {
            $color = (!empty($preloader_color_opt)) ? $preloader_color_opt : 'rgba(150,41,230,0.97)';

            $preloader_css = '
                #preloader {
                    position: fixed;
                    top: 0;
                    left: 0;
                    bottom: 0;
                    right: 0;
                    background-color: ' . esc_attr($color) . ';
                    z-index: 9999999;
                }
    
                #loader {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }';

            wp_add_inline_style('hostim-style', $preloader_css);
        }

	    $custom_css = hostim_option('custom-css');

        if( is_home() ) {
            $postId       = get_option('page_for_posts');
            $page_meta = get_post_meta($postId, 'tt_page_options', true);
            
            if( $page_meta != false ){
                $background_color = $page_meta['header_image']['background-color'];
                $background_image = $page_meta['header_image']['background-image'];
                $bg_color   = !empty($background_color) ? 'background:'. $background_color : '';
                $bg_image   = !empty( $background_image['url'] ) ? 'background-image: url('. $background_image['url'] .')' : '';
                $bg_position= !empty( $background_image['background-position'] ) ? 'background-position:'. $background_image['background-position'] : '';
                $bg_reapte  = !empty( $background_image['background-repeat'] ) ? 'background-repeat:'. $background_image['background-repeat'] : '';
                $bg_size    = !empty( $background_image['background-size'] ) ? 'background-size:'. $background_image['background-size'] : '';
                $custom_css .= "
                    .breadcrumb-area.bg-primary-gradient{
                        $bg_color;
                        $bg_image;
                        $bg_position;
                        $bg_reapte;
                        $bg_size;
                    }
                ";
            }
        }

   
        if( !is_404() && !is_search() ){
            global $post;
            $page_meta = get_post_meta($post->ID, 'tt_page_options', true);
            if( !empty($page_meta['header_width']) ){
                $custom_css .= "
                    @media ( min-width: 1440px){
                        .header-section .header-nav .container{
                            max-width: {$page_meta['header_width']}px;
                        }
                    }
                ";
                
            }
        }
        wp_add_inline_style('hostim-style', $custom_css);
        

    }

    /* Register JS */
    public function js_reg() {

        wp_enqueue_script('popper', $this->gtdu . '/assets/js/popper.min.js', '', '2.9.2', true);
        wp_enqueue_script('bootstrap', $this->gtdu . '/assets/js/bootstrap.min.js', array('popper'), '5.1.3', true);
        wp_enqueue_script( 'bootstrap-slider', $this->gtdu . '/assets/js/bootstrap-slider.js', array( 'jquery' ), '1.0.1', true );
        wp_enqueue_script('jquery-masonry');
        wp_enqueue_script( 'easing', $this->gtdu . '/assets/js/easing.min.js', array( 'jquery' ), '1.4.1', true );
        wp_enqueue_script( 'swiper', $this->gtdu . '/assets/js/swiper.min.js', array( 'jquery' ), '8.1.5', true );
        wp_enqueue_script( 'magnific-popup', $this->gtdu . '/assets/js/magnific-popup.js', array( 'jquery' ), '1.1.0', true );
        wp_enqueue_script( 'waypoints', $this->gtdu . '/assets/js/waypoints.js', array( 'jquery' ), '4.0.1', true );
        wp_enqueue_script( 'counterup', $this->gtdu . '/assets/js/counterup.js', array( 'jquery' ), '1.0', true );

        wp_enqueue_script('hostim-theme', $this->gtdu . '/assets/js/app.js', array('jquery'), false, true);

        //Comment Reply
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    public function admin_css_reg() {
        wp_enqueue_style('admin-font-awesome-five', $this->gtdu . '/assets/css/all.min.css');
        wp_enqueue_style('hostim-admin', $this->gtdu . '/assets/css/hostim-admin.css');
    }

}

if (!function_exists('hostim_enqueue_script')) {
    function hostim_enqueue_script() {
        return Hostim_Enqueue_Script::instance();
    }
}

hostim_enqueue_script()->register_script();