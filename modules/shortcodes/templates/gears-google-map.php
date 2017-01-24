<?php
/**
 * Google Map Shortcode Template. This template handles the vanilla style and view of the 'Gears Google Map Shortcode'.
 *
 * @since  4.1.1
 * @package gears\modules\shortcodes\templates
 * @author  joseph g.
 */
if ( ! defined( 'ABSPATH') ) exit;

extract( shortcode_atts( array(
		'marker_title' => __("Info Title (use 'marker_title' shortcode paramater)", 'gears'),
		'marker_description' => __("Info Description (use 'marker_description' shortcode paramater)", 'gears'),
		'latitude' => -37.817214,
		'longitude' => 144.955925,
		'zoom_level' => 14,
		'infowindow_open' => 1,
		'map_height' => 450
	), $atts) );

?>

<style>
#gears-google-map {
	width: 100%;
	height: <?php echo esc_attr( $map_height ); ?>px;
}

#gears-gmap-info-title {
	color: #777;
	font-size: 12px;
}
#gears-gmap-info-title h2 {
	margin: 0;
	text-transform: uppercase;
	font-size: 12px;
	color: #444;
	margin-bottom: 10px;
}

</style>
<!--Start the Google Map-->
<div id="gears-google-map"></div>

<script>

jQuery(document).ready(function(){

	'use strict';

	// Define the Map Style.
	var map_style = <?php echo apply_filters( 'gears_google_map_style', '[{elementType:"geometry",stylers:[{color:"#f5f5f5"}]},{elementType:"labels.icon",stylers:[{visibility:"off"}]},{elementType:"labels.text.fill",stylers:[{color:"#616161"}]},{elementType:"labels.text.stroke",stylers:[{color:"#f5f5f5"}]},{featureType:"administrative.land_parcel",elementType:"labels.text.fill",stylers:[{color:"#bdbdbd"}]},{featureType:"poi",elementType:"geometry",stylers:[{color:"#eeeeee"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{color:"#e5e5e5"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#ffffff"}]},{featureType:"road.arterial",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#dadada"}]},{featureType:"road.highway",elementType:"labels.text.fill",stylers:[{color:"#616161"}]},{featureType:"road.local",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]},{featureType:"transit.line",elementType:"geometry",stylers:[{color:"#e5e5e5"}]},{featureType:"transit.station",elementType:"geometry",stylers:[{color:"#eeeeee"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#c9c9c9"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]}]'); ?>;

	var map_marker_settings = {
		infowindow_open: <?php echo absint( $infowindow_open ); ?>,
		latitude: <?php echo esc_attr( $latitude ); ?>,
		longitude: <?php echo esc_attr( $longitude ); ?>,
		zoom_level: <?php echo absint( $zoom_level ); ?>,
		info_window: {
			title: '<?php echo esc_html( $marker_title ); ?>',
			 desc: '<?php echo esc_html( $marker_description ); ?>',
		}
	};

	var coords = {
    	lat: map_marker_settings.latitude, // Latitude.
    	lng: map_marker_settings.longitude  // Longitude.
    };

    if ( typeof google !== 'undefined' ) {

	    var map = new google.maps.Map(document.getElementById('gears-google-map'), {
	      
	      center: coords,
	      
	      zoom: map_marker_settings.zoom_level,
	      
	      mapTypeControlOptions: {
	      	
	      	// Different Map Types.
	        mapTypeIds: [
	        	'roadmap', 
	        	'satellite', 
	        	'hybrid', 
	        	'terrain',
	        	'styled_map'
	        ]
	        
	      },

	      scrollwheel: false,
	      styles: map_style,

	    });

	    var info_title = map_marker_settings.info_window.title;

	    var info_description = map_marker_settings.info_window.desc;

	     // Info Window.
	    var info_template = "<div id='gears-gmap-info-title'><h2>"
	    		+ info_title
	    		+ "</h2><div id='gears-gmap-info-description'>"+info_description+"</div></div>";
	    
	    var infowindow = new google.maps.InfoWindow({
	     	content: info_template
	    });


	    var marker = new google.maps.Marker({
	     	position: coords,
	     	map: map,
	     	icon: '<?php echo plugins_url();?>/gears/assets/images/marker.png',
	     	title: map_marker_settings.info_window.title
	    });

	    if ( map_marker_settings.infowindow_open ) {

	    	infowindow.open(map, marker);
	    	
	    } 

	    marker.addListener('click', function() {
        	infowindow.open(map, marker);
        });

    } // end if ( typeof google !== 'undefined' )

});

</script>