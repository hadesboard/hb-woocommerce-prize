<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Order_Handler {

    public function __construct() {
        add_action( 'woocommerce_order_status_completed', array( $this, 'update_user_score' ) );
    }

    public function update_user_score( $order_id ) {
        $order = wc_get_order( $order_id );
        $user_id = $order->get_user_id();
        $total = $order->get_total();

        $conversion_rate = get_option( 'hbwc_conversion_rate', 1000000 );
        $points_per_rate = get_option( 'hbwc_points_per_rate', 10 );

        $score_to_add = floor( $total / $conversion_rate ) * $points_per_rate;

        $user_score = get_user_meta( $user_id, 'user_score', true );
        $new_score = $user_score + $score_to_add;

        update_user_meta( $user_id, 'user_score', $new_score );
    }
}