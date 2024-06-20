<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Account_Tab {

    public function __construct() {
        add_filter( 'woocommerce_account_menu_items', array( $this, 'add_prizes_tab' ) );
        add_action( 'woocommerce_account_prizes_endpoint', array( $this, 'prizes_content' ) );
    }

    public function add_prizes_tab( $items ) {
        $items['prizes'] = __( 'My Prizes', 'hb-woocommerce-prize' );
        return $items;
    }

    public function prizes_content() {
        $user_id = get_current_user_id();
        $claimed_prizes = get_posts( array(
            'post_type' => 'prize',
            'meta_key' => '_claimed_by',
            'meta_value' => $user_id,
            'meta_compare' => 'LIKE'
        ) );

        if ( $claimed_prizes ) {
            echo '<table>';
            echo '<tr><th>' . __( 'Prize', 'hb-woocommerce-prize' ) . '</th><th>' . __( 'Score Needed', 'hb-woocommerce-prize' ) . '</th></tr>';
            foreach ( $claimed_prizes as $prize ) {
                echo '<tr>';
                echo '<td>' . get_the_title( $prize->ID ) . '</td>';
                echo '<td>' . get_post_meta( $prize->ID, '_prize_score', true ) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>' . __( 'You have not claimed any prizes yet.', 'hb-woocommerce-prize' ) . '</p>';
        }
    }
}