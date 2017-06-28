<?php 
class Comment_Walker extends Walker_comment{
    
    	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= '<ol class="single-post__comments-children">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="single-post__comments-children">' . "\n";
				break;
		}
	}
    
    protected function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
        $args['avatar_size'] = 512;
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="single-post__comments-item-body">
			
					<div class="single-post__comments-item-avatar ">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					</div><!-- .single-post__comments-item-avatar -->
                
                
                

                    <div class="single-post__comments-item-right">
                        <div class="single-post__comments-item-reply">
                            <?php
                                comment_reply_link( array_merge( $args, array(
                                    'add_below' => 'div-comment',
                                    'depth'     => $depth,
                                    'max_depth' => $args['max_depth'],
                                    'before'    => '',
                                    'after'     => ''
                                ) ) );
                            ?>
                        </div>
                        
                        <div class="single-post__comments-item-info">
                            <div class="single-post__comments-item-info-author">
                                <span>
                                <?php echo get_comment_author_link( $comment ); ?>
                                </span>
                            </div>
                        <div class="single-post__comments-item-info-date">
                            <span>
                            <a href="<?php echo get_comment_link($comment, $args); ?>"><?php echo get_comment_date( '', $comment ) ?> at <?php echo get_comment_time() ?></a>
                            </span>
                        </div>
                        </div>
                        <div class="single-post__comments-item-post">
                            <p><?php comment_text(); ?></p>
                            <?php if(get_comment_meta( $comment->comment_ID, 'comment_mobile', true )) : ?>
                            <p>Mobile Number: <?php echo get_comment_meta( $comment->comment_ID, 'comment_mobile', true ); ?></p>
                            <?php endif; ?>
                  
                        </div>
                    </div>

			</article><!-- .comment-body -->
<?php
	}
}
?>









