<?php
if ( !defined('ABSPATH') ) exit();

class WC_Product_ANOWOO_BOOK_TAB {
	
	/**
	 * @var array Product type meta fields
	 */
	public $meta;

    /**
     * Build the instance
     * 
     */
    public function __construct( ) {
    	
    	$this->meta = [
                'book_code',
                'book_author',
                'book_pages_number',
                'book_publish_date',
                'book_publisher',
                'book_cover',
                'book_units_number',
                
            ];
    
    	
    	//Add product type to selector dropdown
        add_filter( 'product_type_selector', [ $this, 'addToSelector'] );
        
        //Add tab to tabs sidebar   
        add_filter( 'woocommerce_product_data_tabs', [ $this, 'typeTab'] );
        
        //Add tab's panel
        add_action( 'woocommerce_product_data_panels', [ $this, 'tabPanel'] );
        
        //Save meta data
        add_action( 'woocommerce_admin_process_product_object', [ $this, 'save'], 99 );
        
    }
    
    /**
         * Add product type to selector dropdown
         * @param  array $types 
         * @return array
         */
        public function addToSelector( $types ){
            $types[ 'anowoo_book' ] = __( 'Book', ANOWOO_TEXTDOM );

            return $types;  
        }
            
        /**
         * Add tab to tabs sidebar
         * @param  array $tabs 
         * @return array
         */
        public function typeTab( $tabs) {
        
            $tabs['book'] = array(
              'label'    => __( 'Book meta', ANOWOO_TEXTDOM ),
              'target' => 'book_meta',
              'class'  => 'show_if_bbPress hide_if_anowoo_optic hide_if_simple hide_if_variable hide_if_grouped hide_if_external',
             );
            return $tabs;
        }
        
        /**
         * Add tab's panel
         * @return void
         */
        public function tabPanel(){?>
            <div id='book_meta' class='panel woocommerce_options_panel'>
                <div class='options_group'>
                    <?php
                           $currency = get_woocommerce_currency_symbol();
                           $reg_price =  array(
                              'id' => '_regular_price',
                              'label' => sprintf(__( 'Regular price (%s)', 'dm_product' ), $currency),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => sprintf(__( 'Regular price (%s)', 'dm_product' ), $currency),
                              'type' => 'text'
                            ); 
                            
                            $sale_price = array(
                              'id' => '_sale_price',
                              'label' => sprintf(__( 'Sale price (%s)', 'dm_product' ), $currency),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => sprintf(__( 'Sale price (%s)', 'dm_product' ), $currency),
                              'type' => 'text'
                            );
                        woocommerce_wp_text_input($reg_price);
                        
                        woocommerce_wp_text_input($sale_price);
                        
                        woocommerce_wp_text_input(
                            array(
                              'id' => 'book_code',
                              'label' => __( 'Book code', 'dm_product' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Book code', 'dm_product' ),
                              'type' => 'text'
                            )
                        );
                        
                        woocommerce_wp_text_input(
                            
                            array(
                                'id' => 'book_author',
                                'label' => __( 'Book author', 'dm_product' ),
                                'placeholder' => '',
                                'desc_tip' => 'true',
                                'description' => __( 'Book author', 'dm_product' ),
                                'type' => 'text'
                            )
                        );
                        
                        woocommerce_wp_text_input(
                            array(
                                'id' => 'book_pages_number',
                                'label' => __( 'Book numper of pages', 'dm_product' ),
                                'placeholder' => '',
                                'desc_tip' => 'true',
                                'description' => __( 'Book numper of pages', 'dm_product' ),
                                'type' => 'text'
                            )
                        );
                        
                        woocommerce_wp_text_input(  
                            array(
                                'id' => 'book_publish_date',
                                'label' => __( 'Book publish date', 'dm_product' ),
                                'placeholder' => '',
                                'desc_tip' => 'true',
                                'description' => __( 'Book publish date', 'dm_product' ),
                                'type' => 'text'
                            )
                        );
                        
                        woocommerce_wp_text_input(
                             
                            array(
                                'id' => 'book_publisher',
                                'label' => __( 'Book publisher', 'dm_product' ),
                                'placeholder' => '',
                                'desc_tip' => 'true',
                                'description' => __( 'Book publisher', 'dm_product' ),
                                'type' => 'text'
                            )
                        );
                        
                        woocommerce_wp_text_input(
                             
                            array(
                                'id' => 'book_cover',
                                'label' => __( 'Book cover', 'dm_product' ),
                                'placeholder' => '',
                                'desc_tip' => 'true',
                                'description' => __( 'Book cover', 'dm_product' ),
                                'type' => 'text'
                            )
                            
                        );
                        
                        woocommerce_wp_text_input(   
                            array(
                                'id' => 'book_units_number',
                                'label' => __( 'Book units number', 'dm_product' ),
                                'placeholder' => '',
                                'desc_tip' => 'true',
                                'description' => __( 'Book units number', 'dm_product' ),
                                'type' => 'text'
                            )
                        );
                        
                    ?>
                    
                </div>
            </div>
        <?php }
        
        /**
         * Update meta key
         * @param string $key 
         * @return void
         */
        public function update($key, $product){
            
                // Update the product meta with the custom field values
                $product->update_meta_data( $key , wp_strip_all_tags( $_POST[$key] ) );

                // Save the product data
                $product->save();   
            
        }
        
        
        public function save($product){                        
            foreach ($this->meta as $key) {
                $this->update($key, $product);
            }
        
           
            
        }


}