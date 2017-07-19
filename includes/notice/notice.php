<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	


	
function classified_maker_com_notice_missing_core_plugin()
	{

        
		$active_plugins = get_option('active_plugins');
		if(!in_array( 'classified-maker/classified-maker.php', (array) $active_plugins )){
			
			echo '<div class="update-nag">';
			echo 'Please install first. <a href="https://wordpress.org/plugins/classified-maker/">Classified Maker</a> to work <strong>'.classified_maker_com_plugin_name.'</strong>';
			echo '</div>';
			
			}

	}

add_action('admin_notices', 'classified_maker_com_notice_missing_core_plugin');