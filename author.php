<?php
	global $query_string, $wp_query;
	get_header();
	$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
	$author_page = 	get_author_posts_url( $author->ID);
	$properties = est_get_agent_properties( $author->ID );
	$temp_query = $wp_query;
	$wp_query = null;
	$paged = ( empty( $_GET['page'] ) ) ? 1 : $_GET['page'];
	$args = array(
		'post_type' => 'property',
		'post__in' => $properties,
		'posts_per_page' => get_option( 'posts_per_page' ),
		'paged' => $paged
	);

	$wp_query = new WP_Query( $args );

?>


<div class='row mt44'>


	<div class='large-12 small-12 columns'>
		<div id='siteContent'>
			<div class='row'>

				<div class='columns large-12 small-12'>
					<?php
						echo '<div class="page-title mb22">';
						$title = sprintf( __( '%s\'s Properties', THEMENAME ), $author->display_name );
						echo do_shortcode( '[title icon="home"]' . $title . '[/title]' );
						echo '</div>';
					?>
				</div>


				<div id='siteMain' class='<?php echo bsh_content_classes() ?> columns'>
					<?php
						while ( have_posts() ) {
							the_post();
							get_template_part( 'layout-property', 'list' );
						}

						?>
						<div class="pagination">
						<?php
							$pagination = array(
								'base'      => $author_page . '?page=%#%',
								'format'    => '?page=%#%',
								'current'   => max( 1, get_query_var( 'paged' ) ),
								'total'     => $wp_query->max_num_pages,
								'next_text' => __( 'next', THEMENAME ),
								'prev_text' => __( 'previous', THEMENAME )
							);
							echo paginate_links( $pagination );
						?>

						</div>
						<?php
						$wp_query = $temp_query;
						wp_reset_postdata();

					?>
				</div>

				<?php if( bsh_has_sidebar() ) : ?>
					<div id='siteSidebar' class='small-12 large-4 columns <?php echo bsh_sidebar_classes() ?>'>
						<?php dynamic_sidebar( 'Agent Page Sidebar' ) ?>
					</div>
				<?php endif ?>

			</div>
		</div>
	</div>
</div>

<?php get_footer() ?>