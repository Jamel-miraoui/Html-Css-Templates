<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hostim
 */

get_header();

$sidebar = Hostim_Theme_Helper::render_sidebars('blog');
$row_class = $sidebar['row_class'];
$column = $sidebar['column'];
$blog_style = hostim_option('blog_style', 'list');

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
                                get_template_part( 'template-parts/post/posts', $blog_style);      
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