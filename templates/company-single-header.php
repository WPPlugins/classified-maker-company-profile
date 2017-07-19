<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	$compnay_id = get_the_ID();



	$company_post_data = get_post($compnay_id);

	$class_classified_maker_company_functions = new class_classified_maker_company_functions();
	$company_input_fields = $class_classified_maker_company_functions->company_input_fields();
	
	//var_dump($company_meta_options);
	
	$meta_fields = $company_input_fields['meta_fields'];
	
	//echo '<pre>'.var_export($meta_fields, true).'</pre>';
	
	
	foreach($meta_fields as $fields_key => $fields_group){
		
		foreach($fields_group['meta_fields'] as $meta_key=>$field){
			
			$field[$meta_key] = get_post_meta($compnay_id, $meta_key, true);
			${$meta_key} = get_post_meta($compnay_id, $meta_key, true);			
			//var_dump(${$option_key});
			}
		}
 



	$header_html = '';
	echo '<div class="company-header">';
	
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
	$thumb_url = $thumb['0'];	
	
	if(!empty($thumb_url)){
		$header_html .= '<div class="thumb"><img src="'.$thumb_url.'" /></div>';
		}
	
	if(!empty($classified_maker_com_logo)){
		$header_html .= '<div class="logo"><img src="'.$classified_maker_com_logo.'" /></div>';
		}
	
	if(!empty($company_post_data->post_title)){
		$header_html .= '<h1 itemprop="name" class="name">'.get_the_title().'<span class="tagline">'.$classified_maker_com_tagline.'</span><span class="local">'.$classified_maker_com_country.' <i class="fa fa-angle-right"></i> '.$classified_maker_com_city.'</span></h1>';	
		$header_html .= '';			
		
		}

	echo apply_filters('classified_maker_com_filter_company_single_header',$header_html);		
	

	echo '</div>'; // .company-header	
		

	