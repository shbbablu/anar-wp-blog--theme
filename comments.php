<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package anri
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div class="single-post__comments">
    <h5><?php comments_number(  ); ?>.</h5>

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>

		<ul class="single-post__comments-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ul',
					'short_ping' => true,
                    'walker'     => new Comment_Walker(),
				) );
			?>
		</ul><!-- .comment-list -->


	<?php
	endif; ?>
    
	<?php 

	if ( ! comments_open( $post->ID ) ) {
		
		echo "Comments are closed!";
	}else{


		$commenter = wp_get_current_commenter();
		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html_req = ( $req ? " required='required'" : '' );
		$html5    = 'html5';


		$mobile = !isset( $commenter['comment_mobile'] ) ? '' : $commenter['comment_mobile'];


		$fields = array(
				'author' => '<p class="single-post__comments-respond-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
				            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
				'email'  => '<p class="single-post__comments-respond-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
				            '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>',
				'url'    => '<p class="single-post__comments-respond-url"><label for="url">' . __( 'Website' ) . '</label> ' .
				            '<input id="url" name="url" ' . ( $html5 ? 'type="text"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
				'mobile' => '<p class="single-post__comments-respond-mobile"><label for="url">' . __( 'Mobile Number' ) . '</label> ' .
				            '<input id="mobile" name="mobile" ' . ( $html5 ? 'type="number"' : 'type="text"' ) . ' value="' . esc_attr( $mobile ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
			);

		

		comment_form(array(
			'title_reply_before'	=> '<h5 id="reply-title" class="comment-reply-title">',
			'title_reply_after'		=> '</h5>',
			'title_reply' 			=> 'Leave a Comment',
			'comment_notes_before'	=> '',
			'comment_field'        	=> '<p class="single-post__comments-respond-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea></p><p class="single-post__comments-respond-mobile"><label for="url">' . __( 'Profession: ' ) . '</label> ' .
				            '<input id="profession" name="profession" ' . ( $html5 ? 'type="number"' : 'type="text"' ) . ' value="" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
			'submit_field'         	=> '<p class="single-post__comments-respond-submit">%1$s %2$s</p>',
			


			'fields' 				=> $fields
		)); 

	}



	?>

</div><!-- #comments -->