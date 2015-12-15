<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

include( 'EST_Customdata_Table.class.php' );
include( 'EST_ProfileFields_Table.class.php' );
include( 'EST_Customtaxonomy_Table.class.php' );



/** ************************ REGISTER THE TEST PAGE ****************************
 *******************************************************************************
 * Now we just need to define an admin page. For this example, we'll add a top-level
 * menu item to the bottom of the admin menus.
 */
add_action('admin_menu', 'est_customdata_menu');
function est_customdata_menu(){
    add_menu_page( __( 'Manage your custom field settings', THEMENAME ) , __( 'Custom Data', THEMENAME ), 'manage_options', 'est_custom_fields', 'est_render_list_page', '', "28.234" );
    add_submenu_page( 'est_custom_fields', __( 'Custom Field List', THEMENAME ), __( 'Custom Fields', THEMENAME ), 'manage_options', 'est_custom_fields', 'est_render_list_page' );
    add_submenu_page( 'est_custom_fields', __( 'Add a new custom field', THEMENAME ), __( '+ New Custom Field', THEMENAME ), 'manage_options', 'est_custom_fields_add', 'est_render_add_page' );
    add_submenu_page( 'est_custom_fields', __( 'Manage your custom taxonomies', THEMENAME ), __( 'Custom Taxonomies', THEMENAME ), 'manage_options', 'est_custom_taxonomies', 'est_render_custom_taxonomies_page' );
    add_submenu_page( 'est_custom_fields', __( 'Add a new custom taxonomy', THEMENAME ), __( '+ New Taxonomy', THEMENAME ), 'manage_options', 'est_custom_taxonomy_add', 'est_render_add_taxonomy_page' );
    add_submenu_page( 'est_custom_fields', __( 'Profile Field List', THEMENAME ), __( 'Profile Fields', THEMENAME ), 'manage_options', 'est_profile_fields', 'est_render_profile_fields_list' );
    add_submenu_page( 'est_custom_fields', __( 'Add a new profile field', THEMENAME ), __( '+ New Profile Field', THEMENAME ), 'manage_options', 'est_profile_fields_add', 'est_render_profile_field_add_page' );
    add_submenu_page( 'est_custom_fields', __( 'Set default fields shown', THEMENAME ), __( 'Default Fields', THEMENAME ), 'manage_options', 'est_custom_fields_defaults', 'est_render_defaults_page' );
    add_submenu_page( 'est_custom_fields', __( 'Custom Fields Help', THEMENAME ), __( 'Help', THEMENAME ), 'manage_options', 'est_custom_fields_help', 'est_render_help_page' );
}



