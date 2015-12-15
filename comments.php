<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file is responsible for displaying the
	comments area. The actual comments are shown
	using the mus_comments() function and the
	comment form is shown using the standard
	WordPress comment_form() function.
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*
	1. Password Protected Post Comments
	2. Comments Section Title
	3. Comment List
	4. Comment Navigation
	5. Comments Closed Notice
	6. Comment Form

*/


// 1. Password Protected Post Comments
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<?php // 2. Comments Section Title ?>

		<h2 class="comments-title">
			<?php
				printf(
					_n( 'One Comment', '%1$s Comments', get_comments_number(), THEMENAME ),
					number_format_i18n( get_comments_number() )
				);
			?>
		</h2>



		<?php // 3. Comment List ?>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'bsh_comments', 'style' => 'ul' ) ); ?>
		</ol>



		<?php // 4. Comment Navigation ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="comment-navigation" role="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', THEMENAME ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', THEMENAME ) ); ?></div>
			</nav>
		<?php endif; ?>



		<?php // 5. Comments Closed Notice ?>

		<?php
		if ( ! comments_open() && get_comments_number() ) : ?>
			<div class="nocomments alert-box primary-scheme">
				<?php _e( 'Comments are closed.' , THEMENAME ); ?>
				<a href="" class="close">&times;</a>
			</div>
		<?php endif; ?>

	<?php endif ?>



	<?php // 6. Comment Form ?>
	<?php comment_form() ?>

</div>