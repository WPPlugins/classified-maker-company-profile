<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	$query_args= array('post_type'=>'location');
	
	$wp_query= new WP_Query($query_args);
	
	$html .= '<div class="ads-count-by-location">';
	
	if ( $wp_query->have_posts() ) :
		while ( $wp_query->have_posts() ) : $wp_query->the_post();	
		
		$ads_query_args= array('post_type'=>'location');
		
		$ads_wp_query= new WP_Query($ads_query_args);
		$ads_query = new WP_Query( array( 'post_type'=>'ads','meta_key' => 'classified_maker_ads_company', 'meta_value' => get_the_title() ) );
		
		
		$ads_count_by_company_data[get_the_ID()] = array('name'=>get_the_title(),'count'=>$ads_query->found_posts,'url'=>get_the_permalink());

		endwhile;
	
	wp_reset_query();
	endif;	
	
	
	
	$ads_query = new WP_Query( array( 'post_type'=>'ads' ) );
	
	ksort($ads_count_by_company_data);
	$html.='<div class="total">'.__('Total Ads Count',classified_maker_com_textdomain).' - '.$ads_query->found_posts.'</div>';
	
	$i=1;
	foreach($ads_count_by_company_data as $location_key=>$location_data){
		
		if($i<=$max_item){
				
				$html.='<div class="single-location"><a href="'.$location_data['url'].'">'.$location_data['name'].'</a> - '.$location_data['count'].'</div>';
			}

		$i++;
		}

	
	
	$html .= '</div>'; // .ads-count-by-location	

?>

