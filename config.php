<?php
if ( !defined('ABSPATH') ) exit();

/**
 * Holds plugin text domain
 * @const
 */
define('ANOWOO_TEXTDOM', 'anonyengine-woo');


/**
 * Holds plugin uri
 * @const
 */
define('ANOWOO_URI', plugin_dir_url( __FILE__ ));

/**
 * Holds classes folder path
 * @const
 */
define('ANOWOO_CLASSES', wp_normalize_path(ANOWOO_DIR . '/classes'));

/**
 * Holds product types' folder path
 * @const
 */
define('ANOWOO_PRODUCT_TYPES', wp_normalize_path(ANOWOO_CLASSES . '/product-types'));

/**
 * Holds functions' folder path
 * @const
 */
define('ANOWOO_FUNCTIONS_DIR', wp_normalize_path(ANOWOO_DIR . '/functions'));
	
/**
 * Holds templates' folder path
 * @const
 */
define('ANOWOO_TEMPLATES_DIR', wp_normalize_path(ANOWOO_DIR . '/templates'));
		
	
	/*----------------------Autoloading -------------------------*/

define('ANOWOO_AUTOLOADS' ,serialize(array(
	ANOWOO_CLASSES,
	ANOWOO_PRODUCT_TYPES
)));


/*
*Classes Auto loader
*/
spl_autoload_register( function ( $class_name ) {

	if ( false !== strpos( $class_name, 'WC_Product_ANOWOO_' )) {
		
		$original_name = $class_name;

		$class_name = preg_replace('/WC_Product_ANOWOO_/', '', $class_name);

		$class_name  = strtolower(str_replace('_', '-', $class_name));
		
		$class_file = $class_name .'.php';
		
		
		if(file_exists($class_file)){

			require_once($class_file);
			
			return;
		}
		foreach(unserialize( ANOWOO_AUTOLOADS ) as $path){
			
			
			$class_file = wp_normalize_path($path) .'/'  .$class_name . '.php';
			

			if(file_exists($class_file)){

				require_once($class_file);
				
				return;
			}
			

			$class_file = wp_normalize_path($path .'/' . $class_name .'/' .$class_name . '.php');

			if(file_exists($class_file)){

				require_once($class_file);
				
				return;
			}

			$class_folder = explode('-', $class_name);
			
			$class_file = wp_normalize_path($path .'/' . $class_folder[0] .'/' .$class_name . '.php');

			if(file_exists($class_file)){

				require_once($class_file);
				
				return;
			}
			
		}
				
	}
} );


