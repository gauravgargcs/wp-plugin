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
		wp_enqueue_style( $this->plugin_name.'_datepicker', 'https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css', array(), $this->version, 'all' );
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
        $cos_options = get_option( 'cos_setting_options' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/co_schedulebull_booking-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'_datepicker', 'https://code.jquery.com/ui/1.13.0/jquery-ui.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( $this->plugin_name.'_stripe', 'https://js.stripe.com/v3/', array( 'jquery' ), $this->version, false );
		
		$cos_block_dates = $cos_options['block_date_ranges'];
		$block_dates_array = array();
		if(!empty($cos_block_dates)){
			foreach( $cos_block_dates as $cos_block_date ){
				$d_range = $this->cos_getDatesFromRange($cos_block_date['date_from'], $cos_block_date['date_to']);
				
				if( !empty($d_range) ){
					
					
					unset($d_range[count($d_range) - 1]);
					unset($d_range[0]);
				}
				$block_dates_array = array_merge($block_dates_array, $d_range);
			}
		}
		
		wp_localize_script( $this->plugin_name, 'cos_booking_object',
            array( 
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'stripe_publishable_key' => $cos_options['stripe']['publishable_key']??'',
				'blocked_dates' => json_encode($block_dates_array)
            )
        );

	}
	
	// Function to get all the dates in given range
	public function cos_getDatesFromRange($start, $end, $format = 'Y-m-d') {
		  
		// Declare an empty array
		$array = array();
		  
		// Variable that store the date interval
		// of period 1 day
		$interval = new DateInterval('P1D');
	  
		$realEnd = new DateTime($end);
		$realEnd->add($interval);
	  
		$period = new DatePeriod(new DateTime($start), $interval, $realEnd);
	  
		// Use loop to store date into array
		foreach($period as $date) {                 
			$array[] = $date->format($format); 
		}
	  
		// Return the array elements
		return $array;
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
	      //  if(wp_verify_nonce( $booking_data['cos_booking_action_field'], 'cos_booking_action' )){
	            
	            if( $booking_data['place_from'] != '' && $booking_data['place_to'] != ''){
                    
	                $possible_routes = $this->cos_api_get_routes($booking_data['place_to']);
	                
	                if( !empty($possible_routes) ){
	                    
	                    foreach( $possible_routes as $route_id => $possible_route){
	                        if( ($possible_route->from == $booking_data['place_from'] || $possible_route->to == $booking_data['place_from']) ){
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
	      /*  }
	        else{
	            $response['status'] = 0;
	            $response['msg'] = 'Ivalid Request';
	        } */
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
	    // if(wp_verify_nonce( $booking_data['cos_booking_action_field'], 'cos_booking_action' )){
	            if( $booking_data['place_from'] != ''){
	                $list_html = '';
	                $possible_routes = $this->cos_api_get_routes($booking_data['place_from']);
	                
	                if( !empty($possible_routes) ){
	                    
	                    foreach( $possible_routes as $route_id => $possible_route){
	                        if( $possible_route->from == $booking_data['place_from'] ){
	                            $list_html .= '<option data-RouteId="'.$route_id.'" value="'.$possible_route->to.'">'.$possible_route->to.'</option>';
	                        }
	                        if( $possible_route->to == $booking_data['place_from'] ){
	                            $list_html .= '<option data-RouteId="'.$route_id.'" value="'.$possible_route->from.'">'.$possible_route->from.'</option>';
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
	  /*      }
	        else{
	            $response['status'] = 0;
	            $response['msg'] = 'Ivalid Request';
	        }  */
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
	      //  if(wp_verify_nonce( $booking_data['cos_booking_action_field'], 'cos_booking_action' )){
	            
	            $pessengers_group_count = (int) ( ( $booking_data['adults_'] + $booking_data['childrens_'] ) / 8 );
        	    $pessengers_remaining = ( $booking_data['adults_'] + $booking_data['childrens_'] ) % 8;
	            
	            $route_data__ = $this->cos_api_get_route_price( $booking_data['cos_route_id_one'], $booking_data['date_one'] );
	           
	            if( !empty($route_data__) ){
	                $route_data__ = json_decode(json_encode($route_data__), true);
	                $r_price = $route_data__[$booking_data['cos_route_id_one']]['price'];
            	     $response['hours']= $route_data__[$booking_data['cos_route_id_one']]['hours'];
            	    if( $pessengers_group_count > 0){
            	        for($i = 0; $i < $pessengers_group_count; $i++){
            	            $response['price'] = round( ( $response['price'] + $r_price), 2);
            	        }
            	    }
            	    
            	    if( $pessengers_remaining > 0 ){
            	        $response['price'] = round( ( $response['price'] + $r_price), 2);
            	    }
	               
	                $response['status'] = 1;
					
					if( $booking_data['time_one'] != '' ){
						if( !$this->cos_check_booking_blocked( $booking_data['date_one'], $booking_data['time_one'], $booking_data['place_from'], $booking_data['place_to'] ) ){
							$response['status'] = 0;
							$response['msg'] = 'Booking not available for selected time';
						}
						else{
							$response['price'] = $this->cos_get_booking_price_change( $booking_data['date_one'], $booking_data['time_one'], $response['price'], $booking_data['place_from'], $booking_data['place_to'] );
						}
					}
					
					
					$one_way_price = $response['price'];
	            }
	            
	            if( isset($booking_data['cos_route_id_round']) && $booking_data['cos_route_id_round'] != '' && isset($booking_data['date_round']) && $booking_data['date_round'] != '' ){
	                $route_data__r = $this->cos_api_get_route_price( $booking_data['cos_route_id_round'], $booking_data['date_round'] );
	              
    	            if( !empty($route_data__r) ){
    	                $route_data__r = json_decode(json_encode($route_data__r), true);
    	                $r_price_r = $route_data__r[$booking_data['cos_route_id_round']]['price'];
    	                $response['hours']= $route_data__r[$booking_data['cos_route_id_round']]['hours'];
    	                
    	                if( $pessengers_group_count > 0){
                	        for($i = 0; $i < $pessengers_group_count; $i++){
                	            $response['price'] = round( ( $response['price'] + $r_price_r), 2);
                	        }
                	    }
                	    
                	    if( $pessengers_remaining > 0 ){
                	        $response['price'] = round( ( $response['price'] + $r_price_r), 2);
                	    }
    	            }
					
					
					if( $booking_data['time_round'] != '' ){
						if( !$this->cos_check_booking_blocked( $booking_data['date_round'], $booking_data['time_round'], $booking_data['place_from'], $booking_data['place_to'] ) ){
							$response['status'] = 0;
							$response['msg'] = 'Booking not available for selected time';
						}
						else{
							$response['price'] = round( ($one_way_price + $this->cos_get_booking_price_change( $booking_data['date_round'], $booking_data['time_round'], ($response['price'] - $one_way_price), $booking_data['place_from'], $booking_data['place_to'] )), 2 );
						}
					}
	            }
	     /*   }
	        else{
	            $response['status'] = 0;
	            $response['msg'] = 'Ivalid Request';
	        } */
	    }
	    else{
	        $response['status'] = 0;
	        $response['msg'] = 'Invalid Request';
	    }
	    
	    wp_send_json($response); wp_die();
	}
	
	
	public function cos_check_booking_blocked( $booking_date_, $booking_time, $booking_from, $booking_to ){
		$cos_options = get_option( 'cos_setting_options' );
		
		$cos_block_dates = $cos_options['block_date_ranges'];
		
		//$cos_block_startDates = array_column($cos_block_dates, 'date_from');
		//$cos_block_endDates = array_column($cos_block_dates, 'date_to');
		
		$is_not_blocked = true;
		
		if(!empty( $cos_block_dates )){
			foreach($cos_block_dates as $k => $cos_block_date___ ){
				
				if( ( $cos_block_date___['route_from'] == 'All' || $cos_block_date___['route_from'] == $booking_from )
					&& ( $cos_block_date___['route_to'] == 'All' || $cos_block_date___['route_to'] == $booking_to )
				){
					
					if( $booking_date_ == $cos_block_date___['date_from'] && $booking_date_ == $cos_block_date___['date_to'] ){
			
						$time__st = $cos_block_dates[$k]['start_time'];
						
						$time__et = $cos_block_dates[$k]['end_time'];
						
						if( strtotime($booking_time) >= strtotime($time__st) && strtotime($booking_time) <= strtotime($time__et) ){
							$is_not_blocked = false;
						}
						else{
							$is_not_blocked = true;
						}
					}
					else if( $booking_date_ == $cos_block_date___['date_from'] ){
						
						$time__ = $cos_block_dates[$k]['start_time'];
						
						if( strtotime($booking_time) >= strtotime($time__) ){
							$is_not_blocked = false;
						}
						else{
							$is_not_blocked = true;
						}
					}
					else if( $booking_date_ == $cos_block_date___['date_to'] ){
						$time__ = $cos_block_dates[$k]['end_time'];
						if( strtotime($booking_time) <= strtotime($time__) ){
							$is_not_blocked = false;
						}
						else{
							$is_not_blocked = true;
						}
					}
					else{
						$is_not_blocked = true;
					}
					
				}
				else{
					$is_not_blocked = true;
				}
				
			}
		}
		else{
			$is_not_blocked = true;
		}
		
		return $is_not_blocked;
	}
	
	public function cos_check_booking_blocked_old( $booking_date_, $booking_time ){
		$cos_options = get_option( 'cos_setting_options' );
		
		$cos_block_dates = $cos_options['block_date_ranges'];
		
		$cos_block_startDates = array_column($cos_block_dates, 'date_from');
		$cos_block_endDates = array_column($cos_block_dates, 'date_to');
		
		
		if( array_search($booking_date_, $cos_block_startDates) > -1 && array_search($booking_date_, $cos_block_endDates) > -1 ){
			
			$time__st = $cos_block_dates[array_search($booking_date_, $cos_block_startDates)]['start_time'];
			
			$time__et = $cos_block_dates[array_search($booking_date_, $cos_block_startDates)]['end_time'];
			
			if( strtotime($booking_time) >= strtotime($time__st) && strtotime($booking_time) <= strtotime($time__et) ){
				return false;
			}
			else{
				return true;
			}
		}
		else if( array_search($booking_date_, $cos_block_startDates) > -1 ){
			
			$time__ = $cos_block_dates[array_search($booking_date_, $cos_block_startDates)]['start_time'];
			
			if( strtotime($booking_time) >= strtotime($time__) ){
				return false;
			}
			else{
				return true;
			}
		}
		else if( array_search($booking_date_, $cos_block_endDates) > -1 ){
			$time__ = $cos_block_dates[array_search($booking_date_, $cos_block_startDates)]['end_time'];
			if( strtotime($booking_time) <= strtotime($time__) ){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			return true;
		}
	}
	
	public function cos_get_booking_price_change( $booking_date_, $booking_time, $orignal_price, $booking_from, $booking_to ){
		$cos_options = get_option( 'cos_setting_options' );
		
		$cos_rate_dates = $cos_options['rate_date_ranges'];
		
		//$cos_rate_startDates = array_column($cos_rate_dates, 'date_from');
		//$cos_rate_endDates = array_column($cos_rate_dates, 'date_to');
		
		$change_type = '';
		$change_rate = 0;
		
		$changed_price = $orignal_price;
		
		if(!empty( $cos_rate_dates )){
			foreach($cos_rate_dates as $k => $cos_rate_date___ ){
				
				if( ( $cos_rate_date___['route_from'] == 'All' || $cos_rate_date___['route_from'] == $booking_from )
					&& ( $cos_rate_date___['route_to'] == 'All' || $cos_rate_date___['route_to'] == $booking_to )
				){
					//echo $booking_from;
					
					//echo 'Hello'; die;
					if( $cos_rate_date___['date_from'] == '' && $cos_rate_date___['date_to'] == '' ){
			
						$time__st = $cos_rate_dates[$k]['start_time'];
						
						$time__et = $cos_rate_dates[$k]['end_time'];
						
						if( strtotime($booking_time) >= strtotime($time__st) && strtotime($booking_time) <= strtotime($time__et) ){
							$change_rate = $cos_rate_dates[$k]['date_amount'];
							$change_type = $cos_rate_dates[$k]['amount_type'];
							break;
						}
						else{
							$change_type = '';
							$change_rate = 0;
						}
					}
					
					else if( $booking_date_ == $cos_rate_date___['date_from'] && $booking_date_ == $cos_rate_date___['date_to'] ){
			
						$time__st = $cos_rate_dates[$k]['start_time'];
						
						$time__et = $cos_rate_dates[$k]['end_time'];
						
						if( strtotime($booking_time) >= strtotime($time__st) && strtotime($booking_time) <= strtotime($time__et) ){
							$change_rate = $cos_rate_dates[$k]['date_amount'];
							$change_type = $cos_rate_dates[$k]['amount_type'];
							break;
						}
						else{
							$change_type = '';
							$change_rate = 0;
						}
					}
					else if( $booking_date_ == $cos_rate_date___['date_from'] ){
						
						$time__ = $cos_rate_dates[$k]['start_time'];
						
						if( strtotime($booking_time) >= strtotime($time__) ){
							$change_rate = $cos_rate_dates[$k]['date_amount'];
							$change_type = $cos_rate_dates[$k]['amount_type'];
							break;
						}
						else{
							$change_type = '';
							$change_rate = 0;
						}
					}
					else if( $booking_date_ == $cos_rate_date___['date_to'] ){
						$time__ = $cos_rate_dates[$k]['end_time'];
						if( strtotime($booking_time) <= strtotime($time__) ){
							$change_rate = $cos_rate_dates[$k]['date_amount'];
							$change_type = $cos_rate_dates[$k]['amount_type'];
							break;
						}
						else{
							$change_type = '';
							$change_rate = 0;
						}
					}
					else{
						$change_type = '';
						$change_rate = 0;
					}
					
				}
				
			}
		}
		
		if( $change_type == 'Increase'){
			$changed_price = $orignal_price + ($orignal_price * ($change_rate / 100));
		}
		
		if( $change_type == 'Decrease'){
			$changed_price = $orignal_price - ($orignal_price * ($change_rate / 100));
		}
		$changed_price = round($changed_price, 2);
		
		return $changed_price;
	}
	
	
	public function cos_get_booking_price_change_old( $booking_date_, $booking_time, $orignal_price, $booking_from, $booking_to ){
		$cos_options = get_option( 'cos_setting_options' );
		
		$cos_rate_dates = $cos_options['rate_date_ranges'];
		
		$cos_rate_startDates = array_column($cos_rate_dates, 'date_from');
		$cos_rate_endDates = array_column($cos_rate_dates, 'date_to');
		
		$change_type = '';
		$change_rate = 0;
		
		$changed_price = $orignal_price;
		
		if( array_search($booking_date_, $cos_rate_startDates) > -1 && array_search($booking_date_, $cos_rate_endDates) > -1 ){
			
			$time__st = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['start_time'];
			
			$time__et = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['end_time'];
			
			if( strtotime($booking_time) >= strtotime($time__st) && strtotime($booking_time) <= strtotime($time__et) ){
				$change_rate = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['date_amount'];
				$change_type = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['amount_type'];
			}
			else{
				$change_type = '';
				$change_rate = 0;
			}
		}
		else if( array_search($booking_date_, $cos_rate_startDates) > -1 ){
			
			$time__ = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['start_time'];
			
			if( strtotime($booking_time) >= strtotime($time__) ){
				$change_rate = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['date_amount'];
				$change_type = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['amount_type'];
			}
			else{
				$change_type = '';
				$change_rate = 0;
			}
		}
		else if( array_search($booking_date_, $cos_rate_endDates) > -1 ){
			$time__ = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['end_time'];
			if( strtotime($booking_time) <= strtotime($time__) ){
				$change_rate = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['date_amount'];
				$change_type = $cos_rate_dates[array_search($booking_date_, $cos_rate_startDates)]['amount_type'];
			}
			else{
				$change_type = '';
				$change_rate = 0;
			}
		}
		else{
			$change_type = '';
			$change_rate = 0;
		}
		
		if( $change_type == 'Increase'){
			$changed_price = $orignal_price + ($orignal_price * ($change_rate / 100));
		}
		
		if( $change_type == 'Decrease'){
			$changed_price = $orignal_price - ($orignal_price * ($change_rate / 100));
		}
		$changed_price = round($changed_price, 2);
		
		return $changed_price;
	}
	
	
	/**
	 * schedulebull_booking form Shortcode callback
	 *
	 * @since    1.0.0
	 */
	public function cos_schedulebull_booking_form_callback(){
		ob_start(); ?>
		<?php
		    $msg = '';
		    if( isset( $_POST['cos_booking_action_field']) ){
		      //  if( wp_verify_nonce( $_POST['cos_booking_action_field'], 'cos_booking_action' ) ){
		            $booking_submit = $this->cos_schedulebull_booking_submit( $_POST );
		            
		            if($booking_submit['status']){
						$msg = '<script>location.replace("'.site_url('/successfull_booking').'");</script>';
		                //$msg = '<span class="cosForm-route" style="color:green;text-align: center;width: 95%;display: inline-block;font-size: 20px;font-weight: 700;background: #fff;margin: 0px 2.5%;border-radius: 5px;">Booking Successfull.</span>';
		            }
		            else{
		                $msg = '<span class="cosFormError-route" style="color:red;text-align: center;width: 95%;display: inline-block;font-size: 20px;font-weight: 700;background: #fff;margin: 0px 2.5%;border-radius: 5px;">'.$booking_submit['msg'].'</span>';
		            }
		      /*  }
		        else{
		            $msg = '<span class="cosFormError-route" style="color:red;">Invalid Submission.</span>';
		        } */
		    }
		    
		    $locations__ = $this->cos_api_get_cities();
		    
    	 	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/co_schedulebull_booking-public-schedulebull-booking.php';
        ?>
		<?php return ob_get_clean();
	}
	
		/**
	 * schedulebull_booking form submit callback
	 *
	 * @since    1.0.0
	 */
	public function cos_schedulebull_booking_submit( $form_data = array() ){
		$is_promo = 0;
		if( isset($form_data['promo_code']) && $form_data['promo_code'] != ''){
			$is_promo = 1;
		}
	    
	    $request_data = array();
	    $response = array();

        $request_data_email = array();
        $request_data_email['booking_total'] = 0;
        $request_data_email['booking_ids'] = array();

	    $request_data['from'] = date("Y-m-d H:i:s", strtotime($form_data['date_one'].' '.$form_data['time_one'])); //date and time of period start in format YYYY-MM-DD HH:MM:SS
	   
	  
	   
	    $form_data['time_one'] = strtotime("+1 minutes", strtotime($form_data['time_one']));
        $form_data['time_one'] = date('H:i:s', $form_data['time_one']);
       // $request_data['till'] = date("Y-m-d H:i:s", strtotime($form_data['date_one_to'].' '.$form_data['time_one_to'])); //date and time of period end in format YYYY-MM-DD HH:MM:SS
	    
	   /* if( $form_data['cosb_trip_type'] == 'Round trip' ){
	        $request_data['till'] = date("Y-m-d H:i:s", strtotime($form_data['date_round'].' '.$form_data['time_round'])); //date and time of period end in format YYYY-MM-DD HH:MM:SS
	    }
	    else{
	        $form_data['time_one'] = strtotime("+1 minutes", strtotime($form_data['time_one']));
            $form_data['time_one'] = date('H:i:s', $form_data['time_one']);
	        $request_data['till'] = date("Y-m-d H:i:s", strtotime($form_data['date_one'].' '.$form_data['time_one'])); //date and time of period end in format YYYY-MM-DD HH:MM:SS
	    }*/
	    
	    
	    $request_data['client'] = $form_data['cos_name'].' '.$form_data['cos_surname']; //varchar : client name and surname
	    
	    $request_data['telnr'] = $form_data['cos_mobile']; //varchar : client phone number
	    
	    //$request_data['price'] = $form_data['cos_route_price_total']??0; //double : price of transfer
	    
	    $request_data['place_from'] = $form_data['place_from']; //varchar : place to pick up client
	    
	    $request_data['place_to'] = $form_data['place_to']; //varchar : place where to transfer client

	    $request_data['agency'] = 'Website';

	    $request_data['flightNr'] = $form_data['cos_Outbound_flight_number']??''; // varchar : flight number
	    //$request_data['passengers'] = $form_data['adults_']; //int : passenger count
	    $request_data['comment'] = $form_data['cos_email'].' [en]'; //text : comment in free form. If comment first line is in format "email+space+[+language+]", for example "test@example.com [en]", application will use it for integrated email sending in GUI.
	    $request_data['comment'] .= ' | Hotel name and address: '.$form_data['cos_Hotel_name_address'];
	    $request_data['comment'] .= ' | 2nd Mobile phone: '.$form_data['cos_mobile_second'];
	    $request_data['comment'] .= ' | Luggage info: '.$form_data['cos_language'];
	    $request_data['comment'] .= ' | Additional notes: '.$form_data['cos_additional_notes'];
	     
	    

        if($form_data['cos_infant_seats'] != ''){
            $request_data['comment'] .= ' | Infant seats: '.$form_data['cos_infant_seats'];
        }
        if($form_data['cos_child_seats'] != ''){
            $request_data['comment'] .= ' | Child seats: '.$form_data['cos_child_seats'];
        }
        if($form_data['cos_booster_seats'] != ''){
            $request_data['comment'] .= ' | Booster seats: '.$form_data['cos_booster_seats'];
        }

        if($form_data['cos_ski_board_bags'] != ''){
            $request_data['comment'] .= ' | Ski/borad bags: '.$form_data['cos_ski_board_bags'];
        }
	    
	    $pessengers_group_count = (int) ( ( $form_data['adults_'] + $form_data['childrens_']) / 8 );
	    $pessengers_remaining = ( $form_data['adults_'] + $form_data['childrens_']) % 8;
	    
	    $route_data__ = $this->cos_api_get_route_price( $form_data['cos_route_id_one'], $form_data['date_one'] );
        if( !empty($route_data__) ){
            $route_data__ = json_decode(json_encode($route_data__), true);
            $r_price_ = $route_data__[$form_data['cos_route_id_one']]['price'];
            $hours = $route_data__[$form_data['cos_route_id_one']]['hours'];
            $request_data['till'] = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours',strtotime($request_data['from'])));
            $request_data['price'] = $r_price_;
			
			if($is_promo){
				$promo_applied = $this->cos_validate_promo_code( $form_data['promo_code'], $request_data['price'] );
				$request_data['price'] = $promo_applied['final_amount'];
			}
			
			$request_data['price'] = $this->cos_get_booking_price_change( $form_data['date_one'], $form_data['time_one'], $request_data['price'], $form_data['place_from'], $form_data['place_to'] );
        }
	    
	    if( $pessengers_group_count > 0){
	        for($i = 0; $i < $pessengers_group_count; $i++){
	            $url = $this->cos_get_api_endpoint_url().'?key='.$this->cos_get_api_key().'&q=transphere/shedule/save';
	            $request_data['passengers'] = 8;
	            $url = add_query_arg( $request_data, $url );

                $request_data_email['booking_total'] = round( ( $request_data_email['booking_total'] + $request_data['price']), 2);

	            $submit_booking = $this->cos_api_run( $url );

                $request_data_email['booking_ids'][] = $submit_booking;
	        }
	    }
	    
	    if( $pessengers_remaining > 0 ){
	        $url = $this->cos_get_api_endpoint_url().'?key='.$this->cos_get_api_key().'&q=transphere/shedule/save';
	        $request_data['passengers'] = $pessengers_remaining;
	        $url = add_query_arg( $request_data, $url );

            $request_data_email['booking_total'] = round( ( $request_data_email['booking_total'] + $request_data['price']), 2);

	         $submit_booking = $this->cos_api_run( $url );

             $request_data_email['booking_ids'][] = $submit_booking;
	    }
	    
		//$request_data_email['booking_total'] = $this->cos_get_booking_price_change( $form_data['date_one'], $form_data['time_one'], $request_data_email['booking_total'] );
	    
		$one_way_price = $request_data_email['booking_total'];
		
	    if( $form_data['cosb_trip_type'] == 'Round trip' ){
	        
			
	        $request_data['flightNr'] = $form_data['cos_Return_flight_number']??''; // varchar : flight number
			
            $route_data__r = $this->cos_api_get_route_price( $form_data['cos_route_id_one'], $form_data['date_round'] );
            if( !empty($route_data__r) ){
                $route_data__r = json_decode(json_encode($route_data__r), true);
                $r_price_r = $route_data__r[$form_data['cos_route_id_one']]['price'];
                 $hours = $route_data__r[$form_data['cos_route_id_one']]['hours'];
                $request_data['price'] = $r_price_r;
				
				if($is_promo){
					$promo_applied = $this->cos_validate_promo_code( $form_data['promo_code'], $request_data['price'] );
					$request_data['price'] = $promo_applied['final_amount'];
				}
				
				$request_data['price'] = $this->cos_get_booking_price_change( $form_data['date_round'], $form_data['time_round'], $request_data['price'], $form_data['place_from'], $form_data['place_to'] );
            }
            
	        
	        $request_data['from'] = date("Y-m-d H:i:s", strtotime($form_data['date_round'].' '.$form_data['time_round'])); //date and time of period start in format YYYY-MM-DD HH:MM:SS
	    
    	    $form_data['time_round'] = strtotime("+1 minutes", strtotime($form_data['time_round']));
            $form_data['time_round'] = date('H:i:s', $form_data['time_round']);
        //    $request_data['till'] = date("Y-m-d H:i:s", strtotime($form_data['date_round_to'].' '.$form_data['time_round_to'])); //date and time of period end in format YYYY-MM-DD HH:MM:SS
            $request_data['till'] = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours',strtotime($request_data['from'])));
            $request_data['place_from'] = $form_data['place_to']; //varchar : place to pick up client
	    
	        $request_data['place_to'] = $form_data['place_from']; //varchar : place where to transfer client
        
	        if( $pessengers_group_count > 0){
    	        for($i = 0; $i < $pessengers_group_count; $i++){
    	            $url = $this->cos_get_api_endpoint_url().'?key='.$this->cos_get_api_key().'&q=transphere/shedule/save';
    	            $request_data['passengers'] = 8;
    	            $url = add_query_arg( $request_data, $url );

                    $request_data_email['booking_total'] = round( ( $request_data_email['booking_total'] + $request_data['price']), 2);

    	            $submit_booking = $this->cos_api_run( $url );

                    $request_data_email['booking_ids'][] = $submit_booking;
    	        }
    	    }
    	    
    	    if( $pessengers_remaining > 0 ){
    	        $url = $this->cos_get_api_endpoint_url().'?key='.$this->cos_get_api_key().'&q=transphere/shedule/save';
    	        $request_data['passengers'] = $pessengers_remaining;
    	        $url = add_query_arg( $request_data, $url );

                $request_data_email['booking_total'] = round( ( $request_data_email['booking_total'] + $request_data['price']), 2);

    	         $submit_booking = $this->cos_api_run( $url );

                 $request_data_email['booking_ids'][] = $submit_booking;
    	    }
			
			//$request_data_email['booking_total'] = round( ($one_way_price + $this->cos_get_booking_price_change( $form_data['date_one'], $form_data['time_one'], ($request_data_email['booking_total'] - $one_way_price) )), 2 );
	    }
	    
	    if( is_object($submit_booking) && isset($submit_booking->error)){
	        $response['status'] = 0;
	        $response['msg'] = $submit_booking->error;
	    }
	    else{
	        $response['status'] = 1;
	        $response['msg'] = 'Booking ID: '.$submit_booking;
	        
	        $this->cos_schedulebull_booking_email( $form_data, $request_data, $request_data_email );
	    }
	    
	    
	    return $response;
	}
	
	
	/**
	 * schedulebull_booking email to user and admin after form successfully submitted
	 *
	 * @since    1.0.0
	 */
	 
	public function cos_schedulebull_booking_email( $booking_form_data, $request_data, $request_data_email ){
	    
	    $admin_email = 'info@loyaltransfers.com';
	    
	    $user_email = $booking_form_data['cos_email'];
	    
	    $email_body = '';
	    
	    $email_body .= '<table style="text-align:left;">
        <tr><th scope="row">Booking ID: </th><td>'.( implode(', ', $request_data_email['booking_ids'])).'</td></tr>
        <tr><th scope="row">Transfer From: </th><td>'.$booking_form_data['place_from'].'</td></tr>
        <tr><th scope="row">Transfer To: </th><td>'.$booking_form_data['place_to'].'</td></tr>
        <tr><th scope="row">Date: </th><td>'.$booking_form_data['date_one'].'</td></tr>
        <tr><th scope="row">Time: </th><td>'.$booking_form_data['time_one'].'</td></tr>
        
        <tr><th scope="row">Trip Type: </th><td>'.$booking_form_data['cosb_trip_type'].'</td></tr>';
        
        if( $booking_form_data['cosb_trip_type'] == 'Round trip'){
            $email_body .= '<tr><th scope="row">Return Date: </th><td>'.$booking_form_data['date_round'].'</td></tr>
        <tr><th scope="row">Return Time: </th><td>'.$booking_form_data['time_round'].'</td></tr>';
        }
         
        
         $email_body .= '<tr><th scope="row">Adults: </th><td>'.$booking_form_data['adults_'].'</td></tr>
        <tr><th scope="row">Childrens: </th><td>'.$booking_form_data['childrens_'].'</td></tr>
        <tr><th scope="row">Total Passengers: </th><td>'.($booking_form_data['adults_']+$booking_form_data['childrens_']).'</td></tr>

        <tr><th scope="row">Payment via Stripe (percent): </th><td>'.$booking_form_data['cos_payment_via_stripe'].'</td></tr>
        <tr><th scope="row">Total tranfer price (euro): </th><td>'.$request_data_email['booking_total'].'</td></tr>
        
        <tr><th scope="row">Lead passangers details: </th><td></td></tr>
        <tr><th scope="row">Name: </th><td>'.$booking_form_data['cos_name'].'</td></tr>
        <tr><th scope="row">Surname: </th><td>'.$booking_form_data['cos_surname'].'</td></tr>
        <tr><th scope="row">Email: </th><td>'.$booking_form_data['cos_email'].'</td></tr>
        <tr><th scope="row">Mobile phone: </th><td>'.$booking_form_data['cos_mobile'].'</td></tr>
        <tr><th scope="row">2nd Mobile phone: </th><td>'.$booking_form_data['cos_mobile_second'].'</td></tr>
        <tr><th scope="row">Luggage info: </th><td>'.$booking_form_data['cos_language'].'</td></tr>
        <tr><th scope="row">Additional notes: </th><td>'.$booking_form_data['cos_additional_notes'].'</td></tr>
        
        <tr><th scope="row">Flight and accomodation details: </th><td></td></tr>
        <tr><th scope="row">Outbound flight number, Arrival time, Date: </th><td>'.$booking_form_data['cos_Outbound_flight_number'].'</td></tr>
        <tr><th scope="row">Return flight number, Departure time, Date: </th><td>'.$booking_form_data['cos_Return_flight_number'].'</td></tr>
        <tr><th scope="row">Hotel name & address: </th><td>'.$booking_form_data['cos_Hotel_name_address'].'</td></tr>
        
        
        
        
        </table>';
        
            $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Loyal Transfers <info@loyaltransfers.com>');
             
            $subject = 'Transfer Availability Request ('.( implode(", ", $request_data_email["booking_ids"])).')';
            wp_mail( $admin_email, $subject, $email_body, $headers );
            
            $email_body = '<table><tr><th>We have received your transfer request, we will contact you shortly to confirm our availability.</th></tr></table>'.$email_body.'<table><tr><th></th></tr>
            <tr><th>To edit your reservation details, please contact with manager - <a href="mailto:info@loyaltransfers.com">info@loyaltransfers.com</a></th></tr></table>';
            $subject = 'Transfer Availability Request ('.( implode(", ", $request_data_email["booking_ids"])).')';
            wp_mail( $user_email, $subject, $email_body, $headers );
	    
	}
	
   
	public function cos_apply_promo_code_ajax(){
		$resonse = array();
		
		$promo_applied = $this->cos_validate_promo_code( $_POST['promo_code'], $_POST['amount'] );
		
		wp_send_json( $promo_applied ); die;
	}
	
	public function cos_validate_promo_code( $promo_code, $amount ){
		$args = array(
			'numberposts' => -1,
			'post_type' => 'cos_promo_code',
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'cos_promo_code',
					'value' => $promo_code
				)
			)
		);
		
		$promos = get_posts($args);
		
		if( !empty($promos) ){
			
			$promo_code = get_post_meta( $promos[0]->ID, 'cos_promo_code', true); 
			$promo_type = get_post_meta( $promos[0]->ID, 'cos_promo_type', true); 
			$promo_amount = get_post_meta( $promos[0]->ID, 'cos_promo_amount', true);
			$discount_amount = 0;
			
			if( $promo_type == 'Flat'){
				$discount_amount = $promo_amount;
			}
			
			if( $promo_type == 'Precentage'){
				$discount_amount = round( ($amount * ( $promo_amount / 100 ) ), 2);
			}
			
			if( $discount_amount <= $amount){
				$final_amount = round( ($amount - $discount_amount), 2);
			}
			else{
				$final_amount = 0;
			}
			
			$result = array(
				'validate' => 1,
				'msg' => 'Promo Code Applied',
				'promo_code' => $promo_code,
				'amount' => $amount,
				'discount_amount' => $discount_amount,
				'final_amount' => $final_amount
			);
		}
		else{
			$result = array(
				'validate' => 0,
				'msg' => 'Invalid Promo Code'
			);
		}

		return $result;
	}
}
