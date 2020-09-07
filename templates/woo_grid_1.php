<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
echo '<pre>';
	var_dump($product);
	echo '</pre>';
*/
?>

<div class="jet-woo-products jet-woo-products--preset-2  col-row">
    
    <?php
    foreach($data as $product) :
        
        extract($product);
    ?>
    
    
    <div class="jet-woo-products__item jet-woo-builder-product col-desk-4" data-product-id="<?= $id ?>">
        
    	<div class="jet-woo-products__inner-box">
    		
    		<div class="jet-woo-products__thumb-wrap">
    	    
    			<div class="jet-woo-product-thumbnail">
    			    
    				<a href="<?= $permalink ?>" rel="bookmark"><img src="<?= $thumb_img_full_url ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" data-no-lazy="1" width="188" height="300"></a>
    				
    				<div class="jet-woo-product-img-overlay"></div>
    				
    				
    				<div class="jet-woo-product-badges">
    				    <?php if($onsale) : ?>
    				        <div class="jet-woo-product-badge jet-woo-product-badge__sale"><?= $sale_text ?></div>
    				    <?php endif ?>
    				</div>
    			
    			</div>
    			
    			<div class="hovered-content">
    				<div class="jet-woo-product-button is--default">
    					<a href="<?= $permalink ?>" data-quantity="1" class="button product_type_anowoo_book add_to_cart_button ajax_add_to_cart" data-product_id="<?= $id ?>" data-product_sku="" aria-label="Read more about “<?= $title_attr ?>”" rel="nofollow"><?= $add_to_cart_text ?></a>
    				</div>
    			</div>
    		
    		</div>
    		
    		<div class="jet-woo-product-stock-status jet-woo-product-stock-status__in-stock"><?= $stock_status ?></div>
    		
    		<h5 class="jet-woo-product-title">
    			<a href="<?= $permalink ?>" rel="bookmark"><?= $title ?></a>
    		</h5>
    		
    		<div class="jet-woo-product-price">
    			<del>
    				<span class="woocommerce-Price-amount amount">
    					<bdi><span class="woocommerce-Price-currencySymbol">$</span><?= $sale_price ?></bdi>
    				</span>
    			</del>
    			
    			<ins>
    				<span class="woocommerce-Price-amount amount">
    					<bdi><span class="woocommerce-Price-currencySymbol">$</span><?= $price ?></bdi>
    				</span>
    			</ins>
    		</div>
    		
    		<div class="jet-woo-product-excerpt"></div>
    		<div class="jet-woo-products-cqw-wrapper"></div>
    	</div>
    </div>
    
    <?php endforeach ?>
</div>