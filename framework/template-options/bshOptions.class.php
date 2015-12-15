<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file holds the main post options class.
	It takes care of the general tasks when
	creating options.
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*

	1. Post Options Class
		1.1 Setup and Configuration
			1.1.1 Constructor
			1.1.2 Box Setup
			1.1.3 Meta Box Creation
			1.1.4 Meta Box Content
			1.1.5 Required Scripts
			1.1.6 Required Styles
			1.1.7 Global Loader Element
			1.1.8 Option Saver

		1.2 Helper Functions
			1.2.1 Get Page Template
			1.2.2 Get Page Content Template
			1.2.3 Get Page Template Name

		1.3 AJAX Functions
			1.3.1 Show Post Options

*/

/***********************************************/
/*           1. Post Options Class             */
/***********************************************/

class bshOptions {

	public $args;
	public $post_id;

	/*********************************/
	/*  1.1 Setup and Configuration  */
	/*********************************/

	// 1.1.1 Constructor
    public function __construct( $args = array() ) {
    	$defaults = array(
    		'title'     => __( 'Page Options', THEMENAME ),
    		'post_type' => 'page',
    		'template'  => 'default',
    		'context'   => 'normal',
    		'priority'  => 'high'
    	);
    	$args = wp_parse_args( $args, $defaults );

    	$this->args = $args;

    	$post_id = 0;
    	if( !empty( $_POST['post_ID'] ) OR !empty( $_GET['post'] ) ) {
	    	$post_id = ( !empty( $_GET['post'] ) ) ? $_GET['post'] : $_POST['post_ID'];
	    	$post_id = ( empty( $post_id ) ) ? 0 : $post_id;
    	}
   		$this->post_id = $post_id;

        add_action( 'wp_ajax_show_post_options', array( $this, 'action_show_post_options' ) );
    }

    // 1.1.2 Meta Box Setup
    public function setup_options() {
        add_action( 'add_meta_boxes', array( $this, 'add_options_box' ) );
        add_action( 'save_post', array( $this, 'save_options' ) );
        add_action( 'admin_print_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_print_styles', array( $this, 'enqueue_styles' ) );
        add_action( 'admin_footer', array( $this, 'add_loader' ) );
    }

    // 1.1.3 Meta Box Creatoion
    public function add_options_box( $post_type ) {
    	if( empty( $post_type ) ) {
    		return;
    	}
	    if( $this->get_page_template() != $this->args['template'] ) {
	    	return;
	    }
        add_meta_box(
            'bshPostOptions',
            $this->args['title'],
            array( &$this, 'options_box_content' ),
            $this->args['post_type'],
            $this->args['context'],
            $this->args['priority']
        );
    }

    // 1.1.4 Meta Box Content
    public function options_box_content( $post ) {
        echo 'There are no options specified for this page';
    }

    // 1.1.5 Required Scripts
	public function enqueue_scripts() {
		wp_enqueue_script(
			'bshOptions',
			get_template_directory_uri() . '/framework/template-options/javascripts/source/bshOptions.js',
			array('jquery', 'jquery-ui', 'jquery-ui-timepicker', 'redactor'  ),
			THEMEVERSION,
			true
		);
		wp_enqueue_script(
			'bshPropertyOptions',
			get_template_directory_uri() . '/framework/template-options/javascripts/source/bshPropertyOptions.js',
			array('jquery', 'jquery-ui', 'jquery-ui-timepicker', 'bshOptions'  ),
			THEMEVERSION,
			true
		);
		wp_enqueue_script(
			'redactor',
			get_template_directory_uri() . '/framework/template-options/javascripts/source/external/redactor.js',
			array('jquery'  ),
			THEMEVERSION,
			true
		);
		wp_enqueue_script(
			'jquery-ui',
			get_template_directory_uri() . '/framework/template-options/javascripts/source/external/jquery.ui.min.js',
			array('jquery'),
			'1.10',
			true
		);
		wp_enqueue_script(
			'jquery-ui-timepicker',
			get_template_directory_uri() . '/framework/template-options/javascripts/source/external/jquery.ui.timepicker.min.js',
			array('jquery', 'jquery-ui'),
			'1.2',
			true
		);
		wp_enqueue_script(
			'jquery-reveal',
			get_template_directory_uri() . '/framework/template-options/javascripts/source/external/jquery.reveal.js',
			array('jquery'),
			'1.0',
			true
		);

	}

