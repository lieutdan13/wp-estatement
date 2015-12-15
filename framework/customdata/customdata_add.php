<?php
	$customitem = array();
	if( !empty( $_GET['key'] ) ) {
		$customitem = array();
		$customdata = get_option( 'est_customdata' );
		foreach( $customdata as $item ) {
			if( $item['key'] == $_GET['key'] ) {
				$customitem = $item;
			}
		}
		$customitem['prefix'] = ( empty( $customitem['prefix'] ) ) ? '' : $customitem['prefix'];
		$customitem['suffix'] = ( empty( $customitem['suffix'] ) ) ? '' : $customitem['suffix'];


	}

?>

<div class="wrap nosubsub">
<div id='est_header'>
<div id="est_custom_fields_page_icon" class="icon32 icon32-posts-property"><br></div><h2>
	<?php
		if( !empty( $customitem ) ) {
			_e( 'Edit Custom Field', THEMENAME );
		}
		else {
			_e( 'Add Custom Field', THEMENAME );
		}
	?>
</h2>
</div>

	<?php if( !empty( $_GET['est_error'] ) AND $_GET['est_error'] == 'true' ): ?>
		<div class='est_error'>
			<?php _e( 'There was an error adding your field. Please make sure that you\'ve filled out the name and if you selected a type with multiple options you fill out at least one of them', THEMENAME ) ?>
		</div>
	<?php endif ?>

	<?php if( !empty( $_GET['est_error'] ) AND $_GET['est_error'] == 'edit' ): ?>
		<div class='est_error'>
			<?php _e( 'There was an error editing your field. Please make sure that you\'ve filled out the name and if you selected a type with multiple options you fill out at least one of them. Also, make sure you\'re edited item is not the same as any existing custom field', THEMENAME ) ?>
		</div>
	<?php endif ?>


	<?php if( !empty( $_GET['est_success'] ) AND $_GET['est_success'] == 'edit' ): ?>
		<div class='est_success'>
			<?php _e( 'Your field has been edited successfully', THEMENAME ) ?>
		</div>
	<?php endif ?>


	<?php if( !empty( $_GET['est_success'] ) AND $_GET['est_success'] == 'true' ): ?>
		<div class='est_success'>
			<?php _e( 'Your field has been added', THEMENAME ) ?>
		</div>
	<?php endif ?>

<?php if( !empty( $customitem ) ) : ?>


<form method='post' class='est-form' action='<?php echo admin_url( 'admin-ajax.php' ) ?>' id='add-customdata'>

	<div class='form-row'>
		<label for='add-customdata-name'><?php _e( 'Name', THEMENAME ) ?></label>
		<div class='control'>
			<input type='text' name='name' id='add-customdata-name' placeholder='<?php _e( 'The name of your custom field', THEMENAME ) ?>' value='<?php echo $customitem['name'] ?>'>
		</div>
	</div>

	<div class='form-row'>
		<label for='add-customdata-key'><?php _e( 'Key', THEMENAME ) ?></label>
		<div class='control'>
			<input type='text' name='key' id='add-customdata-key' placeholder='<?php _e( 'The key used to reference this field', THEMENAME ) ?>' value='<?php echo str_replace( '_est_meta_', '', $customitem['key'] ) ?>'>
			<small><?php _e( 'The key will be used when you want to specify which custom details to show and in some other places. Please use only small latin characters and underscores ', THEMENAME ) ?></small>
		</div>
	</div>

	<div class='form-row'>
		<label for='add-customdata-type' class='smalltop'><?php _e( 'Type', THEMENAME ) ?></label>
		<div class='control'>
			<select name='type' id='add-customdata-type'>
				<?php echo est_get_customdata_type_dropdown_options( $customitem['type'] ) ?>
			</select>
		</div>
	</div>

	<div class='form-row'>
		<label for='add-customdata-prefix' class='smalltop'><?php _e( 'Prefix', THEMENAME ) ?></label>
		<div class='control'>
			<input type='text' name='prefix' id='add-customdata-prefix' placeholder='<?php _e( 'Add a prefix to this field', THEMENAME ) ?>' value='<?php echo esc_attr($customitem['prefix']) ?>'>
		</div>
	</div>

	<div class='form-row'>
		<label for='add-customdata-suffix' class='smalltop'><?php _e( 'Suffix', THEMENAME ) ?></label>
		<div class='control'>
			<input type='text' name='suffix' id='add-customdata-suffix' placeholder='<?php _e( 'Add a suffix to this field', THEMENAME ) ?>' value='<?php echo esc_attr($customitem['suffix']) ?>'>
		</div>
	</div>

	<div class='form-row'>
		<label for='add-customdata-suffix' class='smalltop'><?php _e( 'Format', THEMENAME ) ?></label>
		<div class='control'>
			<select name='format' id='add-customdata-number_format'>
			<?php
				$options = array(
					'text'   => __( 'Format as regular text', THEMENAME ),
					'number' => __( 'Format as number', THEMENAME )
				);
				foreach( $options as $value => $name ) :
				$selected = ( !empty( $customitem['format'] ) AND $customitem['format'] == $value ) ? 'selected="selected"' : '';
			?>
			<option <?php echo $selected ?> value='<?php echo $value ?>'><?php echo $name ?></option>
			<?php endforeach ?>
			</select>
		</div>
	</div>


	<?php
		$style = ( ( !empty( $customitem['options'] ) ) ) ? '' : "style='display:none;'";
	?>
	<div class='form-row' id='add-customdata-options' style='<?php echo $style ?>'>
		<label for='type'><?php _e( 'Options', THEMENAME ) ?></label>
		<div class='control'>
			<div class='options'>
				<?php if( empty( $customitem['options'] ) ) : ?>
				<div class='option'>
					<input type='text' name='options[0][name]' placeholder='<?php _e( 'Option Name', THEMENAME ) ?>'>
					<input type='text' name='options[0][value]' placeholder='<?php _e( 'Option Value', THEMENAME ) ?>'>
				</div>
				<div class='option'>
					<input type='text' name='options[1][name]' placeholder='<?php _e( 'Option Name', THEMENAME ) ?>'>
					<input type='text' name='options[1][value]' placeholder='<?php _e( 'Option Value', THEMENAME ) ?>'>
				</div>

				<?php else : ?>
					<?php $i=0; foreach( $customitem['options'] as $option ) : ?>
					<div class="option">
					<input type='text' name='options[<?php echo $i ?>][name]' placeholder='<?php _e( 'Option Name', THEMENAME ) ?>' value='<?php echo $option['name'] ?>'>

					<input type='text' name='options[<?php echo $i ?>][value]' placeholder='<?php _e( 'Option Value', THEMENAME ) ?>' value='<?php echo $option['value'] ?>'>

					</div>
					<?php $i++; endforeach ?>
				<?php endif ?>
			</div>
			<a id='add-customdata-add-option' href='#'><?php _e( '+ add another', THEMENAME ) ?></a>
		</div>
	</div>


	<div class='form-row submit-row'>
		<input type='hidden' name='original_key' value='<?php echo $customitem['key'] ?>'>
		<input type='hidden' name='action' value='edit_customdata'>
		<input type='submit' class='button primary submit' value='+ Edit Custom Field'>
	</div>

