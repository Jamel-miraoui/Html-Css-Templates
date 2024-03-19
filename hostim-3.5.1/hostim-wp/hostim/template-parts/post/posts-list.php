<?php
// Render wraper
$word_count = hostim_option('word_count', '45');
$no_thumb   = has_post_thumbnail() ? 'position-absolute' : 'no_thumb';
$video_post = has_post_format( 'video' ) ? 'video_post' : '';
$thumb_size = (isset($sidebar['content']) && !empty($sidebar['content']) ) ? 'hostim_blog_848x440' : 'full';
 ?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'col-md-12' ); ?>>
	<div class="hm2-blog-card bg-white <?php echo esc_attr( $video_post ) ?>">
		<?php 
		if( has_post_thumbnail() ){ ?>
			<div class="feature-img rounded-top overflow-hidden">	
				<a href="<?php the_permalink() ?>">
					<?php the_post_thumbnail( $thumb_size, array('class'=>'img-fluid') )?>
				</a>
			</div>
			<?php 
		} ?>
		<div class="hm2-blog-card-content position-relative">
			
			<?php Hostim_Theme_Helper::hostim_entry_cat( 'category', 'tag-btn rounded-pill '.$no_thumb  ); ?>

			<a href="<?php the_permalink() ?>">
				<h3 class="h3 mb-3 blog_post_title">
					<?php
					if( !empty( get_the_title() ) ){
						the_title();
					}
					else{
						echo __( 'No title', 'hostim' );
					} ?>
				</h3>
			</a>
			<?php echo wpautop( Hostim_Theme_Helper::hostim_substring( get_the_content(), $word_count, '...' ) ); ?>
			<hr class="spacer mt-20 mb-20">
			<div class="bog-author d-flex align-items-center">
				<span class="post_meta_author">
					<?php echo Hostim_Theme_Helper::hostim_posted_author_avatar(); ?>
				</span>
				<span class="post_meta_date">
					<i class="far fa-calendar"></i>
					<?php echo Hostim_Theme_Helper::hostim_archive_url(); ?>
				</span>
				<span class="post_meta_comment">
					<i class="far fa-comment"></i>
					<?php Hostim_Theme_Helper::hostim_entry_comments( get_the_ID() ) ?>
				</span>
			</div>
		</div>
	</div>
</div>