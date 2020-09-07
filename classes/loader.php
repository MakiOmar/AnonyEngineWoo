<?php
if ( !defined('ABSPATH') ) exit();

/**
 * Plugin loader
 */

if(!class_exists('ANOWOO_LOADER')){
	class WC_Product_ANOWOO_LOADER {

	    /**
	     * Build the instance
	     * 
	     *  Make sure every thing runs if woocommerce is loaded
	     */
	    public function __construct() {
	        add_action( 'woocommerce_loaded', [ $this, 'loadPlugin' ] );
	    }
	    
	    /**
	     * BBPRESS product type
	     */
	    public function bbPressProductType(){
	    	
	    	require_once ANOWOO_PRODUCT_TYPES . '/bbpress/bbpress.php';
	        
	        new WC_Product_ANOWOO_BBPRESS_TAB();
	    }
	    
	    /**
	     * BOOK product type
	     */
	    public function BookProductType(){
	    	
	    	require_once ANOWOO_PRODUCT_TYPES . '/book/book.php';
	        
	        new WC_Product_ANOWOO_BOOK_TAB();
	    }
	    
	    /**
	     * Load WC Dependencies
	     *
	     * @return void
	     */
	    public function loadPlugin() {
	        
	        add_action('bbp_loaded', [ $this,  'bbPressProductType']);
	        
	        $this->BookProductType();
	        
	    }
	}
}
