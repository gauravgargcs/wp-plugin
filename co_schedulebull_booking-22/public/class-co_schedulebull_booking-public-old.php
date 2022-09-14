<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cloud1.me/
 * @since      1.0.0
 *
 * @package    Co_schedulebull_booking
 * @subpackage Co_schedulebull_booking/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Co_schedulebull_booking
 * @subpackage Co_schedulebull_booking/public
 * @author     Gaurav Garg <gauravgargcs1991@gmail.com>
 */
class Co_schedulebull_booking_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        
        $this->schedulebull_api_key = 'kui2gfvtv6soaiugf9ez';
        $this->schedulebull_api_endpoint = 'https://app.schedulebull.com/api3.php';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/co_schedulebull_booking-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/co_schedulebull_booking-public.js', array( 'jquery' ), $this->version, false );

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
	 * Function to get api endpoint url.
	 *
	 * @since    1.0.0
	 */
	public function cos_get_api_endpoint_url() {
	    return $this->schedulebull_api_endpoint;
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
	 * get routes from api
	 *
	 * @since    1.0.0
	 */
	public function cos_api_get_routes( $find = '' ){
	    $url_ = $this->cos_get_api_endpoint_url().'?key='.$this->cos_get_api_key().'&q=transphere%2Froutes&find='.$find;
	    
	    return $this->cos_api_run( $url_ );
	}
	
	/**
	 * get routes price from api
	 *
	 * @since    1.0.0
	 */
	public function cos_api_get_route_price( $route_id = '', $date_ = '' ){
	    $url_ = $this->cos_get_api_endpoint_url().'?key='.$this->cos_get_api_key().'&q=transphere%2Froutes&id='.$route_id.'&date='.$date_;
	    
	    return $this->cos_api_run( $url_ );
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
	 * check round routes from api ajax callback
	 *
	 * @since    1.0.0
	 */
	public function cos_api_check_round_routes_ajax_callback(){
	    $response = array();
	    
	    parse_str($_POST['booking_data'],$booking_data);
	    $response['status'] = 0;
	    if( isset( $booking_data['cos_booking_action_field'] )  ){
	        if(wp_verify_nonce( $booking_data['cos_booking_action_field'], 'cos_booking_action' )){
	            
	            if( $booking_data['place_from'] != '' && $booking_data['place_to'] != ''){
                    
	                $possible_routes = $this->cos_api_get_routes($booking_data['place_to']);
	                
	                if( !empty($possible_routes) ){
	                    
	                    foreach( $possible_routes as $route_id => $possible_route){
	                        if( $possible_route->from == $booking_data['place_to'] &&  $possible_route->to == $booking_data['place_from'] ){
	                            $response['status'] = 1;
	                            $response['route_id_round'] = $route_id;
	                        }
	                    }
	                    
	                    if($response['status'] == 0){
	                        $response['msg'] = 'No round routes found';
	                    }
	                }
	                else{
	                    $response['msg'] = 'No round routes found';
	                }
	                
	            }
	            else{
	                $response['status'] = 0;
	                $response['msg'] = 'Please select place from and place to.';
	            }
	        }
	        else{
	            $response['status'] = 0;
	            $response['msg'] = 'Ivalid Request';
	        }
	    }
	    else{
	        $response['status'] = 0;
	        $response['msg'] = 'Ivalid Request';
	    }
	    
	    wp_send_json($response); wp_die();
	}
	
	
	/**
	 * get routes from api ajax callback
	 *
	 * @since    1.0.0
	 */
	public function cos_api_get_routes_ajax_callback(){
	    
	    $response = array();
	    
	    $response['routes_list_html'] = '<option value="">Transfer To:</option>';
	    
	    parse_str($_POST['booking_data'],$booking_data);
	    
	    if( isset( $booking_data['cos_booking_action_field'] )  ){
	        if(wp_verify_nonce( $booking_data['cos_booking_action_field'], 'cos_booking_action' )){
	            
	            if( $booking_data['place_from'] != ''){
	                $list_html = '';
	                $possible_routes = $this->cos_api_get_routes($booking_data['place_from']);
	                
	                if( !empty($possible_routes) ){
	                    
	                    foreach( $possible_routes as $route_id => $possible_route){
	                        if( $possible_route->from == $booking_data['place_from'] ){
	                            $list_html .= '<option data-RouteId="'.$route_id.'" value="'.$possible_route->to.'">'.$possible_route->to.'</option>';
	                        }
	                    }
	                }
	                
	                if( $list_html != '' ){
	                    $response['status'] = 1;
	                    $response['routes_list_html'] .= $list_html;
	                }
	                else{
	                    $response['status'] = 0;
	                    $response['msg'] = 'No routes found.';
	                }
	                
	            }
	            else{
	                $response['status'] = 0;
	                $response['msg'] = 'Please select place from.';
	            }
	        }
	        else{
	            $response['status'] = 0;
	            $response['msg'] = 'Ivalid Request';
	        }
	    }
	    else{
	        $response['status'] = 0;
	        $response['msg'] = 'Ivalid Request';
	    }
	    
	    wp_send_json($response); wp_die();
	}
	
	
	/**
	 * get routes price from api ajax callback
	 *
	 * @since    1.0.0
	 */
	public function cos_api_get_route_price_ajax_callback(){
	    
	    $response = array();
	    $response['price'] = 0;
	    
	    parse_str($_POST['booking_data'],$booking_data);
	    
	    
	    if( isset( $booking_data['cos_booking_action_field'] )  ){
	        if(wp_verify_nonce( $booking_data['cos_booking_action_field'], 'cos_booking_action' )){
	            
	            $route_data__ = $this->cos_api_get_route_price( $booking_data['cos_route_id_one'], $booking_data['date_one'] );
	            if( !empty($route_data__) ){
	                $route_data__ = json_decode(json_encode($route_data__), true);
	                
	                $r_price = $route_data__[$booking_data['cos_route_id_one']]['price'];
	                
	                $response['price'] = round( ( $response['price'] + $r_price), 2);
	                $response['status'] = 1;
	            }
	            
	            if( isset($booking_data['cos_route_id_round']) && $booking_data['cos_route_id_round'] != '' && isset($booking_data['date_round']) && $booking_data['date_round'] != '' ){
	                $route_data__r = $this->cos_api_get_route_price( $booking_data['cos_route_id_round'], $booking_data['date_round'] );
    	            if( !empty($route_data__r) ){
    	                $route_data__r = json_decode(json_encode($route_data__r), true);
    	                $r_price_r = $route_data__r[$booking_data['cos_route_id_round']]['price'];
    	                $response['price'] = round( ( $response['price'] + $r_price_r), 2);
    	            }
	            }
	        }
	        else{
	            $response['status'] = 0;
	            $response['msg'] = 'Ivalid Request';
	        }
	    }
	    else{
	        $response['status'] = 0;
	        $response['msg'] = 'Ivalid Request';
	    }
	    
	    wp_send_json($response); wp_die();
	}
	
	
	/**
	 * schedulebull_booking form Shortcode callback
	 *
	 * @since    1.0.0
	 */
	public function cos_schedulebull_booking_form_callback(){
		ob_start(); ?>
		<?php
		
		    $locations__ = $this->cos_api_get_cities();
		    
    	 	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/co_schedulebull_booking-public-schedulebull-booking.php';
        ?>
		<?php return ob_get_clean();
	}
	
	

}
