<article <?php post_class( 'layout-post-list' ) ?>>

	<?php if( has_post_thumbnail() ) : ?>
		<a class='hoverlink' title='<?php _e( 'Click here to read this post in full', THEMENAME ) ?>' href='<?php the_permalink() ?>'><?php the_post_thumbnail( 'mus_large' ) ?></a>
	<?php endif ?>
	<h1 class='layout-title'><a title='<?php _e( 'Click here to read this post in full', THEMENAME ) ?>' href='<?php the_permalink() ?>'><?php the_title() ?></a></h1>

	<div class='metas primary-links'>

		<span class='meta date'><img src='<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/14x14/clock.png'> <?php the_time( 'F j, Y' ) ?></span>

		<?php if( has_tag() ) : ?>
		 <span class='meta tags'><img src='<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/14x14/tag.png'> <?php the_tags('', ', ') ?></span>
		<?php endif ?>

		<?php if( has_category() ) : ?>
		 <span class='meta categories'><img src='<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/14x14/folder_open.png'> <?php the_category(', ') ?></span>
		<?php endif ?>

		<?php if( comments_open() ) : ?>
		<span class='meta comments'>
			<img src='<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/14x14/comments.png'>
			<a class='primary' href="<?php comments_link(); ?>"><?php echo comments_number( __( '0 comments', THEMENAME ), __( '1 comment', THEMENAME ), __( '% comments', THEMENAME ) ) ?></a>
		</span>
		<?php endif ?>

	</div>

	<div class='content'>
			<?php
				$content_type = get_theme_mod( 'content_length' );
				if( $content_type === 'content' ) {
					the_content();
				}
				else {
					the_excerpt();
					?>
					<a class='primary button small' title='<?php _e( 'Click here to read this post in full', THEMENAME ) ?>' href='<?php the_permalink() ?>'><?php echo get_theme_mod( 'read_more_text' ) ?></a>
					<?php
				}
			?>
	</div>

</article>