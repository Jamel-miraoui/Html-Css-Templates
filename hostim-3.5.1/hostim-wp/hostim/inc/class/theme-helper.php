<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Hostim Theme Helper
 *
 *
 * @class        Hostim_Theme_Helper
 * @version      1.0
 * @category 	 Class
 * @author       ThemeTags
 */

if ( ! class_exists( 'Hostim_Theme_Helper' ) ) {
	class Hostim_Theme_Helper {

		/**
		 * Constructor
		 */
		function __construct() {
			add_action( 'hostim_after_body', array( $this, 'hostim_preloader_markup' ), 1 );
		}


		/**
		 * Settings Compare function
		 *
		 * @param [type] $name
		 * @param boolean $check_key
		 * @param boolean $check_value
		 *
		 * @return void
		 */
		public static function options_compare( $name, $check_key = false, $check_value = false ) {
			$option = hostim_option( $name );
			$meta   = get_post_meta( get_the_ID(), 'tt_page_options', true );

			//Check if check_key exist
			if ( $check_key ) {
				if ( $meta[ $check_key ] == $check_value ) {
					$option = $meta[ $name ];
				}

			} else {
				$var    = $meta[ $name ];
				$option = ! empty( $var ) ? $meta[ $name ] : hostim_option( $name );
			}

			return $option;
		}

		/**
		 * Utility methods
		 * ---------------
		 */


		static function hostim_breadcrumb( $class = '') {

			// Settings
			$separator	         = '|';
			$breadcrums_id	     = 'breadcrumbs';
			$breadcrums_class	 = 'breadcrumb ' . $class;
			$home_title          = esc_html__('Home',  'hostim' );

			// If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
			$custom_taxonomy	 = 'product_cat';

			// Get the query & post information
			global $post;

			// Do not display on the homepage
			if ( !is_front_page() && !is_search() ) {

				// Build the breadcrums
				echo '<ol id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

				// Home page
				echo '<li class="breadcrumb-item item-home"><a class="breadcrumb-link breadcrumb-home" href="' . esc_url(get_home_url()) . '" title="' . $home_title . '">' . $home_title . '</a></li>';
				if ( is_author() ) {

					// If post is a custom post type
					$post_type = get_post_type();

					$custom_tax_name = get_the_author_meta('display_name');
					echo '<li class="breadcrumb-item item-current item-archive"><span class="breadcrumb-current breadcrumb-archive">' . $custom_tax_name . '</span></li>';
				} else if (class_exists( 'hostim' ) && is_product()) {
						echo '<li class="breadcrumb-item item-current item-archive"><span class="breadcrumb-current breadcrumb-archive">' . get_the_title('') . '</span></li>';
				} else if (class_exists( 'hostim' ) && is_woocommerce()) {
					echo '<li class="breadcrumb-item item-current item-archive"><span class="breadcrumb-current breadcrumb-archive">' . woocommerce_page_title('') . '</span></li>';
				} else if (class_exists( 'bbPress' ) && is_bbpress() ) {
					echo '<li class="breadcrumb-item item-current item-archive"><span class="breadcrumb-current breadcrumb-archive">' . get_the_title() . '</span></li>';
				} else if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

					echo '<li class="breadcrumb-item item-current item-archive"><span class="breadcrumb-current breadcrumb-archive">' . get_the_archive_title() . '</span></li>';

				} else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

					// If post is a custom post type
					$post_type = get_post_type();

					// If it is a custom post type display name and link
					if($post_type != 'post') {

						$post_type_object = get_post_type_object($post_type);
						$post_type_archive = get_post_type_archive_link($post_type);

						echo '<li class="breadcrumb-item item-cat item-custom-post-type-' . $post_type . '"><a class="breadcrumb-cat breadcrumb-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';

					}

					$custom_tax_name = get_queried_object()->name;
					echo '<li class="breadcrumb-item item-current item-archive"><span class="breadcrumb-current breadcrumb-archive">' . $custom_tax_name . '</span></li>';

				} else if ( is_single() ) {

					// If post is a custom post type
					$post_type = get_post_type();

					// If it is a custom post type display name and link
					if($post_type != 'post') {

						$post_type_object = get_post_type_object($post_type);
						$post_type_archive = get_post_type_archive_link($post_type);

						echo '<li class="breadcrumb-item item-cat item-custom-post-type-' . $post_type . '"><a class="breadcrumb-cat breadcrumb-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';

					}

					// Get post category info
					$category = get_the_category();

					if(!empty($category)) {

						// Get last category post is in
						$all_category = array_values($category);
						$last_category = end($all_category);

						// Get parent any categories and create array
						$get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
						$cat_parents = explode(',',$get_cat_parents);

						// Loop through parent categories and store in variable $cat_display
						$cat_display    = '';
						foreach($cat_parents as $parents) {
							$cat_display .= $parents;
						}

					}

					// Check if the post is in a category
					if(!empty( $last_category ) ) {
						echo  '<li class="breadcrumb-item item-cat"> ' . $cat_display . ' </li>';
						echo '<li class="breadcrumb-item item-current item-' . $post->ID . '"><span class="breadcrumb-current breadcrumb-' . $post->ID . '" title="' . get_the_title() . '">'. wp_trim_words( get_the_title(), 3, '...' ) .'</span></li>';

						// Else if post is in a custom taxonomy
					} else if(!empty($cat_id)) {

						echo '<li class="breadcrumb-item item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="breadcrumb-cat breadcrumb-cat-' . $cat_id . ' breadcrumb-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
						echo '<li class="breadcrumb-item item-current item-' . $post->ID . ' active">' . get_the_title() . '</li>';

					} else {

						echo '<li class="breadcrumb-item item-current item-' . $post->ID . ' active">' . get_the_title() . '</li>';

					}

				} else if ( is_category() ) {

					// Category page
					echo '<li class="breadcrumb-item item-current item-cat"><span class="breadcrumb-current breadcrumb-cat">' . single_cat_title('', false) . '</span></li>';

				} else if ( is_home() ) {
					echo '<li class="breadcrumb-item active item-cat"><span class="breadcrumb-current breadcrumb-cat">' . wp_title('', false) . '</span></li>';

				} else if ( is_page() ) {

					// Standard page
					if( $post->post_parent ){

						// If child page, get parents
						$anc = get_post_ancestors( $post->ID );

						// Get parents in the right order
						$anc = array_reverse($anc);
						$parents = '';
						// Parent page loop
						foreach ( $anc as $ancestor ) {
							$parents .= $ancestor;
							echo '<li class="breadcrumb-item item-parent item-parent-' . $ancestor . '"><a class="breadcrumb-parent breadcrumb-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
						}

						// Current page
						echo '<li class="breadcrumb-item item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';

					} else {

						// Just display current page if not parents
						echo '<li class="breadcrumb-item item-current item-' . $post->ID . '"><span class="breadcrumb-current breadcrumb-' . $post->ID . '"> ' . get_the_title() . '</span></li>';

					}

				} else if ( is_tag() ) {

					// Tag page

					// Get tag information
					$term_id	 = get_query_var('tag_id');
					$taxonomy	 = 'post_tag';
					$args	 = 'include=' . $term_id;
					$terms	 = get_terms( $taxonomy, $args );
					$get_term_id	 = $terms[0]->term_id;
					$get_term_slug	 = $terms[0]->slug;
					$get_term_name	 = $terms[0]->name;

					// Display the tag name
					echo '<li class="breadcrumb-item item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><span class="breadcrumb-current breadcrumb-tag-' . $get_term_id . ' breadcrumb-tag-' . $get_term_slug . '">' . $get_term_name . '</span></li>';

				} elseif ( is_day() ) {

					// Day archive

					// Year link
					echo '<li class="breadcrumb-item item-year item-year-' . get_the_time('Y') . '"><a class="breadcrumb-year breadcrumb-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'hostim') .'</a></li>';
					echo '<li class="breadcrumb-item separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

					// Month link
					echo '<li class="breadcrumb-item item-month item-month-' . get_the_time('m') . '"><a class="breadcrumb-month breadcrumb-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . esc_html__(' Archives', 'hostim') .'</a></li>';
					echo '<li class="breadcrumb-item separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

					// Day display
					echo '<li class="breadcrumb-item item-current item-' . get_the_time('j') . '"><span class="breadcrumb-current breadcrumb-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . esc_html__(' Archives', 'hostim') .'</span></li>';

				} else if ( is_month() ) {

					// Month Archive

					// Year link
					echo '<li class="breadcrumb-item item-year item-year-' . get_the_time('Y') . '"><a class="breadcrumb-year breadcrumb-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'hostim') .' </a></li>';
					echo '<li class="breadcrumb-item separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

					// Month display
					echo '<li class="breadcrumb-item item-month item-month-' . get_the_time('m') . '"><span class="breadcrumb-month breadcrumb-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . esc_html__(' Archives', 'hostim') .' </span></li>';

				} else if ( is_year() ) {

					// Display year archive
					echo '<li class="breadcrumb-item item-current item-current-' . get_the_time('Y') . '"><span class="breadcrumb-current breadcrumb-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'hostim').' </span></li>';

				} else if ( is_author() ) {

					// Auhor archive

					// Get the author information
					global $author;
					$userdata = get_userdata( $author );

					// Display author name
					echo '<li class="breadcrumb-item item-current item-current-' . $userdata->user_nicename . '"><span class="breadcrumb-current breadcrumb-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . esc_html__( 'Author: ', 'hostim' ) . $userdata->display_name . '</span></li>';

				} else if ( get_query_var('paged') ) {

					// Paginated archives
					echo '<li class="breadcrumb-item item-current item-current-' . get_query_var('paged') . '"><span class="breadcrumb-current breadcrumb-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.esc_html__('Page', 'hostim' ) . ' ' . get_query_var('paged') . '</span></li>';

				} elseif ( is_404() ) {

					// 404 page
					echo '<li>'. esc_html__('404 Error', 'hostim') .'</li>';
				}

				echo '</ol>';

			}

		}




		/**
		 * Displays navigation to next/previous pages when applicable.
		 *
		 * @since hostim 1.0
		 */
		static function hostim_content_nav( $html_id ) {
			global $wp_query;
			$html_id = esc_attr( $html_id );
			if ( $wp_query->max_num_pages > 1 ) : ?>
				<nav id="<?php echo esc_attr( $html_id ); ?>" class="navigation" role="navigation">
					<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'hostim' ); ?></h3>
					<div class="nav-previous"><?php next_posts_link( wp_kses( __( '<span class="meta-nav">&larr;</span> Older posts', 'hostim' ), array( 'span' => array( 'class' => array() ) ) ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( wp_kses( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'hostim' ), array( 'span' => array( 'class' => array() ) ) ) ); ?></div>
				</nav>
			<?php endif;
		}

		/* Pagination */

		static function hostim_post_pagination( $nav_query = false ) {

			global $wp_query, $wp_rewrite;

			// Don't print empty markup if there's only one page.
			if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
				return;
			}

			// Prepare variables
			$query        = $nav_query ? $nav_query : $wp_query;
			$max          = $query->max_num_pages;
			$current_page = max( 1, get_query_var( 'paged' ) );
			$big          = 999999;


			echo '<div class="template-pagination mt-60">';
			echo '' . paginate_links( array(
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => $current_page,
					'total'     => $max,
					'type'      => 'list',
					'prev_text' => '<i class="fa fa-angle-left"></i>',
					'next_text' => '<i class="fa fa-angle-right"></i>'
				) ) . ' ';
			echo '</div>';
		}

		/**
		 * Template for comments and pingbacks.
		 *
		 * To override this walker in a child theme without modifying the comments template
		 * simply create your own hostim_comment(), and that function will be used instead.
		 *
		 * Used as a callback by wp_list_comments() for displaying the comments.
		 *
		 * @since hostim 1.0
		 */
		static function hostim_comment( $comment, $args, $depth ) {
			$GLOBALS['comment'] = $comment;
			switch ( $comment->comment_type ) :
				case 'pingback' :
				case 'trackback' :
					// Display trackbacks differently than normal comments.
					?>
					<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p><?php esc_html_e( 'Pingback:', 'hostim' ); ?><?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'hostim' ), '<span class="edit-link">', '</span>' ); ?></p>
					<?php
					break;
				default :
					// Proceed with normal comments.
					global $post;
					?>
					<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<div class="comment-avatar">
							<?php echo get_avatar( $comment, 50 ); ?>
						</div>
						<div class="comment-info">
							<header class="comment-meta comment-author vcard">
								<?php
								printf( '<cite><b class="fn">%1$s</b> %2$s</cite>', get_comment_author_link(), // If current post author is also comment author, make it known visually.
								        ( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author', 'hostim' ) . '</span>' : '' );
								printf( '<time datetime="%1$s">%2$s</time>', get_comment_time( 'c' ), /* translators: 1: date, 2: time */ sprintf( esc_html__( '%1$s at %2$s', 'hostim' ), get_comment_date(), get_comment_time() ) );
								?>
								<div class="reply">
									<?php comment_reply_link( array_merge( $args, array(
										'reply_text' => esc_html__( 'Reply', 'hostim' ),
										'after'      => '',
										'depth'      => $depth,
										'max_depth'  => $args['max_depth']
									) ) ); ?>
								</div><!-- .reply -->
							</header><!-- .comment-meta -->
							<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'hostim' ); ?></p>
							<?php endif; ?>
							<section class="comment-content comment">
								<?php comment_text(); ?>
								<?php edit_comment_link( esc_html__( 'Edit', 'hostim' ), '<p class="edit-link">', '</p>' ); ?>
							</section><!-- .comment-content -->
						</div>
					</article><!-- #comment-## -->
					<?php
					break;
			endswitch; // end comment_type check
		}

		/**
		 * Set up post entry meta.
		 *
		 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
		 *
		 * Create your own hostim_entry_meta() to override in a child theme.
		 *
		 * @since hostim 1.0
		 */
		static function hostim_post_tags( $class ) {
			$tag_list       = get_the_tags();

			if( is_array( $tag_list ) && count( $tag_list ) > 0 ){
				echo '<div class="hostim_tags"><span class="me-2"><i class="fa-solid fa-tags"></i></span>';
				foreach( $tag_list as $tag ){
					echo '<a href="'. get_term_link( $tag->term_id ) .'" class="hostim_tag '. esc_attr( $class ) .'">'. esc_html( $tag->name ) .'</a>';
				}
				echo '</div>';
			}

		}

		// Comment Number
		static function hostim_get_comment_number(){

			$num_comments   = (int) get_comments_number();
			$write_comments = '';
			if ( comments_open() ) {
				if ( $num_comments == 0 ) {
					$comments = esc_html__( ' 0 Comment', 'hostim' );
				} elseif ( $num_comments > 1 ) {
					$comments = $num_comments . esc_html__( ' Comments', 'hostim' );
				} else {
					$comments = esc_html__( ' 1 Comment', 'hostim' );
				}
				$write_comments = '<a href="' . get_comments_link() . '" class="comment_count"><i class="fa-solid fa-comment"></i>' . $comments . '</a>';
			}
			return $write_comments;
		}

		static function hostim_entry_meta_small() {
			// Translators: used between list items, there is a space after the comma.
			$author          = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_attr( sprintf( wp_kses( __( 'View all posts by %s', 'hostim' ), array( 'a' => array() ) ), get_the_author() ) ), get_the_author() );
			$utility_text    = esc_html__( '%1$s', 'hostim' );
			printf( $utility_text, $author );
		}

		// Avatar ======================
		static function hostim_posted_author_avatar() {
			global $post;
			printf( '<a class="d-inline-flex align-items-center" href="%1$s"> %2$s <h6 class="ms-2 mb-0 hostim_post_author">%3$s</h6></a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_avatar( get_the_author_meta( 'ID' ), 35, '', '', array('class'=>'img-fluid rounded-circle') ), esc_html( get_the_author() ) );
		}


		// Post Author ================
		static function hostim_get_posted_by() {
			$hostim_post_author = sprintf( esc_html_x( '%s', 'post author', 'hostim' ), '<a class="hostim_post_author" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>' );

			return $hostim_post_author;

		}

		// Post categories ==============
		static function hostim_entry_cat( $term = 'category', $class = '' ) {
			if ( 'post' === get_post_type() ) {
				$cats 	= get_the_terms(get_the_ID(), $term);
				$class	= !empty( $class ) ? $class : 'cat_item';
				if( is_array( $cats ) ){
					foreach( $cats as $cat ){
						echo '<a href="'. esc_url( get_term_link( $cat->term_id, $term ) ) .'" class="'. esc_attr( $class ) .'">'. esc_html( $cat->name ) .'</a>';
					}

				}

			}

		}

		static function hostim_posted_tag( $class = 'tagcloud' ) {
			// Hide category and tag text for pages.
			if ( 'post' === get_post_type() ) {

				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'hostim' ) );
				if ( $tags_list ) {
					/* translators: 1: list of tags. */
					printf( '<div class="'.esc_attr( $class ).'"><span class="tag-title">' . esc_html( 'Tags:', 'hostim' ) . '</span>' . esc_html__( '%1$s', 'hostim' ) . '</div>', $tags_list ); // WPCS: XSS OK.
				}
			}
		}

		/**
		 * Trim text
		 */
		static function hostim_substring( $string, $limit, $afterlimit = '[...]' ) {
			if ( empty( $string ) ) {
				return $string;
			}
			$string = explode( ' ', strip_tags( $string ), $limit );

			if ( count( $string ) >= $limit ) {
				array_pop( $string );
				$string = implode( " ", $string ) . ' ' . $afterlimit;
			} else {
				$string = implode( " ", $string );
			}
			$string = preg_replace( '`[[^]]*]`', '', $string );

			return strip_shortcodes( $string );
		}

		/**
		 * Render sidebars.
		 *
		 * All Page Sidebar Control.
		 *
		 * @since hostim 1.0
		 */


		public static function render_sidebars( $args = 'blog' ) {
			$output        = array();
			$sidebar_style = '';

			$layout        = hostim_option( $args . '_sidebar_layout' ) ? hostim_option( $args . '_sidebar_layout' ) : 'right';
			$sidebar       = 'sidebar_main-sidebar';
			$sidebar_width = hostim_option( $args . '_sidebar_def_width', '8' );
			$sidebar_gap   = hostim_option( $args . '_sidebar_gap' );
			$sidebar_class = $sidebar_style = '';

			if ( isset( $sidebar_gap ) && $sidebar_gap != 'def' && $layout != 'default' ) {
				$layout_pos    = $layout == 'left' ? 'right' : 'left';
				$sidebar_style = 'style="padding-' . $layout_pos . ': ' . $sidebar_gap . 'px;"';
			}

			$column = 12;
			if ( $layout == 'left' || $layout == 'right' ) {
				$column = (int) $sidebar_width;
			} else {
				$sidebar = '';
			}

			if ( ! is_active_sidebar( $sidebar ) ) {
				$column  = 12;
				$sidebar = '';
				$layout  = 'none';
			}

			$output['column']    = $column;
			$output['row_class'] = $layout != 'none' ? ' sidebar_' . esc_attr( $layout ) : '';
			$output['layout']    = $layout;
			$output['content']   = '';

			if ( $layout == 'left' || $layout == 'right' ) {
				$output['content'] .= '<div class="sidebar-container ' . $sidebar_class . 'col-lg-' . ( 12 - (int) $column ) . '" ' . $sidebar_style . '>';
				if ( is_active_sidebar( $sidebar ) ) {
					$output['content'] .= "<aside class='sidebar'>";
					ob_start();
					dynamic_sidebar( $sidebar );
					$output['content'] .= ob_get_clean();
					$output['content'] .= "</aside>";
				}
				$output['content'] .= "</div>";
			}

			return $output;
		}


		/**
		 * @param $name
		 * Name of dynamic sidebar
		 * Check sidebar is active then dynamic it.
		 */
		public static function generated_sidebar( $name ) {
			if ( is_active_sidebar( $name ) ) {
				dynamic_sidebar( $name );
			}
		}

		private function post_author( $author ) {
			if ( ! (bool) $author ) {
				return;
			}

			return '<span class="post_author">' . esc_html__( "by", "hostim" ) . ' <a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></span>';
		}

		/**
		 * Display Post Thumbnail.
		 */
		static function hostim_post_thumbnail() {
			if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
				return;
			}

			if ( is_singular() ) : ?>

				<div class="feature-image">
					<?php the_post_thumbnail( 'full' ); ?>
				</div><!-- .post-thumbnail -->

			<?php else : ?>
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'full', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ) ) ); ?>
				</a>
			<?php
			endif; // End is_singular().
		}


		static function render_author_info() {
			$user_email       = get_the_author_meta( 'user_email' );
			$user_avatar      = get_avatar( $user_email, 110 );
			$user_first       = get_the_author_meta( 'first_name' );
			$user_last        = get_the_author_meta( 'last_name' );
			$user_description = get_the_author_meta( 'description' );
			?>

			<div class="bd-author-info mt-60 rounded d-block d-sm-flex align-items-center">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 110, '', '', array('class'=>'img-fluid flex-shrink-0 rounded-circle') ); ?>
				<div class="bd-author-info-right mt-3 mt-sm-0 ms-sm-3">
					<h6><?php echo get_the_author(); ?></h6>
					<p><?php echo esc_html( $user_description ); ?></p>
				</div>
			</div>

			<?php


		}

		/**
		 * Preloader.
		 *
		 * Preloader Init.
		 *
		 * @since hostim 1.0
		 */

		public function hostim_preloader_markup() {
			$preloader      = hostim_option( 'preloader' );
			$preloader_opt  = hostim_option( 'hostim_preloader' );
			$preloader_type = hostim_option( 'preloader-type' );
			$preloader_img  = hostim_option( 'preloader-images' );


			if ( ! empty( $preloader_opt ) ) :
				$style_name = substr( $preloader_opt, 0, - 2 );
				$style_div  = substr( $preloader_opt, - 1 );
				if ( $preloader ) : ?>

					<div id="preloader">
						<?php if ( $preloader_type == 'css' ) : ?>
							<div id="loader">
								<div class="loader-inner <?php echo esc_attr( $style_name ); ?>">
									<?php for ( $div = 0; $div < $style_div; $div ++ ) : ?>
										<div></div>
									<?php endfor; ?>
								</div>
							</div><!-- /#loader -->
						<?php elseif ( $preloader_type == 'preloader-img' ) : ?>
							<?php $img = wp_get_attachment_image_src( $preloader_img, 'full', true ); ?>

							<img class="pr" src="<?php echo esc_url( $img[0] ); ?>"
									width="<?php echo esc_attr( $img[1] ); ?>"
									height="<?php echo esc_attr( $img[2] ); ?>" alt="<?php get_bloginfo( 'name' ); ?>"/>
						<?php endif; ?>
					</div><!-- /#preloader -->
				<?php
				endif;
			endif;
		}


		public static function render_html( $args ) {
			return isset( $args ) ? $args : '';
		}

		static function hostim_entry_comments( $post_id, $no_comments = 'No Comments' ) {

			$comments_number = get_comments_number( $post_id );
			if ( $comments_number == 0 ) {
				$comment_text = $no_comments;
			} elseif ( $comments_number == 1 ) {
				$comment_text = esc_html__( '1 Comment', 'hostim' );
			} elseif ( $comments_number > 1 ) {
				$comment_text = $comments_number . esc_html__( ' Comments', 'hostim' );
			}
			echo '<a href="'. esc_url( get_comments_link( $post_id ) ) .'">'. esc_html( $comment_text ) .'</a>';

		}

		/** Post Archive Link */
		static function hostim_archive_url(){

			$archive_year  = get_the_time( 'Y' );
			$archive_month = get_the_time( 'm' );
			$archive_day   = get_the_time( 'd' );

			return '<a href="'. esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) .'">'. get_the_date() .'</a>';
		}


		/**
		 * Logo
		 */
		public static function branding_logo( $class = '' ) {

			$logo_main        = hostim_option( 'main_logo' );
			$sticky           = hostim_option( 'sticky_logo' );
			$retina_logo      = hostim_option( 'retina_logo' );
			$retina_sticky    = hostim_option( 'retina_logo_sticky' );
			$is_dark_mode     = hostim_option('is_dark_mode' );
			$dark_mode_logo   = hostim_option('dark_mode_logo' );

			// Logo Callback
			$logo               = ! empty( $logo_main['url'] ) ? $logo_main['url'] : '';
			$logo_contrast      = ! empty( $sticky['url'] ) ? $sticky['url'] : '';
			$retina_logo        = ! empty( $retina_logo['url'] ) ? $retina_logo['url'] : '';
			$retina_logo_sticky = ! empty( $retina_sticky ['url'] ) ? $retina_sticky ['url'] : '';
			$logo_class			= 'global-logo';

			// Logo Meta Callback
			$meta = get_post_meta( get_the_ID(), 'tt_page_options', true );

			$page_logo = isset( $meta['page_logo'] ) ? $meta['page_logo'] : '0';

			if ( $page_logo ) {
				$logo               = ! empty( $meta['meta_main_logo']['url'] ) ? $meta['meta_main_logo']['url'] : $logo;
				$logo_contrast      = ! empty( $meta['meta_sticky_logo']['url'] ) ? $meta['meta_sticky_logo']['url'] : $logo_contrast;
				$retina_logo        = ! empty( $meta['retina_logo']['url'] ) ? $meta['retina_logo']['url'] : $retina_logo;
				$retina_logo_sticky = ! empty( $meta['retina_logo_sticky']['url'] ) ? $meta['retina_logo_sticky']['url'] : $retina_logo_sticky;
				$logo_class			= 'page-meta-logo';
			}
			$class .= !empty( $logo_contrast ) ? ' duble_logo' : ' only_main_logo';
			$a_class = !empty( $class ) ? $class : '';
			?>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="<?php echo esc_attr( $a_class ); ?>" rel="home">
				<?php
				if ( ! empty( $logo ) ) { 
					$retina_logo 		= !empty($retina_logo) ? 'srcset="' . esc_attr($retina_logo) . ' 2x"' : '';
					$retina_logo_sticky = !empty($retina_logo_sticky) ? 'srcset="' . esc_attr($retina_logo_sticky) . ' 2x"' : '';
					echo '<img src="'.esc_url($logo).'" '.$retina_logo. ' class="main-logo '.esc_attr($logo_class).'" alt="'. esc_attr(get_bloginfo('name')) .'">';
					
					if ( $logo_contrast != '' ) {
						echo '<img src="' . esc_url($logo_contrast) . '" ' . $retina_logo_sticky . ' class="logo-sticky ' . esc_attr($logo_class) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
					}
				
					if( $is_dark_mode == '1' && !empty($dark_mode_logo['url'] ) ){
						echo '<img src="'. esc_url( $dark_mode_logo['url'] ) .'" class="dark_mode_logo" alt="'. esc_attr(get_bloginfo('name')) .'">';
					}
				
				} else { ?>
					<h3><?php bloginfo( 'name' ); ?></h3>
				<?php } ?>
			</a>
			<?php
		}


		static function get_hostim_banner(){ ?>

			<section class="breadcrumb-area bg-primary-gradient">
				<div class="container">
					<div class="breadcrumb-content text-center">
						<?php
						if( has_category() ){ ?>
							<div class="cat_wrapper">
								<?php Hostim_Theme_Helper::hostim_entry_cat( 'category', 'template-btn primary-btn'  ); ?>
							</div>
							<?php
						}
						?>
						<h2 class="mb-3">
							<?php
							$blog_title = hostim_option('blog_title');
							if ( is_home() ) {
							$blog_title = !empty( $blog_title ) ? $blog_title : esc_html__( 'Blog', 'hostim' );
							echo esc_html( $blog_title );
							} elseif ( is_page() || is_single() ) {
								the_title();
							} elseif( is_category() ) {
								single_cat_title();
							} elseif( is_archive() ) {
								the_archive_title();
							} elseif( is_search() ) {
								esc_html_e( 'Search result for: “', 'hostim' ); echo get_search_query().'”';
							} else {
								the_title();
							}
							?>
						</h2>
						<nav>
							<?php Hostim_Theme_Helper::hostim_breadcrumb( 'breadcrumb' ) ?>
						</nav>
					</div>
				</div>
			</section>

			<?php
		}

		static function render_post_list_share() { ?>

			<div class="bd-blog-share">
				<h6>Share this Post</h6>
				<div class="social-icons mt-3">
					<a class="facebook" target="_blank"
							href="<?php echo esc_url( 'https://www.facebook.com/share.php?u=' . get_permalink() ); ?>">
						<i class="fab fa-facebook-f"></i>
					</a>

					<?php
					$img_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
					
					if ( $img_url != false ) {

						echo '<a class="pinterest" target="_blank" href="' . esc_url( 'https://pinterest.com/pin/create/button/?url=' . get_permalink() . '&media=' . $img_url[0] ) . '"><i class="fab fa-pinterest-p"></i></a>';

					}
					?>
					<a class="twitter" target="_blank" href="<?php echo esc_url( 'https://twitter.com/intent/tweet?text=' . get_the_title() . '&amp;url=' . get_permalink() ); ?>">
						<i class="fab fa-twitter"></i>
					</a>
					<a class="linkedin" target="_blank"
							href="<?php echo esc_url( 'http://www.linkedin.com/shareArticle?mini=true&url=' . substr( urlencode( get_permalink() ), 0, 1024 ) ); ?>&title=<?php echo esc_attr( substr( urlencode( html_entity_decode( get_the_title() ) ), 0, 200 ) ); ?>">
						<i class="fab fa-linkedin-in"></i>
					</a>

				</div>
			</div>

			<?php
		}

		static function related_post() { ?>
			<div class="related-post-wrapper">
				<h2 class="related-title"><?php echo esc_html( hostim_option( 'related_title' ) ); ?></h2>
				<div class="row">
					<?php
					global $post;
					$post_id    = get_the_ID();
					$cat_ids    = array();
					$categories = get_the_category( $post_id );

					if ( ! empty( $categories ) && is_wp_error( $categories ) ):
						foreach ( $categories as $category ):
							array_push( $cat_ids, $category->term_id );
						endforeach;
					endif;

					$query_args = array(
						'category__in'   => wp_get_post_categories( $post->ID ),
						'post_not_in'    => array( $post_id ),
						'posts_per_page' => '2'
					);

					$related_cats_post = new WP_Query( $query_args );
					if ( $related_cats_post->have_posts() ):
						while ( $related_cats_post->have_posts() ): $related_cats_post->the_post(); ?>

							<div class="col-md-6">
								<div class="related-post">
									<?php
									if ( has_post_thumbnail() ) : ?>
										<div class="feature-image">
											<a href="<?php the_permalink(); ?>"><?php
												the_post_thumbnail( 'post-thumbnail' ); ?>
											</a>
										</div>
									<?php
									endif; ?>
									<div class="blog-content">
										<ul class="post-meta">
											<li><?php self::hostim_entry_cat(); ?></li>
										</ul><!-- .entry-meta -->

										<h3 class="post-title">
											<a href="<?php the_permalink(); ?>">
												<?php the_title(); ?>
											</a>
										</h3>

										<ul class="post-footer-meta">
											<li><i class="feather-calendar"></i><?php echo get_the_date(); ?></li>
											<li>
												<i class="feather-message-square"></i><?php Hostim_Theme_Helper::hostim_entry_comments( get_the_ID() ); ?>
											</li>
										</ul><!-- .entry-meta -->

									</div>
									<!-- /.blog-content -->
								</div>
								<!-- /.related-post -->
							</div>

						<?php endwhile;

						// Restore original Post Data
						wp_reset_postdata();
					endif; ?>
				</div>
			</div>
			<!-- /.related-post-wrapper -->
		<?php }

		static function tt_post_nav() {
			// Don't print empty markup if there's nowhere to navigate.
			$pre_post  = $next_post = '';
			$next_post = get_next_post();
			$pre_post  = get_previous_post();
			if ( ! $next_post && ! $pre_post ) {
				return;
			}
			if ( $pre_post ):
				$pre_img = wp_get_attachment_url( get_post_thumbnail_id( $pre_post->ID ) );
			endif;
			if ( $next_post ):
				$next_img = wp_get_attachment_url( get_post_thumbnail_id( $next_post->ID ) );
			endif;

			echo '<div class="bd-related-posts mt-60"> 
				<div class="row no-gutters"><div class="col-md-6 mb-30"><div class="bd-rl-post-wrapper prev_post d-flex align-items-center">';
			if ( ! empty( $pre_post ) ) { ?>
				<a href="<?php echo get_the_permalink( $pre_post->ID ); ?>" class="flex-shrink-0">
					<?php echo get_the_post_thumbnail( $pre_post->ID, 'thumbnail', array('class'=>'img-fluid rounded-circle') ); ?>
				</a>
				<div class="rs-post-info ms-3">
					<a href="<?php echo get_the_permalink( $pre_post->ID ); ?>">
						<h6 class="mb-1 navigation_post_title"><?php echo get_the_title( $pre_post->ID ) ?></h6>
					</a>
					<span><?php echo get_the_author(); ?></span>
				</div>
				<?php
			}
			echo '</div></div><div class="col-md-6"><div class="bd-rl-post-wrapper next_post d-flex align-items-center justify-content-end">';

			if ( ! empty( $next_post ) ): ?>
				<div class="rs-post-info me-3">
					<a href="<?php echo get_the_permalink( $next_post->ID ); ?>">
						<h6 class="mb-1 navigation_post_title"><?php echo get_the_title( $next_post->ID ) ?></h6>
					</a>
					<span><?php echo get_the_author(); ?></span>
				</div>
				<a href="<?php echo get_the_permalink( $next_post->ID ); ?>" class="flex-shrink-0">
					<?php echo get_the_post_thumbnail( $next_post->ID, 'thumbnail', array('class'=>'img-fluid rounded-circle') ); ?>
				</a>
			<?php
			endif;
			echo '</div></div></div></div>';
		}

		static function tt_portfolio_post_nav() {
			// Don't print empty markup if there's nowhere to navigate.
			$pre_post  = $next_post = '';
			$next_post = get_next_post();
			$pre_post  = get_previous_post();
			if ( ! $next_post && ! $pre_post ) {
				return;
			}
			if ( $pre_post ):
				$pre_img = wp_get_attachment_url( get_post_thumbnail_id( $pre_post->ID ) );
			endif;
			if ( $next_post ):
				$next_img = wp_get_attachment_url( get_post_thumbnail_id( $next_post->ID ) );
			endif;


			echo '<div class="portfolio-post-navigation"> 
				<div class="post-previous">';
			if ( ! empty( $pre_post ) ):
				?>
				<a href="<?php echo get_the_permalink( $pre_post->ID ); ?>" class="single-post-nav">
					<i class="fas fa-chevron-left"></i>
					<div class="post-nav-wrapper">
						<p class="post-nav-title"><?php esc_html_e( 'Older Post', 'hostim' ) ?></p>
						<h4 class="post-title"><?php echo get_the_title( $pre_post->ID ) ?></h4>
					</div>

				</a>

			<?php
			endif;
			echo '</div><i class="fas fa-th-large middle-icon"></i><div class="post-next">';

			if ( ! empty( $next_post ) ):
				?>
				<a href="<?php echo get_the_permalink( $next_post->ID ); ?>" class="single-post-nav">

					<div class="post-nav-wrapper">
						<p class="post-nav-title"><?php esc_html_e( 'Next Post', 'hostim' ) ?></p>
						<h4 class="post-title"><?php echo get_the_title( $next_post->ID ) ?></h4>
					</div>

					<i class="fas fa-chevron-right"></i>
				</a>

			<?php
			endif;
			echo '</div></div>';
		}

		/**
		 * Returns array of title tags
		 *
		 * @param bool $first_empty
		 * @param array $additional_elements
		 *
		 * @return array
		 */
		static function tt_get_title_tag( $first_empty = false, $additional_elements = array() ) {
			$title_tag = array();

			if ( $first_empty ) {
				$title_tag[''] = esc_html__( 'Default', 'hostim' );
			}

			$title_tag['h1'] = 'h1';
			$title_tag['h2'] = 'h2';
			$title_tag['h3'] = 'h3';
			$title_tag['h4'] = 'h4';
			$title_tag['h5'] = 'h5';
			$title_tag['h6'] = 'h6';

			if ( ! empty( $additional_elements ) ) {
				$title_tag = array_merge( $title_tag, $additional_elements );
			}

			return $title_tag;
		}

		public static function get_footers_types() {
			$footer = ['' => esc_html__( 'Default', 'hostim' ) ];
			$footers = get_posts(
				[
					'posts_per_page' => - 1,
					'post_type'      => 'hostim_footer',
					'orderby'        => 'name',
					'order'          => 'ASC'
				]
			);
			foreach ($footers as  $value) {
				$footer[$value->ID] = $value->post_title;
			}
			return $footer;
		}

		public static function hostim_render_footer($footer_style){
			$elementor_instance = Elementor\Plugin::instance();
			return $elementor_instance->frontend->get_builder_content_for_display( $footer_style );
		}

		/* Get Nav menus */
		public static function hostim_get_nav_menus(){
			$nav_menus = wp_get_nav_menus();
			if( is_array( $nav_menus ) ){
				$menu_location[] = '';
				foreach( $nav_menus as $item ){
					$menu_location[$item->slug] = $item->name;
				}
				return $menu_location;
			}
		}

	}

	// Instantiate theme
	new Hostim_Theme_Helper();
}
