<?php
if ( !defined('ABSPATH') ) exit();
/**
 * Plugin Name: AnonyEngine Woocommerce
 * Plugin URI: https://makiomar.com
 * Description: With AnonyEngine you can add any kind of Woocommerce functionality
 * Version: 1.0.1
 * Author: Mohammad Omar
 * Author URI: https://makiomar.com
 * Text Domain: anonyengine-woo
 * License: GPL2
*/


/**
 * Holds plugin PATH
 * @const
 */ 
define('ANOWOO_DIR' , wp_normalize_path(plugin_dir_path( __FILE__ )));

require_once (wp_normalize_path( ANOWOO_DIR . '/config.php' ));

require_once (wp_normalize_path( ANOWOO_FUNCTIONS_DIR . '/shortcodes/woo-query-by-type.php' ));

require_once (wp_normalize_path( ANOWOO_FUNCTIONS_DIR . '/helpers.php' ));


new WC_Product_ANOWOO_LOADER();

