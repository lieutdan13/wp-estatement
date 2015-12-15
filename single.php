<?php get_header() ?>


<div class='row mt44'>
	<div class='large-12 small-12 columns'>
		<div id='siteContent'>
			<div class='row'>

				<div class='columns large-12 small-12'>
					<?php
						echo '<div class="page-title mb22">';
						echo do_shortcode( '[title icon="home"]' . the_title( '', '', false ) . '[/title]' );
						echo '</div>';
					?>
				</div>

				<div id='siteMain' class='<?php echo bsh_content_classes() ?> columns'>
					<?php
						if( have_posts() ) {
							while( have_posts() ) {
								the_post();
								get_template_part( 'layout', 'post' );
							}
						}
						else {

						}
					?>
				</div>
				<?php if( bsh_has_sidebar() ) : ?>
					<div id='siteSidebar' class='small-12 large-4 columns <?php echo bsh_sidebar_classes() ?>'>
						<?php dynamic_sidebar( bsh_get_sidebar() ) ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer() ?>
