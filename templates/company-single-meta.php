<?php
/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	$compnay_id = get_the_ID();


	$company_post_data = get_post(get_the_ID());

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
		
		
		


	echo '<div class="meta-info">';	
		
	if(!empty($classified_maker_com_address)){
	echo '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="meta"><strong><i class="fa fa-map-marker"></i>'.__('Address: ','classified_maker_com').'</strong>'.$classified_maker_com_address.'</div>';
		}		
		
	if(!empty($classified_maker_com_website)){
	echo '<div class="meta"><strong><i class="fa fa-link"></i>'.__('Website: ','classified_maker_com').'</strong>'.$classified_maker_com_website.'</div>';
		}

	
	
	$company_type = '';
	
	if(!empty($classified_maker_com_type)){

		foreach($classified_maker_com_type as $type_key=>$type_name){
			
			$company_type.= $type_name.', ';
			}
	
	
			echo '<div class="meta"><strong><i class="fa fa-flag-o"></i>'.__('Type: ','classified_maker_com').'</strong>'.$company_type.'</div>';
		}

	if(!empty($classified_maker_com_founded)){
		
		echo '<div class="meta"><strong><i class="fa fa-calendar-o"></i>'.__('Founded: ','classified_maker_com').'</strong>'.$classified_maker_com_founded.'</div>';	
	
	}
	if(!empty($classified_maker_com_size)){
		
		echo '<div class="meta"><strong><i class="fa fa-users"></i>'.__('Size: ','classified_maker_com').'</strong>'.$classified_maker_com_size.'</div>';
		}
	if(!empty($classified_maker_com_revenue)){
		
		echo '<div class="meta"><strong><i class="fa fa-money"></i>'.__('Revenue: ','classified_maker_com').'</strong>$'.$classified_maker_com_revenue.'</div>';
		}
	
	
	echo '</div>'; // .meta-info
	
	
	
	
	if(!empty($classified_maker_com_mission)){
		
		echo '<div class="mission"><strong><i class="fa fa-rocket"></i>'.__('Mission: ','classified_maker_com').'</strong>'.$classified_maker_com_mission.'</div>';
		
		}

	if(!empty($company_post_data->post_content)){
		echo '<div  class="description">'.wpautop(get_the_content()).'</div>';
		}	
	
	
	
		
		
