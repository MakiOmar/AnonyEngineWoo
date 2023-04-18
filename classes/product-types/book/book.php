<?php
if ( !defined('ABSPATH') ) exit();

class WC_Product_ANOWOO_BOOK extends WC_Product {

    /**
     * Build the instance
     * 
     */
    public function __construct( $product ) {
    	error_log('WC_Product_ANOWOO_BOOK is called');
    	$this->product_type = 'anowoo_book';
    	$this->supports[]   = 'ajax_add_to_cart';
    	 
		parent::__construct( $product );   
    }

    public function  single_add_to_cart_text() {
        
    	global $product;
    	
    	$product_type = $product->get_type();
    	
    	switch ( $product_type ) {
    		case 'anowoo_book':
    			return __( 'Buy Now', 'woocommerce' );
    		break;
    		
    		default:
    			return __( 'Add to cart', 'woocommerce' );
    	}
    	
    }

}

function anowoo_book_template () {
	
	global $product;
	if ( 'anowoo_book' == $product->get_type() ) {

		$template_path = ANOWOO_CLASSES . '/product-types/book';
		// Load the template
		wc_get_template( '/book-add-to-cart.php',
						'',
						'',
						trailingslashit( $template_path ) );
	}
}

add_action( 'woocommerce_single_product_summary', 'anowoo_book_template' );