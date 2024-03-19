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
                    else{
                        get_template_part( 'template-parts/post/content-none');  
                    } ?>

                </div>
            </div>
            <?php echo (isset($sidebar['content']) && !empty($sidebar['content']) ) ? $sidebar['content'] : ''; ?>
        </div>
    </div>
</section>

<?php

get_footer();