/***************************** RENDER TEST PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the example list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function est_render_list_page(){
	include( get_template_directory() . '/framework/customdata/customdata_display.php' );
}


function est_render_add_page(){
	include( get_template_directory() . '/framework/customdata/customdata_add.php' );
}


function est_render_defaults_page(){
	include( get_template_directory() . '/framework/customdata/customdata_defaults.php' );
}

function est_render_help_page(){
	include( get_template_directory() . '/framework/customdata/customdata_help.php' );
}

function est_render_custom_taxonomies_page(){
	include( get_template_directory() . '/framework/customdata/customtaxonomies_display.php' );
}

function est_render_add_taxonomy_page(){
	include( get_template_directory() . '/framework/customdata/customtaxonomies_add.php' );
}

function est_render_profile_fields_list(){
	include( get_template_directory() . '/framework/customdata/profilefields_display.php' );
}

function est_render_profile_field_add_page(){
	include( get_template_directory() . '/framework/customdata/profilefields_add.php' );
}




add_action( 'admin_enqueue_scripts', 'est_customdata_styles' );
function est_customdata_styles($hook) {

	$pages = array( 'toplevel_page_est_custom_fields', 'custom-data_page_est_profile_fields_add', 'custom-data_page_est_custom_fields_add', 'custom-data_page_est_custom_taxonomies', 'custom-data_page_est_custom_fields_defaults', 'custom-data_page_est_custom_taxonomy_add' );
    if( !in_array( $hook, $pages ) )
        return;
	wp_register_style(
		'est_customdata',
		get_template_directory_uri() . '/framework/customdata/customdata.css',
		array(),
		THEMEVERSION
	);
	wp_enqueue_style( 'est_customdata' );
}


add_action( 'admin_enqueue_scripts', 'est_customdata_scripts' );
function est_customdata_scripts($hook) {
	$pages = array( 'toplevel_page_est_custom_fields', 'custom-data_page_est_profile_fields_add', 'custom-data_page_est_custom_fields_add', 'custom-data_page_est_custom_taxonomies', 'custom-data_page_est_custom_fields_defaults', 'custom-data_page_est_custom_taxonomy_add' );
    if( !in_array( $hook, $pages ) )
        return;
	wp_register_script(
		'est_customdata',
		get_template_directory_uri() . '/framework/customdata/customdata.min.js',
		array(),
		THEMEVERSION,
		true
	);
	wp_enqueue_script( 'est_customdata' );
}

add_action( 'wp_ajax_add_customdata', 'est_add_customdata' );
function est_add_customdata() {
	$error = false;
	$_POST['options'] = array_filter( $_POST['options'] );
	foreach( $_POST['options'] as $key => $option ) {
		if( is_array( $option ) ) {
			if( empty( $option['name'] ) OR $option['value'] === '' ) {
				unset( $_POST['options'][$key] );
			}
		}
	}
	$_POST = stripslashes_deep( $_POST );

	$option_types = array( 'dropdown', 'checkbox', 'radio' );

	if( empty( $_POST['name'] ) ) {
		$error = true;
	}
	if( in_array( $_POST['type'], $option_types ) AND empty( $_POST['options'] ) ) {
		$error = true;
	}

	if( $error == true ) {
		$redirect = admin_url( 'admin.php?page=est_custom_fields_add' );
		$redirect = $redirect . '&est_error=true';
	}
	else {
		$redirect = admin_url( 'admin.php?page=est_custom_fields_add' );
		$redirect = $redirect . '&est_success=true';
	}

	$key = ( empty( $_POST['key'] ) ) ? bsh_make_custom_key( $_POST['name'] ) : bsh_make_custom_key( $_POST['key'] );

	$new_data = array(
		'name' => $_POST['name'],
		'key'  => $key,
		'type' => $_POST['type'],
		'format' => $_POST['format'],
	);

	if( !empty( $_POST['prefix'] ) ) {
		$new_data['prefix'] = $_POST['prefix'];
	}

	if( !empty( $_POST['suffix'] ) ) {
		$new_data['suffix'] = $_POST['suffix'];
	}

	if( !empty( $_POST['options'] ) ) {
		$new_data['options'] = $_POST['options'];
	}



    $data = get_option( 'est_customdata' );
    $data[$new_data['key']] = $new_data;

    update_option( 'est_customdata', $data );


	header( 'Location: ' . $redirect );
	die();
}


add_action( 'wp_ajax_edit_customdata', 'est_edit_customdata' );
function est_edit_customdata() {
	$error = false;
	$customdata = get_option( 'est_customdata' );

	$_POST['options'] = array_filter( $_POST['options'] );
	foreach( $_POST['options'] as $key => $option ) {
		if( is_array( $option ) ) {
			if( empty( $option['name'] ) OR $option['value'] === '' ) {
				unset( $_POST['options'][$key] );
			}
		}
	}
	$_POST = stripslashes_deep( $_POST );

	$option_types = array( 'dropdown', 'checkbox', 'radio' );

	if( empty( $_POST['name'] ) ) {
		$error = true;
	}
	if( in_array( $_POST['type'], $option_types ) AND empty( $_POST['options'] ) ) {
		$error = true;
	}

/*
	foreach( $customdata as $customitem ) {
		if( $customitem['name'] == $_POST['name'] AND $customitem['key'] != bsh_make_custom_key( $_POST['name'] ) ) {
			$error = true;
		}
	}
*/


	if( $error == true ) {
		$redirect = admin_url( 'admin.php?page=est_custom_fields_add' );
		$redirect = $redirect . '&est_error=edit&key=' . $_POST['original_key'];
	}
	else {
		global $wpdb;
		$redirect = admin_url( 'admin.php?page=est_custom_fields_add' );
		$redirect = $redirect . '&est_success=edit';


		$builtin = ( in_array( $_POST['original_key'], est_get_builtins() ) ) ? true : false;
		if( $builtin == true ) {
			$key = $_POST['original_key'];
		}
		else {
			if( empty( $_POST['key'] ) ) {
				$key = bsh_make_custom_key( $_POST['name'] );
			}
			else {
				$key = bsh_make_custom_key( $_POST['key'] );
			}
		}

		$new_data = array(
			'name' => $_POST['name'],
			'key'  => $key,
			'type' => $_POST['type'],
			'format' => $_POST['format'],
		);

		if( !empty( $_POST['prefix'] ) ) {
			$new_data['prefix'] = $_POST['prefix'];
		}

		if( !empty( $_POST['suffix'] ) ) {
			$new_data['suffix'] = $_POST['suffix'];
		}

		if( !empty( $_POST['options'] ) ) {
			$new_data['options'] = $_POST['options'];
		}

	    $data = get_option( 'est_customdata' );

	    if( $builtin != true ) {
		    foreach( $data as $key => $item ) {
		    	if( $item['key'] == $_POST['original_key'] ) {
		    		unset( $data[$key] );
		    	}
		    }

			$wpdb->update(
				$wpdb->postmeta,
				array(
					'meta_key' => $new_data['key'],	// string
				),
				array( 'meta_key' => $_POST['original_key'] ),
				array(
					'%s',	// value1
				),
				array( '%s' )
			);
		}

	    $data[$new_data['key']] = $new_data;

	    update_option( 'est_customdata', $data );

	}



	header( 'Location: ' . $redirect );
	die();
}





