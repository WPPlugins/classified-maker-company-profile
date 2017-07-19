<?php
/*
Plugin Name: Classified Maker - Company Profile
Plugin URI: http://pickplugins.com
Description: Awesome Classified Maker Company Plugin.
Version: 1.0.2
Author: pickplugins
Text Domain: classified-maker-company-profile
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class ClassifiedMakerCom{
	
	public function __construct(){
	
	define('classified_maker_com_plugin_url', plugins_url('/', __FILE__)  );
	define('classified_maker_com_plugin_dir', plugin_dir_path( __FILE__ ) );
	define('classified_maker_com_wp_url', 'https://wordpress.org/plugins/classified-maker/' );
	define('classified_maker_com_wp_reviews', 'http://wordpress.org/support/view/plugin-reviews/classified-maker' );
	define('classified_maker_com_pro_url','http://www.pickplugins.com/item/classified-maker/' );
	define('classified_maker_com_demo_url', 'http://www.pickplugins.com/demo/classified-maker/' );
	define('classified_maker_com_conatct_url', 'http://www.pickplugins.com/contact/' );
	define('classified_maker_com_qa_url', 'http://www.pickplugins.com/questions/' );
	define('classified_maker_com_plugin_name', 'Classified Maker - Company Profile' );
	define('classified_maker_com_plugin_version', '1.0.2' );
	define('classified_maker_com_customer_type', 'free' );	 
	define('classified_maker_com_share_url', '' );
	define('classified_maker_com_tutorial_video_url', '' );
	define('classified_maker_com_textdomain', 'classified-maker-company-profile' );
	
	
	// Class
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-post-types.php');	
	//require_once( plugin_dir_path( __FILE__ ) . 'includes/class-post-meta.php');		
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-functions.php');
	//require_once( plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes.php');
	require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes/shortcodes-company-list.php');	
	require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcodes/shortcodes-company-submit.php');		
	
	require_once( plugin_dir_path( __FILE__ ) . 'includes/notice/notice.php');	
	require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php');
	require_once( plugin_dir_path( __FILE__ ) . 'templates/single-company-functions.php');
	
	require_once( plugin_dir_path( __FILE__ ) . 'templates/company-submit-hook.php');	
	
	
	add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
	add_action( 'wp_enqueue_scripts', array( $this, 'classified_maker_com_front_scripts' ) );
	add_action( 'admin_enqueue_scripts', array( $this, 'classified_maker_com_admin_scripts' ) );
	add_action( 'plugins_loaded', array( $this, 'classified_maker_com_load_textdomain' ));
	
	//Redirect to welcome page
	//add_action( 'activated_plugin', array( $this, 'classified_maker_com_redirect_welcome' ));	
	//add_action( 'admin_head', array( $this, 'classified_maker_com_remove_welcome_menu' ));	

	register_activation_hook( __FILE__, array( $this, 'classified_maker_com_activation' ) );


	add_filter( 'widget_text', 'do_shortcode', 11);


	}
	
	public function classified_maker_com_load_textdomain() {
		load_plugin_textdomain( classified_maker_com_textdomain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' ); 
	}
	
	public function classified_maker_com_activation(){
		
		global $wpdb;
		
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "classified_maker_com_follow"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					company_id	INT( 255 )	NOT NULL,
					follower_id	INT( 255 ) NOT NULL,
					follow	VARCHAR( 255 ) NOT NULL					
					)";
		$wpdb->query($sql);
		
		
		// Reset permalink
		$class_classified_maker_com_post_types= new class_classified_maker_com_post_types();
		$class_classified_maker_com_post_types->classified_maker_com_posttype_company();
		flush_rewrite_rules();
		
		
		do_action( 'classified_maker_com_action_install' );
	}		
		
		
		
	public function classified_maker_com_redirect_welcome($plugin){
		
		$classified_maker_com_welcome_done = get_option('classified_maker_com_welcome_done');
		if($classified_maker_com_welcome_done != true){
				if($plugin=='classified-maker/classified-maker.php') {
					 wp_redirect(admin_url('edit.php?post_type=ads&page=welcome'));
					 die();
				}
			}
		}		
		
	public function classified_maker_com_remove_welcome_menu(){
		remove_submenu_page( 'edit.php?post_type=ads', 'welcome' );
	}
		
		
		
	public function classified_maker_com_front_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-sortable');
		
		wp_enqueue_script('classified_maker_com_front_js', plugins_url( '/asset/front/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		//wp_enqueue_script('classified_maker_com_front_scripts-form', plugins_url( '/asset/front/js/scripts-form.js' , __FILE__ ) , array( 'jquery' ));		
		
		//wp_enqueue_style('jquery-ui', classified_maker_com_plugin_url.'asset/front/css/jquery-ui.css');		
		
		wp_enqueue_style('classified_maker_com_style', classified_maker_com_plugin_url.'asset/front/css/style.css');
		wp_enqueue_style('classified_maker_com_single', classified_maker_com_plugin_url.'asset/front/css/company-single.css');
		wp_enqueue_style('classified_maker_company-submit', classified_maker_com_plugin_url.'asset/front/css/company-submit.css');		
		
		//wp_enqueue_script('classified_maker_com_autocomplete', plugins_url( '/asset/front/js/jquery.autocomplete.min.js' , __FILE__ ) , array( 'jquery' ));
		
		

		//wp_enqueue_script('plupload-handlers');
		//wp_enqueue_script('classified_maker_com_file_uploader', plugins_url( '/asset/front/js/ajax-upload.js' , __FILE__ ) , array( 'jquery' ));		
		
		
		/*wp_localize_script('classified_maker_com_file_uploader', 'classified_maker_com_file_uploader', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('classified_maker_com_file_uploader'),
            'remove' => wp_create_nonce('classified_maker_com_file_upload_remove'),
            'number' => 1,
            'upload_enabled' => true,
            'confirmMsg' => __('Are you sure you want to delete this?'),
            'plupload' => array(
                'runtimes' => 'html5,flash,html4',
                'browse_button' => 'file-uploader',
                'container' => 'file-upload-container',
                'file_data_name' => 'classified_maker_com_file_uploader_file',
                'max_file_size' => '200000000b',
                'url' => admin_url('admin-ajax.php') . '?action=classified_maker_com_file_uploader&nonce=' . wp_create_nonce('classified_maker_com_file_upload_allow'),
                'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
                'filters' => array(array('title' => __('Allowed Files'), 'extensions' => apply_filters('classified_maker_com_bm_filter_file_upload_extensions','gif,png,jpg,jpeg'))),
                'multipart' => true,
                'urlstream_upload' => true,
            )
        ));*/
		
		wp_localize_script( 'classified_maker_com_front_js', 'classified_maker_com_ajax', array( 'classified_maker_com_ajaxurl' => admin_url( 'admin-ajax.php')));
		

