<?php
/*
Template Name: Property Listing
*/
get_header();
global $options, $wp_query;

while ( have_posts() ) : the_post();


$options['customdatas'] = get_post_meta( $post->ID, '_est_customdata', true );
$options['single_address'] = get_post_meta( $post->ID, '_est_single_field_address', true );
$options['custom_taxonomies'] = get_post_meta( $post->ID, '_est_custom_taxonomies', true );
$options['single_address_order'] = get_post_meta( $post->ID, '_est_single_field_address_order', true );

$options['show_excerpt'] = get_post_meta( $post->ID, '_est_excerpt', true );
$options['show_excerpt'] = ( empty( $options['show_excerpt'] ) ) ? 'hide' : $options['show_excerpt'];


$options['_est_single_field_address_name'] = get_post_meta( $post->ID, '_est_single_field_address_name', true );

$options['post_id'] = $post->ID;


$property_layout = get_post_meta( $post->ID, '_est_propery_layout', true );
$property_layout = ( empty( $property_layout ) ) ? 'list' : $property_layout;

$card_columns = get_post_meta( $post->ID, '_est_card_columns', true );
$card_columns = ( empty( $card_columns ) ) ? 3 : (int) $card_columns;


?>

<div class='row mt44'>
	<div class='large-12 small-12 columns'>
		<div id='siteContent'>

			<?php
				if( bsh_show_title() ) {
					echo '<div class="page-title">';
					echo do_shortcode( '[title icon="home"]' . the_title( '', '', false ) . '[/title]' );
					echo '</div>';
				}

			?>

			<div class='row'>
				<div id='siteMain' class='<?php echo bsh_content_classes() ?> columns'>


				<?php
					$show_search = get_post_meta( $post->ID, '_est_show_search', true );
					if( $show_search == 'yes' OR ( $show_search == 'search' AND !empty( $_GET ) ) ) :
				?>
				<form class='custom inContentSearch'>
					<?php
						$title = get_post_meta( $post->ID, '_est_search_title', true );
						if( !empty( $title ) ) :
					?>
					<div class='searchTitle'>
						<div class='title'><?php echo $title ?></div>
					</div>
					<?php endif ?>
					<?php
						$search = array( 'customdatas' => array(), 'custom_taxonomies' => array() );
						$search['customdatas'] = get_post_meta( $post->ID, '_est_customdatas', true );
						$search['custom_taxonomies'] = get_post_meta( $post->ID, '_est_taxonomies', true );

						$details = get_search_options( $search );
						est_vertical_search( $details );
						$text = get_post_meta( $post->ID, '_est_search_button_text', true );
						$text = ( empty( $text ) ) ? 'Search' : $text;
					?>
						<div class='form-row row mt11'>
							<div class='small-12 large-12 columns text-right'>
								<input type='submit' class='button' value='<?php echo $text ?>'>
							</div>
						</div>
				</form>
				<?php endif ?>

				<?php if( !empty( $post->post_content ) ) : ?>

					<?php
						$titlepadding = ( bsh_show_title() ) ? 'mt22' : '';
					?>

					<div class='content mb22 <?php echo $titlepadding ?>'>
						<?php the_content() ?>
					</div>
				<?php endif ?>

				<div class='property-list'>
					<?php
					$temp_query = $wp_query;
					$wp_query = null;

					$metas = get_post_meta( $post->ID );
					$posts_per_page = ( !empty( $metas['_est_count'][0] ) ) ? $metas['_est_count'][0] : get_option( 'posts_per_page' );
					global $paged;
					$args = array(
						'post_type' => 'property',
						'posts_per_page' => $posts_per_page,
						'paged' => $paged
					);


					$taxonomies = array();
					foreach( $metas as $key => $value ) {
						if( substr_count( $key, '_est_taxonomy_' ) ) {
							$taxonomies[$key] = $value;
						}
					}

					if( !empty( $taxonomies ) ) {
						foreach( $taxonomies as $key => $taxonomy ) {
							$terms = @unserialize( $taxonomy[0] );
							unset( $taxonomies[$key]);
							$taxonomy = str_replace( '_est_taxonomy_', '', $key );
							if( !empty( $terms ) AND taxonomy_exists( $taxonomy ) ) {
								$taxonomies[$taxonomy] = $terms;
							}
						}

						if( !empty( $taxonomies ) ) {
							$args['tax_query'] = array();
							$args['tax_query']['relation'] = 'AND';
							foreach( $taxonomies as $taxonomy => $terms ) {

								$args['tax_query'][] = array(
									'taxonomy' => $taxonomy,
									'field'    => 'ID',
									'terms'    => $terms,
									'operator' => 'IN'
								);


							}
						}
					}


					$search_args = get_args_from_search();


					$orderby = get_post_meta( $post->ID, '_est_orderby', true );
					$orderby = ( empty( $orderby ) ) ? 'post_date' : $orderby;

					$order = get_post_meta( $post->ID, '_est_order', true );
					$order = ( empty( $order ) ) ? 'DESC' : $order;


					if( $orderby == 'post_date' ) {
						$args['orderby'] = 'date';
					}


					elseif( $orderby == 'post_title' ) {
						$args['orderby'] = 'title';
					}

					elseif( $orderby == 'rand' ) {
						$args['orderby'] = 'rand';
					}

					else {
						$sort_type = get_post_meta( $post->ID, '_est_sort_type', true );
						$sort_type = ( empty( $sort_type ) ) ? 'meta_value' : $sort_type;
						$args['orderby'] = $sort_type;
						$args['meta_key'] = $orderby;
					}

					$args['order'] = $order;
					$original_tax_query = $args['tax_query'];

					$args = wp_parse_args( $search_args, $args );

					if( !empty( $args['meta_query'] ) AND count( $args['meta_query'] ) > 1 ) {
						$args['meta_query']['relation'] = 'AND';
					}

					if( !empty( $args['s'] ) ) {

						$atts = $args;
						$search = $args['s'];
						unset( $args['s'] );

						$post_ids = array();
						$atts['posts_per_page'] = -1;

						$wp_query = new WP_Query( $atts );
						if( have_posts() ) {
							while( have_posts() ) {
								the_post();
								$post_ids[] = get_the_ID();
							}
						}

						$wp_query = $temp_query;
						wp_reset_postdata();

						$search_results = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_value LIKE '%" . $search . "%' " );

						$property_ids = array_merge( $search_results, $post_ids );
						$property_ids = ( empty( $property_ids ) ) ? array( 999999999 ) :$property_ids;
						$args = array(
							'post_type' => 'property',
							'posts_per_page' => $posts_per_page,
							'paged' => $paged,
							'post__in' => $property_ids
						);

					}

					$args['tax_query'] = ( empty( $args['tax_query'] ) ) ? array() : $args['tax_query'];

					$original_tax_query = ( empty( $original_tax_query ) ) ? array() : $original_tax_query;

					$args['tax_query']  = array_merge( $original_tax_query, $args['tax_query'] );

					$author = get_post_meta( $post->ID, '_est_author', true );
					if( !empty( $author ) ) {
						$args['author'] = $author;
					}

						if( !empty( $_GET['est_page'] ) ) {
							$args['paged'] = $_GET['est_page'];
						}

					$wp_query = new WP_Query( $args );
					if( have_posts() ) {
						$i = $card_columns;
						$card_column_size = 12 / $card_columns;
						while( have_posts() ) {
							the_post();
							if( $property_layout == 'list' ) {
								get_template_part( 'layout-property-list' );
							}
							else {
								if( $i % $card_columns == 0 ) {
									echo '<div class="row">';
								}
								echo '<div class="columns small-12 large-'.$card_column_size.'">';
								get_template_part( 'layout-property-card' );
								echo '</div>';

								if( ( $i + 1 ) % $card_columns == 0 ) {
									echo '</div>';
								}
							}

							$i++;
						}

						if( $property_layout == 'card' AND ( $i % $card_columns) != 0  ) {
							for( $n = 0;  $n < ( $i % $card_columns ); $n++ ) {
								echo '<div class="columns small-12 large-'.$card_column_size.'"></div>';
							}
							echo '</div>';
						}

						bsh_pagination( false, 'est_page' );
					}
					else {
						bsh_no_posts();
					}

					$wp_query = $temp_query;
					wp_reset_postdata();
					?>
					</div>
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

<?php endwhile ?>
<?php get_footer(); ?>
