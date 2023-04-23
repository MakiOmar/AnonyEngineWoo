<?php
if ( !defined('ABSPATH') ) exit();

class WC_Product_ANOWOO_OPTIC_TAB {
	
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
                'size_price',
                'base-curve',
                'diameter',
                'eye_power',
                'eye_cylinder',
                'eye_ipd',
                'eye_axis',
                'eye_add',
                'package_size_price',
                'lens_variaions'
            ];
    
    	
    	//Add product type to selector dropdown
        add_filter( 'product_type_selector', [ $this, 'addToSelector'] );
        
        //Add tab to tabs sidebar   
        add_filter( 'woocommerce_product_data_tabs', [ $this, 'typeTab'] );
        
        //Add tab's panel
        add_action( 'woocommerce_product_data_panels', [ $this, 'tabPanel'] );
        
        //Save meta data
        add_action( 'woocommerce_process_product_meta', [ $this, 'save'] );
        
    }
    
    /**
         * Add product type to selector dropdown
         * @param  array $types 
         * @return array
         */
        public function addToSelector( $types ){
            $types[ 'anowoo_optic' ] = __( 'Optic', ANOWOO_TEXTDOM );

            return $types;  
        }
            
        /**
         * Add tab to tabs sidebar
         * @param  array $tabs 
         * @return array
         */
        public function typeTab( $tabs) {
        
            $tabs['optic'] = array(
              'label'    => __( 'Optical settings', ANOWOO_TEXTDOM ),
              'target' => 'optical_settings',
              'class'  => 'show_if_bbPress hide_if_anowoo_book hide_if_simple hide_if_variable hide_if_grouped hide_if_external',
             );
            return $tabs;
        }
        
        /**
         * Add tab's panel
         * @return void
         */
        public function tabPanel(){
            
        ?>
        <style>
            .woocommerce_options_panel .color-name p.form-field{
                padding: 0 10px !important;
                margin: 0;
            }
        </style>
            <div id='optical_settings' class='panel woocommerce_options_panel'>
                <div class='options_group'>
                    <?php
                    /*
                           $currency = get_woocommerce_currency_symbol();
                           $reg_price =  array(
                              'id' => '_regular_price',
                              'label' => sprintf(__( 'Regular price (%s)', 'wcpt' ), $currency),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => sprintf(__( 'Regular price (%s)', 'wcpt' ), $currency),
                              'type' => 'text'
                            ); 
                            
                            $sale_price = array(
                              'id' => '_sale_price',
                              'label' => sprintf(__( 'Sale price (%s)', 'wcpt' ), $currency),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => sprintf(__( 'Sale price (%s)', 'wcpt' ), $currency),
                              'type' => 'text'
                            );
                        woocommerce_wp_text_input($reg_price);
                        
                        woocommerce_wp_text_input($sale_price);
*/
                        woocommerce_wp_text_input(
                            array(
                              'id' => 'size_price',
                              'label' => __( 'Price per size', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Applicable for all sizes', 'wcpt' ),
                              'type' => 'text',
                              'style' => "direction:ltr;text-align:left",
                            )
                        );
                        
                        woocommerce_wp_textarea_input(
                            array(
                              'id' => 'base-curve',
                              'label' => __( 'Base curve', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Add one base curve per line', 'wcpt' ),
                              'rows' => 30,
                              'columns' => 50,
                              'style' => "direction:ltr;text-align:left",
 
                            )
                        );

                        
                        woocommerce_wp_textarea_input(
                            array(
                              'id' => 'diameter',
                              'label' => __( 'Diameter', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Add one diameter per line', 'wcpt' ),
                              'rows' => 30,
                              'columns' => 50,
                              'style' => "direction:ltr;text-align:left",
 
                            )
                        );

                        woocommerce_wp_textarea_input(
                            array(
                              'id' => 'eye_power',
                              'label' => __( 'Power', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Add one power per line', 'wcpt' ),
                              'rows' => 30,
                              'columns' => 50,
                              'style' => "direction:ltr;text-align:left",
 
                            )
                        );

                        woocommerce_wp_textarea_input(
                            array(
                              'id' => 'eye_cylinder',
                              'label' => __( 'Cylinder', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Add one cylinder per line', 'wcpt' ),
                             
                              'rows' => 30,
                              'columns' => 50,
                              'style' => "direction:ltr;text-align:left",
 
                            )
                        );
                        
                        woocommerce_wp_textarea_input(
                            array(
                              'id' => 'eye_ipd',
                              'label' => __( 'IPD', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Add one IPD per line', 'wcpt' ),
                              'rows' => 30,
                              'columns' => 50,
                              'style' => "direction:ltr;text-align:left",
 
                            )
                        );

                        woocommerce_wp_textarea_input(
                            array(
                              'id' => 'eye_axis',
                              'label' => __( 'Axis', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Add one axis per line', 'wcpt' ),
                              'rows' => 30,
                              'columns' => 50,
                              'style' => "direction:ltr;text-align:left",
 
                            )
                        );
                        
                        woocommerce_wp_textarea_input(
                            array(
                              'id' => 'eye_add',
                              'label' => __( 'ADD', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Add one ADD per line', 'wcpt' ),
                              'rows' => 30,
                              'columns' => 50,
                              'style' => "direction:ltr;text-align:left",
 
                            )
                        );
                        woocommerce_wp_textarea_input(
                            array(
                              'id' => 'package_size',
                              'label' => __( 'Package size', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true',
                              'description' => __( 'Add one package_size per line', 'wcpt' ),
                              'rows' => 30,
                              'columns' => 50,
                              'style' => "direction:ltr;text-align:left",
                              
 
                            )
                        );
                        
                        woocommerce_wp_text_input(
                            array(
                              'id' => 'package_size_price',
                              'label' => __( 'Package price', 'wcpt' ),
                              'style' => "direction:ltr;text-align:left",
                            )
                        );
                        
                        ?>
                        <div style="display: flex;margin: 30px 10px;">
                            <div style="width:33.33%;display: flex;">
                                <input style="width:80px;" type="text" class="lens-thumb-selector-field" name="lens-thumb-selector-field" id="lens-thumb-selector-field" data-url="lens-thumb-url-field" value="">
                                <input type="button" class="button lens-thumb-selector-button" value="Upload thumb">
                            </div>
                            
                            <div style="width:33.33%;display: flex;">
                                <input style="width:80px;" type="text" class="lens-preview-selector-field" name="lens-preview-selector-field" id="lens-preview-selector-field" data-url="lens-preview-url-field" value="">
                                <input type="button" class="button lens-preview-selector-button" value="Upload preview">
                            </div>
                            <div class="color-name" style="width:33.33%;display: flex;">
                                <?php
                                    woocommerce_wp_text_input(
                                        array(
                                          'id' => 'eye_color',
                                          'label' => false,
                                          'placeholder' => __( 'Color name', 'wcpt' ),
                                          'style' => 'width: 100%'
                                    
                                        )
                                    );
                                ?>
                            </div>
                            <a href="#" id="add-lens-variations" class="button">Add</a>
                            
                        </div>
                        
                        <div>
                                <input type="text" style="display:none" class="lens-thumb-url-field" name="lens-thumb-url-field" id="lens-thumb-url-field" value="">
   
                                <input type="text" style="display:none" class="lens-preview-url-field" name="lens-preview-url-field" id="lens-preview-url-field" value="">
                              
                        </div>
                        
                        
                        
                        <div id="images-container"></div>
                        
                        <?php
                        
                        woocommerce_wp_text_input(
                            array(
                              'id' => 'lens_variaions',
                              'label' => __( 'lens variaions', 'wcpt' ),
                              'placeholder' => '',
                              'desc_tip' => 'true'/*,
                              'description' => __( 'Add one varation per line like thumb_id|preview_id|color_name', 'wcpt' ),
                              'rows' => 30,
                              'columns' => 50,
                              'style' => "direction:ltr;text-align:left",
                              'custom_attributes' => ['autocomplete' => 'off', 'readonly'=>true],*/
                              
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
        public function update($key, $post_id){
            
            if( !empty( $_POST[$key] ) ) 
                    update_post_meta( $post_id, $key,  wp_strip_all_tags( $_POST[$key] )  );
        }
        
        
        public function save($post_id){
            
                        
            foreach ($this->meta as $key) {
                $this->update($key, $post_id);
            }
        
           
            
        }


}

// enqueue the necessary scripts and styles
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_media();
 
});

add_action('admin_footer', function () {?>
    <script>	
    	jQuery(document).ready(function($){
    	    $('#lens_variaions').hide();
    	    $.fn.lensAtchments = function(object){
    	        var mediaUploader;
    	        // if the media uploader already exists, open it
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
        
                // create the media uploader
                mediaUploader = wp.media({
                    title: 'Select Media',
                    button: {
                        text: 'Choose Media'
                    },
                    multiple: false
                });
        
                // handle media selection
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#' + object.data('url')).val(attachment.url);
                    object.val(attachment.id);
                });
        
                // open the media uploader
                mediaUploader.open();
    	    }
            
        
            $('.lens-thumb-selector-button').click(function(e) {
                e.preventDefault();
                $.fn.lensAtchments($('#lens-thumb-selector-field'));
                
            });            
            
            $('.lens-preview-selector-button').click(function(e) {
                e.preventDefault();
                $.fn.lensAtchments($('#lens-preview-selector-field'));
                
            });
        
            // Event listener for the delete button
            function onDeleteButtonClicked(event) {
                event.preventDefault();
                const deleteId = $(this).data("id");
                
                // Remove the image and delete button from the container
                const imageElement = $(this).prev();
                $(this).remove();
                imageElement.remove();
                
                const jsonString = $('#lens_variaions').val();
                if( jsonString == '' ){
                    return;
                }
                const imagesObject = JSON.parse(jsonString);
                // Remove the item from the object
                delete imagesObject[deleteId];
                
                if( JSON.stringify(imagesObject) == '{}' ){
                    $('#lens_variaions').val('');
                }else{
                    $('#lens_variaions').val(JSON.stringify(imagesObject));
                }
                
                
            }
            
            $.fn.renderThumbs = function(){
                const jsonString = $('#lens_variaions').val();
                if( jsonString == '' ){
                    return;
                }
                const imagesObject = JSON.parse(jsonString);

                // Get a reference to the images container
                const imagesContainer = $("#images-container");
                imagesContainer.html('');
                // Loop through the object and generate the images and delete buttons
                for (const key in imagesObject) {
                  const imageSrc = imagesObject[key][0];
                  const deleteId = key;
            
                  // Create the image element
                  const imageElement = $("<img>").attr("src", imageSrc);
            
                  // Create the delete button and set its data-id attribute
                  const deleteButton = $("<button>").text("x").attr("data-id", deleteId);
                  
                  // Create a container div and append the image and delete button to it
                    const container = $("<div>").append(imageElement, deleteButton);
            
                  // Append the image and delete button to the container
                  imagesContainer.append(container);
            
                  // Add an event listener to the delete button
                  deleteButton.on("click", onDeleteButtonClicked);
                }
            }
            
            $.fn.renderThumbs();
            
            $('#add-lens-variations').click(function(e) {
                e.preventDefault();

                var thumb   = $('#lens-thumb-selector-field').val();
                var preview = $('#lens-preview-selector-field').val();
                var color   = $('#eye_color').val();
                var thumbUrl   = $('#lens-thumb-url-field').val();
                var previewUrl   = $('#lens-preview-url-field').val();
                
                if( thumb !== '' && preview !== '' && color !== '' && thumbUrl !== ''&& previewUrl !== '' ){
                    var variation = thumb + '|' + preview + '|' + color;
                    
                    // Get the input elements
                    const thumbInput = $('#lens-thumb-selector-field');
                    const previewInput = $('#lens-preview-selector-field');
                    const eyeColorInput = $('#eye_color');
                    const previewUrlInput = $('#lens-preview-url-field');
                    const thumbUrlInput = $('#lens-thumb-url-field');
                    
                    // Create an empty object to store the final result
                    const resultObj = {};
                    
                    // Loop through the thumb input values and add each as a key to the result object
                    thumbInput.each((index, element) => {
                      // Get the values of the other inputs for the current thumb input
                      const previewValue = $(previewInput[index]).val();
                      const eyeColorValue = $(eyeColorInput[index]).val();
                      const previewURLValue = $(previewUrlInput[index]).val();
                      const thumbURLValue = $(thumbUrlInput[index]).val();
                      
                      // Create an array of the other input values for the current thumb input
                      const otherValues = [thumbURLValue, previewURLValue, previewValue,  eyeColorValue];
                      
                      // Add the current thumb input value as a key to the result object with its value being the otherValues array
                      resultObj[$(element).val()] = otherValues;
                    });
                    
                    // Convert the result object to a JSON string
                    const resultJson = JSON.stringify(resultObj);
                    
                    // Get the lens variations textarea element
                    const variationsInput = $('#lens_variaions');
                    
                    // If the lens variations textarea is empty, set its value to the result JSON string
                    if (variationsInput.val().trim() === '') {
                      variationsInput.val(resultJson);
                    } else {
                      // If the lens variations textarea is not empty, parse its value as JSON and append the result object to it
                      const existingJson = variationsInput.val().trim();
                      const existingObj = JSON.parse(existingJson);
                      
                      // Merge the existing object with the new result object using the spread operator
                      const mergedObj = { ...existingObj, ...resultObj };
                      
                      // Convert the merged object to a JSON string and set the lens variations textarea value to the new JSON string
                      const mergedJson = JSON.stringify(mergedObj);
                      variationsInput.val(mergedJson);
                    }
                    
                    /*
                    if( $('#lens_variaions').val() === '' ){
                        $('#lens_variaions').val(variation);
                    }else{
                        $('#lens_variaions').val($('#lens_variaions').val() + '\n' + variation);
                    }
                    */
                    $('#lens-thumb-selector-field').val('');
                    $('#lens-preview-selector-field').val('');
                    $('#eye_color').val('');
                    $('#lens-preview-url-field').val('');
                    $('#lens-thumb-url-field').val('');
                    
                    
                    $.fn.renderThumbs();
                
                    
                }
                
            });
        });
    </script>
 
<?php });


add_action('admin_head', function(){?>
    <style>
        .lens_variaions_field{
            display:none;
        }
        
        #images-container{
            display:flex;
        }
        
        #images-container div {
            position: relative;
            padding:10px;
        }
        
        #images-container div button{
            background-color: red;
            border: none;
            color: white;
            font-weight: bold;
            height: 22px;
            width: 22px;
            border-radius: 50%;
            line-height: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 10px;
            cursor: pointer;
        }
        #images-container div img{
            width: 65px;
        }
    </style>
<?php });


//add_action( 'woocommerce_process_product_meta', 'my_save_product_data' );
function my_save_product_data( $post_id ) {
    $optics_inputs = [
        'size_price',
        'eye_power',
        'eye_cylinder',
        'eye_ipd',
        'eye_axis',
        'eye_add',
        'package_size',
        'lens_variaions'
    ];
    
    foreach( $optics_inputs as $key ){
        update_post_meta( $post_id, $key, $_POST[$key] );
    }
    
    
}


