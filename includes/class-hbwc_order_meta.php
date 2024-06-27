<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Order_Score {

    public function __construct() {
        add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'calculate_and_add_score_to_order_meta' ) );
        add_action( 'woocommerce_admin_order_data_after_billing_address', array( $this, 'display_score_in_admin_order_meta' ), 10, 1 );
        add_action( 'woocommerce_order_details_after_order_table', array( $this, 'display_score_in_customer_order_meta' ), 10, 1 );
    }

    // Calculate and add score to order meta
    public function calculate_and_add_score_to_order_meta( $order_id ) {
        $order = wc_get_order( $order_id );
        $total = $order->get_total();

        $conversion_rate = get_option( 'hbwc_conversion_rate', 1000000 );
        $points_per_rate = get_option( 'hbwc_points_per_rate', 10 );

        $score = intval( ( $total / $conversion_rate ) * $points_per_rate );
        
        update_post_meta( $order_id, '_user_earned_score', $score );
    }

    // Display score in admin order details
    public function display_score_in_admin_order_meta( $order ) {
        $score = get_post_meta( $order->get_id(), '_user_earned_score', true );
        if ( ! empty( $score ) ) {
            echo '<p><strong>' . __( 'User Earned Score', 'hb-woocommerce-prize' ) . ':</strong> ' . esc_html( $score ) . '</p>';
        }
    }

    // Display score in customer order details
    public function display_score_in_customer_order_meta( $order ) {
        $score = get_post_meta( $order->get_id(), '_user_earned_score', true );
        if ( ! empty( $score ) ) {
            echo '<p><strong>' . __( 'Your Earned Score', 'hb-woocommerce-prize' ) . ':</strong> ' . esc_html( $score ) . '</p>';
        }
    }
}

