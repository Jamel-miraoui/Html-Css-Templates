<?php
/**
 * The Header Layout 1.
 *
 * @since   1.0.0
 * @package hostim
 */

// Global Options ================
$unique_id 		= uniqid( 'search-form-' );
$is_panel_on    = hostim_option( 'is_panel_on', false );
$is_dark_mode	= hostim_option( 'is_dark_mode', false );
$is_search_icon = hostim_option( 'header_search' );
$is_cta_enabled = hostim_option( 'is_cta_btn', false );
$is_top_header	= hostim_option( 'top_header', true );
$top_header_mobile	= hostim_option( 'top_header_mobile', false );
$header_type	= hostim_option( 'global_header_type', 'box' );
$menu_alignment	= hostim_option( 'global_menu_alignment', 'ms-auto' );
$nav_menu_bg	= $header_type == 'box' ? 'bg-white-color' : 'mb-0';
$header_class	= $header_type == 'fullwidth' ? 'header_fullwidth' : 'header_box';
$cta_btn_blog 	= hostim_option('is_cta_btn_blog', false);
$is_sticky_header   = hostim_option('is_sticky_header');
$sticky_enabled     = $is_sticky_header == '1' ? ' sticky_enabled' : '';

//Page meta =========
$meta = get_post_meta( get_the_ID(), 'tt_page_options', true );
$meta_is_custom_header = !empty($meta['is_custom_header']) ? $meta['is_custom_header'] : '';
if( $meta_is_custom_header == '1' ){
	$is_top_header	= isset( $meta[ 'is_top_header' ] ) ? $meta[ 'is_top_header' ] : '';
	$header_type 	= isset( $meta['header_type'] ) ? $meta['header_type'] : 'box';
	$nav_menu_bg	= $header_type == 'box' ? 'bg-white-color' : 'mb-0';
	$header_class	= $header_type == 'fullwidth' ? 'header_fullwidth' : 'header_box';
	$is_cta_enabled = isset($meta['is_cta_enabled']) ? $meta['is_cta_enabled'] : '';
	$menu_alignment	= isset( $meta['menu_alignment'] ) ? $meta['menu_alignment'] : 'ms-auto';
}
?>

