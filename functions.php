<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This is the main functions file for the
	theme. Any functionality added starts here,
	either by being coded here, or being included
	here.

*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*
	1. Theme Setup and Config
		1.1  Constants And Setup
		1.2  Image Size Definitions
		1.3  Theme Customzier Class
		1.4  Color Manipulation Class
		1.5  Shortcodes
		1.6  Available Navigation Menus
		1.7  Available Sidebars
		1.8  Widget Image Upload Class
		1.9  Widgets
		1.10 Page Template Options
		1.11 Custom Post Types
		1.12 Custom Post Type Messages

	2. Scripts and Styles
		2.1 Frontend Scripts
		2.2 Frontend Styles
		2.3 Google Maps Integration
		2.4 Tracking Code Integration

	3. Information Retrieving Functions
		3.1 Page Meta
			3.1.1 Canonical URL
			3.1.2 Page Title
			3.1.3 Page Image

	4. Backend Functions
		4.1 Custom Post Icons
		4.2 Additional Image Fields - Edit
		4.3 Additional Image Fields - Save

	5. Frontend Functions
		5.1  Comment Display
		5.2  Pagination
		5.3  Default Menu
		5.5  No Posts Fallback
		5.6  Image Formater
		5.7  Page Title Checker
		5.8  Analytics Code
		5.9  Customized Gallery Display
		5.10 Determine Layout Size
		5.11 Get Audio Tracks
		5.12 Dropdown Walker
		5.13 Default Menu
		5.14 Default Dropwdown

	6. Theme Option Functions
		6.1 Custom Sidebar Generation
		6.2 Get Setting Value
		6.3 Has Sidebar
		6.4 Get Assigned Sidebar
		6.5 Get Page Layout
		6.6 Color Translator
		6.7 Content Area Classes
		6.8 Sidebar Area Classes

	7. Documentation Functions
		7.1 Online Help Documentation
		7.2 Shortcode Documentation

	8. Integrations
		8.1 Twitter Integration
		8.2 Facebook Integration
		8.3 Twitter API

*/

/***********************************************/
/*         1. Theme Setup and Config           */
/***********************************************/

// 1.1 Constants And Setup
define( 'THEMEVERSION', '2.5' );
define( 'COMPANYPREFIX', 'bsh' );
define( 'THEMENAME', 'estatement' );
define( 'THEMEPREFIX', 'est' );
define( 'BSH_GOOGLE_API_KEY', 'AIzaSyCD2NXkx_PIHullgn7_FaEqsr7CmuIbfBM' );
define( 'BSH_FACEBOOK_API_KEY', '151174081701425' );
define( 'BSH_TWITTER_CONSUMER_KEY', 'QWdKTKeTKXf9cdxraARVEA' );
define( 'BSH_TWITTER_CONSUMER_SECRET', 'Ah8Zpg1ymWem2Dj3c1OS1Rcq6Xh0jpHYmjQPLUlCrPM' );
define( 'BSH_TWITTER_ACCESS_TOKEN', '772364892-habgBBoijKTIfInkydJvcfSpxgJc116VWrlKGmRE' );
define( 'BSH_TWITTER_ACCESS_SECRET', '5syRRX89lahrOi6epHgwtDBT3WMiMzU0Da1uoOCI1M' );
if ( ! isset( $content_width ) ) $content_width = 595;
add_theme_support( 'automatic-feed-links' );
add_filter( 'gallery_style', '__return_false', 99 );


if( !empty( $_GET ) ) {
	foreach( $_GET as $key => $value ) {
		if( substr_count( $key, '_est_meta_' ) ) {
			unset( $_GET[$key] );
			$new_key = urlencode( $key );
			$new_key = str_replace('%25', '%', $new_key );
			$new_key = strtolower( $new_key );
			$_GET[$new_key] = $value;
		}
	}
}



add_filter('jpeg_quality', 'bsh_jpeg_quality');
function bsh_jpeg_quality() {
	return 100;
}


add_action( 'after_switch_theme', 'est_activate_theme', 10 ,  2);
function est_activate_theme() {
	$current_version = get_option( 'est_version' );

	if( empty( $current_version ) OR version_compare( $current_version, '2.5' ) == -1 ) {
		est_update_24_25();
	}

	$contact_success_message = get_theme_mod('contact_success_message');
	if( empty( $contact_success_message ) ) {
		set_theme_mod( 'contact_success_message', 'Thank you for your message' );
	}

	$taxonomies = get_option( 'est_taxonomies' );
	if( $taxonomies === false ) {

		$taxonomies['property_type'] = array(
			'labels' => array(
				'name'                => __( 'Property Types', THEMENAME ),
				'singular_name'       => __( 'Property Type', THEMENAME ),
				'search_items'        => __( 'Search Property Type', THEMENAME ),
				'all_items'           => __( 'All Property Types', THEMENAME ),
				'parent_item'         => __( 'Parent Property Type', THEMENAME ),
				'parent_item_colon'   => __( 'Parent Property Type:', THEMENAME ),
				'edit_item'           => __( 'Edit Property Type', THEMENAME ),
				'update_item'         => __( 'Update Property Type', THEMENAME ),
				'add_new_item'        => __( 'Add New Property Type', THEMENAME ),
				'new_item_name'       => __( 'New Property Type Name', THEMENAME ),
				'menu_name'           => __( 'Property Types', THEMENAME )
			),
			'hierarchical' => 1,
			'slug' => 'property_type'
		);


		$taxonomies['property_category'] = array(
			'labels' => array(
				'name'                => _x( 'Property Categories', THEMENAME ),
				'singular_name'       => _x( 'Property Category', THEMENAME ),
				'search_items'        => __( 'Search Property Category', THEMENAME ),
				'all_items'           => __( 'All Property Categories', THEMENAME ),
				'parent_item'         => __( 'Parent Property Category', THEMENAME ),
				'parent_item_colon'   => __( 'Parent Property Category:', THEMENAME ),
				'edit_item'           => __( 'Edit Property Category', THEMENAME ),
				'update_item'         => __( 'Update Property Category'. THEMENAME ),
				'add_new_item'        => __( 'Add New Property Category', THEMENAME ),
				'new_item_name'       => __( 'New Property Category Name', THEMENAME ),
				'menu_name'           => __( 'Property Category', THEMENAME )
			),
			'hierarchical' => 1,
			'slug' => 'property_category'
		);

		update_option( 'est_taxonomies', $taxonomies );

	}


	est_update_theme_version();

}


function est_update_theme_version() {
	if( empty( $current_version ) ) {
		add_option( 'est_version', THEMEVERSION );
	}
	else {
		update_option( 'est_version', THEMEVERSION );
	}
}

function est_update_24_25() {
	global $wpdb;
	$pages = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_page_template' AND meta_value IN ( 'template-bshSearchPage.php', 'template-bshMapPage.php' ) " );
	foreach( $pages as $page_id ) {
		$selection = get_post_meta( $page_id, '_est_details', true );

		$custom_taxonomies = array();
		$customdatas = array();
		if( !empty( $selection ) ) {
			foreach( $selection as $name => $data ) {
				$data['type'] = ( $data['type'] == 'range' ) ? 'slider' : $data['type'];

				if( substr_count( $name, 'taxonomy_' ) ) {
					$taxonomy = str_replace( 'taxonomy_', '', $name );

					if( $data['show'] == 'yes' ) {
						$custom_taxonomies[$taxonomy] = array(
							'show' => 'yes',
							'field' => $data['type'],
							'order' => $data['order'],
							'type' => 'taxonomy'
						);
					}
				}
				elseif( substr_count( $name, '_est_meta_' ) ) {

					if( $data['show'] == 'yes' ) {
						$customdatas[$name] = array(
							'show' => 'yes',
							'field' => $data['type'],
							'order' => $data['order'],
							'type' => 'customdata'
						);
					}
				}
			}
		}

		if( !empty( $custom_taxonomies ) ) {
			update_post_meta( $page_id, '_est_taxonomies', $custom_taxonomies );
		}


		if( !empty( $customdatas ) ) {
			update_post_meta( $page_id, '_est_customdatas', $customdatas );
		}


	}

	$pages = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_page_template' AND meta_value IN ( 'template-bshMapPage.php' ) " );
	foreach( $pages as $page_id ) {
		update_option( $page_id, '_est_show_proximity', 'yes' );
		update_option( $page_id, '_est_default_proximity', '100' );
		update_option( $page_id, '_est_proximity_unit', 'mi' );
		update_option( $page_id, '_est_proximity_options', '25,50,100,200,500' );
		update_option( $page_id, '_est_proximity_label', 'Distance' );
	}

	$option = get_option( 'est_property_subtitles' );
	if( empty( $option ) ) {
		$defaults = array(
			'_est_meta_state' => 2,
			'_est_meta_city' => 1
		);
		update_option( 'est_property_subtitles', $defaults );
	}


}

// 1.2 Image Size Definitions
add_theme_support('post-thumbnails');
add_image_size( 'est_card', 284, 188, true );
add_image_size( 'est_card_wide', 671, 188, true );
add_image_size( 'est_large', 595, 365, true );
add_image_size( 'est_large_nocrop', 595, 365 );
add_image_size( 'est_large_nosb', 904, 365, true );
add_image_size( 'est_small', 130, 80, true );
add_image_size( 'est_flyer', 485, 280, true );
add_image_size( 'est_flyer_small', 335, 280, true );


add_action( 'init', 'est_set_default_data' );
function est_set_default_data() {
    $default_data = array(
		'_est_meta_country' => array(
			'name'     => 'Country',
			'key'      => '_est_meta_country',
			'type'     => 'countries',
			'format'   => 'text'
		),
		'_est_meta_state' => array(
			'name'     => 'State',
			'key'      => '_est_meta_state',
			'type'     => 'states',
			'format'   => 'text'
		),
		'_est_meta_city' => array(
			'name'     => 'City',
			'key'      => '_est_meta_city',
			'type'     => 'text',
			'format'   => 'text'
		),
		'_est_meta_address' => array(
			'name'     => 'Street Address',
			'key'      => '_est_meta_address',
			'type'     => 'text',
			'format'   => 'text'
		),
		'_est_meta_zip_code' => array(
			'name'     => 'Zip Code',
			'key'      => '_est_meta_zip_code',
			'type'     => 'text',
			'format'   => 'text'
		),
		'_est_meta_latitude' => array(
			'name'     => 'Latitude',
			'key'      => '_est_meta_latitude',
			'type'     => 'text',
			'format'   => 'text'
		),
		'_est_meta_longitude' => array(
			'name'     => 'Longitude',
			'key'      => '_est_meta_longitude',
			'type'     => 'text',
			'format'   => 'text'
		),
		'_est_meta_price' => array(
			'name'     => 'Price',
			'key'      => '_est_meta_price',
			'type'     => 'text',
			'prefix'   => '$',
			'format'   => 'number'
		),
		'_est_meta_building_area' => array(
			'name'     => 'Building Area',
			'key'      => '_est_meta_building_area',
			'type'     => 'text',
			'suffix'   => ' sqft',
			'format'   => 'number'
		),
		'_est_meta_property_area' => array(
			'name'     => 'Property Area',
			'key'      => '_est_meta_property_area',
			'type'     => 'text',
			'suffix'   => ' acres',
			'format'   => 'number'
		),
		'_est_meta_year_built' => array(
			'name'     => 'Year Built',
			'key'      => '_est_meta_year_built',
			'type'     => 'text',
			'format'   => 'text'
		),
		'_est_meta_rooms' => array(
			'name'     => 'Rooms',
			'key'      => '_est_meta_rooms',
			'type'     => 'text',
			'format'   => 'number'
		)
	);
    $customdata = get_option( 'est_customdata' );
    if( empty( $customdata ) ) {
    	update_option( 'est_customdata', $default_data );
    	update_option( 'est_customdata_default', array( 'building_area', 'property_area', 'property_rooms', 'price' ) );
    }
}

function est_get_builtins() {
	$builtin = array( '_est_meta_country', '_est_meta_state', '_est_meta_city', '_est_meta_address', '_est_meta_zipcode', '_est_meta_latitude', '_est_meta_longitude' );
	return $builtin;
}


// 1.3 Theme Customizer Class
include( 'framework/customizer/Customizer.class.php' );
add_action ('admin_menu', COMPANYPREFIX . '_theme_customizer');
function bsh_theme_customizer() {
	add_theme_page(
		__( 'Customize Estatement Design and Theme Options', THEMENAME ),
		__( 'Customize Theme', THEMENAME ),
		'edit_theme_options',
		'customize.php'
	);
}

// 5.4 Shortcode Cleanup
add_filter('the_content', COMPANYPREFIX . '_clean_shortcodes' );
add_filter('widget_text', COMPANYPREFIX . '_clean_shortcodes' );
function bsh_clean_shortcodes($content){
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']',
        '><br />' => '>',
    );
    $content = strtr($content, $array);
    return $content;
}


require_once 'framework/classes/BonsaiBooking/BonsaiBooking.class.php';
require_once 'framework/classes/BonsaiError/BonsaiError.class.php';


// 1.4 Color Manipulation Class
include( 'framework/external/Color/Color.class.php' );


// 1.4 Date Manipulation Class
include( 'framework/external/Carbon/Carbon.class.php' );


// 1.5 Shortcodes
include( 'framework/shortcodes.php' );
add_filter('widget_text', 'do_shortcode');


// 1.6 Available Navigation Menus
register_nav_menus( array(
	'header_menu' => __( 'Header menu', THEMENAME ),
	'loggedin_header_menu' => __( 'Logged In Header menu', THEMENAME ),
	'footer_menu' => __( 'Footer Menu', THEMENAME )
));

// 1.7 Available Sidebars
register_sidebar( array(
	'name'          => __( 'Sidebar', THEMENAME ),
	'id'		=> 'sidebar-1',
	'description'   => __( 'The default Estatement sidebar', THEMENAME ),
	'before_widget' => '<div class="widget-container"><div id="%1$s" class="widget %2$s">',
	'after_widget'  => '<div class="end"></div></div></div>',
	'before_title'  => '<h1 class="widget-title">',
	'after_title'   => '</h1>'
));

register_sidebar( array(
	'name'          => __( 'Default Blog Sidebar', THEMENAME ),
	'id'		=> 'sidebar-2',
	'description'   => __( 'The default Blog sidebar', THEMENAME ),
	'before_widget' => '<div class="widget-container"><div id="%1$s" class="widget %2$s">',
	'after_widget'  => '<div class="end"></div></div></div>',
	'before_title'  => '<h1 class="widget-title">',
	'after_title'   => '</h1>'
));



register_sidebar( array(
	'name'          => __( 'Property Page Sidebar', THEMENAME ),
	'id'		=> 'sidebar-3',
	'description'   => __( 'The default sidebar for property pages', THEMENAME ),
	'before_widget' => '<div class="widget-container"><div id="%1$s" class="widget %2$s">',
	'after_widget'  => '<div class="end"></div></div></div>',
	'before_title'  => '<h1 class="widget-title">',
	'after_title'   => '</h1>'
));


register_sidebar( array(
	'name'          => __( 'Footerbar', THEMENAME ),
	'id'            => 'footerbar',
	'description'   => __( 'The default footer bar for Estatement', THEMENAME ),
	'before_widget' => '<div class="widget-container"><div id="%1$s" class="widget %2$s">',
	'after_widget'  => '<div class="end"></div></div>',
	'before_title'  => '<h1 class="widget-title">',
	'after_title'   => '</h1>'
));

register_sidebar( array(
	'name'          => __( 'Agent Page Sidebar', THEMENAME ),
	'id'		=> 'sidebar-5',
	'description'   => __( 'The default Sidebar For Agent Pages', THEMENAME ),
	'before_widget' => '<div class="widget-container"><div id="%1$s" class="widget %2$s">',
	'after_widget'  => '<div class="end"></div></div></div>',
	'before_title'  => '<h1 class="widget-title">',
	'after_title'   => '</h1>'
));
$theme_sidebar_counter = 5;



// 1.8 Widget Image Upload Class
include( 'framework/external/imageUpload/imageUpload.class.php' );


// 1.9 Widgets
include( 'framework/widgets/ContactWidget.class.php' );
include( 'framework/widgets/TwitterWidget.class.php' );
include( 'framework/widgets/FeaturedItemWidget.class.php' );
include( 'framework/widgets/LatestPostsWidget.class.php' );
include( 'framework/widgets/PropertyDetailsWidget.class.php' );
include( 'framework/widgets/PropertyContactWidget.class.php' );
include( 'framework/widgets/AgentContactWidget.class.php' );
include( 'framework/widgets/PropertySearchWidget.class.php' );
include( 'framework/widgets/MapWidget.class.php' );
include( 'framework/widgets/BookingWidget.class.php' );
include( 'framework/widgets/PricingWidget.class.php' );

// 1.10 Page Template Options
include( 'framework/template-options/bshOptions.class.php' );
include( 'framework/template-options/bshPostOptions.class.php' );
include( 'framework/template-options/bshBookingOptions.class.php' );
include( 'framework/template-options/bshCustomListingPageOptions.class.php' );
include( 'framework/template-options/bshListingPageOptions.class.php' );
include( 'framework/template-options/bshPropertyOptions.class.php' );
include( 'framework/template-options/bshDefaultOptions.class.php' );
include( 'framework/template-options/bshSearchPageOptions.class.php' );
include( 'framework/template-options/bshBookingPageOptions.class.php' );
include( 'framework/template-options/bshLoginPageOptions.class.php' );
include( 'framework/template-options/bshRegisterPageOptions.class.php' );
include( 'framework/template-options/bshMapPageOptions.class.php' );
include( 'framework/template-options/bshAgentListPageOptions.class.php' );
include( 'framework/template-options/bshSliderPageOptions.class.php' );
include( 'framework/template-options/bshPropertyFilterPageOptions.class.php' );
include( 'framework/template-options/bshSubmitPorpertyPageOptions.class.php' );
$bshPostOptions = new bshOptions();

// 1.11 Custom Post Types

add_action( 'init', COMPANYPREFIX . '_post_types' );
function bsh_post_types() {

	$labels = array(
		'name'                => __( 'Properties', THEMENAME ),
		'singular_name'       => __( 'Property', THEMENAME ),
		'add_new'             => __( 'Add New', THEMENAME ),
		'add_new_item'        => __( 'Add New Property', THEMENAME ),
		'edit_item'           => __( 'Edit Property', THEMENAME ),
		'new_item'            => __( 'New Property', THEMENAME ),
		'all_items'           => __( 'All Properties', THEMENAME ),
		'view_item'           => __( 'View Property', THEMENAME ),
		'search_items'        => __( 'Search Properties', THEMENAME ),
		'not_found'           => __( 'No properties found', THEMENAME ),
		'not_found_in_trash'  => __( 'No properties found in Trash', THEMENAME ),
		'menu_name'           => __( 'Properties', THEMENAME ),
	);

	$supports = array( 'title', 'editor', 'thumbnail', 'excerpt', 'author' );
	if( get_theme_mod( 'property_commenting' ) == 'yes' ) {
		$supports[] = 'comments';
	}

	$slug = get_theme_mod( 'property_permalink' );
	$slug = ( empty( $slug ) ) ? 'property' : $slug;

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => $slug ),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => null,
		'supports'            => $supports,
		'taxonomies'          => array( 'property_type' )
	);

	register_post_type( 'property', $args );




	$labels = array(
		'name'                => __( 'Bookings', THEMENAME ),
		'singular_name'       => __( 'Booking', THEMENAME ),
		'add_new'             => __( 'Add New', THEMENAME ),
		'add_new_item'        => __( 'Add New Booking', THEMENAME ),
		'edit_item'           => __( 'Edit Booking', THEMENAME ),
		'new_item'            => __( 'New Booking', THEMENAME ),
		'all_items'           => __( 'All Bookings', THEMENAME ),
		'view_item'           => __( 'View Booking', THEMENAME ),
		'search_items'        => __( 'Search Bookings', THEMENAME ),
		'not_found'           => __( 'No bookings found', THEMENAME ),
		'not_found_in_trash'  => __( 'No bookings found in Trash', THEMENAME ),
		'menu_name'           => __( 'Bookings', THEMENAME ),
	);

	$supports = array( 'title', 'editor' );

	$slug = get_theme_mod( 'booking_permalink' );
	$slug = ( empty( $slug ) ) ? 'booking' : $slug;

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => $slug ),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => null,
		'supports'            => $supports,
	);

	register_post_type( 'booking', $args );




}



