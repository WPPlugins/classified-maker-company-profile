<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	$location = array();
	$wp_query = new WP_Query(
		array (
			'post_type' 	=> 'ads',
			'orderby' 		=> 'Date',
			'order' 		=> 'DESC',
			'post_status' 	=> 'publish',
			//'posts_per_page'=> 30,
		) 
	);
				
	if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();	
		
		$classified_maker_ads_company = get_post_meta( get_the_ID(), 'classified_maker_ads_company', true );
		//$loc = get_the_title();
		
		$wp_query_ads = new WP_Query(
			array (
				'post_type' 	=> 'ads',
				//'post_status' 	=> 'publish',
				'meta_query' => array(
					array(
						'key'     => 'classified_maker_ads_company',
						'value'   => $classified_maker_ads_company,
						'compare' => 'LIKE',
					),
				),
		) );
		
		$i = 0;
		if ( $wp_query_ads->have_posts() ) : while ( $wp_query_ads->have_posts() ) : $wp_query_ads->the_post();	
			$i++;
			$location[$classified_maker_ads_company][$i] = get_the_ID();		
		endwhile; endif;
		wp_reset_query();
		
			
	endwhile; endif;
	wp_reset_query();
	
	
	global $wpdb;
	
	$html .= '<script type="text/javascript"> var locations = [';
	$count = 0;
	foreach( $location as $loc => $loc_jobs ) 
	{
		$count++;
		
		$html_jobs = "<span class='google_map_city'>".$loc."</span><br>";
		$html_jobs .= '<ul>';
		
		foreach( $loc_jobs as $serial => $job_id ) 
		{
			$html_jobs .= "<li><a class='google_map_link' target='_blank' href='".get_permalink($job_id)."'>".get_the_title($job_id)."</a></li>";
		}
		
		$html_jobs .= '</ul>';
		
		$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='location'", $loc ));
		$classified_maker_com_latlang = get_post_meta( $post_id, 'classified_maker_com_latlang', true );
		
		if ( !empty($classified_maker_com_latlang) )
			$html .= '["'.$html_jobs.'", '.$classified_maker_com_latlang.', '.$count.'],';
	}
	
	$html .= ' ]; </script>';
	$html .= '<div id="map" style="width:100%; height:420px;"></div>';
	$html .= '
	<script type="text/javascript">
    	
	var styles = [
	  {
		stylers: [
		  { hue: "#0076D7" },
		  { saturation: -20 }
		]
	  },
	  {
		featureType: "road",
		elementType: "geometry",
		stylers: [
		  { lightness: 100 },
		  { visibility: "simplified" }
		]
	  },
	  {
		featureType: "road",
		elementType: "labels",
		stylers: [
		  { visibility: "off" }
		]
	  }
	];
	
    var map = new google.maps.Map(document.getElementById("map"), {
		zoom: 10,
		center: new google.maps.LatLng(locations[0][1], locations[0][2]),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: false,
		navigationControl: false,
		mapTypeControl: false,
		scaleControl: false
    });
	map.setOptions({styles: styles});
	
    var infowindow = new google.maps.InfoWindow();
    var marker, i;

    for ( i = 0; i < locations.length; i++){  
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			map: map
		});

		google.maps.event.addListener(marker, "mousemove", (function(marker, i) {
			return function() {
				infowindow.setContent(locations[i][0]);
				infowindow.open(map, marker);
			}
		})( marker, i ));
		
		/*google.maps.event.addListener(marker, "mouseout", (function(marker, i) {
			return function() {
				infowindow.setContent(locations[i][0]);
				infowindow.close(map, marker);
			}
		})( marker, i )); */
    }
	
  </script>';
		
	
	