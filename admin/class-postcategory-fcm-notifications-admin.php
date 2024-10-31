<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/EmilMfornyam/WordPress-Post-FCM-Plugin
 * @since      1.0.0
 *
 * @package    WordPress-Post-FCM-Plugin
 * @subpackage WordPress-Post-FCM-Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WordPress-Post-FCM-Plugin
 * @subpackage WordPress-Post-FCM-Plugin/admin
 * @author     Mfornyam Emil <mfornyamemil@gmail.com>
 */
class Post_Category_FCM_Notifications_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/postcategory-fcm-notifications-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_media();

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/postcategory-fcm-notifications-admin.js', array( 'jquery' ),"0.1" );

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/postcategory-fcm-notifications-admin.js', array( 'jquery' ), '0.1');

	}
	
	/**
	 * Create Plugin menu item in WordPress Dashboard .
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function ad_menu_pfcm(){
		add_menu_page('Post FCM notifications', 'Post FCM Notifications', 'manage_options', 'admin_menu_pfcm', array($this, 'adm_page_pfcm'), plugins_url('images/fcm-icon.png', __FILE__ ));
		add_submenu_page( 'admin_menu_pfcm', 'Settings', 'Post FCM settings', 'manage_options', 'post_fcm_settings', array($this, 'post_manage_fcm_settings'));
	}
	
	/**
	 * Display Admin Post View in WordPress Dashboard .
	 *
	 * @since     1.0.0
	 */
	function adm_page_pfcm(){
		include('partials/postcategory-fcm-notifications-admin-display.php');
	}
	
	/**
	 * Display Admin Settings View in WordPress Dashboard .
	 *
	 * @since     1.0.0
	 */
	function post_manage_fcm_settings(){
		include('partials/postcategory-fcm-notifications-admin-settings.php');
		//include(plugin_dir_path(__FILE__) .'admin/partials/postcategory-fcm-notifications-admin-display.php') ;
	}

	// Ajax action to refresh the user image
	function myprefix_get_image() {
		if(isset($_GET['id']) ){
		    $image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', false, array( 'id' => 'myprefix-preview-image' ) );
		    $data = array(
		       'image'    => $image,
		    );
		    wp_send_json_success( $data );
		}else{
		    wp_send_json_error();
		}
	}

	/**
	 * Register Admin settings  .
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function fcm_settings(){   
        register_setting('pfcm_group', 'pfcm_api');
        register_setting('pfcm_group', 'pfcm_topic');
        register_setting('pfcm_group', 'pfcm_disable');
        register_setting('pfcm_group', 'pfcm_sound');
        register_setting('pfcm_group', 'pfcm_vibrate');
        register_setting('pfcm_group', 'pfcm_icon');
		
		$catest = get_categories() ;
		foreach($catest as $catests){
			$pfcmCats = 'pfcm_'.$catests->slug;
			register_setting('pfcm_group', $pfcmCats);
		}
    }
	
	/**
	 * Getting post data and checking settings before sending Sending Notifications  .
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function fcm_on_post_publish($post_id, $post) {
		
		$categoryAll = get_the_category($post_id);
		$categorySlug = 'pfcm_'.$categoryAll[0]->slug;
		$contentt = get_post_field('post_content', $post_id);
        $title = get_the_title($post_id);

        $feuture_img ;
        if(has_post_thumbnail($post_id)){
        	$post_thumbnail_id = get_post_thumbnail_id($post_id);
        	$feuture_img = wp_get_attachment_url($post_thumbnail_id, 'thumbnail');
    	}else{
    		$feuture_img = '';
    	}

    	$cust_fields = array();
    	$metas = get_post_meta($post_id);
    	$cust_fields = array_combine(array_keys($metas), array_column($metas, 0));
    	/*if(!empty($metas)){
	    	foreach ($metas as $key => $val) {
	    		 $key . ' : ' . $vals ;
	    		 $cust_fields[$key] = $vals ;
    		}
    	}*/
    	
		
		if(get_option('pfcm_api') && get_option('pfcm_topic')) {
			$topic =  "/topics/".get_option('pfcm_topic') ;
			$published_at_least_once = get_post_meta( $post_id, 'is_published', true );
			
			if (get_option('pfcm_disable') != 1) {
				
				//$this->pfcm_notification($title, $contentt, $feuture_img, $cust_fields);
				if (!$published_at_least_once && get_option($categorySlug) == 1) {
					$published_at_least_once = true;
					$this->pfcm_notification($title, $contentt, $feuture_img, $cust_fields);
				}
			}
			update_post_meta( $post_id, 'is_published', $published_at_least_once );
		}
	}
	
	/**
	 * Send Single FCM with API Call.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function pfcm_notification_single($title, $contentt, $send_token ){
		
        $apiKey 	= get_option('pfcm_api'); 
        $sound 		= (empty(get_option('pfcm_sound'))) ? "" : get_option('pfcm_sound');
        $iconUrl 	= (empty(get_option('pfcm_icon'))) ? "" : get_option('pfcm_icon');
		
		$url = 'https://fcm.googleapis.com/fcm/send';
        
        $keyed = 'key=' . $apiKey;
		
		$notification_data = array(
            'body'           => $contentt,
            'title'           	=> $title,
			'sound'				=> $sound,
			'icon'				=> $iconUrl,
			//'image'				=> $feuture_img,
        );

		$post = array(
            'to'         		=> $send_token,
            'notification'      => $notification_data
        );

        $body = wp_json_encode( $post );
		
		$args = array(
			'method'      => 'POST',
		    'body'        => $body,
		    'timeout'     => '5',
		    'redirection' => '5',
		    'httpversion' => '1.0',
		    'blocking'    => true,
		    'sslverify'   => false,
		    'headers'     => array(
            'Authorization' => $keyed,
            'Content-Type'  => 'application/json',
        	),
		);

		$request = wp_remote_post($url, $args); 

		return $request; 

	}

	/**
	 * FCM API Call.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function pfcm_notification($title, $contentt, $feuture_img, $cust_fields ){
		
        $apiKey 	= get_option('pfcm_api'); 
        $topic  	= "/topics/".get_option('pfcm_topic') ;
        $sound 		= (empty(get_option('pfcm_sound'))) ? "" : get_option('pfcm_sound');
        $iconUrl 	= (empty(get_option('pfcm_icon'))) ? "" : get_option('pfcm_icon');

        $notification_values = array();
		
		$url = 'https://fcm.googleapis.com/fcm/send';

		$keyed = 'key=' . $apiKey;
		
		$notification_data = array(
            'body'           => $contentt,
            'title'           	=> $title,
			'sound'				=> $sound,
			'icon'				=> $iconUrl,
			'image'				=> $feuture_img,
        );

		$notification_values = array_merge($notification_data, $cust_fields) ;

		$post = array(
            'to'        => $topic,
            'data'      => $notification_values,
        );
		
		$body = wp_json_encode($post);
		
		$args = array(
			'method'      => 'POST',
		    'body'        => $body,
		    'timeout'     => '5',
		    'redirection' => '5',
		    'httpversion' => '1.0',
		    'blocking'    => true,
		    'sslverify'   => false,
		    'headers'     => array(
            'Authorization' => $keyed,
            'Content-Type'  => 'application/json',
        	),
		);

		$request = wp_remote_post($url, $args); 

		return $request; 
	}
	
}
