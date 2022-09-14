<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cloud1.me/
 * @since      1.0.0
 *
 * @package    Co_schedulebull_booking
 * @subpackage Co_schedulebull_booking/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Co_schedulebull_booking
 * @subpackage Co_schedulebull_booking/includes
 * @author     Gaurav Garg <gauravgargcs1991@gmail.com>
 */
class Co_schedulebull_booking_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$plugin_self = new Co_schedulebull_booking();
        
        $plugin_admin = new Co_schedulebull_booking_Admin( $plugin_self->get_plugin_name(), $plugin_self->get_version() );

        // Registering 'cpc_product_catalog' custom post type
	    $plugin_admin->cos_regitser_cos_promo_code_post_type();
	    
	    // Flushing rewrite
        flush_rewrite_rules();
	}

}