add_filter('manage_property_posts_columns', 'est_property_columns');
function est_property_columns( $defaults ) {
	$final = array();
	$n=0;
	$keys = array_keys( $defaults );
	$values = array_values( $defaults );

	$final[$keys[$n]] = $values[$n];
	$n++;
	$final['ID'] = 'ID';

	for( $i = $n; $n < count( $keys ); $n++ ) {
		$final[$keys[$n]] = $values[$n];
	}

    return $final;
}

add_action( 'manage_property_posts_custom_column', 'est_property_column_content', 10, 2 );

function est_property_column_content( $column_name, $post_id ) {
    if ($column_name == 'ID') {
    	echo $post_id;
    }

}


$taxonomies = get_option( 'est_taxonomies' );
foreach( $taxonomies as $taxonomy => $data ) {
	add_filter('manage_edit-'.$taxonomy.'_columns', 'est_taxonomy_columns');
	add_action('manage_'.$taxonomy.'_custom_column', 'est_taxonomy_column_content', 10, 3);

}


function est_taxonomy_columns( $defaults ) {
	$final = array();
	$n=0;
	$keys = array_keys( $defaults );
	$values = array_values( $defaults );

	$final[$keys[$n]] = $values[$n];
	$n++;
	$final['ID'] = 'ID';

	for( $i = $n; $n < count( $keys ); $n++ ) {
		$final[$keys[$n]] = $values[$n];
	}

    return $final;
}


function est_taxonomy_column_content( $dep, $column_name, $term_id ) {
    if ($column_name == 'ID') {
    	echo $term_id;
    }

}



// 1.12 Custom Post Type Messages
add_filter( 'post_updated_messages', COMPANYPREFIX . '_post_type_messages' );
function bsh_post_type_messages( $messages ) {
	global $post, $post_ID;

	$messages['property'] = array(
		0  => '',
		1  => sprintf( __('Property updated. <a href="%s">View property</a>', THEMENAME),
			  esc_url( get_permalink($post_ID) ) ),
		2  => __('Custom field updated.', THEMENAME),
		3  => __('Custom field deleted.', THEMENAME),
		4  => __('Property updated.', THEMENAME),
		5  => isset($_GET['revision']) ? sprintf( __('Property restored to revision from %s',
			  THEMENAME), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __('Property published. <a href="%s">View property</a>', THEMENAME),
			  esc_url( get_permalink($post_ID) ) ),
		7  => __('Property saved.', THEMENAME),
		8  => sprintf( __('Property submitted. <a target="_blank" href="%s">Preview property</a>',
			  THEMENAME), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9  => sprintf( __('Property scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview property</a>', THEMENAME),
			date_i18n( __( 'M j, Y @ G:i', THEMENAME ), strtotime( $post->post_date ) ),
			esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Property draft updated. <a target="_blank" href="%s">Preview property</a>',
			  THEMENAME), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);



	return $messages;
}




add_action( 'init', 'trc_taxonomies' );
function trc_taxonomies() {

	$taxonomies = get_option( 'est_taxonomies' );
	if( !empty( $taxonomies ) ) {
		foreach( $taxonomies as $taxonomy ) {
			$taxonomy['hierarchical'] = ( $taxonomy['hierarchical'] == 1 ) ? true : false;
			$args = array(
				'hierarchical'        => $taxonomy['hierarchical'],
				'labels'              => $taxonomy['labels'],
			    'show_ui'             => true,
			    'show_admin_column'   => true,
			    'query_var'           => true,
			    'rewrite'             => array( 'slug' => $taxonomy['slug'] )
			);
			register_taxonomy( $taxonomy['slug'] , array( 'property' ), $args );
		}
	}


}


/***********************************************/
/*            2. Scripts and Styles            */
/***********************************************/

// 2.1 Frontend Scripts
add_action('wp_enqueue_scripts',  COMPANYPREFIX . '_frontend_scripts');
function bsh_frontend_scripts() {
	global $post;

	$decimal_separator = get_theme_mod( 'decimal_separator' );
	$decimal_separator = ( empty( $decimal_separator ) ) ? '.' : $decimal_separator;

	$thousand_separator = get_theme_mod( 'thousand_separator' );
	$thousand_separator = ( empty( $thousand_separator ) ) ? ',' : $thousand_separator;


	wp_register_script(
		'scripts',
		get_template_directory_uri() . '/javascripts/scripts.min.js',
		array( 'jquery' ),
		time(),
		false
	);

	wp_enqueue_script(
		'app',
		get_template_directory_uri() . '/javascripts/app.min.js',
		array( 'jquery', 'scripts' ),
		time(),
		true
	);

	wp_localize_script( 'scripts', 'estAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'thousand_separator' => $thousand_separator,
		'decimal_separator' => $decimal_separator
	));

	wp_enqueue_script(
		'booking-calendar',
		get_template_directory_uri() . '/javascripts/booking-calendar.min.js',
		array( 'jquery', 'scripts', 'app' ),
		time(),
		true
	);


	if( is_page() AND substr_count( get_post_meta( $post->ID, '_wp_page_template', true ), 'template-bshSearchPage.php' ) > 0 ) {
		wp_enqueue_script(
			'search-page',
			get_template_directory_uri() . '/javascripts/search-page.min.js',
			array( 'jquery', 'scripts' ),
			time(),
			true
		);
	}

	if( is_page() AND substr_count( get_post_meta( $post->ID, '_wp_page_template', true ), 'template-bshMapPage.php' ) > 0 ) {
		wp_enqueue_script(
			'map-page',
			get_template_directory_uri() . '/javascripts/map-page.min.js',
			array( 'jquery', 'scripts' ),
			time(),
			true
		);
	}


	if( is_page() AND substr_count( get_post_meta( $post->ID, '_wp_page_template', true ), 'template-bshPropertyFilterPage.php' ) > 0 ) {
		wp_enqueue_script(
			'filter-page',
			get_template_directory_uri() . '/javascripts/source/filter-page.js',
			array( 'jquery', 'scripts' ),
			time(),
			true
		);
	}


	if ( is_singular() ) {
		wp_enqueue_script( "comment-reply" );
	}
}

// 2.2 Frontend Styles
add_action('wp_enqueue_scripts', COMPANYPREFIX . '_frontend_styles');
function bsh_frontend_styles() {
	if( !is_admin() ) {
		wp_register_style(
			'estatement',
			get_bloginfo( 'stylesheet_url' ),
			array(),
			THEMEVERSION
		);
		wp_enqueue_style( 'estatement' );
	}
}

// 2.3 Google Maps Integration
add_action( 'wp_head', COMPANYPREFIX . '_google_maps_api' );
function bsh_google_maps_api() {
	$api_key = get_theme_mod('google_maps_api_key');
	$api_key = ( empty( $api_key ) ) ? BSH_GOOGLE_API_KEY : $api_key;
	echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&amp;sensor=false"></script>';
}

// 2.4 Tracking Code Integration
add_action( 'wp_footer', COMPANYPREFIX . '_tracking_code' );
function bsh_tracking_code() {
	$tracking_code = get_theme_mod('analytics');
	if( !empty( $tracking_code ) ) {
		echo $tracking_code;
	}
}



/***********************************************/
/*     3. Information Retrieving Functions     */
/***********************************************/

/*********************************/
/*         3.1 Page Meta         */
/*********************************/

// 3.1.1 Canonical URL
/*
Used to get a standard link for any page. Used in
meta tags in the header
*/
function bsh_canonical_url() {

	if( is_home() OR is_front_page() ) {
		$url = 	home_url();
	}
	elseif( is_singular() ) {
		global $post;
		$url = get_permalink( $post->ID );
	}
	else {
		global $wp;
		$url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
	}

	return $url;

}

// 3.1.2 Page Title
/*
Used to get a standard title for any page. Used in
meta tags in the header
*/
function bsh_page_title() {
	global $page, $paged;

	ob_start();

	bloginfo();
	wp_title( '' );

	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	if ( $paged >= 2 || $page >= 2 )
		echo ' | Page ' . max( $paged, $page );

	$title = ob_get_clean();
	$title = trim( $title );
	return $title;

}

// 3.1.3 Page Image
/*
Used to get an attached image for any page.
Used in meta tags in the header
*/
function bsh_page_image() {
	global $post;

	$image = '';
	$image_id = '';
	if( is_singular() ) {
		$image_id = get_post_thumbnail_id( $post->ID );
	}

	if( !empty( $image_id ) ) {
		$image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
		$image = $image[0];
	}

	return $image;

}


function get_property_detail_list( $options, $post_id = 0 ) {
	if( $post_id == 0 ) {
		global $post;
		$post_id = $post->ID;
	}

	$location_fields = array( '_est_meta_country', '_est_meta_city', '_est_meta_state', '_est_meta_address', '_est_meta_zip_code' );
	$single_address = ( !empty( $options['single_address'] ) AND $options['single_address'] == 'yes' ) ? true : false;

	if( empty( $options ) ) {
		$options = array();
		$options['customdatas'] = get_option( 'est_customdata_default' );
	}

	$options['location'] = array();

	$i = 9999;
	if( !empty( $options['customdatas'] ) ) {
	foreach( $options['customdatas'] as $key => $data ) {
		if( empty( $data['order'] ) ) {
			$options['customdatas'][$key]['order'] = $i;
			$data['order'] = $i;
		}

		if( empty( $data['show'] ) OR $data['show'] != 'yes' ) {
			unset( $options['customdatas'][$key] );
		}

		if( $single_address == true AND in_array( $key, $location_fields ) ) {
			unset( $options['customdatas'][$key] );
			if( !empty( $data['show'] ) AND $data['show'] == 'yes' ) {
				$options['location'][$key] = $data;
			}
		}
		$i++;
	}
	}
	if( !empty( $options['custom_taxonomies'] ) ) {
		foreach( $options['custom_taxonomies'] as $key => $data ) {
			if( empty( $data['show'] ) OR $data['show'] != 'yes' ) {
				unset( $options['custom_taxonomies'][$key] );
			}
			$i++;
		}
	}

	$shown_fields = array();


	$customdata = get_option( 'est_customdata' );

	if( !empty( $options['customdatas'] ) ) {
	foreach( $options['customdatas'] as $key => $data ) {
		$raw_value = get_post_meta( $post_id, $key );
		$value = est_customdata_value( $key, $raw_value );

		if( !empty( $customdata[$key] ) ) {
			$name = $customdata[$key]['name'];
		
			if( function_exists( 'icl_t' ) ) {
				$name = icl_t( 'Estatement - Custom Field Names', $customdata[$key]['name'], $customdata[$key]['name'] );
			}
		
		
			if( !empty( $value ) ) {
				$shown_fields[] = array(
					'name'  => $name,
					'key'   => $key,
					'value' => $value,
					'raw_value' => $raw_value,
					'order' => $data['order']
				);
			}
		}
	}
	}



	if( !empty( $options['custom_taxonomies'] ) ) {
		foreach( $options['custom_taxonomies'] as $key => $data ) {
			$terms = wp_get_object_terms( $post_id, $key );
			if( !empty( $terms ) ) {
				$taxonomy = get_taxonomy( $key );

				$value = array();
				$raw_value = array();
				foreach( $terms as $term ) {
					$value[] = $term->name;
					$raw_value[] = $term->term_id;
				}
				$value = implode( ', ', $value );

				$name = $taxonomy->labels->name;

				if( function_exists( 'icl_t' ) ) {
					$name = icl_t( 'Estatement - Custom Taxonomies', $taxonomy->labels->name, $taxonomy->labels->name );
				}


				$shown_fields[] = array(
					'name'  => $name,
					'value' => $value,
					'raw_value' => $raw_value,
					'key' => $key,
					'order' => $data['order']
				);
			}
		}
	}

	if( $single_address == true AND !empty( $options['location'] ) ) {
		$name = ( empty( $options['_est_single_field_address_name'] ) ) ? __( 'Location: ', THEMENAME ) : $options['_est_single_field_address_name'];
		$order = empty( $options['single_address_order'] ) ? $i : $options['single_address_order'];

		uasort( $options['location'], 'est_sort_custom_data' );

		$value = array();
		foreach( $options['location'] as $key => $data ){
			$value[] = est_customdata_value( $key, get_post_meta( $post_id, $key, true ) );
		}
		$value = implode( ', ', $value );

		$shown_fields[] = array(
			'name' => $name,
			'value' => $value,
			'order' => $order
		);
	}

	foreach( $shown_fields as $key => $fields) {
		if( empty( $fields['raw_value'] ) ) {
			unset( $shown_fields[$key] );
		}
	}

	usort( $shown_fields, 'est_sort_custom_data' );

	return $shown_fields;

}

function est_sort_custom_data( $a, $b ) {
	return $a['order'] - $b['order'];
}


function get_filter_range_atts( $search, $data ) {
	$atts = array();
	foreach( $search['customdatas'] as $name => $field ) {
		if( $field['field'] == 'slider' ) {
			foreach( $data as $item ) {
				if( $item['key'] == $name ) {
					$value = $item['raw_value'][0];
				}
			}
			$atts[] = 'data-' . $name . '="' . $value . '"';
		}
	}
	return implode( ' ', $atts );
}

function get_filter_classes( $data ) {
	$classes = array();
	if( !empty( $data ) ) {
		foreach( $data as $item ) {
			if( is_array( $item['raw_value'] ) ) {
				foreach( $item['raw_value'] as $value ) {
					$value = str_replace( ' ', '-', $value );
					$classes[] = 'filter_' . $item['key'] . '-' . $value;
				}
			}
			else {
				$item['raw_value'] = str_replace( ' ', '-', $item['raw_value'] );
				$classes[] = 'filter_' . $item['key'] . '-' . $item['raw_value'];
			}
		}
	}
	return implode( ' ', $classes );
}

function get_property_subtitle_details( $subtitle_options ) {
	$options = array( 'customdatas' => array(), 'custom_taxonomies' => array() );
	if( !empty( $subtitle_options['subtitle'] ) ) {
		$details = explode( '|', $subtitle_options['subtitle'] );
		$i=1;
		foreach( $details as $detail ) {
			if( substr_count( $detail, 'taxonomy-' ) > 0 ) {
				$taxonomy = trim( str_replace( 'taxonomy-', '', $detail ) );
				$options['custom_taxonomies'][$taxonomy] = array(
					'show' => 'yes',
					'order' => $i
				);
			}
			else {
				$name = trim( '_est_meta_' . $detail );
				$options['customdatas'][$name] = array(
					'show' => 'yes',
					'order' => $i
				);
			}
			if( $detail == 'single_address' ) {
				$options['single_address_order'] = $i;
			}
			$i++;
		}
	}
	else {
		$defaults = get_option( 'est_property_subtitles' );
		foreach( $defaults as $name => $order ) {
			$options['customdatas'][$name] = array(
				'show' => 'yes',
				'order' => $order
			);
		}
	}

	$details = get_property_detail_list( $options );

	return $details;

}

function get_property_dropdown_options() {
	global $wpdb;
	$properties = $wpdb->get_results( "SELECT ID, post_title FROM $wpdb->posts WHERE post_type='property' AND post_status = 'publish' " );

	$options = array();
	if( !empty( $properties ) ) {
		foreach( $properties as $property ) {
			$options[$property->ID] = $property->post_title;
		}
	}
	return $options;
}


function est_property_subtitle( $subtitle_options ) {
	$details = get_property_subtitle_details( $subtitle_options );

	$display = array();
	foreach( $details as $detail ) {
		$display[] = $detail['value'];
	}
	return implode( ', ', $display );
}

function show_property_detail_table( $shown_fields, $classes = 'mb22' ) {
	?>
	<table class="detail-table <?php echo $classes ?>">
		<tbody>
	<?php
		foreach( $shown_fields as $field ) :
		$field['value'] = trim( $field['value'] );
		if( $field['value'] != '' ) :
                    $multi_value = explode(',', $field['value']);
                    if ( count( $multi_value ) > 1) {
                        $display_value = implode("<br/>", $multi_value);
                    } else {
                        $display_value = $field['value'];
                    }
		?>
			<tr>
				<?php if( is_rtl() ) : ?>
					<td class="value"><?php echo $display_value ?></td>
					<td class="name"><?php echo $field['name'] ?></td>
				<?php else : ?>
					<td class="name"><?php echo $field['name'] ?></td>
					<td class="value"><?php echo $display_value ?></td>
				<?php endif ?>
			</tr>
		<?php endif ?>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php
}

/***********************************************/
/*            4. Backend Functions             */
/***********************************************/

// 4.1 Custom Post Icons
add_action( 'admin_head', COMPANYPREFIX . '_icons' );
function bsh_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-property .wp-menu-image {
            background: url(<?php echo get_template_directory_uri() ?>/images/icons/post-types/property.png) no-repeat 6px -17px !important;
            background-size: 16px 40px;
        }
        #menu-posts-property:hover .wp-menu-image, #menu-posts-property.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px!important;
        }
        #menu-posts-booking .wp-menu-image {
            background: url(<?php echo get_template_directory_uri() ?>/images/icons/post-types/booking.png) no-repeat 6px -17px !important;
            background-size: 16px 40px;
        }
        #menu-posts-booking:hover .wp-menu-image, #menu-posts-booking.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px!important;
        }
		#toplevel_page_est_custom_fields .wp-menu-image {
		    background: url( <?php echo get_template_directory_uri() ?>/images/icons/post-types/customdata.png ) no-repeat 6px -17px !important;
		    background-size: 16px 40px;
		}
		#toplevel_page_est_custom_fields:hover .wp-menu-image, #toplevel_page_est_custom_fields.wp-has-current-submenu .wp-menu-image, #toplevel_page_est_custom_fields.current .wp-menu-image {
		    background-position:6px 7px!important;
		}

    </style>
<?php
}


/***********************************************/
/*            5. Frontend Functions            */
/***********************************************/