add_action( 'wp_ajax_delete_customdata', 'est_delete_customdata' );
function est_delete_customdata() {
	if( !in_array( $_GET['key'], est_get_builtins() ) ) {
		global $wpdb;
		check_admin_referer( 'est_delete_customdata' );
	    $data = get_option( 'est_customdata' );
	    foreach( $data as $key => $item ) {
	    	if( $item['key'] == $_GET['key'] ) {
	    		unset( $data[$key] );
				$wpdb->query(
					$wpdb->prepare(
						"
				         DELETE FROM $wpdb->postmeta
						 WHERE meta_key = %s
						",
					        $_GET['key']
				        )
				);

	    	}
	    }
	    update_option( 'est_customdata', $data );

		$redirect = admin_url( 'admin.php?page=est_custom_fields' );
		$redirect = $redirect . '&est_success=delete';
	}
	else {
		$redirect = admin_url( 'admin.php?page=est_custom_fields' );
		$redirect = $redirect . '&est_error=builtin';
	}
	header( 'Location: ' . $redirect );

	die();
}

add_action( 'wp_ajax_delete_customtaxonomy', 'est_delete_customtaxonomy' );
function est_delete_customtaxonomy() {
	check_admin_referer( 'est_delete_customtaxonomy' );
	$taxonomies = get_option( 'est_taxonomies' );
	unset( $taxonomies[$_GET['taxonomy']] );

	update_option( 'est_taxonomies', $taxonomies );
	$redirect = admin_url( 'admin.php?page=est_custom_taxonomies' );
	$redirect = $redirect . '&est_success=delete';

	header( 'Location: ' . $redirect );

}


