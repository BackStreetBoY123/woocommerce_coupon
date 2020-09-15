<?php
//create coupon of amount 100rs and limit 1, fixed product 

$coupon_code = 'FIX100'; // Code
$amount = '100'; // Amount
$discount_type = 'fixed_cart'; 
// Type: fixed_cart, percent, fixed_product, percent_product

// set the coupon title, 
$coupon = array(
'post_title' => $coupon_code,
'post_content' => '',
'post_status' => 'publish',
'post_author' => 1,
'post_type' => 'shop_coupon');

$new_coupon_id = wp_insert_post( $coupon );

// Add meta information in woocommerce/coupon 
update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
update_post_meta( $new_coupon_id, 'individual_use', 'no' );
update_post_meta( $new_coupon_id, 'product_ids', 141 );
update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
update_post_meta( $new_coupon_id, 'usage_limit', '1' );
update_post_meta( $new_coupon_id, 'expiry_date', '2020-10-12' );
update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
update_post_meta( $new_coupon_id, 'free_shipping', 'no' );


add_action( 'woocommerce_before_cart', 'matched_coupons' );
 // before checkout match the coupon
function matched_coupons() {
  
    $coupon_code = 'FIX100'; 
  
    if ( WC()->cart->has_discount( $coupon_code ) ) return;
  
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
  
    // this is your product ID
    $autocoupon = array( 141 );
  
    if ( in_array( $cart_item['product_id'], $autocoupon ) ) {   
        WC()->cart->apply_coupon( $coupon_code );
        wc_print_notices();
    }
  
    }
  
}

?>