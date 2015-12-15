<?php
/*
Template Name: Map Page
*/

get_header();


$use_user_location = get_post_meta( $post->ID, '_est_initial_location_auto', true );
$use_initial_coords = ( $use_user_location == 'coord' ) ? 'true' : 'false';
$use_user_location = ( $use_user_location == 'yes' ) ? 'true' : 'false';

if( $use_initial_coords === 'true' ) {
	$initial_location = get_post_meta( $post->ID, '_est_initial_location', true );
	$initial_location = explode( ',', $initial_location );
}
else {
	$initial_location = get_post_meta( $post->ID, '_est_initial_location_geocode', true );
	$initial_location = ( empty( $initial_location ) OR empty( $initial_location[0] ) OR empty( $initial_location[1] ) ) ? array( 38.830615, -104.824677 ) : $initial_location;
}

$marker_action = get_post_meta( $post->ID, '_est_marker_action', true );
$marker_action = ( empty( $marker_action ) ) ? 'popup' : $marker_action;

$icon = get_post_meta( $post->ID, '_est_marker', true );

$map_type = get_post_meta( $post->ID, '_est_map_type', true );
$map_type = ( empty( $map_type ) ) ? 'ROADMAP' : $map_type;

$error_behavior = get_post_meta( $post->ID, '_est_error_behavior', true );
$error_behavior = ( empty( $error_behavior ) ) ? 'show_error' : $error_behavior;

$show_advanced = get_post_meta( $post->ID, '_est_show_advanced', true );
$show_advanced = ( empty( $show_advanced ) ) ? 'no' : $show_advanced;

$location_bias = get_post_meta( $post->ID, '_est_location_bias', true );
$location_bias = ( empty( $location_bias ) ) ? '' : $location_bias;

$no_results_message = get_post_meta( $post->ID, '_est_no_results_message', true );
$no_results_message = ( empty( $no_results_message ) ) ? 'There are no results near that location. Please try a different location, or increase the distance in the additional options' : $no_results_message;

$initial_zoom = get_post_meta( $post->ID, '_est_map_initial_zoom', true );
$initial_zoom = ( empty( $initial_zoom ) ) ? 12 : $initial_zoom;

$full_map = get_post_meta( $post->ID, '_est_full_page_map', true );
$full_map = ( empty( $full_map ) ) ? 'yes' : $full_map;
$map_class = ( $full_map == 'yes' ) ? 'full'
: 'no-full';


$height = get_post_meta( $post->ID, '_est_map_height', true );
$height = str_replace( 'px', '', $height );
$map_style = ( $full_map == 'no' ) ? 'height:' . ( $height + 200 ) . 'px' : 'height: 100%';
$map_container_style = ( $full_map == 'no' ) ? 'height:' .  $height . 'px' : 'height: 100%';


$metas = get_post_meta( $post->ID );
$taxonomies = array();
foreach( $metas as $key => $value ) {
	if( substr_count( $key, '_est_taxonomy_' ) ) {
		$taxonomies[$key] = $value;
	}
}

if( !empty( $taxonomies ) ) {
	foreach( $taxonomies as $key => $taxonomy ) {
		$terms = @unserialize( $taxonomy[0] );
		unset( $taxonomies[$key]);
		$taxonomy = str_replace( '_est_taxonomy_', '', $key );
		if( !empty( $terms ) AND taxonomy_exists( $taxonomy ) ) {
			$taxonomies[$taxonomy] = $terms;
		}
	}

	if( !empty( $taxonomies ) ) {
		$args['tax_query'] = array();
		$args['tax_query']['relation'] = 'AND';
		foreach( $taxonomies as $taxonomy => $terms ) {

			$args['tax_query'][] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'ID',
				'terms'    => $terms,
				'operator' => 'IN'
			);


		}
	}
}

$taxonomies = json_encode($args['tax_query']);

$default_radius = get_post_meta( $post->ID, '_est_default_proximity', true );
$default_radius = ( empty( $default_radius ) )? 'auto' : $default_radius;

