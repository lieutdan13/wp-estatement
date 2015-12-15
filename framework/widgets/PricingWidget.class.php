<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file contains the featured item widget.
	The featured item allows for the upload of
	an image, the specification of some text and
	a link to show as a featured item.
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*
	1. Featured Item Widget Class
		1.1 Constructor
		1.2 Backend Form
		1.3 Save Widget Options
		1.4 Frontend Widget Display

	2. Widget Registration

*/

/***********************************************/
/*       1. Featured Item Widget Class         */
/***********************************************/

class bshPricingWidget extends WP_Widget {

    var $image_field = 'image';

	// 1.1 Constructor
	function bshPricingWidget() {
        parent::WP_Widget(
        	false,
        	__( 'Estatement: Pricing Widget', THEMENAME ),
        	array(
        		'description' => __( 'This widget displays a list of pricing for the property in question', THEMENAME )
        	)
        );
    }

	// 1.2 Backend Form
	function form( $instance ) {
		$defaults = array(
			'title'              => '',
		);
		$values = wp_parse_args( $instance, $defaults );
        $image  = new WidgetImageField( $this, $values['image'] );

		?>
        <p>
        	<label for='<?php echo $this->get_field_id('title'); ?>'>
        		<?php _e( 'Title:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'title' ); ?>' name='<?php echo $this->get_field_name( 'title' ); ?>' type='text' value='<?php echo $values['title']; ?>' />
        	</label>
        </p>



        <?php
    }

	// 1.3 Save Widget Options
	function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

	// 1.4 Frontend Widget Display
	function widget( $args, $instance ) {
		global $post, $wpdb;
		$bookable = get_post_meta( $post->ID, '_est_bookable', true );
		if( $bookable == 'yes' ) {
			echo $args['before_widget'];
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) .  $args['after_title'];

			$pricing['daily']   = get_post_meta( $post->ID, '_est_rent_daily_price', true );
			$pricing['weekly']  = get_post_meta( $post->ID, '_est_rent_weekly_price', true );
			$pricing['monthly'] = get_post_meta( $post->ID, '_est_rent_monthly_price', true );

			$currency = get_post_meta( $post->ID, '_est_rent_currency', true );
			$currency_position = get_post_meta( $post->ID, '_est_rent_currency_position', true );
			$pricing = array_filter( $pricing );

			if( !empty( $pricing ) ) :
			?>
			<h5><?php _e( 'Regular Prices', THEMENAME ) ?></h5>
			<table class="detail-table mb11">
				<tbody>
					<?php if( !empty( $pricing['daily'] ) ) : ?>
					<tr>
						<td class="name"><?php _e( 'Daily Price' ) ?></td>
						<td class="value"><?php echo est_get_amount( $pricing['daily'], $currency, $currency_position ) ?></td>
					</tr>
					<?php endif ?>
					<?php if( !empty( $pricing['weekly'] ) ) : ?>
					<tr>
						<td class="name"><?php _e( 'Weekly Price' ) ?></td>
						<td class="value"><?php echo est_get_amount( $pricing['weekly'], $currency, $currency_position ) ?></td>
					</tr>
					<?php endif ?>
					<?php if( !empty( $pricing['monthly'] ) ) : ?>
					<tr>
						<td class="name"><?php _e( 'Monthly Price' ) ?></td>
						<td class="value"><?php echo est_get_amount( $pricing['monthly'], $currency, $currency_position ) ?></td>
					</tr>
					<?php endif ?>
				</tbody>
			</table>

			<?php
				endif;
				$seasonal = get_post_meta( $post->ID, '_est_rent_seasonal_price', true );

				if( !empty( $seasonal ) ) {
					foreach( $seasonal as $season ) {
						if( !empty( $season['start'] ) AND !empty( $season['end'] ) ) {

						$season_name = ( !empty( $season['name'] ) ) ? $season['name'] . ' - <small>' . $season['start'] .' - ' . $season['end'] . '</small>': $season['start'] .' - ' . $season['end'];

			?>
				<h5><?php echo $season_name ?></h5>
				<table class="detail-table mb11">
				<tbody>
					<?php if( !empty( $season['price']['daily'] ) ) : ?>
					<tr>
						<td class="name"><?php _e( 'Daily Price' ) ?></td>
						<td class="value"><?php echo est_get_amount( $season['price']['daily'], $currency, $currency_position ) ?></td>
					</tr>
					<?php endif ?>
					<?php if( !empty( $season['price']['weekly'] ) ) : ?>
					<tr>
						<td class="name"><?php _e( 'Weekly Price' ) ?></td>
						<td class="value"><?php echo est_get_amount( $season['price']['weekly'], $currency, $currency_position ) ?></td>
					</tr>
					<?php endif ?>
					<?php if( !empty( $season['price']['monthly'] ) ) : ?>
					<tr>
						<td class="name"><?php _e( 'Monthly Price' ) ?></td>
						<td class="value"><?php echo est_get_amount( $season['price']['monthly'], $currency, $currency_position ) ?></td>
					</tr>
					<?php endif ?>
				</tbody>
				</table>

			<?php
						}
					}
				}
			echo $args['after_widget'];
		}
    }
}


/***********************************************/
/*          2. Widget Registration             */
/***********************************************/

register_widget('bshPricingWidget');

?>