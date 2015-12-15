<?php
/*
Template Name: Submit Page
*/
get_header();

while ( have_posts() ) : the_post();


$full_search = get_post_meta( $post->ID, '_est_full_page_search', true );
$full_search = ( empty( $full_search ) ) ? 'yes' : $full_search;
$search_class = ( $full_search == 'yes' ) ? 'full'
: 'no-full';

$height = get_post_meta( $post->ID, '_est_search_height', true );
$search_style = ( $full_search == 'no' ) ? 'height:' . $height : '';



// Get Attachments

$image_ids = get_post_meta( get_the_ID(), '_est_slideshow_images', true );
if( empty( $image_ids ) ) {
	$attachments = get_posts( 'post_parent=' . get_the_ID() . '&post_type=attachment&orderby=menu_order&order=ASC' );

	$images = array();

	foreach( $attachments as $attachment ) {
		$image = wp_get_attachment_image_src( $attachment->ID, 'full' );
		$images[] = $image[0];
	}

}
else {
	$image_ids = explode( ',', $image_ids );
	$image_ids = array_map( 'trim', $image_ids );
	foreach( $image_ids as $image_id ) {
		$image = wp_get_attachment_image_src( $image_id, 'full' );
		$images[] = $image[0];
	}

}


$imageCount = count( $images );
$background_type = get_post_meta( $post->ID, '_est_search_background_type', true );

if( $imageCount > 0 AND $background_type != 'pageload' ) :
	// Slideshow Setup
	$timer = bs_get_post_meta( '_est_slideshow_speed', 12 );
	$totalTime = $timer * $imageCount;

	$crossfade = 500;
	$totalTimeMs = $totalTime * 1000;

	$stop_1 = round ( $crossfade / $totalTimeMs * 100 ) ;
	$stop_2 = round( ( $totalTimeMs / $imageCount ) / $totalTimeMs * 100 );
	$stop_3 = $stop_2 + $stop_1;
	// CSS Animation
	?>
		<style type='text/css'>
			/* Animation for the slideshow images */
			@-webkit-keyframes imageAnimation {
			    0% { opacity: 0; }
			    <?php echo $stop_1 ?>% { opacity: 1; -webkit-animation-timing-function: ease-in; }
			    <?php echo $stop_2 ?>% { opacity: 1 }
			    <?php echo $stop_3 ?>% { opacity: 0; -webkit-animation-timing-function: ease-out; }
			    100% { opacity: 0; }
			}
			@-moz-keyframes imageAnimation {
			    0% { opacity: 0; }
			    <?php echo $stop_1 ?>% { opacity: 1; -moz-animation-timing-function: ease-in; }
			    <?php echo $stop_2 ?>% { opacity: 1 }
			    <?php echo $stop_3 ?>% { opacity: 0; -moz-animation-timing-function: ease-out; }
			    100% { opacity: 0; }
			}
			@-o-keyframes imageAnimation {
			    0% { opacity: 0; }
			    <?php echo $stop_1 ?>% { opacity: 1; -o-animation-timing-function: ease-in; }
			    <?php echo $stop_2 ?>% { opacity: 1 }
			    <?php echo $stop_3 ?>% { opacity: 0; -o-animation-timing-function: ease-out; }
			    100% { opacity: 0; }
			}
			@-ms-keyframes imageAnimation {
			    0% { opacity: 0; }
			    <?php echo $stop_1 ?>% { opacity: 1; -ms-animation-timing-function: ease-in; }
			    <?php echo $stop_2 ?>% { opacity: 1 }
			    <?php echo $stop_3 ?>% { opacity: 0; -ms-animation-timing-function: ease-out; }
			    100% { opacity: 0; }
			}
			@keyframes imageAnimation {
			    0% { opacity: 0; }
			    <?php echo $stop_1 ?>% { opacity: 1; animation-timing-function: ease-in; }
			    <?php echo $stop_2 ?>% { opacity: 1 }
			    <?php echo $stop_3 ?>% { opacity: 0; animation-timing-function: ease-out; }
			    100% { opacity: 0; }
			}






		</style>

	    <ul class="cb-slideshow <?php echo $search_class ?>" style='<?php echo $search_style ?>'>
	    	<?php
	    		$i = 0;
	    		foreach( $images as $image ) :
		    		$delay = $i * ( $totalTimeMs / $imageCount ) - 500;
		    		$delay = ( $delay < 0 ) ? 0 : $delay;

		    		$total_time = $totalTime;
		    		$style = '
              -webkit-animation: imageAnimation ' . $totalTime . 's linear infinite 0s;
              -moz-animation: imageAnimation ' . $totalTime . 's linear infinite 0s;
              -o-animation: imageAnimation ' . $totalTime . 's linear infinite 0s;
              -ms-animation: imageAnimation ' . $totalTime . 's linear infinite 0s;
              animation: imageAnimation ' . $totalTime . 's linear infinite 0s;
              -webkit-animation-delay: ' . $delay . 'ms;
              -moz-animation-delay: ' . $delay . 'ms;
              -o-animation-delay: ' . $delay . 'ms;
              -ms-animation-delay: ' . $delay . 'ms;
              animation-delay: ' . $delay . 'ms;
					    background-image:url(' . $image . ');
		    		';
	    	?>
		        <li><span style='<?php echo $style ?>'></span></li>
	        <?php $i++; endforeach ?>
	    </ul>
<?php endif  ?>
<?php if( $background_type == 'pageload' ) : ?>
   	 <ul class="cb-slideshow <?php echo $search_class ?>" style='<?php echo $search_style ?>'>
    	<?php
    		shuffle( $images );
    		$images = array( $images[0] );
    		$i = 0;
    		foreach( $images as $image ) :
	    		$style = 'background-image:url(' . $image . '); opacity:1;';
    	?>
	        <li><span style="<?php echo $style ?>"></span></li>
        <?php $i++; endforeach ?>
    </ul>

<?php endif ?>

<div id='search-page' class='<?php echo $search_class ?>'>


	<?php
		$show_title = get_post_meta( get_the_ID(), '_est_show_title_bar', true );
		$show_title = (empty( $show_title ) ) ? 'show' : $show_title;
		if( $show_title == 'show' ) :
	?>
	<div class='full-title'>
		<div class='row'>
			<div class='small-12 large-12 columns'>
				<h1><?php the_title() ?></h1>
			</div>
		</div>
	</div>
	<?php endif ?>

		<div class='row mt44'><div class='large-9 small-12 small-centered columns'>
			<div id='siteContent'>
				<?php if( !empty( $post->post_content ) ) : ?>
					<div class='content mb22'>
						<?php the_content() ?>
					</div>
				<?php endif ?>
				<form id='register-form' action='<?php echo admin_url( 'admin-ajax.php' ) ?>' method='post' class='custom'>


					<div id='advanced-search'>
						<?php
							$search['customdatas'] = get_post_meta( $post->ID, '_est_customdatas', true );
							$search['custom_taxonomies'] = get_post_meta( $post->ID, '_est_taxonomies', true );

							$details = get_search_options( $search );
							est_vertical_search( $details );
						?>
					</div>

					<input type='hidden' name='action' value='est_submit_property'>
					<input type='submit' class='submit button' value='Submit'>

				</form>

			</div>
		</div>


</div>

<?php endwhile; ?>
<?php get_footer(); ?>