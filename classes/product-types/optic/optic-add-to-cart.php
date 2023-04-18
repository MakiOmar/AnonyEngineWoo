<?php
/**
 * Optic product template
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

do_action( 'anowoo_optic_before_add_to_cart_form' );


define('OPTICS_GETTEXT', serialize( array(
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
$optics_text = unserialize( OPTICS_GETTEXT );
$optics_inputs = [
    'size_price',
    'base-curve',
    'diameter',
    'eye_power',
    'eye_cylinder',
    'eye_ipd',
    'eye_axis',
    'eye_add',
    'package_size',
    'lens_variaions'
];

$optics_inputs_values = array();
foreach( $optics_inputs as $key ){
    $optics_inputs_values[$key] = get_post_meta($product->get_id(),$key, true );
}



?>


<style type="text/css">
	
	.anowoo_optic_cart{

	}
	#optics-options{
		color: #999 !important;
		table-layout: fixed;
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		margin-top: 0;
		background:#f7f5f0
	}
	#optics-options tbody {
		line-height: 20px;
	}

	#optics-options thead > tr > th, #optics-options > tbody > tr > td, #optics-options > tr > th, #optics-options > tr > td {
        padding: 5px;
        border: 1px solid #dddddd;
        text-align: initial;
	}
	
	input.qty{
	    opacity: 0;
        visibility: hidden;
        position: absolute;
        z-index: -1;
	}

	#optics-options input[type="checkbox"], #optics-options input[type="radio"] {
		vertical-align: middle;
		width: 14px;
		height: 14px;
		margin-top: -2px;
	}
	#optics-options .eye_option{
		width: 100%;
		background-color: #fff;
		border: 1px solid #dddddd;
		padding: 5px;
	}
	#optics-options .eye_option.disabled{
		background-color:#dddddd
	}
	#optics-options select.required{
		border:  1px solid  #d02222;
	}
	#optics-options .add-to-cart-wrapper{
	    display:flex;
	    align-items:center;
	}
	.errormsg{
		color:  red;
		font-weight: bold;
	}
	#anowoo_optic_cart .toggle-switch{
	    min-width: 100%;
	    margin-bottom: 30px;
	}
	#anowoo_optic_cart .toggle-switch__tongue {
    	width: 50%;
    
    }
    #anowoo_optic_cart .toggle-switch--on > .toggle-switch__tongue {
	    left: 50%;
    	margin-left: auto;
    }
    #anowoo_optic_cart .toggle-switch--off > .toggle-switch__tongue {
    	left: 0;
    	
    }
    #anowoo_optic_cart .toggle-switch:after, #anowoo_optic_cart .toggle-switch:before{
        display:block;
        position: absolute;
        top: 0;
        text-transform: uppercase;
        font-size: 12px;
        line-height: 34px;
        font-weight: 400;
        width: 50%;
        height: 34px;
        border-radius: 34px;
        border: 1px solid #ccc;
        margin: -1px -1px 0 -1px;
        text-align: center;
        color: #000;
        text-shadow: 0 0 1px #fff;
    }
     #anowoo_optic_cart .toggle-switch.toggle-switch--off:before{
         display:none
     }
     #anowoo_optic_cart .toggle-switch.toggle-switch--on:after{
         display:none
     }
    #anowoo_optic_cart .toggle-switch:before{
        content:'<?php echo $optics_text['accessory'] ?>';
        left:0;

    }   
    
    #anowoo_optic_cart .toggle-switch:after{
        content:'<?php echo $optics_text['prescription'] ?>';
        right:0;
    }
    input[name=with-power]{
    	display: none!important;
    }
</style>
<?php

    $jsonString = get_post_meta($product->get_id(), 'lens_variaions', true);
    $html = '';
    if( !empty( $jsonString ) ){
        $data = json_decode($jsonString, true);
        if( $data && is_array($data) ){
            $html = '<style>
                .lens-thumbnail {
                    display: inline-flex;
                    width: 70px;
                    height: 70px;
                    margin-right: 10px;
                    justify-content: center;
                    align-items: center;
                    cursor: pointer;
                    padding:4px
                }
                #lens-thumbnails-container{
                    margin: 10px 0;
                }
                .lens-thumbnail.active-lens {
                  border: 2px solid #4CAF50;
                  border-radius: 50%;
                }#color-name{display:none}</style>';
            $html .= '<p id="selected-preview"></p><input type="text" id="color-name" name="lens_color_name" value="" readonly><div id="lens-thumbnails-container">';
            foreach ($data as $id => $item) {
            $thumbnailUrl = $item[0];
            $previewUrl = $item[1];
            $previewId = $item[2];
            $colorName = $item[3];
            
            $html .= '<div class="lens-thumbnail" data-preview-url="' . htmlspecialchars($previewUrl) . '" data-color-name="' . htmlspecialchars($colorName) . '">';
            $html .= '<img src="' . htmlspecialchars($thumbnailUrl) . '" alt="Thumbnail ' . htmlspecialchars($id) . '">';
            $html .= '</div>';
            
            
            }
            $html .= '</div>';            
        }
    }

?>
<form id="anowoo_optic_cart" class="anowoo_optic_cart" method="post" enctype='multipart/form-data' autocomplete="off">
	<?php echo $html; ?>
    <input type="checkbox" name="with-power">
	<table id="optics-options" cellspacing="0">
		<tbody>
			<tr>
				<td >
					<label><?php echo $optics_text['eye']; ?></label>
				</td>
				<td>
					<input type="checkbox" class="which-eye" data-target="eye-right-side" name='which-eye[]' value='right'> <?php echo $optics_text['right']; ?>
				</td>

				<td>
					<input type="checkbox" class="which-eye" data-target="eye-right-side" name='which-eye[]' value='left'> <?php echo $optics_text['left']; ?>
				</td>
			</tr>

            <?php if(!empty( $optics_inputs_values['base-curve'] ) ) { ?>
			<tr>
				<td>
					<label><?php echo $optics_text['base-curve']; ?></label>
				</td>
				<td class="eye-right-side">
					<?php wcpt_render_select( $product->get_id(), 'base-curve', '_right' ) ?>
				</td>

				<td class="eye-left-side">
					<?php wcpt_render_select( $product->get_id(), 'base-curve', '_left' ) ?>
				</td>
			</tr>
			<?php } ;?>


            <?php if(!empty( $optics_inputs_values['diameter'] ) ) { ?>
			<tr>
				<td>
					<label><?php echo $optics_text['diameter']; ?></label>
				</td>
				<td class="eye-right-side">
					<?php wcpt_render_select( $product->get_id(), 'diameter', '_right' ) ?>
				</td>

				<td class="eye-left-side">
					<?php wcpt_render_select( $product->get_id(), 'diameter', '_left' ) ?>
				</td>
			</tr>
			<?php } ;?>


            <?php if(!empty( $optics_inputs_values['eye_power'] ) ) { ?>
			<tr class="with-power">
				<td>
					<label><?php echo $optics_text['eye_power']; ?></label>
				</td>
				<td class="eye-right-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_power', '_right' ) ?>
				</td>

				<td class="eye-left-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_power', '_left' ) ?>
				</td>
			</tr>
			<?php } ;?>

			<?php if(!empty( $optics_inputs_values['eye_cylinder'] ) ) { ?>
			<tr class="with-power">
				<td>
					<label><?php echo $optics_text['eye_cylinder']; ?></label>
				</td>
				<td class="eye-right-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_cylinder' , '_right') ?>
				</td>

				<td class="eye-left-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_cylinder' , '_left') ?>
				</td>
			</tr>
			<?php } ;?>			
			

			<?php if(!empty( $optics_inputs_values['eye_axis'] ) ) { ?>
			<tr class="with-power">
				<td>
					<label><?php echo $optics_text['eye_axis']; ?></label>
				</td>
				<td class="eye-right-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_axis', '_right' ) ?>
				</td>

				<td class="eye-left-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_axis', '_left' ) ?>
				</td>
			</tr>
			<?php } ;?>
			
			<?php if(!empty( $optics_inputs_values['eye_add'] ) ) { ?>
			<tr class="with-power">
				<td>
					<label><?php echo $optics_text['eye_add']; ?></label>
				</td>
				<td class="eye-right-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_add', '_right' ) ?>
				</td>

				<td class="eye-left-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_add', '_left' ) ?>
				</td>
			</tr>
			<?php } ;?>
			
			<?php if(!empty( $optics_inputs_values['eye_ipd'] ) ) { ?>
			<tr class="with-power">
				<td>
					<label><?php echo $optics_text['eye_ipd']; ?></label>
				</td>
				<td class="eye-right-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_ipd' , '_right') ?>
				</td>

				<td class="eye-left-side">
					<?php wcpt_render_select( $product->get_id(), 'eye_ipd' , '_left') ?>
				</td>
			</tr>
			<?php } ;?>
			<tr>
				<td>
					<label><?php echo $optics_text['quantity']; ?></label>
				</td>
				<td class="eye-right-quantity">
					<input class="eye_option eye_quantity_option eye_right" type="number" name="eye-right-quantity" min="1" value="1"/>
				</td>

				<td class="eye-left-side">
					<input class="eye_option eye_quantity_option eye_left" type="number" name="eye-left-quantity" min="1" value="1"/>
				</td>
			</tr>
            <?php if(!empty( $optics_inputs_values['package_size'] ) ) { ?>
			<tr>
				<td>
					<label><?php echo $optics_text['package_size']; ?></label>
				</td>
				<td colspan="2">
					<?php wcpt_render_select( $product->get_id(), 'package_size' ) ?>
				</td>

				
			</tr>
			<?php } ;?>
		</tbody>
	</table>
	<?php
	
	
	
	    $size_price = get_post_meta( $product->get_id(), 'size_price', true );
	    if( !empty($size_price) ){
	    
	    ?>
	        
    	        <input type="hidden" class="size_price eye_option" name="size_price_right" data-target="eye_power_right" value="0"/>
    	        
    	        <input type="hidden" class="size_price eye_option" name="size_price_left" data-target="eye_power_left" value="0"/>
    	        
    	        <input type="hidden" id="size_price" class="eye_option" name="size_price" value="<?php echo esc_attr($size_price) ?>"/>
	       
	    <?php } ?>
	    
	    <input type="hidden" id="eyedeal"  name="eyedeal" value=""/>


	<p class="errormsg"></p>
	<?php //do_action('woocommerce_simple_add_to_cart'); ?>
	<div class="add-to-cart-wrapper">
        <input style="height: 35px; border:none;outline:none" type="number" step="1" min="1" max="" name="quantity" value="1" title="Quantity" class="input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric"  readonly>
    
    	<button style="height: 35px" type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
	</div>
</form>

<script type="text/javascript">
	
    var toggleSwitch = new ToggleSwitch('input[name="with-power"]', {
        onLabel: '<?php echo $optics_text['prescription'] ?>', // [string] - Label for `true` value of checkbox. 
        offLabel: '<?php echo $optics_text['accessory'] ?>' // [string] - Label for `false` value of checkbox. 
    });
	jQuery(document).ready( function($){
	    
	    $.fn.sizePrice = function(){
	        
		    var newPrice = 0;
			
			$( '.size_price' ).each(function(){
			    var target = $('#' + $(this).data('target'));
			    
			    if( !$(this).prop('disabled') && target.val() !== '' && target.val() !== '0.00' && target.val() !== '0'){
    			    $(this).val(parseInt( $('#size_price').val() ));
    			}else{
    			    $(this).val('0');
    			}
			});
			
		}
	    $.fn.calcQuantity = function(){
	        
		    var newQuantity = 0;
			
			$( '.eye_quantity_option' ).each(function(){
			    
			    if( !$(this).prop('disabled')){
    			    newQuantity += parseInt($(this).val());
    			}
			});
			
			$('input.qty').val( parseInt(newQuantity)  );
		}
		
		$.fn.sideDisabled = function(object){
			if( object.is(':checked') )
			{
			    
			    if( $('input[name="with-power"]').is(':checked') ){
			        $('.eye_' + object.val() ).removeClass('disabled');
				    $('.eye_' + object.val() ).attr( 'disabled', false );
				    $('.with-power').show();
			    }else{
			        $('.eye_' + object.val() + ':not(.base-curve, .diameter)' ).addClass('disabled');
				    $('.eye_' + object.val() + ':not(.base-curve, .diameter)' ).attr( 'disabled', true );
			        $('input.eye_' + object.val() ).removeClass('disabled');
				    $('input.eye_' + object.val() ).attr( 'disabled', false );
				    $('.with-power').hide();
			    }
			    
				
				$('.errormsg').text('');
			}else{
				$('.eye_' + object.val() + ':not(.base-curve, .diameter)' ).addClass('disabled');
				$('.eye_' + object.val() + ':not(.base-curve, .diameter)' ).attr( 'disabled', true );
                

			}
		}
		
		$.fn.calcTotal = function(){
		    
		    var productTotal = 0;
		    var packageSizPrice = 0;
		    var productPrice = parseInt($('#temp_product_price').val());

		    $(".which-eye").each(function() {
    			if( $(this).is(':checked') ){
    			   var checkedQuantity = parseInt($('input[name=eye-'+$(this).val()+'-quantity]').val());
    			   
    			   var sizePrice = parseInt($('input[name=size_price_' + $(this).val() + ']').val());
    		

    			   var selectedPackageSize = $('#package_size').find('option:selected');
            
                    if( selectedPackageSize.val() !== '' ){
                        // Get the price value from the data-price attribute
                        packageSizPrice = parseInt(selectedPackageSize.data('price'));
                		
                	
                    }
                    
                    console.log();
                    
                    productTotal += checkedQuantity * (productPrice + sizePrice + packageSizPrice);
    			   
    			}
    
    		});
    		
                		
    		if( productTotal == 0 )
    		{
    		    productTotal = productPrice;
    		}
    		
    		//$('.price').find( 'bdi' ).text(productTotal);
    		$('.price').each( function(){
    		    var currency = $(this).find( '.woocommerce-Price-currencySymbol' );
    		    if( currency[0] !== undefined ){
    		    	if( $(this).find('del').length > 0 ){
	    		        var ins = $(this).find('ins');
	    		        ins.find( 'bdi' ).html( productTotal +  currency[0].outerHTML );
	    		    }else{
	    		        $(this).find( 'bdi' ).html( productTotal +  currency[0].outerHTML );
	    		    }
    		    }
    		    
    		} );

    		$( '#eyedeal' ).val(productTotal);
    		//console.log(productTotal);
    		
    		
		}
		
        $(".which-eye").on('change', function() {
            
			$.fn.sideDisabled($(this));
			$.fn.calcQuantity();
			$.fn.sizePrice();
			
			$.fn.calcTotal();
			
		});
		
		
		$(".which-eye").each(function() {
			$.fn.sideDisabled($(this));
			

		});

		$('.eye_power').on('change', function(){
		    $.fn.sizePrice();
		    $.fn.calcTotal();
		});


		
		$(".eye_quantity_option").on('change', function() {

            $.fn.calcQuantity();
            $.fn.calcTotal();
			
		});
		
		$('#package_size').change(function() {
             $.fn.calcTotal();   
        });
			
		$('input[name="with-power"]').on('change', function(){
            $(".which-eye").each(function() {
    			$.fn.sideDisabled($(this));
    			
    		});
    		
    		$('.eye_option:not(.package_size)' ).prop('selectedIndex', 0).change();
    		$('.eye_option' ).removeClass('required');
        });
       
		$('tr input[type=checkbox][value=right]').prop('checked', true).change();
	
		$("#anowoo_optic_cart").submit(function(e){

		  var arr = [];

          $(".which-eye").each(function() {
				if( $(this).is(':checked') )
				{
					arr.push($(this).val());
				}
			});

          if (arr.length === 0 || !arr.length){
          	e.preventDefault();

          	$('.errormsg').text('Please select which eye');
          	
          }else{

          	$('.errormsg').text('');
          }

          $("#anowoo_optic_cart").find('.eye_option').each(function() {

				if( !$(this).prop('disabled') && ($(this).val() == '' || $(this).val() === undefined ))
				{
					e.preventDefault();

					$(this).addClass('required');

					
					$('.errormsg').text('Please complete required fields');
				}else{
					$(this).removeClass('required');
				}
			});

		});

		$("#anowoo_optic_cart").find('.eye_option').on('change',function() {
			if( !$(this).prop('disabled') && $(this).val() == '' || $(this).val() === undefined )
			{
				$(this).addClass('required');
			}else{
				$(this).removeClass('required');
			}
		});
	} );
</script>


<script>
    jQuery(document).ready(function($) {
        
        $('.lens-thumbnail').click(function() {
            var previewUrl = $(this).data('preview-url');
            var colorName = $(this).data('color-name');
            $('#preview-image').attr('src', previewUrl);

            $('#color-name').val(colorName);
            $('#selected-preview').text('Lens color: ' + colorName);
            
            // Remove active class from all thumbnails
            $('.lens-thumbnail').removeClass('active-lens');
        
            // Add active class to clicked thumbnail
            $(this).addClass('active-lens');
        });
        $('.lens-thumbnail:first').trigger('click');
    });
</script>
<?php do_action( 'anowoo_optic_after_add_to_cart_form' ); ?>

<?php add_action( 'wp_footer', function(){
    
    global $product;
    ?>
    <input type="hidden" id="temp_product_price"  name="temp_product_price" value="<?php echo esc_attr($product->get_price()) ?>"/>
    <?php
}); 