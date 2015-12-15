<?php if( is_front_page() AND get_theme_mod( 'show_featured_properties' ) == 'yes' ) : ?>

	<?php
		global $wp_query;
		$temp_query = $wp_query;
		$wp_query = null;

		$posts_per_page = get_theme_mod( 'featured_properties_count' );
		$posts_per_page = ( empty( $posts_per_page ) ) ? 5 : $posts_per_page;

		$args = array (
			'post_type' => 'property',
			'post_status' => 'publish',
			'posts_per_page' => $posts_per_page,
		);

		$to_show = get_theme_mod( 'featured_properties_to_show' );
		$to_show = ( empty( $to_show ) ) ? 'latest' : $to_show;

		if( $to_show === 'from_category' ) {
			$terms = get_theme_mod( 'featured_properties_terms' );
			if( !empty( $terms ) ) {
				$terms = explode( ',', $terms );
				$terms = array_map('trim', $terms);
				$args['tax_query'] = array(
					array(
						'taxonomy' => get_theme_mod( 'featured_properties_taxonomy' ),
						'field' => 'ID',
						'terms' => $terms
					)
				);
			}
		}

		elseif( $to_show === 'random' ) {
			$args['orderby'] = 'rand';
		}
		elseif( $to_show === 'specified' ) {
			$ids = get_theme_mod('featured_properties_ids');
			if( !empty( $ids ) ) {
				$ids = explode( ',', $ids );
				$ids = array_map( 'trim', $ids );
				$args['post__in'] = $ids;
			}
		}
		else {
			$args['orderby'] = 'date';
			$args['order'] = 'DESC';
		}


		$wp_query = new WP_Query( $args );

		if( have_posts() ) {

			$timer = get_theme_mod( 'featured_properties_speed' );

			echo "<div class='row'>";
				echo "<div class='small-12 large-12 columns'>";
				echo '<div id="featured-properties-container">';
				echo '<div id="featured-flag"></div>';
				echo '<div id="featured-properties" data-speed="' . $timer . '">';
				$i=0;
				while( have_posts() ) {
					the_post();

					get_template_part( 'layout', 'property-flyer' );

					$i++;
				}
				echo '</div>';
				echo '</div>';
				echo '</div>';
			echo '</div>';
		}
		$wp_query = $temp_query;
		wp_reset_postdata();
	?>
	</div>
</div>

<?php endif ?>