    // 1.1.6 Required Styles
	public function enqueue_styles() {
		wp_enqueue_style(
			'bshOptions',
			get_template_directory_uri() . '/framework/template-options/styles/bshOptions.css'
		);
	}

    // 1.1.7 Global Loader Element
    public function add_loader() {
    	echo '<div id="bshLoad"></div>';
    }

    // 1.1.8 Option Saver
    function save_options() {
    	$post_id = $this->get_post_id();

    	if( !empty( $_GET['action'] ) AND  $_GET['action'] ) {
    		return;
    	}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || defined( 'DOING_AJAX' ) && DOING_AJAX )
		  return;

		if ( !empty( $_POST['post_type'] ) AND 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) )
			    return;
		}
		else {
			if ( !empty($post_id) AND !current_user_can( 'edit_post', $post_id ) )
			    return;
		}
		$postmeta = array();

		if( !empty( $_POST['_est_meta_latitude'] ) AND !empty( $_POST['_est_meta_longitude'] ) ) {
			$_POST['_est_lat'] = $_POST['_est_meta_latitude'];
			$_POST['_est_lng'] = $_POST['_est_meta_longitude'];
			$_POST['_est_geocode'] = $_POST['_est_meta_latitude'] . ',' . $_POST['_est_meta_longitude'];
		}
		elseif( get_post_type( $post_id ) == 'property' ) {
			$geolocation = est_get_geolocation( $_POST );
			if( !empty( $geolocation ) ) {
				$_POST['_est_lat'] = $geolocation['lat'];
				$_POST['_est_lng'] = $geolocation['lng'];
				$_POST['_est_geocode'] = $geolocation['lat'] . ',' . $geolocation['lng'];
			}
		}

		if( !empty( $_POST['_est_initial_location'] ) ) {
			$geolocation = est_get_geolocation( $_POST['_est_initial_location'], false );
				$_POST['_est_initial_location_geocode'] = array( $geolocation['lat'], $geolocation['lng'] );
		}

		foreach( $_POST as $key => $value ) {
			if( substr_count( $key, '_' . THEMEPREFIX . '_') ) {
				if( !is_array( $value ) ) {
					$value = stripslashes( $value );
					if( is_serialized( $value ) ) {
						$value = unserialize( $value );
					}
					if( !is_array( $value ) ) {
						$value =  $value ;
					}
				}

				if( is_array( $value ) AND count( $value ) == 1 AND current( $value ) == 'none' ) {
					delete_post_meta( $post_id, $key );
				}
				else {
					if( is_array( $value ) ) {
						$nonekey = array_search( 'none', $value );
						if( $nonekey !== false ) {
							unset( $value[$nonekey] );
						}
					}

					if( $key == '_est_property_custom' ) {
						if( is_array( $value ) ) {
							$details = array();
							foreach( $value as $custom ) {
								$custom_key = bsh_make_custom_key( $custom['name'] );
								$custom_value = $custom['value'];
								update_post_meta( $post_id, $custom_key, $custom_value  );
								$details[] = $custom['name'];
							}

							update_post_meta( $post_id, '_' . THEMEPREFIX . '_property_custom', $details );
						}
					}
					else {
						if( substr_count( $key, '_est_meta' ) AND is_array( $value ) ) {
							delete_post_meta( $post_id, $key );
							foreach( $value as $item ) {
								add_post_meta( $post_id, $key, $item );
							}
						}
						else {
							update_post_meta( $post_id, $key, $value );
						}
					}
				}
			}
		}

		delete_post_meta( $post_id, '_est_agent' );

		if( !empty( $_POST['_est_agent'] ) ) {
			array_filter( $_POST['_est_agent'] );
		}


		if( !empty( $_POST['_est_agent'] ) ) {
			foreach( $_POST['_est_agent'] as $agent_id ) {
				if( !empty( $agent_id ) ) {
					add_post_meta( $post_id, '_est_agent', $agent_id );
				}
			}
		}
		else {
			add_post_meta( $post_id, '_est_agent', $_POST['post_author'] );
		}

		if( empty( $_POST['_est_single_field_address'] ) ) {
			delete_post_meta( $post_id, '_est_single_field_address' );
		}




    }


    // 1.1.9 Get Post ID

    public function get_post_id() {
    	$post_id = 0;
    	if( !empty( $_POST['ID'] ) ) {
    		$post_id = $_POST['ID'];
    	}
    	elseif( !empty( $_GET['post'] ) ) {
    		$post_id = $_GET['post'];
    	}

    	return $post_id;
    }

    /*********************************/
    /*     1.2  Helper Functions     */
    /*********************************/

    // 1.2.1 Get Page Template
    public function get_page_template( $id = 0 ) {
    	$post_id = ( $id == 0 ) ? $this->post_id : $id;

		if( !empty( $post_id ) ) {
			if( get_post_type( $post_id ) == 'property' ) {
				return 'property';
			}
		}

	    $page_type = get_post_meta( $post_id, '_wp_page_template', true );
	    if( empty($page_type) ) {
	    	$page_type = get_post_type( $post_id );
	    }

	    if( empty( $page_type ) AND !empty( $_GET['post_type'] ) ) {
	    	$page_type = $_GET['post_type'];
	    }

	    elseif( empty( $page_type ) AND empty( $_GET['post_type'] ) ) {
	    	$page_type = 'post';
	    }

	    if( $page_type == 'page' ) {
	    	$page_type = 'default';
	    }

		if( $page_type == 'default' ) {
			$post_type = get_post_type( $post_id );
			if( $post_type != 'page' ) {
				$page_type = $post_type;
			}
		}


	    return $page_type;
    }

    // 1.2.2 Get Page Content Template
    public function get_page_template_content( $id = 0 ) {
    	$template = $this->get_page_template( $id );
    	$template = str_replace( 'template', 'content', $template );

    	if( $template == 'default' ) {
    		$template = 'content-page.php';
    	}
    	return $template;
    }

    // 1.2.3 Get Page Template Name
    public function get_page_template_name( $id = 0 ) {
    	$template = $this->get_page_template( $id );
    	$template_names = array(
    		'default'                     => 'Regular Page',
    		'template-bshMenuPage.php'    => 'Menu',
    		'template-bshGalleryPage.php' => 'Gallery',
    		'template-bshBlogPage.php'    => 'Blog',
    	);

    	if( in_array( $template, array_keys( $template_names ) ) ) {
    		$name = $template_names[$template];
    	}
    	else {
    		$name = 'Default Page';
    	}

    	return $name;
    }


    /*********************************/
    /*      1.3 AJAX Functions       */
    /*********************************/

    // 1.3.1 Show Post Options
    public function action_show_post_options() {

	    $template = $_POST['template'];
	    $built_in = array(
	    	'default' => 'bshDefaultOptions'
	    );
	    $class = ( in_array( $template, array_keys( $built_in ) ) ) ?
	    	$built_in[$template] :
	    	str_replace( array( 'template-', '.php' ), '', $template ) . 'Options';

	    if( !class_exists( $class ) ) {
		    $result = array( 'type' => 'nooptions' );
		    echo json_encode( $result );
	    	die();
	    	return;
	    }

	    $post = get_post( $_POST['post_ID'] );
	    $options = new $class();

	    ob_start();
	    $options->options_box_content( $post );
		$options_content = ob_get_clean();

	    $result = array( 'args' => $options->args, 'options' => $options_content, 'type' => 'success' );
	    echo json_encode( $result );

	    die();
    }



}




?>