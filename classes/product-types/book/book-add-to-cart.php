<?php
/**
 * book product template
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

do_action( 'anowoo_book_before_add_to_cart_form' );  ?>

<form class="anowoo_book_cart" method="post" enctype='multipart/form-data'>

	<table cellspacing="0">
		<tbody>
			<tr>
				<td >
					<label for="anowoo_book_amount"><?php echo __( "Amount", 'wcpt' ); ?></label>
				</td>
				<td class="price">
					<?php $get_price = get_post_meta ( $product->get_id(), '_regular_price' );
					$price = 0;
					if ( isset( $get_price[0] ) ) {
						$price =  wc_price( $get_price[0] ) ;
					}
					echo $price;
					 ?>
				</td>
			</tr>
		</tbody>
	</table>
	<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
</form>

<?php do_action( 'anowoo_book_after_add_to_cart_form' ); ?>