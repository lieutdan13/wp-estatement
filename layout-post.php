<div <?php post_class( 'layout-post' ) ?>>

	<?php if( has_post_thumbnail() ) : ?>
		<div class='post-image'>
			<?php the_post_thumbnail( bsh_get_layout_size( 'est_large' ) ) ?>
		</div>
	<?php endif ?>

	<?php if( bsh_have_meta() ) : ?>
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
	<?php endif ?>

	<div class='post-content'>
		<div class='content mb22'>
		<?php the_content() ?>
		</div>

		<?php
			wp_link_pages();
		?>

		<?php comments_template() ?>

	</div>

</div>