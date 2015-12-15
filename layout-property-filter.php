<?php
	global $filter_options, $details, $search;

	$meta = get_post_meta( get_the_ID() );

	$subtitle_fields = get_option( 'est_property_subtitles' );
	$subtitle = est_property_subtitle( $filter_options );
?>
<?php
	$data = get_property_detail_list( $search );
	$classes = get_filter_classes( $data );
	$ranges = get_filter_range_atts( $search, $data );
?>

<div <?php post_class('layout-property-filter property ' . $classes ) ?> data-id='<?php the_ID() ?>' <?php echo $ranges ?> >
<?php est_webmaster_tools_data() ?>

	<div class='row'>

		<?php if( has_post_thumbnail() ) : ?>

			<div class='large-6 small-12 columns'>
				<div class='post-image'>
					<a href='<?php the_permalink() ?>' class='hoverlink hide-for-small'>
						<?php the_post_thumbnail( 'est_card' ) ?>
					</a>
					<a href='<?php the_permalink() ?>' class='hoverlink show-for-small mb11'>
						<?php the_post_thumbnail( 'est_card_wide' ) ?>
					</a>
				</div>
			</div>
		<?php endif ?>
			<div class='large-6 small-12 columns'>
			<hgroup>
				<h1><a href='<?php the_permalink() ?>'><?php the_title() ?></a></h1>
				<?php if( !empty( $subtitle ) ) : ?>
					<h2 class='light'><?php echo $subtitle ?></h2>
				<?php endif ?>
			</hgroup>

			<?php
				show_property_detail_table( get_property_detail_list( $filter_options ), '' )
			?>

		</div>

	</div>


</div>