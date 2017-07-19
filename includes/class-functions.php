<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_classified_maker_company_functions{
	
		public function __construct(){

		}
	

	
	public function company_input_fields(){
		
		$class_classified_maker_functions 		= new class_classified_maker_functions();
		$classified_maker_com_country_list		= $class_classified_maker_functions->country_list();


		
		$input_fields = array(
													
								'title'			=>'',
								'description'	=>'',
								'recaptcha'		=>true,	
																								
								'post_title'	=>array(
									'meta_key'=>'post_title',
									'css_class'=>'post_title',
									'placeholder'=>__('Company Title',classified_maker_com_textdomain),
									'title'=>__('Company Title', classified_maker_com_textdomain),
									'option_details'=>__('Write company title here', classified_maker_com_textdomain),					
									'input_type'=>'text',
									'input_values'=>'',
									'attributes'=>'',
									'required'=>'yes',
								),
								'post_content'=>array(
									'meta_key'=>'post_content',
									'css_class'=>'post_content',
									'placeholder'=>'',
									'title'=>__('Company details', classified_maker_com_textdomain),
									'option_details'=>__('Write company details here', classified_maker_com_textdomain),					
									'input_type'=>'wp_editor',
									'input_values'=>'',
									'attributes'=>'',
									'required'=>'yes',
									'input_args'=>array(),
								),
					
								'post_thumbnail'=>array(
									'meta_key'=>'post_thumbnail',
									'css_class'=>'post_thumbnail',
									'placeholder'=>'',
									'title'=>__('Thumbnail', classified_maker_com_textdomain),
									'option_details'=>__('Add some awesome images.', classified_maker_com_textdomain),					
									'input_type'=>'file', 
									'input_values'=>'',
									'attributes'=>'',
									'input_args'=>array(),
								),	

								'post_taxonomies'=>array(
								
														'company_cat'=>array(
															'meta_key'=>'company_cat',
															'css_class'=>'company_cat',
															'required'=>'no', // (yes, no) is this field required.
															'display'=>'yes', // (yes, no)															
															//'placeholder'=>'',
															'title'=>__('Company Category', classified_maker_com_textdomain),
															'option_details'=>__('Select company Category.', classified_maker_com_textdomain),					
															'input_type'=>'select', // text, radio, checkbox, select,
															'input_values'=>array(''), // could be array
															'input_args'=> classified_maker_get_terms('company_cat'), // 
															
															),
								
														),	

								
								'meta_fields'=>array(
								
										'general'=>array(
										
												'title'=>			__('General',classified_maker_com_textdomain),
												'details'=>			__('Company General Information.',classified_maker_com_textdomain),
												'meta_fields'=>		array(
												
																	'classified_maker_com_tagline'=>array(
																									'meta_key'=>'classified_maker_com_tagline',
																									'css_class'=>'loc_tagline',
																									'placeholder'=>'',
																									'title'=>__('Company Tagline', classified_maker_com_textdomain),
																									'input_values'=> '',
																									'option_details'=>__('Write company tagline here.', classified_maker_com_textdomain),					
																									'input_type'=>'text',
																									'attributes'=>'',
																									'required'=>'yes',
																									
																								),
												
												
									
																	
																	'classified_maker_com_mission'=>array(
																									'meta_key'=>'classified_maker_com_mission',
																									'css_class'=>'com_mission',
																									'placeholder'=>'',
																									'title'=>__('Company Mission', classified_maker_com_textdomain),
																									'input_values'=> '',
																									'option_details'=>__('Write company mission here.', classified_maker_com_textdomain),					
																									'input_type'=>'text',
																									'attributes'=>'',
																									'required'=>'yes',
																									
																								),
																	
																	'classified_maker_com_country'=>array(
																									'meta_key'=>'classified_maker_com_country',
																									'css_class'=>'com_country',
																									'placeholder'=>'',
																									'title'=>__('Country', classified_maker_com_textdomain),
																									'input_values'=> array(),
																									'option_details'=>'',					
																									'input_type'=>'select',
																									'input_args'=>$classified_maker_com_country_list,
																									'attributes'=>'',
																									
																								),
																	
																	'classified_maker_com_city'=>array(
																									'meta_key'=>'classified_maker_com_city',
																									'css_class'=>'com_city',
																									'placeholder'=>'',
																									'title'=>__('City', classified_maker_com_textdomain),
																									'input_values'=> '',
																									'option_details'=>__('Company city.', classified_maker_com_textdomain),					
																									'input_type'=>'text',
																									'required'=>'yes',
																								),
																	
																	'classified_maker_com_hq_address'=>array(
																									'meta_key'=>'classified_maker_com_hq_address',
																									'css_class'=>'com_hq_address',
																									'placeholder'=>'',
																									'title'=>__('Headquarters Address', classified_maker_com_textdomain),
																									'input_values'=> '',
																									'option_details'=>__('Comany headquarters address', classified_maker_com_textdomain),					
																									'input_type'=>'text',
																									'required'=>'yes',
																								),
																	
																	'classified_maker_com_address'=>array(
																									'meta_key'=>'classified_maker_com_address',
																									'css_class'=>'com_address',
																									'placeholder'=>'',
																									'title'=>__('Address', classified_maker_com_textdomain),
																									'input_values'=> '',
																									'attributes'=> '',
																									'required'=>'yes',
																									'option_details'=>__('Full Address, ex: House No: 254, Road: 5, Mirpur-12, Dhaka', classified_maker_com_textdomain),					
																									'input_type'=>'textarea',
																								),	
													
																	'classified_maker_com_website'=>array(
																									'meta_key'=>'classified_maker_com_website',
																									'css_class'=>'com_website',
																									'placeholder'=>'',
																									'title'=>__('Website', classified_maker_com_textdomain),
																									'input_values'=> '',
																									'attributes'=> '',
																									'required'=>'yes',
																									'option_details'=>__('http://www.example.com', classified_maker_com_textdomain),					
																									'input_type'=>'text',
																								),	
													
				
																				
												
																		)
																),
								
										'more'=>array(
										
												'title'=>			__('More',classified_maker_com_textdomain),
												'details'=>			__('Company More Information.',classified_maker_com_textdomain),
												'meta_fields'=>		array(
												
																	'classified_maker_com_founded'=>array(
																									'meta_key'=>'classified_maker_com_founded',
																									'css_class'=>'com_founded',
																									'placeholder'=>'',
																									'title'=>__('Founded', classified_maker_com_textdomain),
																									'input_values'=> '',
																									'attributes'=> '',
																									'required'=>'yes',
																									'option_details'=>__('ex: 1975', classified_maker_com_textdomain),					
																									'input_type'=>'text',
																								),	
																				
																	'classified_maker_com_revenue'=>array(
																									'meta_key'=>'classified_maker_com_revenue',
																									'css_class'=>'com_revenue',
																									'placeholder'=>'',
																									'title'=>__('Revenue', classified_maker_com_textdomain),
																									'input_values'=> '',
																									'attributes'=> '',
																									'option_details'=>__('Revenue Yearly ($)', classified_maker_com_textdomain),					
																									'input_type'=>'text',
																								),	
													
																	'classified_maker_com_size'=>array(
																								'meta_key'=>'classified_maker_com_size',
																								'css_class'=>'com_size',
																								'placeholder'=>'',
																								'title'=>__('Company Size', classified_maker_com_textdomain),
																								'input_values'=> '',
																								'attributes'=> '',
																								'required'=>'yes',
																								'option_details'=>__('1500 (peoples)', classified_maker_com_textdomain),					
																								'input_type'=>'text',
																							),	
												
																			)
																			
																	),
								
	
									

									
									
											
									
									
								)
		);

		$input_fields = apply_filters( 'classified_maker_filter_company_inputs', $input_fields );

		return $input_fields;
	}
	

} 

new class_classified_maker_company_functions();