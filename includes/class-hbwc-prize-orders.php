<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Prize_Orders {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_prize_orders_page' ) );
    }

    public function add_prize_orders_page() {
        add_submenu_page(
            'edit.php?post_type=prize',
            __( 'Prize Orders', 'hb-woocommerce-prize' ),
            __( 'Prize Orders', 'hb-woocommerce-prize' ),
            'manage_options',
            'hbwc-prize-orders',
            array( $this, 'render_prize_orders_page' )
        );
    }

    public function render_prize_orders_page() {
        $claimed_prizes = get_posts( array(
            'post_type' => 'prize',
            'meta_key' => '_claimed_by',
            'meta_compare' => 'EXISTS'
        ) );

        echo '<div class="wrap">';
        echo '<h1>' . __( 'Prize Orders', 'hb-woocommerce-prize' ) . '</h1>';
        if ( $claimed_prizes ) {
            echo '<table>';
            echo '<tr><th>' . __( 'Prize', 'hb-woocommerce-prize' ) . '</th><th>' . __( 'User', 'hb-woocommerce-prize' ) . '</th><th>' . __( 'Date', 'hb-woocommerce-prize' ) . '</th></tr>';
            foreach ( $claimed_prizes as $prize ) {
                $user_id = get_post_meta( $prize->ID, '_claimed_by', true );
                $user = get_user_by( 'id', $user_id );
                echo '<tr>';
                echo '<td>' . get_the_title( $prize->ID ) . '</td>';
                echo '<td>' . $user->display_name . '</td>';
                echo '<td>' . get_the_date( '', $prize->ID ) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>' . __( 'No prize orders found.', 'hb-woocommerce-prize' ) . '</p>';
        }
        echo '</div>';
    }
}