// 5.1 Comment Display
function bsh_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
		<li <?php comment_class( 'comment pingback' ); ?> id="comment-<?php comment_ID(); ?>">
			<article class='primary-links'>

				<span class='pingback-title'>
					<?php _e( 'Pingback', THEMENAME ) ?>
				</span>
				<span class='pingback-content'>
				<?php comment_author_link(); ?>
				</span>

				<?php edit_comment_link( 'Edit', ' - <span class="edit-link">', '</span>' ); ?>
			</article>
	<?php
		break;
		default :
	?>
		<li <?php comment_class( 'comment' ); ?> id="comment-<?php comment_ID(); ?>">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<div class="alert-box comment-awaiting-moderation">
					<?php _e( 'Your comment is awaiting moderation.', THEMENAME ); ?>
					<a href="" class="close">&times;</a>
					</div>
				<?php endif; ?>

			<article>
				<?php echo get_avatar( $comment, 50 ) ?>
				<header class='comment-meta comment-author'>
					<cite class='fn heading-font'><?php comment_author_link() ?></cite>
					<span class='comment-time body-text-lighter'><?php comment_time( 'F d Y \a\t H:i a' ) ?></span>
				</header>
				<section class='comment-content'>
					<?php comment_text() ?>
				</section>

				<span class='primary-links'>
					<?php
						comment_reply_link( array_merge( $args, array(
							'reply_text' => 'Reply',
							'depth' => $depth,
							'max_depth' => $args['max_depth']
						)));
					?>

					<?php edit_comment_link( 'Edit', ' - <span class="edit-link">', '</span>' ); ?>
				</span>

			</article>
	<?php
	break;
	endswitch;
}


// 5.2 Pagination
function bsh_pagination( $query = false, $param = false ) {
	if( $query == false ) {
		global $wp_query;
		$query = $wp_query;
	}
	global $wp;

	if( $param == false ) {
		$pagination = array(
			'base'      => str_replace( 99999, '%#%', get_pagenum_link( 99999 ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $query->max_num_pages,
			'next_text' => __( 'next', THEMENAME ),
			'prev_text' => __( 'previous', THEMENAME ),
			'type' => 'plain'
		);

	}

	else {
		$link = get_pagenum_link( 1 );
		$link = ( substr_count( $link, '?' ) ) ? $link . '&est_page=%#%' : $link . '?est_page=%#%';
		$pagination = array(
			'base'      => $link,
			'format'    => '%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $query->max_num_pages,
			'next_text' => __( 'next', THEMENAME ),
			'prev_text' => __( 'previous', THEMENAME ),
			'type' => 'plain'
		);

	}



	ob_start();
	echo paginate_links( $pagination );
	$pagination = ob_get_clean();

	$pagination = preg_replace_callback( '/&_est_meta(.*?)=/', 'bsh_pagination_replace', $pagination );
	$pagination = str_replace( '&#038;', '&', $pagination );


	echo '<div class="pagination">';
	echo $pagination;
	echo '</div>';
}

function bsh_pagination_replace( $matches ) {
	return urlencode( $matches[1] );
}

// 5.3 Default Menu
function mus_default_menu( $args ) {
	ob_start();
	wp_page_menu();
	$menu = ob_get_clean();
	$menu = preg_replace( "/<ul class='children'>(.*?)<\/ul>/", '<div class="sub-container gradient"><ul class="children">$1</ul></div>', $menu );

	echo $menu;
}


// 5.5 No Posts Fallback
function bsh_no_posts( $title = false, $message = false) {
	$title = ( empty( $title ) ) ? get_theme_mod( 'no_posts_title' ) : $title;
	$message = ( empty( $message ) ) ? get_theme_mod( 'no_posts_message' ) : $message;

	echo '
		<hgroup class="no-posts-error">
		<h1>' . $title . '</h1>
		<h2>' . $message . '</h2>
		</hgroup>
	';
}


// 5.6 Image Formatter

//add_filter( 'post_thumbnail_html', THEMEPREFIX . '_format_image', 10, 5 );
function mus_format_image( $html = '', $post_id, $post_thumbnail_id, $size = '', $attr = '' ) {
$html = '<div class="image">' . $html . '</div>';
return $html;
}

// 5.7 Page Title Checker
function bsh_have_title() {
	global $post;
	$has_title = get_post_meta( $post->ID, '_' . THEMEPREFIX . '_title', true );
	$has_title = ( ( !empty( $has_title ) AND $has_title === 'hide' ) OR get_the_title( '', '', false ) == '' ) ? false : true;
	return $has_title;
}

function bsh_have_meta() {
	global $post;
	$show_meta = get_post_meta( $post->ID, '_' . THEMEPREFIX . '_metadata', true );

	$has_meta = ( $show_meta === 'hide' ) ? false : true;

	return $has_meta;
}


// 5.9 Customized Gallery Display
remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'gallery_shortcode_fancybox');
function gallery_shortcode_fancybox($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$icontag = tag_escape($icontag);
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) )
		$itemtag = 'dl';
	if ( ! isset( $valid_tags[ $captiontag ] ) )
		$captiontag = 'dd';
	if ( ! isset( $valid_tags[ $icontag ] ) )
		$icontag = 'dt';

	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->";
	$size_class = sanitize_html_class( 'gallery' );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$image_gallery = wp_get_attachment_image_src($id, 'gallery' );
		$image_large = wp_get_attachment_image_src($id, 'full' );

		$link = '<a title="' . $attachment->post_excerpt . '" href="' . $image_large[0] . '" rel="lightbox"><img src="' . $image_gallery[0] . '"></a>';

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
	}

	$output = '<div class="gallery">' . $output . '</div>';

	return $output;
}

// 5.10 Determine Layout Size
function bsh_get_layout_size( $image_size ) {
	if ( bsh_has_sidebar() ) {
		return $image_size;
	}
	else {
		return $image_size . '_nosb';
	}
}


// 5.12 Dropdown Walker

class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
	function start_lvl(&$output, $depth = 0, $args = array() ){
		$indent = str_repeat("\t", $depth);
	}

	function end_lvl(&$output, $depth = 0, $args = array()){
		$indent = str_repeat("\t", $depth);
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
		global $wp;
		$item = (object) $item;
		$title = str_repeat("&nbsp;", $depth * 4) . $item->post_title;

		$title = $item->post_title;
		$url = $item->url;

		if( empty( $title ) ) {
			$title = $item->title;
		}

		if( empty( $url ) ) {
			$url = $item->guid;
		}

		$current_url = home_url(add_query_arg(array(),$wp->request));
	 	$selected = ( $current_url == $item->url OR $current_url . '/' == $item->url ) ? 'selected="selected"' : '';
		$output .= '<option ' . $selected . ' value="' . $url . '">' . $title;
	}

	function end_el(&$output, $item, $depth = 0, $args = array() ){
		$output .= "</option>\n";
	}
}

// 5.13 Default Menu

function bsh_default_menu() {
	wp_page_menu( array(
		'menu_class' => 'menu menu-normal',
		'show_home'  => true
	));
}

// 5.14 Default Dropwdown

function bsh_default_dropdown() {
	echo '<div class="menu-select" style="display:none">';
	wp_dropdown_pages();
	echo '</div>';
}

add_action( 'init', 'est_session' );
function est_session() {
	if ( !session_id() ) {
		session_start();
	}
}



/***********************************************/
/*          6. Theme Option Functions          */
/***********************************************/

// 6.1 Custom Sidebar Generation
$choices = explode(',', get_theme_mod( 'sidebars' ) );
foreach( $choices as $choice ) {
	$theme_sidebar_counter++;
	$choice = trim( $choice );
	if( !empty( $choice ) ) {

		register_sidebar( array(
			'name'          => $choice,
			'id'		=> 'sidebar-' . $theme_sidebar_counter,
	'before_widget' => '<div class="widget-container"><div id="%1$s" class="widget %2$s">',
	'after_widget'  => '<div class="end"></div></div></div>',
	'before_title'  => '<h1 class="widget-title">',
	'after_title'   => '</h1>'
		));


	}
}

// 6.2 Get Setting Value
function bsh_get_page_setting( $setting, $default = '' ) {
    global $post;
    $value = get_post_meta( $post->ID, '_' . THEMEPREFIX . '_' . $setting, true );

    if( empty( $value ) OR $value == 'default' ) {
    	$value = get_theme_mod( $setting );
    }
    if( empty( $value ) ) {
    	$value = $default;
    }
    return $value;
}


// 6.3 Has Sidebar
function bsh_has_sidebar() {
	$layout = bsh_get_layout();

	if( $layout === '1col' ) {
		return false;
	}
	else {
		return true;
	}
}

// 6.4 Get Assigned Sidebar
function bsh_get_sidebar() {

	$sidebar = get_theme_mod( 'sidebar' );
	if( is_singular( 'property' ) ) {
		$sidebar = get_theme_mod( 'property_sidebar' );
	}
	if ( is_singular( 'post' ) ) {
		$sidebar = 'Default Blog Sidebar';
	}


	if( is_singular() ) {

		global $post;
		$page_sidebar = get_post_meta( $post->ID, '_' . THEMEPREFIX . '_sidebar', true );
		if( !empty( $page_sidebar ) AND $page_sidebar != 'default' ) {
			$sidebar = $page_sidebar;
		}
	}
	return $sidebar;
}

// 6.5 Get Page Layout
function bsh_get_layout() {
	$layout = get_theme_mod( 'layout' );

	if( is_singular() ) {
	    global $post;
	    $layout = bsh_get_page_setting( 'layout' );
	}

	return $layout;

}


// 6.6 Color Translator
function bsh_determine_color( $color ) {
	$colors = array(
		'primary'           => get_theme_mod( 'primary_color' ),
		'primary_text'      => get_theme_mod( 'primary_text_color' ),
		'red'               => '#E23455',
		'cyan'              => '#139BC1',
		'yellow'            => '#F4D248',
		'black'             => '#4D4D4D',
		'blue'              => '#569CD1',
		'green'             => '#88BF53',
		'purple'            => '#C355BD',
		'orange'            => '#EC9F5F',
	);


	if( in_array( $color, array_keys( $colors ) ) ) {
		$final_color = $colors[ $color ];
	}
	else {
		if( substr( $color, 0, 1 ) == '#' ) {
			$final_color = $color;
		}
		else {
			$final_color = $colors['primary'];
		}
	}
	return $final_color;
}


// 6.7 Content Area Classes
function bsh_content_classes() {
	if( !bsh_has_sidebar() === true ) {
		return 'large-12 small-12';
	}
	$layout = bsh_get_layout();
	if( $layout === '2col_left' ) {
		return 'large-8 small-12 push-4';
	}
	else {
		return 'large-8 small-12';
	}
}

// 6.8 Sidebar Area Classes
function bsh_sidebar_classes() {
	$layout = bsh_get_layout();
	if( $layout === '2col_left' ) {
		return 'pull-8';
	}
	return;
}



/***********************************************/
/*         7. Documentation Functions          */
/***********************************************/

