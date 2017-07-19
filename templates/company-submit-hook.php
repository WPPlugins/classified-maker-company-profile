<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	
	add_action('classified_maker_action_post_company_main','classified_maker_action_post_company_field_set');
	function classified_maker_action_post_company_field_set(){
	
		$class_classified_maker_pickform 		= new class_classified_maker_pickform();		
		$class_classified_maker_com_functions 	= new class_classified_maker_com_functions();
		$post_type_company_input_fields 		= $class_classified_maker_com_functions->post_type_company_input_fields();
			
		$top_input_field['post_title'] 			= $post_type_company_input_fields[0]['post_title'];	
		$top_input_field['post_content'] 		= $post_type_company_input_fields[0]['post_content'];
		$top_input_field['post_thumbnail'] 		= $post_type_company_input_fields[0]['post_thumbnail'];
		$meta_fields 							= $post_type_company_input_fields[0]['meta_fields'];
		
		
		
		foreach($top_input_field as $key=>$field) {
			?>
            <div class="item">
			
			<?php

			if( !empty($_POST) ) {
				
				if ( $key != 'post_thumbnail' ) {
					$meta_value = sanitize_text_field($_POST[$key]);
				} else {
					$meta_value = $_POST[$key];
				}
				$field[$key] = array_merge($field, array('input_values'=>$meta_value));
				$output_html = $class_classified_maker_pickform->field_set($field[$key]);
			} else{
				$output_html = $class_classified_maker_pickform->field_set($field);
			}
							
			echo $output_html;

			?>
            </div>
			<?php
		}

		foreach($meta_fields as $key=>$field){
			
			?><div class="item"><?php
				
			if(!empty($_POST)){
					
				$POST_KEY = isset($_POST[$key]) ? $_POST[$key] : '';
				
				if ( $key == 'classified_maker_com_type' ) {
					$meta_value = $POST_KEY;
				}
				else $meta_value = sanitize_text_field($POST_KEY);
				
				$field[$key] = array_merge($field, array('input_values'=>$meta_value));
				$output_html = $class_classified_maker_pickform->field_set($field[$key]);
				
			} else {
				$output_html = $class_classified_maker_pickform->field_set($field);
			}
			echo $output_html;
			
			?></div><?php
		}
	}
	
	
	
	
	add_action('classified_maker_action_post_company_save','classified_maker_action_post_company_save');
	function classified_maker_action_post_company_save(){
	
		$class_classified_maker_com_functions = new class_classified_maker_com_functions();
		$post_type_company_input_fields = $class_classified_maker_com_functions->post_type_company_input_fields();
		
		$classified_maker_com_submitted_com_status = get_option('classified_maker_com_submitted_com_status');
		
		if(empty($classified_maker_com_submitted_com_status)){
			$classified_maker_com_submitted_com_status='pending';
		}
		
		$userid = get_current_user_id();
		
		$post_title = sanitize_text_field($_POST['post_title']);
		$post_content = sanitize_text_field($_POST['post_content']);
		$post_thumbnail_id = ($_POST['post_thumbnail']);					
		
		$ads_post_data = array(
		  'post_title'    => $post_title,
		  'post_content'  => $post_content,
		  'post_status'   => $classified_maker_com_submitted_com_status,
		  'post_type'     => 'company',
		  'post_author'   => $userid,
		);
		
		$ads_ID = wp_insert_post($ads_post_data);

		update_post_meta( $ads_ID, '_thumbnail_id', $post_thumbnail_id[0] );
		
		$meta_fields = $post_type_company_input_fields[0]['meta_fields'];

	
		foreach($meta_fields as $field_key=>$field){
				
			if(!empty($_POST[$field_key])){
				
				if(is_array($_POST[$field_key])){
					$option_value = serialize($_POST[$field_key]);
				} else{
					$option_value = sanitize_text_field($_POST[$field_key]);
				}
			} else {
				$option_value = '';
			}
			update_post_meta($ads_ID, $field_key , $option_value);
		}
	}
	