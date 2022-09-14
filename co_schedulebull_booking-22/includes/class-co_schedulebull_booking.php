<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cloud1.me/
 * @since      1.0.0
 *
 * @package    Co_schedulebull_booking
 * @subpackage Co_schedulebull_booking/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Co_schedulebull_booking
 * @subpackage Co_schedulebull_booking/includes
 * @author     Gaurav Garg <gauravgargcs1991@gmail.com>
 */
class Co_schedulebull_booking {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Co_schedulebull_booking_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CO_SCHEDULEBULL_BOOKING_VERSION' ) ) {
			$this->version = CO_SCHEDULEBULL_BOOKING_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'co_schedulebull_booking';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shortcodes();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Co_schedulebull_booking_Loader. Orchestrates the hooks of the plugin.
	 * - Co_schedulebull_booking_i18n. Defines internationalization functionality.
	 * - Co_schedulebull_booking_Admin. Defines all hooks for the admin area.
	 * - Co_schedulebull_booking_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-co_schedulebull_booking-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-co_schedulebull_booking-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-co_schedulebull_booking-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-co_schedulebull_booking-public.php';
		
		/**
		 * The class responsible for defining all actions that occur in the stripe-payment-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-co_schedulebull_booking-stripe.php';

		$this->loader = new Co_schedulebull_booking_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Co_schedulebull_booking_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Co_schedulebull_booking_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Co_schedulebull_booking_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// adding admin menu page 
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'cos_admin_menu_page' );
		
		//Add Setting Page fields
		$this->loader->add_action( 'admin_init', $plugin_admin, 'cos_setting_settings_init' );
		
		// Registering 'cos_promo_code' custom post type
		$this->loader->add_action( 'init', $plugin_admin, 'cos_regitser_cos_promo_code_post_type' );
		
		// adding promo meta box
        $this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'cos_promo_code_add_custom_box' );
		
		// saving metabox data
		$this->loader->add_action( 'save_post', $plugin_admin, 'cos_promo_code_save_data' );
		$this->loader->add_action( 'new_to_publish', $plugin_admin, 'cos_promo_code_save_data' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Co_schedulebull_booking_Public( $this->get_plugin_name(), $this->get_version() );
		$plugin_stripe = new cos_StripePayment( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		$this->loader->add_action( 'wp_ajax_nopriv_cos_api_get_routes_ajax', $plugin_public, 'cos_api_get_routes_ajax_callback' );
        $this->loader->add_action( 'wp_ajax_cos_api_get_routes_ajax', $plugin_public, 'cos_api_get_routes_ajax_callback' );
        
        $this->loader->add_action( 'wp_ajax_nopriv_cos_api_get_route_price_ajax', $plugin_public, 'cos_api_get_route_price_ajax_callback' );
        $this->loader->add_action( 'wp_ajax_cos_api_get_route_price_ajax', $plugin_public, 'cos_api_get_route_price_ajax_callback' );
        
        $this->loader->add_action( 'wp_ajax_nopriv_cos_api_check_round_routes_ajax', $plugin_public, 'cos_api_check_round_routes_ajax_callback' );
        $this->loader->add_action( 'wp_ajax_cos_api_check_round_routes_ajax', $plugin_public, 'cos_api_check_round_routes_ajax_callback' );
		
		$this->loader->add_action( 'wp_ajax_nopriv_cos_apply_promo_code_ajax', $plugin_public, 'cos_apply_promo_code_ajax' );
        $this->loader->add_action( 'wp_ajax_cos_apply_promo_code_ajax', $plugin_public, 'cos_apply_promo_code_ajax' );
		
		$this->loader->add_action( 'wp_ajax_nopriv_cos_stripe_ajax', $plugin_stripe, 'cos_stripe_ajax' );
        $this->loader->add_action( 'wp_ajax_cos_stripe_ajax', $plugin_stripe, 'cos_stripe_ajax' );
	}
	
	/**
	 * Register all of the shortcodes related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_shortcodes(){
	    $plugin_public = new Co_schedulebull_booking_Public( $this->get_plugin_name(), $this->get_version() );
	    // Shortcode to show booking form
	    add_shortcode( 'schedulebull_booking_form', array($plugin_public, 'cos_schedulebull_booking_form_callback') );
	    
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Co_schedulebull_booking_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
