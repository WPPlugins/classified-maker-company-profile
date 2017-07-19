<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 




	if ( is_user_logged_in() ) 
		{
			$userid = get_current_user_id();
		}
	else{
			$userid = 0;
			
			$classified_maker_account_required_post_ads = get_option( 'classified_maker_account_required_post_ads' );
			if( $classified_maker_account_required_post_ads=='yes'){
				
				echo __(sprintf('Please <a href="%s">login</a> to submit ads.',$login_page_url), classified_maker_com_textdomain) ;
				return;
				}
			
		}







	$class_pickform = new class_pickform();

	$class_classified_maker_company_functions = new class_classified_maker_company_functions();
	$company_input_fields = $class_classified_maker_company_functions->company_input_fields();
		
	//echo '<pre>'.var_export($company_input_fields, true).'</pre>';
	
	$company_title = $company_input_fields['post_title'];	
	$company_content = $company_input_fields['post_content'];
	$post_thumbnail = $company_input_fields['post_thumbnail'];	
		
	$recaptcha = $company_input_fields['recaptcha'];		
	
	$post_taxonomies = $company_input_fields['post_taxonomies'];
	$company_category = $post_taxonomies['company_cat'];

	$meta_fields = $company_input_fields['meta_fields'];
	
	//echo '<pre>'.var_export($meta_fields, true).'</pre>';


?>

