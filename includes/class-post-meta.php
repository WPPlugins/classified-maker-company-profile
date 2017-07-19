<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_classified_maker_com_post_meta{
	
	public function __construct(){

		//add_action('add_meta_boxes', array($this, 'meta_boxes_company'));
		//add_action('save_post', array($this, 'meta_boxes_company_save'));

	}
	
	public function company_meta_options($options = array()){

		$class_classified_maker_functions		= new class_classified_maker_functions();
		$class_classified_maker_com_functions	= new class_classified_maker_com_functions();
		$classified_maker_com_country_list 		= $class_classified_maker_functions->country_list();
		$classified_maker_com_type 				= $class_classified_maker_com_functions->company_type();


		$options['Company Info'] = array(
			
								'classified_maker_com_type'=>array(
									'css_class'=>'classified_maker_com_type',					
									'title'=>__('Company Type',classified_maker_com_textdomain),
									'option_details'=>'',						
									'input_type'=>'checkbox', // text, radio, checkbox, select, 
									'input_values'=>'', // could be array
									'input_args'=>$classified_maker_com_type,
								),	
									
								'classified_maker_com_tagline'=>array(
									'css_class'=>'tagline',					
									'title'=>__('Company Tagline',classified_maker_com_textdomain),
									'option_details'=>'',						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=>'', // could be array
									'attributes'=>'', // could be array
									),	
									
									
									
								'classified_maker_com_mission'=>array(
									'css_class'=>'mission',					
									'title'=>__('Company Mission',classified_maker_com_textdomain),
									'option_details'=>'',						
									'input_type'=>'textarea', // text, radio, checkbox, select, 
									'input_values'=>'', // could be array
									),										
									
								'classified_maker_com_country'=>array(
									'css_class'=>'country',					
									'title'=>'Country',
									'option_details'=>__('Country',classified_maker_com_textdomain),						
									'input_type'=>'select', // text, radio, checkbox, select, 
									'input_values'=>'', // could be array
									'input_args'=>$classified_maker_com_country_list, // could be array									
									),	
																	
								'classified_maker_com_city'=>array(
									'css_class'=>'city',					
									'title'=>'City',
									'option_details'=>__('Company City',classified_maker_com_textdomain),						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=>'', // could be array
									),
									
								'classified_maker_com_hq_address'=>array(
									'css_class'=>'hq_address',					
									'title'=>__('Headquarters Address',classified_maker_com_textdomain),
									'option_details'=>__('Company City',classified_maker_com_textdomain),						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=>'', // could be array
									),									

								'classified_maker_com_address'=>array(
									'css_class'=>'address',					
									'title'=>__('Address',classified_maker_com_textdomain),
									'option_details'=>__('Full Address',classified_maker_com_textdomain),						
									'input_type'=>'textarea', // text, radio, checkbox, select, 
									'input_values'=>'', // could be array
									),									

								'classified_maker_com_logo'=>array(
									'css_class'=>'logo',					
									'title'=>__('Logo',classified_maker_com_textdomain),
									'option_details'=>__('Company Logo',classified_maker_com_textdomain),						
									'input_type'=>'file', // text, radio, checkbox, select, 
									'input_values'=>'', // could be array
									),	
																						

						);

			
			$options['More Info'] = array(
			
			
								'classified_maker_com_website'=>array(
									'css_class'=>'website',					
									'title'=>__('Website',classified_maker_com_textdomain),
									'option_details'=>__('Company website',classified_maker_com_textdomain),						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									),
												
								'classified_maker_com_founded'=>array(
									'css_class'=>'founded',					
									'title'=>__('Founded',classified_maker_com_textdomain),
									'option_details'=>'',						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									),		

								'classified_maker_com_revenue'=>array(
									'css_class'=>'revenue',					
									'title'=>__('Yearly Revenue',classified_maker_com_textdomain),
									'option_details'=>__('Yearly Revenue ($)',classified_maker_com_textdomain),						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									),
																		
								'classified_maker_com_size'=>array(
									'css_class'=>'size',					
									'title'=>__('Size',classified_maker_com_textdomain),
									'option_details'=>__('Emplyee Size',classified_maker_com_textdomain),						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									),								
																										
								'classified_maker_com_type'=>array(
									'css_class'=>'type',					
									'title'=>'Type',
									'option_details'=>__('Company Type',classified_maker_com_textdomain),						
									'input_type'=>'checkbox', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									'input_args'=> apply_filters('classified_maker_com_filters_company_types',array())
									),										

						);

		$options = apply_filters( 'classified_maker_filter_company_meta', $options );

		return $options;
		
	}
	
	
	public function company_meta_options_form(){
		
			global $post;
			
			$company_meta_options = $this->company_meta_options();
			//var_dump($job_meta_options);
			$html = '';
			
			$html.= '<div class="para-settings job-bm-cp-settings">';			

			$html_nav = '';
			$html_box = '';
					
			$i=1;
			foreach($company_meta_options as $key=>$options){
			if($i==1){
				$html_nav.= '<li nav="'.$i.'" class="nav'.$i.' active">'.$key.'</li>';				
				}
			else{
				$html_nav.= '<li nav="'.$i.'" class="nav'.$i.'">'.$key.'</li>';
				}
				
				
			if($i==1){
				$html_box.= '<li style="display: block;" class="box'.$i.' tab-box active">';				
				}
			else{
				$html_box.= '<li style="display: none;" class="box'.$i.' tab-box">';
				}

				
			foreach($options as $option_key=>$option_info){

				$option_value =  get_post_meta( $post->ID, $option_key, true );
				//var_dump($option_value);
				
				
				if(empty($option_value)){
					$option_value = $option_info['input_values'];
					}
				
				
				$html_box.= '<div class="option-box '.$option_info['css_class'].'">';
				$html_box.= '<p class="option-title">'.$option_info['title'].'</p>';
				$html_box.= '<p class="option-info">'.$option_info['option_details'].'</p>';
				
				if($option_info['input_type'] == 'text'){
				$html_box.= '<input type="text" placeholder="" name="'.$option_key.'" value="'.$option_value.'" /> ';					

					}
				elseif($option_info['input_type'] == 'textarea'){
					$html_box.= '<textarea placeholder="" name="'.$option_key.'" >'.$option_value.'</textarea> ';
					
					}
					
					
					
					
				elseif($option_info['input_type'] == 'radio'){
					
					$input_args = $option_info['input_args'];
					
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if($input_args_key == $option_value){
							$checked = 'checked';
							}
						else{
							$checked = '';
							}
							
						$html_box.= '<label><input class="'.$option_key.'" type="radio" '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'"   >'.$input_args_values.'</label><br/>';
						}
					
					
					}
					
					
				elseif($option_info['input_type'] == 'select'){
					
					$input_args = $option_info['input_args'];
					$html_box.= '<select name="'.$option_key.'" >';
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if($input_args_key == $option_value){
							$selected = 'selected';
							}
						else{
							$selected = '';
							}
						
						$html_box.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';

						}
					$html_box.= '</select>';
					
					}					
					
					
					
					
					
					
					
					
				elseif($option_info['input_type'] == 'checkbox'){
					
					$input_args = $option_info['input_args'];
					
					foreach($input_args as $input_args_key=>$input_args_values){
						
						
						if(empty($option_value[$input_args_key])){
							$checked = '';
							}
						else{
							$checked = 'checked';
							}
						$html_box.= '<label><input '.$checked.' value="'.$input_args_values.'" name="'.$option_key.'['.$input_args_key.']"  type="checkbox" >'.$input_args_values.'</label><br/>';
						
						
						}
					
					
					}
					
				elseif($option_info['input_type'] == 'file'){
					
					$html_box.= '<input type="text" id="file_'.$option_key.'" name="'.$option_key.'" value="'.$option_value.'" /><br />';
					
					$html_box.= '<input id="upload_button_'.$option_key.'" class="upload_button_'.$option_key.' button" type="button" value="'.__('Upload File',classified_maker_com_textdomain).'" />';					
					
					$html_box.= '<br /><br /><div style="overflow:hidden;max-height:150px;max-width:150px;" class="logo-preview"><img width="100%" src="'.$option_value.'" /></div>';
					
					$html_box.= '
<script>
								jQuery(document).ready(function($){
	
									var custom_uploader; 
								 
									jQuery("#upload_button_'.$option_key.'").click(function(e) {
	
										e.preventDefault();
								 
										//If the uploader object has already been created, reopen the dialog
										if (custom_uploader) {
											custom_uploader.open();
											return;
										}
								
										//Extend the wp.media object
										custom_uploader = wp.media.frames.file_frame = wp.media({
											title: "Choose File",
											button: {
												text: "Choose File"
											},
											multiple: false
										});
								
										//When a file is selected, grab the URL and set it as the text field\'s value
										custom_uploader.on("select", function() {
											attachment = custom_uploader.state().get("selection").first().toJSON();
											jQuery("#file_'.$option_key.'").val(attachment.url);
											jQuery(".logo-preview img").attr("src",attachment.url);											
										});
								 
										//Open the uploader dialog
										custom_uploader.open();
								 
									});
									
									
								})
							</script>
					
					';					
					
					
					
					
					}		
					
					
										
					
								
				$html_box.= '</div>';
				
				}
			$html_box.= '</li>';
			
			
			$i++;
			}
			
			
			$html.= '<ul class="tab-nav">';
			$html.= $html_nav;			
			$html.= '</ul>';
			$html.= '<ul class="box">';
			$html.= $html_box;
			$html.= '</ul>';		
			
			
			
			$html.= '</div>';			
			return $html;
		}
	
	
	
	
	public function meta_boxes_company($post_type) {
			$post_types = array('company');
	 
			//limit meta box to certain post types
			if (in_array($post_type, $post_types)) {
				add_meta_box('company_metabox',
				__('company Data',classified_maker_com_textdomain),
				array($this, 'company_meta_box_function'),
				$post_type,
				'normal',
				'high');
			}
		}
	public function company_meta_box_function($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('company_nonce_check', 'company_nonce_check_value');
 
        // Use get_post_meta to retrieve an existing value from the database.
       // $classified_maker_com_data = get_post_meta($post -> ID, 'classified_maker_com_data', true);

		$company_meta_options = $this->company_meta_options();
		
		//var_dump($job_meta_options);
		foreach($company_meta_options as $options_tab=>$options){
			
			foreach($options as $option_key=>$option_data){
				
				${$option_key} = get_post_meta($post -> ID, $option_key, true);

				}
			}
			
		//var_dump($classified_maker_com_salary_currency);
        // Display the form, using the current value.
		
		?>
        <div class="job-bm-cp-meta">
        
        <?php
		
		
        echo $this->company_meta_options_form(); 
		?>
        </div>
        <?php
		

		
		




   		}
	
	
	public function meta_boxes_company_save($post_id){
	 
			/*
			 * We need to verify this came from the our screen and with 
			 * proper authorization,
			 * because save_post can be triggered at other times.
			 */
	 
			// Check if our nonce is set.
			if (!isset($_POST['company_nonce_check_value']))
				return $post_id;
	 
			$nonce = $_POST['company_nonce_check_value'];
	 
			// Verify that the nonce is valid.
			if (!wp_verify_nonce($nonce, 'company_nonce_check'))
				return $post_id;
	 
			// If this is an autosave, our form has not been submitted,
			//     so we don't want to do anything.
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return $post_id;
	 
			// Check the user's permissions.
			if ('page' == $_POST['post_type']) {
	 
				if (!current_user_can('edit_page', $post_id))
					return $post_id;
	 
			} else {
	 
				if (!current_user_can('edit_post', $post_id))
					return $post_id;
			}
	 
			/* OK, its safe for us to save the data now. */
	 
			// Sanitize the user input.
			//$classified_maker_com_data = stripslashes_deep($_POST['classified_maker_com_data']);
	
			
			// Update the meta field.
			//update_post_meta($post_id, 'classified_maker_com_data', $classified_maker_com_data);
			
			$company_meta_options = $this->company_meta_options();
			
			foreach($company_meta_options as $options_tab=>$options){
				
				foreach($options as $option_key=>$option_data){
					
					${$option_key} = stripslashes_deep($_POST[$option_key]);
					
					update_post_meta($post_id, $option_key, ${$option_key});			
					
					}
				}
			
			
			
			
			
					
		}
	
	}


new class_classified_maker_com_post_meta();