<?php

if( $_GET['s'] == 'property_search' ) {

	global $wp_query;
	$temp_query = $wp_query;
	$wp_query = null;
	$args = get_args_from_search();
	$wp_query = new WP_Query( $args );

}
get_header();
?>

<div class='row mt44'>
	<div class='large-12 small-12 columns'>
		<div id='siteContent'>
			<div class='row'>
				<div id='siteMain' class='<?php echo bsh_content_classes() ?> columns'>
					<?php
					if( have_posts() ){
						while( have_posts() ) {
							the_post();
							if( get_post_type() == 'property' ) {
								get_template_part( 'layout-property-list' );
							}
							else {
								get_template_part( 'layout-post-list' );
							}
						}
					}
					else {
						?>
							<hgroup class='no-posts-error'>
								<h1><?php echo get_theme_mod( 'no_search_title' ) ?></h1>
								<h2><?php echo get_theme_mod( 'no_search_message' ) ?></h2>
							</hgroup>

							<?php
								$page_id = get_theme_mod( 'no_search_include_page' );
								if( !empty( $page_id ) ) {
									echo '<div class="mt44">';
									$temp_query = $wp_query;
									$wp_query = null;
									$wp_query = new WP_Query( array( 'post_type' => 'page', 'post__in' => array( $page_id ) ) );
									if( have_posts() ) {
										while( have_posts() ) {
											the_post();
											echo '<div class="content">';
											the_content();
											echo '</div>';
										}
									}
									$temp_query = $wp_query;
									wp_reset_postdata();
									echo '</div>';
								}

							?>

						<?php
					}
					?>
				</div>
				<div id='siteSidebar' class='small-12 large-4 columns <?php echo bsh_sidebar_classes() ?>'>
					<?php dynamic_sidebar('Sidebar') ?>
				</div>
			</div>
		</div>
	</div>
</div>




<?php
	$wp_query = $temp_query;
	wp_reset_postdata();
	get_footer()
?>