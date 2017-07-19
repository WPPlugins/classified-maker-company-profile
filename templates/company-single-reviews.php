<?php
/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	$company_post_data = get_post(get_the_ID());
	
	$classified_maker_com_ads_login_page_id = get_option('classified_maker_com_ads_login_page_id');

		
		echo '<div  class="reviews">';
		
		
		$comments = get_comments( array( 'post_id' => get_the_ID(), 'status' => 'approve', 'number' => 5,) );
		//var_dump($comments);
		
		if(empty($comments)){

			$taotal_comments = 0;
			$taotal_rate = 0;		
			$ratings = 0;

			}
		else{
			
			//echo '<pre>'; print_r($comments);echo '</pre>';
			
			foreach($comments as $comment){
				
				$comment_ID = $comment->comment_ID;
				
				$review_rate[] = get_comment_meta( $comment_ID, 'classified_maker_com_review_rate', true );
				
				}

			$taotal_comments = count($review_rate);
			$taotal_rate = array_sum($review_rate);		
			$ratings = ($taotal_rate/$taotal_comments)*20;
			
			}

		echo '<div title="'.sprintf("%u&#37; - Total: %u",$ratings, $taotal_comments).'"  class="ratings"><div class="rate" style=" width:'.($ratings).'%;"></div></div><div class="ratings-des">'.sprintf("%u&#37; - Total: %u",$ratings, $taotal_comments).'</div>';
		
		echo '<ul  class="reviews-list">';		

			foreach($comments as $comment){
				$comment_content = $comment->comment_content;
				$comment_author_email = $comment->comment_author_email;	
				$comment_ID = $comment->comment_ID;								
				$rate = get_comment_meta( $comment_ID, 'classified_maker_com_review_rate', true );
				
				
				echo '<li class="review">';
				
				echo '';
				echo '<div class="comment"><div class="thumb">'.get_avatar( $comment_author_email, 50 ).'</div> <i class="fa fa-quote-left"></i> '.$comment_content.' <i class="fa fa-quote-right"></i></div>';
				//echo '<div class="rate">'.__(sprintf('Rate: %u', $rate),classified_maker_com_cp).'/5</div>';							
				
				echo '</li>';

				
				}
		
		
		echo '</ul>';
		
		
		echo '<div  class="reviews-input">
		
		<div  class="input-form">
		<span class="close"><i class="fa fa-times" aria-hidden="true"></i></span>';
		
		if(is_user_logged_in()){
			
			echo '<p>'.__('Rate',classified_maker_com_textdomain).'<br/>';
			
			echo '<select class="rate-value">';
			echo '<option value="5">5</option>';
			echo '<option value="4">4</option>';
			echo '<option value="3">3</option>';
			echo '<option value="2">2</option>';
			echo '<option value="1">1</option>';
			echo '</select>';
			
			echo '</p>';
			
			echo '<p>'.__('Comments',classified_maker_com_textdomain).'<br/>';
			echo '<textarea class="rate-comment">';
			echo '</textarea>';			
			echo '</p>';	
			echo '<div post-id="'.get_the_ID().'" class="submit button">Submit</div>';
			echo '<div class="message"></div>';
					
			
			
			}
		else{
			
			echo '<div class="message"><i class="fa fa-times"></i> '.__(sprintf('Please <a href="%s">login</a> to submit reviews',get_permalink($classified_maker_com_ads_login_page_id)),classified_maker_com_textdomain).'</div>';
			}
		
		
		echo '</div>
		</div>';	
	
		echo '</div>';



	
	
		
		
