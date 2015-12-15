<?php
	$thumbnail_id = get_post_thumbnail_id();
	$image = wp_get_attachment_image_src( $thumbnail_id, 'est_flyer' );
?>

<div <?php post_class( 'layout-property-flyer' ) ?> style="background-image: url( '<?php echo $image[0] ?>' )">
<?php est_webmaster_tools_data() ?>

	<div class='post-content'>
		<div class='post-image-overlay'></div>
		<h1><a class='heading-text-color' href='<?php the_permalink() ?>'><?php the_title() ?></a></h1>
		<div class='content'>
			<?php the_excerpt() ?>
		</div>
		<div class='details'>
			<div class="info light">
			<?php
				$detail_1 = get_theme_mod( 'featured_properties_info_1' );
				$detail_1 = ( empty( $detail_1 ) ) ? '_est_meta_building_area' : $detail_1;
				$detail_2 = get_theme_mod( 'featured_properties_info_2' );
				$detail_2 = ( empty( $detail_2 ) ) ? '_est_meta_property_area' : $detail_2;
				$value = array();

				if( $detail_1 != 'none' ) {
					$value[0] = get_post_meta( get_the_ID(), $detail_1 ) ;
					$value[0] = est_customdata_value( $detail_1, $value[0] );
				}

				if( $detail_2 != 'none' ) {
					$value[1] = get_post_meta( get_the_ID(), $detail_2 ) ;
					$value[1] = est_customdata_value( $detail_2, $value[1] );
				}

				if( !empty( $value ) ) {
					echo implode( ' - ', $value );
				}
			?>
			</div>
			<a class='button small' href='<?php the_permalink() ?>'><?php _e( 'details', THEMENAME ) ?></a>

		</div>
	</div>

</div>