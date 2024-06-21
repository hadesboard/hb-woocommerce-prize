<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Account_Tab {

    public function __construct() {
        add_filter( 'woocommerce_account_menu_items', array( $this, 'reorder_tabs' ) );
        add_action( 'init', array( $this, 'add_prize_orders_endpoint' ) );
        add_action( 'woocommerce_account_prize-orders_endpoint', array( $this, 'prize_orders_content' ) );
    }

    public function reorder_tabs( $items ) {
        // Remove the existing 'prize-orders' item
        unset( $items['prize-orders'] );

        // Insert 'prize-orders' after 'orders'
        $new_items = array();

        foreach ( $items as $key => $value ) {
            $new_items[ $key ] = $value;

            if ( $key === 'orders' ) {
                $new_items['prize-orders'] = __( 'Prize Orders', 'hb-woocommerce-prize' );
            }
        }

        return $new_items;
    }

    public function add_prize_orders_endpoint() {
        add_rewrite_endpoint( 'prize-orders', EP_PAGES );
    }

    public function prize_orders_content() {
        $user_id = get_current_user_id();

        // Get the user's current score
        $user_score = get_user_meta( $user_id, 'user_score', true );

        echo '<h3>' . __( 'Your Current Score:', 'hb-woocommerce-prize' ) . ' ' . esc_html( $user_score ) . '</h3>';

        // Get the prize orders for the user
        $args = array(
            'post_type'   => 'prize-order',
            'post_status' => 'publish',
            'author'      => $user_id,
        );
        $prize_orders = new WP_Query( $args );

        if ( $prize_orders->have_posts() ) {
            echo '<table class="shop_table shop_table_responsive my_account_orders">';
            echo '<thead>';
            echo '<tr>';
            echo '<th class="order-number"><span class="nobr">' . __( 'Order', 'hb-woocommerce-prize' ) . '</span></th>';
            echo '<th class="order-prize"><span class="nobr">' . __( 'Prize', 'hb-woocommerce-prize' ) . '</span></th>';
            echo '<th class="order-date"><span class="nobr">' . __( 'Date', 'hb-woocommerce-prize' ) . '</span></th>';
            echo '<th class="order-status"><span class="nobr">' . __( 'Status', 'hb-woocommerce-prize' ) . '</span></th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ( $prize_orders->have_posts() ) {
                $prize_orders->the_post();
                $order_id = get_the_ID();
                $order_date = get_the_date();
                $order_status = get_post_meta( $order_id, '_prize_order_status', true );

                // Get the prize ID from post meta
                $prize_id = get_post_meta( $order_id, '_prize_id', true );
                // Get the prize name
                $prize_name = get_the_title( $prize_id );

                echo '<tr class="order">';
                echo '<td class="order-number" data-title="' . __( 'Order', 'hb-woocommerce-prize' ) . '">';
                echo '<a href="' . esc_url( get_permalink( $order_id ) ) . '">' . esc_html( $order_id ) . '</a>';
                echo '</td>';
                echo '<td class="order-prize" data-title="' . __( 'Prize', 'hb-woocommerce-prize' ) . '">';
                echo esc_html( $prize_name );
                echo '</td>';
                echo '<td class="order-date" data-title="' . __( 'Date', 'hb-woocommerce-prize' ) . '">';
                echo esc_html( $order_date );
                echo '</td>';
                echo '<td class="order-status" data-title="' . __( 'Status', 'hb-woocommerce-prize' ) . '">';
                echo esc_html( $order_status );
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            wp_reset_postdata();
        } else {
            echo '<p>' . __( 'You have no prize orders.', 'hb-woocommerce-prize' ) . '</p>';
        }
    }
}
?>
