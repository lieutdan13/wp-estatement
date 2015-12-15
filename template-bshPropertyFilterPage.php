<?php
/*
Template Name: Property Filter
*/
get_header();
while( have_posts() ) : the_post();
	global $details, $search;
	$search = array( 'customdatas' => array(), 'custom_taxonomies' => array() );
	$search['customdatas'] = get_post_meta( $post->ID, '_est_customdatas', true );
	$search['custom_taxonomies'] = get_post_meta( $post->ID, '_est_taxonomies', true );
	$details = get_search_options( $search );

	$position = get_post_meta( get_the_ID(), '_est_filter_location', true );
	$class_content = ( $position == 'left' ) ? 'push-4' : '';
	$class_filter = ( $position == 'left' ) ? 'pull-8' : '';
?>

<div class='row mt44'>
	<div class='large-4 small-12 columns <?php echo $class_filter ?>' id='siteSidebar'>
		<form class='custom inContentSearch' id='filterPageSearch' data-type='<?php echo $filter_type ?>'>
			<?php
				$title = get_post_meta( $post->ID, '_est_search_title', true );
				if( !empty( $title ) ) :
			?>
			<div class='searchTitle'>
				<div class='title'><?php echo $title ?></div>
			</div>
			<?php endif ?>
			<?php
				est_vertical_search( $details, array( 'sliders' => false ) );
			?>
		</form>

		<?php dynamic_sidebar( bsh_get_sidebar() ) ?>

	</div>
	<div class='large-8 small-12 columns <?php echo $class_content ?>'>
		<div id='siteContent' class='nopadding nobgcolor'>
			<div id='filterNoResults' style='display:none'>
				<h1><?php echo get_post_meta( get_the_ID(), '_est_no_results_title', true ) ?></h1>
				<p><?php echo get_post_meta( get_the_ID(), '_est_no_results_message', true ) ?></p>
			</div>

			<?php
				$args = array(
					'post_type' => 'property',
					'posts_per_page' => -1
				);

				$orderby = get_post_meta( $post->ID, '_est_orderby', true );
				$orderby = ( empty( $orderby ) ) ? 'post_date' : $orderby;

				$order = get_post_meta( $post->ID, '_est_order', true );
				$order = ( empty( $order ) ) ? 'DESC' : $order;


				if( in_array( $orderby, array( 'post_date', 'post_title' ) ) ) {
					$args['orderby'] = $orderby;
				}
				else {
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = $orderby;
				}


				$args['order'] = $order;


					$metas = get_post_meta( $post->ID );

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


				$filter_type = get_post_meta( get_the_ID(), '_est_filter_type', true );
				if( $filter_type == 'paginate' ) {
					$posts_per_page = get_post_meta( get_the_ID(), '_est_posts_per_page', true );
					$posts_per_page = ( empty( $posts_per_page ) ) ? get_option( 'posts_per_page' ) : $posts_per_page;
					$args['posts_per_page'] = $posts_per_page;
				}

			?>

			<div id='fiterArgs' style='display:none'><?php echo json_encode( $args ) ?></div>
			<div id='filter' data-page-id='<?php echo get_the_ID() ?>'>
				<?php get_filter_content( $args ); ?>
			</div>
		</div>
	</div>


</div>


<?php
	endwhile;
	get_footer();
?>