<header class="header-section header-gradient <?php echo esc_attr( $header_class . $sticky_enabled) ?>">
	<?php
	if( $is_top_header == '1' ) { ?>
        <div class="topbar <?php echo esc_attr($top_header_mobile ? '' : 'topbar_of_mobile' ) ?>">
            <div class="container">
                <div class="row align-item-center">
                    <div class="col-6 col-md-6">
                        <div class="topbar-left">
							<?php
							$top_left_text = hostim_option( 'top_left_text' );
							if( !empty( $top_left_text ) ){
								echo '<p class="mb-0">'. wp_kses_post( $top_left_text ) .'</p>';
							}
							?>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
						<?php
						$select_nav = hostim_option( 'select_nav' );
						if ( !empty( $select_nav ) ) {
							$selected_nav = wp_get_nav_menu_items( $select_nav );
							echo '<div class="topbar-right text-end">';
							foreach( $selected_nav as $item ){
								echo '<a href="'. esc_url( $item->url ) .'">'. hostim_kses_post($item->title) .'</a>';
							}
							echo '</div>';
						} ?>

                    </div>
                </div>
            </div>
        </div>
		<?php
	} ?>
    <div class="header-nav">
        <div class="container">
            <div class="nav-menu <?php echo esc_attr( $nav_menu_bg ) ?>">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-2 col-lg-3 col-6">
                        <div class="logo-wrapper">
							<?php Hostim_Theme_Helper::branding_logo(); ?>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-9 col-6 d-flex align-items-center justify-content-end">
                        <div class="nav-wrapper d-none d-lg-block <?php echo esc_attr( $menu_alignment ) ?>">
                            <nav>
								<?php
								if ( has_nav_menu( 'primary' ) ) {
									wp_nav_menu( array (
										'theme_location' => 'primary',
										'container' => null,
										'menu_class' => 'navbar-nav menu mx-auto',
										'walker' => new Hostim_Main_Nav_Walker(),
										'depth' => 3
									));
								}
								else {
									echo '<ul><li><a target="_blank" href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__('Add Menu', 'hostim') . '</a></li></ul>';
								}
								?>
                            </nav>
                        </div>
                        <div class="header-right d-flex align-items-center justify-content-end">
							<?php
							if( $is_dark_mode == '1' ){ ?>
								<button class="dark-light-switcher me-2" id="theme-switch">
									<span class="light-sun"><i class="fa-solid fa-sun"></i></span>
									<span class="dark-moon"><i class="fa-solid fa-moon"></i></span>
								</button>
								<?php
							}
							if( $is_search_icon == '1' ){ ?>
                                <div class="header-search position-relative dropdown hr_item">
                                    <button class="border-0" data-bs-toggle="dropdown">
                                        <svg width="16" height="16" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.421875 7.58979C0.421875 7.27212 0.421875 6.95874 0.421875 6.64107C0.451875 6.43501 0.473304 6.22466 0.507589 6.0186C0.794732 4.31433 1.5833 2.8891 2.88188 1.75149C3.82902 0.918674 4.93045 0.382065 6.16473 0.137372C6.46045 0.0772716 6.76473 0.0429287 7.06473 0C7.38188 0 7.69902 0 8.01188 0C8.2133 0.0257572 8.41902 0.0472216 8.61616 0.0815645C10.279 0.360601 11.6976 1.09897 12.8204 2.36537C14.3376 4.06964 14.9162 6.06582 14.5604 8.31958C14.3847 9.43573 13.939 10.4488 13.2619 11.3546C13.2019 11.4319 13.1462 11.5135 13.0519 11.638C13.1162 11.6809 13.1847 11.7109 13.2319 11.7582C14.8176 13.3379 16.399 14.9177 17.9762 16.5061C18.1433 16.6778 18.2676 16.8881 18.4133 17.0856C18.4133 17.1929 18.4133 17.296 18.4133 17.4033C18.3062 17.5578 18.2247 17.7467 18.079 17.8583C17.7704 18.1073 17.3847 18.0343 17.059 17.7081C15.4304 16.0811 13.8019 14.4541 12.1776 12.8271C12.1262 12.7756 12.0962 12.6983 12.0533 12.6339C11.9933 12.6854 11.9804 12.6897 11.9719 12.694C11.9119 12.7369 11.8519 12.7842 11.7876 12.8271C9.71759 14.2995 7.46759 14.6773 5.08473 13.793C2.68902 12.9044 1.20616 11.1572 0.589018 8.68018C0.511875 8.32387 0.481875 7.95469 0.421875 7.58979ZM13.1719 7.13475C13.159 4.04388 10.6862 1.52826 7.57473 1.5068C4.51473 1.48533 1.95616 3.95373 1.92188 7.09611C1.88759 10.1655 4.41188 12.7369 7.53616 12.7412C10.6176 12.7498 13.1376 10.2943 13.1719 7.13475Z" fill="#001042" />
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end bg-transparent border-0">
                                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="header-search-form">
                                            <input type="text" id="<?php echo esc_attr($unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'hostim' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                            <input type="submit" value="Go">
                                        </form>
                                    </div>
                                </div>
								<?php
							} ?>
                            <div class="ofcanvus-btns hr_item next">
								<?php
								if( $is_panel_on == '1' ){ ?>
                                    <a href="#" class="ofcanvus-btn d-none d-lg-block"><i class="fa-solid fa-bars-staggered"></i></a>
									<?php
								} ?>
                                <a href="#" class="mobile-menu-toggle d-lg-none"><i class="fa-solid fa-bars-staggered"></i></a>
                            </div>

							<?php
							if ( $is_cta_enabled != '1' ){
								if( $is_cta_enabled == 'enabled' && !empty( $meta['cta_btn']['text'] ) ){
									$btn_style = !empty( $meta['select_btn_style'] ) ? $meta['select_btn_style'] : 'primary-btn';
									$game_btn = $btn_style == 'gm-header-btn' ? '<span><img src="'. HOSTIM_THEME_URI .'/assets/images/shape/angle_arrow.png" alt="angle arrow"></span>' : '';
									echo '<a href="'. esc_url( $meta['cta_btn']['url'] ) .'" class="template-btn ms-4 d-none d-lg-inline-block '. esc_attr( $btn_style ) .'">'. esc_html( $meta['cta_btn']['text'] ) . hostim_kses_post( $game_btn ).'</a>';
								}
								
							}
                            elseif( $is_cta_enabled == '1' && ! is_home() && !is_singular('post') ) {
								
								$cta_btn_label = hostim_option('button_label');
								$cta_url	   = hostim_option('button_link');
								echo '<a href="'. esc_url( $cta_url ) .'" class="template-btn ms-4 d-none d-lg-inline-block primary-btn ">'. esc_html( $cta_btn_label ) .'</a>';
								
							}
							elseif( $cta_btn_blog == '1' && ( is_home() || is_singular('post') ) ){
								$cta_btn_label = hostim_option('button_label');
								$cta_url	   = hostim_option('button_link');
								echo '<a href="' . esc_url($cta_url) . '" class="template-btn ms-4 d-none d-lg-inline-block primary-btn ">' . esc_html($cta_btn_label) . '</a>';
							}
							?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>