<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package hostim
 */

get_header();

$sidebar 		= Hostim_Theme_Helper::render_sidebars('blog');
$row_class		= $sidebar['row_class'];
$column			= $sidebar['column'];
$meta_category	= hostim_option( 'blog_list_meta_categories');
$post_share_icon= hostim_option( 'post_share_icon', false );
$feature_image	= hostim_option( 'is_feature_image', true );
$author_name	= hostim_option( 'blog_details_meta_author', true );
$post_date		= hostim_option( 'blog_details_meta_comments', true );
$post_comments	= hostim_option( 'blog_details_meta_date', true );
$post_navigation= hostim_option( 'single_post_nav', true );
$author_info	= hostim_option( 'author_info', false );
$video_post = has_post_format( 'video' ) ? 'video_post' : '';
$thumb_size = (isset($sidebar['content']) && !empty($sidebar['content']) ) ? 'hostim_blog_848x440' : 'full';

Hostim_Theme_Helper::get_hostim_banner();

if ( isset($_GET['elementor_library']) ) {
    while (have_posts()) : the_post();
        the_content();
        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'hostim') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . esc_html__('Page', 'hostim') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
        ));
    endwhile;
} else { ?>

	<section class="hm-blog-grids pt-120 pb-120 overflow-hidden">
		<div class="container">
			<div class="row g-5">
				<div class="col-xl-<?php echo esc_attr( $column ); ?>">
					<div class="hm-blog-grid-left bg-white deep-shadow rounded-5">
						<div class="hm2-blog-card">
							<?php
							$p_class = 'pt-5';
							if( has_post_thumbnail() && $feature_image == true ){ ?>
								<div class="feature-img rounded-top overflow-hidden">
									<?php the_post_thumbnail( $thumb_size, array('class'=>'img-fluid') ) ?>
								</div>
								<?php
								$p_class = '';
							}
							?>
							
							<div class="bd-content-wrapper <?php echo esc_attr( $p_class ) ?>">
								<?php 
								while( have_posts() ){ 
									the_post(); ?>

									<div class="bd-blog-meta d-flex align-items-center flex-wrap mb-4">
										<?php 
										if( $author_name == true){
											echo '<span class="post_meta_author">'.Hostim_Theme_Helper::hostim_posted_author_avatar().'</span>';
										}
										if( $post_date == true ){
											echo '<span class="post_meta_date"><i class="far fa-calendar"></i>' . Hostim_Theme_Helper::hostim_archive_url() .'</span>';
										}
										if( $post_comments == true ){
											echo '<span class="post_meta_comment"><i class="far fa-comment"></i>';
											Hostim_Theme_Helper::hostim_entry_comments(get_the_ID());
											echo '</span>';
										}
										?>
									</div>
									
									<div class="hostim_blog_content">
										<?php 
										the_content(); 
										
										wp_link_pages( array(
											'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hostim' ),
											'after'  => '</div>',
										) );
										?>
									</div>
									<?php 
								} 
								if( has_tag() || $post_share_icon == true ){ ?>
								
									<div class="bd-blog-bottom mt-4">
										<div class="row g-4">
											<?php 
											if( $post_share_icon == true ){ ?>
												<div class="col-md-6">
													<?php echo Hostim_Theme_Helper::render_post_list_share(); ?>
												</div> 
												<?php 
											} ?>

											<?php 
											if( has_tag() ){ 
												$col_full = $post_share_icon == false ? 'col-lg-12' : 'col-lg-6';
												?>
												<div class="<?php echo esc_attr( $col_full )?>">
													<?php echo Hostim_Theme_Helper::hostim_posted_tag( 'bd-blog-tags' ) ?>
												</div>
												<?php
											}
											?>
										</div>
									</div>
									<?php
								}

								if( !empty( get_the_author_meta( 'description' ) ) && $author_info == true ){
									echo Hostim_Theme_Helper::render_author_info();
								}
								
								if( $post_navigation == true ){
									echo Hostim_Theme_Helper::tt_post_nav(); 
								}
								
								if (comments_open() || get_comments_number()) :
									comments_template();
								endif;
								?>
							</div>
						
						</div>
					</div>
				</div>
				<?php echo (isset($sidebar['content']) && !empty($sidebar['content'])) ? $sidebar['content'] : ''; ?>
			</div>
		</div>
	</section>

<?php
}


get_footer();