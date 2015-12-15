<?php
	$taxonomy = array();
	$taxonomies = get_option( 'est_taxonomies' );

	if( !empty( $_GET['taxonomy'] ) AND !empty( $taxonomies[$_GET['taxonomy']] ) ) {
		$taxonomy = $taxonomies[$_GET['taxonomy']];
	}

?>

<div class="wrap nosubsub">
<div id='est_header'>
<div id="est_custom_fields_page_icon" class="icon32 icon32-posts-property"><br></div><h2>
	<?php
		if( !empty( $taxonomy ) ) {
			_e( 'Edit Taxonomy', THEMENAME );
		}
		else {
			_e( 'Add Taxonomy', THEMENAME );
		}
	?>
</h2>
</div>


	<?php if( !empty( $_GET['est_error'] ) AND $_GET['est_error'] == 'exists' ): ?>
		<div class='est_error'>
			<?php _e( 'That taxonomy already exists, please use a different name', THEMENAME ) ?>
		</div>
	<?php endif ?>



	<?php if( !empty( $_GET['est_success'] ) AND $_GET['est_success'] == 'edit' ): ?>
		<div class='est_success'>
			<?php _e( 'Your custom taxonomy has been edited successfully', THEMENAME ) ?>
		</div>
	<?php endif ?>


	<?php if( !empty( $_GET['est_success'] ) AND $_GET['est_success'] == 'true' ): ?>
		<div class='est_success'>
			<?php _e( 'Your custom taxonomy has been added', THEMENAME ) ?>
		</div>
	<?php endif ?>