?>

	<div id='estatementMapContainer' style='<?php echo $map_container_style ?>'>
		<div id='estatementMapLoader'></div>

		<div id="estatementMap" class='map <?php echo $map_class ?>' style='<?php echo $map_style ?>'></div>

		<?php if( get_post_meta( get_the_ID(), '_est_search', true ) != 'no' ) : ?>
		  	<div id='searchContainer'>
				<form method='get' action='<?php echo site_url() ?>' id='map-page-form' class='custom'>
					<div id='main-search'>
						<input type='submit' class='submit button' value='<?php echo bs_get_post_meta( '_est_button_text', 'search' ); ?>'>
						<input type='text' id='addressInput' class='main-search-field' name='location' placeholder='<?php echo esc_attr( bs_get_post_meta( '_est_input_placeholder', 'Where would you like to live?' ) ) ?>'>
					</div>
					<div id='advanced-search' data-show_advanced='<?php echo $show_advanced ?>'>

						<?php
							$show = get_post_meta( get_the_ID(), '_est_show_proximity', true );
							$show = ( empty( $show ) ) ? 'yes' : $show;
							$show_style = ( $show == 'no' ) ? 'style="display:none"' : ''
						?>

						<div class='row form-row' <?php echo $show_style ?> >
							<div class='large-4 small-12 columns'>
								<?php
									$proximity_label = get_post_meta( get_the_ID(), '_est_proximity_label', true );
									$proximity_label = ( empty( $proximity_label ) ) ? __( 'Distance', THEMENAME ) : $proximity_label;
								?>
								<label for="$detail" class='offset'><?php echo $proximity_label ?></label>
							</div>

							<div class='large-8 small-12 columns' >
								<?php
						    		$options = get_post_meta( get_the_ID(), '_est_proximity_options', true );
									$options = ( empty( $options ) ) ? '25,50,100,200,500' : $options;
						    		$unit = get_post_meta( get_the_ID(), '_est_proximity_unit', true );
									$unit = ( empty( $unit ) ) ? 'mi' : $unit;
						    		$options = explode( ',', $options );
						    		$default = get_post_meta( get_the_ID(), '_est_default_proximity', true );
									$options[] = $default;
									sort($options);
									$options = array_unique( $options );
								?>
							    <select id="radiusSelect">
							    	<?php
							    		foreach( $options as $option ) :
							    			$option = trim( $option );
											$selected = ( $option == $default ) ? 'selected="selected"' : '';
							    	?>
										<option <?php echo $selected ?> value="<?php echo $option ?>"><?php echo $option ?><?php echo $unit ?></option>
								  	<?php endforeach ?>
							    </select>
							</div>
						</div>

							<?php
								$advanced_search = bs_get_post_meta( '_est_advanced_search', 'no' );
								if( $advanced_search == 'yes' ) :
							?>

								<?php

									$search['customdatas'] = get_post_meta( $post->ID, '_est_customdatas', true );
									$search['custom_taxonomies'] = get_post_meta( $post->ID, '_est_taxonomies', true );

									$details = get_search_options( $search );

									est_vertical_search( $details );
								?>


							<?php endif ?>


					</div>


					<div class='row'>
						<div class='large-12 small-12 columns'>
							<span id='advanced-search-switch' data-open_text='<?php echo bs_get_post_meta( '_est_advanced_search_text_open', 'less options' ) ?>' data-closed_text='<?php echo bs_get_post_meta( '_est_advanced_search_text', 'more options' ) ?>'>
								<?php echo bs_get_post_meta( '_est_advanced_search_text', 'more options' ) ?>
							</span>
						</div>
					</div>

				</form>
			</div>
		<?php endif ?>

	</div>

    <script type="text/javascript" src='<?php echo get_template_directory_uri() ?>/javascripts/vendor/infoBubble.js'></script>

	<script type='text/javascript'>
	( function( $ ) {


		// Get the user's location
		var user_location = [];
		var map = '';
		var markers = [];
		var infoBubble = '';
		var error_behavior = '<?php echo $error_behavior ?>';
		var zoom = <?php echo $initial_zoom ?>;
		var initial = true;

        infoBubble = new InfoBubble({
          shadowStyle: 1,
          padding: 0,
          borderRadius: 4,
          arrowSize: 10,
          borderWidth: 0,
          borderColor: '#ffffff',
          disableAutoPan: false,
          hideCloseButton: false,
          arrowPosition: 30,
          backgroundClassName: 'infoBubble',
          arrowStyle: 2
        });

		var get_user_location_options = {
			enableHighAccuracy: true,
			timeout: 5000,
			maximumAge: 0
		};

		function get_user_location_success( pos ) {
			var location = pos.coords;
			user_location.lat = location.latitude;
			user_location.lng = location.longitude
			initializeMap( user_location );
		};

		function get_user_location_error(err) {
			console.warn('ERROR(' + err.code + '): ' + err.message);
		};


		function get_user_location() {
			navigator.geolocation.getCurrentPosition( get_user_location_success, get_user_location_error, get_user_location_options );
		}


		// Loader

		function show_loader() {
			jQuery( '#estatementMapLoader' ).show();
		}

		function hide_loader() {
			jQuery( '#estatementMapLoader' ).fadeOut();
		}


		// Map Initialization

		function initializeMap( location ) {
			center = new google.maps.LatLng( location.lat, location.lng )

			var mapOptions = {
				center: center,
				zoom: zoom,
				mapTypeId: google.maps.MapTypeId.<?php echo strtoupper( $map_type ) ?>
			};
			map = new google.maps.Map(
				document.getElementById("estatementMap"),
				mapOptions
			);
		}


		function parseXml(str) {
			if (window.ActiveXObject) {
				var doc = new ActiveXObject('Microsoft.XMLDOM');
				doc.loadXML(str);
				return doc;
			}
			else if (window.DOMParser) {
				return (new DOMParser).parseFromString(str, 'text/xml');
			}
		}



		function createMarker(latlng, name, address, html, marker_url, icon) {
			if( icon === '' || typeof icon === 'undefined' || icon === null ) {
				marker_icon = '<?php echo $icon ?>';
			}
			else {
				marker_icon = icon;
			}

			var marker = new google.maps.Marker({
				map: map,
				position: latlng,
				icon: marker_icon,
			});


			google.maps.event.addListener(marker, 'click', function() {
				var marker_action = '<?php echo $marker_action ?>';
				if( jQuery(window).width() < 500 || marker_action == 'link' ) {
					window.location = marker_url;
				}
				else {
			   		infoBubble.setContent(html);
			   		infoBubble.open(map, marker);
			   		var height = jQuery( '#estatementMapContainer' ).height();
				if( jQuery('#estatementMap').hasClass( 'no-full' ) && height < 600 ) {
			    	jQuery( '#estatementMap, #estatementMapContainer' ).animate( {height: '600px' }, function() {
				    	//mapOffset( 0, -50 )

			    	})
				}
			}
			});

			markers.push(marker);

			return marker;
		}


function mapOffset(offsetx,offsety) {
	latlng = map.getCenter();
    var point1 = map.getProjection().fromLatLngToPoint(
        (latlng instanceof google.maps.LatLng) ? latlng : map.getCenter()
    );
    var point2 = new google.maps.Point(
        ( (typeof(offsetx) == 'number' ? offsetx : 0) / Math.pow(2, map.getZoom()) ) || 0,
        ( (typeof(offsety) == 'number' ? offsety : 0) / Math.pow(2, map.getZoom()) ) || 0
    );
    map.setCenter(map.getProjection().fromPointToLatLng(new google.maps.Point(
        point1.x - point2.x,
        point1.y + point2.y
    )));
}


		function getProperties( location, radius, clear ) {
			if( clear === '' || typeof clear === 'undefined' || clear === null ) {
				clear = true;
			}
			if( radius === 'auto' ) {
				radius = getBoundsRadius();
			}
			else if( radius === '' || typeof radius === 'undefined' || radius === null ) {
				radius = $( '#radiusSelect' ).val();
				if( radius === '' || typeof radius === 'undefined' || radius === null ) {
					radius = getBoundsRadius();
				}
			}


			if( location === '' || typeof location === 'undefined' || location === null ) {
				location = [];
				mapCenter = map.getCenter();
				location.lat = mapCenter.lat();
				location.lng = mapCenter.lng();

			}
			else {
				var center = new google.maps.LatLng( location.lat, location.lng );
				map.panTo( center )
			}

			var form_data = jQuery('#map-page-form').serialize();
                        console.log(estAjax.ajaxurl);
                        console.log(form_data);

			jQuery.ajax({
				url: estAjax.ajaxurl,
				type: 'post',
				data: {
					page_id: <?php echo $post->ID ?>,
					action: 'load_location_xml',
					radius : radius,
					form_data : form_data,
					taxonomies: <?php echo $taxonomies ?>,
					lat: location.lat,
					lng: location.lng
				},
				beforeSend: function() {
					show_loader();
					if( clear == true ) {
						clearLocations();
					}
				},
				dataType: 'text',
				success: function( data ) {
					hide_loader();

					var show_advanced = $('#advanced-search').data('show_advanced');
					if( show_advanced != 'yes'  ) {
						$('#advanced-search').slideUp();
					}
					else {
						if( initial == true ) {
							initial = false;
						}
						else {
							$('#advanced-search').slideUp();
						}
					}
					var xml = parseXml( data );
					var markerNodes = xml.documentElement.getElementsByTagName( 'marker' );
					var bounds = new google.maps.LatLngBounds();

					if( markerNodes.length == 0 && error_behavior === 'show_errors' ) {
						var marker = createMarker( map.getCenter(), 'No Properties', 'Address', '<?php echo addslashes ( $no_results_message ) ?>', '', '');
						infoBubble.setContent('<div class="map-no-results"><?php echo addslashes ( $no_results_message ) ?></div>');

						infoBubble.open( map, marker )
					}
					else {

						for (var i = 0; i < markerNodes.length; i++) {
							var name = markerNodes[i].getAttribute("name");
							var address = markerNodes[i].getAttribute("address");
							var html = markerNodes[i].getAttribute("html");
							var url = markerNodes[i].getAttribute("url");
							var icon = markerNodes[i].getAttribute("icon");
							var distance = parseFloat(markerNodes[i].getAttribute("distance"));
							var latlng = new google.maps.LatLng(
								parseFloat(markerNodes[i].getAttribute("lat")),
								parseFloat(markerNodes[i].getAttribute("lng"))
							);
							createMarker(latlng, name, address, html, url, icon);
							bounds.extend(latlng);
						}


					}

				}
			})
		}

		function clearLocations() {
			if ( markers.length > 0 ) {
				infoBubble.close();
				for (var i = 0; i < markers.length; i++) {
					markers[i].setMap(null);
				}
				markers.length = 0;
			}
		}


		function getBoundsRadius() {
			bounds = map.getBounds();
			center = map.getCenter();
			ne = bounds.getNorthEast();
			var r = 3963.0;
			var lat1 = center.lat() / 57.2958;
			var lon1 = center.lng() / 57.2958;
			var lat2 = ne.lat() / 57.2958;
			var lon2 = ne.lng() / 57.2958;
			var dis = r * Math.acos(Math.sin(lat1) * Math.sin(lat2) +
			  Math.cos(lat1) * Math.cos(lat2) * Math.cos(lon2 - lon1));

			var radius = Math.sqrt( ( dis * dis ) / 2 );
			return radius;
		}

		function getPropertiesNearAddress( address ) {
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode(
				{address: address},
				function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						var center = results[0].geometry.location;
						var location = [];
						location.lat = center.lat();
						location.lng = center.lng();
						getProperties( location );
					}
					else {
						var center = map.getCenter();
						var location = [];
						location.lat = center.lat();
						location.lng = center.lng();
						getProperties( location );
					}
				}
			)
		}

		var use_user_location = <?php echo $use_user_location ?>;
		var initial_location = [];
		initial_location.lat = '<?php echo $initial_location[0] ?>';
		initial_location.lng = '<?php echo $initial_location[1] ?>';

		if( use_user_location == true ) {
			get_user_location();
		}
		else {
			initializeMap( initial_location );
		}

		google.maps.event.addListenerOnce(map, 'idle', function(){
			getProperties( '', <?php echo $default_radius ?>);
		})

		google.maps.event.addListener(map, 'dragend', function(){
			getProperties( '', 'auto', false);
		})

		google.maps.event.addListener(map, 'zoom_changed', function(){
			getProperties( '', 'auto', false);
		})


		if (!document.addEventListener) {
			document.attachEvent('touchmove', function(e) {
				map.setOptions({draggable:false});
			});
		}
		else {
			document.addEventListener('touchmove', function(e) {
				map.setOptions({draggable:true});
			});

		}


		$( document ).on( 'submit', '#map-page-form', function() {
			address = $('#addressInput').val();
			address = address + ' ' + '<?php echo $location_bias ?>';
			getPropertiesNearAddress( address );
			return false;
		})






	} )( jQuery );
	</script>


<?php if( $full_map == 'no' ) : ?>

<?php get_template_part( 'module', 'featured' ) ?>

<div class='row mt44'>
	<div class='large-12 small-12 columns'>
		<div id='siteContent'>
			<div class='row'>
				<div id='siteMain' class='<?php echo bsh_content_classes() ?> columns'>

					<?php

						if( have_posts() ) {
							while( have_posts() ) {
								the_post();

								echo '<div class="content">';
									the_content();
								echo '</div>';
							}
						}
						else {

						}
					?>
				</div>
				<?php if( bsh_has_sidebar() ) : ?>
					<div id='siteSidebar' class='small-12 large-4 columns <?php echo bsh_sidebar_classes() ?>'>
						<?php dynamic_sidebar( bsh_get_sidebar() ) ?>
					</div>
				<?php endif ?>
			</div>

		</div>
	</div>
</div>

<?php endif ?>



<?php get_footer() ?>