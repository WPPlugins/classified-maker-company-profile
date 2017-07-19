<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_classified_maker_shortcodes_company_submit{
	
    public function __construct(){
		
		add_shortcode( 'classified_maker_company_submit', array( $this, 'classified_maker_company_submit' ) );
		
   	}

	
	
	public function classified_maker_company_submit($atts, $content = null ) {
		$atts = shortcode_atts( 
			array(

		), $atts);
		
		$html = '';
			
		include classified_maker_com_plugin_dir .'templates/company-submit.php';

		return $html;
	}
	
	
	
} 

new class_classified_maker_shortcodes_company_submit();