<?php get_header() ?>

<div class='row mt44'>
	<div class='large-12 small-12 columns'>
		<div id='siteContent'>
			<div class='row'>

			<?php
				global $wp_query;
				$title = '';
				if ( is_day() ) :
					$title = sprintf( __( 'Daily Archives: %s', THEMENAME ), '<span>' . get_the_date() . '</span>' );
						$icon = 'click';
				elseif ( is_month() ) :
					$title = sprintf( __( 'Monthly Archives: %s', THEMENAME ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', THEMENAME ) ) . '</span>' );
						$icon = 'click';
				elseif ( is_year() ) :
					$title = sprintf( __( 'Yearly Archives: %s', THEMENAME ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', THEMENAME ) ) . '</span>' );
						$icon = 'click';
				elseif ( is_category() ) :
					$title = sprintf( __( 'Category: %s', THEMENAME ), '<span>' . single_cat_title( '', false ) . '</span>' );
					$icon = 'folder_open';
				elseif ( is_tag() ) :
					$title = printf( __( 'Tags: %s', THEMENAME ), '<span>' . single_cat_title( '', false ) . '</span>' );
					$icon = 'tag';
				elseif ( is_tax() ) :
					$title = $wp_query->queried_object->name;
					$icon = 'folder_open';
				elseif( have_posts() ) :
					$title = get_theme_mod( 'blog_title' );
					$title = ( empty($title) ) ? __( 'Archives', THEMENAME ) : $title;
					$icon = 'folder_open';
				endif;

				if( !empty( $title ) ) {
					$icon = ( empty( $icon ) ) ? 'notes_2' : $icon;
					echo '<div class="large-12 small-12 columns">';
					echo '<div class="page-title mb22">';
					echo do_shortcode( '[title icon="'.$icon.'"]' . $title . '[/title]' );
					echo '</div>';
					echo '</div>';
				}


			?>

				<div id='siteMain' class='<?php echo bsh_content_classes() ?> columns'>
					<?php
						if( is_tax() ) {
							$description = ( !empty( $wp_query->queried_object->description ) ) ? $wp_query->queried_object->description : '';
							if( !empty( $description ) ) {
								echo '<div class="content">';
								echo wpautop( $description );
								echo '</div>';
							}
						}

					?>
					<?php
						if( have_posts() ) {
							echo '<div class="propertylist">';
							while( have_posts() ) {
								the_post();
								get_template_part( 'layout', 'post-list' );
							}
							echo '<div class="mt22">';
								bsh_pagination();
							echo '</div>';
							echo '</div>';
						}
						else {

						}
					?>
				</div>
				<?php if( bsh_has_sidebar() ) : ?>
					<div id='siteSidebar' class='small-12 large-4 columns <?php echo bsh_sidebar_classes() ?>'>
						<?php dynamic_sidebar( 'Default Blog Sidebar' ) ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer() ?>