<div class="company-submit pickform">

	<div class="validations">
    
    
	<?php
    
		if(isset($_POST['post_company_hidden'])){
			
			
			$validations = array();
			
			
			if(empty($_POST['post_title'])){
				
				 $validations['post_title'] = '';
				 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$company_title['title'].'</b> '.__('missing',classified_maker_com_textdomain).'.</div>';
				}
			
			if(empty($_POST['post_content'])){
				
				 $validations['post_content'] = '';
				 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$company_content['title'].'</b> '.__('missing',classified_maker_com_textdomain).'.</div>';
				}		
			

			
			
			if(empty($_POST['company_cat'])){
				
				 $validations['company_cat'] = '';
				 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$company_category['title'].'</b> '.__('missing',classified_maker_com_textdomain).'.</div>';
				}				
			
			if(empty($_POST['post_thumbnail'])){
				
				 $validations['post_content'] = '';
				 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$post_thumbnail['title'].'</b> '.__('missing',classified_maker_com_textdomain).'.</div>';
				}			
			
		
			foreach($meta_fields as $fields){
				
				$fields = $fields['meta_fields'];
				
				
				
				foreach($fields as $key=>$field_data){
					
					//echo '<pre>'.var_export($field_data, true).'</pre>';
					
					
					$meta_key = $field_data['meta_key'];
					$meta_title = $field_data['title'];	
									
					if(isset($_POST[$meta_key]))
					 $valid = $class_pickform->validations($field_data, $_POST[$meta_key]);
					 
					 if(!empty( $valid)){
						 $validations[$meta_key] = $valid;
						 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$meta_title.'</b> '.$valid.'.</div>';
						 
						 }					 
					}
			}
			
			
			
			if(empty($validations)){
				
				
				$company_title_val = $class_pickform->sanitizations($_POST['post_title'], 'text');
				$company_content_val = $class_pickform->sanitizations($_POST['post_content'], 'wp_editor');		
				$company_category_val = $class_pickform->sanitizations($_POST['company_cat'], 'select');	
				
				$post_thumbnail =	$_POST['post_thumbnail'];
				$post_thumbnail_id = $post_thumbnail[0];	
				
				$company_post = array(
				  'post_title'    => $company_title_val,
				  'post_content'  => $company_content_val,
				  'post_status'   => 'pending',
				  'post_type'   => 'company',
				  'post_author'   => $userid,
				);
				
				// Insert the post into the database
				//wp_insert_post( $my_post );
				$company_ID = wp_insert_post($company_post);
				
				update_post_meta( $company_ID, '_thumbnail_id', $post_thumbnail_id );
				$taxonomy = 'company_cat';
				
				wp_set_post_terms( $company_ID, $company_category_val, $taxonomy );
				
				
				foreach($meta_fields as $group_key=>$group_data){
					
					$group_meta_fields = $group_data['meta_fields'];
					
					foreach($group_meta_fields as $key=>$field_data){
						$meta_key = $field_data['meta_key'];						
						$input_type = $field_data['input_type'];
						
						if(is_array( $_POST[$meta_key])){
							$meta_value = $class_pickform->sanitizations($_POST[$meta_key], $input_type);
							
							$meta_value = serialize($meta_value);
							}
						else{
							$meta_value = $class_pickform->sanitizations($_POST[$meta_key], $input_type);
							}
						
						
						update_post_meta($company_ID, $meta_key , $meta_value);
						
						//var_dump($field_data_new);
						}
				}

				
				
				
				
				
				
				echo '<div class="success"><i class="fa fa-check"></i> '.__('Company Submitted successfully.',classified_maker_com_textdomain).'</div>';
				echo '<div class="success"><i class="fa fa-check"></i> '.sprintf(__('Submission Status: %s',classified_maker_com_textdomain),'Pending').'</div>';				
				
				
				
				
				
				
				
				
				
				
				}
			
			
			
		}
	
	
	
	
	
	
	?>
    
    
    
    
    
    
    
    
    </div> 
		
    <form enctype="multipart/form-data"   method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="post_company_hidden" value="Y">
        
        <?php
		
			//var_dump($company_title);
		
			do_action('classified_maker_action_company_submit_main');
			
			echo '<div class="item">';
			echo $class_pickform->field_set($company_title);
			
			echo '</div>';
			
			
			
			echo '<div class="item">';
			echo $class_pickform->field_set($company_content);
			
			echo '</div>';	
			
			
			echo '<div class="item">';
			echo $class_pickform->field_set($company_category);
			
			echo '</div>';	
			
			
			echo '<div class="item">';
			echo $class_pickform->field_set($post_thumbnail);
			
			echo '</div>';			
						
			
			?>
        <div class="meta-fields">
        
        <?php
        
        //echo '<pre>'.var_export($meta_fields, true).'</pre>';
        
        //var_dump($meta_fields);
        foreach($meta_fields as $fields){
            
            echo '<div class="steps-title">'.$fields['title'].'</div>';
            
            echo '<div class="steps-body">';
            
            $fields = $fields['meta_fields'];
            
            foreach($fields as $key=>$field_data){
                //var_dump($field_data);
            ?>
            <div class="item">

                
                <?php
                if(!empty($field_data['display'])){
                    $display = $field_data['display'];
                    }
                else{
                    $display = 'yes';
                    }
                
                
                
                if($display=='yes')
                echo $class_pickform->field_set($field_data);
                ?>

            </div>
            <?php
                
                }

            echo '</div>';
            }
        
        ?>
        
        
        </div>


        
	   <script>
       

            jQuery(".meta-fields").steps({
                headerTag: ".steps-title",
                bodyTag: ".steps-body",
                transitionEffect: "slide",
                onFinished: function (event, currentIndex){
                    jQuery('.company-submit-button').fadeIn();
                },
                labels: {
                    cancel: "<?php echo __('Cancel',classified_maker_com_textdomain); ?>",
                    current: "<?php echo __('current step:',classified_maker_com_textdomain); ?>",
                    pagination: "<?php echo __('Pagination',classified_maker_com_textdomain); ?>",
                    finish: "<?php echo __('Finish',classified_maker_com_textdomain); ?>",
                    next: "<?php echo __('Next',classified_maker_com_textdomain); ?>",
                    previous: "<?php echo __('Previous',classified_maker_com_textdomain); ?>",
                    loading: "<?php echo __('Loading ...',classified_maker_com_textdomain); ?>"
                }
                
                
            });

       </script>
        


        <div class="company-submit-button">
        
        <?php		
            

                
                echo '<div class="option">';
                echo $class_pickform->field_set($recaptcha);
                echo '</div>';
                
  

            wp_nonce_field( 'classified_maker' );
        ?>
            

            <input type="submit"  name="submit" value="<?php _e('Submit',classified_maker_com_textdomain); ?>" />

        </div>


	</form>
 




</div>