<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	add_action( 'classified_maker_action_com_single_main', 'classified_maker_template_com_single_header', 10 );
	add_action( 'classified_maker_action_com_single_main', 'classified_maker_template_com_single_reviews', 10 );
	add_action( 'classified_maker_action_com_single_main', 'classified_maker_template_com_single_meta', 10 );
	//add_action( 'classified_maker_action_com_single_main', 'classified_maker_com_template_single_ads_list', 20 );	
	add_action( 'classified_maker_action_com_single_main', 'classified_maker_com_template_single_related', 20 );	

	if ( ! function_exists( 'classified_maker_template_com_single_header' ) ) {
		function classified_maker_template_com_single_header() {
			require_once( classified_maker_com_plugin_dir. 'templates/company-single-header.php');
		}
	}
	
	if ( ! function_exists( 'classified_maker_template_com_single_reviews' ) ) {
		function classified_maker_template_com_single_reviews() {
			require_once( classified_maker_com_plugin_dir. 'templates/company-single-reviews.php');
		}
	}
	
	if ( ! function_exists( 'classified_maker_template_com_single_meta' ) ) {
		function classified_maker_template_com_single_meta() {
			require_once( classified_maker_com_plugin_dir. 'templates/company-single-meta.php');
		}
	}

	if ( ! function_exists( 'classified_maker_com_template_single_ads_list' ) ) {
		function classified_maker_com_template_single_ads_list() {
			require_once( classified_maker_com_plugin_dir. 'templates/company-single-ads-list.php');
		}
	}

	
	if ( ! function_exists( 'classified_maker_com_template_single_related' ) ) 
	{
		function classified_maker_com_template_single_related() 
		{
			$check = 0;
			$id = get_the_ID();
			$classified_maker_com_country = get_post_meta( $id,'classified_maker_com_country', true);
			
			$wp_query = new WP_Query(
				array (
					'post_type' => 'company',
					'orderby' => 'Date',
					'order' => 'DESC',
					'meta_query' => array(
						array(
							'key' => 'classified_maker_com_country',
							'value' => $classified_maker_com_country,
							'compare' => 'LIKE',
						),
					)
				) );
			
			$html = '';	
			$html .= '<h2 class="related-company-header">'.__('Related company',classified_maker_com_textdomain).'</h2>';
			$html .= '<div class="related-company-container">';
			
			if ( $wp_query->have_posts() ) :
				while ( $wp_query->have_posts() ) : $wp_query->the_post();	
			
			//if( $id != get_the_ID() ): //$check = 1;	//remove current company
			
				$html .= '<div class="single-company">';
				
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
				$thumb_url = $thumb['0'];	
				if(empty($thumb_url))  {
					
					$classified_maker_com_display_img_from_map = get_option('classified_maker_com_display_img_from_map');
					if ( !empty($classified_maker_com_display_img_from_map) && $classified_maker_com_display_img_from_map == 'yes' ) {
						
						$classified_maker_com_latlang 	= get_post_meta(get_the_ID(),'classified_maker_com_latlang', true);
						if ( !empty($classified_maker_com_latlang) ) {
							$classified_maker_com_latlang 	= explode(',',$classified_maker_com_latlang);
							if(!empty($classified_maker_com_latlang[0]))
								$classified_maker_com_latlang['lat'] =$classified_maker_com_latlang[0];
							else $classified_maker_com_latlang['lat'] ='';
							if(!empty($classified_maker_com_latlang[1]))
								$classified_maker_com_latlang['lng'] =$classified_maker_com_latlang[1];
							else $classified_maker_com_latlang['lng'] ='';
							
							$thumb_url = 'https://maps.googleapis.com/maps/api/staticmap?center='.$classified_maker_com_latlang['lat'].','.$classified_maker_com_latlang['lng'].'&zoom=12&size=300x300&markers=color:red|label:C|'.$classified_maker_com_latlang['lat'].','.$classified_maker_com_latlang['lng'];
						} else {
							$thumb_url = classified_maker_com_plugin_url .'asset/front/images/map.png';
						}
					
					} else {
						$thumb_url = classified_maker_com_plugin_url .'asset/front/images/map.png';
					}
				}
				
				$html .= '<div class="thumb"><a href="'.get_the_permalink().'"><img src="'.$thumb_url.'" /></a></div>';
				$html .= '<span itemprop="name" class="name"><a href="'.get_the_permalink().'">'.get_the_title().'</a></span>';	

				$html .= '</div>'; // single company
			
			//endif;  //remove current company
			
			
				endwhile;
			wp_reset_query();
			
			$html .= '</div>'; // company container
			endif;
			
			//if ( $check == 1 ) 
				echo $html;
		
		}
	}





if ( ! function_exists( 'classified_maker_com_template_single_css' ) ) {

	
	function classified_maker_com_template_single_css() {
				
		require_once( classified_maker_com_plugin_dir. 'templates/company-single-css.php');
	}
}








function get_custom_post_type_template_company($single_template) {
		 global $post;

		 if ($post->post_type == 'company') {
			  $single_template = classified_maker_com_plugin_dir . 'templates/company-single.php';
		 }
		 return $single_template;
	}
	add_filter( 'single_template', 'get_custom_post_type_template_company' );