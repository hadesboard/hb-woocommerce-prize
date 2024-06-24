<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HBWC_Free_Shipping {

    public function __construct() {
        // Hook to apply the free shipping discount
        add_action( 'woocommerce_cart_calculate_fees', array( $this, 'apply_free_shipping_discount' ) );
        // Add custom checkbox to checkout
        add_action( 'woocommerce_review_order_before_payment', array( $this, 'add_free_shipping_checkbox' ) );
        // Save checkbox state
        add_action( 'woocommerce_checkout_update_order_review', array( $this, 'save_free_shipping_checkbox' ) );
        // Add JavaScript to handle checkbox interaction
        add_action( 'wp_footer', array( $this, 'add_free_shipping_script' ) );
        // Reduce user score after order is processed
        add_action( 'woocommerce_thankyou', array( $this, 'reduce_user_score' ) );
    }

    /**
     * Apply a discount equal to the shipping cost.
     *
     * @param WC_Cart $cart The WooCommerce cart object.
     */
    public function apply_free_shipping_discount( $cart ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            return;
        }

        // Get the current user ID and score
        $user_id = get_current_user_id();
        $user_score = get_user_meta( $user_id, 'user_score', true );
        $enabled = get_option( 'hbwc_free_shipping_enabled', 'no' );
        $threshold = get_option( 'hbwc_free_shipping_score_threshold', 100 );

        // Check if the free shipping option is enabled and the user score is above the threshold
        if ( $enabled === 'yes' && $user_score >= $threshold && WC()->session->get( 'hbwc_free_shipping' ) ) {
            // Get the shipping cost
            $shipping_total = $cart->get_shipping_total();

            // If there's a shipping cost, apply a discount
            if ( $shipping_total > 0 ) {
                // Add a negative fee to offset the shipping cost
                $cart->add_fee( __('Free Shipping Discount', 'hb-woocommerce-prize'), -$shipping_total );

            }
        }
    }

    /**
     * Add a custom checkbox to the checkout form.
     */
    public function add_free_shipping_checkbox() {
        // Get the current user ID and score
        $user_id = get_current_user_id();
        $user_score = get_user_meta( $user_id, 'user_score', true );
        $enabled = get_option( 'hbwc_free_shipping_enabled', 'no' );
        $threshold = get_option( 'hbwc_free_shipping_score_threshold', 100 );
        $free_shipping_label = sprintf(__('Enable free shipping for %s score', 'hb-woocommerce-prize'), $threshold);

        // Only display the checkbox if the free shipping option is enabled and the user score is above the threshold
        if ($enabled === 'yes' && $user_score >= $threshold) {
            ?>
            <div id="hbwc-free-shipping-checkbox" class="shipping-checkbox">
                <h3><?php echo esc_html(__('Free Shipping', 'hb-woocommerce-prize')); ?></h3>
                <p>
                    <input type="checkbox" id="hbwc_free_shipping" name="hbwc_free_shipping">
                    <label for="hbwc_free_shipping"><?php echo esc_html($free_shipping_label); ?></label>
                </p>
            </div>
            <?php
        }
    }

    /**
     * Save the state of the free shipping checkbox.
     *
     * @param string $posted_data The posted data from the checkout form.
     */
    public function save_free_shipping_checkbox( $posted_data ) {
        parse_str( $posted_data, $output );
        if ( isset( $output['hbwc_free_shipping'] ) ) {
            WC()->session->set( 'hbwc_free_shipping', true );
        } else {
            WC()->session->set( 'hbwc_free_shipping', false );
        }
    }

    /**
     * Add JavaScript to handle the checkbox interaction.
     */
    public function add_free_shipping_script() {
        if ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) {
            ?>
            <script type="text/javascript">
                jQuery(function($) {
                    $('#hbwc_free_shipping').change(function() {
                        $('body').trigger('update_checkout');
                    });
                });
            </script>
            <?php
        }
    }

    /**
     * Reduce the user score by the threshold amount after order completion.
     *
     * @param int $order_id The order ID.
     */
    public function reduce_user_score( $order_id ) {
        // Get the order
        $order = wc_get_order( $order_id );
        $user_id = $order->get_user_id();
        $enabled = get_option( 'hbwc_free_shipping_enabled', 'no' );
        $threshold = get_option( 'hbwc_free_shipping_score_threshold', 100 );

        // Check if the free shipping option was used
        if ( $enabled === 'yes' && WC()->session->get( 'hbwc_free_shipping' ) ) {
            // Get the current user score
            $user_score = get_user_meta( $user_id, 'user_score', true );

            // Reduce the user score by the threshold amount
            $new_score = max( 0, $user_score - $threshold );
            update_user_meta( $user_id, 'user_score', $new_score );

            // Clear the session flag
            WC()->session->__unset( 'hbwc_free_shipping' );
        }
    }
}
