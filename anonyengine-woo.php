<?php
if ( !defined('ABSPATH') ) exit();
/***
 * Plugin Name: Optical products
 * Plugin URI: https://makiomar.com
 * Description: Add a new optical product type for woocommerce
 * Version: 1.0.1
 * Author: Mohammad Omar
 * Author URI: https://makiomar.com
 * Text Domain: wcpt
 * License: GPL2
*/

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action(
    'plugins_loaded',
    function() {
        load_plugin_textdomain( 'wcpt', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }
);

/**
 * Holds plugin PATH
 * @const
 */ 
define('ANOWOO_DIR' , wp_normalize_path(plugin_dir_path( __FILE__ )));

require_once (wp_normalize_path( ANOWOO_DIR . '/config.php' ));

require_once (wp_normalize_path( ANOWOO_FUNCTIONS_DIR . '/shortcodes/woo-query-by-type.php' ));

require_once (wp_normalize_path( ANOWOO_FUNCTIONS_DIR . '/helpers.php' ));
require_once (wp_normalize_path( ANOWOO_CLASSES . '/class-anony-wc-settings-tab.php' ));

new WC_Product_ANOWOO_LOADER();


