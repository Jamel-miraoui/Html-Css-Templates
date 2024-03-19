<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package hostim
 */

get_header();

$sidebar = Hostim_Theme_Helper::render_sidebars();
$row_class = $sidebar['row_class'];
$column = $sidebar['column'];

?>
<section class="hm-blog-grids pt-120 pb-120 overflow-hidden">
    <div class="container">
        <div class="row g-5 <?php echo apply_filters('tt_row_class', $row_class); ?>">
            <div class="col-xl-<?php echo esc_attr( $column ); ?>">
                <div class="hm-blog-grid-left">
                    <?php 
                    if( have_posts() ){ ?>
                        <div class="row g-4">

                            <?php 
                            while( have_posts() ){
                                the_post();
                                get_template_part( 'template-parts/post/posts-list');      
                            }
                            ?>
                            
                        </div>
                        
                        <?php 
                        Hostim_Theme_Helper::hostim_post_pagination(); 
                    }
                    else{ ?>
                        <div class="search_page_404_wrapper">
                                <div class="search-header-404">
                                    <h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'hostim' ); ?></h2>
                                </div>

                                <div class="hostim-page-content">
                                    <?php if ( is_search() ) : ?>
                                        <p class="banner_404_text">
                                            <?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hostim' ); ?>
                                        </p>
                                        <div class="search_result_form text-center">
                                            <?php get_search_form(); ?>
                                        </div>
                                        <div class="tt_home_button">
                                            <a class="template-btn primary-btn me-4 mt-3" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Take me home', 'hostim'); ?></a>
                                        </div>
                                    <?php else : ?>
                                        <p class="banner_404_text">
                                            <?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hostim' ); ?>
                                        </p>
                                        <div class="search_result_form text-center">
                                            <?php get_search_form(); ?>
                                        </div>

                                        <div class="tt_404_button ">
                                            <a class="template-btn primary-btn me-4" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Take me home', 'hostim'); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php 
                    } ?>

                </div>
            </div>
            <?php echo (isset($sidebar['content']) && !empty($sidebar['content']) ) ? $sidebar['content'] : ''; ?>
        </div>
    </div>
</section>

<?php

get_footer();
