<?php
if ( !defined('ABSPATH') ) exit();

class WC_Product_ANOWOO_OPTIC extends WC_Product {

    /**
     * Build the instance
     * 
     */
    public function __construct( $product ) {

    	
    	$this->product_type = 'anowoo_optic';
    	$this->supports[]   = 'ajax_add_to_cart';
    	 
		parent::__construct( $product );
		
		add_filter( 'woocommerce_product_add_to_cart_text' , [$this, 'single_add_to_cart_text']);
        
    }

    public function single_add_to_cart_text() {
        
    	global $product;
    	
    	$product_type = $product->get_type();
    	
    	switch ( $product_type ) {
    		case 'anowoo_optic':
    			return __( 'Add to cart', 'woocommerce' );
    		break;
    		
    		default:
    			return __( 'Add to cart', 'woocommerce' );
    	}
    	
    }

}

add_action( 'woocommerce_single_product_summary', 'anowoo_optic_template' );

function anowoo_optic_template () {

    global $product;
    if ( 'anowoo_optic' == $product->get_type() ) {

        $template_path = ANOWOO_CLASSES . '/product-types/optic';
        // Load the template
        wc_get_template( '/optic-add-to-cart.php',
            '',
            '',
            trailingslashit( $template_path ) );
    }
}

define('WCPT_OPTICAL_FIELDS', serialize( array(
    'which-eye',
    'base-curve_right',
    'diameter_right',
    'eye_power_right',
    'eye_cylinder_right',
    'eye_axis_right',
    'base-curve_left',
    'diameter_left',
    'eye_power_left',
    'eye_cylinder_left',
    'eye_axis_left',
    'package_size',
    'eye-right-quantity',
    'eye-left-quantity', 
    'lens_color_name',
) ));

define('OPTICS_GETTEXT_CART', serialize( array(
    'eye_power'    => wcpt_get_setting('wc_oprics_settings_Sph') ? wcpt_get_setting('wc_oprics_settings_Sph') : esc_html__( "Power", 'wcpt' ),
    'eye_cylinder' => wcpt_get_setting('wc_oprics_settings_Cyl') ? wcpt_get_setting('wc_oprics_settings_Cyl') : esc_html__( "Cylinder", 'wcpt' ),
    'eye_axis'     => wcpt_get_setting('wc_oprics_settings_Axis') ? wcpt_get_setting('wc_oprics_settings_Axis') : esc_html__( "Axis", 'wcpt' ),
    'eye_add'      => wcpt_get_setting('wc_oprics_settings_Add') ? wcpt_get_setting('wc_oprics_settings_Add') : esc_html__( "Add", 'wcpt' ),
    'eye_ipd'      => wcpt_get_setting('wc_oprics_settings_Ipd') ? wcpt_get_setting('wc_oprics_settings_Ipd') : esc_html__( "Ipd", 'wcpt' ),
    'eye'          => esc_html__( "Eye", 'wcpt' ),
    'right'        => esc_html__( "Right", 'wcpt' ),
    'left'         => esc_html__( "Left", 'wcpt' ),
    'base-curve'   => esc_html__( "Base curve", 'wcpt' ),
    'diameter'     => esc_html__( "Diameter", 'wcpt' ),
    'quantity' => esc_html__( "Quantity", 'wcpt' ),
    'eye-right-quantity' => esc_html__( "Right package quantity", 'wcpt' ),
    'eye-left-quantity'  => esc_html__( "Left package quantity", 'wcpt' ),
    'package_size'       => esc_html__( "Package size", 'wcpt' ),
    'accessory'          => esc_html__( "Accessory only", 'wcpt' ),
    'prescription'       => esc_html__( "With a prescription", 'wcpt' ),
) ));
add_filter( 'woocommerce_add_cart_item_data', function ( $cart_item_data, $product_id, $variation_id ) {
	global $woocommerce;
	
	
    $size_price = get_post_meta( $product_id, 'size_price', true );
    
    if( empty($size_price) ) return $cart_item_data;
    
    $total_size_price = 0;
    
    if( !empty($_POST['eye_power_right']) &&  !in_array( $_POST['eye_power_right'], array('', '0.0', '0.00', '0') ) ){
        $total_size_price += $size_price * $_POST['eye-right-quantity'];
        
    }
    
    
    if( !empty($_POST['eye_power_left']) &&  !in_array( $_POST['eye_power_left'], array('', '0.0', '0.00', '0') ) ){
        $total_size_price += $size_price * $_POST['eye-left-quantity'];

    }
    
    $cart_item_data['size_price'] = $total_size_price;
    
    /*-------------------Package size------------------*/
    
    $total_package_size_price = 0;

    $package_sizes_prices = wcpt_value_price('package_size', $product_id);
    
    if( is_array( $package_sizes_prices ) && !empty( $package_sizes_prices ) && !empty( $_POST['package_size'] ) && isset( $package_sizes_prices[$_POST['package_size']] )){
        
        $selected_package_price = $package_sizes_prices[$_POST['package_size']];
    
        if( !empty( $_POST['eye-right-quantity'] ) )
        {
            $total_package_size_price += $selected_package_price * $_POST['eye-right-quantity'];
        }
        
        if( !empty( $_POST['eye-left-quantity'] ) )
        {
            $total_package_size_price += $selected_package_price * $_POST['eye-left-quantity'];
        }
    }
    
    
    $cart_item_data['total_package_size_price'] = $total_package_size_price;

    $fields = unserialize( WCPT_OPTICAL_FIELDS );
    
    $session = array();
    foreach( $fields as $field ){
        if ( isset( $_POST[$field] ) ) {
            
            if( is_array( $_POST[$field] ) )
            {
                $value = $_POST[$field];
            }else{
                $value = sanitize_text_field( $_POST[$field] );
            }
            $cart_item_data[$field] = $value;
            
            $session[$field] = $value;
        }
    }
    $session['size_price']               = $total_size_price;
    $session['total_package_size_price'] = $total_package_size_price ;
    
	$woocommerce->session->set( 'optics_preferences', $session );
	
    return $cart_item_data;
} , 10, 3 );

