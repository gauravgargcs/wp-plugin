<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cloud1.me/
 * @since      1.0.0
 *
 * @package    Co_schedulebull_booking
 * @subpackage Co_schedulebull_booking/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Co_schedulebull_booking
 * @subpackage Co_schedulebull_booking/admin
 * @author     Gaurav Garg <gauravgargcs1991@gmail.com>
 */
class Co_schedulebull_booking_Admin {

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
	 * The schedulebull_api_key.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The schedulebull_api_key.
	 */
	protected $schedulebull_api_key;
	
	/**
	 * The schedulebull_api endpoint.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The schedulebull_api_key.
	 */
	protected $schedulebull_api_endpoint;

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
		
		$this->schedulebull_api_key = 'kui2gfvtv6soaiugf9ez';
        $this->schedulebull_api_endpoint = 'https://app.schedulebull.com/api3.php';

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
		 * defined in Co_schedulebull_booking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Co_schedulebull_booking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/co_schedulebull_booking-admin.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( $this->plugin_name.'_datepicker', 'https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css', array(), $this->version, 'all' );

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
		 * defined in Co_schedulebull_booking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Co_schedulebull_booking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/co_schedulebull_booking-admin.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( $this->plugin_name.'_datepicker', 'https://code.jquery.com/ui/1.13.0/jquery-ui.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Adding admin menu page
	 *
	 * @since    1.0.0
	 */
	public function cos_admin_menu_page(){
		add_menu_page(
            __( 'Schedulebull Booking' ),
            __( 'Schedulebull Booking' ),
            'manage_options',
            'schedulebull-booking',
            array($this, 'cos_schedulebull_booking_page_content'),
            'dashicons-welcome-write-blog'
        );
		
		add_submenu_page(
            'schedulebull-booking',
            __( 'Settings' ),
            __( 'Settings' ),
            'manage_options',
            'schedulebull-booking-settings',
            array( $this, 'cos_schedulebull_booking_settings_page_content' )
        );
	}
	
	/**
	 * admin menu page callback
	 *
	 * @since    1.0.0
	 */
	public function cos_schedulebull_booking_page_content(){
		
	}
	
	/**
	 * Function to get api endpoint url.
	 *
	 * @since    1.0.0
	 */
	public function cos_get_api_endpoint_url() {
	    return $this->schedulebull_api_endpoint;
	}
	
	/**
	 * Function to get api key form settings option.
	 *
	 * @since    1.0.0
	 */
	public function cos_get_api_key() {
	    return $this->schedulebull_api_key;
	}
	
	/**
	 * Function to get cities from api
	 *
	 * @since    1.0.0
	 */
	public function cos_api_run( $url ) {
	    $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        
        $obj = json_decode($result);
	    return $obj;
	}
	
	/**
	 * Function to get cities from api
	 *
	 * @since    1.0.0
	 */
	public function cos_api_get_cities() {
	    
	    $url_ = $this->cos_get_api_endpoint_url().'?key='.$this->cos_get_api_key().'&q=transphere%2Flocations';
	    
	    return $this->cos_api_run( $url_ );
	}
	
	/**
	 * admin menu settings page callback
	 *
	 * @since    1.0.0
	 */
	public function cos_schedulebull_booking_settings_page_content(){
		
		if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $cos_options = get_option( 'cos_setting_options' );
        if ( isset( $_GET['settings-updated'] ) ) {
            add_settings_error( 'cos_setting_messages', 'cos_setting_message', __( 'Settings Saved' ), 'updated' );
        }
        settings_errors( 'cos_setting_messages' );
		
		$locations__ = $this->cos_api_get_cities();
		

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/cos-admin-settings.php';
	}
	
	public function cos_time_select_field( $name_, $hour, $minutes ){
        $time_select_field = '';
		
		$hours_array = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
		$munites_array = array('00','05','10','15','20','25','30','35','40','45','50','55');
        
        $time_select_field .= '<select data-name="'.$name_.'_hours" class="cos_time_hours">';
		
		foreach($hours_array as $h){
			$time_select_field .='<option value="'.$h.'" '.(($hour == $h)?'selected':'').'>'.$h.'</option>';
		}
        
        $time_select_field .= '</select>';
        
        $time_select_field .= '<div class="cos_time_saperator">:</div>';
        
        $time_select_field .='<select data-name="'.$name_.'_minutes" class="cos_time_minutes">';
        
		foreach($munites_array as $m){
			$time_select_field .='<option value="'.$m.'" '.(($minutes == $m)?'selected':'').'>'.$m.'</option>';
		}
        $time_select_field .='</select>';
        
        return $time_select_field;
    }
	
	/**
	 * Initialize an options field.
	 *
	 * @since    1.0.0
	 */
    public function cos_setting_settings_init(){
        register_setting( 'cos_setting', 'cos_setting_options' );
    }
	
	/**
	 * Register 'cos_promo_code' custom post type.
	 *
	 * @since    1.0.0
	 */
	public function cos_regitser_cos_promo_code_post_type(){
	    
	    register_post_type( 'cos_promo_code',
            array(
                'labels'      => array(
                    'name' => __('Schedulebull Promo Code'),
                    'add_new_item' => __('Add New Schedulebull Promo Code'),
                    'edit_item' => __('Edit Schedulebull Promo Code'),
                    'all_items' => __('All Schedulebull Promo Code'),
                    'singular_name' => __('Schedulebull Promo Code'),
                    'menu_name' => __('Schedulebull Promo Code')
                ),
				'show_in_menu' => 'schedulebull-booking',
                'public'      => true,
                'has_archive' => true,
                'supports'    => array('title')
            )
        );

	}
	
	/**
	 * Adding promo meta box.
	 *
	 * @since    1.0.0
	 */
	public function cos_promo_code_add_custom_box(){
		add_meta_box(
			'cos-catalog-box',       // $id
			'Promo Details',                  // $title
			array( $this, 'cos_promo_metabox_callback' ),  // $callback
			'cos_promo_code',                 // $page
			'normal',                  // $context
			'high'                     // $priority
		);
	}
	
	/**
	 * catalog meta box content
	 *
	 * @since    1.0.0
	 */
	public function cos_promo_metabox_callback(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/co_schedulebull_booking-admin-promo-details.php';
	}
	
	/**
	 * saving promo meta box data to post meta
	 *
	 * @since    1.0.0
	 */
	public function cos_promo_code_save_data( $post_id ){
		
		if( isset($_POST['cos_promo_code']) && !empty($_POST['cos_promo_code']) ){
			update_post_meta( $post_id, 'cos_promo_code', $_POST['cos_promo_code']);
		}
		
		if( isset($_POST['cos_promo_type']) && !empty($_POST['cos_promo_type']) ){
			update_post_meta( $post_id, 'cos_promo_type', $_POST['cos_promo_type']);
		}
		
		if( isset($_POST['cos_promo_amount']) && !empty($_POST['cos_promo_amount']) ){
			update_post_meta( $post_id, 'cos_promo_amount', $_POST['cos_promo_amount']);
		}
	}

}