add_action( 'wp_ajax_add_customtaxonomy', 'est_add_customtaxonomy' );
function est_add_customtaxonomy() {

	$taxonomies = get_option( 'est_taxonomies' );
	$taxonomies = ( empty( $taxonomies ) ) ? array() : $taxonomies;

	$hierarchical = ( $_POST['hierarchical'] == '1' ) ? true : false;

	$singular_name = ( empty( $_POST['singular_name'] ) ) ? 'Taxonomy' : $_POST['singular_name'];

	$labels = array(
	    'name'                => $_POST['name'],
	    'singular_name'       => $singular_name,
	    'search_items'        => ( empty( $_POST['search_items'] ) ) ? 'Search Taxonomy' : $_POST['search_items'],
	    'all_items'           => ( empty( $_POST['all_items'] ) ) ? 'All Terms' : $_POST['all_items'],
	    'parent_item'         => ( empty( $_POST['parent_item'] ) ) ? 'Parent Term' : $_POST['parent_item'],
	    'parent_item_colon'   => ( empty( $_POST['parent_item'] ) ) ? 'Parent Term:' : $_POST['parent_item'] . ':',
	    'edit_item'           => ( empty( $_POST['edit_item'] ) ) ? 'Edit Term' : $_POST['edit_item'],
	    'update_item'         => ( empty( $_POST['update_item'] ) ) ? 'Update Term' : $_POST['update_item'],
	    'add_new_item'        => ( empty( $_POST['add_new_item'] ) ) ? 'Add New Term' : $_POST['add_new_item'],
	    'new_item_name'       => ( empty( $_POST['new_item_name'] ) ) ? 'New Term Name' : $_POST['new_item_name'],
	    'menu_name'           => ( empty( $_POST['menu_name'] ) ) ? $_POST['name'] : $_POST['menu_name'],
	);

	$slug = ( !empty( $_POST['slug'] ) ) ? $_POST['slug'] : $_POST['name'];
	$slug = str_replace( '-', '_', sanitize_title( $slug ) );

	$new_taxonomy = array(
		'labels'       => $labels,
		'hierarchical' => $hierarchical,
		'slug'         => $slug,
	);



	$existing_taxonomies = get_taxonomies();
	if( in_array( $new_taxonomy['slug'], $existing_taxonomies ) ) {
		$redirect = admin_url( 'admin.php?page=est_custom_taxonomy_add' );
		$redirect = $redirect . '&est_error=exists';
	}
	else {
		$taxonomies[$new_taxonomy['slug']] = $new_taxonomy;
		update_option( 'est_taxonomies', $taxonomies );
		$redirect = admin_url( 'admin.php?page=est_custom_taxonomy_add' );
		$redirect = $redirect . '&est_success=true';
	}

	header( 'Location: ' . $redirect );

}


add_action( 'wp_ajax_edit_customtaxonomy', 'est_edit_customtaxonomy' );
function est_edit_customtaxonomy() {
	$taxonomies = get_option( 'est_taxonomies' );
	unset( $taxonomies[$_POST['taxonomy']] );

	$hierarchical = ( $_POST['hierarchical'] == '1' ) ? true : false;

	$labels = array(
	    'name'                => $_POST['name'],
	    'singular_name'       => ( empty( $_POST['singular_name'] ) ) ? 'Taxonomy' : $_POST['singular_name'],
	    'search_items'        => ( empty( $_POST['search_items'] ) ) ? 'Search Taxonomy' : $_POST['search_items'],
	    'all_items'           => ( empty( $_POST['all_items'] ) ) ? 'All Terms' : $_POST['all_items'],
	    'parent_item'         => ( empty( $_POST['parent_item'] ) ) ? 'Parent Term' : $_POST['parent_item'],
	    'parent_item_colon'   => ( empty( $_POST['parent_item'] ) ) ? 'Parent Term:' : $_POST['parent_item'] . ':',
	    'edit_item'           => ( empty( $_POST['edit_item'] ) ) ? 'Edit Term' : $_POST['edit_item'],
	    'update_item'         => ( empty( $_POST['update_item'] ) ) ? 'Update Term' : $_POST['update_item'],
	    'add_new_item'        => ( empty( $_POST['add_new_item'] ) ) ? 'Add New Term' : $_POST['add_new_item'],
	    'new_item_name'       => ( empty( $_POST['new_item_name'] ) ) ? 'New Term Name' : $_POST['new_item_name'],
	    'menu_name'           => ( empty( $_POST['menu_name'] ) ) ? $_POST['name'] : $_POST['menu_name'],
	);

	$slug = ( !empty( $_POST['slug'] ) ) ? $_POST['slug'] : $_POST['name'];
	$slug = str_replace( '-', '_', sanitize_title( $slug ) );

	$new_taxonomy = array(
		'labels'       => $labels,
		'hierarchical' => $hierarchical,
		'slug'         => $slug,
	);

	$existing_taxonomies = get_taxonomies();
	unset( $existing_taxonomies[$_POST['slug']] );

	if( in_array( $new_taxonomy['slug'], $existing_taxonomies ) ) {
		$redirect = admin_url( 'admin.php?page=est_custom_taxonomy_add&taxonomy=' . $_POST['taxonomy'] );
		$redirect = $redirect . '&est_error=exists';
	}
	else {
		$taxonomies[$new_taxonomy['slug']] = $new_taxonomy;
		update_option( 'est_taxonomies', $taxonomies );
		$redirect = admin_url( 'admin.php?page=est_custom_taxonomy_add&taxonomy=' . $new_taxonomy['slug'] );

		if( $new_taxonomy['slug'] != $_POST['taxonomy'] ) {
			global $wpdb;
			$wpdb->update(
				$wpdb->term_taxonomy,
				array(
					'taxonomy' => $new_taxonomy['slug'],
				),
				array( 'taxonomy' => $_POST['taxonomy'] ),
				array(
					'%s',
				),
				array( '%s' )
			);
		}

		$redirect = $redirect . '&est_success=edit';
	}

	header( 'Location: ' . $redirect );

}