<?php if( !empty( $taxonomy ) ) : ?>


	<form method='post' class='est-form' action='<?php echo admin_url( 'admin-ajax.php' ) ?>' id='add-customtaxonomy'>

		<div class='form-row'>
			<label for='add-customtaxonomy-name'><?php _e( 'Name', THEMENAME ) ?></label>
			<div class='control'>
				<input type='text' name='name' id='add-customtaxonomy-name' placeholder='<?php _e( 'Eg: Amenities', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['name'] ?>'>
			</div>
		</div>

		<div class='form-row'>
			<label for='add-customtaxonomy-type' class='smalltop'><?php _e( 'Type', THEMENAME ) ?></label>
			<div class='control'>
				<?php
					$choices = array( 1 => 'Hierarchical (like post categories)', 0 => 'Non-hierarchical (like tags)' );
				?>
				<select name='hierarchical' id='add-customtaxonomy-type'>
					<?php
						foreach( $choices as $value => $name ) :
						$selected = ( ( $value == $taxonomy['hierarchical'] ) OR ( empty( $taxonomy['hierarchical'] ) AND $value == 0  ) ) ? 'selected="selected"' : '';
					?>
						<option <?php echo $selected ?> value='<?php echo $value ?>'><?php echo $name ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>

		<h4 id='open-advanced-options'>Advanced Options &raquo;</h4>

		<div id='advanced-options' style='display:none'>
			<div class='form-row'>
				<label for='add-customtaxonomy-singular_name' class='smalltop'><?php _e( 'Singular Name', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='singular_name' id='add-customtaxonomy-singular_name' placeholder='<?php _e( 'Eg: Amenity', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['singular_name'] ?>'>
				</div>
			</div>


			<div class='form-row'>
				<label for='add-customtaxonomy-search_items' class='smalltop'><?php _e( 'Search Items', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='search_items' id='add-customtaxonomy-search_items' placeholder='<?php _e( 'Eg: Search Amenities', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['search_items'] ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-all_items' class='smalltop'><?php _e( 'All Items', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='all_items' id='add-customtaxonomy-all_items' placeholder='<?php _e( 'Eg: All Amenities', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['all_items'] ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-parent_item' class='smalltop'><?php _e( 'Parent Item', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='parent_item' id='add-customtaxonomy-parent_item' placeholder='<?php _e( 'Eg: Parent Amenity', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['parent_item'] ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-edit_item' class='smalltop'><?php _e( 'Edit Item', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='edit_item' id='add-customtaxonomy-edit_item' placeholder='<?php _e( 'Eg: Edit Amenity', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['edit_item'] ?>'>
				</div>
			</div>


			<div class='form-row'>
				<label for='add-customtaxonomy-update_item' class='smalltop'><?php _e( 'Update Item', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='update_item' id='add-customtaxonomy-update_item' placeholder='<?php _e( 'Eg: Update Amenity', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['update_item'] ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-add_new_item' class='smalltop'><?php _e( 'Add New Item', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='add_new_item' id='add-customtaxonomy-add_new_item' placeholder='<?php _e( 'Eg: Add New Amenity', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['add_new_item'] ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-new_item_name' class='smalltop'><?php _e( 'New Item Name', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='new_item_name' id='add-customtaxonomy-new_item_name' placeholder='<?php _e( 'Eg: New Amenity Name', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['new_item_name'] ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-menu_name' class='smalltop'><?php _e( 'Menu Name', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='menu_name' id='add-customtaxonomy-menu_name' placeholder='<?php _e( 'Eg: Amenities', THEMENAME ) ?>' value='<?php echo $taxonomy['labels']['menu_name'] ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-slug' class='smalltop'><?php _e( 'Slug', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='slug' id='add-customtaxonomy-slug' placeholder='<?php _e( 'All lowercase, no spaces, used in the URL', THEMENAME ) ?>' value='<?php echo $taxonomy['slug'] ?>'>
				</div>
			</div>
		</div>

		<div class='form-row submit-row'>
			<input type='hidden' name='action' value='edit_customtaxonomy'>
			<input type='hidden' name='taxonomy' value='<?php echo $_GET['taxonomy'] ?>'>
			<input type='submit' class='button primary submit' value='Modify Taxonomy'>
		</div>

	</form>




<?php else : ?>

	<form method='post' class='est-form' action='<?php echo admin_url( 'admin-ajax.php' ) ?>' id='add-customtaxonomy'>

		<div class='form-row'>
			<label for='add-customtaxonomy-name'><?php _e( 'Name', THEMENAME ) ?></label>
			<div class='control'>
				<input type='text' name='name' id='add-customtaxonomy-name' placeholder='<?php _e( 'Eg: Amenities', THEMENAME ) ?>'>
			</div>
		</div>

		<div class='form-row'>
			<label for='add-customtaxonomy-type' class='smalltop'><?php _e( 'Type', THEMENAME ) ?></label>
			<div class='control'>
				<select name='hierarchical' id='add-customtaxonomy-type'>
					<option value='1'>Hierarchical (like post categories) </option>
					<option value='0'>Non-hierarchical (like tags) </option>
				</select>
			</div>
		</div>

		<h4 id='open-advanced-options'>Advanced Options &raquo;</h4>

		<div id='advanced-options' style='display:none'>

			<div class='form-row'>
				<label for='add-customtaxonomy-singular_name' class='smalltop'><?php _e( 'Singular Name', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='singular_name' id='add-customtaxonomy-singular_name' placeholder='<?php _e( 'Eg: Amenity', THEMENAME ) ?>'>
				</div>
			</div>


			<div class='form-row'>
				<label for='add-customtaxonomy-search_items' class='smalltop'><?php _e( 'Search Items', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='search_items' id='add-customtaxonomy-search_items' placeholder='<?php _e( 'Eg: Search Amenities', THEMENAME ) ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-all_items' class='smalltop'><?php _e( 'All Items', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='all_items' id='add-customtaxonomy-all_items' placeholder='<?php _e( 'Eg: All Amenities', THEMENAME ) ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-parent_item' class='smalltop'><?php _e( 'Parent Item', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='parent_item' id='add-customtaxonomy-parent_item' placeholder='<?php _e( 'Eg: Parent Amenity', THEMENAME ) ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-edit_item' class='smalltop'><?php _e( 'Edit Item', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='edit_item' id='add-customtaxonomy-edit_item' placeholder='<?php _e( 'Eg: Edit Amenity', THEMENAME ) ?>'>
				</div>
			</div>


			<div class='form-row'>
				<label for='add-customtaxonomy-update_item' class='smalltop'><?php _e( 'Update Item', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='update_item' id='add-customtaxonomy-update_item' placeholder='<?php _e( 'Eg: Update Amenity', THEMENAME ) ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-add_new_item' class='smalltop'><?php _e( 'Add New Item', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='add_new_item' id='add-customtaxonomy-add_new_item' placeholder='<?php _e( 'Eg: Add New Amenity', THEMENAME ) ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-new_item_name' class='smalltop'><?php _e( 'New Item Name', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='new_item_name' id='add-customtaxonomy-new_item_name' placeholder='<?php _e( 'Eg: New Amenity Name', THEMENAME ) ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-menu_name' class='smalltop'><?php _e( 'Menu Name', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='menu_name' id='add-customtaxonomy-menu_name' placeholder='<?php _e( 'Eg: Amenities', THEMENAME ) ?>'>
				</div>
			</div>

			<div class='form-row'>
				<label for='add-customtaxonomy-slug' class='smalltop'><?php _e( 'Slug', THEMENAME ) ?></label>
				<div class='control'>
					<input type='text' name='slug' id='add-customtaxonomy-slug' placeholder='<?php _e( 'All lowercase, no spaces, used in the URL', THEMENAME ) ?>'>
				</div>
			</div>

		</div>

		<div class='form-row submit-row'>
			<input type='hidden' name='action' value='add_customtaxonomy'>
			<input type='submit' class='button primary submit' value='+ Add Taxonomy'>
		</div>

	</form>

<?php endif ?>

</div>


