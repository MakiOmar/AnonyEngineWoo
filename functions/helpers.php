<?php

function wcpt_get_setting($option_name)
{
    $value = get_option( $option_name );
    
    if( $value && !empty( $option_name ) )
    {
        return $value;
    }
    
    return false;
}
/**
 * Read textarea content line by line.
 *
 * @param string $content To be read multi-line text.
 * @return array An array of text's lines.
 */
function wcpt_line_by_line_textarea( $content ) {

	return explode( "\r\n", trim( $content ) );

}

function wcpt_value_price($meta_key, $product_id){
    $options = get_post_meta($product_id, $meta_key, true);
    
    if( $options && !empty( $options ) )
    {
        $options_array = wcpt_line_by_line_textarea($options);

		if( $options_array && is_array($options_array) )
		{
		    $temp = array();
		    foreach ($options_array as $value)
		    {
		        if( strpos($value, '|') !== false ){
			        $value_arr = explode( '|', $value );
			        if( !empty( $value_arr[1] ) )
			        {
			            $temp[$value_arr[0]] = $value_arr[1];
			        }else{
			            $temp[$value] = '0';
			        }
			        
			    }else{
			        $temp[$value] = '0';
			    }
		    }
		    
		    return $temp;
		}
    }
    
    return false;
}
function wcpt_render_select( $product_id, $meta_key, $suffix = false )
{

	$options = get_post_meta($product_id, $meta_key, true);
	
	$package_size_price = get_post_meta( $product_id, 'package_size_price', true );

	if( !empty( $options ) )
	{
		$options_array = wcpt_line_by_line_textarea($options);

		if( $options_array && is_array($options_array) )
		{
			?>
			<select id="<?php echo  ($suffix) ? $meta_key . $suffix : $meta_key ?>" class="<?php echo  ($suffix) ? $meta_key . ' eye' . $suffix : $meta_key. ' eye' ?> eye_option" name="<?php echo  ($suffix) ? $meta_key . $suffix : $meta_key ?>">
				<option value="">--</option>
				<?php foreach ($options_array as $index => $value) {
				    $price = '0';
				    if( strpos($value, '|') !== false ){
				        $value_arr = explode( '|', $value );
				        
				        $value = $value_arr[0];
				        
				        if( !empty( $value_arr[1] ) )
				        {
				            $price = $value_arr[1];
				        }
				    }
				    /*
				    if( 'package_size' == $meta_key && $index == 0 && !empty( $package_size_price )){
				        $price = $package_size_price;
				    }*/
				?>
					<option value="<?php echo esc_attr($value) ?>" data-price="<?php echo esc_attr($price) ?>"><?php echo esc_html($value) ?></option>
				<?php } ?>

			</select>
			<?php
		}
	}

}
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
