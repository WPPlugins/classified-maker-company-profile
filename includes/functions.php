<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	
	
	function classified_maker_com_ajax_company_folowing(){
	

		$company_id = (int)$_POST['company_id'];
		$redirect = $_POST['redirect'];
		

		$html = array();
		
		
		if ( is_user_logged_in() ) 
			{
				$follower_id = get_current_user_id();
		
				global $wpdb;
				$table = $wpdb->prefix . "classified_maker_com_follow";
				$result = $wpdb->get_results("SELECT * FROM $table WHERE company_id = '$company_id' AND follower_id = '$follower_id'", ARRAY_A);
				$already_insert = $wpdb->num_rows;
			
				if($already_insert > 0 )
					{
							
						$wpdb->delete( $table, array( 'company_id' => $company_id, 'follower_id' => $follower_id), array( '%d','%d' ) );
						//$wpdb->query("UPDATE $table SET followed = '$followed' WHERE author_id = '$authorid' AND follower_id = '$follower_id'");

						$html['follower_id'] = $follower_id;
						$html['follow_status'] = 'unfollow';
						$html['follow_class'] = 'follow_no';
						$html['follow_text'] = 'Follow';						
					}
				else
					{
						$wpdb->query( $wpdb->prepare("INSERT INTO $table 
													( id, company_id, follower_id, follow)
											VALUES	( %d, %d, %d, %s )",
											array	( '', $company_id, $follower_id, 'yes')
													));
						
						$html['follower_id'] = $follower_id;
						$html['follow_status'] = 'following';
						$html['follow_class'] = 'follow_yes';
						$html['follow_text'] = 'Unfollow';	
						$html['follower_html'] = '<div class="follower follower-'.$follower_id.'">'.get_avatar( $follower_id, 32 ).'</div>';
	
						
					}

			}
		else
			{
				$html['login_error'] = __('Please <a href="'.wp_login_url($redirect).'">login</a> first.',classified_maker_com_textdomain);
			}
		
		
		echo json_encode($html);
		

		die();		

	}

add_action('wp_ajax_classified_maker_com_ajax_company_folowing', 'classified_maker_com_ajax_company_folowing');
add_action('wp_ajax_nopriv_classified_maker_com_ajax_company_folowing', 'classified_maker_com_ajax_company_folowing');


	
	add_filter('classified_maker_com_filter_company_single_header','classified_maker_com_filter_company_single_header');
	
	function classified_maker_com_filter_company_single_header($html){
	
		$company_id = get_the_ID();
		$follower_id = get_current_user_id();
		
		global $wpdb;
		$table = $wpdb->prefix . "classified_maker_com_follow";

		
		
		$html.= '<div class="follow">';
		
		$is_follow_query = $wpdb->get_results("SELECT * FROM $table WHERE company_id = '$company_id' AND follower_id = '$follower_id'", ARRAY_A);
		$is_follow = $wpdb->num_rows;
		if($is_follow > 0 ){
				
				$follow_text = __('Unfollow',classified_maker_com_textdomain);
			}
		else{
				$follow_text = __('Follow',classified_maker_com_textdomain);
			}
							
							
		$html.= '<span company_id="'.get_the_ID().'" redirect="'.$_SERVER['REQUEST_URI'].'" class="follow-button">'.$follow_text.'</span>';	
		
		
		
		$follower_query = $wpdb->get_results("SELECT * FROM $table WHERE company_id = '$company_id' ORDER BY id DESC LIMIT 10");

		$html.= '<div class="follower-list">';	
		
		foreach( $follower_query as $follower )
			{
				$follower_id = $follower->follower_id;
				$user = get_user_by( 'id', $follower_id );
				
				//var_dump($user);
				
				$html .= '<div title="'.$user->display_name.'" class="follower follower-'.$follower_id.'">';
				$html .= get_avatar( $follower_id, 50 );
				$html .= '</div>';
			}
		
		$html.= '</div>';
		
		$html.= '<div class="status"></div>';		
		$html.= '</div>';	
		$html.= '<div class="clear"></div>';
		
		return $html;
	
	}
	

	function classified_maker_com_ajax_submit_reviews(){
		
		$post_id = (int)$_POST['post_id'];
		$rate_value = (int)$_POST['rate_value'];	
		$rate_comment = sanitize_text_field($_POST['rate_comment']);	
		
		
		$current_user = wp_get_current_user();

		$comment_author_email = $current_user->user_email;
		$comment_author = $current_user->user_nicename;

		$data = array(
			'comment_post_ID' => $post_id,
			'comment_author_email' => $comment_author_email,	
			'comment_author_url' => '',	
			'comment_author' => $comment_author,						
			'comment_content' => $rate_comment,
			'comment_type' => '',
			'comment_parent' => 0,
			'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
			'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
			'comment_date' => current_time('mysql'),
			'comment_approved' => 1
		);
		
		
		$comments = get_comments( array( 'post_id' => $post_id, 'status' => 'all', 'author_email'=>$comment_author_email ) );
		
		
		if(!empty($comments)){
			
			echo '<i class="fa fa-times"></i> '.__('You already submitted a reviews',classified_maker_com_textdomain);

			
			}
		else{
			
			$comment_id = wp_insert_comment( $data );
			add_comment_meta( $comment_id, 'classified_maker_com_review_rate', $rate_value );
			
			echo '<i class="fa fa-check" aria-hidden="true"></i> '.__('Review submitted.',classified_maker_com_textdomain);
			}
		
		
		
		
		die();
		}

	add_action('wp_ajax_classified_maker_com_ajax_submit_reviews', 'classified_maker_com_ajax_submit_reviews');
	add_action('wp_ajax_nopriv_classified_maker_com_ajax_submit_reviews', 'classified_maker_com_ajax_submit_reviews');