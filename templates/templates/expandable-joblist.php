<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	$loc_expand = array();
	
	$wp_query = new WP_Query(
		array (
			'post_type' 	=> 'location',
			'orderby' 		=> 'Date',
			'order' 		=> 'DESC',
			'post_status' 	=> 'publish',
		) 
	);
	
	if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();	
		
		$location = get_the_title();
		$job_bm_company_country_code = get_post_meta( get_the_ID(), 'job_bm_company_country_code', true );
		
		$wp_query_job = new WP_Query(
			array (
				'post_type' 	=> 'job',
				'post_status' 	=> 'publish',
				'meta_query' => array(
					array(
						'key'     => 'job_bm_company',
						'value'   => $location,
						'compare' => 'LIKE',
					),
				),
		) );
		
		$i = 0;
		if ( $wp_query_job->have_posts() ) : while ( $wp_query_job->have_posts() ) : $wp_query_job->the_post();	
			$i++;
		
			$loc_expand[$job_bm_company_country_code][$location][$i] = get_the_ID();
		
		endwhile; endif;
		wp_reset_query();
	
	endwhile; endif;
	wp_reset_query();
	
	
	$class_job_bm_companys_functions = new class_job_bm_companys_functions();
	$job_bm_companys_country_list = $class_job_bm_companys_functions->job_bm_companys_country_list();
	
	
	$html .= '
	<div class="job_bm_expand_loc">
	<ul>';
	
	foreach( $loc_expand as $country => $locations ){
		
		$html .= '<li><a href="#">'.$job_bm_companys_country_list[$country].'</a>
			<ul>';

		foreach( $locations as $location => $jobs ){
			$html .= '
				<li>
					<a href="#">'.$location.'</a>
					<ul>';
					
					foreach( $jobs as $serial => $job_id ){
						$html .= '<li><a   href="'.get_the_permalink($job_id).'"><i class="fa fa-dot-circle-o"></i> '.get_the_title($job_id).'</a></li>';
					}
			$html.='			
					</ul>
				</li>';
		}
		
		$html.=	'</ul>
		</li>';
	}
	
$html .= '
	</ul>
</div>
	';
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	