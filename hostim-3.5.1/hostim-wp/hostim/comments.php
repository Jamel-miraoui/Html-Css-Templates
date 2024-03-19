<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage hostim
 * @since 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}

if (have_comments() || comments_open()) {
	echo '<div id="comments">';
}
if (have_comments()) : 

$post_share_icon = hostim_option( 'post_share_icon', false );
$spacer_class = has_tag() || $post_share_icon == true ? 'mt-80 mb-80' : 'mt-40 mb-40'; ?>

	<div class="bd-comment-area">
		<hr class="spacer <?php echo esc_attr( $spacer_class ) ?>">
		<h3 class="comments-title mb-0">
			<?php
				$comments_number = get_comments_number();
				if ('1' === $comments_number) {
					/* translators: %s: post title */
					printf(_x('<span class="number-comments">1</span> Comment', 'comments title', 'hostim'));
				} else {
					$comments_number = (int)$comments_number < 10 ? $comments_number : $comments_number;
					printf(
						_nx(
							'<span class="number-comments">%1$s</span> Comments',
							'<span class="number-comments">%1$s</span> Comments',
							$comments_number,
							'comments title',
							'hostim'
						),
						$comments_number
					);
				}
			?>
		</h3>

		<ol class="comment-lists">
			<?php wp_list_comments(array(
				'walker' => new Hostim_Walker_Comment(),
				'avatar_size' => 60,
				'short_ping' => true
			));	?>
		</ol>
		<?php if (get_comment_pages_count() > 1) { ?>
			<div><?php paginate_comments_links(); ?></div>
		<?php } ?>
	</div>

<?php endif; ?>

	<div class="bd-comment-form">
		<?php
			$row_start = !is_user_logged_in() ? '<div class="row g-4">' : '';
			$row_close = !is_user_logged_in() ? '</div>' : '</div>';
			$cf_row_start = is_user_logged_in() ? '<div class="row g-4">' : '';

			$args = array();
			$args['fields'] = array(
				'author'	=> $row_start. '<div class="col-md-6"><div class="input-field"><input type="text" name="author" placeholder="' . esc_attr__('Full Name *', 'hostim') . '" title="' . esc_attr__('Full Name *', 'hostim') . '"></div></div>',
				'email'		=> '<div class="col-md-6"><div class="input-field"><input type="email" name="email" placeholder="' . esc_attr__('Email Address *', 'hostim') . '" title="' . esc_attr__('Email Address *', 'hostim') . '"></div></div>',
				 
			);
			$args['comment_field']	= $cf_row_start.'<div class="col-md-12"><div class="input-field"><textarea rows="5" name="comment" placeholder="' . esc_attr__('Write Comment', 'hostim') . '"></textarea></div></div>'.$row_close;
			$args['class_submit']	= 'template-btn primary-btn border-0 rounded-pill';
			

			ob_start();
			comment_form($args);
			$comment_form = ob_get_clean();
			echo trim($comment_form);
		?>
	</div>
	<!-- /.comment-wrapper -->

<?php
if (have_comments() || comments_open()) {
	echo '</div>';
}