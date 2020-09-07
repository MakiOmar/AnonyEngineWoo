<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function anowoo_products_by_type($atts){
    
    $atts = shortcode_atts( array(
		'type' => 'simple',
	), $atts );
	
	extract ($atts);
	
	$query_args = array(
       'post_type' => 'product',
       'tax_query' => array(
            array(
                'taxonomy' => 'product_type',
                'field'    => 'slug',
                'terms'    => $type, 
            ),
        ),
     );
     
     $products = new WP_Query($query_args);
     
     $data = [];
     
     if($products->have_posts()){
         
         while($products->have_posts()){
             $products->the_post();
             
            $p = wc_get_product(get_the_ID());
            
            
            $data[] = anowoo_common_product_data($p);
            
         }
         
         wp_reset_postdata();
     }
     
	
	if(!empty($data)){
	    
	    ob_start();
	    
	    include(ANOWOO_TEMPLATES_DIR .'/woo_grid_1.php');
	    
	    return ob_get_clean();
	}
    
    return esc_html__('No products found', ANOWOO_TEXTDOM);
}

add_shortcode( 'anowoo_products_by_type', 'anowoo_products_by_type' );