add_action( 'woocommerce_add_order_item_meta', 'wcpt_add_values_to_order_item_meta' , 1, 2 );

function wcpt_add_values_to_order_item_meta( $item_id, $values ) {
	global $woocommerce,$wpdb;
	$session = $woocommerce->session->get( 'optics_preferences' );
	
	if( is_array( $session ) ){
		foreach( $session as $key => $value ){
		    if( is_array($value) ){
		        $_value = implode(',' ,$value);
		    }else{
		        $_value = $value;
		    }
			wc_add_order_item_meta( $item_id, $key, $_value );
		}
	}
}
add_filter( 'woocommerce_order_item_display_meta_key', function ( $display_key, $meta ) {
	$fields = unserialize( WCPT_OPTICAL_FIELDS );
	foreach( $optics_text as $field  ){
        if( $meta->key === $field ){
            return ucfirst(str_replace( ['_', '-'], ' ', $field ));
        }
    }
	
	return $display_key;


} , 20, 2 );

add_filter( 'woocommerce_get_item_data', function ( $item_data, $cart_item ) {
   
    $fields = unserialize( WCPT_OPTICAL_FIELDS );
        
    foreach( $fields as $field ){
        if ( isset( $cart_item[$field] ) ) {
            
            
           $item_data[] = array(
               'key'   => ucfirst(str_replace( ['_', '-'], ' ', $field )),
               //'key'   => $cart_texts[$field],
               'value' => ($field == 'which-eye') ? implode(',', $cart_item[$field]) : $cart_item[$field]
           );
       }
    }
   

   return $item_data;
}, 10, 2 );


add_action( 'woocommerce_before_calculate_totals', function ( $cart_object ) {

	foreach ( $cart_object->cart_contents as $cart_item_key => $value ) {
	    $product_id = $value['product_id'];
	    $product = wc_get_product($product_id);
        $thePrice = $product->get_price();
        $thePrice_right = 0;
        $thePrice_left= 0;
        if( !empty( $value['eye-right-quantity'] ) ){
            $thePrice_right = $thePrice * $value['eye-right-quantity'] ;
        }
        
        if(  !empty( $value['eye-left-quantity'] ) ){
            $thePrice_left = $thePrice * $value['eye-left-quantity'] ;
        }
        
        $thePrice = $thePrice_left + $thePrice_right;
        
        if( $thePrice == 0 ){
            return;
        }
        if( !empty( $value['size_price'] ) && is_numeric( $value['size_price'] ) ){
            
            $thePrice += $value['size_price'];
            

        }
 
        if( !empty( $value['total_package_size_price'] ) ){

            $thePrice += $value['total_package_size_price']  ;
            
        }
        
        
        $value['data']->set_price( $thePrice/$value['quantity'] );
	}
}, 1100);
   

add_filter( 'woocommerce_product_data_tabs', function ( $tabs ) {
    $tabs['inventory']['class'][] = 'show_if_anowoo_optic';
    return $tabs;
}, 10, 2 );




add_action( 'admin_footer', function () {
    if ( 'product' != get_post_type() ) :
        return;
    endif;
    ?>
    <script type='text/javascript'>
        jQuery(document).ready(function () {
            //for Price tab
            jQuery('.product_data_tabs .general_tab').addClass('show_if_anowoo_optic').show();
            jQuery('#general_product_data .pricing').addClass('show_if_anowoo_optic').show();
            //for Inventory tab
            jQuery('.inventory_options').addClass('show_if_anowoo_optic').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_anowoo_optic').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_anowoo_optic').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_anowoo_optic').show();
        });
    </script>
    <?php

} );
add_action( 'wp_head', function(){
    ?>

        <style type="text/css">
            
            .woocommerce td.product-name dl.variation dt{
                float: none;
                clear: initial;
            }
            .woocommerce td.product-name dl.variation dd{
                display: inline-block;
            }
        </style>

    <?php
} );

add_action('wp_enqueue_scripts', function(){
    if ( 'product' != get_post_type() ) :
        return;
    endif;
    
    wp_enqueue_script('toggle-switch', ANOWOO_URI . 'assets/js/toggle-switch.js', ['jquery'], '1.2.0', false);
    wp_enqueue_style('toggle-switch', ANOWOO_URI . 'assets/css/toggle-switch.css', [], '1.2.0');
    
});


function add_preview_section_to_product_image_container() {
        
            echo '<div class="preview"><div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4" style="opacity: 1; transition: opacity 0.25s ease-in-out 0s;">
	<figure class="woocommerce-product-gallery__wrapper"><img id="preview-image" src=""></figure>
</div></div>';
}

add_action( 'woocommerce_before_single_product', function(){
    if( is_singular('product') ){
        $product_id = get_the_ID();
        $jsonString = get_post_meta($product_id,'lens_variaions',true);
        if( !empty( $jsonString ) ){
            $data = json_decode($jsonString, true);
            if( $data && is_array($data) ){
                // Remove the default product image display
                remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
                // Add a custom div element to hold the preview section
                add_action( 'woocommerce_before_single_product_summary', 'add_preview_section_to_product_image_container', 10 );
            }
        }
    }
} );









