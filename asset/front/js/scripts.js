jQuery(document).ready(function($)
	{

		$(document).on('click', 'span.follow-button', function()
			{
				var company_id = $(this).attr('company_id');
				var redirect = $(this).attr('redirect');
				
				var pre_html = $(this).html();
				$(this).html('<i class="fa fa-spin fa-cog" aria-hidden="true"></i>');
				
				
				
				$.ajax(
					{
				type: 'POST',
				context: this,
				url:classified_maker_com_ajax.classified_maker_com_ajaxurl,
				data: {"action": "classified_maker_com_ajax_company_folowing", "company_id":company_id,"redirect":redirect,},
				success: function(data)
				{	
					var html = JSON.parse(data)
					var login_error = html['login_error'];
					var follow_status = html['follow_status'];
					var follow_text = html['follow_text'];								
					var follow_class = html['follow_class'];
					var follower_html = html['follower_html'];																		
					var follower_id = html['follower_id'];	
					
					$(this).html(pre_html);
				
					if(follow_status=='following'){
						$('.follower-list').prepend(follower_html);
						$(this).html(follow_text);	
					
					} else if(follow_status=='unfollow'){
									
						$('.follower-list .follower-'+follower_id).fadeOut();	
						$(this).html(follow_text);
					
					} else {
						$('.follow .status' ).html(login_error);
					}
					
				}
					});
			})
			
			
		$(document).on('click', '.single-company .reviews .submit', function()
			{
				$(this).addClass('loading');
				
				var post_id = $(this).attr('post-id');				
				var rate_value = $('.rate-value').val();
				var rate_comment = $('.rate-comment').val();				
		
				$.ajax(
					{
				type: 'POST',
				context: this,
				url:classified_maker_com_ajax.classified_maker_com_ajaxurl,
				data: {"action": "classified_maker_com_ajax_submit_reviews", "post_id":post_id,"rate_value":rate_value,"rate_comment":rate_comment,},
				success: function(data)
				{	
					$('.reviews .reviews-input .message').html(data);
					$(this).removeClass('loading');
				}
					
					});				
				
			})		
				
				
		$(document).on('click', '.single-company .reviews .ratings', function()
			{
				$('.reviews-input').fadeIn();
			})
	
	
		$(document).on('click', '.single-company .reviews .reviews-input .close', function()
			{
				$(this).parent().parent().fadeOut();
			})	
	
		
		
	});	

