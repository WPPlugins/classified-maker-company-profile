<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	$location_post_data = get_post(get_the_ID());
	
	
	echo '<h2 class="ads-list-header">'.__(sprintf('Ads available from - %s', $location_post_data->post_title),classified_maker_com_textdomain).'</h2>';		
	echo do_shortcode('[classified_maker_archive location="'.$location_post_data->post_title.'"]');