// 7.1 Online Help Documentation
if( !function_exists( 'bsh_docs_get_support' ) ) {
	function bsh_docs_get_support() {
			return __( '
			<p>
				Don\'t forget that there is inline help available for each specific option next to the option itself. Simply hover over the help link.</p>
			<p>
				Before you ask for support make sure to read the relevant sections in the documentation you received with the theme. We also have online documentation in our <a href="http://bonsaished.com/knowledgebase/">Knowledgebase</a>. We recommend taking a look here as well.
			</p>
			<p>
				If you still have questions or you have found a possible bug, we are at your service in the <a href="http://bonsaished.com/support/theme/estatement/">Support Forum</a>.If you contact us there, please make sure to include a <strong>screenshot and a link</strong> to whatever it is you have a problem with.

			</p>
		', THEMENAME );
	}
}

// 7.3 Shortcode Documentation
function bsh_docs_shortcodes() {
	return __('
	    <p>Shortcodes are snippets of specially formatted content which you can use to liven up your website\'s content. If you don\'t know how to use them, refer to the theme documentation, or read our short guide on <a href="http://bonsaished.com/blog/kb/how-to-use-shortcodes/">How to Use Shortcodes</a> online.</p>

	    <h4>Line Shortcode</h4>

	    <h5>[line]</h5>

	    <p>The line shortcode allows you to add a separator line between two bits of content. Optionally you can add a little link inline with the line. The parameters of this shortcode are:</p>

	    <p><strong>color</strong><br>
	    By specifying a color you are controling the color of the line. Please take a look at the Color Notes for how to specify colors.</p>

	    <p><strong>url</strong><br>
	    If you would like to add a link next to the line (to take the user to the top of the page for example) you can do so by adding the url parameter. If given, a link will be generated for you. if you want the link to take users to the top of the page use \'#\' as the value for this parameter.</p>

	    <p><strong>text</strong><br>
	    The link will have the text given here. The default text is \'link\' which you will probably want to change to something more meaningful.</p>

	    <p><strong>position</strong><br>
	    You can define a position for the link. The position can be left or right (left is the default).</p><a href="http://bonsaished.com/blog/kb/line-shortcode/">View Examples Online</a>

	    <div class="separator"></div>

	    <h4>Column Shortcode</h4>

	    <h5>[row][column][/column][/row]</h5>

	    <p>Columns enable you to easily sort your content into a column based layout. Creating columns requires the use of two separate shortcodes, the [row] and the [column] shortcode. The parameters of this shortcode are:</p>

	    <p>There is only one attribute involved which needs to be added to the column shortcode to tell it how wide it should be.</p>

	    <p><strong>width</strong><br>
	    Sets the width of a column in units. Should be given as one to twelve.</p>

	    <p>There are twelve units in each row. This means that whenever you create a row you will need to distrbute 12 units throughout them. In other words you can create one \'twelve\' width column in a row or two \'six\' width coliumns, or three \'four\' width columns. The idea is that the width of all columns in a row should add up to twelve.</p>

	    <p>You don\'t have to use the same widths in a row though. You could create a \'six\' width column and two \'three\' width columns. Let\'s look at some examples.</p><a href="http://bonsaished.com/blog/kb/column-shortcode/">View Examples Online</a>

	    <div class="separator"></div>

	    <h4>Map Shortcode</h4>

	    <h5>[map]</h5>

	    <p>The map shortcode lets you put a customizable Google map centered on a location you specify anywhere in a post. The parameters of this shortcode are:</p>

	    <p><strong>location</strong><br>
	    Adding this is necessary for the map to show up. It should be an address in plain text, something you would type into the search field in Google Maps.</p>

	    <p><strong>type</strong><br>
	    The type of map to show. The value can be HYBRID, SATELLITE, ROADMAP, TERRAIN. The default value is HYBRID.</p>

	    <p><strong>zoom</strong><br>
	    Set the initial zoom level for a map. If you\'re adding a street level map somewhere around 14 (the default) is best. The zoom can range from 1 and up where 1 is the most zoomed out.</p>

	    <p><strong>marker</strong><br>
	    If set to yes, a marker will be placed at the center of the map, indicating the location you specified</p>

	    <p><strong>height</strong><br>
	    The height of the map can be set specifically if you need it. By default it is set to 400px. Don\'t forget to add the \'px\' suffix to the amount!</p><a href="http://bonsaished.com/blog/kb/map-shortcode/">View Examples Online</a>

	    <div class="separator"></div>

	    <h4>Tabs Shortcode</h4>

	    <h5>[tabs][section][/section][/tabs]</h5>

	    <p>Using the tabs shortcode you can create an area with tabbed navigation. This is great if you want to show more content in smaller area. The [tabs] shortcode is always used with the [section] shortcode, similarly to how columns are created. The parameters of this shortcode are:</p>

	    <p>The [tabs] shorcode has two attributes:</p>

	    <p><strong>contained</strong><br>
	    This attribute can be set to \'yes\' or \'no\'. By default it is set to yes, which means that the contents of the tabs will be contained in a box. If set to no, the box will be removed.</p>

	    <p><strong>pill</strong><br>
	    This attribute allows you to use pill-style navigation instead of regular tabs. Set to yes if you would like pills, the default value is no.</p>

	    <p>The [section] shortcode has just one attribute:</p>

	    <p><strong>title</strong><br>
	    The title of the section which will be used in the tab.</p><a href="http://bonsaished.com/blog/kb/tabs-shortcode/">View Examples Online</a>

	    <div class="separator"></div>

	    <h4>Accordion Shortcode</h4>

	    <h5>[accordion][section][/section][/accordion]</h5>

	    <p>An accordion is very similar to a tab, but has a vertical orientation. It is similarly useful for displaying more content in smaller spaces. To create an accordion you will need to use the [accordion] shortcode and the [section] shortcode. The setup is exactly the same as before, but the accordion shortcode does not have any parameters. The section shortcode has a title parameter which you must fill out. The parameters of this shortcode are:</p>

	    <p><strong>background</strong><br>
	    The title of the section which will be used in the accordion</p><a href="http://bonsaished.com/blog/kb/accordion-shortcode/">View Examples Online</a>

	    <div class="separator"></div>



	    <h4>Slideshow</h4>

	    <h5>[slideshow]</h5>

		<p>A slideshow enables you to show off a number of images in style. Users will be able to flick through the slideshow and navigate it via the navigation dots on the bottom. Slideshows have just one parameter which allows you to add the images you need. If you omit this parameter, all images beloning to the post in question will be used. If you don\'t know what shortcodes are we recommend you read our article on <a href="http://bonsaished.com/blog/kb/how-to-use-shortcodes/">How to Use Shortcodes</a>.</p>
		<p><strong>ids</strong><br>
		Add a comma separated list of image ids. The easiest way to add the images you need is to actually create a WordPress gallery first. If you don\'t know how to do this, refer to our article about <a href="http://bonsaished.com/blog/kb/uploading-and-using-media/">Uploading and Using Media</a>. Once you\'ve created the gallery just rename the shortcode from <code>gallery</code> to <code>slideshow</code></p>

		<a href="http://bonsaished.com/blog/kb/slideshow-shortcode/">View Examples Online</a>

	    <div class="separator"></div>


	    <h4>Property List Shortcode</h4>

	    <h5>[postlist]</h5>




							<p>The property list shortcode is great for showing property listings wherever you like. It allows you to add property cards or listings anywhere inside content, with full control over what is shown and how.&nbsp;If you don\'t know what shortcodes are we recommend you read our article on&nbsp;<a href="http://bonsaished.com/blog/kb/how-to-use-shortcodes/" data-cke-saved-href="http://bonsaished.com/blog/kb/how-to-use-shortcodes/">How to Use Shortcodes</a>. The parameters of this shortcode are:</p>
<strong>layout</strong><br>
<p>By choosing between specific layouts you can make the properties display differently. Currently you have a choice between <strong>card</strong>, <strong>minicard</strong> and <strong>list</strong>.</p>
<strong>count</strong><br>
<p>Select the number of items to show</p>

<strong>columns</strong><br>
<p>
Determine how many columns you would like to show the results in. The options are "1", "2" or "3".</p>
<strong>include</strong><br>
<p>
Select specific properties to show. If you add this parameters, others are discarded. To find the ID of a property take a look at our guide on <a href="http://bonsaished.com/blog/kb/post-ids/">Post Ids</a>. Remember that you can add multiple ids by separating them with commas. </p>
<strong>property_type</strong><br>
<p>
Select the ID of the property type you want to show. You can add comma separated values as well to use multiple types. If you don?t know how to find the ID of a property type, refer to our article on&nbsp;<a href="http://bonsaished.com/blog/kb/category-and-taxonomy-ids/" data-cke-saved-href="http://bonsaished.com/blog/kb/category-and-taxonomy-ids/">Category and Taxonomy IDs</a>.</p>
<strong>property_category</strong><br>
<p>Select the ID of the property category you want to show. You can add comma separated values as well to use multiple categories. If you don?t know how to find the ID of a property category, refer to our article on&nbsp;<a href="http://bonsaished.com/blog/kb/category-and-taxonomy-ids/" data-cke-saved-href="http://bonsaished.com/blog/kb/category-and-taxonomy-ids/">Category and Taxonomy IDs</a>.</p>



		<a href="http://bonsaished.com/blog/kb/property-list-shortcode/">View Examples Online</a>

	    <div class="separator"></div>


	    <h4>Button Shortcode</h4>

	    <h5>[button][/button]</h5>

	    <p>Creating nicely formatted buttons is extremely easy with the button shortcode. Just wrap it around any text to make it look like a button. You can specify a URL to actually make it work as a button and you can adjust various style settings. The parameters of this shortcode are:</p>

	    <p><strong>url</strong><br>
	    The URL the user is taken to when the button is clicked</p>

	    <p><strong>background</strong><br>
	    The background color of the button. See the section above on using colors for what values you can add here.</p>

	    <p><strong>color</strong></p>

	    <div>
	        The text color of the button.&nbsp;See the section above on using colors for what values you can add here.

	        <p></p>

	        <p><strong>gradient</strong><br>
	        If set to \'yes\' a subtle gradient will be generated based on the background color. The default value is \'no\'.</p>

	        <p><strong>radius</strong><br>
	        If you would like a rounded button you can set the radius here. By default it is set to \'0px\'. If you would like a subtle rounded corner use a small value like \'3px\'. if you want heavily rounded corners use something like \'3px\'. Don\'t &nbsp;forget to add the \'px\' part!</p>

	        <p><strong>arrow</strong><br>
	        If set to \'yes\', an arrow will be generated on the right of the button. The color of this arrow will be the same as the given text color. By default it is set to \'no\'</p><a href="http://bonsaished.com/blog/kb/button-shortcode/">View Examples Online</a>

	        <div class="separator"></div>

	        <h4>Highlight Shortcode</h4>

	        <h5>[highlight][/highlight]</h5>

	        <p>The highlight shortcode allows you to highlight bits of your text in the post content. This is useful for making something stand out, or separating some content from the rest for some other reason. You can modify the color of the highlight using attributes. The parameters of this shortcode are:</p>

	        <p><strong>background</strong><br>
	        The background color of the highlight. See the section above on using colors for what values you can add here.</p>

	        <p><strong>color</strong><br>
	        The text color of the highlight.&nbsp;See the section above on using colors for what values you can add here.</p><a href="http://bonsaished.com/blog/kb/highlight-shortcode/">View Examples Online</a>

	        <div class="separator"></div>

	        <h4>Message Shortcode</h4>

	        <h5>[message][/message]</h5>

	        <p>The message shortcode is another helpful tool for making some content stick out. It is great for putting up notices, warnings and other relevant information that you want to draw the user\'s attention to. Using attributes you can change some properties of the display. The parameters of this shortcode are:</p>

	        <p><strong>background</strong><br>
	        The background color of the message. See the section above on using colors for what values you can add here.</p>

	        <p><strong>color</strong><br>
	        The text color of the message.&nbsp;See the section above on using colors for what values you can add here.</p>

	        <p><strong>radius</strong><br>
	        If you would like a rounded message you can set the radius here. By default it is set to \'0px\'. If you would like a subtle rounded corner use a small value like \'3px\'. if you want heavily rounded corners use something like \'3px\'. Don\'t &nbsp;forget to add the \'px\' part!</p><a href="http://bonsaished.com/blog/kb/message-shortcode/">View Examples Online</a>
	        </p>

	', THEMENAME );
}




/***********************************************/
/*                8. Integrations              */
/***********************************************/

// 8.1 Twitter Integration
add_action( 'wp_head', COMPANYPREFIX . '_twitter_integration' );
function bsh_twitter_integration() {
?>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<?php
}


// 8.2 Facebook Integration

//add_action( 'wp_footer', COMPANYPREFIX . '_facebook_integration' );
function bsh_facebook_integration() {
	$api_key = get_theme_mod( 'facebook_api_key' );
	$api_key = ( empty( $api_key ) ) ? BSH_FACEBOOK_API_KEY : $api_key;

	?>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $api_key ?>";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php
}

// 8.3 Twitter API

add_action( 'init', COMPANYPREFIX . '_twitter_api' );
function bsh_twitter_api() {
	global $cb;
	$consumer_key = get_theme_mod( 'twitter_consumer_key' );
	$consumer_key = ( empty( $consumer_key ) ) ? BSH_TWITTER_CONSUMER_KEY : $consumer_key;
	$consumer_secret = get_theme_mod( 'twitter_consumer_secret' );
	$consumer_secret = ( empty( $consumer_secret ) ) ? BSH_TWITTER_CONSUMER_SECRET : $consumer_secret;
	$access_token = get_theme_mod( 'twitter_access_token' );
	$access_token = ( empty( $access_token ) ) ? BSH_TWITTER_ACCESS_TOKEN : $access_token;
	$access_secret = get_theme_mod( 'twitter_access_secret' );
	$access_secret = ( empty( $access_secret ) ) ? BSH_TWITTER_ACCESS_SECRET : $access_secret;

	require_once ('framework/external/Codebird/Codebird.class.php');
	Codebird::setConsumerKey( $consumer_key, $consumer_secret );
	$cb = Codebird::getInstance();
	$cb->setToken( $access_token, $access_secret );

}


/***********************************************/
/*                 */
/***********************************************/

function bs_filter_option_array( $option_array ) {
	foreach( $option_array as $key => $data ) {
		if( empty( $data['value'] ) ) {
			unset( $option_array[$key] );
		}
	}
	return $option_array;
}


function bs_nav_menu(){
	$menu = wp_page_menu( array(
		'menu_class' => 'menu-container',
		'echo'       => false
	));

	$menu = str_replace(
		array(
			'current_page_item',
			'current_page_parent',
			'current_page_ancestor',
			'<ul>',
			'page_item',
			'<ul class=\'children\'>'
		),
		array(
			'current-menu-item',
			'current-menu-parent',
			'current-menu-ancestor',
			'<ul class="menu">',
			'menu-item',
			'<ul class="sub-menu">'
		),
		$menu
	);

	echo $menu;
}



function bs_get_post_meta( $meta_key, $default = null ) {
	global $post;
	$meta_value = get_post_meta( $post->ID, $meta_key, true );

	if( !empty( $meta_value ) ) {
		return $meta_value;
	}

	if( empty( $meta_value ) AND $default == null ) {
		return $meta_value;
	}
	elseif ( empty( $meta_value ) AND !empty( $default ) ) {
		return $default;
	}
}


function bsh_get_taxonomy_array( $taxonomy ) {
	$terms = get_terms( $taxonomy );

	$term_array = array();

	foreach( $terms as $term ) {
		$term_array[$term->term_id] = $term->name;
	}

	return $term_array;

}



function bsh_get_taxonomy_dropdown_options( $taxonomy, $current = '', $all = '' ) {
	$terms = get_terms( $taxonomy );

	$options = array();

	if( !empty( $all ) ) {
		$options[] = '<option value="">' . $all . '</option>';
	}

	foreach( $terms as $term ) {
		$selected = ( $current == $term->term_id ) ? 'selected="selected"' : '';
		$options[] = '<option ' . $selected . ' value="' . $term->term_id . '">' . $term->name . '</option>';
	}

	return implode( ' ', $options );
}





function get_all_builtin_details() {
	$details = array(
		0 => array(
			'name'     => 'Country',
			'key'      => '_est_meta_country',
			'prefered' => 'select'
		),
		1 => array(
			'name'     => 'State',
			'key'      => '_est_meta_state',
			'prefered' => 'select'
		),
		2 => array(
			'name'     => 'City',
			'key'      => '_est_meta_city',
			'prefered' => 'select'
		),
		3 => array(
			'name'     => 'Street Address',
			'key'      => '_est_meta_address',
			'prefered' => 'text'
		),
		4 => array(
			'name'     => 'Zip/Postal Code',
			'key'      => '_est_meta_zipcode',
			'prefered' => 'text'
		),
		5 => array(
			'name'     => 'Price',
			'key'      => '_est_meta_price',
			'prefered' => 'range'
		),
		6 => array(
			'name'     => 'Building Area',
			'key'      => '_est_meta_building_area',
			'prefered' => 'range'
		),
		7 => array(
			'name'     => 'Property Area',
			'key'      => '_est_meta_property_area',
			'prefered' => 'range'
		),
		8 => array(
			'name'     => 'Year Built',
			'key'      => '_est_meta_property_built',
			'prefered' => 'range'
		),
		9 => array(
			'name'     => 'Room Count',
			'key'      => '_est_meta_property_rooms',
			'prefered' => 'range'
		),
		10 => array(
			'name'     => 'Property Type',
			'key'      => 'property_type',
			'prefered' => 'select'
		),
		11 => array(
			'name'     => 'Property Category',
			'key'      => 'property_category',
			'prefered' => 'select'
		),

	);

	return $details;
}


function get_all_custom_details() {
	global $wpdb;
	$detail_list = array();

	$details = $wpdb->get_col( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_est_property_custom' " );

	foreach( $details as $key => $value ) {
		$post_detail = unserialize( $value );
		$detail_list = array_merge( $detail_list, $post_detail );
	}

	$detail_list = array_unique( $detail_list );
	$customdata = get_option( 'est_customdata' );

	$details = array();
	foreach( $detail_list as $detail ) {
		$key = bsh_make_custom_key( $detail );
		if( !in_array( $key, array_keys( $customdata ) ) ) {
			$details[$detail] = $key;
		}
	}


	return $details;
}

function get_custom_detail_select_options( $current = '' ) {
	$options = array();
	$details = get_all_custom_details();
	foreach( $details as $name => $key ) {
		$options[] = '<option value="' . $key . '">' . $name . '</option>';
	}
	return $options;
}

function get_custom_detail_array() {
	$customdata = get_option( 'est_customdata' );
	$detail_array = array();
	$detail_array['none'] = '-- No Detail Selected --';
	foreach( $customdata as $key => $data ) {
		$detail_array[$key] = $data['name'];
	}
	return $detail_array;
}



function bsh_make_custom_key( $name ) {
	$custom_key = sanitize_title_with_dashes( $name );
	$custom_key = str_replace( '-', '_', $custom_key );
	if( function_exists( 'mb_strtolower' ) ) {
		$custom_key = mb_strtolower( $custom_key, 'UTF-8' );
	}
	else {
		$custom_key = strtolower( $custom_key );
	}
	$custom_key = '_' . THEMEPREFIX . '_meta_' . $custom_key;
	return $custom_key;
}

function est_get_detail_range( $detail = '' ) {
	if( !empty( $detail ) ) {
		global $wpdb;
		$values = $wpdb->get_col( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '$detail' AND post_ID IN ( SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'property' ) " );
		foreach( $values as $key => $value ) {
			if( !is_numeric( $value ) ) {
				unset( $values[$key] );
			}
		}
		$range = array();

		if( !empty( $values ) ) {
			$range['min'] = min( $values );
			$range['max'] = max( $values );
		}

		return $range;
	}
}

function bsh_get_price( $price = 0, $currency = '', $currency_position = '' ) {
	if( empty( $currency ) ) {
		$currency = get_theme_mod( 'currency' );
		$currency = ( empty( $currency ) ) ? '$' : $currency;
	}

	if( empty( $currency_position ) ) {

		$currency_position = get_theme_mod( 'currency_position' );
		$currency_position = ( empty( $currency_position ) ) ? 'before' : $currency_position;

	}
	$display = ( $currency_position == 'before' ) ? '<span class="unit">' . $currency . '</span><span class="value">' . est_number_format( $price, 2 ) . '</span>' : '<span class="value">' . est_number_format( $price, 2 ) . '</span><span class="unit">' .  $currency . '</span>';
	return $display;
}

function bsh_get_numeric_digits( $number ) {
        return ceil(log10($number));
}

function bsh_get_area( $size, $unit_type = 'area_unit' ) {
	$unit = get_theme_mod( $unit_type );

	if( empty( $unit ) AND $unit_type == 'area_unit' ) {
		$unit = 'sqft';
	}

	if( empty( $unit ) AND $unit_type == 'grounds_area_unit' ) {
		$unit = 'acres';
	}

	return '<span class="value">' . est_number_format( $size, 2 ) . '</span> <span class="unit">' . $unit . '</span>';
}



function bsh_get_country_dropdown_options( $current = '' ) {
	$countries = include( get_template_directory() . '/framework/data/countries.php' );
	$options = array();
	foreach( $countries as $country ) {
		$selected = ( $country === $current ) ? 'selected="selected"' : '';
		$options[] = '<option ' . $selected . ' value="' . $country . '">' . $country . '</option>';
	}
	return implode( '', $options );
}



function bsh_get_state_dropdown_options( $current = '' ) {
	$states = include( get_template_directory() . '/framework/data/states.php' );
	$options = array();
	foreach( $states as $state ) {
		$selected = ( $state === $current ) ? 'selected="selected"' : '';
		$options[] = '<option ' . $selected . ' value="' . $state . '">' . $state . '</option>';
	}
	return implode( '', $options );
}




function bsh_get_detail_dropdown_options( $detail, $current = '', $all = '' ) {
	global $wpdb;
	$customdata = get_option( 'est_customdata' );
	$data = $customdata[$detail]['options'];

	$values = $wpdb->get_col( "SELECT DISTINCT( meta_value ) FROM $wpdb->postmeta WHERE meta_key = '$detail' AND post_ID IN ( SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' ) " );
        
	if( $customdata[$detail]['format'] == 'text' && !empty( $data) ) {
		$newvalues = array();
		foreach( $data as $item ) {
			if(in_array( $item['value'], $values)) {
				$newvalues[$item['value']] = $item['name'];
			}
		}
		$values = $newvalues;
	}
	else {
		sort( $values );
	}
        
	$options = array();

	if( !empty( $all ) ) {
		$options[] = '<option value="">' . $all . '</option>';
	}

	foreach( $values as $value => $name ) {

                //DAN CHANGES - Commenting this fixes a bug where a dropdown for custom fields is not working on search pages
		/*if( $customdata[$detail]['format'] == 'text' ) {
			$value = $name;
		}*/
                
		if( !empty( $value ) ) {
			$selected = ( $current == $value ) ? 'selected="selected"' : '';
			$options[] = '<option ' . $selected . ' value="' . $value . '">' . str_replace( array('<', '>'), array('&lt;', '&gt;'), $name) . '</option>';
		}
	}

	return implode( '', $options );
}



function get_search_options( $search ) {

	if( !empty( $search['customdatas'] ) ) {
		foreach( $search['customdatas'] as $key => $data ) {
			if( empty( $data['show'] ) OR $data['show'] != 'yes' ) {
				unset( $search['customdatas'][$key] );
			}
		}
	}
	$options['customdata'] = ( empty( $search['customdatas'] ) ) ? array() : $search['customdatas'];

	if( !empty( $search['custom_taxonomies'] ) ) {
		foreach( $search['custom_taxonomies'] as $taxonomy => $data ) {
			if( empty( $data['show'] ) OR $data['show'] != 'yes' ) {
				unset( $search['custom_taxonomies'][$taxonomy] );
			}
		}
	}
	$options['custom_taxonomies'] = ( empty( $search['custom_taxonomies'] ) ) ? array() : $search['custom_taxonomies'];

	$options = array_merge( $options['custom_taxonomies'], $options['customdata'] );

	if( isset( $_GET['search'] ) ) {
		$options['search'] = array(
			'show' => 'yes',
			'field' => 'text',
			'order' => 0,
			'type' => 'search'
		);
	}

	uasort( $options, 'est_sort_custom_data' );


	return $options;

}

function bsh_get_search_field( $key, $detail, $args = array() ) {
	if( function_exists( 'bsh_get_search_field_' . $detail['field'] ) ) {
		call_user_func( 'bsh_get_search_field_' . $detail['field'], $key, $detail, $args );
	}
}


function est_vertical_search( $details, $args = array() ) {
		$defaults = array(
			'sliders' => true
		);

		$args = wp_parse_args( $args, $defaults );
	?>

	<div class='estSearch vertical_twocol'>
	<?php foreach( $details as $key => $detail ) { ?>
		<div class='row form-row'>
			<div class='large-4 small-12 columns'>
				<label for="<?php echo $key ?>" class='offset'>
					<?php echo est_search_detail_name( $key, $detail ) ?>
				</label>
			</div>
			<div class='large-8 small-12 columns'>
				<?php echo bsh_get_search_field( $key, $detail, $args ) ?>
			</div>
		</div>
		<?php
	}
	?>
	</div>
	<?php
}


function est_search_detail_name( $key, $detail ) {

	if( $detail['type'] == 'customdata' ) {
		$details = get_option( 'est_customdata' );
		$name = $details[$key]['name'];
	}
	elseif( $detail['type'] == 'taxonomy' ) {
		$taxonomy = get_taxonomy( $key );
		$name = $taxonomy->labels->name;
	}
	elseif( $detail['type'] == 'search' ) {
		global $post;

		$name = get_post_meta( $post->ID, '_est_search_terms_label', true );
		$name = ( empty( $name ) ) ? __( 'Search Terms', THEMENAME ) : $name;
	}
	elseif( $detail['type'] == 'profilefields' ) {
		$details = get_option( 'est_profilefields' );
		$name = $details[$key]['name'];
	}

	if( function_exists( 'icl_t' ) ) {
		$name = icl_t( 'Estatement - Custom Field Names', $name, $name );
	}


	return $name;
}


function bsh_get_search_field_select( $key, $detail, $args = array() ) {
	$customdata = get_option( 'est_customdata' );
	?>
		<?php
			if( $detail['type'] == 'taxonomy' ) :
		?>
			<select id="<?php echo $key ?>" class="medium" name='<?php echo $key ?>'>
				<?php echo bsh_get_taxonomy_dropdown_options( $key, $_GET[$key], __( 'All', THEMENAME ) ) ?>
			</select>
		<?php else :
			$options = bsh_get_detail_dropdown_options( $key, $_GET[$key], __( 'Any', THEMENAME ) );
		?>

			<select id="<?php echo $key ?>" class="medium" name='<?php echo $key ?>'>
				<?php echo $options ?>
			</select>

		<?php endif ?>
	<?php
}


function bsh_get_search_field_slider( $key, $detail, $args = array() ) {
	$customdata = get_option( 'est_customdata' );
	$range = est_get_detail_range( $key );
	$min = est_customdata_value( $key, $range['min'] );
	$max = est_customdata_value( $key, $range['max'] );

        //START DAN CHANGES - Added min/max_digits_round so that the price slider rounds to the nearest 10, fixing a bug
        $min_digits_round = bsh_get_numeric_digits( $range['min'] ) > 1 ? 10 : 1;
        $max_digits_round = bsh_get_numeric_digits( $range['max'] ) > 1 ? 10 : 1;
	$range['min'] = floor( $range['min'] / $min_digits_round ) * $min_digits_round ;
	$range['max'] = ceil( $range['max'] / $max_digits_round ) * $max_digits_round;
	//$range['min'] = floor( $range['min'] );
	//$range['max'] = ceil( $range['max'] );
        //END DAN CHANGES

	$current_min = ( !empty( $_GET[$key]['min'] ) ) ? $_GET[$key]['min'] : '';
	$current_max = ( !empty( $_GET[$key]['max'] ) ) ? $_GET[$key]['max'] : '';

	$sliders_class = ( empty( $args['sliders'] ) ) ? 'off' : 'on';
?>
	<p data-id='<?php echo $key ?>' class='mb0 range-values'><span class='min'><?php echo $min ?></span> - <span class='max'><?php echo $max ?></span></p>
	<div class='range-container'>
	<div id='<?php echo $key ?>' class='range <?php echo $sliders_class ?>' data-name='<?php echo $key ?>' data-min="<?php echo $range['min'] ?>" data-max='<?php echo $range['max'] ?>' data-value_min='<?php echo $current_min ?>' data-value_max='<?php echo $current_max ?>'></div>
	</div>
<?php
}

function bsh_get_search_field_text( $key, $detail, $args = array() ) {
	$customdata = get_option( 'est_customdata' );
	$value = ( empty( $_GET[$key] ) ) ? '' : $_GET[$key] ;
?>
	<input type='text' id="<?php echo $detail ?>" name='<?php echo $key ?>' value='<?php echo $value ?>'>
<?php
}

function bsh_get_search_field_checkbox( $key, $detail, $args = array() ) {
	global $wpdb;
	$customdata = get_option( 'est_customdata' );
	?>
	<div class='checkboxes' data-type='<?php echo $detail['filter_type'] ?>'>

	<?php
	if( $detail['type'] == 'taxonomy' ) :
		$terms = get_terms( $key );
	?>
	<?php
		$i=0;
		foreach( $terms as $term ) :
		$checked = ( !empty( $_GET[$key] ) AND in_array( $term->term_id, $_GET[$key] ) ) ? 'checked="checked"' : ''
	?>
		<label class='inline' for='<?php echo $key ?>_<?php echo $i ?>'>
		<input <?php echo $checked ?> type='checkbox' id="<?php echo $key ?>_<?php echo $i ?>" name='<?php echo $key ?>[]' value='<?php echo $term->term_id ?>'>
		<?php echo $term->name ?></label><br>
	<?php
		$i++;
		endforeach;

	else :
		$options = $wpdb->get_col( "SELECT DISTINCT( meta_value ) FROM $wpdb->postmeta WHERE meta_key = '$key' AND post_ID IN ( SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' ) " );
		sort( $options );

		$i=0;
		if( !empty( $customdata[$key]['options'] ) ) :
		foreach( $customdata[$key]['options'] as $option ) :
			if( in_array( $option['value'], $options ) ) :
			$checked = ( !empty( $_GET[$key] ) AND in_array( $option['value'], $_GET[$key] ) ) ? 'checked="checked"' : ''
		?>
			<label class='inline' for='<?php echo $key ?>_<?php echo $i ?>'>
			<input <?php echo $checked ?> type='checkbox' id="<?php echo $key ?>_<?php echo $i ?>" name='<?php echo $key ?>[]' value='<?php echo $option['value'] ?>'>
			<?php echo $option['name'] ?></label><br>
		<?php $i++; endif; endforeach; endif; ?>
<?php
	endif;
?>
	</div>

<?php
}

function bsh_get_search_field_radio( $key, $detail, $args = array() ) {
	global $wpdb;
	$customdata = get_option( 'est_customdata' );

	if( $detail['type'] == 'taxonomy' ) :
		$terms = get_terms( $key );
	?>

	<?php
		$i=0;
		foreach( $terms as $term ) :
	?>
		<label class='inline' for='<?php echo $key ?>_<?php echo $i ?>'>
		<input type='radio' id="<?php echo $key ?>_<?php echo $i ?>" name='<?php echo $key ?>' value='<?php echo $term->term_id ?>'>
		<?php echo $term->name ?></label><br>
	<?php
		$i++;
		endforeach;

	else :
		$options = $wpdb->get_col( "SELECT DISTINCT( meta_value ) FROM $wpdb->postmeta WHERE meta_key = '$key' AND post_ID IN ( SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' ) " );
		sort( $options );

		$i=0;
		foreach( $customdata[$key]['options'] as $option ) :
			if( in_array( $option['value'], $options ) ) :
		?>
			<label class='inline' for='<?php echo $key ?>_<?php echo $i ?>'>
			<input type='radio' id="<?php echo $key ?>_<?php echo $i ?>" name='<?php echo $key ?>' value='<?php echo $option['value'] ?>'>
			<?php echo $option['name'] ?></label><br>
		<?php $i++; endif; endforeach ?>

<?php
	endif;

}


function bsh_get_the_taxonomies( $post_id, $taxonomy, $link = true ) {

	$terms = wp_get_object_terms( $post_id, $taxonomy );

	$list = array();
	foreach( $terms as $term ) {
		if( $link == true ) {
			$list[] = '<a href="' . get_term_link( (int) $term->term_id, $taxonomy ) . '">' . $term->name . '</a>';
		}
		else {
			$list[] = $term->name;
		}
	}

	return implode( ', ', $list );

}

add_action( 'wp_ajax_send_contact_message', 'send_contact_message' );
add_action( 'wp_ajax_nopriv_send_contact_message', 'send_contact_message' );

function send_contact_message() {

	$url = get_permalink( $_POST['post_id'] );
	$title = get_the_title( $_POST['post_id'] );

	if( !empty( $_POST['force_email'] ) AND empty( $_POST['email'] ) ) {
		header( 'location: ' . $url . '?message_sent=email' );
		die();
	}

	if( empty( $_POST['nocaptcha'] ) ) {
	$captcha_value = unserialize( $_POST['captcha_value'] );
	$answer = $captcha_value[0] - 1 + $captcha_value[1] + 1;
	if( $answer != $_POST['captcha'] ) {
		header( 'location: ' . $url . '?message_sent=captcha' );
		die();
	}
	}


	$property_subject = get_post_meta( $_POST['post_id'], '_est_contact_reply_subject', true );
	$property_subject = ( empty( $property_subject ) ) ? get_theme_mod( 'contact_reply_subject' ) : $property_subject;

	$property_message = get_post_meta( $_POST['post_id'], '_est_contact_reply_message', true );
	$property_message = ( empty( $property_message ) ) ? get_theme_mod( 'contact_reply_message' ) : $property_message;
	$property_message = str_replace( array( '!title', '!url' ), array( $title, $url ), $property_message );

	$sender = array(
		'subject'  => $property_subject,
		'message'  => $property_message,
		'email'    => $_POST['email']
	);

	$property_email = get_post_meta( $_POST['post_id'], '_est_contact_email', true );
	$property_email = ( empty( $property_email ) ) ? get_theme_mod( 'contact_email' ) : $property_email;

	$message = '
		<strong>' . __( 'Name', THEMENAME ) . ':</strong> ' . $_POST["name"] . '<br>
		<strong>' . __( 'Email', THEMENAME ) . ':</strong> ' . $_POST["email"] . '<br>
		<strong>' . __( 'Phone', THEMENAME ) . ':</strong> ' . $_POST["phone"] . '<br>
		<strong>' . __( 'Property', THEMENAME ) . ':</strong> <a href="' . $url . '">' . $title . '</a><br>
		<strong>' . __( 'Message', THEMENAME ) . ': </strong><br>
		' . nl2br( $_POST['message'] ) . ';
	';

	$recipient = array(
		'subject'  => __( 'Contact about a property', THEMENAME ),
		'message'  => __( 'You have received a contact email about a property, here are the details:', THEMENAME ) . $message,
		'email'    => $property_email
	);

    $from_mail = get_theme_mod( 'contact_email' );
    $from_mail = ( empty( $from_mail ) ) ? get_option( 'admin_email' ) : $from_mail;

    $headers = 'From: '.get_bloginfo().' <'.$from_mail.'>' . "\r\n";    $from_mail = ( empty( $from_mail ) ) ? get_option( 'admin_email' ) : $from_mail;

    $headers = 'From: '.get_bloginfo().' <'.$from_mail.'>' . "\r\n";

add_filter( 'wp_mail_content_type', 'set_html_content_type' );

	@wp_mail( $sender['email'], $sender['subject'], $sender['message'], $headers );
	@wp_mail( $recipient['email'], $recipient['subject'], $recipient['message'], $headers );
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

	header( 'location: ' . $url . '?message_sent=true' );


}

function bsh_show_title() {
	global $post;
	$show = get_post_meta( $post->ID, '_est_title', true );
	if( $show === 'hide' ) {
		return false;
	}

	return true;
}


function est_get_data_from_url( $url ) {
	if( defined( 'EST_DATA_METHOD' ) ) {
		$method = EST_DATA_METHOD;
	}
	else {
		$method = ( function_exists('curl_version') ) ? 'curl' : 'file_get_contents';
	}

	if( $method == 'curl' ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$data = curl_exec($ch);
		curl_close($ch);
	}
	else {
		$data = file_get_contents( $url );
	}

	return $data;
}


function est_get_geolocation( $data, $parse = true ) {

	if( $parse == true ) {
		$location_data = array( '_est_meta_country', '_est_meta_city', '_est_meta_state', '_est_meta_address', '_est_meta_zipcode' );
		foreach( $data as $key => $value ) {
			if( !in_array( $key, $location_data ) ) {
				unset( $data[$key] );
			}
		}

		$location = implode( ', ', $data );
	}
	else {
		$location = $data;
	}

	$location = str_replace( ' ', '+', $location );

	$geolocation = est_get_data_from_url( 'http://maps.googleapis.com/maps/api/geocode/json?address=' . $location . '&sensor=false' );

	$geolocation = json_decode( $geolocation );

	if( $geolocation->status == 'ZERO_RESULTS' ) {
		return false;
	}
	else {
		$geocode['lat'] = $geolocation->results[0]->geometry->location->lat;
		$geocode['lng'] = $geolocation->results[0]->geometry->location->lng;
	}

	return $geocode;
}

function get_close_properties( $lat = '38.830615', $lng = '-104.824677', $radius = '100', $form_data = '', $force_taxonomies = '' ) {
	global $wpdb;
	if( !empty( $force_taxonomies ) ) {
		if( !is_array( $force_taxonomies ) ) {
			$force_taxonomies = json_decode( stripslashes( $force_taxonomies ), true );
		}
	}

	$results = $wpdb->get_results("
		SELECT
			post_id,
			meta_key,
			SUBSTRING_INDEX( meta_value , ',', 1 ) as lat,
			SUBSTRING_INDEX( meta_value , ',', -1 ) lng,
			( 3959 * acos( cos( radians('$lat') ) * cos( radians( SUBSTRING_INDEX( meta_value , ',', 1 ) ) ) * cos( radians( SUBSTRING_INDEX( meta_value , ',', -1 ) ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( SUBSTRING_INDEX( meta_value , ',', 1 ) ) ) ) ) AS distance
		FROM $wpdb->postmeta
		WHERE meta_key = '_est_geocode'
		HAVING distance < $radius
		LIMIT 0, 250
	");

	if( empty( $form_data ) AND !empty( $force_taxonomies ) ) {


		$args = array(
			'post_type'      => 'property',
			'posts_per_page' => -1,
		);

		$args['tax_query'] = $force_taxonomies;

		$not_in = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_est_show_on_map' AND meta_value = 'hide' ");
		$args['post__not_in'] = $not_in;
		global $wp_query;
		$temp_query = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query( $args );
		$ids = array();
		if( have_posts() ) {
			while( have_posts() ) {
				the_post();
				$ids[] = get_the_ID();
			}
		}
		$wp_query = $temp_query;
		wp_reset_postdata();

		foreach( $results as $key => $result ) {
			if( !in_array( $result->post_id, $ids ) ) {
				unset( $results[$key] );
			}
		}

	}

	elseif( !empty( $form_data ) ) {

		$form_data = wp_parse_args( $form_data );
		$form_data = array_filter($form_data);

		$defaults = array(
			'post_type' => 'property',
			'post_status' => 'publish',
			'count'     => -1
		);

		$params = wp_parse_args( $form_data, $defaults );
		foreach( $params as $key => $value ) {
			if( substr( $key, 0, 5 ) == 'meta_' ) {
				$meta_key = substr( $key, 5 );

				if( substr_count( $meta_key, '_min' ) > 0 OR substr_count( $meta_key, '_max' ) > 0 ) {
					$pos = strrpos( $meta_key, '_' );
					$option = substr( $meta_key, 0, $pos );
					$option = str_replace( '-range', '', $option );
					$append = substr( $meta_key, $pos + 1 );
					$params['meta'][$option][$append] = $value;
				}
				else {
					$params['meta'][$meta_key] = $value;
				}
			}
		}

		if( !empty( $params['meta'] ) ) {
			$params['meta'] = array_filter( $params['meta'] );
		}

		$args = array(
			'post_type'      => $params['post_type'],
			'posts_per_page' => $params['count'],
		);


		$existing_taxonomies = get_taxonomies( );
		$taxonomies = array();
		foreach( $params as $key => $value ) {
			if( in_array( $key, $existing_taxonomies ) ) {
				$terms = explode( ',', $value );
				$terms = array_map( 'trim', $terms );
				if( !empty( $terms ) AND !empty( $terms[0] ) ) {
					$taxonomies[$key] = $terms;
				}
			}
		}


		if( !empty( $taxonomies ) ) {
			$args['tax_query'] = array();
			foreach( $taxonomies as $taxonomy => $terms ) {
				$args['tax_query'][] = array(
					'taxonomy' => $taxonomy,
					'field'    => 'ID',
					'terms'    => $terms
				);
			}
		}


		foreach( $form_data as $name => $value ) {
			if( $name == 'search' ) {
				$args['s'] = $value;
			}
			elseif( in_array( $name, $taxonomies ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => $name,
					'field' => 'id',
					'terms' => $value
				);
			}
			elseif( substr_count( $name, '_est_meta' ) > 0 ) {
				if( is_array( $value ) AND isset( $value['min'] ) AND isset( $value['max'] ) ) {
					$meta_value = array(  $value['min'], $value['max'] );
					$compare = 'BETWEEN';
					$type = 'NUMERIC';
				}
				else {
					$compare = ( is_array( $value ) ) ? 'IN' : '=';
					$meta_value = $value;
					$type = 'CHAR';
				}
				$args['meta_query'][] = array(
					'key' => $name,
					'value' => $meta_value,
					'type' => $type,
					'compare' => $compare
				);

			}
		}

		if( !empty( $force_taxonomies ) ) {
			$args['tax_query'] = $force_taxonomies;
		}


		$not_in = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_est_show_on_map' AND meta_value = 'hide' ");

		$args['post__not_in'] = $not_in;

		global $wp_query;
		$temp_query = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query( $args );
		$ids = array();
		if( have_posts() ) {
			while( have_posts() ) {
				the_post();
				$ids[] = get_the_ID();
			}
		}
		$wp_query = $temp_query;
		wp_reset_postdata();

		foreach( $results as $key => $result ) {
			if( !in_array( $result->post_id, $ids ) ) {
				unset( $results[$key] );
			}
		}
	}
	else {

		$args = array(
			'post_type'      => 'property',
			'posts_per_page' => -1,
		);

		$not_in = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_est_show_on_map' AND meta_value = 'hide' ");

		$args['post__not_in'] = $not_in;

		global $wp_query;
		$temp_query = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query( $args );
		$ids = array();
		if( have_posts() ) {
			while( have_posts() ) {
				the_post();
				$ids[] = get_the_ID();
			}
		}
		$wp_query = $temp_query;
		wp_reset_postdata();

		foreach( $results as $key => $result ) {
			if( !in_array( $result->post_id, $ids ) ) {
				unset( $results[$key] );
			}
		}

	}


	return $results;

}


function est_get_address( $post_id ) {
	$meta = get_post_meta( $post_id );
	$address = array();

	if( !empty( $meta['_est_meta_zipcode'][0] ) ) {
		$address[] = $meta['_est_meta_zipcode'][0];
	}

	if( !empty( $meta['_est_meta_country'][0] ) ) {
		$address[] = $meta['_est_meta_country'][0];
	}

	if( !empty( $meta['_est_meta_state'][0] ) ) {
		$address[] = $meta['_est_meta_state'][0];
	}

	if( !empty( $meta['_est_meta_city'][0] ) ) {
		$address[] = $meta['_est_meta_city'][0];
	}

	if( !empty( $meta['_est_meta_address'][0] ) ) {
		$address[] = $meta['_est_meta_address'][0];
	}

	$address = implode( ', ', $address );

	return $address;

}

function est_geolocation_xml( $results, $page_id = 0 ) {
	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node);

	foreach( $results as $result ) {
		$node = $dom->createElement("marker");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("name", get_the_title( $result->post_id ) );
		$newnode->setAttribute("address", est_get_address( $result->post_id ) );
		$newnode->setAttribute("lat", $result->lat );
		$newnode->setAttribute("lng", $result->lng );
		$newnode->setAttribute("distance", $result->distance );
		$newnode->setAttribute("html", est_get_marker_content( $result->post_id, $page_id ) );
		$newnode->setAttribute("url", get_permalink( $result->post_id ) );

		$icon = get_post_meta( $result->post_id, '_est_marker', true );
		if( $icon == get_template_directory_uri() . '/images/marker.png') {
			$icon = '';
		}
		$newnode->setAttribute("icon", $icon );
	}

	echo $dom->saveXML();

}


function est_get_marker_content( $post_id, $page_id = 0 ) {


	$html = '<div class="layout-map">';

	$thumbnail_id = get_post_thumbnail_id( $post_id );
	if( !empty( $thumbnail_id ) ) {
		$thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'est_card' );
	}

	$html .= '<a href="'.get_permalink( $post_id ) .'"><img src="' . $thumbnail[0] . '"></a>';
	if( $page_id != 0 ) {
		$field = get_post_meta( $page_id, '_est_field', true );
		if( !empty( $field ) ) {
			$value = get_post_meta( $post_id, $field, true );
			if( !empty( $value ) ) {
				$value = est_customdata_value( $field, $value, array( 'property_id' => $post_id ) );
				$html .= '<span class="custom_field">' . $value . '</span>';
			}
		}
	}

	$html .= '<h1><a href="' . get_permalink( $post_id ) . '">' . get_the_title( $post_id ) . '</a></h1>';

	$html .= '</div>';


	return $html;
}

add_action( 'wp_ajax_load_location_xml', 'load_location_xml' );
add_action( 'wp_ajax_nopriv_load_location_xml', 'load_location_xml' );

function load_location_xml() {
	if( empty( $_POST['form_data'] ) ) {
		$_POST['form_data'] = '';
	}
	if( empty( $_POST['taxonomies'] ) ) {
		$_POST['taxonomies'] = '';
	}

	$results = get_close_properties( $_POST['lat'], $_POST['lng'], $_POST['radius'], $_POST['form_data'], $_POST['taxonomies'] );
	est_geolocation_xml( $results, $_POST['page_id'] );
	die();
}

load_theme_textdomain( THEMENAME, get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable($locale_file) ) {
	require_once($locale_file);
}




include( 'framework/customdata/customdata.php' );

/***********************************************/
/*                 */
/***********************************************/

function est_get_customdata_type_dropdown_options( $current ) {
	$types = array(
		'text' => 'Text Field',
		'textarea' => 'Text Area',
		'dropdown' => 'Dropdown',
		'radio'    => 'Radio Buttons',
		'checkbox' => 'Checkboxes',
		'countries' => 'Country Selector',
		'state'     => 'State Selector'
	);

	$options = array();

	foreach( $types as $key => $name ) {
		$selected = ( $key === $current ) ? 'selected="selected"' : '';
		$options[] = '<option ' . $selected . ' value="' . $key . '">' . $name . '</option>';
	}
	return implode( '', $options );


}



function show_customdata_field( $post, $field) {
	if( function_exists( 'show_customdata_field_' . $field['type'] ) ) {
		call_user_func( 'show_customdata_field_' . $field['type'], $post, $field );
	}
}


function show_customdata_field_text( $post, $field ) {
	$value = get_post_meta( $post->ID, $field['key'], true );
?>
	<input type='text' class='widefat' id='<?php echo $field['key'] ?>' name='<?php echo $field['key'] ?>' value='<?php echo esc_html( $value ) ?>'>

<?php
}


function show_customdata_field_radio( $post, $field ) {
	$value = get_post_meta( $post->ID, $field['key'], true );
	$i=0;
	foreach( $field['options'] as $option ) :
	$checked = ( $option == $value ) ? 'checked="checked"' : '';

?>
	<input <?php echo $checked ?> type='radio' id='<?php echo $field['key'] ?>_<?php echo $i ?>' name='<?php echo $field['key'] ?>' value='<?php echo $option['value'] ?>'><label for='<?php echo $field['key'] ?>_<?php echo $i ?>'><?php echo $option['name'] ?></label><br>
<?php $i++; endforeach ?>

<?php
}



function show_customdata_field_checkbox( $post, $field ) {
	$value = get_post_meta( $post->ID, $field['key'] );
	$i=0;
	foreach( $field['options'] as $option ) :
	$checked = ( !empty( $value ) AND in_array( $option['value'], $value ) ) ? 'checked="checked"' : '';
?>
	<input <?php echo $checked ?> type='checkbox' id='<?php echo $field['key'] ?>_<?php echo $i ?>' name='<?php echo $field['key'] ?>[]' value='<?php echo $option['value'] ?>'><label for='<?php echo $field['key'] ?>_<?php echo $i ?>'><?php echo $option['name'] ?></label><br>
<?php $i++; endforeach ?>

<?php
}


function show_customdata_field_textarea( $post, $field ) {
	$value = get_post_meta( $post->ID, $field['key'], true );
?>
	<textarea class='widefat' id='<?php echo $field['key'] ?>' name='<?php echo $field['key'] ?>'><?php echo $value ?></textarea>

<?php
}


function show_customdata_field_dropdown( $post, $field ) {
	$value = get_post_meta( $post->ID, $field['key'], true );
?>
	<select class='widefat' id='<?php echo $field['key'] ?>' name='<?php echo $field['key'] ?>' >
		<option value=''><?php _e( '-- Select a Value --', THEMENAME ) ?></option>
	<?php
		foreach( $field['options'] as $option ) :
		$selected = ( $value == $option['value'] ) ? 'selected="selected"' : '';
	?>
		<option <?php echo $selected ?> value='<?php echo $option['value'] ?>'><?php echo $option['name'] ?></option>
	<?php endforeach ?>
	</select>

<?php
}


function show_customdata_field_countries( $post, $field ) {
	$value = get_post_meta( $post->ID, $field['key'], true );
?>
	<select class='widefat' id='<?php echo $field['key'] ?>' name='<?php echo $field['key'] ?>' >
	<?php echo bsh_get_country_dropdown_options( $value ) ?>
	</select>

<?php
}


function show_customdata_field_states( $post, $field ) {
	$value = get_post_meta( $post->ID, $field['key'], true );
?>
	<select class='widefat' id='<?php echo $field['key'] ?>' name='<?php echo $field['key'] ?>' >
	<?php echo bsh_get_state_dropdown_options( $value ) ?>
	</select>

<?php
}


function est_customdata_value( $detail, $value, $args = array() ) {
	$customdata = get_option( 'est_customdata' );
	$detailvalue = '';


	if( $detail === 'location' ) {

		$location = array();
		$location_fields = array( '_est_meta_country', '_est_meta_state', '_est_meta_city', '_est_meta_address', '_est_meta_zip_code' );

		$used_fields = get_post_meta( $args['post_id'], '_est_customdata', true );
		$used_location_fields = array();

		foreach( $used_fields as $key => $customdetail ) {
			if( in_array( $key, $location_fields ) AND !empty( $customdetail['show'] ) ) {
				$used_location_fields[] = $key;
			}
		}

		$details = get_post_meta( $args['property_id'] );

		if( in_array( '_est_meta_country', $used_location_fields ) ) {
			if( !empty( $details['_est_meta_country'] ) ) {
				$location[] = est_customdata_value( '_est_meta_country', $details['_est_meta_country'][0] );
			}
		}
		if( in_array( '_est_meta_city', $used_location_fields ) ) {
			if( !empty( $details['_est_meta_city'] ) ) {
				$location[] = est_customdata_value( '_est_meta_city', $details['_est_meta_city'][0] );
			}
		}
		if( in_array( '_est_meta_state', $used_location_fields ) ) {
			if( !empty( $details['_est_meta_state'] ) ) {
				$location[] = est_customdata_value( '_est_meta_state', $details['_est_meta_state'][0] );
			}
		}
		if( in_array( '_est_meta_zip_code', $used_location_fields ) ) {
			if( !empty( $details['_est_meta_zip_code'] ) ) {
				$location[] = est_customdata_value( '_est_meta_zip_code', $details['_est_meta_zip_code'][0] );
			}
		}
		if( in_array( '_est_meta_address', $used_location_fields ) ) {
			if( !empty( $details['_est_meta_address'] ) ) {
				$location[] = est_customdata_value( '_est_meta_address', $details['_est_meta_address'][0] );
			}
		}

		$location = implode( ', ', $location );
		$detailvalue = '<span class="value">' . $location . '</span>';
	}
	else {

		if( isset( $customdata[$detail] ) AND $customdata[$detail]['type'] == 'text' AND is_array( $value ) ) {
			$value = $value[0];
		}

		if( is_array( $value ) ) {

			$detailvalue = array();
			foreach( $value as $item ) {
				$prefix = '';
				$detailvalueelement = '';
				$suffix = '';
				if( !empty( $customdata[$detail]['prefix'] ) ) {
					$display = $customdata[$detail]['prefix'];
					if( function_exists( 'icl_t' ) ) {
						$display = icl_t( 'Estatement - Custom Field Prefixes', $display, $display );
					}
					$prefix = '<span class="unit">' . $display . '</span>';
				}

				if( !empty( $customdata[$detail]['options'] ) AND is_array( $customdata[$detail]['options'] ) ) {
					$name = $item;
					foreach( $customdata[$detail]['options'] as $option ) {
						if( $option['value'] == $item ) {
							$name = $option['name'];
						}
					}
					if( !empty( $name ) ) {
						$display = $name;
						if( function_exists( 'icl_t' ) ) {
							$display = icl_t( 'Estatement - Custom Field Values', $display, $display );
						}

						$detailvalueelement = '<span class="value">' . $display  . '</span>';
					}
				}
				else {
					$item = ( !empty( $customdata[$detail]['format'] ) AND $customdata[$detail]['format'] == 'number' ) ? est_number_format( $item, 2 ) : $item;
					if( !empty( $item ) ) {
						$display = $item;
						if( function_exists( 'icl_t' ) ) {
							$display = icl_t( 'Estatement - Custom Field Values', $display, $display );
						}
						$detailvalueelement = '<span class="value">' . $display . '</span>';
					}
				}

				if( !empty( $customdata[$detail]['suffix'] ) ) {
					$display = $customdata[$detail]['suffix'];
					if( function_exists( 'icl_t' ) ) {
						$display = icl_t( 'Estatement - Custom Field Suffixes', $display, $display );
					}
					$suffix = '<span class="unit">' . $display . '</span>';
				}

				if( !empty( $detailvalueelement ) ) {
					$detailvalue[] = $prefix . $detailvalueelement . $suffix;
				}
			}
			$detailvalue = implode( ', ', $detailvalue );
		}
		else {

			$value = ( !empty( $customdata[$detail]['format'] ) AND $customdata[$detail]['format'] == 'number' ) ? est_number_format( $value, 2 ) : $value;

			if( !empty( $value ) ) {
				if( !empty( $customdata[$detail]['prefix'] ) ) {
					$display = $customdata[$detail]['prefix'];
					if( function_exists( 'icl_t' ) ) {
						$display = icl_t( 'Estatement - Custom Field Prefixes', $display, $display );
					}

					$detailvalue .= '<span class="unit">' . $display . '</span>';
				}

				$display = $value;
				if( function_exists( 'icl_t' ) ) {
					$display = icl_t( 'Estatement - Custom Field Suffixes', $display, $display );
				}

				$detailvalue .= '<span class="value">' . $display . '</span>';

				if( !empty( $customdata[$detail]['suffix'] ) ) {
					$display = $customdata[$detail]['suffix'];
					if( function_exists( 'icl_t' ) ) {
						$display = icl_t( 'Estatement - Custom Field Suffixes', $display, $display );
					}

					$detailvalue .= '<span class="unit">' . $display . '</span>';
				}
			}
		}
	}

	$value_class = '';
	if( isset( $value[0] ) AND !is_array( $value[0] ) ) {
		$value_class = str_replace( '_est_meta_', '', $detail ) . '-' . $value[0];
	}

	$detailvalue = ( $detailvalue == '<span class="value"></span>' OR $detailvalue == '' ) ? '' : $detailvalue;


	if( !empty( $detailvalue ) ) {
		return '<span class="est_value ' . $value_class . '">' . $detailvalue . '</span>';
	}
}

function est_number_format( $value, $decimals = 2 ) {
	$decimal_separator = get_theme_mod( 'decimal_separator' );
	$decimal_separator = ( empty( $decimal_separator ) ) ? '.' : $decimal_separator;

	$thousand_separator = get_theme_mod( 'thousand_separator' );
	$thousand_separator = ( empty( $thousand_separator ) ) ? ',' : $thousand_separator;

	if( substr_count( $value, '.') > 0 ) {
		$value = floatval( $value );
	}
	else {
		$value = intval( $value );
	}
	if( is_float( $value ) ) {
		return number_format( $value, $decimals, $decimal_separator, $thousand_separator );
	}
	else {
		return number_format( $value, 0, $decimal_separator, $thousand_separator );
	}
}


function list_hooked_functions($tag=false){
 global $wp_filter;
 if ($tag) {
  $hook[$tag]=$wp_filter[$tag];
  if (!is_array($hook[$tag])) {
  trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
  return;
  }
 }
 else {
  $hook=$wp_filter;
  ksort($hook);
 }
 echo '<pre>';
 foreach($hook as $tag => $priority){
  echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
  ksort($priority);
  foreach($priority as $priority => $function){
  echo $priority;
  foreach($function as $name => $properties) echo "\t$name<br />";
  }
 }
 echo '</pre>';
 return;
}

if( isset($_GET['location'] )) {
remove_filter( 'wp_head', 'feed_links_extra', 3 );
}


add_action('init', 'si_author_base');
function si_author_base() {
	$base = get_theme_mod( 'author_base' );
	$base = (empty( $base ) ) ? 'agent' : $base;
	global $wp_rewrite;
	$wp_rewrite->author_base = $base;
}
	global $wp_rewrite;




add_action( 'show_user_profile', 'est_profile_fields' );
add_action( 'edit_user_profile', 'est_profile_fields' );

function est_profile_fields( $user ) { ?>

	<h3><?php _e( 'Additional Profile Info', THEMENAME ) ?></h3>
	<table class="form-table">
		<?php $order = ( !empty( $user->order ) ) ? $user->order : '' ?>
		<tr>
			<th><label for='position'><?php _e( 'Order On Agents Page', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="order" id="order" value="<?php echo $order ?>" />
			</td>
		</tr>


		<?php $position = ( !empty( $user->position ) ) ? $user->position : '' ?>
		<tr>
			<th><label for='position'><?php _e( 'Position', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="position" id="position" value="<?php echo $position ?>" />
			</td>
		</tr>

		<?php $facebook_profile = ( !empty( $user->facebook_profile ) ) ? $user->facebook_profile : '' ?>
		<tr>
			<th><label for='facebook_profile'><?php _e( 'Facebook Profile URL', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="facebook_profile" id="facebook_profile" value="<?php echo $facebook_profile ?>" />
			</td>
		</tr>
		<?php $twitter_username = ( !empty( $user->twitter_username ) ) ? $user->twitter_username : '' ?>
		<tr>
			<th><label for='twitter_username'><?php _e( 'Twitter Username', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="twitter_username" id="twitter_username" value="<?php echo $twitter_username ?>" />
			</td>
		</tr>
		<?php $google_profile = ( !empty( $user->google_profile ) ) ? $user->google_profile : '' ?>
		<tr>
			<th><label for='google_profile'><?php _e( 'Google Plus Profile', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="google_profile" id="google_profile" value="<?php echo $google_profile ?>" />
			</td>
		</tr>
		<?php $linkedin_profile = ( !empty( $user->linkedin_profile ) ) ? $user->linkedin_profile : '' ?>
		<tr>
			<th><label for='linkedin_profile'><?php _e( 'Linkedin Profile URL', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="linkedin_profile" id="linkedin_profile" value="<?php echo $linkedin_profile ?>" />
			</td>
		</tr>
		<?php $flickr_profile = ( !empty( $user->flickr_profile ) ) ? $user->flickr_profile : '' ?>
		<tr>
			<th><label for='flickr_profile'><?php _e( 'Flickr Profile URL', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="flickr_profile" id="flickr_profile" value="<?php echo $flickr_profile ?>" />
			</td>
		</tr>
		<?php $pinterest_profile = ( !empty( $user->pinterest_profile ) ) ? $user->pinterest_profile : '' ?>
		<tr>
			<th><label for='pinterest_profile'><?php _e( 'Pinterest Profile URL', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="pinterest_profile" id="pinterest_profile" value="<?php echo $pinterest_profile ?>" />
			</td>
		</tr>
		<?php $phone_number = ( !empty( $user->phone_number ) ) ? $user->phone_number : '' ?>
		<tr>
			<th><label for='phone_number'><?php _e( 'Phone Number', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="phone_number" id="phone_number" value="<?php echo $phone_number ?>" />
			</td>
		</tr>

		<?php $address = ( !empty( $user->address ) ) ? $user->address : '' ?>
		<tr>
			<th><label for='address'><?php _e( 'Address', THEMENAME ) ?></label></th>
			<td>
				<input type="text" class='regular-text' name="address" id="address" value="<?php echo $address ?>" />
			</td>
		</tr>

	</table>


<?php


}


add_action( 'personal_options_update', 'est_save_profile_fields' );
add_action( 'edit_user_profile_update', 'est_save_profile_fields' );

function est_save_profile_fields( $user_id ) {

	$_POST['order'] = ( empty( $_POST['order'] ) ) ? '' : $_POST['order'];
	update_user_meta( $user_id, 'order', $_POST['order'] );

	$_POST['facebook_profile'] = ( empty( $_POST['facebook_profile'] ) ) ? '' : $_POST['facebook_profile'];
	update_user_meta( $user_id, 'facebook_profile', $_POST['facebook_profile'] );

	$_POST['twitter_username'] = ( empty( $_POST['twitter_username'] ) ) ? '' : $_POST['twitter_username'];
	update_user_meta( $user_id, 'twitter_username', $_POST['twitter_username'] );

	$_POST['linkedin_profile'] = ( empty( $_POST['linkedin_profile'] ) ) ? '' : $_POST['linkedin_profile'];
	update_user_meta( $user_id, 'linkedin_profile', $_POST['linkedin_profile'] );

	$_POST['flickr_profile'] = ( empty( $_POST['flickr_profile'] ) ) ? '' : $_POST['flickr_profile'];
	update_user_meta( $user_id, 'flickr_profile', $_POST['flickr_profile'] );

	$_POST['pinterest_profile'] = ( empty( $_POST['pinterest_profile'] ) ) ? '' : $_POST['pinterest_profile'];
	update_user_meta( $user_id, 'pinterest_profile', $_POST['pinterest_profile'] );

	$_POST['phone_number'] = ( empty( $_POST['phone_number'] ) ) ? '' : $_POST['phone_number'];
	update_user_meta( $user_id, 'phone_number', $_POST['phone_number'] );

	$_POST['google_profile'] = ( empty( $_POST['google_profile'] ) ) ? '' : $_POST['google_profile'];
	update_user_meta( $user_id, 'google_profile', $_POST['google_profile'] );


	$_POST['position'] = ( empty( $_POST['position'] ) ) ? '' : $_POST['position'];
	update_user_meta( $user_id, 'position', $_POST['position'] );

	$_POST['address'] = ( empty( $_POST['address'] ) ) ? '' : $_POST['address'];
	update_user_meta( $user_id, 'address', $_POST['address'] );


}









add_action( 'show_user_profile', 'est_custom_profile_fields' );
add_action( 'edit_user_profile', 'est_custom_profile_fields' );

function est_custom_profile_fields( $user ) {
	$fields = get_option( 'est_profilefields' );
	if( !empty( $fields ) ) :
?>
	<h3><?php _e( 'Estatement Profile Info', THEMENAME ) ?></h3>
<?php
	foreach( $fields as $field ) :
	$key = $field['key']
?>
	<table class="form-table">
		<?php $value = ( !empty( $user->$key ) ) ? $user->$key : '' ?>
		<tr>
			<th><label for='<?php echo $key ?>'><?php echo $field['name'] ?></label></th>
			<td>
				<?php if( $field['type'] == 'dropdown' ) : ?>
					<select name="<?php echo $key ?>" id="<?php echo $key ?>">
						<option value=''><?php _e( '-- Select a Value --', THEMENAME ) ?>
						<?php
							if( !empty( $field['options']) ) {
							foreach( $field['options'] as $option ) {
								$selected = ( $value == $option['value'] ) ? 'selected="selected"' : '';
								echo '<option '.$selected.' value="'.$option['value'].'">'.$option['name'].'</option>';
							}}
						?>
					</select>
				<?php elseif( $field['type'] == 'textarea' ) : ?>
					<textarea rows='5' cols='30' class='regular-text' name="<?php echo $key ?>" id="<?php echo $key ?>"><?php echo $value ?></textarea>
				<?php elseif( $field['type'] == 'checkbox' ) : ?>
						<?php
							if( !empty( $field['options']) ) {
							$i=1;
							foreach( $field['options'] as $option ) {
								$checked = ( is_array( $value ) and in_array( $option['value'], $value ) ) ? 'checked="checked"' : '';
								echo '<input '.$checked.' type="checkbox" name="'. $key .'[]" id="'.$key.'-'.$i.'" value="'.$option['value'].'"> <label for="'.$key.'-'.$i.'">'.$option['name'].'</label><br>';
								$i++;
							}}
						?>
					</select>
				<?php elseif( $field['type'] == 'radio' ) : ?>
						<?php
							if( !empty( $field['options']) ) {
							$i=1;
							foreach( $field['options'] as $option ) {
								$checked = ( $option['value'] == $value ) ? 'checked="checked"' : '';
								echo '<input '.$checked.' type="radio" name="'. $key .'" id="'.$key.'-'.$i.'" value="'.$option['value'].'"> <label for="'.$key.'-'.$i.'">'.$option['name'].'</label><br>';
								$i++;
							}}
						?>
					</select>
				<?php else : ?>
					<input type="text" class='regular-text' name="<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $value ?>" />
				<?php endif ?>
			</td>
		</tr>


	</table>


<?php
endforeach;
endif;
}





add_action( 'personal_options_update', 'est_custom_profile_fields_save' );
add_action( 'edit_user_profile_update', 'est_custom_profile_fields_save' );

function est_custom_profile_fields_save( $user_id ) {

	$fields = get_option('est_profilefields');
	if( !empty( $fields ) ) {
	foreach( $fields as $field ) {
		$key = $field['key'];
		if( empty( $_POST[$key] ) ) {
			delete_user_meta( $user_id, $key);
		}
		else {
			update_user_meta( $user_id, $key, $_POST[$key] );
		}
	}
	}


}







add_action( 'admin_init', 'est_custom_roles' );
function est_custom_roles() {

	$agent = add_role( 'agent', 'Agent' );
	if( $agent != null ) {

		$author_role = get_role( 'author' );
		$author_caps = array_keys( $author_role->capabilities );

		$agent_role = get_role( 'agent' );
		foreach( $author_caps as $cap ) {
			$agent_role->add_cap( $cap );
		}
	}


}


function est_get_agent_properties( $agent_id ) {
	global $wpdb;
	$property_author = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE post_type = 'property' AND post_status='publish' AND post_author = $agent_id " );
	$property_agent = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_est_agent' AND meta_value = $agent_id " );

	$properties = array_merge( $property_author, $property_agent );
	$properties = array_unique( $properties );
	return $properties;

}


function get_args_from_search() {
	$args = array();
	$taxonomies = get_taxonomies( array( 'object_type' => array( 'property' ) ) );
	$_GET = array_filter( $_GET );
	foreach( $_GET as $name => $value ) {
		if( $name == 'search' ) {
			$args['s'] = $value;
		}
		elseif( in_array( $name, $taxonomies ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => $name,
				'field' => 'id',
				'terms' => $value
			);
		}
		elseif( substr_count( $name, '_est_meta' ) > 0 ) {
			if( is_array( $value ) AND isset( $value['min'] ) AND isset( $value['max'] ) ) {
				$meta_value = array(  $value['min'], $value['max'] );
				$compare = 'BETWEEN';
				$type = 'NUMERIC';
			}
			else {
				$compare = ( is_array( $value ) ) ? 'IN' : '=';
				$meta_value = $value;
				$type = 'CHAR';
			}
			$args['meta_query'][] = array(
				'key' => $name,
				'value' => $meta_value,
				'type' => $type,
				'compare' => $compare
			);

		}
	}

	return $args;

}

/***********************************************/
/*                  Bookings                   */
/***********************************************/

function calculate_booking_price( $property_id, $guests, $start, $end ) {

	// Price type ( daily or per property )
	$price_type = get_post_meta( $property_id, '_est_price_type', true );
	$price_type = ( empty( $price_type ) ) ? 'night' : $price_type;

	// Date difference
	$start = Carbon::createFromFormat( 'Y-m-d', $start );
	$end = Carbon::createFromFormat('Y-m-d', $end );
	$days = $start->diffInDays( $end, false );
	$weeks = floor( $days / 7 );
	$months = floor( $days / 30 );

	// Calculate Price Used
	$price_length = '';
	if( $months > 0 ) {
		$price_length = 'monthly';
	}
	elseif( $months == 0 AND $weeks > 0 ) {
		$price_length = 'weekly';
	}
	else {
		$price_length = 'daily';
	}

	// Get Prices
	$prices = get_property_price_list( $property_id, $price_length, $start, $end );

	return array_sum( $prices );

}


function get_property_price_list( $property_id, $price_length = '', $start = '', $end = '' ) {

	// Start and end dates
	$start = ( empty( $start ) ) ? Carbon::createFromFormat( 'Y-m-d', date( 'Y-m' ) . '-01' ) : $start;
	$end = ( empty( $end ) ) ? Carbon::createFromFormat( 'Y-m-d', date( 'Y-m-d', mktime( 0,0,0, date('n') + 1, 0, date('Y') ) ) ) : $end;

	// Get Price Lengths
	$prices = array();
	if( empty( $price_length ) ) {
		$prices['daily'] = get_post_meta( $property_id, '_est_rent_daily_price', true );
		$prices['weekly']  = get_post_meta( $property_id, '_est_rent_weekly_price', true );
		$prices['monthly']  = get_post_meta( $property_id, '_est_rent_monthly_price', true );
	}
	else {
		$prices[$price_length]  = get_post_meta( $property_id, '_est_rent_' . $price_length . '_price', true );
	}


	$seasonal_pricing = get_post_meta( $property_id, '_est_rent_seasonal_price', true );

	if( !empty( $seasonal_pricing ) ) {
		$seasonlist = array();
		foreach( $seasonal_pricing as $season ) {
			$season_start = Carbon::createFromFormat( 'Y-m-d', $start->format('Y') . '-' . $season['start'] );
			$season_end = Carbon::createFromFormat('Y-m-d', $start->format('Y') . '-' . $season['end'] );

			$days = $season_start->diffInDays( $season_end, false );
			$days = ( $days < 0 ) ? 365 - abs( $days ) : $days;


			$current_date = $season_start;
			for( $i = 0; $i <= $days; $i++ ) {
				$key = $current_date->format( 'm-d' );

				if( empty( $price_length ) ) {
					$value = $season['price'];
				}
				else {
					$value = $season['price'][$price_length];
				}

				$seasonlist[$key] = $value;
				$current_date->addDay();
			}
		}
	}
	$season_dates = array_keys( $seasonlist );

	$days = $start->diffInDays( $end, false );
	$pricelist = array();
	$current_date = $start;
	for( $i = 0; $i <= $days; $i++ ) {
		$key = $current_date->format( 'm-d' );

		if( empty( $price_length ) ) {
			if( in_array( $key, $season_dates ) ) {
				$seasonlist[$key];
			}
			else {
				$value = $prices;
			}
		}
		else {
			if( in_array( $key, $season_dates ) ) {
				$value = $seasonlist[$key];
			}
			else {
				$value = $prices[$price_length];
			}
		}

		if( !empty( $price_length ) ) {
			if( $price_length == 'weekly' ) {
				$value = round( $value / 7 );
			}
			elseif( $price_length == 'monthly' ) {
				$value = round( $value / 30 );
			}
		}

		$pricelist[$key] = $value;
		$current_date->addDay();
	}

	return $pricelist;

}



if( is_admin() AND function_exists( 'icl_register_string' )) {
	$customdata = get_option( 'est_customdata' );
	foreach( $customdata as $field ) {
		icl_register_string( 'Estatement - Custom Field Names' , $field['name'], $field['name'] );
		if( !empty( $field['prefix'] ) ) {
			icl_register_string( 'Estatement - Custom Field Prefixes' , $field['prefix'], $field['prefix'] );
		}
		if( !empty( $field['suffix'] ) ) {
			icl_register_string( 'Estatement - Custom Field Suffixes' , $field['suffix'], $field['suffix'] );
		}
		if( !empty( $field['options'] ) ) {
			foreach( $field['options'] as $option ) {
				icl_register_string( 'Estatement - Custom Field Values' , $option['name'], $option['name'] );
			}
		}
	}

	$taxonomies = get_option( 'est_taxonomies' );
	foreach( $taxonomies as $taxonomy ) {
		foreach( $taxonomy['labels'] as $type => $value ){
			icl_register_string( 'Estatement - Custom Taxonomies' , $value, $value );
		}
	}

}



add_action( 'save_post', 'est_update_bookings' );
add_action( 'update_booking_dates', 'est_update_bookings', 10, 2 );

function est_update_bookings( $post_id ) {
	if( get_post_type( $post_id ) == 'booking' AND get_post_status( $post_id ) != 'trash' ) {
		$start = get_post_meta( $post_id, '_est_start', true );
		$end = get_post_meta( $post_id, '_est_end', true );

		if( !empty( $_POST['_est_start'] ) ) {
			$start = $_POST['_est_start'];
		}

		if( !empty( $_POST['_est_end'] ) ) {
			$end = $_POST['_est_end'];
		}


		$property_id = get_post_meta( $post_id, '_est_property_id', true );

		if( !empty( $start ) AND !empty( $end ) AND !empty( $property_id ) ) {
			$start = Carbon::createFromFormat( 'Y-m-d', $start );
			$end = Carbon::createFromFormat( 'Y-m-d', $end );
			$current = $start;
			$end = $end;
			$dates = array();

			while( $current->lt( $end ) ) {
				$dates[] = $start->toDateString();
				$current->addDay();
			}

			$booked_dates = get_post_meta( $property_id, '_est_bookings', true );
			$booked_dates[ $post_id ] = $dates;
			update_post_meta( $property_id, '_est_bookings', $booked_dates );
		}
	}
}

add_action( 'before_delete_post', 'est_delete_booking_dates' );
add_action( 'pending_to_trash', 'est_delete_booking_dates' );
add_action( 'draft_to_trash', 'est_delete_booking_dates' );
add_action( 'publish_to_trash', 'est_delete_booking_dates' );
function est_delete_booking_dates( $post ){
	$post_id = ( is_numeric( $post ) ) ? $post : $post->ID;
    global $post_type;
    $post_type = ( empty( $post_type ) ) ? get_post_type( $post_id ) : $post_type;

    if ( $post_type == 'booking' ) {
		$property_id = get_post_meta( $post_id, '_est_property_id', true );
		$booked_dates = get_post_meta( $property_id, '_est_bookings', true );
		if( !empty( $booked_dates[$post_id] ) ) {
			unset( $booked_dates[$post_id] );
		}
		$check = update_post_meta( $property_id, '_est_bookings', $booked_dates );
		$test = get_post_meta( $property_id, '_est_bookings', true );
    }

}


add_filter('manage_booking_posts_columns', 'est_booking_table_head');
function est_booking_table_head( $defaults ) {
    $defaults['property'] = 'Property';
    $defaults['guests'] = 'Guests';
    $defaults['arrival'] = 'Arrival';
    $defaults['departure'] = 'Departure';
    return $defaults;
}


add_action('manage_booking_posts_custom_column', 'est_booking_table_content', 10, 2);

function est_booking_table_content( $column_name, $post_id ) {
    if ($column_name == 'property') {
		$property_id = get_post_meta( $post_id, '_est_property_id', true );
		$property = '<a href="' . get_permalink( $property_id ) . '">' . get_the_title( $property_id ) . '</a>';
		echo $property;
    }
    if ($column_name == 'guests') {
		$guests = get_post_meta( $post_id, '_est_guests', true );
		echo $guests;
    }

    if ($column_name == 'arrival') {
		$start = get_post_meta( $post_id, '_est_start', true );
		echo $start;
    }

    if ($column_name == 'departure') {
		$end = get_post_meta( $post_id, '_est_end', true );
		echo $end;
    }

}


add_filter( 'manage_edit-booking_sortable_columns', 'est_booking_table_sorting' );
function est_booking_table_sorting( $columns ) {
	$columns['property'] = 'property';
	$columns['guests'] = 'guests';
	$columns['arrival'] = 'arrival';
	$columns['departure'] = 'departure';
	return $columns;
}


add_action( 'restrict_manage_posts', 'est_booking_table_filtering' );
function est_booking_table_filtering() {
	$screen = get_current_screen();
	global $wp_query;
	if ( $screen->post_type == 'booking' ) {
		$properties = get_property_dropdown_options();
		echo '<select style="width:120px;" name="property_id">';
			echo '<option value="">All Properties</option>';
			foreach( $properties as $value => $name ) {
				$selected = ( !empty( $_GET['property_id'] ) AND $_GET['property_id'] == $value ) ? 'selected="selected"' : '';
				echo '<option ' . $selected . ' value="' . $value . '">' . $name . '</option>';
			}
		echo '</select>';

		$arrivals_start = ( !empty( $_GET['arrivals_min'] ) ) ? $_GET['arrivals_min'] : '';
		echo '<input type="text" style="width:84px;" placeholder="Arrivals From:" name="arrivals_min" value="' . $arrivals_start . '">';

		$arrivals_end = ( !empty( $_GET['arrivals_max'] ) ) ? $_GET['arrivals_max'] : '';
		echo '<input type="text" style="width:84px;" placeholder="Arrivals Until:" name="arrivals_max" value="' . $arrivals_end . '">';

		$departures_start = ( !empty( $_GET['departures_min'] ) ) ? $_GET['departures_min'] : '';
		echo '<input type="text" style="width:100px;" placeholder="Departures From:" name="departures_min" value="' . $departures_start . '">';

		$departures_end = ( !empty( $_GET['departures_max'] ) ) ? $_GET['departures_max'] : '';
		echo '<input type="text" style="width:100px;" placeholder="Departures Until:" name="departures_max" value="' . $departures_end . '">';
	}
}

add_filter( 'parse_query','est_booking_table_filter' );
function est_booking_table_filter( $query ) {
	if( is_admin() AND $query->query['post_type'] == 'booking' ) {
		$qv = &$query->query_vars;
		$qv['meta_query'] = array();

		if( !empty( $_GET['property_id'] ) ) {
			$qv['meta_query'][] = array(
				'field' => '_est_property_id',
				'value' => $_GET['property_id'],
				'compare' => '='
			);
		}

		if( !empty( $_GET['arrivals_min'] ) ) {
			$qv['meta_query'][] = array(
				'field' => '_est_start',
				'value' => $_GET['arrivals_min'],
				'compare' => '>=',
				'type' => 'DATE'
			);
		}

		if( !empty( $_GET['arrivals_max'] ) ) {
			$qv['meta_query'][] = array(
				'field' => '_est_start',
				'value' => $_GET['arrivals_max'],
				'compare' => '<=',
				'type' => 'DATE'
			);
		}

		if( !empty( $_GET['departures_min'] ) ) {
			$qv['meta_query'][] = array(
				'field' => '_est_end',
				'value' => $_GET['departures_min'],
				'compare' => '>=',
				'type' => 'DATE'
			);
		}

		if( !empty( $_GET['departures_max'] ) ) {
			$qv['meta_query'][] = array(
				'field' => '_est_end',
				'value' => $_GET['departures_max'],
				'compare' => '<=',
				'type' => 'DATE'
			);
		}
	}
}

include( 'framework/booking/booking.php' );

add_action( 'wp_ajax_get_bookings_for_calendar', 'est_get_bookings_for_calendar' );
add_action( 'wp_ajax_norpiv_get_bookings_for_calendar', 'est_get_bookings_for_calendar' );

function est_get_bookings_for_calendar() {

$start_time = date( 'Y-m-d H:i:s' );

$args = array(
	'posts_per_page' => -1,
	'post_type' => 'booking',
	'post_status' => 'publish',
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => '_est_start',
			'value' => $start_time,
			'compare' => '>='
		),
	)
);


global $wp_query;
$wp_query = null;
$wp_query = new WP_Query( $args );

$data = array();


while( have_posts() ) { the_post();

	$property = get_post_meta( get_the_ID(), '_est_property_id', true );
	$title = get_the_title( $property );
	$title = str_replace( '&#8217;', "'", $title );

	$data[] = array(
		'id' => get_the_ID(),
		'title' => $title,
		'start' => get_post_meta( get_the_ID(), '_est_start', true ),
		'end' => get_post_meta( get_the_ID(), '_est_end', true ),
		'allDay' => true
	);

}

echo json_encode( $data );
die();

}


add_action( 'wp_ajax_action_booking', 'est_action_booking' );
add_action( 'wp_ajax_nopriv_action_booking', 'est_action_booking' );
function est_action_booking() {

	$details = array(
		'_est_name' => $_POST['_est_name'],
		'_est_email' => $_POST['_est_email'],
		'_est_phone' => $_POST['_est_phone']
	);

	$booking = new BonsaiBooking( $_POST['_est_property_id'], $_POST['_est_guests'], $_POST['_est_start'], $_POST['_est_end'], $details );

	$booking_id = $booking->insertBooking();

	$redirect = $_POST['redirect']. '?_est_property_id=' . $_POST['_est_property_id'] . '&est_success=true';



	est_send_booking_emails( $booking_id, $_POST );


	header( 'Location: ' . $redirect );
}



function est_send_booking_emails( $booking_id, $data ) {
	$url = get_permalink( $data['_est_property_id'] );
	$title = get_the_title( $data['_est_property_id'] );


	if( !empty( $data['n'] ) ) {
		$data['_est_name'] = $data['n'];
	}

	if( !empty( $data['p'] ) ) {
		$data['_est_phone'] = $data['p'];
	}

	if( !empty( $data['e'] ) ) {
		$data['_est_email'] = $data['e'];
	}



	$recipients = get_post_meta( $data['booking_page'], '_est_recipients', true );
	$recipients = ( empty( $recipients ) ) ? array() : $recipients;
	if( in_array( 'booker', $recipients ) ) {

		/* Email to the Booker */

		$confirmation_subject = get_post_meta( $data['_est_property_id'], '_est_booking_email_subject', true );
		$confirmation_subject = ( empty( $confirmation_subject ) ) ? get_theme_mod( 'booking_email_subject' ) : $confirmation_subject;

		$confirmation_message = get_post_meta( $data['_est_property_id'], '_est_booking_email_message', true );
		$confirmation_message = ( empty( $confirmation_message ) ) ? get_theme_mod( 'booking_email_message' ) : $confirmation_message;

		$confirmation_message = str_replace( array( '!title', '!url' ), array( $title, $url ), $confirmation_message );

		$booker = array(
			'subject'  => $confirmation_subject,
			'message'  => $confirmation_message,
			'email'    => $data['_est_email']
		);


$from_mail = get_theme_mod( 'contact_email' );
    $from_mail = ( empty( $from_mail ) ) ? get_option( 'admin_email' ) : $from_mail;

    $headers = 'From: '.get_bloginfo().' <'.$from_mail.'>' . "\r\n";

add_filter( 'wp_mail_content_type', 'set_html_content_type' );

		@wp_mail( $booker['email'], $booker['subject'], $booker['message'], $headers );
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

	}

	/* Email to the Admin and Agents */

	$notification_subject = __( 'A booking has been made', THEMENAME );



	$notification_message = '
		Someone has just made a booking, here are the details:<br>

		<h3>Booking Details</h3>
		<strong>' . __( 'Property', THEMENAME ) . ':</strong> <a href="' . $url . '">' . $title . '</a><br>
		<strong>' . __( 'Arrival', THEMENAME ) . ':</strong> ' . date( 'F jS, Y', strtotime( $data['_est_start'] ) ) . '<br>
		<strong>' . __( 'Departure', THEMENAME ) . ':</strong> ' . date( 'F jS, Y', strtotime( $data['_est_end'] ) ) . '<br>
		<strong>' . __( 'Guests', THEMENAME ) . ':</strong> ' . $data['_est_guests'] . '<br>

		<hr>

		<h3>Contact Details</h3>
		<strong>' . __( 'Name', THEMENAME ) . ':</strong> ' . $data['_est_name'] . '<br>
		<strong>' . __( 'Email', THEMENAME ) . ':</strong> ' . $data["_est_email"] . '<br>
		<strong>' . __( 'Phone', THEMENAME ) . ':</strong> ' . $data["_est_phone"] . '<br>

		<hr>

		<a href="' . admin_url( 'post.php?post=' . $booking_id . '&action=edit' ) . '">Click here</a> to view this booking on the website.
	';

	$notification = array(
		'subject'  => $notification_subject,
		'message'  => $notification_message,
		'email'    => get_option( 'admin_email' )
	);

	if( in_array( 'admin', $recipients ) ) {
$from_mail = get_theme_mod( 'contact_email' );
    $from_mail = ( empty( $from_mail ) ) ? get_option( 'admin_email' ) : $from_mail;
add_filter( 'wp_mail_content_type', 'set_html_content_type' );

    $headers = 'From: '.get_bloginfo().' <'.$from_mail.'>' . "\r\n";		@wp_mail( $notification['email'], $notification['subject'], $notification['message'], $headers );
	}

	if( in_array( 'agents', $recipients ) ) {

		$agents = get_post_meta( $data['_est_property_id'], '_est_agent');
		if( !empty( $agents ) ) {
			foreach( $agents as $user_id ) {
				$email = get_the_author_meta( 'user_email', 	$user_id );
$from_mail = get_theme_mod( 'contact_email' );
    $from_mail = ( empty( $from_mail ) ) ? get_option( 'admin_email' ) : $from_mail;

    $headers = 'From: '.get_bloginfo().' <'.$from_mail.'>' . "\r\n";				@wp_mail( $email, $notification['subject'], $notification['message'], $headers );

			}
		}

	}

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

}



add_action( 'wp_ajax_get_booking_prices', 'est_action_get_booking_prices' );
add_action( 'wp_ajax_nopriv_get_booking_prices', 'est_action_get_booking_prices' );

function est_action_get_booking_prices() {
	$currency = get_post_meta( $_POST['_est_property_id'], '_est_rent_currency', true );
	$currency_position = get_post_meta( $_POST['_est_property_id'], '_est_rent_currency_position', true );

	$_POST['_est_guests'] = ( empty( $_POST['_est_guests'] ) ) ? 1 : $_POST['_est_guests'];

	if( empty( $_POST['_est_end'] ) OR empty( $_POST['_est_start'] ) ) {
		$response['price_per_night'] = est_get_amount( 0, $currency, $currency_position );
		$response['total_price'] = est_get_amount( 0, $currency, $currency_position );
	}
	else {
		$booking = new BonsaiBooking( $_POST['_est_property_id'], $_POST['_est_guests'], $_POST['_est_start'], $_POST['_est_end'] );

		$response['price_per_night'] = est_get_amount( $booking->calculatePricePerNight(), $currency, $currency_position );
		$response['total_price'] = est_get_amount( $booking->calculateTotalPrice(), $currency, $currency_position );
	}

	echo json_encode( $response );
	die();
}

function get_property_bookings( $property_id ) {

	$booking_dates = get_post_meta( $property_id, '_est_bookings', true );
	$bookings = array();

	if( !empty( $booking_dates ) ) {
		foreach( $booking_dates as $dates ) {
			$bookings = array_merge( $bookings, $dates );
		}
	}

	return $bookings;
}

function get_property_bookings_for_calendar( $property_id ) {
	$bookings = get_property_bookings( $property_id );
	$booking_dates = array();
	foreach( $bookings as $date ){
		$booking_dates[] = '"' . $date . '"';
	}
	$booking_dates = '[' . implode( ',', $booking_dates ) . ']';
	return $booking_dates;
}


function est_get_page_template_dropdown( $template ) {
	global $wpdb;
	$pages = $wpdb->get_results( "SELECT ID, post_title FROM $wpdb->posts WHERE ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_page_template' AND meta_value = '$template' ) " );
	$options = array();
	if( !empty( $pages ) ) {
		foreach( $pages as $page ) {
			$options[$page->ID] = $page->post_title;
		}
	}

	return $options;

}

function est_get_amount( $value, $currency, $position ) {
	if( $position == 'before' ) {
		$output = '<span class="unit">' . $currency . '</span><span class="value">' . number_format( $value ) . '</span>';
	}
	else {
		$output = '<span class="value">' . number_format( $value ) . '</span><span class="unit">' . $currency . '</span>';
	}

	return $output;
}

if( !empty( $_POST ) AND !empty( $_POST['ipn_track_id'] ) ) {
	est_intercept_ipn();
	die();
}




function est_intercept_ipn() {
	$data = wp_parse_args( $_POST['custom'] );
	$data['_est_email'] = $_POST['payer_email'];
	$details = array(
		'_est_name' => $data['n'],
		'_est_email' => $_POST['e'],
		'_est_phone' => $data['p']
	);

	$booking = new BonsaiBooking( $data['_est_property_id'], $data['_est_guests'], $data['_est_start'], $data['_est_end'], $details );

	if( !empty( $_POST['e'] ) ) {
		$_POST['_est_email'] = $_POST['e'];
	}

	$booking_id = $booking->insertBooking( $_POST );


	est_send_booking_emails( $booking_id, $data );


}


add_action( 'wp_ajax_nopriv_est_login', 'est_login' );
function est_login() {
	global $wpdb;
	$creds = array();
	$creds['user_login'] = $_POST['user_login'];
	$creds['user_password'] = $_POST['user_pass'];
	$creds['remember'] = false;

	$user_id = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE user_login = '".$_POST['user_login']."' " );

	$user_activation = $wpdb->get_var( "SELECT meta_value FROM $wpdb->usermeta WHERE user_id = $user_id AND meta_key = 'activation_key' "  );

	if( !empty( $user_activation ) ) {
		header( 'Location: ' . get_permalink( $_POST['page_id'] ) . '?est_error=activation' );
		exit();
	}


	$user = wp_signon( $creds, false );

	if ( is_wp_error($user) ) {
		header( 'Location: ' . get_permalink( $_POST['page_id'] ) . '?est_error=login' );
	}
	else {
		$redirect = get_post_meta( $_POST['page_id'], '_est_login_redirect', true );
		$redirect = ( empty( $redirect ) ) ? site_url() : $redirect;
		header( 'Location:' . $redirect );
	}

}

add_action( 'wp_ajax_est_login', 'est_login_already_logged_in' );
function est_login_already_logged_in() {
	header( 'Location: ' . get_permalink( $_POST['page_id'] ) . '?est_error=loggedin' );
}



add_action( 'wp_ajax_nopriv_est_forgot', 'est_forgot_password' );
add_action( 'wp_ajax_est_forgot', 'est_forgot_password' );
function est_forgot_password() {
	global $wpdb;
	$activation_key = substr( sha1( time() . $_POST['user_email'] ), 1,12 );
	$wpdb->update(
		$wpdb->users,
		array(
			'user_activation_key' => $activation_key,
		),
		array( 'user_email' => $_POST['user_email'] ),
		array(
			'%s'
		),
		array( '%s' )
	);

	$user_id = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE user_email = '".$_POST['user_email']."' " );
	delete_user_meta( $user_id, 'activation_key' );


	$email_subject = get_post_meta( $_POST['page_id'], '_est_forgot_email_subject', true );
	$email_message = get_post_meta( $_POST['page_id'], '_est_forgot_email_message', true );

	$link = get_permalink( $_POST['page_id'] ) . '?est_action=reset_password&key=' . $activation_key;
	$email_message .= '<p><a href="' . $link . '">' . $link . '</a></p>';
$from_mail = get_theme_mod( 'contact_email' );
    $from_mail = ( empty( $from_mail ) ) ? get_option( 'admin_email' ) : $from_mail;

    $headers = 'From: '.get_bloginfo().' <'.$from_mail.'>' . "\r\n";
add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	$mail = wp_mail( $_POST['user_email'], $email_subject, $email_message, $headers );
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
	header( 'Location: ' . get_permalink( $_POST['page_id'] ) . '?est_action=forgot_sent' );
	die();

}



function bsh_reset_password( $user, $page_id ) {
	global $wpdb;

	$new_pass = time() . $user->ID . $user->user_email . $user->user_login . time();
	$new_pass = sha1( $new_pass );
	$new_pass = substr( $new_pass, 3,12 );
	$data['ID'] = $user->ID;
	$data['user_activation_key'] = '';
	$data['user_pass'] = $new_pass;
	wp_update_user( $data );

	$email_subject = get_post_meta( $page_id, '_est_password_reset_subject', true );
	$email_message = get_post_meta( $page_id, '_est_password_reset_message', true );

	if( substr_count( $email_message, '@password@' ) > 0 ) {
		$email_message = str_replace( '@password@', $new_pass , $email_message );
	}
	else {
		$email_message .= '<p><strong>'.$new_pass.'</strong></p>';
	}
add_filter( 'wp_mail_content_type', 'set_html_content_type' );

	wp_mail( $user->user_email, $email_subject, $email_message );
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

}


function bsh_get_taxonomies_array() {
	$data = get_option( 'est_taxonomies' );

	$options = array();
	foreach( $data as $taxonomy => $details ) {
		$options[$taxonomy] = $details['labels']['name'];
	}

	return $options;
}


function get_filter_content( $args ) {
	global $options, $details, $search, $wp_query, $post;

	$temp_query = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query( $args );

	echo "<div id='propertyFilter'>";
	echo "<div id='fiterDetails' style='display:none'>" . json_encode( $details ) . "</div>";
	echo "<div id='fiterSearch' style='display:none'>" . json_encode( $search ) . "</div>";
	echo "<div id='fiterOptions' style='display:none'>" . json_encode( $options ) . "</div>";
	echo "<div id='filterForm' style='display:none'></div>";
	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
			get_template_part( 'layout-property-filter' );
		}
	}
	else {
		?>

			<div id='filterNoResults' style='margin-top:22px'>
				<h1><?php echo get_post_meta( $_POST['page_id'], '_est_no_results_title', true ) ?></h1>
				<p><?php echo get_post_meta( $_POST['page_id'], '_est_no_results_message', true ) ?></p>
			</div>

		<?php
	}
	echo "</div>";
	echo "<div class='mt22'>";
	bsh_pagination();
	echo "</div>";

	$wp_query = $temp_query;
	wp_reset_postdata();
}

add_action( 'wp_ajax_est_get_filter_content', 'est_get_filter_content' );
add_action( 'wp_ajax_nopriv_est_get_filter_content', 'est_get_filter_content' );

function est_get_filter_content() {
	global $options, $details, $search;
	$args = json_decode( stripslashes($_POST['args'] ), true );
	$options = json_decode( stripslashes($_POST['options'] ), true );
	$details = json_decode( stripslashes($_POST['details'] ), true );
	$search = json_decode( stripslashes($_POST['search'] ), true );
	$form =  json_decode( stripslashes($_POST['form'] ), true );

	if( !empty( $form ) ) {
		$params = array();
		foreach( $form as $param ) {
			$param['name'] = str_replace( '[]', '', $param['name']);
			if( isset( $params[$param['name']] ) ) {
				$params[$param['name']]['values'][] = $param['value'];
			}
			else {
				$params[$param['name']]['values'] = array( $param['value'] );
			}

			if( substr_count( $param['name'], '[min]' ) ) {
				$name = str_replace( '[min]', '', $param['name']);
				$params[$name]['min'] = $param['value'];
				unset( $params[$param['name']] );
			}
			if( substr_count( $param['name'], '[max]' ) ) {
				$name = str_replace( '[max]', '', $param['name']);
				$params[$name]['max'] = $param['value'];
				unset( $params[$param['name']] );
			}

			if( $params[$param['name']] === '' OR $params[$param['name']]['values'][0] == '' ) {
				unset( $params[$param['name']] );
			}


		}


		$taxonomies = get_taxonomies();
		foreach( $params as $key => $details ) {
			if( in_array( $key, $taxonomies ) ) {
				$params['custom_taxonomies'][$key] = $details;
				unset( $params[$key] );
			}
			else {
				$params['customdatas'][$key] = $details;
				unset( $params[$key] );
			}
		}

		if( !empty( $params['customdatas'] ) ) {
		foreach( $params['customdatas'] as $key => $details ) {
			$params['customdatas'][$key]['filter_type'] = $search['customdatas'][$key]['filter_type'];
		}
		}


		if( !empty( $params['custom_taxonomies'] ) ) {
		foreach( $params['custom_taxonomies'] as $key => $details ) {
			$params['custom_taxonomies'][$key]['filter_type'] = $search['custom_taxonomies'][$key]['filter_type'];
		}
		}


		if( !empty( $params['custom_taxonomies'] ) ) {

			foreach( $params['custom_taxonomies'] as $key => $details ) {
				$operator = ( $details['filter_type'] == 'and' ) ? 'AND' : 'IN';
				$new_args['tax_query'][] = 	array(
					'taxonomy' => $key,
					'field' => 'id',
					'terms' => $details['values'],
					'operator' => $operator
				);
			}

		}

		if( !empty( $params['customdatas'] ) )  {
		foreach( $params['customdatas'] as $key => $details ) {
			if( !empty( $details['min'] ) ) {
				$new_args['meta_query'][] = 	array(
					'key' => $key,
					'value' => array( $details['min'], $details['max'] ),
					'compare' => 'BETWEEN',
				);
			}
			else {
				$new_args['meta_query'][] = 	array(
					'key' => $key,
					'value' => $details['values'],
					'compare' => 'IN',
				);
			}

		}
		}
	}


	$args = wp_parse_args( $new_args, $args );

	$args['paged'] = $_POST['page'];

	echo get_filter_content( $args );
	die();
}

add_action( 'wp_ajax_est_check_email', 'est_check_email' );
add_action( 'wp_ajax_nopriv_est_check_email', 'est_check_email' );
function est_check_email() {
	global $wpdb;
	$user = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE user_email = '".$_POST['email']."'" );
	if( !empty( $user ) ) {
		echo 'error';
	}

	die();
}

add_action( 'wp_ajax_est_check_username', 'est_check_username' );
add_action( 'wp_ajax_nopriv_est_check_username', 'est_check_username' );
function est_check_username() {
	global $wpdb;
	$user = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE user_login = '".$_POST['username']."'" );
	if( !empty( $user ) ) {
		echo 'error';
	}

	die();
}


add_action( 'wp_ajax_est_user_register', 'est_user_register' );
add_action( 'wp_ajax_nopriv_est_user_register', 'est_user_register' );
function est_user_register() {
	global $wpdb;
	$data = array(
		'user_login' => $_POST['user_login'],
		'user_email' => $_POST['user_email'],
		'user_pass' => $_POST['user_pass'],
		'role' => 'author'
	);
	$user_id = wp_insert_user( $data );
	if( is_multisite() ) {
		global $blog_id;
		$blog_id = get_current_blog_id();
		add_user_to_blog( $blog_id, $user_id, 'author' );
	}

	$user_email = $_POST['user_email'];
	unset( $_POST['user_login'] );
	unset( $_POST['user_email'] );
	unset( $_POST['user_pass'] );
	unset( $_POST['action'] );

	foreach( $_POST as $key => $value ) {
		add_user_meta( $user_id, $key, $value );
	}

	$activation_key = substr( sha1( time() . $user_email ), 1,12 );
	add_user_meta( $user_id, 'activation_key', $activation_key );

	$email_subject = get_post_meta( $_POST['page_id'], '_est_register_activate_subject', true );
	$email_message = get_post_meta( $_POST['page_id'], '_est_register_activate_message', true );

	$link = get_permalink( $_POST['page_id'] ) . '?est_action=activate_account&key=' . $activation_key;
	$email_message .= '<p><a href="' . $link . '">' . $link . '</a></p>';
add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	wp_mail( $user_email, $email_subject, $email_message );
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );


	header( 'Location: ' . get_permalink( $_POST['page_id'] ) . '?est_action=registered' );

}


function est_webmaster_tools_data() {
	global $post;
	$google_profile = get_the_author_meta( 'google_profile', $post->post_author );
?>
	<div class='hidden'>
	<h1 class='entry-title'><?php the_title() ?></h1>
	<span class="updated"><?php echo date( 'Y-m-d H:i:s', strtotime( $post->post_modified ) ) ?></span>
	<span class="vcard author hidden">
		<span class="fn"><?php the_author(); ?></span>
		<span class="org"><?php bloginfo(); ?></span>
		<span class="role"><?php _e( 'Property Author', THEMENAME ) ?></span>
	</span>
	<?php if( !empty( $google_profile ) ) : ?>
		<a href="<?php echo $google_profile ?>?rel=author">Google</a>
	<?php endif ?>
	</div>
	<?php
}


function est_login_check( $user ) {
	if( !empty( $user->activation_key ) ) {
		return null;
	}
	return $user;
}
add_filter('authenticate','est_login_check', 999);


add_action( 'wp_head', 'est_custom_css', 99 );
function est_custom_css() {
	$css = get_theme_mod( 'custom_css' );
	echo '<style type="text/css">';
	echo $css;
	echo '</style>';
}

//START DAN CHANGES
function is_property_a_complex( $post_id = 0 ) {
        return property_has_taxonomy_type( $post_id, 'type', 'apartment-complex' );
}

function is_property_a_building( $post_id = 0 ) {
        return property_has_taxonomy_type( $post_id, 'type', 'apartment-building' );
}

function is_property_a_floorplan( $post_id = 0 ) {
        return property_has_taxonomy_type( $post_id, 'type', 'apartment-floorplan' );
}

function property_has_taxonomy_type( $post_id = 0, $taxonomy = '', $taxonomy_types = '' ) {
        if (!$post_id) {
                $post_id = get_the_ID();
        }
        if ( !is_array($taxonomy_types) ) {
                $taxonomy_types = array( $taxonomy_types );
        }
        $terms = wp_get_post_terms($post_id, $taxonomy, true);
        foreach ( $terms as $term ) {
                if ( $term->taxonomy == $taxonomy && in_array( $term->slug, $taxonomy_types ) ) {
                        return true;
                }
        }
}

function get_building( $post_id = 0 ) {
        if (!$post_id) {
                $post_id = get_the_ID();
        }
        $property_names = wp_get_post_terms($post_id, 'property_name');
        $building = NULL;
        foreach ( $property_names as $property ) {
                //If this property taxonomy has a parent, then this should be the building
                if ( $property->parent ) {
                        return $property;
                }
                $building = $property;
        }
        return $building;
}

function show_breadcrumb ($post_id = 0) {
        if (!$post_id) {
                $post_id = get_the_ID();
        }
        echo '<div class="breadcrumb-container" id="breadcrumb-container">';
        echo '<div class="breadcrumb"><a href="/property-listing">Property Listing</a></div> &gt; ';
        if (is_property_a_floorplan($post_id)) {
                $building = get_building();
                echo '<div class="breadcrumb"><a href="/property/' . $building->slug . '">' . $building->name . '</a></div> &gt; ';
        }
        echo '<div class="breadcrumb-main">' . the_title( '', '', false ) . '</div>';
        echo '</div>';
}
//END DAN CHANGES
?>
