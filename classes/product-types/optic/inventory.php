<?php

global $product_object;

?>
<div id="inventory_product_data" class="panel woocommerce_options_panel">

    <?php do_action( 'woocommerce_product_options_inventory_product_data_start', $product_object ); ?>

    <div class="options_group">

        <?php
        woocommerce_wp_checkbox(
            array(
                'id'            => '_manage_stock',
                'label'         => __( 'Manage stock', 'woocommerce' ),
                'description'   => __( 'Enable stock management at product level', 'woocommerce' ),
                'value'         => $product_object->get_manage_stock( 'edit' ) ? 'yes' : 'no',
            )
        );

        woocommerce_wp_text_input(
            array(
                'id'            => '_stock',
                'label'         => __( 'Stock quantity', 'woocommerce' ),
                'desc_tip'      => true,
                'description'   => __( 'Current stock quantity.', 'woocommerce' ),
                'type'          => 'number',
                'custom_attributes' => array(
                    'step'  => 'any',
                    'min'   => '0'
                ),
                'value'         => $product_object->get_stock_quantity( 'edit' ),
            )
        );

        // Add any other inventory fields that you need for your custom product type here.

        ?>

    </div>

    <?php do_action( 'woocommerce_product_options_inventory_product_data_end', $product_object ); ?>

</div>