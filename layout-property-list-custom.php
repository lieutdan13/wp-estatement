<?php
	global $options;

	$meta = get_post_meta( get_the_ID() );

	$subtitle_fields = get_option( 'est_property_subtitles' );
	$subtitle = est_property_subtitle( $options );
        $show_complex_name = get_post_meta( $post->ID, '_est_meta_show_complex_name_in_listing', true );
        $complex_name = get_post_meta( $post->ID, '_est_meta_complex_name', true );
        $property_image_overlay_text = get_post_meta( $post->ID, '_est_meta_property_image_overlay_text', true );
        $property_listing_excerpt = get_post_meta( $post->ID, '_est_meta_property_listing_excerpt', true );
?>
<div <?php post_class('layout-property-list') ?>>
<?php est_webmaster_tools_data() ?>

	<div class='row'>
		<?php if( has_post_thumbnail() ) : ?>
			<div class='large-6 small-12 columns'>
				<div class='post-image'>
					<a href='<?php the_permalink() ?>' class='hoverlink hide-for-small'>
						<?php the_post_thumbnail( 'est_card' ) ?>
                                                <?php if ($property_image_overlay_text) {?>
                                                <div class="property-image-overlay"><?php echo $property_image_overlay_text;?></div>
                                                <?php } ?>
					</a>
					<a href='<?php the_permalink() ?>' class='hoverlink show-for-small mb11'>
						<?php the_post_thumbnail( 'est_card_wide' ) ?>
					</a>
				</div>
			</div>
		<?php endif ?>

		<div class='large-6 small-12 columns'>
			<hgroup>
				<h1 class="property-name"><a href='<?php the_permalink() ?>'><?php the_title() ?></a></h1>
				<?php //START DAN CHANGES
                                if ($show_complex_name) {
                                    echo "<h2 class='light'>$complex_name</h2>";
                                }
				//END DAN CHANGES
				?>
				<?php if( !empty( $subtitle ) ) : ?>
					<h2 class='light'><?php echo $subtitle ?></h2>
				<?php endif ?>
			</hgroup>

			<?php if( !empty( $options['show_excerpt'] ) AND $options['show_excerpt'] == 'show'  ): ?>
			<div class='excerpt content mb11'>
				<?php
					$length = get_theme_mod( 'property_excerpt_length' );
					ob_start();
					the_excerpt();
					$excerpt = ob_get_clean();
					if( !empty( $length ) AND !empty( $excerpt ) ) {
						$excerpt = strip_tags( $excerpt );
						$excerpt = substr( $excerpt, 0, $length );
						$spos = strrpos( $excerpt, ' ' );
						$excerpt = substr( $excerpt, 0, $spos );
						$excerpt .= '...';
					}

					echo $excerpt;
				?>
			</div>
			<?php endif ?>

			<?php if( empty( $property_listing_excerpt )) {
				show_property_detail_table( get_property_detail_list( $options ), '' );
                        } else { ?>
                                <div class='excerpt content'>
                                <?php echo $property_listing_excerpt; ?>
                                </div>
                        <?php } ?>

			<?php if( $options['excerpt'] == true ) : ?>
				<div class='excerpt content'>
					<?php the_excerpt() ?>
				</div>
			<?php endif ?>


		</div>

	</div>


</div>