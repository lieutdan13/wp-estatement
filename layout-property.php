<div <?php post_class( 'layout-property' ) ?>>

<?php est_webmaster_tools_data() ?>

	<?php
		$large_image_size = ( get_theme_mod( 'property_slider_crop' ) == 'full' ) ? 'est_large_nocrop' : 'est_large'
	?>

	<?php if( !empty( $_GET['message_sent'] ) AND $_GET['message_sent'] == 'true' ) : ?>
		<div class="alert-box success" data-alert>
		  <?php
			  $contact_success_message = get_theme_mod('contact_success_message');
			  $contact_success_message = ( empty( $contact_success_message ) ) ? ' Thank you for your message' : $contact_success_message;
			  echo $contact_success_message;
		  ?>
		  <a href="#" class="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if( !empty( $_GET['message_sent'] ) AND $_GET['message_sent'] == 'captcha' ) : ?>
		<div class="alert-box alert" data-alert>
		  <?php
			  $contact_error_message = get_theme_mod('contact_error_captcha');
			  $contact_error_message = ( empty( $contact_error_message ) ) ? ' Please fill out the captcha correctly' : $contact_error_message;
			  echo $contact_error_message;
		  ?>
		  <a href="#" class="close">&times;</a>
		</div>
	<?php endif ?>
	<?php if( !empty( $_GET['message_sent'] ) AND $_GET['message_sent'] == 'email' ) : ?>
		<div class="alert-box alert" data-alert>
		  <?php
			  $contact_error_message = get_theme_mod('contact_error_email');
			  $contact_error_message = ( empty( $contact_error_message ) ) ? ' Please provide your email address' : $contact_error_message;
			  echo $contact_error_message;
		  ?>
		  <a href="#" class="close">&times;</a>
		</div>
	<?php endif ?>

<?php

	$top_element = get_post_meta( $post->ID, '_est_top_element', true );
	$top_element = ( empty( $top_element ) ) ? 'slider' : $top_element;

	if( $top_element != 'none' ) {
		$thumbnail_id = get_post_thumbnail_id();
		$images = array();

		if( $top_element == 'thumbnail' ) {
			$large = wp_get_attachment_image_src( $thumbnail_id, 'est_large' );
			$small = wp_get_attachment_image_src( $thumbnail_id, 'est_small' );
			$images[$thumbnail_id] = array(
				'large' => array( 'url' => $large[0], 'title' => get_the_title( $thumnail_id ) ),
				'small' => array( 'url' => $small[0], 'title' => get_the_title( $thumnail_id ) ),
			);
		}
		else {

			$image_ids = get_post_meta( get_the_ID(), '_est_slider_image_ids', true );
			if( !empty( $image_ids ) ) {
				$image_ids = explode( ',', $image_ids );
				$image_ids = array_map( 'trim', $image_ids );
			}

			if( !empty( $image_ids ) ) {
				$attachments = get_posts(array(
					'post_type' => 'attachment',
					'post_status' => 'any',
					'posts_per_page' => -1,
					'post_mime_type' => array( 'image/png', 'image/jpg', 'image/tif', 'image/gif', 'image/jpeg' ),
					'post__in' => $image_ids
				));
			}
			else {
				$attachments = get_posts(array(
					'post_type' => 'attachment',
					'post_status' => 'any',
					'post_parent' => get_the_ID(),
					'post_mime_type' => array( 'image/png', 'image/jpg', 'image/tif', 'image/gif', 'image/jpeg' ),
					'posts_per_page' => -1
				));
			}

			foreach( $attachments as $attachment ) {
				$large = wp_get_attachment_image_src( $attachment->ID, $large_image_size );
				$small = wp_get_attachment_image_src( $attachment->ID, 'est_small' );
				$images[$attachment->ID] = array(
					'large' => array( 'url' => $large[0], 'title' => get_the_title( $attachment->ID ) ),
					'small' => array( 'url' => $small[0], 'title' => get_the_title( $attachment->ID ) )
				);
			}

			if( !empty( $thumbnail_id ) AND in_array( $thumbnail_id, array_keys( $images ) ) ) {
				$images[0] = $images[$thumbnail_id];
				unset( $images[$thumbnail_id] );
			}
			elseif( !empty( $thumbnail_id ) AND !in_array( $thumbnail_id, array_keys( $images ) ) ) {
				$large = wp_get_attachment_image_src( $thumbnail_id, $large_image_size );
				$small = wp_get_attachment_image_src( $thumbnail_id, 'est_small' );
				$images[0] = array(
					'large' => array( 'url' => $large[0], 'title' => get_the_title( $thumbnail_id ) ),
					'small' => array( 'url' => $small[0], 'title' => get_the_title( $thumbnail_id ) )
				);
			}
		}
		ksort( $images );
		$imageCount = count( $images );
	}
?>

<?php if( $top_element != 'none' ) : ?>
	<div id='post-slider'>
		<?php
			$detail = get_post_meta( get_the_ID(), '_est_ribbon_field', true );
			$detail = ( empty( $detail ) OR $detail == 'default' ) ? get_theme_mod( 'property_ribbon_field' ) : $detail;
			$detail = ( empty( $detail ) ) ? '_est_meta_price' : $detail;
			$value = get_post_meta( get_the_ID(), $detail ) ;

			$value = est_customdata_value( $detail, $value );
			if( !empty( $value ) ) :
		?>
			<div id='price-flag'><span class='price'><?php echo $value ?></span></div>
		<?php endif ?>
		<div id="property-slider" class="flexslider">
			<ul class="slides">
				<?php foreach( $images as $image ) : ?>
					<li>
						<img src="<?php echo $image['large']['url'] ?>" title='<?php echo $image['small']['title'] ?>' alt='<?php echo $image['small']['title'] ?>' />
					</li>
				<?php endforeach ?>
			</ul>
		</div>

		<?php if( $imageCount > 1 ) : ?>
		<div id="property-carousel" class="flexslider carousel">
			<ul class="slides">
				<?php foreach( $images as $image ) : ?>
					<li>
						<img src="<?php echo $image['small']['url'] ?>" title='<?php echo $image['small']['title'] ?>' />
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php endif ?>
	</div>
<?php endif ?>

<div class='content'>
	<?php the_content() ?>
</div>

<?php
if( get_theme_mod( 'property_commenting' ) == 'yes' ) {
	comments_template();
}
?>

<?php
$property_post_links = get_theme_mod('property_post_links');
if( $property_post_links == 'yes' ) :
?>

<div class="property-post-nav">
	<div class='prev'>
	<?php previous_post_link(); ?>
	</div>
	<div class='next'>
	<?php next_post_link(); ?>
	</div>
</div>

<?php endif ?>

</div>