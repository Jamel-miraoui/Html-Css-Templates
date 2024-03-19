<?php

// Render wrapper
$column = hostim_option('blog_column');

?>
<div class="blog-posts blog-posts-grid">
	<div class="row">
		<?php if (have_posts()) :
			while (have_posts()) : the_post(); ?>
				<div class="blog-grid-item col-md-<?php echo esc_attr( $column ) ?>">
				<?php get_template_part('template-parts/post/content', 'grid'); ?>
			</div>
			<?php endwhile;
		endif;
		?>
	</div>
	<!-- /.row -->
</div>