add_action( 'wp_ajax_edit_defaults', 'est_edit_defaults' );
function est_edit_defaults() {

	$defaults = $_POST['est_customdata_default'];

	foreach( $defaults as $key => $data ) {
		if( empty( $data['show'] ) ) {
			unset( $defaults[$key] );
		}
	}

	update_option( 'est_customdata_default', $defaults );

	$redirect = admin_url( 'admin.php?page=est_custom_fields_defaults' );
	$redirect = $redirect . '&est_success=success';

	header( 'Location: ' . $redirect );
	die();

}


add_action( 'wp_ajax_edit_subtitles', 'est_edit_subtitles' );
function est_edit_subtitles() {

	$fields = $_POST['est_property_subtitles'];
	$used_fields = array();
	foreach( $fields as $key => $data ) {
		if( empty( $data['detail'] ) ) {
			unset( $fields[$key] );
		}
		else {
			$data['order'] = ( empty($data['order'] ) ) ? '' : $data['order'];
			$used_fields[$data['detail']] = $data['order'];
		}
	}



	update_option( 'est_property_subtitles', $used_fields );

	$redirect = admin_url( 'admin.php?page=est_custom_fields_defaults' );
	$redirect = $redirect . '&est_success=success_subtitle#subtitle';

	header( 'Location: ' . $redirect );
	die();
}








add_action( 'wp_ajax_add_profilefield', 'est_add_profilefield' );
function est_add_profilefield() {
	$error = false;
	$_POST['options'] = array_filter( $_POST['options'] );
	foreach( $_POST['options'] as $key => $option ) {
		if( is_array( $option ) ) {
			if( empty( $option['name'] ) OR $option['value'] === '' ) {
				unset( $_POST['options'][$key] );
			}
		}
	}
	$_POST = stripslashes_deep( $_POST );

	$option_types = array( 'dropdown', 'checkbox', 'radio' );

	if( empty( $_POST['name'] ) ) {
		$error = true;
	}
	if( in_array( $_POST['type'], $option_types ) AND empty( $_POST['options'] ) ) {
		$error = true;
	}

	if( $error == true ) {
		$redirect = admin_url( 'admin.php?page=est_profile_fields_add' );
		$redirect = $redirect . '&est_error=true';
	}
	else {
		$redirect = admin_url( 'admin.php?page=est_profile_fields_add' );
		$redirect = $redirect . '&est_success=true';
	}

	$new_data = array(
		'name' => $_POST['name'],
		'key'  => bsh_make_custom_key( $_POST['name'] ),
		'type' => $_POST['type'],
		'format' => $_POST['format'],
	);

	if( !empty( $_POST['prefix'] ) ) {
		$new_data['prefix'] = $_POST['prefix'];
	}

	if( !empty( $_POST['suffix'] ) ) {
		$new_data['suffix'] = $_POST['suffix'];
	}

	if( !empty( $_POST['options'] ) ) {
		$new_data['options'] = $_POST['options'];
	}



    $data = get_option( 'est_profilefields' );
    $data[$new_data['key']] = $new_data;

    update_option( 'est_profilefields', $data );


	header( 'Location: ' . $redirect );
	die();
}



