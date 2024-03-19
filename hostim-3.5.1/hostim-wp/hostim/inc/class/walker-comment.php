<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Hostim Walker Comment
*
*
* @class        Hostim_Walker_Comment
* @version      1.0
* @category     Class
* @author       ThemeTags
*/

if (!class_exists('Hostim_Walker_Comment')) {
    class Hostim_Walker_Comment extends Walker_Comment {
        public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
            $depth++;
            $GLOBALS['comment_depth'] = $depth;
            $GLOBALS['comment']       = $comment;
            if ( ! empty( $args['callback'] ) ) {
                ob_start();
                call_user_func( $args['callback'], $comment, $args, $depth );
                $output .= ob_get_clean();
                return;
            }
            if ( ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) && $args['short_ping'] ) {
                ob_start();
                $this->ping( $comment, $depth, $args );
                $output .= ob_get_clean();
            } else {
                ob_start();
                $this->comment( $comment, $depth, $args );
                $output .= ob_get_clean();
            }
        }


        protected function ping( $comment, $depth, $args ) {
            $tag = ( 'div' == $args['style'] ) ? 'div' : 'li'; ?>

            <<?php echo Hostim_Theme_Helper::render_html($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
                <div class="comment-body stand_comment">
                    <?php esc_html_e( 'Pingback:', 'hostim' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'hostim' ), '<span class="edit-link">', '</span>' ); ?>
                </div>
        <?php }

        protected function comment( $comment, $depth, $args ) {
            $max_depth_comment = ($args['max_depth'] > 4 ? 4 : $args['max_depth']);

            $GLOBALS['comment'] = $comment; ?>
            
            <li <?php comment_class( 'comment-box' ); ?> id="li-comment-<?php comment_ID() ?>">
                <div id="comment-<?php comment_ID(); ?>" class="comment-body comment-box-wrapper d-block d-sm-flex align-items-start">
        
                    <?php
                    $avatar_size = $depth > 1 ? 70 : 90;
                    echo get_avatar($comment->comment_author_email, $avatar_size, '', '', array('class'=>'img-fluid rounded-circle flex-shrink-0') ); ?>
             
                    <div class="comment-user-info position-relative mt-3 mt-sm-0 ms-sm-3 overflow-hidden">
                        <span class="date d-block mb-3 mb-sm-0"><?php printf('%1$s', get_comment_date()) ?></span>
                        <h6><?php printf('%s', get_comment_author_link()) ?></h6>
                        <?php comment_text() ?>
                    
                        <?php comment_reply_link(array_merge( $args, array('reply_text' =>   esc_html__('Reply', 'hostim'),  'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>

                    </div>
                </div>
            <?php
        }
    }
}