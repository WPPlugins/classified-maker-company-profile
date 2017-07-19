<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_classified_maker_shortcodes_company_list{
	
    public function __construct(){
		
		add_shortcode( 'classified_maker_company_list', array( $this, 'classified_maker_company_list' ) );

		
   	}

		
	public function classified_maker_company_list($atts, $content = null ) {
		$atts = shortcode_atts( 
			array(

		), $atts);
		
		$post_per_page = 5;
		
		
		$html = '';
			
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
	
		$wp_query = new WP_Query( array (
			'post_type' => 'company',
			'post_status' => 'publish',	
			'orderby' => 'date',
			'posts_per_page'=>-1,
			'order' => 'DESC',				
			'paged' => $paged,
		) );
						
				
		$html .= '<div class="company-list">';						
						
		if( $wp_query->have_posts() ) :
		while ($wp_query->have_posts()) : $wp_query->the_post();

			$company_post_data = get_post(get_the_ID());
		
			/*
			//unset($meta_query);
			$meta_query[] = array(
				'key' => 'job_bm_company_name',
				'value' => $company_post_data->post_title,
				'compare' => '=',
			); */
				
		$wp_query_custom = new WP_Query(
				array (
				'post_type' => 'ads',
				'post_status' => 'publish',
				//'meta_query' => $meta_query,
			) );
		
			/*if ( $allow_empty_job_showing == 'false' )
			{
				if ( $wp_query_custom->found_posts < 1 )
					continue;
			}*/
		
		
		$html .= '<div class="single">';

		$html .= '<div style="padding-bottom: 10px; padding-left: 10px; padding-top: 10px; padding-right: 10px;">';
		
		$classified_maker_com_logo = get_post_meta(get_the_ID(),'classified_maker_com_logo', true);
		if( empty($classified_maker_com_logo) ) $classified_maker_com_logo = classified_maker_com_plugin_url.'assets/global/images/company.png';
			
		$html .= '<img align="left" src=" '.$classified_maker_com_logo.' ">
					<div style="margin:0px 0px -5px 62px;">
						<div class="hotadssCompanyName">
							<strong><a href="'.get_permalink().'">'.$company_post_data->post_title.'</a></strong>
						</div> 
						<ul class="hotadssBullet">';
						
		//---------- loading ads list START ----------------------------// 
				$count = 0;
				
				
				if ( $wp_query_custom->have_posts() ):
				
				while ( $wp_query_custom->have_posts() ) : $wp_query_custom->the_post();	
					
					if ( $count < $post_per_page )
						//$html .= '<li><a href="'.get_permalink().'" target="_blank">'.get_the_title().'</a></li>';		
				
					$count++;
					
				endwhile;
				
				else: $html .= '';
				endif;
				wp_reset_query();
		//---------- loading ads list END ----------------------------// 
		
		$html .= '</ul></div>
				</div>';
		
		
		
		$html .= '</div>';
		
		endwhile;
		
		
		$html .= '<div class="paginate">';
		$big = 999999999; // need an unlikely integer
		$html .= paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $paged ),
			'total' => $wp_query->max_num_pages
			) );
	
		$html .= '</div >';	
		
		
		
		
		wp_reset_query(); 
		endif;
		
		$html .= '</div>';		

		return $html;
	}
	
	

	
} 

new class_classified_maker_shortcodes_company_list();