/*

		$translation_array = array( 'some_string' => __( 'Some string to translate' ), 'a_value' => '10' );
		wp_localize_script( 'some_handle', 'object_name', $translation_array );
		
		// http://wordpress.stackexchange.com/questions/162415/how-do-i-translate-string-inside-jquery-script-with-wpml
*/


		
		}

	public function classified_maker_com_admin_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		
		wp_enqueue_script('classified_maker_com_admin_js', plugins_url( '/asset/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'classified_maker_com_admin_js', 'classified_maker_com_ajax', array( 'classified_maker_com_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		wp_enqueue_style('classified_maker_com_admin_style', classified_maker_com_plugin_url.'asset/admin/css/style.css');
		
		//wp_enqueue_script('classified_maker_com_PickAdmin', plugins_url( '/asset/admin/PickAdmin/scripts.js' , __FILE__ ) , array( 'jquery' ));		
		//wp_enqueue_style('classified_maker_com_PickAdmin', classified_maker_com_plugin_url.'asset/admin/PickAdmin/style.css');
		//wp_enqueue_style('font-awesome', classified_maker_com_plugin_url.'asset/global/css/font-awesome.css');
		
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'classified_maker_com_color_picker', plugins_url('/asset/admin/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
		}
	}

new ClassifiedMakerCom();