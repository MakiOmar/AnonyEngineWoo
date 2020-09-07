<?php

/**
 * Collects common post data.
 * 
 * Should be used inside the loop.
 * 
 * @param object $product Product object
 * @return array
 */
function anowoo_common_product_data($product){
	
	if(!is_object($product)) return [];
	
	$temp['id']        = get_the_ID();
	
	$temp['permalink'] = esc_url(get_the_permalink());
	
	$temp['title']     = esc_html(get_the_title());
	
	$temp['title_attr']        = the_title_attribute( ['echo' => false] );
	
	$temp['content']   = apply_filters('the_content',get_the_content());
	
	$temp['excerpt']   = esc_html(get_the_excerpt());
	
	$temp['thumb']     = has_post_thumbnail();
	
	$temp['thumb_img_full']    = get_the_post_thumbnail(get_the_ID(), 'full');
	
	$temp['thumb_img_full_url']    = esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full'));
	
	$temp['thumbnail_img'] = esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'));
	
	$temp['date']        = get_the_date();
	
	$temp['onsale']      = esc_html($product->is_on_sale());
	
	$temp['sale_price']  = esc_html($product->get_sale_price());
	
	$temp['price'] = esc_html($product->get_regular_price());
	
	$temp['add_to_cart_text'] = esc_html( $product->single_add_to_cart_text() );
	
    $temp['rating_html'] = wc_get_rating_html( $product->get_average_rating() );
    
    $temp['price_html'] = $product->get_price_html();
    
    $temp['sale_text']      = apply_filters('woocommerce_sale_flash', esc_html__( 'Sale!', 'woocommerce' ), $product, $product);
    
    // Compatibility for WC versions from 2.5.x to 3.0+
    if ( method_exists( $product, 'get_stock_status' ) ) {
        $temp['stock_status'] = esc_html($product->get_stock_status()); // For version 3.0+
    } else {
        $temp['stock_status'] = esc_html($product->stock_status); // Older than version 3.0
    }
	
	
	
	return $temp;
	
}
