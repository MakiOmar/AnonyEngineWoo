<?php
if ( !defined('ABSPATH') ) exit();

class WC_Product_ANOWOO_PRODUCT_TYPE_TAB {
    
    
    /**
     * @var string Product type slug
     */
    public $type;
    
    /**
     * @var string Product type title
     */
    public $type_title;
       
    /**
     * @var string Tab's ID
     */
    public $tab_id;
    
    /**
     * @var array Tab's data (target, label, class)
     */
    public $tab_data;
    
    /**
     * @var array Product type meta fields
     */
    public $meta_fields;

    /**
     * Build the instance
     * 
     */
    public function __construct( $data ) {
      
      $this->type = $data['type'];
      $this->type_title = $data['type_title'];
      $this->tab_id = $data['tab_id'];
      $this->tab_data = $data['tab_data'];
      $this->meta_fields = $data['meta_fields'];
    	
    	//Add product type to selector dropdown
        add_filter( 'product_type_selector', [ $this, 'addToSelector'] );
        
        //Add tab to tabs sidebar   
        add_filter( 'woocommerce_product_data_tabs', [ $this, 'typeTab'] );
        
        //Add tab's panel
        add_action( 'woocommerce_product_data_panels', [ $this, 'tabPanel'] );
        
        //Save meta data
        add_action( 'woocommerce_process_product_meta', [ $this, 'save'] );
        
        add_action( 'woocommerce_product_options_general_product_data', function(){
            echo '<div class="options_group show_if_'.$this->type.' clear"></div>';
        } );
        
        add_action( 'admin_footer', array( $this, 'enable_js_on_wc_product' ) );
    }
    
    /**
         * Add product type to selector dropdown
         * @param  array $types 
         * @return array
         */
        public function addToSelector( $types ){
            $types[ $this->type ] = $this->type_title;

            return $types;  
        }
            
        /**
         * Add tab to tabs sidebar
         * @param  array $tabs 
         * @return array
         */
        public function typeTab( $tabs) {
        
            $tabs[$this->tab_id] = $this->tab_data;
            
            return $tabs;
        }
        
        /**
         * Add tab's panel
         * @return void
         */
        public function tabPanel(){?>
            <div id='<?= $this->tab_data["target"] ?>' class='panel woocommerce_options_panel'>
                <div class='options_group'>
                    <?php
                       
                      foreach ($this->meta_fields as $field => $data) {
                        
                        
                          woocommerce_wp_text_input( $data );
                        }  
                        
                    ?>
                    
                </div>
            </div>
        <?php }
        
        /**
         * Update meta key
         * @param string $key 
         * @return void
         */
        public function update($key){
            
            if( !empty( $_POST[$key] ) ) 
                    update_post_meta( $post_id, $key, esc_attr( wp_strip_all_tags( $_POST[$key] ) ) );
        }
        
        /**
         * Save meta values
         * @return void
         */
        public function save(){
          
          $meta_keys = array_keys($this->meta_fields);
        
            foreach ($meta_keys as $key) {
                $this->update($key);
            }
            
        }
        
        public function enable_js_on_wc_product() {
          global $post, $product_object;
    
          if ( ! $post ) return; 
    
          if ( 'product' != $post->post_type )  return;
    
          $is_type = $product_object && $this->type === $product_object->get_type() ? true : false;
    
          ?>
          <script type='text/javascript'>
            jQuery(document).ready(function () {
              //for Price tab
              jQuery('#general_product_data .pricing').addClass('show_if_<?= $this->type ?>');
    
              <?php if ( $is_type ) { ?>
                jQuery('#general_product_data .pricing').show();
              <?php } ?>
             });
           </script>
           <?php
         }


}