</form>



<?php else : ?>

	<form method='post' class='est-form' action='<?php echo admin_url( 'admin-ajax.php' ) ?>' id='add-customdata'>

		<div class='form-row'>
			<label for='add-customdata-name'><?php _e( 'Name', THEMENAME ) ?></label>
			<div class='control'>
				<input type='text' name='name' id='add-customdata-name' placeholder='<?php _e( 'The name of your custom field', THEMENAME ) ?>'>
			</div>
		</div>

	<div class='form-row'>
		<label for='add-customdata-key'><?php _e( 'Key', THEMENAME ) ?></label>
		<div class='control'>
			<input type='text' name='key' id='add-customdata-key' placeholder='<?php _e( 'The key used to reference this field', THEMENAME ) ?>'>
			<small><?php _e( 'The key will be used when you want to specify which custom details to show and in some other places. Please use only small latin characters and underscores ', THEMENAME ) ?></small>
		</div>
	</div>




		<div class='form-row'>
			<label for='add-customdata-type' class='smalltop'><?php _e( 'Type', THEMENAME ) ?></label>
			<div class='control'>
				<select name='type' id='add-customdata-type'>
					<?php echo est_get_customdata_type_dropdown_options() ?>
				</select>
			</div>
		</div>

		<div class='form-row'>
			<label for='add-customdata-prefix' class='smalltop'><?php _e( 'Prefix', THEMENAME ) ?></label>
			<div class='control'>
				<input type='text' name='prefix' id='add-customdata-prefix' placeholder='<?php _e( 'Add a prefix to this field', THEMENAME ) ?>'>
			</div>
		</div>

		<div class='form-row'>
			<label for='add-customdata-suffix' class='smalltop'><?php _e( 'Suffix', THEMENAME ) ?></label>
			<div class='control'>
				<input type='text' name='suffix' id='add-customdata-suffix' placeholder='<?php _e( 'Add a suffix to this field', THEMENAME ) ?>'>
			</div>
		</div>

		<div class='form-row'>
			<label for='add-customdata-suffix' class='smalltop'><?php _e( 'Format', THEMENAME ) ?></label>
			<div class='control'>
				<select name='format' id='add-customdata-number_format'>
				<?php
					$options = array(
						'text'   => __( 'Format as regular text', THEMENAME ),
						'number' => __( 'Format as number', THEMENAME )
					);
					foreach( $options as $value => $name ) :
				?>
				<option  value='<?php echo $value ?>'><?php echo $name ?></option>
				<?php endforeach ?>
				</select>
			</div>
		</div>


		<div class='form-row' id='add-customdata-options' style='display:none;'>
			<label for='type'><?php _e( 'Options', THEMENAME ) ?></label>
			<div class='control'>
				<div class='options'>
					<div class='option'>
						<input type='text' name='options[0][name]' placeholder='<?php _e( 'Option Name', THEMENAME ) ?>'>
						<input type='text' name='options[0][value]' placeholder='<?php _e( 'Option Value', THEMENAME ) ?>'>
					</div>
					<div class='option'>
						<input type='text' name='options[1][name]' placeholder='<?php _e( 'Option Name', THEMENAME ) ?>'>
						<input type='text' name='options[1][value]' placeholder='<?php _e( 'Option Value', THEMENAME ) ?>'>
					</div>
				</div>
				<a id='add-customdata-add-option' href='#'><?php _e( '+ add another', THEMENAME ) ?></a>
			</div>
		</div>


		<div class='form-row submit-row'>
			<input type='hidden' name='action' value='add_customdata'>
			<input type='submit' class='button primary submit' value='+ Add Custom Field'>
		</div>

	</form>

<?php endif ?>

</div>


