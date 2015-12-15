<div class="wrap nosubsub">
<div id='est_header'>
<div id="est_custom_fields_page_icon" class="icon32 icon32-posts-property"><br></div><h2><?php _e( 'Edit Default Fields', THEMENAME ) ?></h2>
</div>


	<?php if( !empty( $_GET['est_success'] ) AND $_GET['est_success'] == 'success' ): ?>
		<div class='est_success'>
			<?php _e( 'Default custom fields have been modified', THEMENAME ) ?>
		</div>
	<?php endif ?>


<form method='post' class='est-form' action='<?php echo admin_url( 'admin-ajax.php' ) ?>' id='add-customdata'>

<h3><?php _e( 'Custom Details', THEMENAME ) ?></h3>
<?php _e( '
	<p>
	Whenever properties are shown, custom fields are usually shown as well. Using the controls below you can set which custom fields should be shown, unless otherwise specified. Note that you can control the custom fields shown for listing pages and shortcode separately if you wish.
	</p>
', THEMENAME ) ?>

<table>
	<tr>
		<th>Custom Field</th>
		<th style='padding-left:11px;'>Order</th>
	</tr>

<?php
	$customdata = get_option( 'est_customdata' );
	$defaults = get_option( 'est_customdata_default' );

	$i=0;
	foreach( $customdata as $data ) :
	$checked = ( !empty( $defaults[$data['key']]['show'] ) AND $defaults[$data['key']]['show'] == 'yes' ) ? 'checked="checked"' : '';
?>
	<tr>
	<td>
	<input <?php echo $checked ?> type='checkbox' name="est_customdata_default[<?php echo $data['key'] ?>][show]" id='est_customdata_default_show<?php echo $i ?>' value='yes'> <label class='noformat' for='est_customdata_default_show<?php echo $i ?>'><?php echo $data['name'] ?></label>
	</td>
		<td style='padding-left:22px;'>
		<?php $order = ( !empty( $defaults[$data['key']]['order'] ) ) ? $defaults[$data['key']]['order'] : '' ?>
		<input type='text' style='width:60px;' name="est_customdata_default[<?php echo $data['key'] ?>][order]" id='est_customdata_default_order<?php echo $i ?>' value='<?php echo $order ?>'>
		</td>
	</tr>

<?php $i++; endforeach ?>
</table>



		<div class='form-row submit-row'>
			<input type='hidden' name='action' value='edit_defaults'>
			<input type='submit' class='button primary submit' value='Edit Default Fields'>
		</div>


</form>


<br><br>


<?php if( !empty( $_GET['est_success'] ) AND $_GET['est_success'] == 'success_subtitle' ): ?>
	<div class='est_success' id='subtitle'>
		<?php _e( 'Default subtitles have been modified', THEMENAME ) ?>
	</div>
<?php endif ?>


<form method='post' class='est-form' action='<?php echo admin_url( 'admin-ajax.php' ) ?>' id='add-customdata'>
<h3><?php _e( 'Property Subtitle', THEMENAME ) ?></h3>

<?php _e( '
	<p>
	In a number of cases there is a subtitle shown under the property name. By default this is the city and state. Here you can select the items you\'d like to show instead. Fill out the order fields using numbers to set the order in which they appear.
	</p>
', THEMENAME ) ?>

<div class='checkboxes'>
<table>
	<tr>
		<th>Custom Field</th>
		<th style='padding-left:11px;'>Order</th>
	</tr>
<?php
	$customdata = get_option( 'est_customdata' );
	$fields = get_option( 'est_property_subtitles' );

	$used_data = array();
	if( !empty( $fields ) ) {
		$used_data = array_keys( $fields );
	}

	$i=0;

	foreach( $customdata as $data ) :
	$value = $data['key'];
	$checked = ( in_array( $value, $used_data ) ) ? 'checked="checked"' : '';
	$order = ( !empty( $fields[$data['key']] ) ) ? $fields[$data['key']] : '';
?>
	<tr><td>
	<input <?php echo $checked ?> type='checkbox' name="est_property_subtitles[<?php echo $i ?>][detail]" id='est_property_subtitles_details_<?php echo $i ?>' value='<?php echo $value ?>'> <label class='noformat'  for='est_property_subtitles_details_<?php echo $i ?>'><?php echo $data['name'] ?></label>
	</td>
	<td style='padding-left:22px;'>
		<input type='text' style='width:60px;' name="est_property_subtitles[<?php echo $i ?>][order]" id='est_property_subtitles_order_<?php echo $i ?>' value='<?php echo $order ?>'>
</td>
</tr>

<?php $i++; endforeach ?>
</table>
</div>



		<div class='form-row submit-row'>
			<input type='hidden' name='action' value='edit_subtitles'>
			<input type='submit' class='button primary submit' value='Edit Property Subtitle Fields'>
		</div>


</form>


</div>
