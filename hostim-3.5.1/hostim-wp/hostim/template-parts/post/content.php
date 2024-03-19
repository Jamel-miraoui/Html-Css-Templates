<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hostim
 */

$content       = apply_filters( 'the_content', get_the_content() );
$meta          = get_post_meta( get_the_ID(), 'hostim-post-video', true );
$videothumb    = ! empty( $meta['video-thumbnail'] ) ? $meta['video-thumbnail'] : '';
$meta_gallery  = get_post_meta( get_the_ID(), 'themename-post-gallery', true );
$category_list = get_the_category_list( ', ' );
$author = hostim_option( 'blog_list_meta_author', true );
$meta_date = hostim_option( 'blog_list_meta_date', false );
$meta_comments = hostim_option( 'blog_list_meta_comments', true );
$meta_category = hostim_option( 'blog_list_meta_categories', true );
$word_count = hostim_option('word_count', '25');

?>


<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-list entry-post' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail-wrapper">
			<?php Hostim_Theme_Helper::hostim_post_thumbnail(); ?>

			<?php $category_list = get_the_category_list();

			$terms    = get_the_terms( get_the_ID(), 'category' );
			$cat_temp = '';

			if ( ( $terms && ! is_wp_error( $terms ) ) && $meta_category == '1' ) : ?>
				<div class="meta-category-wrapper">
					<?php foreach ( $terms as $term ) {
						$cat_temp .= '<a href="' . get_category_link( $term->term_id ) . '" class="hostim-blog-meta-category" rel="category tag">' . esc_html( $term->name ) . '</a>';
					}
					echo wp_kses_post( $cat_temp ); ?>
				</div>
			<?php endif; ?>
		</div>
		<!-- /.post-thumbnail-wrapper -->
	<?php endif; ?>



	<div class="blog-content">
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="post-meta-wrapper">
				<?php
				if ( 'post' === get_post_type() ) : ?>
					<ul class="post-meta">
						<?php

						if ( $author == '1' ) : ?>
							<li class="author-simple">
								<?php echo Hostim_Theme_Helper::hostim_posted_author_avatar(); ?>
							</li>
						<?php endif; ?>

						<?php if ( $meta_date == '1' ) : ?>
							<li><i class="feather-calendar"></i><?php echo get_the_date(); ?></li>
						<?php endif; ?>

						<?php if ( $meta_comments == '1' ) : ?>
							<li>
								<i class="feather-message-square"></i><?php Hostim_Theme_Helper::hostim_entry_comments( get_the_ID() ); ?>
							</li>
						<?php endif; ?>

					</ul><!-- .entry-meta -->
				<?php endif; ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>

		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<div class="entry-content">
			<p>

				<?php echo Hostim_Theme_Helper::hostim_substring( get_the_content(), $word_count, '...' ); ?>
			</p>

			<footer class="blog-footer">
				<a href="<?php the_permalink(); ?>" class="hostim-btn">
					<?php echo esc_html__( 'Read More', 'hostim' ); ?>
					<i class="fas fa-arrow-right"></i>
				</a>
			</footer>

			<?php if ( is_singular() ) {
				wp_link_pages();
			} ?>
		</div>
	</div><!-- /.entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
