<?php
class EstatementCustomize {


	public static function register ( $wp_customize ) {

		/*********************************/
		/*         1.1 Sections          */
		/*********************************/

		$wp_customize->add_section( 'general_options' , array(
			'title'      => __( 'General Options', THEMENAME ),
			'priority'   => 10,
		));

		$wp_customize->add_section( 'property_options' , array(
			'title'      => __( 'Property Options', THEMENAME ),
			'priority'   => 15,
		));

		$wp_customize->add_section( 'blog_options' , array(
			'title'      => __( 'Blog Options', THEMENAME ),
			'priority'   => 18,
		));

		$wp_customize->add_section( 'header_options' , array(
			'title'      => __( 'Header Options', THEMENAME ),
			'priority'   => 20,
		));

		$wp_customize->add_section( 'footer_options' , array(
			'title'      => __( 'Footer Options', THEMENAME ),
			'priority'   => 24,
		));


		$wp_customize->add_section( 'footer_bar_options' , array(
			'title'      => __( 'Footer Bar Options', THEMENAME ),
			'priority'   => 26,
		));

		$wp_customize->add_section( 'featured_properties_options' , array(
			'title'      => __( 'Featured Properties Options', THEMENAME ),
			'priority'   => 27,
		));


		$wp_customize->add_section( 'contact_options' , array(
			'title'      => __( 'Contact Options', THEMENAME ),
			'priority'   => 28,
		));


		$wp_customize->add_section( 'booking_options' , array(
			'title'      => __( 'Booking Options', THEMENAME ),
			'priority'   => 29,
		));



		$wp_customize->add_section( 'api_keys' , array(
			'title'      => __( 'API Keys', THEMENAME ),
			'priority'   => 30,
		));


		$wp_customize->add_section( 'error_options' , array(
			'title'      => __( 'Error Display Options', THEMENAME ),
			'priority'   => 40,
		));
		$wp_customize->add_section( 'custom_css' , array(
			'title'      => __( 'Custom CSS', THEMENAME ),
			'priority'   => 150,
		));



		$wp_customize->add_setting( 'custom_css',
			array(
				'default' => '',
				'transport' => 'refresh',
			)
		);


			$wp_customize->add_control( new WP_Customize_Textarea_Control(
				$wp_customize,
				'custom_css',
				array(
					'label'	=> __( 'Custom CSS Code', THEMENAME ),
					'priority' => 20,
					'section' => 'custom_css',
					'settings' => 'custom_css',
					'description' => ''
				)
			));


		/*********************************/
		/*         1.2 Settings          */
		/*********************************/

		// 1.2.1 General Settings

		$wp_customize->add_setting( 'author_base',
			array(
				'default' => 'agent',
				'transport' => 'postMessage',
			)
		);


		$wp_customize->add_setting( 'body_text_color',
			array(
				'default' => '#666666',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'heading_text_color',
			array(
				'default' => '#444444',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'read_more_text',
			array(
				'default' => 'read_more',
			)
		);

		$wp_customize->add_setting( 'site_background_color',
			array(
				'default' => '#282828',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'background_image',
			array(
				'default' => get_template_directory_uri() . '/images/defaults/bg.png',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'background_tiling',
			array(
				'default' => 'repeat',
			)
		);


		$wp_customize->add_setting( 'background_position',
			array(
				'default' => 'center',
			)
		);


		$wp_customize->add_setting( 'background_attachment',
			array(
				'default' => 'scroll',
			)
		);

		$wp_customize->add_setting( 'content_background',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'layout',
			array(
				'default' => '2col_right',
			)
		);

		$wp_customize->add_setting( 'primary_color',
			array(
				'default' => '#ee514b',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'primary_text_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'body_font',
			array(
				'default' => 'Chivo',
			)
		);

		$wp_customize->add_setting( 'heading_font',
			array(
				'default' => 'Bitter',
			)
		);

		$wp_customize->add_setting( 'font_character_set',
			array(
				'default' => 'latin',
			)
		);

		$wp_customize->add_setting( 'search_page_heading',
			array(
				'default' => 'Raleway',
			)
		);


		$wp_customize->add_setting( 'sidebars',
			array(
				'default' => '',
			)
		);

		$wp_customize->add_setting( 'sidebar_responsiveness',
			array(
				'default' => 'show',
			)
		);


		$wp_customize->add_setting( 'analytics',
			array(
				'default' => '',
			)
		);


		$wp_customize->add_setting( 'sidebar',
			array(
				'default' => 'Sidebar',
			)
		);


		$wp_customize->add_setting( 'property_sidebar',
			array(
				'default' => 'Property Page Sidebar',
			)
		);


		// 1.2.2 Header Settings


		$wp_customize->add_setting( 'logo_image',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Image_Control(
				$wp_customize,
				'logo_image',
				array(
					'label' => __( 'Logo Image', THEMENAME ),
					'section' => 'header_options',
					'settings' => 'logo_image',
					'priority' => 10,
				)
			));

		$wp_customize->add_setting( 'logo_image_retina',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Image_Control(
				$wp_customize,
				'logo_image_retina',
				array(
					'label' => __( 'HiDPI Logo Image', THEMENAME ),
					'section' => 'header_options',
					'settings' => 'logo_image_retina',
					'priority' => 15,
				)
			));

		$wp_customize->add_setting( 'retina_logo_width',
			array(
				'default' => '',
			)
		);


			$wp_customize->add_control(
				'retina_logo_width',
				 array(
					'label'     => __( 'Retina Logo Width', THEMENAME ),
				 	'section'	=> 'header_options',
				 	'setting'   => 'retina_logo_width',
				 	'priority'  => 16
				 )
			);


		$wp_customize->add_setting( 'logo_full_width',
			array(
				'default' => 'no',
			)
		);

			$wp_customize->add_control(
				'logo_full_width',
				array(
					'label' => __( 'Full Width Logo?', THEMENAME ),
					'section' => 'header_options',
					'priority' => 17,
					'settings' => 'logo_full_width',
					'type' => 'radio',
					'choices' => array(
						'yes'    => 'Yes',
						'no' => 'No',
					),
				)
			);


		$wp_customize->add_setting( 'header_contact_location',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control(
				'header_contact_location',
				 array(
					'label'     => __( 'Location Text', THEMENAME ),
				 	'section'	=> 'header_options',
				 	'setting'   => 'header_contact_location',
				 	'priority'  => 20
				 )
			);

		$wp_customize->add_setting( 'header_contact_phone',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);


			$wp_customize->add_control(
				'header_contact_phone',
				 array(
					'label'     => __( 'Phone Text', THEMENAME ),
				 	'section'	=> 'header_options',
				 	'setting'   => 'header_contact_phone',
				 	'priority'  => 30
				 )
			);

		$wp_customize->add_setting( 'header_contact_phone_link',
			array(
				'default' => 'yes',
				'transport' => 'postMessage',
			)
		);


			$wp_customize->add_control(
				'header_contact_phone_link',
				array(
					'label' => __( 'Use Tel Link?', THEMENAME ),
					'section' => 'header_options',
					'priority' => 31,
					'settings' => 'header_contact_phone_link',
					'type' => 'radio',
					'choices' => array(
						'yes'    => 'Yes',
						'no' => 'No',
					),
				)
			);


		$wp_customize->add_setting( 'header_contact_email',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control(
				'header_contact_email',
				 array(
					'label'     => __( 'Email Text', THEMENAME ),
				 	'section'	=> 'header_options',
				 	'setting'   => 'header_contact_email',
				 	'priority'  => 40
				 )
			);

		$wp_customize->add_setting( 'header_background_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'header_background_color',
				array(
					'label' => __( 'Header Background Color', THEMENAME ),
					'section' => 'header_options',
					'settings' => 'header_background_color',
					'priority' => 50,
				)
			));


		$wp_customize->add_setting( 'header_text_color',
			array(
				'default' => '#5c5c5c',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'header_text_color',
				array(
					'label' => __( 'Header Text Color', THEMENAME ),
					'section' => 'header_options',
					'settings' => 'header_text_color',
					'priority' => 60,
				)
			));

		$wp_customize->add_setting( 'header_slider_shortcode',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control(
				'header_slider_shortcode',
				 array(
					'label'     => __( 'Header Slider Shortcode', THEMENAME ),
				 	'section'	=> 'header_options',
				 	'setting'   => 'header_slider_shortcode',
				 	'priority'  => 70
				 )
			);




		// Footer Options

		$wp_customize->add_setting( 'show_footer',
			array(
				'default' => 'yes',
			)
		);

			$wp_customize->add_control(
				'show_footer',
				array(
					'label' => __( 'Show Widgetized Footer Area?', THEMENAME ),
					'section' => 'footer_options',
					'priority' => 10,
					'settings' => 'show_footer',
					'type' => 'radio',
					'choices' => array(
						'yes'    => 'Yes',
						'no' => 'No',
					),
				)
			);



		$wp_customize->add_setting( 'footer_background_color',
			array(
				'default' => '#232323',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'footer_background_color',
				array(
					'label' => __( 'Footer Background Color', THEMENAME ),
					'section' => 'footer_options',
					'settings' => 'footer_background_color',
					'priority' => 10,
				)
			));


		$wp_customize->add_setting( 'footer_text_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'footer_text_color',
				array(
					'label' => __( 'Footer Text Color', THEMENAME ),
					'section' => 'footer_options',
					'settings' => 'footer_text_color',
					'priority' => 20,
				)
			));


		$wp_customize->add_setting( 'footer_background_image',
			array(
				'default' => '',
			)
		);

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'footer_background_image',
			array(
				'label' => __( 'Background Image', THEMENAME ),
				'section' => 'footer_options',
				'settings' => 'footer_background_image',
				'priority' => 30,
			)
		));

		$wp_customize->add_setting( 'footer_background_tiling',
			array(
				'default' => 'repeat',
			)
		);

		$wp_customize->add_control(
			'footer_background_tiling',
			array(
				'label' => __( 'Tile Background?', THEMENAME ),
				'section' => 'footer_options',
				'priority' => 40,
				'settings' => 'footer_background_tiling',
				'type' => 'radio',
				'choices' => array(
					'repeat'    => 'Yes',
					'repeat-x'    => 'Only Horizontally',
					'repeat-y'    => 'Only Vertically',
					'no-repeat' => 'No',
				),
			)
		);







		// Footer Bar Options

		$wp_customize->add_setting( 'show_footer_bar',
			array(
				'default' => 'yes',
			)
		);

			$wp_customize->add_control(
				'show_footer_bar',
				array(
					'label' => __( 'Show Footer Bar?', THEMENAME ),
					'section' => 'footer_bar_options',
					'priority' => 10,
					'settings' => 'show_footer_bar',
					'type' => 'radio',
					'choices' => array(
						'yes'    => 'Yes',
						'no' => 'No',
					),
				)
			);



		$wp_customize->add_setting( 'footer_bar_background_color',
			array(
				'default' => '#000000',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'footer_bar_background_color',
				array(
					'label' => __( 'Footer Bar Background Color', THEMENAME ),
					'section' => 'footer_bar_options',
					'settings' => 'footer_bar_background_color',
					'priority' => 10,
				)
			));


		$wp_customize->add_setting( 'footer_bar_text_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'footer_bar_text_color',
				array(
					'label' => __( 'Footer Bar Text Color', THEMENAME ),
					'section' => 'footer_bar_options',
					'settings' => 'footer_bar_text_color',
					'priority' => 20,
				)
			));


		$wp_customize->add_setting( 'footer_bar_text',
			array(
				'default' => 'Estatement Theme By <a href="http://bonsaished.com">Bonsai Shed</a>',
				'transport' => 'postMessage',
			)
		);


			$wp_customize->add_control(
				'footer_bar_text',
				 array(
					'label'     => __( 'Footer Bar Text', THEMENAME ),
				 	'section'	=> 'footer_bar_options',
				 	'setting'   => 'footer_bar_text',
				 	'priority'  => 30
				 )
			);

		// Featured Property Options

		$wp_customize->add_setting( 'show_featured_properties',
			array(
				'default' => 'yes',
			)
		);

			$wp_customize->add_control(
				'show_featured_properties',
				array(
					'label' => __( 'Show Featured Properties Box?', THEMENAME ),
					'section' => 'featured_properties_options',
					'priority' => 10,
					'settings' => 'show_featured_properties',
					'type' => 'radio',
					'choices' => array(
						'yes'    => 'Yes',
						'no' => 'No',
					),
				)
			);

		$wp_customize->add_setting( 'featured_properties_speed',
			array(
				'default' => '10',
			)
		);


			$wp_customize->add_control(
				'featured_properties_speed',
				 array(
					'label'     => __( 'Featured Properties Speed', THEMENAME ),
				 	'section'	=> 'featured_properties_options',
				 	'setting'   => 'featured_properties_speed',
				 	'priority'  => 20
				 )
			);



		$wp_customize->add_setting( 'featured_properties_count',
			array(
				'default' => '5',
			)
		);


			$wp_customize->add_control(
				'featured_properties_count',
				 array(
					'label'     => __( 'Number Of Featured Properties To Show', THEMENAME ),
				 	'section'	=> 'featured_properties_options',
				 	'setting'   => 'featured_properties_count',
				 	'priority'  => 30
				 )
			);


		$wp_customize->add_setting( 'featured_properties_to_show',
			array(
				'default' => 'latest',
			)
		);

			$wp_customize->add_control(
				'featured_properties_to_show',
				array(
					'label' => __( 'Featured Properties To Show', THEMENAME ),
					'section' => 'featured_properties_options',
					'priority' => 40,
					'settings' => 'featured_properties_to_show',
					'type' => 'radio',
					'choices' => array(
						'latest'        => 'Latest',
						'random'        => 'Random',
						'from_category' => 'From Category',
						'specified'     => 'Specified Properties'
					),
				)
			);


		$wp_customize->add_setting( 'featured_properties_ids',
			array(
				'default' => '',
			)
		);


			$wp_customize->add_control(
				'featured_properties_ids',
				 array(
					'label'     => __( 'Comma separated Propert ID\'s to show', THEMENAME ),
				 	'section'	=> 'featured_properties_options',
				 	'setting'   => 'featured_properties_ids',
				 	'priority'  => 45
				 )
			);


		$wp_customize->add_setting( 'featured_properties_taxonomy',
			array(
				'default' => '0',
			)
		);

			$wp_customize->add_control(
				'featured_properties_taxonomy',
				array(
					'label' => 'Featured Properties Taxonomy',
					'section' => 'featured_properties_options',
					'settings' => 'featured_properties_taxonomy',
					'priority' => 50,
					'type' => 'radio',
					'choices' => bsh_get_taxonomies_array()
				)
			);


		$wp_customize->add_setting( 'featured_properties_terms',
			array(
				'default' => '',
			)
		);


			$wp_customize->add_control(
				'featured_properties_terms',
				 array(
					'label'     => __( 'Comma separated terms to show from taxonomy', THEMENAME ),
				 	'section'	=> 'featured_properties_options',
				 	'setting'   => 'featured_properties_terms',
				 	'priority'  => 52
				 )
			);




		$wp_customize->add_setting( 'featured_properties_info_1',
			array(
				'default' => '_est_meta_building_area',
			)
		);


			$wp_customize->add_control(
				'featured_properties_info_1',
				 array(
					'label'     => __( 'First Custom Field To Show', THEMENAME ),
					'section' => 'featured_properties_options',
					'settings' => 'featured_properties_info_1',
					'priority' => 60,
					'type' => 'select',
					'choices' => get_custom_detail_array()
				 )
			);

		$wp_customize->add_setting( 'featured_properties_info_2',
			array(
				'default' => '_est_meta_property_area',
			)
		);


			$wp_customize->add_control(
				'featured_properties_info_2',
				 array(
					'label'     => __( 'Second Custom Field To Show', THEMENAME ),
					'section' => 'featured_properties_options',
					'settings' => 'featured_properties_info_2',
					'priority' => 70,
					'type' => 'select',
					'choices' => get_custom_detail_array()
				 )
			);


		// Contact Options

		$wp_customize->add_setting( 'contact_info',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Info(
				$wp_customize,
				'contact_info',
				array(
					'label'	=> __( 'About Contact Options', THEMENAME ),
					'priority' => 1,
					'section' => 'contact_options',
					'settings' => 'contact_info',
					'description' => __( '<p>
						The following options concern contact messages sent from single property pages. Whenever a user sends a message it is sent to you (or a separate contact for the specific property) and a confirmation is sent to the user.
						</p>
						<p>
							For the subject and message fields below you can use a couple of placeholders which signify the title and the link for the property. If you use <strong>!url</strong> it will be replaced by the url of the property. If you use <strong>!title</strong> it will be replaced with the title of the property.
						</p>
					', THEMENAME )
				)
			));


		$wp_customize->add_setting( 'contact_reply_subject',
			array(
				'default' => 'Thank you for your message',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control(
				'contact_reply_subject',
				 array(
					'label'     => __( 'Contact Auto-Reply Subject', THEMENAME ),
				 	'section'	=> 'contact_options',
				 	'setting'   => 'contact_reply_subject',
				 	'priority'  => 10
				 )
			);

		$wp_customize->add_setting( 'contact_reply_message',
			array(
				'default' => 'We\'ve received your message regarding our property <a href="!url">!title</a>. We read all messages and try and respond within 24 hours.',
				'transport' => 'postMessage',
			)
		);


			$wp_customize->add_control( new WP_Customize_Textarea_Control(
				$wp_customize,
				'contact_reply_message',
				array(
					'label'	=> __( 'Contact Auto-reply Message', THEMENAME ),
					'priority' => 20,
					'section' => 'contact_options',
					'settings' => 'contact_reply_message',
					'description' => ''
				)
			));

		$wp_customize->add_setting( 'contact_email',
			array(
				'default' => get_option( 'admin_email' ),
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control(
				'contact_email',
				 array(
					'label'     => __( 'Send Contact Messages To:', THEMENAME ),
				 	'section'	=> 'contact_options',
				 	'setting'   => 'contact_email',
				 	'priority'  => 30
				 )
			);

		$wp_customize->add_setting( 'contact_success_message',
			array(
				'default' => 'Thank you for your message',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control(
				'contact_success_message',
				 array(
					'label'     => __( 'Contact Success Message:', THEMENAME ),
				 	'section'	=> 'contact_options',
				 	'setting'   => 'contact_email',
				 	'priority'  => 40
				 )
			);



		$wp_customize->add_setting( 'contact_error_captcha',
			array(
				'default' => 'Please fill out the captcha field correctly',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control(
				'contact_error_captcha',
				 array(
					'label'     => __( 'Captcha Field Error:', THEMENAME ),
				 	'section'	=> 'contact_options',
				 	'setting'   => 'contact_error_captcha',
				 	'priority'  => 50
				 )
			);



		$wp_customize->add_setting( 'contact_error_email',
			array(
				'default' => 'Please provide your email address',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control(
				'contact_error_email',
				 array(
					'label'     => __( 'Captcha Field Error:', THEMENAME ),
				 	'section'	=> 'contact_options',
				 	'setting'   => 'contact_error_email',
				 	'priority'  => 60
				 )
			);

		// Booking Options


		$wp_customize->add_setting( 'booking_email_info',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control( new WP_Customize_Info(
				$wp_customize,
				'contact_info',
				array(
					'label'	=> __( 'About Booking Confirmations', THEMENAME ),
					'priority' => 1,
					'section' => 'booking_email_info',
					'settings' => 'contact_info',
					'description' => __( '<p>
						The following options concern booking confirmation emails sent after a booking has been completed. The following options are default options, they can be overridden for each property individually.
						</p>
						<p>
							For the subject and message fields below you can use a couple of placeholders which signify the title and the link for the property. If you use <strong>!url</strong> it will be replaced by the url of the property. If you use <strong>!title</strong> it will be replaced with the title of the property.
						</p>
					', THEMENAME )
				)
			));



		$wp_customize->add_setting( 'booking_email_subject',
			array(
				'default' => 'Thank you for your booking',
				'transport' => 'postMessage',
			)
		);

			$wp_customize->add_control(
				'booking_email_subject',
				 array(
					'label'     => __( 'Booking Confirmation Subject ', THEMENAME ),
				 	'section'	=> 'booking_options',
				 	'setting'   => 'booking_email_subject',
				 	'priority'  => 10
				 )
			);


		$wp_customize->add_setting( 'booking_email_message',
			array(
				'default' => 'Thank you for booking <a href="!url">!title</a>. We look forward to having you at our property, if you have any questions please let us know!',
				'transport' => 'postMessage',
			)
		);


			$wp_customize->add_control( new WP_Customize_Textarea_Control(
				$wp_customize,
				'booking_email_message',
				array(
					'label'	=> __( 'Booking Confirmation Message', THEMENAME ),
					'priority' => 20,
					'section' => 'booking_options',
					'settings' => 'booking_email_message',
					'description' => ''
				)
			));



		// 1.2.3 API Settings
		$wp_customize->add_setting( 'google_maps_api_key',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'facebook_api_key',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'twitter_consumer_key',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'twitter_consumer_secret',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'twitter_access_token',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_setting( 'twitter_access_secret',
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);


		// Error Options

		$wp_customize->add_setting( '404_title',
			array(
				'default' => 'Oh No, a page is missing!',
			)
		);

		$wp_customize->add_setting( '404_message',
			array(
				'default' => 'It seems that you have stumbled on to some missing content. Try going back to the <a href="' . home_url() . '">main page</a> and give it another go.',
			)
		);

		$wp_customize->add_setting( 'no_posts_title',
			array(
				'default' => 'There is no content here!',
			)
		);

		$wp_customize->add_setting( 'no_posts_message',
			array(
				'default' => 'The page you are on exists, but there is no content added to it yet!',
			)
		);

		$wp_customize->add_setting( 'no_search_title',
			array(
				'default' => 'Your search yielded no results :(',
			)
		);

		$wp_customize->add_setting( 'no_search_message',
			array(
				'default' => 'Go back to try your search again',
			)
		);

		$wp_customize->add_setting( 'no_search_include_page',
			array(
				'default' => '',
			)
		);



		/*********************************/
		/*         1.3 Controls          */
		/*********************************/

		// 1.3.1 General Controls

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'body_text_color',
			array(
				'label' => __( 'Body Text Color', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'body_text_color',
				'priority' => 1,
			)
		));

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'heading_text_color',
			array(
				'label' => __( 'Heading Text Color', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'heading_text_color',
				'priority' => 2,
			)
		));

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'site_background_color',
			array(
				'label' => __( 'Background Color', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'site_background_color',
				'priority' => 3,
			)
		));

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'background_image',
			array(
				'label' => __( 'Background Image', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'background_image',
				'priority' => 4,
			)
		));

		$wp_customize->add_control(
			'background_tiling',
			array(
				'label' => __( 'Tile Background?', THEMENAME ),
				'section' => 'general_options',
				'priority' => 5,
				'settings' => 'background_tiling',
				'type' => 'radio',
				'choices' => array(
					'repeat'    => 'Yes',
					'repeat-x'    => 'Only Horizontally',
					'repeat-y'    => 'Only Vertically',
					'no-repeat' => 'No',
				),
			)
		);

		$wp_customize->add_control(
			'background_position',
			array(
				'label' => __( 'Background Position', THEMENAME ),
				'section' => 'general_options',
				'priority' => 6,
				'settings' => 'background_position',
				'type' => 'radio',
				'choices' => array(
					'left top'    => 'Left',
					'right top' => 'Right',
					'center top' => 'Center',
				),
			)
		);



		$wp_customize->add_control(
			'background_attachment',
			array(
				'label' => __( 'Background Attachment', THEMENAME ),
				'section' => 'general_options',
				'priority' => 6,
				'settings' => 'background_attachment',
				'type' => 'radio',
				'choices' => array(
					'scroll'    => 'Scroll',
					'fixed' => 'Fixed',
				),
			)
		);


		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'content_background',
			array(
				'label' => __( 'Content Area Background', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'content_background',
				'priority' => 7,
			)
		));


		$wp_customize->add_control(
			'layout',
			array(
				'label' => __( 'Default Layout', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'layout',
				'type' => 'radio',
				'priority' => 8,
				'choices' => array(
					'2col_right' => '2 Columns - Sidebar on the Right',
					'2col_left' => '2 Columns - Sidebar on the Left',
					'1col' => '1 Column - No Sidebar',
				),
			)
		);


		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'primary_color',
			array(
				'label' => __( 'Primary Color', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'primary_color',
				'priority' => 10,
			)
		));

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'primary_text_color',
			array(
				'label' => __( 'Primary Text Color', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'primary_text_color',
				'priority' => 20,
			)
		));



		$wp_customize->add_setting( 'favicon',
			array(
				'default' => get_template_directory_uri() . '/images/defaults/favicon.ico',
			)
		);
			$wp_customize->add_control( new WP_Customize_Image_Control(
				$wp_customize,
				'favicon',
				array(
					'label' => __( 'Favicon', THEMENAME ),
					'section' => 'general_options',
					'settings' => 'favicon',
					'priority' => 40,
				)
			));

		$wp_customize->add_setting( 'touchicon',
			array(
				'default' => get_template_directory_uri() . '/images/defaults/apple-touch-icon.png',
			)
		);
			$wp_customize->add_control( new WP_Customize_Image_Control(
				$wp_customize,
				'touchicon',
				array(
					'label' => __( 'Apple Touch Icon', THEMENAME ),
					'section' => 'general_options',
					'settings' => 'touchicon',
					'priority' => 41,
				)
			));




		$wp_customize->add_control(
			'body_font',
			array(
				'label' => __( 'Body Font', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'body_font',
				'type' => 'select',
				'priority' => 33,
				'choices' => self::get_font_dropdown_options()
			)
		);

		$wp_customize->add_control(
			'heading_font',
			array(
				'label' => __( 'Heading Font', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'heading_font',
				'type' => 'select',
				'priority' => 36,
				'choices' => self::get_font_dropdown_options()
			)
		);

		$wp_customize->add_control(
			'font_character_set',
			array(
				'label' => __( 'Character Set', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'font_character_set',
				'type' => 'select',
				'priority' => 36,
				'choices' => array(
					'latin' => 'Use Latin',
					'cyrillic-ext' => 'Use Cyrillic if possible',
					'greek-ext' => 'Use Greek if possible'
				)
			)
		);


		$wp_customize->add_control(
			'search_page_heading',
			array(
				'label' => __( 'Search Page Heading Font', THEMENAME ),
				'section' => 'general_options',
				'settings' => 'search_page_heading',
				'type' => 'select',
				'priority' => 40,
				'choices' => self::get_font_dropdown_options()
			)
		);


		$wp_customize->add_control( new WP_Customize_Textarea_Control(
			$wp_customize,
			'sidebars',
			array(
				'label'	=> __( 'Sidebars', THEMENAME ),
				'priority' => 50,
				'section' => 'general_options',
				'settings' => 'sidebars',
				'description' => 'Add custom sidebars, separated by commas. Once added, please reload this page to be able to select in the default sidebar list below'
			)
		));


		$choices = explode(',', get_theme_mod( 'sidebars' ) );
		$sidebars['Sidebar'] = 'Sidebar';
		$sidebars['Property Page Sidebar'] = 'Property Page Sidebar';
		foreach( $choices as $choice ) {
			$choice = trim( $choice );
			if( !empty( $choice ) ) {
				$sidebars[$choice] = $choice;
			}
		}

		$wp_customize->add_control( 'sidebar', array(
			'label' => 'Default Sidebar:',
			'section' => 'general_options',
			'priority' => 60,
			'type' => 'select',
			'choices' => $sidebars
		));


		$wp_customize->add_control( 'property_sidebar', array(
			'label' => 'Default Property Page Sidebar:',
			'settings' => 'property_sidebar',
			'section' => 'general_options',
			'priority' => 70,
			'type' => 'select',
			'choices' => $sidebars
		));


		$wp_customize->add_control( 'sidebar_responsiveness', array(
			'label' => 'Sidebar on mobile devices:',
			'settings' => 'sidebar_responsiveness',
			'section' => 'general_options',
			'priority' => 80,
			'type' => 'radio',
				'choices' => array(
					'show' => 'Show sidebar below content',
					'hide' => 'Hide the sidebar'
				),
		));



		$wp_customize->add_control( new WP_Customize_Textarea_Control(
			$wp_customize,
			'analytics',
			array(
				'label'	=> __( 'Analytics', THEMENAME ),
				'priority' => 80,
				'section' => 'general_options',
				'settings' => 'analytics',
				'description' => 'Add analytics code here. If you use more than one service paste each code block one under the other'
			)
		));

		$wp_customize->add_control( 'read_more_text', array(
			'label' => 'Read More Text:',
			'settings' => 'read_more_text',
			'section' => 'general_options',
			'priority' => 90
		));


		$wp_customize->add_setting( 'decimal_separator',
			array(
				'default' => '.',
			)
		);

			$wp_customize->add_control(
				'decimal_separator',
				array(
					'label' => __( 'Decimal Separator', THEMENAME ),
					'section' => 'general_options',
					'priority' => 100,
					'settings' => 'decimal_separator',
				)
			);


		$wp_customize->add_setting( 'thousand_separator',
			array(
				'default' => '.',
			)
		);

			$wp_customize->add_control(
				'thousand_separator',
				array(
					'label' => __( 'Thousand Separator', THEMENAME ),
					'section' => 'general_options',
					'priority' => 110,
					'settings' => 'thousand_separator',
				)
			);


			$wp_customize->add_control(
				'author_base',
				array(
					'label' => __( 'Agent URL Base', THEMENAME ),
					'section' => 'general_options',
					'priority' => 120,
					'settings' => 'author_base',
				)
			);


		// Property Options


		$wp_customize->add_setting( 'property_permalink',
			array(
				'default' => 'property',
			)
		);

		$wp_customize->add_control(
			'property_permalink',
			array(
				'label' => __( 'Property Permalink', THEMENAME ),
				'section' => 'property_options',
				'priority' => 5,
				'settings' => 'property_permalink',
			)
		);



		$wp_customize->add_setting( 'property_slider_crop',
			array(
				'default' => 'crop',
			)
		);

		$wp_customize->add_control(
			'property_slider_crop',
			array(
				'label' => __( 'Crop Images In Slider', THEMENAME ),
				'section' => 'property_options',
				'priority' => 6,
				'settings' => 'property_slider_crop',
				'type' => 'radio',
				'choices' => array(
					'crop'    => 'Crop',
					'full' => 'Don\'t crop (leaves whitespace next to image)',
				),
			)
		);





		$wp_customize->add_setting( 'property_excerpt_length',
			array(
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'property_excerpt_length',
			array(
				'label' => __( 'Property Excerpt Length (0 for auto)', THEMENAME ),
				'section' => 'property_options',
				'priority' => 6,
				'settings' => 'property_excerpt_length',
			)
		);


		$wp_customize->add_setting( 'property_post_links',
			array(
				'default' => 'no',
			)
		);
		$wp_customize->add_control(
			'property_post_links',
			array(
				'label' => __( 'Show links to next/prev properties?', THEMENAME ),
				'section' => 'property_options',
				'priority' => 10,
				'settings' => 'property_post_links',
				'type' => 'radio',
				'choices' => array(
					'yes'    => 'Yes',
					'no' => 'No',
				),
			)
		);




		$wp_customize->add_setting( 'property_commenting',
			array(
				'default' => 'no',
			)
		);

		$wp_customize->add_control(
			'property_commenting',
			array(
				'label' => __( 'Allow Commenting on Properties?', THEMENAME ),
				'section' => 'property_options',
				'priority' => 12,
				'settings' => 'property_commenting',
				'type' => 'radio',
				'choices' => array(
					'yes'    => 'Yes',
					'no' => 'No',
				),
			)
		);


		$wp_customize->add_setting( 'featured_ribbon',
			array(
				'default' => get_template_directory_uri() . '/images/featured-flag.png',
				'transport' => 'postMessage',
			)
		);



		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'featured_ribbon',
			array(
				'label' => __( 'Featured Ribbon', THEMENAME ),
				'section' => 'property_options',
				'settings' => 'featured_ribbon',
				'priority' => 14,
			)
		));



		$wp_customize->add_setting( 'featured_ribbon_width',
			array(
				'default' => '95',
			)
		);

		$wp_customize->add_control(
			'featured_ribbon_width',
			array(
				'label' => __( 'Featured Ribbon Width', THEMENAME ),
				'section' => 'property_options',
				'priority' => 15,
				'settings' => 'featured_ribbon_width',
			)
		);


		$wp_customize->add_setting( 'featured_ribbon_height',
			array(
				'default' => '95',
			)
		);

		$wp_customize->add_control(
			'featured_ribbon_height',
			array(
				'label' => __( 'Featured Ribbon Height', THEMENAME ),
				'section' => 'property_options',
				'priority' => 16,
				'settings' => 'featured_ribbon_height',
			)
		);




		$wp_customize->add_setting( 'property_ribbon_field',
			array(
				'default' => '_est_meta_price',
			)
		);


			$wp_customize->add_control(
				'property_ribbon_field',
				 array(
					'label'     => __( 'Field To Show In Ribbon', THEMENAME ),
					'section' => 'property_options',
					'settings' => 'property_ribbon_field',
					'priority' => 20,
					'type' => 'select',
					'choices' => get_custom_detail_array()
				 )
			);


		$wp_customize->add_setting( 'show_print',
			array(
				'default' => 'yes',
			)
		);

		$wp_customize->add_control(
			'show_print',
			array(
				'label' => __( 'Show Print Button?', THEMENAME ),
				'section' => 'property_options',
				'priority' => 30,
				'settings' => 'show_print',
				'type' => 'radio',
				'choices' => array(
					'yes'    => 'Yes',
					'no' => 'No',
				),
			)
		);

		$wp_customize->add_setting( 'print_icon',
			array(
				'default' => 'http://cdn.printfriendly.com/button-print-gry20.png',
				'transport' => 'postMessage',
			)
		);



		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'print_icon',
			array(
				'label' => __( 'Print Icon', THEMENAME ),
				'section' => 'property_options',
				'settings' => 'print_icon',
				'priority' => 40,
			)
		));


		// Blog Options


		$wp_customize->add_setting( 'content_length',
			array(
				'default' => 'excerpt',
			)
		);

		$wp_customize->add_control(
			'content_length',
			array(
				'label' => __( 'Content to show in lists', THEMENAME ),
				'section' => 'blog_options',
				'priority' => 10,
				'settings' => 'content_length',
				'type' => 'radio',
				'choices' => array(
					'excerpt'    => 'Excerpt',
					'content'    => 'Full Content',
				),
			)
		);


		$wp_customize->add_setting( 'blog_title',
			array(
				'default' => 'Archives',
			)
		);

		$wp_customize->add_control(
			'blog_title',
			array(
				'label' => __( 'The title to show on the blog page', THEMENAME ),
				'section' => 'blog_options',
				'priority' => 10,
				'settings' => 'blog_title',
				'type' => 'text',
			)
		);


		$wp_customize->add_setting( 'blog_slider',
			array(
				'default' => '',
			)
		);

		$wp_customize->add_control(
			'blog_slider',
			array(
				'label' => __( 'Slider to show on main blog page', THEMENAME ),
				'section' => 'blog_options',
				'priority' => 10,
				'settings' => 'blog_slider',
				'type' => 'text',
			)
		);



		// 1.3.2 Header Controls



		// 1.3.3 API Controls
		$wp_customize->add_control(
			'google_maps_api_key',
			 array(
				'label' => __( 'Google Maps API Key', THEMENAME ),
			 	'section'	=> 'api_keys',
			 )
		);


		$wp_customize->add_control(
			'facebook_api_key',
			 array(
				'label' => __( 'Facebook API Key', THEMENAME ),
			 	'section'	=> 'api_keys',
			 )
		);

		$wp_customize->add_control(
			'twitter_consumer_key',
			 array(
				'label' => __( 'Twitter Consumer Key', THEMENAME ),
			 	'section'	=> 'api_keys',
			 )
		);

		$wp_customize->add_control(
			'twitter_consumer_secret',
			 array(
				'label' => __( 'Twitter Consumer Secret', THEMENAME ),
			 	'section'	=> 'api_keys',
			 )
		);


		$wp_customize->add_control(
			'twitter_access_token',
			 array(
				'label' => __( 'Twitter Access Token', THEMENAME ),
			 	'section'	=> 'api_keys',
			 )
		);


		$wp_customize->add_control(
			'twitter_access_secret',
			 array(
				'label' => __( 'Twitter Access Secret', THEMENAME ),
			 	'section'	=> 'api_keys',
			 )
		);



		// Error Controls

		$wp_customize->add_control(
			'404_title',
			 array(
				'label' => __( '404 Error Title', THEMENAME ),
			 	'section'	=> 'error_options',
				'priority' => 10,
			 )
		);

		$wp_customize->add_control( new WP_Customize_Textarea_Control(
			$wp_customize,
			'404_message',
			array(
				'label'	=> __( '404 Error Message', THEMENAME ),
				'priority' => 20,
				'section' => 'error_options',
				'settings' => '404_message'
			)
		));


		$wp_customize->add_control(
			'no_posts_title',
			 array(
				'label' => __( 'No Content Title', THEMENAME ),
			 	'section'	=> 'error_options',
				'priority' => 60,
				'settings' => 'no_posts_title',
			 )
		);

		$wp_customize->add_control( new WP_Customize_Textarea_Control(
			$wp_customize,
			'no_posts_message',
			array(
				'label'	=> __( 'No Content Message', THEMENAME ),
				'priority' => 70,
				'section' => 'error_options',
				'settings' => 'no_posts_message',
			)
		));



		$wp_customize->add_control(
			'no_search_title',
			 array(
				'label' => __( 'No Search Results Title', THEMENAME ),
			 	'section'	=> 'error_options',
				'priority' => 80,
				'settings' => 'no_search_title',
			 )
		);

		$wp_customize->add_control( new WP_Customize_Textarea_Control(
			$wp_customize,
			'no_search_message',
			array(
				'label'	=> __( 'No Search Results Message', THEMENAME ),
				'priority' => 90,
				'section' => 'error_options',
				'settings' => 'no_search_message',
			)
		));


		$wp_customize->add_control(
			'no_search_include_page',
			array(
				'label' => __( 'Include a Page When No Search Results', THEMENAME ),
				'section' => 'error_options',
				'settings' => 'no_search_include_page',
				'type' => 'select',
				'priority' => 100,
				'choices' => self::get_page_dropdown_options()
			)
		);



   }


	/*********************************/
	/*        1.4 CSS Output         */
	/*********************************/
	public static function header_css_output() {
		?>
			<style type="text/css">

				<?php // 1.4.1 General CSS Output ?>


				<?php
					// Body Text Color
					self::generate_css_color(
						'html, body, p, a, .body-text-color, table tbody tr td, .content a.body-text-color, label',
						'color',
						'body_text_color'
					);
					self::generate_css_color(
						'.light, code',
						'color',
						'body_text_color',
						+20
					);

					// Heading Text Color
					self::generate_css_color(
						'h1,h2,h3,h4,h5,h6, .heading-text-color, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, .widget_rss li > a, h1.widget-title a, .dsidx-prop-title, .dsidx-address, .dsidx-address a',
						'color',
						'heading_text_color'
					);

					// Primary Colors
					self::generate_css_color(
						'.primary, .primary-links a, a:hover, .content p a, .widget_calendar a, .content a.body-text-color:hover, #footerBar a:hover, a.heading-text-color:hover, .layout-propert-flyer h1 a.heading-text-color:hover, #headerMenu .menu > li a:hover, #login .links a:hover',
						'color',
						'primary_color'
					);
					self::generate_css_color(
						'.primary-background, .button, .button.primary,
						#siteHeader .menu .current-menu-item > a,
						#siteHeader .menu .current-menu-parent > a,
						#siteHeader .menu .current-menu-ancestor > a,
						#headerDropdown .menu > li, .pagination .page-numbers.current,
						.section-container section.active .title a, #dsidx-contact-form-submit, .layout-map .custom_field
						',
						'background-color',
						'primary_color'
					);
					self::generate_css_color(
						'.button:hover
						',
						'background-color',
						'primary_color',
						-5
					);

					self::generate_css_color(
						'#siteHeader, #headerMenu .menu > li > ul,  #headerDropdown .menu > li > ul, #siteFooter, #footerMenu .menu  > li > ul, #estatementMapContainer, .cb-slideshow',
						'border-color',
						'primary_color'
					);
					self::generate_css_color(
						'.button, .button.primary',
						'text-shadow',
						'primary_color',
						-6,
						1,
						'-1px -1px 0 '
					);

					// Primary Text Color
					self::generate_css_color(
						'.primary-background, .primary-background a, .primary-background h1, .primary-background h2, .primary-background h3, .primary-background h4, .primary-background h5, .primary-background h6,
							#siteHeader .menu .current-menu-item > a,
							#siteHeader .menu .current-menu-parent > a,
							#siteHeader .menu .current-menu-ancestor > a,
							#headerDropdown .menu > li, .button, .content .button, .pagination .page-numbers.current,
							#siteHeader .menu li.current-menu-item > a,
						#siteHeader .menu li.current-menu-parent > a,
						#siteHeader .menu li.current-menu-ancestor > a,
						.section-container section.active .title a, #dsidx-contact-form-submit, #dsidx-listings .dsidx-price, .layout-map .custom_field
						',
						'color',
						'primary_text_color'
					);


					// Body Font
					self::generate_css(
						'p, body, html, .body-font',
						'font-family',
						'body_font'
					);

					// Heading Font
					self::generate_css(
						'h1,h2,h3,h4,h5,h6,.heading-font, .widget_rss li > a, h1.widget-title a, .dsidx-prop-title, #dsidx-property-types strong, .dsidx-address, #booking-form input[type=text], .booking-value',
						'font-family',
						'heading_font'
					);

					// Search Heading Font
					self::generate_css(
						'#search-page .full-title h1',
						'font-family',
						'search_page_heading'
					);

					// Background Color
					self::generate_css(
						'html',
						'background-color',
						'site_background_color'
					);

					// Background Image

					self::generate_css(
						'html',
						'background-image',
						'background_image',
						'url(',
						')'
					);

					self::generate_css(
						'html',
						'background-repeat',
						'background_tiling'
					);
					self::generate_css(
						'html',
						'background-attachment',
						'background_attachment'
					);

					self::generate_css(
						'html',
						'background-position',
						'background_position'
					);

					// Content Area Background
					self::generate_css(
						'#siteContent, .layout-property-flyer, .layout-property-flyer .post-content, .layout-booknow-property, .layout-booknow-property .post-content, .line a, #propertyFilter .property, #filterNoResults, #filterPageSearch, .box',
						'background-color',
						'content_background'
					);

					echo '#siteContent.nobgcolor{ background-color:transparent}';

					$sidebar_responsiveness = get_theme_mod('sidebar_responsiveness');
					if( !empty( $sidebar_responsiveness ) AND $sidebar_responsiveness == 'hide' ) {
						echo '
							@media only screen and (max-width: 767px ) {
								#siteSidebar {
									display:none;
								}
							}
						';
					}

					self::generate_css_color(
						'.layout-property-card, .layout-property-minicard, .carousel, .pagination .page-numbers, #siteContent .customSelect, code,
							.section-container section .content, .section-container .section .content, .section-container.auto section .content, .section-container.auto .section .content, .section-container.tabs section.active .title, .section-container.tabs .section.active .title, .inContentSearch',
						'background-color',
						'content_background',
						-3
					);

					self::generate_css_color(
						'#siteContent input[type="text"],
							#siteContent input[type="password"],
							#siteContent input[type="date"],
							#siteContent input[type="datetime"],
							#siteContent input[type="datetime-local"],
							#siteContent input[type="month"],
							#siteContent input[type="week"],
							#siteContent input[type="email"],
							#siteContent input[type="number"],
							#siteContent input[type="search"],
							#siteContent input[type="tel"],
							#siteContent input[type="time"],
							#siteContent input[type="url"],
							#siteContent textarea',
						'background-color',
						'content_background',
						-6
					);


					self::generate_css_color(
						'#siteContent input[type="text"],
							#siteContent input[type="password"],
							#siteContent input[type="date"],
							#siteContent input[type="datetime"],
							#siteContent input[type="datetime-local"],
							#siteContent input[type="month"],
							#siteContent input[type="week"],
							#siteContent input[type="email"],
							#siteContent input[type="number"],
							#siteContent input[type="search"],
							#siteContent input[type="tel"],
							#siteContent input[type="time"],
							#siteContent input[type="url"],
							#siteContent textarea',
						'color',
						'body_text_color'
					);


					self::generate_css_color(
						'.line',
						'background-color',
						'content_background',
						-12
					);

					self::generate_css_color(
						'.map-canvas',
						'border-color',
						'content_background',
						-3
					);

					self::generate_css_color(
						'#siteContent .widget ul li, #siteContent .widget_propertydetailswidget table tr td, .widget_bshpropertydetailswidget table tr td, .section-container.tabs section .content, .section-container.tabs .section .content, .section-container.tabs section.active .title, .section-container.tabs .section.active .title, .section-container.tabs section:last-child .title, .section-container.tabs .section:last-child .title, .section-container.tabs section .title, .section-container.tabs .section .title, .calculated',
						'border-color',
						'content_background',
						-10
					);
					self::generate_css_color(
						'.section-container section .title, .section-container .section .title, .section-container.auto section .title, .section-container.auto .section .title',
						'background-color',
						'content_background',
						-8
					);


					self::generate_css(
						'#featured-flag',
						'background-image',
						'featured_ribbon',
						'url(',
						')'
					);

					self::generate_css(
						'#featured-flag',
						'width',
						'featured_ribbon_width',
						'',
						'px'
					);


					self::generate_css(
						'#featured-flag',
						'height',
						'featured_ribbon_height',
						'',
						'px'
					);

					/***********************************************/
					/*                BuddyPress                   */
					/***********************************************/

					self::generate_css_color(
						'#buddypress a.button, #buddypress input[type=submit]',
						'background-color',
						'primary_color'
					);

					self::generate_css_color(
						'#buddypress a.button:hover, #buddypress input[type=submit]:hover',
						'background-color',
						'primary_color',
						-10
					);

					self::generate_css_color(
						'#buddypress a.button, #buddypress input[type=submit]',
						'color',
						'primary_text_color'
					);

					self::generate_css_color(
						'#buddypress a.button:hover, #buddypress input[type=submit]:hover',
						'color',
						'primary_text_color'
					);


					self::generate_css_color(
						'#buddypress a.button, #buddypress input[type=submit]',
						'border-color',
						'primary_text_color',
						-5
					);

					self::generate_css_color(
						'#buddypress a.button:hover, #buddypress input[type=submit]:hover',
						'border-color',
						'primary_color',
						-10
					);

					self::generate_css_color(
						'#buddypress a.button span',
						'background',
						'primary_color',
						-20
					);

					self::generate_css_color(
						'#buddypress a.button:hover span',
						'background',
						'primary_color',
						-30
					);


					self::generate_css_color(
						'#buddypress form#whats-new-form textarea',
						'background',
						'content_background',
						-5
					);

					self::generate_css_color(
						'#buddypress .profile-fields td',
						'background',
						'content_background'
					);

					self::generate_css_color(
						'#buddypress .profile-fields td',
						'color',
						'body_text_color'
					);

					/***********************************************/
					/*                 Header Options              */
					/***********************************************/

					self::generate_css_color(
						'#siteHeader, #headerMenu .menu > li > ul, #headerDropdown .menu > li > ul',
						'background-color',
						'header_background_color'
					);

					self::generate_css_color(
						'#siteHeader, #headerMenu .menu > li > a, #headerMenu .menu > li a, #headerDropdown .menu > li > ul li a',
						'color',
						'header_text_color'
					);

					/***********************************************/
					/*                 Footer Options              */
					/***********************************************/

					self::generate_css_color(
						'#siteFooter',
						'background-color',
						'footer_background_color'
					);
					self::generate_css_color(
						'#siteFooter .widget ul li',
						'border-color',
						'footer_background_color',
						+10
					);

					self::generate_css(
						'#siteFooter',
						'background-image',
						'footer_background_image',
						'url(',
						')'
					);

					self::generate_css(
						'#siteFooter',
						'background-repeat',
						'footer_background_tiling'
					);


					self::generate_css_color(
						'#siteFooter h1, #siteFooter h2, #siteFooter h3, #siteFooter h4, #siteFooter h5, #siteFooter h6, #siteFooter.heading-text-color',
						'color',
						'footer_text_color'
					);
					self::generate_css_color(
						'#siteFooter, #siteFooter p',
						'color',
						'footer_text_color',
						-45
					);

					/***********************************************/
					/*               Footer Bar Options            */
					/***********************************************/

					self::generate_css_color(
						'#footerBar, #footerMenu .menu  > li > ul',
						'background-color',
						'footer_bar_background_color'
					);

					self::generate_css_color(
						'#footerBar, #footerBar a, #footerBar .menu > li > a, #footerBar .menu > li a',
						'color',
						'footer_bar_text_color'
					);


				?>





			</style>

		<?php
	}

	/*********************************/
	/*    1.5 Live Preview Script    */
	/*********************************/
	public static function live_preview() {
		wp_enqueue_script(
			'customizer',
			get_template_directory_uri().'/framework/customizer/customizer.js',
			array( 'jquery','customize-preview' ),
			time(),
			true
		);

		wp_localize_script( 'customizer', 'bs', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'template_url' => get_template_directory_uri() ) );

	}

	/*********************************/
	/*        1.6 CSS Helper         */
	/*********************************/
	public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true) {

		$return = '';
		$mod = get_theme_mod($mod_name);
		if ( ! empty( $mod ) ) {
			$return = sprintf('%s { %s:%s; }',
				$selector,
				$style,
				$prefix.$mod.$postfix
			);
			if ( $echo ) {
				echo $return;
			}
		}

		return $return;
	}

	public static function generate_css_color( $selector, $style, $mod_name, $color_offset = 0, $opacity = 1, $before = '', $after = '' ) {
		$mod = get_theme_mod($mod_name);

		if ( ! empty( $mod ) ) {
			$value = $mod;
			if( substr( $value, 0, 1 ) != '#' ) {
				$value = '#' . $value;
			}

			$color = new Color( $value );

			if( $color_offset > 0 ) {
				$value = '#' . $color->lighten( abs( $color_offset ) );
			}
			elseif( $color_offset < 0 ) {
				$value = '#' . $color->darken( abs( $color_offset ) );
			}

			if( abs( $opacity ) < 1 ) {
				$rgb = new Color( $value );
				$rgb = $rgb->getRgb();
				$value = 'rgba( ' . $rgb['R'] . ', ' . $rgb['G'] . ', ' . $rgb['B'] . ', ' . $opacity . ' )';
			}

			echo $selector . '{ ' . $style . ': ' . $before . ' ' . $value . ' ' . $after . ' }';
		}
	}

	public static function generate_css_gradient( $selector, $style, $mod_name ) {
		$mod = get_theme_mod($mod_name);
		if ( ! empty( $mod ) ) {
			$color = new Color( $mod );
			$gradient = $color->makeGradient();
			echo $selector . "{
				background: #" . $gradient['light'] . ";
				background: -moz-linear-gradient(top,  #" . $gradient['light'] . " 0%, #" . $gradient['dark'] . " 100%);
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#" . $gradient['light'] . "), color-stop(100%,#" . $gradient['dark'] . "));
				background: -webkit-linear-gradient(top,  #" . $gradient['light'] . " 0%,#" . $gradient['dark'] . " 100%);
				background: -o-linear-gradient(top,  #" . $gradient['light'] . " 0%,#" . $gradient['dark'] . " 100%);
				background: -ms-linear-gradient(top,  #" . $gradient['light'] . " 0%,#" . $gradient['dark'] . " 100%);
				background: linear-gradient(to bottom,  #" . $gradient['light'] . " 0%,#" . $gradient['dark'] . " 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#" . $gradient['light'] . "', endColorstr='#" . $gradient['dark'] . "',GradientType=0 );
			}";
		}
	}

	/*********************************/
	/*       1.7 Set Defaults        */
	/*********************************/
	public static function set_defaults() {

		$primary = get_theme_mod( 'primary_color' );
		if( empty( $primary ) ) {
			// General Settings
			set_theme_mod( 'primary_color', '#ee514b' );
			set_theme_mod( 'primary_text_color', '#ffffff' );
			set_theme_mod( 'heading_font', 'Bitter' );
			set_theme_mod( 'body_font', 'Chivo' );
			set_theme_mod( 'favicon',  get_template_directory_uri() . '/images/defaults/favicon.ico' );
			set_theme_mod( 'touchicon', get_template_directory_uri() . '/images/defaults/apple-touch-icon.png' );
			set_theme_mod( 'search_page_heading', 'Raleway' );
			set_theme_mod( 'body_text_color', '#666666' );
			set_theme_mod( 'background_image', get_template_directory_uri() . '/images/defaults/bg.png' );
			set_theme_mod( 'background_tiling', 'repeat' );
			set_theme_mod( 'background_position', 'center' );
			set_theme_mod( 'background_attachment', 'scroll' );
			set_theme_mod( 'sidebar_responsiveness', 'show' );
			set_theme_mod( 'sidebar', 'Sidebar' );
			set_theme_mod( 'property_sidebar', 'Property Page Sidebar' );
			set_theme_mod( 'heading_text_color', '#444444' );
			set_theme_mod( 'site_background_color', '#fafafa' );
			set_theme_mod( 'read_more_text', 'read more' );
			set_theme_mod( 'content_background', '#ffffff' );
			set_theme_mod( 'header_contact_location', 'Colorado Springs, Colorado' );
			set_theme_mod( 'header_contact_phone', ' (740) 431-1945' );
			set_theme_mod( 'header_contact_email', 'contact@bonsaished.com' );
			// Property Options
			set_theme_mod( 'property_permalink', 'property' );
			set_theme_mod( 'property_commenting', 'no' );
			set_theme_mod( 'property_ribbon_field', '_est_meta_price' );
			set_theme_mod( 'show_print', 'yes' );
			// Blog Options
			set_theme_mod( 'content_length', 'excerpt' );
			// Header Settings
			set_theme_mod( 'logo_image', get_template_directory_uri() . '/images/defaults/logo.png' );
			set_theme_mod( 'logo_full_width', 'no' );
			set_theme_mod( 'logo_image_retina', get_template_directory_uri() . '/images/defaults/logo@2x.png' );
			set_theme_mod( 'header_background_color', '#ffffff' );
			set_theme_mod( 'header_text_color', '#505050' );
			// Footer Settins
			set_theme_mod( 'show_footer', 'yes' );
			set_theme_mod( 'footer_background_color', '#232323' );
			set_theme_mod( 'footer_text_color', '#ffffff' );
			// Footer Bar Settings
			set_theme_mod( 'show_footer_bar', 'yes' );
			set_theme_mod( 'footer_bar_background_color', '#000000' );
			set_theme_mod( 'footer_bar_text_color', '#ffffff' );
			set_theme_mod( 'footer_bar_text', 'Estatement Theme By <a href="http://bonsaished.com">Bonsai Shed</a>' );
			// Featured Properties
			set_theme_mod( 'show_featured_properties', 'yes' );
			set_theme_mod( 'show_featured_properties', 'yes' );
			set_theme_mod( 'featured_properties_speed', '10' );
			set_theme_mod( 'featured_properties_count', '5' );
			set_theme_mod( 'featured_properties_to_show', 'latest' );
			set_theme_mod( 'featured_properties_category', '0' );
			set_theme_mod( 'featured_properties_info_1', '_est_meta_building_area' );
			set_theme_mod( 'featured_properties_info_2', '_est_meta_property_area' );
			// Contact Settings
			set_theme_mod( 'contact_reply_subject', 'Thank you for your message' );
			set_theme_mod( 'contact_reply_message', 'We\'ve received your message regarding our property <a href="!url">!title</a>. We read all messages and try and respond within 24 hours.' );

			set_theme_mod( 'contact_email', get_option( 'admin_email' ) );
			set_theme_mod( 'contact_success_message', 'Thank you for your message' );
			// Booking Options
			set_theme_mod( 'booking_email_subject', 'Thank you for your booking' );
			set_theme_mod( 'booking_email_message', 'Thank you for booking <a href="!url">!title</a>. We look forward to having you at our property, if you have any questions please let us know!' );
			// Error Options
			set_theme_mod( '404_title', 'Oh No, a page is missing' );
			set_theme_mod( '404_message', 'It seems that you have stumbled on to some missing content. Try going back to the <a href="' . home_url() . '">main page</a> and give it another go.' );
			set_theme_mod( '404_color', '#ffffff' );
			set_theme_mod( '404_background', '#000000' );
			set_theme_mod( '404_opacity', '0.4' );
			set_theme_mod( 'no_posts_title', 'There is no content here!' );
			set_theme_mod( 'no_posts_message', 'The page you are on exists, but there is no content added to it yet.' );
			set_theme_mod( 'no_search_title', 'Your search yielded no results :(' );
			set_theme_mod( 'no_search_message', 'Go back to try another search' );

		}

	}



	/*********************************/
	/*         1.9 Font Output       */
	/*********************************/

	public static function get_fontlist() {
		$fontlist = get_option( 'bs_fontlist' );
		if( empty( $fontlist ) ) {

			$fontlist = array();
			$fonts = unserialize( include( 'font_list.php' ) );
			$fontlist = array();
			foreach( $fonts->items as $font ) {
				$fontlist[$font->family] = $font->variants;
			}

			$builtin = array(
				'Helvetica Neue'    => 'Helvetica Neue',
				'Helvetica'         => 'Helvetica',
				'Arial'             => 'Arial',
				'Times New Roman'   => 'Times New Roman',
				'Verdana'           => 'Verdana',
				'Georgia'           => 'Georgia',
			);

			foreach( $builtin as $font ) {
				$fontlist[$font] = array( 'regular', 700 );
			}

			update_option( 'bs_fontlist', $fontlist );
		}
		return $fontlist;
	}

	public static function get_font_dropdown_options() {
		$fonts = self::get_fontlist();
		$options = array();
		foreach( $fonts as $font => $variations ) {
			$options[$font] = $font;
		}

		return $options;
	}


	public static function get_page_dropdown_options() {
		$pages = get_posts( 'post_type=page&posts_per_page=-1' );
		$options = array();
		$options[''] = __( 'Don\'t Show a Page', THEMENAME );
		foreach( $pages as $page ) {
			$options[$page->ID] = $page->post_title;
		}

		return $options;
	}


	public static function header_js_output() {
		global $post;

		if( !empty( $post ) ) {
			if( substr_count( get_post_meta( $post->ID, '_wp_page_template', true ), 'template-bshSearchPage.php' ) > 0 ) {
				$fonts['search_heading'] = get_theme_mod( 'search_page_heading' );
			}
		}

		$builtin = array(
			'Helvetica Neue'    => 'Helvetica Neue',
			'Helvetica'         => 'Helvetica',
			'Arial'             => 'Arial',
			'Times New Roman'   => 'Times New Roman',
			'Verdana'           => 'Verdana',
			'Georgia'           => 'Georgia',
		);

		$fonts['body']    = get_theme_mod( 'body_font' );
		$fonts['heading'] = get_theme_mod( 'heading_font' );

		$fontlist = self::get_fontlist();

		$request = 'http://fonts.googleapis.com/css?family=';

		$single_font = array();

		foreach( $fonts as $font ) {
			$single_request = $font;
			if( !in_array( $font, $builtin ) ) {
				$sizes = array( 400 );
				if( !empty( $fontlist[$font] ) AND in_array( 200, $fontlist[$font] ) ) {
					$sizes[] = 200;
				}
				if( !empty( $fontlist[$font] ) AND in_array( 700, $fontlist[$font] ) ) {
					$sizes[] = 700;
				}

				if( count( $sizes ) > 1 ) {
					$single_request .= ':' . implode( ',', $sizes );
				}

				$single_font[] = $single_request;
			}
		}

		$request .= implode( '|', $single_font );
		$request = str_replace( ' ', '+', $request );

		$request .= '&subset=latin';
		$font_set = get_theme_mod( 'font_character_set' );
		if( !empty( $font_set ) AND $font_set != 'latin' ) {
			if( $font_set == 'cyrillic-ext' ) {
				$font_set = 'cyrillic-ext,cyrillic';
			}
			$request .= ',' . $font_set;
		}

		$request = urlencode( $request );

		echo "<link href='" . $request . "' rel='stylesheet' type='text/css'>"

		?>



		<?php
	}

}

/***********************************************/
/*               2. Class Setup                */
/***********************************************/

add_action( 'init' , array( 'EstatementCustomize' , 'set_defaults' ) );
add_action( 'customize_register' , array( 'EstatementCustomize' , 'register' ) );
add_action( 'wp_head' , array( 'EstatementCustomize' , 'header_css_output' ) );
add_action( 'wp_head' , array( 'EstatementCustomize' , 'header_js_output' ) );
add_action( 'customize_preview_init' , array( 'EstatementCustomize' , 'live_preview' ) );


/***********************************************/
/*             3. Custom Controls              */
/***********************************************/

// 3.1 Custom Textarea

if( class_exists( 'WP_Customize_Control' ) ):
	class WP_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public $args = '';

		public function __construct( $manager, $id, $args ) {
			$this->args = $args;
        	parent::__construct( $manager, $id, $args );
		}

		public function render_content() {
			?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			<?php if( !empty( $this->args['description'] ) ) : ?>
			<p class='description'><?php echo esc_html( $this->args['description'] ) ?></p>
			<?php endif ?>
		</label>
		<?php
		}
	}
endif;

if( class_exists( 'WP_Customize_Control' ) ):
	class WP_Customize_Info extends WP_Customize_Control {

		public function __construct( $manager, $id, $args ) {
			$this->args = $args;
        	parent::__construct( $manager, $id, $args );
		}

		public function render_content() {
			?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php echo  $this->args['description'] ?>
		</label>
		<?php
		}
	}
endif;



/***********************************************/
/*           4. Preview AJAX Actions           */
/***********************************************/

add_action( 'wp_ajax_customizer_get_sidebar', 'customizer_get_sidebar' );
function customizer_get_sidebar() {
	$sidebar = ( $_POST['sidebar'] == 'mus_default' ) ? get_theme_mod( 'sidebar' ) : $_POST['sidebar'];

	dynamic_sidebar( $sidebar );
	die();

}

?>