add_action( 'wp_ajax_edit_profilefield', 'est_edit_profilefield' );
function est_edit_profilefield() {
	$error = false;
	$customdata = get_option( 'est_profilefields' );

	$_POST['options'] = array_filter( $_POST['options'] );
	foreach( $_POST['options'] as $key => $option ) {
		if( is_array( $option ) ) {
			if( empty( $option['name'] ) OR $option['value'] === '' ) {
				unset( $_POST['options'][$key] );
			}
		}
	}

	$option_types = array( 'dropdown', 'checkbox', 'radio' );

	if( empty( $_POST['name'] ) ) {
		$error = true;
	}
	if( in_array( $_POST['type'], $option_types ) AND empty( $_POST['options'] ) ) {
		$error = true;
	}

	foreach( $customdata as $customitem ) {
		if( $customitem['name'] == $_POST['name'] AND $customitem['key'] != bsh_make_custom_key( $_POST['name'] ) ) {
			$error = true;
		}
	}


	if( $error == true ) {
		$redirect = admin_url( 'admin.php?page=est_custom_fields_add' );
		$redirect = $redirect . '&est_error=edit&key=' . $_POST['original_key'];
	}
	else {
		global $wpdb;
		$redirect = admin_url( 'admin.php?page=est_profile_fields_add' );
		$redirect = $redirect . '&est_success=edit';

		$key = bsh_make_custom_key( $_POST['name'] );

		$new_data = array(
			'name' => $_POST['name'],
			'key'  => $key,
			'type' => $_POST['type'],
			'format' => $_POST['format'],
		);

		if( !empty( $_POST['prefix'] ) ) {
			$new_data['prefix'] = $_POST['prefix'];
		}

		if( !empty( $_POST['suffix'] ) ) {
			$new_data['suffix'] = $_POST['suffix'];
		}

		if( !empty( $_POST['options'] ) ) {
			$new_data['options'] = $_POST['options'];
		}

	    $data = get_option( 'est_profilefields' );

		    foreach( $data as $key => $item ) {
		    	if( $item['key'] == $_POST['original_key'] ) {
		    		unset( $data[$key] );
		    	}
		    }

			$wpdb->update(
				$wpdb->postmeta,
				array(
					'meta_key' => $new_data['key'],	// string
				),
				array( 'meta_key' => $_POST['original_key'] ),
				array(
					'%s',	// value1
				),
				array( '%s' )
			);


	    $data[$new_data['key']] = $new_data;

	    update_option( 'est_profilefields', $data );

	}



	header( 'Location: ' . $redirect );
	die();
}





add_action( 'wp_ajax_delete_profilefield', 'est_delete_profilefield' );
function est_delete_profilefield() {
	global $wpdb;
	check_admin_referer( 'est_delete_profilefield' );
    $data = get_option( 'est_profilefields' );
    foreach( $data as $key => $item ) {
    	if( $item['key'] == $_GET['key'] ) {
    		unset( $data[$key] );
			$wpdb->query(
				$wpdb->prepare(
					"
			         DELETE FROM $wpdb->usermeta
					 WHERE meta_key = %s
					",
				        $_GET['key']
			        )
			);

    	}
    }
    update_option( 'est_profilefields', $data );

	$redirect = admin_url( 'admin.php?page=est_profile_fields' );
	$redirect = $redirect . '&est_success=delete';
	header( 'Location: ' . $redirect );

	die();
}

