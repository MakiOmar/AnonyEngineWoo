<?php
if ( !defined('ABSPATH') ) exit();

class WC_Product_ANOWOO_BBPRESS extends WC_Product {

    /**
     * Build the instance
     * 
     */
    public function __construct( $product ) {
    	
    	$this->product_type = 'anowoo_bbpress';
    	 
		parent::__construct( $product );
        
    }

}
